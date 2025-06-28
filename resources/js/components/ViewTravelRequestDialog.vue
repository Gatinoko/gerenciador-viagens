<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { DateFormatter } from "@internationalized/date";
import { CalendarIcon } from "lucide-vue-next";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Calendar } from "@/components/ui/calendar";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { computed } from "vue";
import { translateStatus, translateAndFormatStatus } from "@/lib/utils";

const props = defineProps({
    travelRequestData: Object,
    travelRequestInfoDialogToggle: Boolean,
});
const emits = defineEmits(["update:travelRequestInfoDialogToggle"]);

// Computed value from parent ref
const travelRequestInfoDialogToggle = computed({
    get: () => props.travelRequestInfoDialogToggle,
    set: (v) => emits("update:travelRequestInfoDialogToggle", v),
});

// Date formatter for calendar
const dateFormatter = new DateFormatter("pt-BR", {
    dateStyle: "long",
    timeZone: "UTC",
});
</script>

<template>
    <Dialog v-model:open="travelRequestInfoDialogToggle">
        <DialogContent class="sm:max-w-[425px]">
            <!-- Dialog header -->
            <DialogHeader>
                <DialogTitle>Informaçoes Sobre Pedido de Viagem </DialogTitle>
                <DialogDescription>
                    Informações sobre o pedido de viagem de id
                    {{ travelRequestData.id }}, feito por
                    {{ travelRequestData.user.name }}.
                </DialogDescription>
            </DialogHeader>

            <!-- View travel request form -->
            <form @submit.prevent="submit" class="grid gap-1.5 py-4" novalidate>
                <!-- Solicitor ID field (read only) -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="solicitorId"> ID Solicitante </Label>
                    <Input
                        id="solicitor"
                        class="col-span-3"
                        type="text"
                        v-model="travelRequestData.user.id"
                        name="solicitorId"
                        disabled
                        readonly
                    />
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>

                <!-- Solicitor field (read only) -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="solicitorName"> Solicitante </Label>
                    <Input
                        id="solicitor"
                        class="col-span-3"
                        type="text"
                        v-model="travelRequestData.user.name"
                        name="solicitorName"
                        disabled
                        readonly
                    />
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>

                <!-- Destination field -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="destination"> Destino </Label>
                    <Input
                        id="destination"
                        class="col-span-3"
                        type="text"
                        v-model="travelRequestData.destination"
                        name="destination"
                        placeholder="Canada, Marrocos..."
                        disabled
                        readonly
                    />
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>

                <!-- Departure field -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="departureDate"> Data de ida </Label>
                    <Popover>
                        <PopoverTrigger as-child>
                            <Button
                                disabled
                                variant="outline"
                                class="w-[280px] justify-start text-left font-normal"
                            >
                                <CalendarIcon class="mr-2 h-4 w-4" />
                                {{
                                    dateFormatter.format(
                                        new Date(
                                            travelRequestData.departure_date
                                        )
                                    )
                                }}
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent class="w-auto p-0">
                            <Calendar initial-focus />
                        </PopoverContent>
                        <span
                            class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                        ></span>
                    </Popover>
                </div>

                <!-- Return field -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="returnDate"> Data de volta </Label>
                    <Popover>
                        <PopoverTrigger as-child>
                            <Button
                                disabled
                                variant="outline"
                                class="w-[280px] justify-start text-left font-normal"
                            >
                                <CalendarIcon class="mr-2 h-4 w-4" />
                                {{
                                    dateFormatter.format(
                                        new Date(travelRequestData.return_date)
                                    )
                                }}
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent class="w-auto p-0">
                            <Calendar :disabled="true" initial-focus />
                        </PopoverContent>
                        <span
                            class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                        ></span>
                    </Popover>
                </div>

                <!-- Status field (read only) -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="name"> Status </Label>
                    <Select :disabled="true">
                        <SelectTrigger class="col-span-3 w-full">
                            <SelectValue class="text-foreground">
                                {{
                                    translateAndFormatStatus(
                                        travelRequestData.status
                                    )
                                }}
                            </SelectValue>
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem value="solicited">
                                    Solicited
                                </SelectItem>
                                <SelectItem value="approved">
                                    Approved
                                </SelectItem>
                                <SelectItem value="cancelled">
                                    Cancelled
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>

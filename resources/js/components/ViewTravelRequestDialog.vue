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

// Props
const props = defineProps({
    currentTravelRequestData: Object,
    viewTravelRequestDialogOpen: Boolean,
});

// Emits
const emits = defineEmits(["update:viewTravelRequestDialogOpen"]);

// Computed value from parent ref
const viewTravelRequestDialogOpen = computed({
    get: () => props.viewTravelRequestDialogOpen,
    set: (val) => emits("update:viewTravelRequestDialogOpen", val),
});

// Date formatter for calendar
const dateFormatter = new DateFormatter("pt-BR", {
    dateStyle: "long",
    timeZone: "UTC",
});
</script>

<template>
    <Dialog v-model:open="viewTravelRequestDialogOpen">
        <DialogContent class="sm:max-w-[425px]">
            <!-- Dialog header -->
            <DialogHeader>
                <DialogTitle>Informaçoes Sobre Pedido de Viagem </DialogTitle>
                <DialogDescription>
                    Informações sobre o pedido de viagem de id
                    {{ currentTravelRequestData.id }}, feito por
                    {{ currentTravelRequestData.user.name }}.
                </DialogDescription>
            </DialogHeader>

            <!-- Dialog body -->
            <form @submit.prevent="submit" class="grid gap-4 py-4" novalidate>
                <!-- Solicitor (read only) -->
                <div>
                    <!-- Field -->
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="solicitorName"> Solicitante </Label>
                        <Input
                            id="solicitor"
                            class="col-span-3"
                            type="text"
                            name="solicitorName"
                            v-model="currentTravelRequestData.user.name"
                            disabled
                            readonly
                        />
                    </div>
                </div>

                <!-- Destination -->
                <div>
                    <!-- Field -->
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="destination"> Destino </Label>
                        <Input
                            id="destination"
                            class="col-span-3"
                            type="text"
                            name="destination"
                            v-model="currentTravelRequestData.destination"
                            placeholder="Canada, Marrocos..."
                            disabled
                            readonly
                        />
                    </div>
                </div>

                <!-- Departure -->
                <div>
                    <!-- Field -->
                    <div class="grid grid-cols-4 items-center gap-4">
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
                                                currentTravelRequestData.departure_date
                                            )
                                        )
                                    }}
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent class="w-auto p-0">
                                <Calendar initial-focus />
                            </PopoverContent>
                        </Popover>
                    </div>
                </div>

                <!-- Return -->
                <div>
                    <!-- Field -->
                    <div class="grid grid-cols-4 items-center gap-4">
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
                                            new Date(
                                                currentTravelRequestData.return_date
                                            )
                                        )
                                    }}
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent class="w-auto p-0">
                                <Calendar :disabled="true" initial-focus />
                            </PopoverContent>
                        </Popover>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <!-- Field (read only) -->
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="name" class="text-right"> Status </Label>
                        <Select
                            v-model="currentTravelRequestData.status"
                            :disabled="true"
                        >
                            <SelectTrigger class="col-span-3 w-full">
                                <SelectValue placeholder="Select a fruit">
                                    {{
                                        translateAndFormatStatus(
                                            currentTravelRequestData.status
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
                    </div>
                </div>
            </form>

            <!-- Dialog footer -->
            <DialogFooter></DialogFooter>
        </DialogContent>
    </Dialog>
</template>

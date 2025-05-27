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
import { translateAndFormatStatus } from "@/lib/utils";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    travelRequestData: Object,
    travelRequestStatusUpdateDialogToggle: Boolean,
});
const emits = defineEmits(["update:travelRequestStatusUpdateDialogToggle"]);

// Computed value from parent ref
const travelRequestInfoDialogToggle = computed({
    get: () => props.travelRequestStatusUpdateDialogToggle,
    set: (v) => emits("update:travelRequestStatusUpdateDialogToggle", v),
});

// Create travel request dialog form
const form = useForm({
    travelRequestId: props.travelRequestData.id,
    solicitorId: props.travelRequestData.user.id,
    destination: props.travelRequestData.destination,
    departureDate: props.travelRequestData.departure_date,
    returnDate: props.travelRequestData.return_date,
    status: props.travelRequestData.status,
});

// Date formatter for calendar
const dateFormatter = new DateFormatter("pt-BR", {
    dateStyle: "long",
    timeZone: "UTC",
});

// Form submit function
function submit() {
    form.clearErrors();
    // console.log(form.data());
    form.post("/travelRequest/updateStatus");
}
</script>

<template>
    <Dialog v-model:open="travelRequestInfoDialogToggle">
        <DialogContent class="sm:max-w-[425px]">
            <!-- Dialog header -->
            <DialogHeader>
                <DialogTitle>Atualizar Status do Pedido de Viagem </DialogTitle>
                <DialogDescription>
                    Atualizar o status do pedido de viagem de id
                    {{ travelRequestData.id }}.
                </DialogDescription>
            </DialogHeader>

            <!-- Update travel request status form -->
            <form @submit.prevent="submit" class="grid gap-1.5 py-4" novalidate>
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
                    <Select v-model="form.status">
                        <SelectTrigger class="col-span-3 w-full">
                            <SelectValue class="text-foreground">
                                {{ translateAndFormatStatus(form.status) }}
                            </SelectValue>
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem value="solicited">
                                    Solicitado
                                </SelectItem>
                                <SelectItem value="approved">
                                    Aprovado
                                </SelectItem>
                                <SelectItem value="cancelled">
                                    Cancelado
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>
            </form>

            <!-- Dialog footer -->
            <DialogFooter>
                <!-- Form submit button -->
                <Button class="w-full" @click="submit">
                    Atualizar status de pedido de viagem
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

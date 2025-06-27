<script setup lang="ts">
import { Button } from "@/components/ui/button";
import {
    DateFormatter,
    type DateValue,
    getLocalTimeZone,
    parseDate,
} from "@internationalized/date";
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
import { useForm, usePage, router } from "@inertiajs/vue3";
import { cn } from "@/lib/utils";
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
import { computed, reactive, ref, watch } from "vue";
import { translateAndFormatStatus } from "@/lib/utils";
import { Textarea } from "@/components/ui/textarea";

// Props
const props = defineProps({
    travelRequestData: Object,
    solicitTravelRequestCancellationFormDialogToggle: Boolean,
    errors: Object,
});

// Emits
const emits = defineEmits([
    "update:solicitTravelRequestCancellationFormDialogToggle",
]);

// Computed value from parent ref
const travelRequestInfoDialogToggle = computed({
    get: () => props.solicitTravelRequestCancellationFormDialogToggle,
    set: (v) =>
        emits("update:solicitTravelRequestCancellationFormDialogToggle", v),
});

// Create travel request dialog form
const form = useForm({
    travelRequestId: props.travelRequestData?.id,
    solicitorId: props.travelRequestData?.user.id,
    destination: props.travelRequestData?.destination,
    departureDate: props.travelRequestData?.departure_date,
    returnDate: props.travelRequestData?.return_date,
    status: props.travelRequestData?.status,
    requestMessage: "",
});

// Date formatter for calendar
const dateFormatter = new DateFormatter("pt-BR", {
    dateStyle: "long",
});

// Form submit function
function submit() {
    console.log(form.data());
    form.clearErrors();
    form.post("/cancellationRequest/create");
}
</script>

<template>
    <Dialog v-model:open="travelRequestInfoDialogToggle">
        <DialogContent class="sm:max-w-[425px]">
            <!-- Dialog header -->
            <DialogHeader>
                <DialogTitle>Solicitar Cancelamento</DialogTitle>
                <DialogDescription>
                    Solicitar o cancelamento do pedido de viagem com o id X,
                    criado por Y.
                </DialogDescription>
            </DialogHeader>

            <!-- Solicit travel request cancellation form -->
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
                        v-model="form.destination"
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
                                        new Date(form.departureDate)
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
                                        new Date(form.returnDate)
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
                                {{ translateAndFormatStatus(form.status) }}
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

                <!-- Request message -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="requestMessage"> Mensagem </Label>
                    <Textarea
                        id="requestMessage"
                        class="col-span-3"
                        type="text"
                        v-model="form.requestMessage"
                        name="requestMessage"
                    />
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                        >{{ props.errors?.value.requestMessage }}</span
                    >
                </div>
            </form>

            <!-- Dialog footer -->
            <DialogFooter>
                <!-- Form submit button -->
                <Button @click="submit" variant="destructive" class="w-full">
                    Solicitar cancelamento
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

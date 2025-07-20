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
import type { TravelRequestWithUser } from "resources/types/TravelRequest";

const props = defineProps<{
    travelRequestData: TravelRequestWithUser;
    solicitTravelRequestCancellationFormDialogToggle: boolean;
    errors: Object;
}>();

const emits = defineEmits([
    "update:solicitTravelRequestCancellationFormDialogToggle",
]);

const travelRequestInfoDialogToggle = computed({
    get: () => props.solicitTravelRequestCancellationFormDialogToggle,
    set: (v) =>
        emits("update:solicitTravelRequestCancellationFormDialogToggle", v),
});

const form = useForm({
    travelRequestId: props.travelRequestData?.id,
    solicitorId: props.travelRequestData?.user.id,
    destination: props.travelRequestData?.destination,
    departureDate: props.travelRequestData?.departure_date,
    returnDate: props.travelRequestData?.return_date,
    status: props.travelRequestData?.status,
    requestMessage: "",
});

const dateFormatter = new DateFormatter("pt-BR", {
    dateStyle: "long",
});

function submit(e: Event) {
    form.clearErrors();
    form.post("/cancellationRequest/create");
}

// Clears shared page errors when closing modal
watch(
    () => travelRequestInfoDialogToggle.value,
    (newValue, oldValue) => {
        if (newValue === false)
            router.reload({
                only: [],
                preserveState: true,
                preserveScroll: true,
            });
    }
);
</script>

<template>
    <Dialog v-model:open="travelRequestInfoDialogToggle">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Solicitar Cancelamento</DialogTitle>
                <DialogDescription>
                    Solicitar o cancelamento do pedido de viagem com o id X,
                    criado por Y.
                </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="submit" class="grid gap-1.5 py-4" novalidate>
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
                        >{{
                            props.errors?.value.requestMessage ??
                            props.errors?.value.travelRequestId
                        }}</span
                    >
                </div>
            </form>
            <DialogFooter>
                <Button @click="submit" variant="destructive" class="w-full">
                    Solicitar cancelamento
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

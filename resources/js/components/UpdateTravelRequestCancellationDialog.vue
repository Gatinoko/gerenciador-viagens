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
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { computed, watch } from "vue";
import { translateAndFormatStatus } from "@/lib/utils";
import { Textarea } from "@/components/ui/textarea";
import type { CancellationRequestWithTravelRequest } from "resources/types/CancellationRequest";

const props = defineProps<{
    cancellationRequestData: CancellationRequestWithTravelRequest;
    travelRequestCancellationStatusUpdateDialogToggle: boolean;
}>();
const emits = defineEmits([
    "update:travelRequestCancellationStatusUpdateDialogToggle",
]);

const updateCancellationRequestDialogToggle = computed({
    get: () => props.travelRequestCancellationStatusUpdateDialogToggle,
    set: (v) =>
        emits("update:travelRequestCancellationStatusUpdateDialogToggle", v),
});

const form = useForm({
    cancellationRequestId: props.cancellationRequestData?.id,
    associatedTravelRequestId: props.cancellationRequestData?.travel_request.id,
    message: props.cancellationRequestData?.message,
    status: props.cancellationRequestData?.status,
});

function submit(e: Event) {
    form.clearErrors();
    form.post("/cancellationRequest/updateStatus");
}

// Clears shared page errors when closing modal
watch(
    () => updateCancellationRequestDialogToggle.value,
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
    <Dialog v-model:open="updateCancellationRequestDialogToggle">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Atualizar Solicitação de Cancelamento</DialogTitle>
                <DialogDescription>
                    Atualiza a solicitação de cancelamento do pedido de viagem
                    com o id X, criado por Y.
                </DialogDescription>
            </DialogHeader>

            <form @submit.prevent="submit" class="grid gap-1.5 py-4" novalidate>
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="cancellationRequestId"> ID Solicitação </Label>
                    <Input
                        id="id"
                        class="col-span-3"
                        type="text"
                        v-model="form.cancellationRequestId"
                        name="cancellationRequestId"
                        disabled
                        readonly
                    />
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>

                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="associatedTravelRequestId">
                        ID Pedido Associado
                    </Label>
                    <Input
                        id="request_id"
                        class="col-span-3"
                        type="text"
                        v-model="form.associatedTravelRequestId"
                        name="associatedTravelRequestId"
                        disabled
                        readonly
                    />
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>

                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="status"> Status </Label>
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
                                <SelectItem value="rejected">
                                    Rejeitado
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>

                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="message"> Mensagem </Label>
                    <Textarea
                        id="message"
                        class="col-span-3"
                        type="text"
                        v-model="form.message"
                        name="message"
                        readonly
                        disabled
                    />
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>
            </form>

            <DialogFooter>
                <Button @click="submit" variant="default" class="w-full">
                    Atualizar solicitação de cancelamento
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import ViewTravelRequestDialog from "@/components/ViewTravelRequestDialog.vue";
import UpdateTravelRequestStatusDialog from "@/components/UpdateTravelRequestStatusDialog.vue";
import SolicitTravelRequestCancellationDialog from "@/components/SolicitTravelRequestCancellationDialog.vue";
import { MoreHorizontal } from "lucide-vue-next";
import { Button } from "@/components/ui/button";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { computed, ref } from "vue";
import UpdateTravelRequestCancellationDialog from "../UpdateTravelRequestCancellationDialog.vue";

const props = defineProps({
    cancellationRequestInfo: Object,
    cancellationRequestUpdateControlsToggle: Boolean,
    errors: Object,
});

const associatedTravelRequestInfoDialogToggle = ref(false);
const cancellationRequestStatusUpdateDialogToggle = ref(false);

function viewAssociatedTravelRequestInfoHandler() {
    associatedTravelRequestInfoDialogToggle.value = true;
}

function updateCancellationRequestStatusHandler() {
    cancellationRequestStatusUpdateDialogToggle.value = true;
}
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="w-8 h-8 p-0">
                <span class="sr-only">Abrir menu</span>
                <MoreHorizontal class="w-4 h-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Opçoes</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem @click="viewAssociatedTravelRequestInfoHandler">
                Ver informações do pedido associado
            </DropdownMenuItem>
            <DropdownMenuItem
                v-if="props.cancellationRequestUpdateControlsToggle"
                @click="updateCancellationRequestStatusHandler"
            >
                Atualizar status da solicitação
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>

    <ViewTravelRequestDialog
        :travelRequestData="props.cancellationRequestInfo?.travel_request"
        v-model:travel-request-info-dialog-toggle="
            associatedTravelRequestInfoDialogToggle
        "
    />

    <UpdateTravelRequestCancellationDialog
        v-if="props.cancellationRequestUpdateControlsToggle"
        :cancellationRequestData="props.cancellationRequestInfo"
        v-model:travel-request-cancellation-status-update-dialog-toggle="
            cancellationRequestStatusUpdateDialogToggle
        "
    />
</template>

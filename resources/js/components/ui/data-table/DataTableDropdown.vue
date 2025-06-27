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
import { ref } from "vue";

const props = defineProps({
    travelRequestInfo: Object,
    travelRequestUpdateControlsToggle: Boolean,
    travelRequestSolicitCancellationControlsToggle: Boolean,
    errors: Object,
});

// View travel request dialog ref (for programatic control)
const travelRequestInfoDialogToggle = ref(false);

// View travel request dialog ref (for programatic control)
const travelRequestStatusUpdateDialogToggle = ref(false);

// Show solicit travel request cancellation form dialog
const solicitTravelRequestCancellationFormDialogToggle = ref(false);

// Handler function for the "Ver informações do pedido" button
function viewTravelRequestInfoHandler() {
    travelRequestInfoDialogToggle.value = true;
}

// Handler function for the "Atualizar status do pedido" button
function updateTravelRequestStatusHandler() {
    travelRequestStatusUpdateDialogToggle.value = true;
}

// Handler function for the "Solicitar cancelamento" button
function solicitTravelRequestCancellationFormHandler() {
    solicitTravelRequestCancellationFormDialogToggle.value = true;
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
            <DropdownMenuItem @click="viewTravelRequestInfoHandler">
                Ver informações do pedido
            </DropdownMenuItem>
            <DropdownMenuItem
                v-if="props.travelRequestUpdateControlsToggle"
                @click="updateTravelRequestStatusHandler"
            >
                Atualizar status do pedido
            </DropdownMenuItem>
            <DropdownMenuItem
                v-if="props.travelRequestSolicitCancellationControlsToggle"
                variant="destructive"
                @click="solicitTravelRequestCancellationFormHandler"
            >
                Solicitar cancelamento
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>

    <ViewTravelRequestDialog
        :travelRequestData="travelRequestInfo"
        v-model:travel-request-info-dialog-toggle="
            travelRequestInfoDialogToggle
        "
    />

    <UpdateTravelRequestStatusDialog
        v-if="props.travelRequestUpdateControlsToggle"
        :travelRequestData="travelRequestInfo"
        v-model:travel-request-status-update-dialog-toggle="
            travelRequestStatusUpdateDialogToggle
        "
    />

    <SolicitTravelRequestCancellationDialog
        v-if="props.travelRequestSolicitCancellationControlsToggle"
        :travelRequestData="travelRequestInfo"
        v-model:solicit-travel-request-cancellation-form-dialog-toggle="
            solicitTravelRequestCancellationFormDialogToggle
        "
        :errors="props.errors"
    />
</template>

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

const travelRequestInfoDialogToggle = ref(false);
const travelRequestStatusUpdateDialogToggle = ref(false);
const solicitTravelRequestCancellationFormDialogToggle = ref(false);

function viewTravelRequestInfoHandler() {
    travelRequestInfoDialogToggle.value = true;
}

function updateTravelRequestStatusHandler() {
    travelRequestStatusUpdateDialogToggle.value = true;
}

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

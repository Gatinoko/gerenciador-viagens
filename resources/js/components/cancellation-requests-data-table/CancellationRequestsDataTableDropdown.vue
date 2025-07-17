<script setup lang="ts">
import ViewTravelRequestDialog from "@/components/ViewTravelRequestDialog.vue";
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
import ViewTravelRequestCancellationDialog from "../ViewTravelRequestCancellationDialog.vue";

const props = defineProps({
    cancellationRequestInfo: Object,
    errors: Object,
});

const associatedTravelRequestInfoDialogToggle = ref(false);
const cancellationRequestStatusUpdateDialogToggle = ref(false);
const cancellationRequestInfoDialogToggle = ref(false);

function viewAssociatedTravelRequestInfoHandler() {
    associatedTravelRequestInfoDialogToggle.value = true;
}
function updateCancellationRequestStatusHandler() {
    cancellationRequestStatusUpdateDialogToggle.value = true;
}
function viewCancellationRequestInfoHandler() {
    cancellationRequestInfoDialogToggle.value = true;
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
            <DropdownMenuItem @click="viewCancellationRequestInfoHandler">
                Ver informações da solicitação
            </DropdownMenuItem>
            <DropdownMenuItem @click="viewAssociatedTravelRequestInfoHandler">
                Ver informações do pedido associado
            </DropdownMenuItem>
            <DropdownMenuItem @click="updateCancellationRequestStatusHandler">
                Atualizar status da solicitação
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>

    <ViewTravelRequestCancellationDialog
        :cancellationRequestData="props.cancellationRequestInfo"
        v-model:cancellation-request-info-dialog-toggle="
            cancellationRequestInfoDialogToggle
        "
    />

    <ViewTravelRequestDialog
        :travelRequestData="props.cancellationRequestInfo?.travel_request"
        v-model:travel-request-info-dialog-toggle="
            associatedTravelRequestInfoDialogToggle
        "
    />

    <UpdateTravelRequestCancellationDialog
        :cancellationRequestData="props.cancellationRequestInfo"
        v-model:travel-request-cancellation-status-update-dialog-toggle="
            cancellationRequestStatusUpdateDialogToggle
        "
    />
</template>

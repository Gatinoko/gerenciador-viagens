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
import { ref } from "vue";

const props = defineProps({
    travelRequestInfo: Object,
});

// View travel request dialog ref (for programatic control)
const travelRequestInfoDialogToggle = ref(false);

// Handler function for the "Ver informações do pedido" button
function viewTravelRequestInfoHandler() {
    travelRequestInfoDialogToggle.value = true;
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
            <DropdownMenuItem @click="viewTravelRequestInfoHandler">
                Ver informações do pedido
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>

    <ViewTravelRequestDialog
        :travelRequestData="travelRequestInfo"
        v-model:travel-request-info-dialog-toggle="
            travelRequestInfoDialogToggle
        "
    />
</template>

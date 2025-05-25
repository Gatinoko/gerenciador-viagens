<script setup lang="ts">
import { Button } from "@/components/ui/button";
import {
    Table,
    TableCaption,
    TableHeader,
    TableRow,
    TableHead,
    TableBody,
    TableCell,
} from "@/components/ui/table";
import AppLayout from "@/layouts/AppLayout.vue";
import Header from "@/components/Header.vue";
import CreateTravelRequestDialog from "@/components/CreateTravelRequestDialog.vue";
import axios from "axios";
import ViewTravelRequestDialog from "@/components/ViewTravelRequestDialog.vue";

// Props
const { appName, allReqs, errors } = defineProps({
    appName: String,
    allReqs: Array,
    errors: Object,
});

// Auth user object
const page = usePage<{ flash: { message: string } }>();
const user = computed(() => page.props.auth?.user);

// Form values
const form = useForm({
    solicitorId: user.value.id,
    destination: "",
    departureDate: "",
    returnDate: "",
    status: "",
});

// Ref that stores current travel request data when the user clicks on a table row
const currentTravelRequestData = ref();

// View travel request dialog ref (for programatic control)
const viewTravelRequestDialogOpen = ref(false);

// Handler function for clicking in the table row
function tableRowClickHandler(e: PointerEvent) {
    // Resets currentTravelRequestData ref
    currentTravelRequestData.value = {};

    // Gets id
    const currentTravelRequest = e.currentTarget?.dataset.id;

    // Send get request to endpoint
    axios
        .get("/travelRequest/get", {
            params: {
                user_id: user.value.id,
                travel_request_id: currentTravelRequest,
            },
        })
        .then((res) => {
            currentTravelRequestData.value = res.data;
            console.log(res.data);
        })
        .finally(() => {
            viewTravelRequestDialogOpen.value = true;
            console.log(viewTravelRequestDialogOpen.value);
        });
}
</script>

<template>
    <AppLayout>
        <Header text="Dashboard" />

        <span class="text-green-600" v-if="page.props.flash.message">{{
            page.props.flash.message
        }}</span>

        <!-- User travel request table -->
        <Table>
            <!-- Caption -->
            <TableCaption>Pedidos de viagem de {{ user.name }}.</TableCaption>

            <!-- Header -->
            <TableHeader>
                <TableRow>
                    <TableHead class="w-[100px]"> ID Pedido </TableHead>
                    <TableHead>Solicitante</TableHead>
                    <TableHead>Destino</TableHead>
                    <TableHead> Data de ida </TableHead>
                    <TableHead> Data de volta </TableHead>
                    <TableHead> Status </TableHead>
                </TableRow>
            </TableHeader>

            <!-- Body -->
            <TableBody>
                <TableRow
                    @click="tableRowClickHandler"
                    :data-id="travelRequest?.id"
                    v-for="travelRequest in allReqs"
                >
                    <TableCell class="font-medium">
                        {{ travelRequest?.id }}
                    </TableCell>
                    <TableCell class="font-medium">
                        {{ user.name }}
                    </TableCell>
                    <TableCell class="font-medium">
                        {{ travelRequest?.destination }}
                    </TableCell>
                    <TableCell class="font-medium">
                        {{ travelRequest?.departure_date }}
                    </TableCell>
                    <TableCell class="font-medium">
                        {{ travelRequest?.return_date }}
                    </TableCell>
                    <TableCell class="font-medium">
                        {{ travelRequest?.status }}
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>

        <!-- Create new travel request dialog -->
        <CreateTravelRequestDialog
            v-bind:user="user"
            v-bind:errors="errors"
            v-bind:form="form"
        >
            <Button>Novo pedido de viagem</Button>
        </CreateTravelRequestDialog>

        <ViewTravelRequestDialog
            v-bind:current-travel-request-data="currentTravelRequestData"
            v-model:view-travel-request-dialog-open="
                viewTravelRequestDialogOpen
            "
        />
    </AppLayout>
</template>

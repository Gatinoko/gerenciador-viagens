<script setup lang="ts">
import { toast } from "vue-sonner";
import { translateAndFormatStatus, formatDbDate } from "@/lib/utils";
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
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";
import axios from "axios";
import ViewTravelRequestDialog from "@/components/ViewTravelRequestDialog.vue";
import DataTable from "@/components/ui/data-table/DataTable.vue";
import { columns } from "@/components/ui/data-table/columns";

// Props
const props = defineProps({
    appName: String,
    userRequests: Array,
    errors: Object,
});

const page = usePage<{
    toast: {
        type: string;
        message: string;
    };
}>();

// Auth user object
const user = computed(() => page.props.auth?.user);

const createTravelRequestFormDialogToggle = ref(false);

function createTravelRequestHandler() {
    createTravelRequestFormDialogToggle.value = true;
}

// Triggers a success toast whenever the user logs in and gets redirected to the dashboard
watch(
    () => ({ toast: page.props.toast }),
    (v) => {
        if (v.toast.type === "success")
            setTimeout(() => {
                toast.success(`${v.toast.message}`);
            }, 0);
    },
    { immediate: true }
);
</script>

<template>
    <AppLayout>
        <template #header>
            <Header v-slot:header text="Dashboard" />
        </template>

        <Button @click="createTravelRequestHandler"
            >Novo pedido de viagem</Button
        >

        <CreateTravelRequestDialog
            v-bind:user="user"
            v-bind:errors="props.errors"
            v-model:create-travel-request-dialog-toggle="
                createTravelRequestFormDialogToggle
            "
        />

        <DataTable
            v-bind:errors="props.errors"
            :columns="columns"
            :data="props.userRequests"
            :travel-request-update-controls-toggle="false"
            :travel-request-solicit-cancellation-controls-toggle="true"
        />
    </AppLayout>
</template>

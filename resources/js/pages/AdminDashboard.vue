<script setup lang="ts">
import { toast } from "vue-sonner";
import AppLayout from "@/layouts/AppLayout.vue";
import Header from "@/components/Header.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";
import { columns as travelRequestColumns } from "@/components/travel-requests-data-table/columns";
import { columns as cancellationRequestColumns } from "@/components/cancellation-requests-data-table/columns";
import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from "@/components/ui/tabs/index";
import TravelRequestsDataTable from "@/components/travel-requests-data-table/TravelRequestsDataTable.vue";
import CancellationRequestsDataTable from "@/components/cancellation-requests-data-table/CancellationRequestsDataTable.vue";

// Props
const props = defineProps({
    appName: String,
    allRequests: Array,
    allCancellationRequests: Array,
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
            <Header v-slot:header text="Dashboard de Administradores" />
        </template>

        <Tabs default-value="travel-requests">
            <TabsList>
                <TabsTrigger value="travel-requests">
                    Travel Requests
                </TabsTrigger>
                <TabsTrigger value="cancellation-requests">
                    Cancellation Requests
                </TabsTrigger>
            </TabsList>
            <TabsContent value="travel-requests">
                <TravelRequestsDataTable
                    v-bind:errors="props.errors"
                    :columns="travelRequestColumns"
                    :data="props.allRequests"
                    :travel-request-update-controls-toggle="true"
                    :travel-request-solicit-cancellation-controls-toggle="false"
                />
            </TabsContent>
            <TabsContent value="cancellation-requests">
                <CancellationRequestsDataTable
                    v-bind:errors="props.errors"
                    :columns="cancellationRequestColumns"
                    :data="props.allCancellationRequests"
                    :cancellation-request-update-controls-toggle="true"
                />
            </TabsContent>
        </Tabs>
    </AppLayout>
</template>

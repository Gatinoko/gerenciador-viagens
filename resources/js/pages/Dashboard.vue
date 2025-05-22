<script setup lang="ts">
import { Button } from "@/components/ui/button";
import AppLayout from "@/layouts/AppLayout.vue";

defineProps({ appName: String });
</script>

<template>
    <AppLayout>
        <h1>Dashboard</h1>
    </AppLayout>
</template>

<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";

defineProps({ appName: String });
</script>

<template>
    <AppLayout>
        <h1>Welcome to {{ appName }}</h1>
        <h2>This is the index. TODO.</h2>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import Header from "@/components/Header.vue";

defineProps({ appName: String });
</script>

<template>
    <AppLayout>
        <template #header>
            <Header v-slot:header text="Início" />
        </template>
        <h1>Welcome to {{ appName }}</h1>
        <h2>This is the index. TODO.</h2>
    </AppLayout>
</template>

<script setup lang="ts">
import { Button } from "@/components/ui/button";

defineProps({ appName: String });
</script>

<template>
    <div class="p-6 text-gray-900 bg-red-400">
        <h1>Dashboard</h1>
        <Button>Test button</Button>
    </div>
</template>

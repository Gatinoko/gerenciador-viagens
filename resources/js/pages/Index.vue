<script setup lang="ts">
import { defineProps } from "vue";

defineProps({ appName: String });
</script>

<template>
    <div class="p-6 text-gray-900 bg-red-400">
        <h1>Welcome to {{ appName }}</h1>
    </div>
</template>

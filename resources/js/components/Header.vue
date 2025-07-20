<script setup lang="ts">
const props = defineProps<{ text: string }>();
</script>

<template>
    <header
        class="bg-primary/75 px-12 py-5 border-b-1 border-primary/50 shadow-md"
    >
        <h1 class="text-5xl font-semibold text-secondary">
            {{ text }}
        </h1>
    </header>
</template>

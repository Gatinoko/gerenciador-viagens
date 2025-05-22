<script setup lang="ts">
const props = defineProps({
    text: String,
});
</script>

<template>
    <header
        class="bg-neutral-400 px-40 py-5 mb-10 border-b-1 border-neutral-500"
    >
        <h1 class="text-5xl">{{ text }}</h1>
    </header>
</template>

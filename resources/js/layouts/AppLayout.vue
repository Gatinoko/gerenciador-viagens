<script lang="ts" setup>
import Navigation from "@/components/Navigation.vue";
</script>

<template>
    <Navigation />

    <main class="flex flex-col">
        <slot />
    </main>
</template>

<script lang="ts" setup>
import Navigation from "@/components/Navigation.vue";
import { Toaster } from "@/components/ui/sonner";
import "vue-sonner/style.css";
</script>

<template>
    <Navigation />

    <main class="flex flex-col">
        <slot />
    </main>

    <Toaster rich-colors />
</template>

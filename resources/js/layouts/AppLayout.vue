<script lang="ts" setup>
import Navigation from "@/components/Navigation.vue";
import { Toaster } from "@/components/ui/sonner";
import "vue-sonner/style.css";
</script>

<template>
    <Navigation />

    <slot name="header"></slot>

    <main class="flex flex-col px-20 pt-10">
        <slot />
    </main>

    <Toaster rich-colors theme="dark" />
</template>

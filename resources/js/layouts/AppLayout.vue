<script lang="ts" setup>
import Navigation from "@/components/Navigation.vue";
import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <Navigation />
    <main>
        <slot />
    </main>
</template>

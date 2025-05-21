<template>
    <div class="p-6 text-gray-900">
        <h1>Welcome to {{ appName }}</h1>
    </div>
</template>

<script setup>
defineProps(["appName"]);
</script>

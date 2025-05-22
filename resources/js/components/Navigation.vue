<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <nav class="bg-neutral-500 p-2 flex justify-between">
        <ul class="flex gap-1">
            <li>
                <Link href="./dashboard">
                    <Button>Dashboard</Button>
                </Link>
            </li>
            <li>
                <Link href="/">
                    <Button>Index</Button>
                </Link>
            </li>
        </ul>

        <ul class="flex gap-1">
            <li>
                <Link href="/login">
                    <Button>Login</Button>
                </Link>
            </li>
            <li>
                <Link href="/register">
                    <Button>Register</Button>
                </Link>
            </li>
        </ul>
    </nav>
</template>

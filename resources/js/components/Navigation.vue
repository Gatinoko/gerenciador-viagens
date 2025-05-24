<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const user = computed(() => page.props.auth?.user);

const { appName, errors } = defineProps({ appName: String, errors: Object });
</script>

<template>
    <nav
        class="bg-neutral-500 p-2 flex justify-between border-b-1 border-neutral-600"
    >
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

        <span class="text-red-600" v-if="user">{{ user.email }}</span>
        <span class="text-red-600" v-if="user">{{ user.name }}</span>

        <ul class="flex gap-1">
            <li>
                <Link v-if="user" href="/logout" method="post">
                    <Button>Logout</Button>
                </Link>
            </li>
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

<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";

const page = usePage();
const user = computed(() => page.props.auth?.user);

console.log(page.props.auth);

const { appName, errors } = defineProps({ appName: String, errors: Object });
</script>

<template>
    <nav
        class="bg-primary py-2 px-12 flex border-b-1 gap-6 border-neutral-600 shadow-md"
    >
        <!-- Application name -->
        <h1
            class="self-center font-semibold text-primary-foreground text-nowrap select-none"
        >
            Gerenciador de Viagens &copy
        </h1>

        <div class="flex w-full justify-between">
            <ul class="flex gap-1">
                <li>
                    <Link href="/">
                        <Button
                            size="sm"
                            class="bg-transparent hover:bg-secondary/10"
                            >Inicio</Button
                        >
                    </Link>
                </li>
                <li>
                    <Link v-if="user" href="./dashboard">
                        <Button
                            size="sm"
                            class="bg-transparent hover:bg-secondary/10"
                            >Dashboard</Button
                        >
                    </Link>
                </li>
                <li>
                    <Link
                        v-if="user && user.user_role === 'admin'"
                        href="./adminDashboard"
                    >
                        <Button
                            size="sm"
                            class="bg-transparent hover:bg-secondary/10"
                            >Dashboard de Admins</Button
                        >
                    </Link>
                </li>
            </ul>

            <!-- <span class="text-red-600" v-if="user">{{ user.email }}</span>
            <span class="text-red-600" v-if="user">{{ user.name }}</span> -->

            <ul class="flex gap-1">
                <li>
                    <Link v-if="user" href="/auth/logout" method="post">
                        <Button
                            size="sm"
                            class="bg-transparent hover:bg-secondary/10"
                            >Logout</Button
                        >
                    </Link>
                </li>
                <li>
                    <Link v-if="!user" href="/login">
                        <Button
                            size="sm"
                            class="bg-transparent hover:bg-secondary/10"
                            >Login</Button
                        >
                    </Link>
                </li>
                <li>
                    <Link v-if="!user" href="/register">
                        <Button
                            size="sm"
                            class="bg-transparent hover:bg-secondary/10"
                            >Registro</Button
                        >
                    </Link>
                </li>

                <Avatar v-if="user">
                    <AvatarImage
                        src="https://github.com/unovue.png"
                        alt="@unovue"
                    />
                    <AvatarFallback>CN</AvatarFallback>
                </Avatar>
            </ul>
        </div>
    </nav>
</template>

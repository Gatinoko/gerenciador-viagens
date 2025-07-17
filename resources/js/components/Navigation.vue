<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { ShieldUser } from "lucide-vue-next";
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from "@/components/ui/tooltip";

const page = usePage();
const user = computed(() => page.props.auth?.user);

const props = defineProps({ appName: String, errors: Object });
</script>

<template>
    <nav
        class="bg-primary py-2 px-12 flex border-b-1 gap-6 border-neutral-600 shadow-md"
    >
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
                            >Dashboard do Usuário</Button
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
                            >Dashboard de Administradores</Button
                        >
                    </Link>
                </li>
            </ul>

            <div class="flex gap-1">
                <ul class="flex gap-1">
                    <li v-if="user">
                        <Link href="/auth/logout" method="post">
                            <Button
                                size="sm"
                                class="bg-transparent hover:bg-secondary/10"
                                >Logout</Button
                            >
                        </Link>
                    </li>
                    <li v-if="!user">
                        <Link href="/login">
                            <Button
                                size="sm"
                                class="bg-transparent hover:bg-secondary/10"
                                >Login</Button
                            >
                        </Link>
                    </li>
                    <li v-if="!user">
                        <Link href="/register">
                            <Button
                                size="sm"
                                class="bg-transparent hover:bg-secondary/10"
                                >Registro</Button
                            >
                        </Link>
                    </li>
                </ul>

                <div class="flex gap-1">
                    <Avatar v-if="user">
                        <AvatarImage
                            src="https://github.com/unovue.png"
                            alt="@unovue"
                        />
                        <AvatarFallback>CN</AvatarFallback>
                    </Avatar>
                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger>
                                <ShieldUser
                                    v-if="user && user.user_role === 'admin'"
                                    class="self-center"
                                    color="white"
                                />
                            </TooltipTrigger>
                            <TooltipContent>
                                <p>Administrador</p>
                            </TooltipContent>
                        </Tooltip>
                    </TooltipProvider>
                </div>
            </div>
        </div>
    </nav>
</template>

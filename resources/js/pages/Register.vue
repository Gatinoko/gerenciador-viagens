<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import AppLayout from "@/layouts/AppLayout.vue";
import Header from "@/components/Header.vue";

defineProps({ appName: String });
</script>

<template>
    <AppLayout>
        <Header text="Registro" />

        <div
            class="p-10 w-200 self-center bg-neutral-300 rounded-xl border-1 border-neutral-400"
        >
            <!-- Register form -->
            <form>
                <div>
                    <Label for="email" class="text-right"> Email </Label>
                    <Input
                        class="col-span-3"
                        id="email"
                        placeholder="exemplo@gmail.com"
                    />
                </div>
                <div>
                    <Label for="senha" class="text-right"> Senha </Label>
                    <Input
                        class="col-span-3"
                        id="password"
                        placeholder="senha123"
                    />
                </div>
            </form>

            <!-- Register button -->
            <Button>Registrar</Button>

            <!-- Auxiliary text -->
            <p>
                Já possui uma conta?
                <Link href="./login" class="text-blue-400 underline"
                    >Faça login aqui</Link
                >
            </p>
        </div>
    </AppLayout>
</template>

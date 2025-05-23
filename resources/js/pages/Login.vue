<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import Header from "@/components/Header.vue";

const page = usePage<{ flash: { message: string } }>();
</script>

<template>
    <AppLayout>
        <Header text="Login" />

        <div
            class="p-10 w-200 self-center bg-neutral-300 rounded-xl border-1 border-neutral-400"
        >
            <!-- Success message  -->
            <span class="text-green-600" v-if="page.props.flash.message">{{
                page.props.flash.message
            }}</span>
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
            <Button>Login</Button>

            <!-- Auxiliary text -->
            <p>
                Não possui uma conta?
                <Link href="./register" class="text-blue-400 underline"
                    >Registre-se aqui</Link
                >
            </p>
        </div>
    </AppLayout>
</template>

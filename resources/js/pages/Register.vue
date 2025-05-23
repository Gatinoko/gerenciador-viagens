<script setup lang="ts">
import { Link, useForm } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import AppLayout from "@/layouts/AppLayout.vue";
import Header from "@/components/Header.vue";

const form = useForm({
    email: "",
    password: "",
    passwordConfirmation: "",
});

function submit() {
    form.clearErrors();
    form.post("/register");
}

const { appName, errors } = defineProps({ appName: String, errors: Object });
</script>

<template>
    <AppLayout>
        <Header text="Registro" />

        <div
            class="p-10 w-150 self-center bg-neutral-300 rounded-xl border-1 border-neutral-400"
        >
            <!-- Register form -->
            <form @submit.prevent="submit" novalidate>
                <div>
                    <Label for="email" class="text-right"> Email </Label>
                    <Input
                        id="email"
                        class="col-span-3"
                        type="email"
                        name="email"
                        placeholder="exemplo@gmail.com"
                        v-model="form.email"
                    />
                    <span class="text-red-600" v-if="errors?.email">{{
                        errors?.email
                    }}</span>
                </div>

                <div>
                    <Label for="password" class="text-right"> Senha </Label>
                    <Input
                        id="password"
                        class="col-span-3"
                        type="text"
                        name="password"
                        placeholder="senha123"
                        v-model="form.password"
                    />
                    <span class="text-red-600" v-if="errors?.password">{{
                        errors?.password
                    }}</span>
                </div>

                <div>
                    <Label for="password_confirmation" class="text-right">
                        Confirmar senha
                    </Label>
                    <Input
                        class="col-span-3"
                        type="text"
                        name="password_confirmation"
                        placeholder="senha123"
                        v-model="form.passwordConfirmation"
                    />
                    <span
                        class="text-red-600"
                        v-if="errors?.passwordConfirmation"
                        >{{ errors.passwordConfirmation }}</span
                    >
                </div>

                <!-- Register button -->
                <Button>Registrar</Button>
            </form>

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

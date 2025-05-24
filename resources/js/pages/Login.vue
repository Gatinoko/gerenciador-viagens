<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import Header from "@/components/Header.vue";

const form = useForm({
    email: "",
    password: "",
});

function submit() {
    form.clearErrors();
    form.post("/login");
}

const { appName, errors } = defineProps({ appName: String, errors: Object });
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

            <!-- Login error message -->
            <span class="text-red-600" v-if="errors?.credentials">
                {{ errors.credentials }}
            </span>

            <!-- Login form -->
            <form @submit.prevent="submit" novalidate>
                <div>
                    <Label for="email" class="text-right"> Email </Label>
                    <Input
                        id="email"
                        class="col-span-3"
                        type="email"
                        placeholder="exemplo@gmail.com"
                        v-model="form.email"
                    />
                    <span class="text-red-600" v-if="errors?.email">{{
                        errors?.email
                    }}</span>
                </div>
                <div>
                    <Label for="senha" class="text-right"> Senha </Label>
                    <Input
                        id="password"
                        class="col-span-3"
                        type="text"
                        placeholder="senha123"
                        v-model="form.password"
                    />
                    <span class="text-red-600" v-if="errors?.password">{{
                        errors?.password
                    }}</span>
                </div>

                <!-- Login button -->
                <Button>Login</Button>
            </form>

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

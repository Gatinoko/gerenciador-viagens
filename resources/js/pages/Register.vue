<script setup lang="ts">
import { Link, useForm } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import AppLayout from "@/layouts/AppLayout.vue";
import Header from "@/components/Header.vue";

const form = useForm({
    name: "",
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
            class="p-6 w-100 self-center bg-background rounded-lg border-1 border-border shadow-lg"
        >
            <!-- Register form -->
            <form @submit.prevent="submit" novalidate class="grid gap-3">
                <div class="grid gap-1.5">
                    <!-- Name field -->
                    <div class="grid gap-0.5">
                        <Label for="name"> Nome </Label>
                        <Input
                            id="name"
                            class="col-span-3"
                            type="text"
                            name="name"
                            placeholder="Jose Carlos"
                            v-model="form.name"
                        />
                        <span
                            class="text-red-600 text-xs h-4 w-full block col-span-3"
                            >{{ errors?.name }}</span
                        >
                    </div>

                    <!-- Email field -->
                    <div class="grid gap-0.5">
                        <Label for="email"> Email </Label>
                        <Input
                            id="email"
                            class="col-span-3"
                            type="email"
                            name="email"
                            placeholder="exemplo@gmail.com"
                            v-model="form.email"
                        />
                        <span
                            class="text-red-600 text-xs h-4 w-full block col-span-3"
                            >{{ errors?.email }}</span
                        >
                    </div>

                    <!-- Password -->
                    <div class="grid gap-0.5">
                        <Label for="password"> Senha </Label>
                        <Input
                            id="password"
                            class="col-span-3"
                            type="password"
                            name="password"
                            placeholder="senha123"
                            v-model="form.password"
                        />
                        <span
                            class="text-red-600 text-xs h-4 w-full block col-span-3"
                            >{{ errors?.password }}</span
                        >
                    </div>

                    <!-- Confirm password -->
                    <div class="grid gap-0.5">
                        <Label for="password_confirmation">
                            Confirmar senha
                        </Label>
                        <Input
                            class="col-span-3"
                            type="password"
                            name="password_confirmation"
                            placeholder="senha123"
                            v-model="form.passwordConfirmation"
                        />
                        <span
                            class="text-red-600 text-xs h-4 w-full block col-span-3"
                            >{{ errors?.passwordConfirmation }}</span
                        >
                    </div>
                </div>

                <!-- Submit button -->
                <Button>Registrar</Button>
            </form>
        </div>
    </AppLayout>
</template>

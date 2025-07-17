<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { toast } from "vue-sonner";
import { useForm, usePage } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import Header from "@/components/Header.vue";
import { watch } from "vue";

const props = defineProps({ appName: String, errors: Object });

const page = usePage<{
    toast: {
        type: string;
        message: string;
    };
}>();

const form = useForm({
    email: "",
    password: "",
});

function submit() {
    form.clearErrors();
    form.post("/auth/login");
}

// Triggers a warning toast every time there is a credential error
watch(
    () => ({ credentialsError: props.errors?.wrongCredentialsError }),
    (v) => {
        if (v.credentialsError) toast.warning(`${v.credentialsError}`);
    }
);

// Triggers a success toast when user registers successfully and gets redirected to login page, or when the user logs out
watch(
    () => ({ toast: page.props.toast }),
    (v) => {
        if (v.toast.type === "success")
            setTimeout(() => {
                toast.success(`${v.toast.message}`);
            }, 0);
    },
    { immediate: true }
);
</script>

<template>
    <AppLayout>
        <template #header>
            <Header v-slot:header text="Login" />
        </template>
        <div
            class="p-6 w-100 self-center bg-background rounded-lg border-1 border-border shadow-lg"
        >
            <form @submit.prevent="submit" novalidate class="grid gap-3">
                <div class="grid gap-1.5">
                    <div class="grid gap-0.5">
                        <Label for="email"> Email </Label>
                        <Input
                            id="email"
                            class="col-span-3"
                            type="email"
                            placeholder="exemplo@gmail.com"
                            v-model="form.email"
                        />
                        <span
                            class="text-red-600 text-xs h-4 w-full block col-span-3"
                            >{{ errors?.email }}</span
                        >
                    </div>

                    <div class="grid gap-0.5">
                        <Label for="senha"> Senha </Label>
                        <Input
                            id="password"
                            class="col-span-3"
                            type="password"
                            placeholder="senha123"
                            v-model="form.password"
                        />
                        <span class="text-red-600 text-xs h-4 w-full block">{{
                            errors?.password
                        }}</span>
                    </div>
                </div>
                <Button>Login</Button>
            </form>
        </div>
    </AppLayout>
</template>

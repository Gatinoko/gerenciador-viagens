<script setup lang="ts">
import { Button } from "@/components/ui/button";
import {
    DateFormatter,
    type DateValue,
    getLocalTimeZone,
    parseDate,
} from "@internationalized/date";
import { CalendarIcon } from "lucide-vue-next";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { useForm, usePage, router } from "@inertiajs/vue3";
import { cn } from "@/lib/utils";
import { Calendar } from "@/components/ui/calendar";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { computed, reactive, ref, watch } from "vue";

// Props
const { errors, user, form } = defineProps({
    errors: Object,
    user: Object,
    form: Object,
});

// Calendar value workaround
const departureDate = ref();
const returnDate = ref();
watch(
    departureDate,
    (v) => (form.departureDate = `${v.year}-${v.month}-${v.day}`)
);
watch(returnDate, (v) => (form.returnDate = `${v.year}-${v.month}-${v.day}`));

// Date formatter for calendar
const dateFormatter = new DateFormatter("pt-BR", {
    dateStyle: "long",
});

// Form submit function
function submit() {
    form.clearErrors();
    form.post("/travelRequest/create");
}
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <!-- Dialog header -->
            <DialogHeader>
                <DialogTitle>Novo Pedido de Viagem</DialogTitle>
                <DialogDescription>
                    Criar um novo pedido de viagem.
                </DialogDescription>
            </DialogHeader>

            <!-- Dialog body -->
            <form @submit.prevent="submit" class="grid gap-4 py-4" novalidate>
                <!-- Solicitor (read only) -->
                <div>
                    <!-- Field eror message  -->
                    <span class="text-red-600" v-if="errors?.solicitor">{{
                        errors.solicitor
                    }}</span>

                    <!-- Field -->
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="solicitorName"> Solicitante </Label>
                        <Input
                            id="solicitor"
                            class="col-span-3"
                            type="text"
                            name="solicitorName"
                            v-model="user.name"
                            readonly
                            disabled
                        />
                    </div>
                </div>

                <!-- Destination -->
                <div>
                    <!-- Field error message  -->
                    <span class="text-red-600" v-if="errors?.destination">{{
                        errors.destination
                    }}</span>

                    <!-- Field -->
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="destination"> Destino </Label>
                        <Input
                            id="destination"
                            class="col-span-3"
                            type="text"
                            name="destination"
                            placeholder="Canada, Marrocos..."
                            v-model="form.destination"
                        />
                    </div>
                </div>

                <!-- Departure -->
                <div>
                    <!-- Field eror message  -->
                    <span class="text-red-600" v-if="errors?.departureDate">{{
                        errors.departureDate
                    }}</span>

                    <!-- Field -->
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="departureDate"> Data de ida </Label>
                        <Popover>
                            <PopoverTrigger as-child>
                                <Button
                                    variant="outline"
                                    :class="
                                        cn(
                                            'w-[280px] justify-start text-left font-normal',
                                            !departureDate &&
                                                'text-muted-foreground'
                                        )
                                    "
                                >
                                    <CalendarIcon class="mr-2 h-4 w-4" />
                                    {{
                                        departureDate
                                            ? dateFormatter.format(
                                                  departureDate.toDate(
                                                      getLocalTimeZone()
                                                  )
                                              )
                                            : "Selecione uma data de ida"
                                    }}
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent class="w-auto p-0">
                                <Calendar
                                    v-model="departureDate"
                                    initial-focus
                                />
                            </PopoverContent>
                        </Popover>
                    </div>
                </div>

                <!-- Return -->
                <div>
                    <!-- Field error message  -->
                    <span class="text-red-600" v-if="errors?.returnDate">{{
                        errors.returnDate
                    }}</span>

                    <!-- Field -->
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="returnDate"> Data de volta </Label>
                        <Popover>
                            <PopoverTrigger as-child>
                                <Button
                                    variant="outline"
                                    :class="
                                        cn(
                                            'w-[280px] justify-start text-left font-normal',
                                            !returnDate &&
                                                'text-muted-foreground'
                                        )
                                    "
                                >
                                    <CalendarIcon class="mr-2 h-4 w-4" />
                                    {{
                                        returnDate
                                            ? dateFormatter.format(
                                                  returnDate.toDate(
                                                      getLocalTimeZone()
                                                  )
                                              )
                                            : "Selecione uma data de volta"
                                    }}
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent class="w-auto p-0">
                                <Calendar v-model="returnDate" initial-focus />
                            </PopoverContent>
                        </Popover>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <!-- Field error message  -->
                    <span class="text-red-600" v-if="errors?.status">{{
                        errors.status
                    }}</span>

                    <!-- Field (read only) -->
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="name" class="text-right"> Status </Label>
                        <Select v-model="form.status" :disabled="true">
                            <SelectTrigger class="col-span-3 w-full">
                                <SelectValue placeholder="Select a fruit">
                                    {{
                                        form.status.charAt(0).toUpperCase() +
                                        form.status.slice(1)
                                    }}
                                </SelectValue>
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem value="solicited">
                                        Solicitado
                                    </SelectItem>
                                    <SelectItem value="approved">
                                        Aprovado
                                    </SelectItem>
                                    <SelectItem value="cancelled">
                                        Cancelado
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </div>
                </div>
            </form>

            <!-- Dialog footer -->
            <DialogFooter>
                <!-- Form submit button -->
                <Button @click="submit" class="w-full">
                    Criar novo pedido de viagem
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

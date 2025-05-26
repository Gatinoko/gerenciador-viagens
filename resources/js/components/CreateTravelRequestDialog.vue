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
import { translateAndFormatStatus } from "@/lib/utils";

// Props
const props = defineProps({
    errors: Object,
    user: Object,
    form: Object,
});

// Calendar value workaround
const departureDate = ref();
const returnDate = ref();
watch(
    departureDate,
    (v) => (props.form.departureDate = `${v.year}-${v.month}-${v.day}`)
);
watch(
    returnDate,
    (v) => (props.form.returnDate = `${v.year}-${v.month}-${v.day}`)
);

// Date formatter for calendar
const dateFormatter = new DateFormatter("pt-BR", {
    dateStyle: "long",
});

// Form submit function
function submit() {
    props.form.clearErrors();
    props.form.post("/travelRequest/create");
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

            <!-- Create travel request form -->
            <form @submit.prevent="submit" class="grid gap-1.5 py-4" novalidate>
                <!-- Solicitor field (read only) -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="solicitorName"> Solicitante </Label>
                    <Input
                        id="solicitor"
                        class="col-span-3"
                        type="text"
                        name="solicitorName"
                        v-model="props.user.name"
                        readonly
                        disabled
                    />
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                        >{{ props.errors.solicitor }}</span
                    >
                </div>

                <!-- Destination field -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="destination"> Destino </Label>
                    <Input
                        id="destination"
                        class="col-span-3"
                        type="text"
                        name="destination"
                        placeholder="Canada, Marrocos..."
                        v-model="props.form.destination"
                    />
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                        >{{ props.errors.destination }}</span
                    >
                </div>

                <!-- Departure field -->
                <div class="grid grid-cols-4 gap-0.5">
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
                            <Calendar v-model="departureDate" initial-focus />
                        </PopoverContent>
                        <span
                            class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                            >{{ props.errors.departureDate }}</span
                        >
                    </Popover>
                </div>

                <!-- Return field -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="returnDate"> Data de volta </Label>
                    <Popover>
                        <PopoverTrigger as-child>
                            <Button
                                variant="outline"
                                :class="
                                    cn(
                                        'w-[280px] justify-start text-left font-normal',
                                        !returnDate && 'text-muted-foreground'
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
                        <span
                            class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                            >{{ props.errors.returnDate }}</span
                        >
                    </Popover>
                </div>

                <!-- Status field (read only) -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="name" class="text-right"> Status </Label>
                    <Select v-model="props.form.status" :disabled="true">
                        <SelectTrigger class="col-span-3 w-full">
                            <SelectValue placeholder="Select a fruit">
                                {{
                                    translateAndFormatStatus(props.form.status)
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
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                        >{{ props.errors.status }}</span
                    >
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

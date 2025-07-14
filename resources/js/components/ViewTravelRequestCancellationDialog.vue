<script setup lang="ts">
import { Textarea } from "@/components/ui/textarea";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { computed } from "vue";
import { translateAndFormatStatus } from "@/lib/utils";

const props = defineProps({
    cancellationRequestData: Object,
    cancellationRequestInfoDialogToggle: Boolean,
});
const emits = defineEmits(["update:cancellationRequestInfoDialogToggle"]);

// Computed value from parent ref
const cancellationRequestInfoDialogToggle = computed({
    get: () => props.cancellationRequestInfoDialogToggle,
    set: (v) => emits("update:cancellationRequestInfoDialogToggle", v),
});
</script>

<template>
    <Dialog v-model:open="cancellationRequestInfoDialogToggle">
        <DialogContent class="sm:max-w-[425px]">
            <!-- Dialog header -->
            <DialogHeader>
                <DialogTitle
                    >Informaçoes Sobre Solicitação de Cancelamento
                </DialogTitle>
                <DialogDescription>
                    Informações sobre o solicitação de cancelamento de id
                    {{ props.cancellationRequestData?.id }}, feito por
                    {{
                        props.cancellationRequestData?.travel_request.user.name
                    }}.
                </DialogDescription>
            </DialogHeader>

            <form class="grid gap-1.5 py-4" novalidate>
                <!-- Cancellation request ID field (read only) -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="solicitorId"> ID Solicitação </Label>
                    <Input
                        id="solicitor"
                        class="col-span-3"
                        type="text"
                        v-model="
                            props.cancellationRequestData.travel_request.user.id
                        "
                        name="solicitorId"
                        disabled
                        readonly
                    />
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>

                <!-- Associated request ID field (read only) -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="solicitorName"> ID Pedido Associado </Label>
                    <Input
                        id="solicitor"
                        class="col-span-3"
                        type="text"
                        v-model="
                            props.cancellationRequestData.travel_request.id
                        "
                        name="solicitorName"
                        disabled
                        readonly
                    />
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>

                <!-- Solicitor name field (read only) -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="solicitorName"> Nome do Solicitante </Label>
                    <Input
                        id="solicitor"
                        class="col-span-3"
                        type="text"
                        v-model="
                            props.cancellationRequestData.travel_request.user
                                .name
                        "
                        name="solicitorName"
                        disabled
                        readonly
                    />
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>

                <!-- Status field (read only) -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="name"> Status </Label>
                    <Select :disabled="true">
                        <SelectTrigger class="col-span-3 w-full">
                            <SelectValue class="text-foreground">
                                {{
                                    translateAndFormatStatus(
                                        props.cancellationRequestData?.status
                                    )
                                }}
                            </SelectValue>
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem value="solicited">
                                    Solicited
                                </SelectItem>
                                <SelectItem value="approved">
                                    Approved
                                </SelectItem>
                                <SelectItem value="cancelled">
                                    Cancelled
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>

                <!-- Message -->
                <div class="grid grid-cols-4 gap-0.5">
                    <Label for="message"> Mensagem </Label>
                    <Textarea
                        id="message"
                        class="col-span-3"
                        type="text"
                        v-model="props.cancellationRequestData.message"
                        name="message"
                        readonly
                        disabled
                    />
                    <span
                        class="text-red-600 text-xs h-4 w-full block col-start-2 col-span-3"
                    ></span>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>

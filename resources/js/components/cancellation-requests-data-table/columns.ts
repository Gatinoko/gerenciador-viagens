import DropdownAction from "./CancellationRequestsDataTableDropdown.vue";
import { formatDbDate, translateAndFormatStatus } from "@/lib/utils";
import type { ColumnDef } from "@tanstack/vue-table";
import { h } from "vue";
import type { TravelRequest } from "resources/types/TravelRequest";
import type { User } from "resources/types/User";
import { Button } from "@/components/ui/button";
import { ArrowUpDown, ChevronDown } from "lucide-vue-next";

export const columns: ColumnDef<TravelRequest>[] = [
    {
        accessorKey: "id",
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => [
                    "ID Solicitação",
                    h(ArrowUpDown, { class: "ml-2 h-4 w-4" }),
                ]
            );
        },
        cell: ({ row }) => {
            return h("div", { class: "" }, row.getValue("id"));
        },
    },
    {
        accessorKey: "request_id",
        header: () => h("div", { class: "" }, "ID Pedido Associado"),
        cell: ({ row }) => {
            return h("div", { class: "" }, row.getValue("request_id"));
        },
    },
    {
        accessorKey: "status",
        header: () => h("div", { class: "" }, "Status"),
        cell: ({ row }) => {
            const formattedStatus = translateAndFormatStatus(
                row.getValue("status")
            );
            return h("div", { class: "" }, formattedStatus);
        },
    },
    {
        accessorKey: "message",
        header: () => h("div", { class: "" }, "Mensagem"),
        cell: ({ row }) => {
            return h("div", { class: "" }, row.getValue("message"));
        },
    },
    {
        accessorKey: "actions",
        header: () => h("div", { class: "" }, "Opções"),
        cell: ({ row, table }) => {
            const cancellationRequestInfo = row.original;
            const errors = table.options.meta?.errors;
            return h(
                "div",
                { class: "relative" },
                h(DropdownAction, {
                    cancellationRequestInfo,
                    errors,
                })
            );
        },
    },
];

import DropdownAction from "./DataTableDropdown.vue";
import { formatDbDate, translateAndFormatStatus } from "@/lib/utils";
import type { ColumnDef } from "@tanstack/vue-table";
import { h } from "vue";
import type { TravelRequest } from "@/../types/travelRequest";
import type { User } from "@/../types/user";
import { Button } from "@/components/ui/button";
import { ArrowUpDown, ChevronDown } from "lucide-vue-next";

export const columns: ColumnDef<TravelRequest>[] = [
    {
        accessorKey: "id",
        // header: () => h("div", { class: "" }, "ID Pedido"),
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["ID Pedido", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })]
            );
        },
        cell: ({ row }) => {
            return h("div", { class: "" }, row.getValue("id"));
        },
    },
    {
        accessorKey: "user",
        header: () => h("div", { class: "" }, "Solicitante"),
        cell: ({ row }) => {
            return h("div", { class: "" }, row.getValue<User>("user").name);
        },
    },
    {
        accessorKey: "destination",
        header: () => h("div", { class: "" }, "Destino"),
        cell: ({ row }) => {
            return h("div", { class: "" }, row.getValue("destination"));
        },
    },
    {
        accessorKey: "departure_date",
        header: () => h("div", { class: "" }, "Data de ida"),
        cell: ({ row }) => {
            const formattedDate = formatDbDate(row.getValue("departure_date"));
            return h("div", { class: "" }, formattedDate);
        },
    },
    {
        accessorKey: "return_date",
        header: () => h("div", { class: "" }, "Data de volta"),
        cell: ({ row }) => {
            const formattedDate = formatDbDate(row.getValue("return_date"));
            return h("div", { class: "" }, formattedDate);
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
        accessorKey: "actions",
        header: () => h("div", { class: "" }, "Opções"),
        cell: ({ row, table }) => {
            const travelRequestInfo = row.original;
            const travelRequestUpdateControlsToggle =
                table.options.meta?.travelRequestUpdateControlsToggle;
            return h(
                "div",
                { class: "relative" },
                h(DropdownAction, {
                    travelRequestInfo,
                    travelRequestUpdateControlsToggle,
                })
            );
        },
    },
];

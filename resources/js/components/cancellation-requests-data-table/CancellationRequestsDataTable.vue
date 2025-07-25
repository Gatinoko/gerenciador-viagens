<script setup lang="ts" generic="TData, TValue">
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import {
    Table,
    TableHeader,
    TableRow,
    TableHead,
    TableBody,
    TableCell,
} from "@/components/ui/table";
import {
    FlexRender,
    getCoreRowModel,
    getPaginationRowModel,
    useVueTable,
    type ColumnDef,
    type SortingState,
    type ColumnFiltersState,
    getSortedRowModel,
    getFilteredRowModel,
} from "@tanstack/vue-table";
import { Button } from "@/components/ui/button";
import { valueUpdater } from "../ui/table/utils";
import { computed, ref } from "vue";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { ChevronRight, ChevronLeft } from "lucide-vue-next";

const props = defineProps<{
    columns: ColumnDef<TData, TValue>[];
    data: TData[];
    cancellationRequestUpdateControlsToggle: boolean;
    errors: Object;
}>();
const emits = defineEmits(["update:errors"]);

const errors = computed({
    get: () => props.errors,
    set: (v) => emits("update:errors", v),
});
const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);
const table = useVueTable({
    get data() {
        return props.data;
    },
    get columns() {
        return props.columns;
    },
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, columnFilters),
    getFilteredRowModel: getFilteredRowModel(),
    state: {
        get sorting() {
            return sorting.value;
        },
        get columnFilters() {
            return columnFilters.value;
        },
    },
    meta: {
        cancellationRequestUpdateControlsToggle:
            props.cancellationRequestUpdateControlsToggle,
        errors: errors,
    },
});
</script>

<template>
    <div class="flex items-center py-4 w-full gap-6 h-max">
        <div class="grid gap-0.5 w-full">
            <Label for="destinationFilter">Filtrar por mensagem</Label>
            <Input
                name="destinationFilter"
                placeholder="Tivemos um imprevisto no..."
                :model-value="table.getColumn('message')?.getFilterValue() as string"
                @update:model-value="
                    table.getColumn('message')?.setFilterValue($event)
                "
            />
        </div>
        <div class="flex flex-col gap-0.5 min-w-40 max-w-45">
            <Label for="statusFilter">Filtrar por status</Label>
            <Select
                name="statusFilter"
                class="min-w-3"
                default-value="noFiltering"
                @update:model-value="
                    if ($event !== 'noFiltering')
                        table.getColumn('status')?.setFilterValue($event);
                    else table.getColumn('status')?.setFilterValue(null);
                "
            >
                <SelectTrigger class="col-span-3 w-full">
                    <SelectValue></SelectValue>
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectItem value="noFiltering">
                            Sem filtragem
                        </SelectItem>
                        <SelectItem value="solicited"> Solicitado </SelectItem>
                        <SelectItem value="approved"> Aprovado </SelectItem>
                        <SelectItem value="rejected"> Rejeitado </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>
        <div class="flex gap-1 self-end">
            <Button
                variant="outline"
                :disabled="!table.getCanPreviousPage()"
                @click="table.previousPage()"
            >
                <ChevronLeft class="w-4 h-4" />
            </Button>
            <Button
                variant="outline"
                :disabled="!table.getCanNextPage()"
                @click="table.nextPage()"
            >
                <ChevronRight class="w-4 h-4" />
            </Button>
        </div>
    </div>

    <div class="border shadow-xs rounded-sm">
        <Table>
            <TableHeader>
                <TableRow v-for="headerGroup in table.getHeaderGroups()">
                    <TableHead
                        v-for="header in headerGroup.headers"
                        :key="header.id"
                    >
                        <FlexRender
                            v-if="!header.isPlaceholder"
                            :render="header.column.columnDef.header"
                            :props="header.getContext()"
                        />
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <template v-if="table.getRowModel().rows?.length">
                    <TableRow
                        v-for="row in table.getRowModel().rows"
                        :key="row.id"
                        :data-state="
                            row.getIsSelected() ? 'selected' : undefined
                        "
                    >
                        <TableCell
                            v-for="cell in row.getVisibleCells()"
                            :key="cell.id"
                        >
                            <FlexRender
                                :render="cell.column.columnDef.cell"
                                :props="cell.getContext()"
                            />
                        </TableCell>
                    </TableRow>
                </template>
                <template v-else>
                    <TableRow>
                        <TableCell
                            :colspan="columns.length"
                            class="h-24 text-center"
                        >
                            No results.
                        </TableCell>
                    </TableRow>
                </template>
            </TableBody>
        </Table>
    </div>
</template>

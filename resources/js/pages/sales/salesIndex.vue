<template>
    <!-- Toolbar -->

    <!-- Search & Create Button -->
    <v-layout class="pt-6">
        <v-row class="justify-space-between p-6 pr-8">
            <!-- Search Field -->
            <v-col cols="12" sm="3">
                <v-text-field
                    v-model="useWareHouseRepository.search"
                    label="جستجو"
                    prepend-inner-icon="mdi-magnify"
                    variant="outlined"
                    name="search"
                    density="compact"
                />
            </v-col>

            <!-- Create Button -->
            <div class="btn d-flex gap-4">
                <v-btn color="primary" variant="flat" @click="create"> 
                    جدید
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
            </div>
        </v-row>
    </v-layout>

    <!-- Data Table -->
    <v-app>
        <v-main>
            <v-row>
                <v-col>
                    <v-data-table-server
                        v-model:items-per-page="
                            WareHouseRepository.itemsPerPage
                        "
                        :headers="headers"
                        :items-length="WareHouseRepository.totalItems"
                        :items="WareHouseRepository.sales"
                        :loading="WareHouseRepository.loading"
                        :search="WareHouseRepository.search"
                        item-value="id"
                        item-key="id"
                        hover
                        @update:options="fetchsales"
                    >
                        <!-- Actions Column -->
                        <template v-slot:item.actions="{ item }">
                            <v-menu>
                                <template v-slot:activator="{ props }">
                                    <v-btn
                                        icon="mdi-dots-vertical"
                                        v-bind="props"
                                        variant="text"
                                    />
                                </template>

                                <v-list>
                                    <v-list-item>
                                        <v-list-item-title
                                            class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                            @click="
                                                $router.push({
                                                    name: 'sales.edit',
                                                    params: { id: item.id },
                                                })
                                            "
                                        >
                                            <v-icon color="green"
                                                >mdi-square-edit-outline</v-icon
                                            >
                                            ویرایش
                                        </v-list-item-title>

                                        <v-list-item-title
                                            class="cursor-pointer d-flex gap-3"
                                            @click="deleteItem(item.id)"
                                        >
                                            <v-icon color="red"
                                                >mdi-delete-outline</v-icon
                                            >
                                            حذف کردن
                                        </v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </template>
                    </v-data-table-server>
                </v-col>
            </v-row>
        </v-main>
    </v-app>
</template>

<script setup>
import { onMounted } from "vue";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";

const WareHouseRepository = useWareHouseRepository();

const headers = [
    { title: "نوت", key: "note", sortable: false },
    {title: "تاریخ", key: "date", sortable: false},
    {title: "آیدی مشتری ", key: "customer_id", sortable: false},
    {title: "آیدی حساب", key: "account_id", sortable: false},
    {title: "آیدی استفاده کننده ", key: "user_id", sortable: false},
    {title: "مقدار موجودی", key: "total_amount", sortable: false},
    {title: " تخفیف", key: "discount", sortable: false},
    {title: " مقدار نهایی", key: "final_amount", sortable: false},
    {title: " مقدار پرداختی", key: "paid_amount", sortable: false},
    {title: " مقدار قرض", key: "due_amount", sortable: false},
    {title: " وضعیت پرداخت", key: "payment_status", sortable: false},
    {title: "  بخش", key: "items", sortable: false},


];

import { useRouter } from "vue-router";


const router = useRouter();

const create = () => {
    router.push("./sales/create");
};
const deleteItem = (id) => {
    WareHouseRepository.deletesale(id);
};

const fetchsales = (options) => {
    const { page, itemsPerPage } = options;
    WareHouseRepository.fetchsales({ page, itemsPerPage });
};


</script>

<style scoped>
.all-sales {
    transition: all 0.3s ease-in-out;
}

.all-sales:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.btn v-btn {
    transition: 0.2s;
}

.btn v-btn:hover {
    transform: scale(1.05);
}
</style>

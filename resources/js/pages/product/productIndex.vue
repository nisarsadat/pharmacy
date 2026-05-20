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
                <v-btn
                    color="primary"
                    variant="flat"
                    @click="$router.push({ name: 'products.create' })"
                >
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
                        :items="WareHouseRepository.products"
                        :loading="WareHouseRepository.loading"
                        :search="WareHouseRepository.search"
                        item-value="id"
                        item-key="id"
                        hover
                        @update:options="fetchproductsdata"
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
                                                    name: 'products.edit',
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
    { title: "اسم", key: "name", sortable: false },
    { title: "قیمت اصلی", key: "main_price", sortable: false },
    { title: "قیمت فروش  ", key: "sale_price", sortable: false },
    { title: "مقدار محصول", key: "product_quantity", sortable: false },
    { title: "کارخانه محصول", key: "product_company", sortable: false },
    { title: "تاریخ", key: "date", sortable: false },
    { title: "تاریخ ختم", key: "expire_date", sortable: false },
    { title: "تاریخ محصول", key: "product_date", sortable: false },
    { title: "  آیدی گدام ", key: "warehouse_id", sortable: false },
    { title: "آیدی نوعیت محصول", key: "product_type_id", sortable: false },
    { title: "نوت", key: "note", sortable: false },

    {
        title: "هوشدار انقضای تاریخ ",
        key: "expire_date_alert",
        sortable: false,
    },
    { title: "تاریخ", key: "date", sortable: false },
    { title: "مقدار محصول ", key: "product_amount", sortable: false },
    {title: "عکس ها ", key: "image", sortable: false},
    { title: "action", key: "actions", sortable: false },
];

const deleteItem = (id) => {
    WareHouseRepository.deleteproduct(id);
};

const fetchproductsdata = (options) => {
    const { page, itemsPerPage } = options;
    WareHouseRepository.fetchproducts({ page, itemsPerPage });
};

// onMounted(() => {
//     fetchproducts({ page: 1, itemsPerPage: 5 });
// });
</script>

<style scoped>
.all-product {
    transition: all 0.3s ease-in-out;
}

.all-product :hover {
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

<template>
    <!-- Dialogs -->
    <Update v-if="WareHouseRepository.updateDialog" />
    <Create v-if="WareHouseRepository.createDialog" />

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
                <v-btn color="primary" variant="flat" @click="createPopUp">
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
                        v-model:items-per-page="WareHouseRepository.itemsPerPage"
                        :headers="headers"
                        :items-length="WareHouseRepository.totalItems"
                        :items="WareHouseRepository.warehouses"
                        :loading="WareHouseRepository.loading"
                        :search="WareHouseRepository.search"
                        item-value="id"
                        item-key="id"
                        hover
                        @update:options="fetchwarehouses"
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
                                            @click="editItem(item.id)"
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
import Create from "./createWarehouse.vue";
import Update from "./UpdateWarehouse.vue";

const WareHouseRepository = useWareHouseRepository();

const headers = [
    { title: "اسم", key: "name", sortable: false },
    { title: "شماره صاحب", key: "owner_phone", sortable: false },
    { title: "اسم صاحب", key: "owner_name", sortable: false },
    { title: "نوت", key: "note", sortable: false },
    { title: "عمل", key: "actions", sortable: false },
];

const createPopUp = () => {
    WareHouseRepository.createDialog = true;
};

const deleteItem = (id) => {
    WareHouseRepository.deletewarehouse(id);
};

const editItem = (id) => {
    WareHouseRepository.warehouse = {};
    if (
        !WareHouseRepository.warehouse ||
        Object.keys(WareHouseRepository.warehouse).length === 0
    ) {
        WareHouseRepository.fetchwarehouse(id)
            .then(() => {
                WareHouseRepository.updateDialog = true;
            })
            .catch((error) => console.error("Error fetching data:", error));
    }
};

const Fetchwarehouses = (options) => {
    const { page, itemsPerPage } = options;
    WareHouseRepository.fetchwarehouses({ page, itemsPerPage });
};

onMounted(() => {
    Fetchwarehouses({ page: 1, itemsPerPage: 5 });
});
</script>

<style scoped>
.all-expense {
    transition: all 0.3s ease-in-out;
}

.all-expense:hover {
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

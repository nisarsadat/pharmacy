<template>
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
                    @click="$router.push({ name: 'employees.create' })"
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
                        :items="WareHouseRepository.employees"
                        :loading="WareHouseRepository.loading"
                        :search="WareHouseRepository.search"
                        item-value="id"
                        item-key="id"
                        hover
                        @update:options="fetchemployee"
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
                                            @click="   $router.push({
                                                    name: 'employees.edit',
                                                    params: { id: item.id },
                                                })"
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
    { title: "ولد", key: "father_name", sortable: false },
    { title: "تخلص", key: "last_name", sortable: false },
    { title: "عکس", key: "image", sortable: false },
    { title: "شماره تذکره ", key: "tazkira_number", sortable: false },
    { title: "شماره تماس ", key: "phone_number", sortable: false },
    { title: "شماره واتساپ", key: "whatsapp_number", sortable: false },
    { title: "جنسیت", key: "gender", sortable: false },
    { title: "شفت از", key: "shift_from", sortable: false },
    { title: " شفت تا", key: "shift_to", sortable: false },
    { title: "مقدار معاش", key: "salary_amount", sortable: false },
    {
        title: "مقدار معاش روزانه",
        key: "salary_amount_per_day",
        sortable: false,
    },
    { title: "نوع وظیفه", key: "job_type", sortable: false },
    { title: "تاریخ ورودی", key: "entry_date", sortable: false },
    { title: "تاریخ خروجی ", key: "leave_date", sortable: false },
    { title: "روز کاری ", key: "work_days", sortable: false },
];

const deleteItem = (id) => {
    WareHouseRepository.deleteemployee(id);
};

const editItem = (id) => {
    WareHouseRepository.employees = {};
    if (
        !WareHouseRepository.employees ||
        Object.keys(WareHouseRepository.employees).length === 0
    ) {
        WareHouseRepository.fetchemployee(id)
            .then(() => {
                WareHouseRepository.updateDialog = true;
            })
            .catch((error) => console.error("Error fetching data:", error));
    }
};

const fetchemployee = (options) => {
    const { page, itemsPerPage } = options;
    WareHouseRepository.fetchemployees({ page, itemsPerPage });
};

onMounted(() => {
    fetchemployee({ page: 1, itemsPerPage: 5 });
});
</script>

<style scoped>
.all-employee {
    transition: all 0.3s ease-in-out;
}

.all-employee:hover {
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

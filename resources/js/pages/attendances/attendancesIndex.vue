<template>
    <!-- Search & Create Button -->
    <v-layout class="pt-6">
        <v-row class="justify-space-between p-6 pr-8">
            <!-- Search Field -->
            <v-col cols="12" sm="3">
                <v-text-field
                    v-model="usePeopleRepository.search"
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
                    @click="$router.push({ name: 'attendances.create' })"
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
                        v-model:items-per-page="PeopleRepository.itemsPerPage
                        "
                        :headers="headers"
                        :items-length="PeopleRepository.totalItems"
                        :items="PeopleRepository.attendances"
                        :loading="PeopleRepository.loading"
                        :search="PeopleRepository.search"
                        item-value="id"
                        item-key="id"
                        hover
                        @update:options="fetchattendance"
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
                                                    name: 'attendances.edit',
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
import { usePeopleRepository } from "../../repositories/PeopleRepository";

const PeopleRepository = usePeopleRepository();

const headers = [
    {title: " آیدی کارگر", key: "employee_id", sortable:false},
    {title: " تاریخ ", key: "date", sortable:false},
    {title: "   وضعیت", key: "status", sortable:false},
   
  
];

const deleteItem = (id) => {
   PeopleRepository.deleteattendance(id);
};

const editItem = (id) => {
   PeopleRepository.attendances = {};
    if (
        !PeopleRepository.attendances ||
        Object.keys(PeopleRepository.attendances).length === 0
    ) {
       PeopleRepository.fetchattendances(id)
            .then(() => {
               PeopleRepository.updateDialog = true;
            })
            .catch((error) => console.error("Error fetching data:", error));
    }
};

const fetchattendances = (options) => {
    const { page, itemsPerPage } = options;
   PeopleRepository.fetchattendances({ page, itemsPerPage });
};

onMounted(() => {
    fetchattendances({ page: 1, itemsPerPage: 5 });
});
</script>

<style scoped>
.all-attendances {
    transition: all 0.3s ease-in-out;
}

.all-attendances:hover {
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

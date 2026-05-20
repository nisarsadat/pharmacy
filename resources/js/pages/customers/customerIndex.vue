<template>
    <!-- Toolbar -->
    <div class="mx-3">
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
                            v-model:items-per-page="
                                WareHouseRepository.itemsPerPage
                            "
                            :headers="headers"
                            :items-length="WareHouseRepository.totalItems"
                            :items="WareHouseRepository.customers"
                            :loading="WareHouseRepository.loading"
                            :search="WareHouseRepository.search"
                            item-value="id"
                            item-key="id"
                            hover
                            @update:options="fetchcustomers"
                        >
                            <template v-slot:item.image="{ item }">
                                <v-avatar
                                    size="45"
                                    class="image-avatar elevation-2"
                                    @click="openImage(item.image)"
                                >
                                    <v-img
                                        v-if="item?.image"
                                        :src="item.image"
                                        cover
                                    />
                                </v-avatar>
                            </template>
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
                                                        name: 'customers.edit',
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
                        <v-dialog v-model="imageDialog" max-width="600">
                            <v-card class="pa-2">
                                <v-img
                                    :src="selectedImage"
                                    max-height="500"
                                    contain
                                />
                            </v-card>
                        </v-dialog>
                    </v-col>
                </v-row>
            </v-main>
        </v-app>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useWareHouseRepository } from "../../repositories/WareHouseRepository";
    
const imageDialog = ref(false);
const selectedImage = ref(null);

const openImage = (img) => {
    selectedImage.value = img;
    imageDialog.value = true;
};
const WareHouseRepository = useWareHouseRepository();

const headers = [
    { title: " عکس", key: "image", sortable: false },
    { title: "اسم", key: "name", sortable: false },
    { title: "تخلص ", key: "last_name", sortable: false },
    { title: "ولد ", key: "father_name", sortable: false },
    { title: "شماره تماس ", key: "phone_number", sortable: false },
    { title: " شماره تذکره ", key: "tazkira_number", sortable: false },
    { title: "نوت", key: "note", sortable: false },
    { title: "action", key: "actions", sortable: false },
];

import { useRouter } from "vue-router";

const router = useRouter();

const createPopUp = () => {
    router.push("./customers/create");
};
const deleteItem = (id) => {
    WareHouseRepository.deletecustomer(id);
};

const fetchcustomers = (options) => {
    const { page, itemsPerPage } = options;
    WareHouseRepository.fetchcustomers({ page, itemsPerPage });
};

onMounted(() => {
    fetchcustomers({ page: 1, itemsPerPage: 5 });
});
</script>

<style scoped>
.all-customers {
    transition: all 0.3s ease-in-out;
}

.all-customers:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.btn v-btn {
    transition: 0.2s;
}

.btn v-btn:hover {
    transform: scale(1.05);
}
.imagepart {
    border-radius: 50%;
}
.image-avatar {
    transition: 0.2s ease;
    cursor: pointer;
}

.image-avatar:hover {
    transform: scale(1.1);
}
</style>

<template>
    <!-- Dialogs -->
    <Update v-if="AccountRepository.updateDialog" />
    <Create v-if="AccountRepository.createDialog" />

    <!-- Toolbar -->

    <!-- Search & Create Button -->
    <v-layout class="pt-6">
        <v-row class="justify-space-between p-6 pr-8">
            <!-- Search Field -->
            <v-col cols="12" sm="3">
                <v-text-field
                    v-model="AccountRepository.search"
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
                        v-model:items-per-page="AccountRepository.itemsPerPage"
                        :headers="headers"
                        :items-length="AccountRepository.totalItems"
                        :items="AccountRepository.accounts"
                        :loading="AccountRepository.loading"
                        :search="AccountRepository.search"
                        item-value="id"
                        item-key="id"
                        hover
                        @update:options="fetchAccounts"
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
import { useAccountRepository } from "../../repositories/AccountRepository";
import Create from "./CreateAccount.vue";
import Update from "./UpdateAccount.vue";

const AccountRepository = useAccountRepository();

const headers = [
    { title: "نام", key: "name", sortable: false },
    { title: "قیمت", key: "price", sortable: false },
    { title: "تاریخ", key: "date", sortable: false },
    { title: "نکته", key: "note", sortable: false },
    { title: "نوعیت اکونت", key: "account_type", sortable: false },
    { title: "عمل", key: "actions", sortable: false, align: "end" },
];

const createPopUp = () => {
    AccountRepository.createDialog = true;
};

const deleteItem = (id) => {
    AccountRepository.deleteAccount(id);
};

const editItem = (id) => {
    AccountRepository.account = {};
    if (
        !AccountRepository.account ||
        Object.keys(AccountRepository.account).length === 0
    ) {
        AccountRepository.fetchAccount(id)
            .then(() => {
                AccountRepository.updateDialog = true;
            })
            .catch((error) => console.error("Error fetching data:", error));
    }
};

const fetchAccounts = (options) => {
    const { page, itemsPerPage } = options;
    AccountRepository.fetchAccounts({ page, itemsPerPage });
};

onMounted(() => {
    fetchAccounts({ page: 1, itemsPerPage: 5 });
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

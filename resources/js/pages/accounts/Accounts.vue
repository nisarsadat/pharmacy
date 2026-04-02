<template>
    <Update v-if="AccountRepository.updateDialog" />
    <Create v-if="AccountRepository.createDialog" />
    <div class="mt-4">
        <div class="all-expense rounded-xl w-full bg-white">
            <toolbar title="Setting-" subtitle="Accounts" />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <v-layout class="pt-6">
                <v-row class="justify-space-between p-6 pr-8">
                    <v-col cols="12" sm="3">
                        <v-text-field
                            v-model="AccountRepository.search"
                            label="جستجو"
                            prepend-inner-icon="mdi-magnify"
                            variant="outlined"
                            name="search"
                            density="compact"
                        ></v-text-field>
                    </v-col>
                    <div class="btn d-flex gap-4">
                        <v-btn
                            color="primary"
                            variant="flat"
                            @click="createPopUp"
                        >
                            جدید
                        </v-btn>
                    </div>
                </v-row>
            </v-layout>

            <div class="overflow-x-auto pb-10 mx-5">
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
                                    @update:options="fetchAccounts"
                                    :item-key="AccountRepository.accounts"
                                    itemKey="id"
                                    hover
                                >
                                    <template
                                        v-slot:item.actions="{ item }"
                                        class="right"
                                    >
                                        <v-menu>
                                            <template
                                                v-slot:activator="{ props }"
                                            >
                                                <v-btn
                                                    icon="mdi-dots-vertical"
                                                    v-bind="props"
                                                    variant="text"
                                                ></v-btn>
                                            </template>

                                            <v-list>
                                                <v-list-item>
                                                    <v-list-item-title
                                                        @click="editItem(item.id)"
                                                        class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                    >
                                                        <v-icon color="green"
                                                            >mdi-square-edit-outline</v-icon
                                                        >
                                                        Edit
                                                    </v-list-item-title>

                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3"
                                                        @click="deleteItem(item.id)"
                                                    >
                                                        <v-icon color="red"
                                                            >mdi-delete-outline</v-icon
                                                        >
                                                        Delete
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
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useAccountRepository } from "../../repositories/AccountRepository";
import Create from "./CreateAccount.vue";
import Update from "./UpdateAccount.vue";

let AccountRepository = useAccountRepository();

const headers = [
    { title: "نام", key: "name", sortable: false },
    { title: "PRICE", key: "price", sortable: false },
    { title: "DATE", key: "date", sortable: false },
    { title: "NOTE", key: "note", sortable: false },
    { title: "ACCOUNT TYPE", key: "account_type", sortable: false },
    { title: "Action", key: "actions", sortable: false, align: "end" },
];

const createPopUp = () => {
    AccountRepository.createDialog = true;
};

const deleteItem = (id) => {
    AccountRepository.deleteAccount(id);
};

const editItem = (id) => {
    AccountRepository.account = {};
    if (!AccountRepository.account || Object.keys(AccountRepository.account).length === 0) {
        AccountRepository.fetchAccount(id)
            .then(() => {
                AccountRepository.updateDialog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
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
<template>
    <Update v-if="MoneyAccountRepository.updateDailog" />
    <Create v-if="MoneyAccountRepository.createDailog" />
    <CreateTransferAccount v-if="MoneyAccountRepository.createDailogTransfer" />
    <div class="mt-4">
        <div class="all-expense rounded-xl w-full bg-white">
            <toolbar title="Setting-" subtitle="Money Account" />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <v-layout class="pt-6">
                <v-row class="justify-space-between p-6 pr-8">
                    <v-col cols="12" sm="3">
                        <v-text-field
                            v-model="MoneyAccountRepository.Search"
                            label="Search"
                            prepend-inner-icon="mdi-magnify"
                            variant="outlined"
                            name="search"
                            density="compact"
                        ></v-text-field>
                    </v-col>
                    <div class="btn d-flex gap-4">
                        <v-btn
                            variant="outlined"
                            color="primary"
                            @click="createPopUpTransfer"
                            >Transfer <v-icon> mdi-cash</v-icon></v-btn
                        >
                        <v-btn
                            color="primary"
                            variant="flat"
                            @click="createPopUp"
                        >
                            Create
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
                                    v-model:items-per-page="
                                        MoneyAccountRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="
                                        MoneyAccountRepository.totalItems
                                    "
                                    :items="MoneyAccountRepository.accounts"
                                    :loading="MoneyAccountRepository.loading"
                                    :search="
                                        MoneyAccountRepository.ServiceSearch
                                    "
                                    item-value="id"
                                    @update:options="
                                        MoneyAccountRepository.FetchAccountsData
                                    "
                                    :item-key="MoneyAccountRepository.accounts"
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
                                                        @click="
                                                            editItem(item.id)
                                                        "
                                                        class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                    >
                                                        <v-icon color="green"
                                                            >mdi-square-edit-outline</v-icon
                                                        >
                                                        Edit
                                                    </v-list-item-title>

                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3"
                                                        @click="
                                                            deleteItem(item.id)
                                                        "
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
import { useMoneyAccountRepository } from "../../store/MoneyAccountRepository ";
import Create from "./Create.vue";
import Update from "./Update.vue";
import CreateTransferAccount from "./CreateTransferAccount.vue";
import Toolbar from "../../Component/UI/Toolbar.vue";
import Search from "../../Component/UI/Search.vue";
import CreateButton from "../../Component/UI/CreateButton.vue";
let MoneyAccountRepository = useMoneyAccountRepository();

const headers = [
    { title: "MONEY ACCOUNT", key: "name", sortable: false },
    { title: "AMOUNT", key: "price", sortable: false },

    { title: "Action", key: "actions", sortable: false, align: "end" },
];

const createPopUp = () => {
    MoneyAccountRepository.createDailog = true;
};
const createPopUpTransfer = () => {
    MoneyAccountRepository.createDailogTransfer = true;
};
const deleteItem = (id) => {
    MoneyAccountRepository.DeleteAccount(id);
};
const editItem = (id) => {
    MoneyAccountRepository.wharehouse = {};
    if (Object.keys(MoneyAccountRepository.account).length === 0) {
        MoneyAccountRepository.FetchAccountData(id)
            .then(() => {
                // Data has been fetched successfully, now set dialog to true
                MoneyAccountRepository.updateDailog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
                // Display  message
            });
    }
    console.log("man of the mutch");
};
</script>

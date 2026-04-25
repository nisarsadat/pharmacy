<template>
    <!-- Dialogs -->
    <Update v-if="AccountRepository.updateDialog" />
    <Create v-if="AccountRepository.createDialog" />
    <div>
        <!-- Header -->
        <v-toolbar
            class="account-toolbar px-4 px-md-6"
            color="primary"
            density="comfortable"
            flat
        >
            <v-toolbar-title class="text-white font-weight-bold">
                مدیریت اکونت‌ها
            </v-toolbar-title>

            <v-spacer />

            <v-chip class="ml-2" color="white" variant="tonal" size="small">
                {{ AccountRepository.totalItems }} مورد
            </v-chip>
        </v-toolbar>

        <!-- Controls -->
        <div class="pa-4 pa-md-6 pb-2">
            <v-row align="center" justify="space-between" class="ga-3">
                <v-col cols="12" sm="6" md="4" lg="3">
                    <v-text-field
                        v-model="AccountRepository.search"
                        label="جستجو"
                        prepend-inner-icon="mdi-magnify"
                        variant="outlined"
                        density="comfortable"
                        hide-details
                        class="search-field"
                        clearable
                    />
                </v-col>

                <v-col
                    cols="12"
                    sm="6"
                    md="4"
                    lg="3"
                    class="d-flex justify-sm-end"
                >
                    <v-btn
                        color="primary"
                        size="large"
                        class="create-btn px-5"
                        variant="flat"
                        @click="createPopUp"
                    >
                        <v-icon start>mdi-plus</v-icon>
                        جدید
                    </v-btn>
                </v-col>
            </v-row>
        </div>

        <v-divider />

        <!-- Table -->
        <v-card-text class="pa-0">
            <v-data-table-server
                v-model:items-per-page="AccountRepository.itemsPerPage"
                class="account-table"
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
                <template v-slot:item.actions="{ item }">
                    <v-menu location="bottom end">
                        <template v-slot:activator="{ props }">
                            <v-btn
                                icon="mdi-dots-vertical"
                                v-bind="props"
                                variant="text"
                                density="comfortable"
                                class="action-trigger"
                            />
                        </template>

                        <v-list class="action-menu py-2" min-width="180">
                            <v-list-item
                                class="action-item"
                                @click="editItem(item.id)"
                            >
                                <template #prepend>
                                    <v-icon color="green"
                                        >mdi-square-edit-outline</v-icon
                                    >
                                </template>
                                <v-list-item-title>ویرایش</v-list-item-title>
                            </v-list-item>

                            <v-list-item
                                class="action-item"
                                @click="deleteItem(item.id)"
                            >
                                <template #prepend>
                                    <v-icon color="red"
                                        >mdi-delete-outline</v-icon
                                    >
                                </template>
                                <v-list-item-title>حذف کردن</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </template>
            </v-data-table-server>
        </v-card-text>
    </div>
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
.account-page {
    background: linear-gradient(180deg, #f6f8fc 0%, #eef3f9 100%);
    min-height: 100vh;
}

.account-shell {
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.06);
    backdrop-filter: blur(8px);
}

.account-toolbar {
    background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
}

.search-field :deep(.v-field) {
    border-radius: 14px;
}

.create-btn {
    border-radius: 14px;
    text-transform: none;
    font-weight: 600;
    letter-spacing: 0;
    box-shadow: 0 10px 20px rgba(25, 118, 210, 0.25);
}

.create-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 14px 26px rgba(25, 118, 210, 0.3);
}

.account-table :deep(.v-data-table__wrapper) {
    border-radius: 0 0 20px 20px;
}

.account-table :deep(thead th) {
    background: #f8fafc;
    font-weight: 700;
    color: #334155;
    white-space: nowrap;
}

.account-table :deep(tbody tr:hover) {
    background: rgba(25, 118, 210, 0.04);
}

.account-table :deep(td),
.account-table :deep(th) {
    padding-top: 16px;
    padding-bottom: 16px;
}

.action-trigger {
    border-radius: 12px;
}

.action-trigger:hover {
    background: rgba(25, 118, 210, 0.08);
}

.action-menu {
    border-radius: 16px;
}

.action-item {
    border-radius: 12px;
    margin: 4px 8px;
}

.action-item:hover {
    background: rgba(0, 0, 0, 0.04);
}
</style>

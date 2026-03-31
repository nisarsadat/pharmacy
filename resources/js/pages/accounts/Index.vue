<template>
  <div>
    <!-- Search + Add -->
    <div class="d-flex justify-space-between mb-4">
      <v-text-field
        v-model="search"
        label="جستجو"
        prepend-inner-icon="mdi-magnify"
        variant="outlined"
        density="compact"
      />
      
      <v-btn color="primary" @click="openCreate">
        افزودن حساب
      </v-btn>
    </div>

    <!-- Table -->
    <v-data-table-server
      v-model:items-per-page="itemsPerPage"
      :headers="headers"
      :items="serverItems"
      :items-length="totalItems"
      :loading="loading"
      :search="search"
      item-value="id"
      @update:options="loadItems"
    >
      <template #item.actions="{ item }">
        <v-btn icon @click="openEdit(item)">
          ✏️
        </v-btn>
        <v-btn icon color="red" @click="deleteItem(item.id)">
          🗑️
        </v-btn>
      </template>
    </v-data-table-server>

    <!-- Dialog -->
    <AccountForm
      v-model="dialog"
      :editedItem="editedItem"
      @saved="loadItems({ page: 1, itemsPerPage })"
    />
  </div>
</template>

<script setup>
import { ref } from "vue";
import accountRepository from "@/repositories/accountRepository";
import AccountForm from "./AccountForm.vue";

const itemsPerPage = ref(5);
const headers = ref([
  { title: "ID", key: "id" },
  { title: "نام", key: "name" },
  { title: "ایمیل", key: "email" },
  { title: "عملیات", key: "actions", sortable: false },
]);

const search = ref("");
const serverItems = ref([]);
const loading = ref(false);
const totalItems = ref(0);

const dialog = ref(false);
const editedItem = ref(null);

function loadItems({ page, itemsPerPage }) {
  loading.value = true;

  accountRepository
    .getAll({
      page,
      per_page: itemsPerPage,
      search: search.value,
    })
    .then((res) => {
      serverItems.value = res.data.data;
      totalItems.value = res.data.total;
    })
    .finally(() => {
      loading.value = false;
    });
}

function openCreate() {
  editedItem.value = null;
  dialog.value = true;
}

function openEdit(item) {
  editedItem.value = item;
  dialog.value = true;
}

function deleteItem(id) {
  if (confirm("حذف شود؟")) {
    accountRepository.delete(id).then(() => {
      loadItems({ page: 1, itemsPerPage: itemsPerPage.value });
    });
  }
}
</script>
<template>
  <v-app>
    <!-- Navigation Drawer -->
    <v-navigation-drawer
      v-model="drawer"
      app
      permanent
      width="250"
      class="bg-deep-purple darken-3"
    >
      <v-list nav v-model:opened="openGroups">

        <!-- Home item -->
        <v-list-item prepend-icon="mdi-home" :to="'/'" title="خانه" link></v-list-item>
        <v-list-item prepend-icon="mdi-warehouse" :to="'/warehouse'" title="گدام" link></v-list-item>

        <!-- Finance parent group -->
        <v-list-group value="Finance">
          <template #activator="{ props }">
            <v-list-item v-bind="props" prepend-icon="mdi-cash" title="Finance"></v-list-item>
          </template>

          <!-- Finance sub-items -->
          <v-list-item
            v-for="(route, i) in financeRoutes"
            :key="i"
            :prepend-icon="route.icon"
            :title="route.meta.title"
            :to="route.path"
            link
          ></v-list-item>
        </v-list-group>

      </v-list>

      <v-spacer></v-spacer>

    
    </v-navigation-drawer>

    <!-- Main content -->
    <v-main>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const drawer = ref(true)
const openGroups = ref(['Finance']) // initially open Finance

const router = useRouter()


const financeRoutes = [
  { path: "/accounts", name: "Accounts", meta: { title: "حساب‌ها" }, icon: "mdi-account" },
  { path: "/expense-category", name: "Expense-Category", meta: { title: "کتگوری مصارفات" }, icon: "mdi-book" },
  { path: "/expenses", name: "Expenses", meta: { title: "مصارفات" }, icon: "mdi-book-outline" },
  { path: "/Owner-pickup", name: "Owner-Pickup", meta: { title: "برداشت صاحب" }, icon: "mdi-account" },
]
</script>

<style>
.v-list-item-title {
  font-weight: 500;
}
</style>
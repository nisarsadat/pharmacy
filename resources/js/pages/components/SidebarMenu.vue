<template>
    <v-navigation-drawer
        v-model="drawer"
        app
        permanent
        location="right"
        width="260"
        class=" text-white"
        color="primary"
        elevation="1"
        border
    >
        <v-divider class="mb-3"></v-divider>

        <v-list
            nav
            v-model:opened="openGroups"
            class="px-1"
            density="comfortable"
            dir="rtl"
        >
            <v-list-item
                prepend-icon="mdi-home"
                :to="'/'"
                title="خانه"
                link
                class="rounded-xl mb-1"
                color="text-white"
            ></v-list-item>

            <v-divider class="my-2"></v-divider>

            <v-list-item
                prepend-icon="mdi-warehouse"
                :to="'/warehouse'"
                title="گدام"
                link
                class="rounded-xl mb-1"
            ></v-list-item>

            <v-list-item
                prepend-icon="mdi-package-variant-closed"
                :to="'/product-types'"
                title="نوع پرودکت"
                link
                class="rounded-xl mb-1"
            ></v-list-item>

            <v-list-item
                prepend-icon="mdi-package-variant"
                :to="'/products'"
                title="پرودکت"
                link
                class="rounded-xl mb-1"
            ></v-list-item>

            <v-divider class="my-2"></v-divider>

            <v-list-item
                prepend-icon="mdi-account-group"
                :to="'/customers'"
                title="مشتری"
                link
                class="rounded-xl mb-1"
            ></v-list-item>

            <v-list-item
                prepend-icon="mdi-sale"
                :to="'/sales'"
                title="فروشات"
                link
                class="rounded-xl mb-1"
            ></v-list-item>

            <v-divider class="my-2"></v-divider>

            <v-list-item
                prepend-icon="mdi-account-group"
                :to="'/employees'"
                title="کارمندان"
                link
                class="rounded-xl mb-1"
            ></v-list-item>

            <v-list-item
                prepend-icon="mdi-account-check"
                :to="'/attendances'"
                title="حاضری"
                link
                class="rounded-xl mb-1"
            ></v-list-item>

            <v-list-group value="Finance">
                <template #activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        prepend-icon="mdi-cash"
                        title="بخش مالی"
                        class="font-weight-bold text-white"
                    ></v-list-item>
                </template>

                <v-list-item
                    v-for="(route, i) in financeRoutes"
                    :key="i"
                    :prepend-icon="route.icon"
                    :title="route.meta.title"
                    :to="route.path"
                    link
                    class="rounded-xl ml-4 mb-1"
                ></v-list-item>
            </v-list-group>

            <v-list-item
                prepend-icon="mdi-account-plus"
                :to="'/users'"
                title="کاربران"
                link
                class="rounded-xl mb-1"
            ></v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script setup>
import { ref } from "vue";

const drawer = ref(true);
const openGroups = ref(["Finance"]);

const financeRoutes = [
    {
        path: "/accounts",
        name: "Accounts",
        meta: { title: "حساب‌ها" },
        icon: "mdi-account",
    },
    {
        path: "/expense-category",
        name: "Expense-Category",
        meta: { title: "کتگوری مصارفات" },
        icon: "mdi-book",
    },
    {
        path: "/expenses",
        name: "Expenses",
        meta: { title: "مصارفات" },
        icon: "mdi-book-outline",
    },
    {
        path: "/Owner-pickup",
        name: "Owner-Pickup",
        meta: { title: "برداشت صاحب" },
        icon: "mdi-account",
    },
];
</script>

<style>
.v-list-item-title {
    font-weight: 500;
}
</style>
<template>
    <v-app>
        <!-- Navigation Drawer -->
        <v-navigation-drawer
            v-model="drawer"
            app
            permanent
            width="260"
            class="bg-deep-purple-darken-4 text-white"
            elevation="6"
            border
        >
            <!-- Header -->
            <v-sheet class="pa-4 pt-6 bg-transparent">
                <div
                    class="text-subtitle-1 font-weight-medium text-white text-center"
                >
                    سیستم مدیریت فروش
                </div>
            </v-sheet>

            <v-divider class="mb-3"></v-divider>

            <v-list
                nav
                v-model:opened="openGroups"
                class="px-1"
                density="comfortable"
            >
                <!-- Home item -->
                <v-list-item
                    prepend-icon="mdi-home"
                    :to="'/'"
                    title="خانه"
                    link
                    class="rounded-xl mb-1"
                    color="deep-purple-lighten-2"
                ></v-list-item>

                <v-divider class="my-2"></v-divider>

                <!-- Warehouse & Products -->
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

                <!-- Customers & Sales -->
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

                <!-- Employees & Attendance -->
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

                <v-divider class="my-2"></v-divider>

                <!-- Finance parent group -->
                <v-list-group value="Finance">
                    <template #activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            prepend-icon="mdi-cash"
                            title="بخش مالی"
                            class="font-weight-bold text-deep-purple-lighten-1"
                        ></v-list-item>
                    </template>

                    <!-- Finance sub-items -->
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
            </v-list>

            <!-- Push footer to bottom -->
            <v-spacer></v-spacer>

            <!-- Footer -->
            <v-sheet
                class="pa-3 text-center bg-transparent text-white text-caption"
            >
                سیستم فروش &nbsp;·&nbsp; 2026
            </v-sheet>
        </v-navigation-drawer>
    </v-app>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const drawer = ref(true);
const openGroups = ref(["Finance"]); // initially open Finance

const router = useRouter();

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

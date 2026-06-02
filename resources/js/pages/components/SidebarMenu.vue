<template>
    <v-navigation-drawer
        v-model="drawer"
        app
        permanent
        location="right"
        width="180"
        class="custom-sidebar"
        color="white"
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
            <!-- Home -->
            <v-list-item :to="'/'" link class="menu-item">
                <div class="menu-content">
                    <v-icon>mdi-home</v-icon>
                    <span>خانه</span>
                </div>
            </v-list-item>

            <v-divider class="my-2"></v-divider>

            <!-- Warehouse -->
            <v-list-item :to="'/warehouse'" link class="menu-item">
                <div class="menu-content">
                    <v-icon>mdi-warehouse</v-icon>
                    <span>گدام</span>
                </div>
            </v-list-item>

            <!-- Product Type -->
            <v-list-item :to="'/product-types'" link class="menu-item">
                <div class="menu-content">
                    <v-icon>mdi-package-variant-closed</v-icon>
                    <span>نوع محصول </span>
                </div>
            </v-list-item>

            <!-- Products -->
            <v-list-item :to="'/products'" link class="menu-item">
                <div class="menu-content">
                    <v-icon>mdi-package-variant</v-icon>
                    <span>محصول</span>
                </div>
            </v-list-item>

            <v-divider class="my-2"></v-divider>

            <!-- Customers -->
            <v-list-item :to="'/customers'" link class="menu-item">
                <div class="menu-content">
                    <v-icon>mdi-account-group</v-icon>
                    <span>مشتری</span>
                </div>
            </v-list-item>

            <!-- Sales -->
            <v-list-item :to="'/sales'" link class="menu-item">
                <div class="menu-content">
                    <v-icon>mdi-sale</v-icon>
                    <span>فروشات</span>
                </div>
            </v-list-item>

            <v-divider class="my-2"></v-divider>

            <!-- Employees -->
            <v-list-item :to="'/employees'" link class="menu-item">
                <div class="menu-content">
                    <v-icon>mdi-account-group</v-icon>
                    <span>کارمندان</span>
                </div>
            </v-list-item>

            <!-- Attendance -->
            <v-list-item :to="'/attendances'" link class="menu-item">
                <div class="menu-content">
                    <v-icon>mdi-account-check</v-icon>
                    <span>حاضری</span>
                </div>
            </v-list-item>

            <!-- Finance -->
            <v-list-group value="Finance">
                <template #activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        class="menu-item"
                    >
                        <div class="menu-content">
                            <v-icon>mdi-cash</v-icon>
                            <span>بخش مالی</span>
                        </div>
                    </v-list-item>
                </template>

                <v-list-item
                    v-for="(route, i) in financeRoutes"
                    :key="i"
                    :to="route.path"
                    link
                    class="finance-item"
                >
                    <template #prepend>
                        <v-icon>{{ route.icon }}</v-icon>
                    </template>

                    <v-list-item-title>
                        {{ route.meta.title }}
                    </v-list-item-title>
                </v-list-item>
            </v-list-group>

            <!-- Users -->
            <v-list-item :to="'/users'" link class="menu-item">
                <div class="menu-content">
                    <v-icon>mdi-account-plus</v-icon>
                    <span>کاربران</span>
                </div>
            </v-list-item>
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
.custom-sidebar {
    border-left: 1px solid #dcdcdc !important;
}

.menu-item {
    min-height: 110px !important;
    border: 1px solid #dcdcdc;
    margin-bottom: 0 !important;
    border-radius: 0 !important;
    position: relative;
    padding: 0 !important;
}

.menu-content {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 10px;
    text-align: center;
}

.menu-content .v-icon {
    font-size: 38px !important;
    color: #0f2747;
}

.menu-content span {
    font-size: 20px;
    font-weight: 500;
    color: #0f2747;
}

.v-list-item--active::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 0;
    border-bottom: 40px solid #4d7cff;
    border-right: 40px solid transparent;
}

.finance-item {
    min-height: 60px !important;
}
</style>
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

        <v-list nav class="px-1" density="comfortable" dir="rtl">
            <!-- Home -->
            <!-- Home -->
            <v-list-item to="/" exact class="menu-item">
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

            <!-- Product Types -->
            <v-list-item to="/product-types" class="menu-item">
                <div class="menu-content">
                    <v-icon>mdi-shape</v-icon>
                    <span>نوعیت محصول</span>
                </div>
            </v-list-item>

            <!-- Product -->
            <v-menu open-on-hover location="left" offset="10">
                <template #activator="{ props }">
                    <v-list-item v-bind="props" class="menu-item">
                        <div class="menu-content">
                            <v-icon>mdi-package-variant</v-icon>
                            <span>محصول</span>
                        </div>
                    </v-list-item>
                </template>

                <v-card min-width="220">
                    <v-list>
                        <v-list-item to="/products">
                            <v-list-item-title>
                                لیست محصولات
                            </v-list-item-title>
                        </v-list-item>

                        <v-list-item to="/products/create">
                            <v-list-item-title> ایجاد محصول </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>

            <v-divider class="my-2"></v-divider>

            <!-- Customers -->
            <v-menu open-on-hover location="left" offset="10">
                <template #activator="{ props }">
                    <v-list-item v-bind="props" class="menu-item">
                        <div class="menu-content">
                            <v-icon>mdi-account-group</v-icon>
                            <span>مشتری</span>
                        </div>
                    </v-list-item>
                </template>

                <v-card min-width="220">
                    <v-list>
                        <v-list-item to="/customers">
                            <v-list-item-title>
                                لیست مشتریان
                            </v-list-item-title>
                        </v-list-item>

                        <v-list-item to="/customers/create">
                            <v-list-item-title> ایجاد مشتری </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>

            <!-- Sales -->
            <v-menu open-on-hover location="left" offset="10">
                <template #activator="{ props }">
                    <v-list-item v-bind="props" class="menu-item">
                        <div class="menu-content">
                            <v-icon>mdi-sale</v-icon>
                            <span>فروشات</span>
                        </div>
                    </v-list-item>
                </template>

                <v-card min-width="220">
                    <v-list>
                        <v-list-item to="/sales">
                            <v-list-item-title> لیست فروشات </v-list-item-title>
                        </v-list-item>

                        <v-list-item to="/sales/create">
                            <v-list-item-title> ایجاد فروش </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>

            <v-divider class="my-2"></v-divider>

            <!-- Employees -->
            <v-menu open-on-hover location="left" offset="10">
                <template #activator="{ props }">
                    <v-list-item v-bind="props" class="menu-item">
                        <div class="menu-content">
                            <v-icon>mdi-account-group</v-icon>
                            <span>کارمندان</span>
                        </div>
                    </v-list-item>
                </template>

                <v-card min-width="220">
                    <v-list>
                        <v-list-item to="/employees">
                            <v-list-item-title>
                                لیست کارمندان
                            </v-list-item-title>
                        </v-list-item>

                        <v-list-item to="/employees/create">
                            <v-list-item-title>
                                ایجاد کارمند
                            </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>

            <!-- Attendance -->
            <v-list-item :to="'/attendances'" link class="menu-item">
                <div class="menu-content">
                    <v-icon>mdi-account-check</v-icon>
                    <span>حاضری</span>
                </div>
            </v-list-item>

            <!-- Finance -->
            <v-menu open-on-hover location="left" offset="10">
                <template #activator="{ props }">
                    <v-list-item v-bind="props" class="menu-item">
                        <div class="menu-content">
                            <v-icon>mdi-cash</v-icon>
                            <span>بخش مالی</span>
                        </div>
                    </v-list-item>
                </template>

                <v-card min-width="250">
                    <v-list>
                        <v-list-item to="/accounts">
                            <v-list-item-title>حساب‌ها</v-list-item-title>
                        </v-list-item>

                        <v-list-item to="/expense-category">
                            <v-list-item-title
                                >کتگوری مصارفات</v-list-item-title
                            >
                        </v-list-item>

                        <v-list-item to="/expenses">
                            <v-list-item-title>مصارفات</v-list-item-title>
                        </v-list-item>

                        <v-list-item to="/Owner-pickup">
                            <v-list-item-title>برداشت صاحب</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>
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
    border-left: none !important;
    box-shadow: none !important;
}

.menu-item {
    min-height: 110px !important;
    border: none !important;
    border-bottom: 1px solid #dcdcdc !important;
    margin-bottom: 0 !important;
    border-radius: 0 !important;
    position: relative;
    padding: 0 !important;
    transition: all 0.3s ease;
}
.v-divider {
    display: none !important;
}

/* Active item */
.v-list-item--active {
    background-color: #e8f0ff !important;
    border-bottom: 3px solid #4d7cff !important;
}

/* Active icon */
.v-list-item--active .v-icon {
    color: #4d7cff !important;
}

/* Active text */
.v-list-item--active span {
    color: #4d7cff !important;
    font-weight: bold;
}
.v-overlay__content .v-card {
    border-radius: 16px !important;
    overflow: hidden;
}

.v-overlay__content .v-list-item {
    min-height: 56px;
}
.finance-menu-card {
    border-radius: 16px !important;
    overflow: hidden;
}

.finance-menu-header {
    background: linear-gradient(135deg, #4d7cff, #6b95ff);
    color: white;
    padding: 14px 18px;
    font-size: 16px;
    font-weight: 600;
}

.finance-menu-item {
    transition: all 0.25s ease;
    border-right: 4px solid transparent;
}

.finance-menu-item:hover {
    background: #eef4ff;
    border-right-color: #4d7cff;
}

.finance-menu-item .v-icon {
    color: #4d7cff;
}

.finance-menu-item:hover .v-icon {
    transform: scale(1.1);
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
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 10px;
    text-align: center;
}
.router-link-exact-active {
    background-color: #e8f0ff !important;
    border-bottom: 3px solid #4d7cff !important;
}

.router-link-exact-active .v-icon,
.router-link-exact-active span {
    color: #4d7cff !important;
    font-weight: bold;
}
</style>

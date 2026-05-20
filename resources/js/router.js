import { createRouter, createWebHistory } from "vue-router";

// =========================================
// LAYOUT
// =========================================

import Home from "./home.vue";

// =========================================
// AUTH
// =========================================

import LoginView from "./pages/auth/LoginView.vue";

// =========================================
// PAGES
// =========================================

import Accounts from "./pages/accounts/Accounts.vue";

import ExpenseCategoyIndex from "./pages/expense-category/Expense-categoryIndex.vue";

import Expenses from "./pages/Expense/Expenses.vue";

import OwnerPickupsIndex from "./pages/owner-pickups/owner-pickupsIndex.vue";

import WarehouseIndex from "./pages/warehouse/warehouseIndex.vue";

import ProductTypesIndex from "./pages/product-types/Product-types.Index.vue";

import ProductIndex from "./pages/product/productIndex.vue";

import Createproduct from "./pages/product/createproduct.vue";

import Updateproduct from "./pages/product/updateproduct.vue";

import CustomerIndex from "./pages/customers/customerIndex.vue";

import Createcustomer from "./pages/customers/createcustomer.vue";

import Updatecustomer from "./pages/customers/updatecustomer.vue";

import SalesIndex from "./pages/sales/salesIndex.vue";

import Createsales from "./pages/sales/createsales.vue";

import employeeIndex from "./pages/employees/employeeIndex.vue";

import Createemployee from "./pages/employees/createemployee.vue";

import updateemployee from "./pages/employees/upateemployee.vue";

import attendancesIndex from "./pages/attendances/attendancesIndex.vue";

// =========================================
// ROUTES
// =========================================

const routes = [

    // =====================================
    // LOGIN
    // =====================================

    {
        path: "/login",
        name: "auth.login",
        component: LoginView,
    },

    // =====================================
    // MAIN LAYOUT
    // =====================================

    {
        path: "/",
        component: Home,

        meta: {
            requiresAuth: true,
        },

        children: [

            // =================================
            // DASHBOARD
            // =================================

            {
                path: "",
                name: "Home",

                component: Accounts,

                meta: {
                    title: "خانه",
                    subtitle: "به صفحه اصلی خوش آمدید",
                },
            },

            // =================================
            // ACCOUNTS
            // =================================

            {
                path: "accounts",
                name: "Accounts",

                component: Accounts,

                meta: {
                    title: "حساب‌ها",
                    subtitle: "مدیریت حساب‌ها",
                },
            },

            // =================================
            // EXPENSE CATEGORY
            // =================================

            {
                path: "expense-category",
                name: "expense-category",

                component: ExpenseCategoyIndex,

                meta: {
                    title: "کتگوری مصارفات",
                    subtitle: "مدیریت کتگوری مصارفات",
                },
            },

            // =================================
            // EXPENSES
            // =================================

            {
                path: "expenses",
                name: "Expenses",

                component: Expenses,

                meta: {
                    title: "مصارفات",
                    subtitle: "مدیریت مصارفات",
                },
            },

            // =================================
            // OWNER PICKUP
            // =================================

            {
                path: "Owner-pickup",
                name: "Owner-pickup",

                component: OwnerPickupsIndex,

                meta: {
                    title: "صاحب",
                    subtitle: "مدیریت صاحب اکونت",
                },
            },

            // =================================
            // WAREHOUSE
            // =================================

            {
                path: "warehouse",
                name: "warehouse",

                component: WarehouseIndex,

                meta: {
                    title: "گدام",
                    subtitle: "مدیریت گدام ها",
                },
            },

            // =================================
            // PRODUCT TYPES
            // =================================

            {
                path: "product-types",
                name: "product-types",

                component: ProductTypesIndex,

                meta: {
                    title: "نوعیت پرودکت",
                    subtitle: "مدیریت نوعیت پرودکت",
                },
            },

            // =================================
            // PRODUCTS
            // =================================

            {
                path: "products",
                name: "products",

                component: ProductIndex,

                meta: {
                    title: "محصول",
                    subtitle: "مدیریت محصول",
                },
            },

            {
                path: "products/create",
                name: "products.create",

                component: Createproduct,

                meta: {
                    title: "ساختن محصول",
                    subtitle: "ایجاد محصول جدید",
                },
            },

            {
                path: "products/:id/edit",
                name: "products.edit",

                component: Updateproduct,

                props: true,

                meta: {
                    title: "ویرایش محصول",
                    subtitle: "اپدیت محصول",
                },
            },

            // =================================
            // CUSTOMERS
            // =================================

            {
                path: "customers",
                name: "customers",

                component: CustomerIndex,

                meta: {
                    title: "مشتری",
                    subtitle: "مدیریت مشتری",
                },
            },

            {
                path: "customers/create",
                name: "customers.create",

                component: Createcustomer,

                meta: {
                    title: "مشتری ایجاد",
                    subtitle: "مدیریت مشتری",
                },
            },

            {
                path: "customers/:id/edit",
                name: "customers.edit",

                component: Updatecustomer,

                meta: {
                    title: "تغیر مشتری",
                    subtitle: "مدیریت تغیر مشتری",
                },
            },

            // =================================
            // SALES
            // =================================

            {
                path: "sales",
                name: "sales",

                component: SalesIndex,

                meta: {
                    title: "فروشات",
                    subtitle: "مدیریت فروشات",
                },
            },

            {
                path: "sales/create",
                name: "createsales",

                component: Createsales,

                meta: {
                    title: "ایجاد فروش",
                    subtitle: "مدیریت ایجاد فروش",
                },
            },

            // =================================
            // EMPLOYEES
            // =================================

            {
                path: "employees",
                name: "employees",

                component: employeeIndex,

                meta: {
                    title: "کارمند",
                    subtitle: "مدیریت کارمند",
                },
            },

            {
                path: "employees/create",
                name: "employees.create",

                component: Createemployee,

                meta: {
                    title: "ایجاد کارمند",
                    subtitle: "مدیریت ایجاد کارمند",
                },
            },

            {
                path: "employees/:id/edit",
                name: "employees.edit",

                component: updateemployee,

                meta: {
                    title: "تغیر کارمند",
                    subtitle: "مدیریت تغیر کارمند",
                },
            },

            // =================================
            // ATTENDANCES
            // =================================

            {
                path: "attendances",
                name: "attendances",

                component: attendancesIndex,

                meta: {
                    title: "حاضری",
                    subtitle: "مدیریت حاضری",
                },
            },
        ],
    },
];

// =========================================
// ROUTER
// =========================================

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// =========================================
// AUTH GUARD
// =========================================

router.beforeEach((to, from, next) => {

    const token = sessionStorage.getItem("token");

    // =============================
    // NEED LOGIN
    // =============================

    if (to.meta.requiresAuth && !token) {

        return next({
            name: "auth.login",
        });
    }

    // =============================
    // ALREADY LOGGED IN
    // =============================

    if (to.name === "auth.login" && token) {

        return next({
            name: "Home",
        });
    }

    next();
});

export default router;
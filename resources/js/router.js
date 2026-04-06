import { createRouter, createWebHistory } from "vue-router";

// Pages
import Home from "./pages/Home.vue";
import Accounts from "./pages/accounts/Accounts.vue";
import ExpenseCategoyIndex from "./pages/expense-category/Expense-categoryIndex.vue";
import Expenses from "./pages/Expense/Expenses.vue";
import OwnerPickupsIndex from "./pages/owner-pickups/owner-pickupsIndex.vue";
import WarehouseIndex from "./pages/warehouse/warehouseIndex.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
        meta: {
            title: "خانه",
            subtitle: "به صفحه اصلی خوش آمدید",
        },
    },
    {
        path: "/accounts",
        name: "Accounts",
        component: Accounts,
        meta: {
            title: "حساب‌ها",
            subtitle: "مدیریت حساب‌ها",
        },
    },
    {
        path: "/expense-category",
        name: "expense-category",
        component: ExpenseCategoyIndex,
        meta: {
            title: "کتگوری مصارفات ",
            subtitle: "مدیریت کتگوری مصارفات ",
        },
    },
    {
        path: "/expenses",
        name: "Expenses",
        component: Expenses,
        meta: {
            title: "مصارفات ",
            subtitle: "مدیریت مصارفات ",
        },
    },
     {
        path: "/Owner-pickup",
        name: "Owner-pickup",
        component: OwnerPickupsIndex,
        meta: {
            title:  "صاحب  ",
            subtitle: "مدیریت صاحب اکونت  ",
        },
    },
     {
        path: "/warehouse",
        name: "warehouse",
        component: WarehouseIndex,
        meta: {
            title:  "گدام",
            subtitle: "مدیریت گدام ها ",
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

import { createRouter, createWebHistory } from "vue-router";

// Pages
import Home from "./pages/Home.vue";
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
            title: "صاحب  ",
            subtitle: "مدیریت صاحب اکونت  ",
        },
    },
    {
        path: "/warehouse",
        name: "warehouse",
        component: WarehouseIndex,
        meta: {
            title: "گدام",
            subtitle: "مدیریت گدام ها ",
        },
    },
    {
        path: "/product-types",
        name: "product-types",
        component: ProductTypesIndex,
        meta: {
            title: "نوعیت پرودکت ",
            subtitle: "مدیریت نوعیت پرودکت ",
        },
    },
    {
        path: "/products",
        name: "products",
        component: ProductIndex,
        meta: {
            title: " محصول ",
            subtitle: "مدیریت  محصول ",
        },
    },
    {
        path: "/products",
        name: "products",
        component: ProductIndex,
        meta: {
            title: "محصول",
            subtitle: "مدیریت محصول",
        },
    },

    // ✅ Create Product
    {
        path: "/products/create",
        name: "products.create",
        component: Createproduct,
        meta: {
            title: "ساختن محصول",
            subtitle: "ایجاد محصول جدید",
        },
    },

    // ✅ Edit Product
    {
        path: "/products/:id/edit",
        name: "products.edit",
        component: Updateproduct,
        props: true,
        meta: {
            title: "ویرایش محصول",
            subtitle: "اپدیت محصول",
        },
    },
    {
        path: "/customers",
        name: "customers",
        component: CustomerIndex,
        meta: {
            title: "مشتری ",
            subtitle: "مدیریت مشتری",
        },
    },
    {
        path: "/customers/create",
        name: "customers.create",
        component: Createcustomer,
        meta: {
            title: "مشتری  ایجاد ",
            subtitle: "مدیریت مشتری",
        },
    },
    {
        path: "/customers/:id/edit",
        name: "customers.edit",
        component: Updatecustomer,
        meta: {
            title: "تغیر مشتری    ",
            subtitle: "مدیریت تغیر مشتری",
        },
    },
    {
        path: "/sales",
        name: "sales",
        component: SalesIndex,
        meta: {
            title: "فروشات",
            subtitle: "مدیریت  فروشات",
        },
    },
    {
        path: "/sales/create",
        name: "sales.create",
        component: Createsales,
        meta: {
            title: "مشتری  ایجاد ",
            subtitle: "مدیریت ایجاد  مشتری",
        },
    },
    // {
    //     path: "/sales/:id/edit",
    //     name: "sales.edit",
    //     component: updatesles,
    //     meta: {
    //         title: "تغیر فروش    ",
    //         subtitle: "مدیریت تغیر فروش",
    //     },
    // },
     {
        path: "/employees",
        name: "employees",
        component: employeeIndex,
        meta: {
            title: "کارمند",
            subtitle: "مدیریت کارمند ",
        },
    },
       {
        path: "/employees/create",
        name: "employees.create",
        component: Createemployee,
        meta: {
            title: "ایجاد کارمند   ",
            subtitle: "مدیریت ایجاد  کارمند ",
        },
    },
    {
        path: "/employees/:id/edit",
        name: "employees.edit",
        component: updateemployee,
        meta: {
            title: "تغیر کارمند    ",
            subtitle: "مدیریت تغیر کارمند",
        },
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

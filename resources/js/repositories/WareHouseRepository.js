// stores/AccountRepository.js

import { defineStore } from "pinia";
import axios from "@/plugins/axios";
import Createproduct from "../pages/product/createproduct.vue";

export let useWareHouseRepository = defineStore("WareHouseRepository", {
    state() {
        return {
            warehouses: [],
            warehouse: [], // ✅ IMPORTANT FIX
            producttype: [],
            producttypes: [], // ✅ IMPORTANT FIX
            products: [],
            product: [], // ✅ IMPORTANT FIX
            employees: [],
            employee: [],
            ProductTypesForDropDown: [], // ✅ IMPORTANT FIX
            warehouseForDropDown: [],
            accountForDropDown: [],
            customerForDropDown: [],
            customers: [],
            customer: [],
            sales: [],
            sale: [],
            isLoading: false,
            error: null,
            loading: false,
            itemsPerPage: 10,
            page: 1,
            selectedItems: [],
            selectAll: false,
            createDialog: false,
            updateDialog: false,
            showSelect: true,
            totalItems: 0,
            itemKey: "id",
        };
    },

    actions: {
        // hellpers
        async fetchProductTypesForDropDowns() {
            try {
                const response = await axios.get(`product-types`);
                // Store in dropdown format { label, value }
                this.ProductTypesForDropDown = response.data.items.map(
                    (acc) => ({
                        label: acc.name, // display name
                        value: acc.id, // actual id
                    }),
                );
            } catch (error) {
                console.error(error);
            }
        },
        async fetchwarehouseForDropDowns() {
            try {
                const response = await axios.get(`warehouses`);
                // Store in dropdown format { label, value }
                this.warehouseForDropDown = response.data.items.map((acc) => ({
                    label: acc.name, // display name
                    value: acc.id, // actual id
                }));
            } catch (error) {
                console.error(error);
            }
        },
        async fetchaccountForDropDowns() {
            try {
                const response = await axios.get(`accounts`);
                // Store in dropdown format { label, value }
                this.accountForDropDown = response.data.items.map((acc) => ({
                    label: acc.name, // display name
                    value: acc.id, // actual id
                }));
            } catch (error) {
                console.error(error);
            }
        },

        async fetchcustomerForDropDowns() {
            try {
                const response = await axios.get(`customers`);
                // Store in dropdown format { label, value }
                this.customerForDropDown = response.data.items.map((acc) => ({
                    label: acc.name, // display name
                    value: acc.id, // actual id
                }));
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Fetch all
        async fetchwarehouses({ page, itemsPerPage }) {
            this.loading = true;
            try {
                const response = await axios.get(
                    `warehouses?page=${page}&perPage=${itemsPerPage}`,
                );

                this.warehouses = response.data.items;
                this.page = page;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        // ✅ Fetch one
        async fetchwarehouse(id) {
            try {
                const response = await axios.get(`warehouses/${id}`);
                this.warehouse = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Create
        async createwarehouse(formData) {
            try {
                await axios.post("warehouses", formData);

                this.createDialog = false;

                await this.fetchwarehouses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Update
        async updatewarehouse(id, data) {
            try {
                await axios.put(`warehouses/${id}`, data);

                this.updateDialog = false;

                await this.fetchwarehouses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Delete
        async deletewarehouse(id) {
            try {
                await axios.delete(`warehouses/${id}`);

                await this.fetchwarehouses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },
        // this is for the product-types
        async fetchproducttypes({ page, itemsPerPage }) {
            this.loading = true;
            try {
                const response = await axios.get(
                    `product-types?page=${page}&perPage=${itemsPerPage}`,
                );

                this.producttypes = response.data.items;
                this.page = page;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        // ✅ Fetch one
        async fetchproducttype(id) {
            try {
                const response = await axios.get(`product-types/${id}`);
                this.producttype = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Create
        async createproducttype(formData) {
            try {
                await axios.post("product-types", formData);

                this.createDialog = false;

                await this.fetchproducttypes({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Update
        async updateproducttype(id, data) {
            try {
                await axios.put(`product-types/${id}`, data);

                this.updateDialog = false;

                await this.fetchproducttypes({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Delete
        async deleteprodcucttype(id) {
            try {
                await axios.delete(`product-types/${id}`);

                await this.fetchproducttypes({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // this is for the product
        async fetchproducts({ page, itemsPerPage }) {
            this.loading = true;
            try {
                const response = await axios.get(
                    `products?page=${page}&perPage=${itemsPerPage}`,
                );

                this.customers = response.data.items;
                this.page = page;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        // ✅ Fetch one
        async fetchproduct(id) {
            try {
                const response = await axios.get(`products/${id}`);
                this.product = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Create
        async Createproduct(formData) {
            try {
                await axios.post("products", formData);

                this.createDialog = false;

                await this.fetchproducts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Update
        async updateproduct(id, data) {
            try {
                await axios.put(`products/${id}`, data);

                this.updateDialog = false;

                await this.fetchproducts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Delete
        async deleteproduct(id) {
            try {
                await axios.delete(`customers/${id}`);

                await this.fetchcustomers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },
        // this is for the customers
        async fetchcustomers({ page, itemsPerPage }) {
            this.loading = true;
            try {
                const response = await axios.get(
                    `customers?page=${page}&perPage=${itemsPerPage}`,
                );

                this.customers = response.data.items;
                this.page = page;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        // ✅ Fetch one
        async fetchcustomer(id) {
            try {
                const response = await axios.get(`customers/${id}`);
                this.customer = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Create
        async createcustomers(formData) {
            try {
                await axios.post("customers", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });

                this.createDialog = false;

                await this.fetchcustomers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Update
        async updatecustomer(id, data) {
            try {
                // 👇 VERY IMPORTANT
                data.append("_method", "PUT");

                await axios.post(`customers/${id}`, data, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });

                this.updateDialog = false;

                await this.fetchcustomers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Delete
        async deletecustomer(id) {
            try {
                await axios.delete(`customers/${id}`);

                await this.fetchcustomers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },
        // this is for the sales
        async fetchsales({ page, itemsPerPage }) {
            this.loading = true;
            try {
                const response = await axios.get(
                    `sales?page=${page}&perPage=${itemsPerPage}`,
                );

                this.sales = response.data.items;
                this.page = page;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        // ✅ Fetch one
        async fetchsale(id) {
            try {
                const response = await axios.get(`sales/${id}`);
                this.sale = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Create
        async createsales(formData) {
            try {
                await axios.post("sales", formData);

                this.createDialog = false;

                await this.fetchsales({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Update
        async updatesale(id, data) {
            try {
                await axios.put(`sales/${id}`, data);

                this.updateDialog = false;

                await this.fetchsales({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Delete
        async deletesale(id) {
            try {
                await axios.delete(`sales/${id}`);

                await this.fetchsales({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },
        // this is for the employee
        async fetchemployees({ page, itemsPerPage }) {
            this.loading = true;
            try {
                const response = await axios.get(
                    `employees?page=${page}&perPage=${itemsPerPage}`,
                );

                this.employees = response.data.data;
                this.page = page;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        // ✅ Fetch one
        async fetchemployee(id) {
            try {
                const response = await axios.get(`employees/${id}`);
                this.employee = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Create
        async createemployees(formData) {
            try {
                await axios.post("employees", formData);

                this.createDialog = false;

                await this.fetchemployees({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Update
        async updateemployee(id, data) {
            try {
                await axios.put(`employees/${id}`, data);

                this.updateDialog = false;

                await this.fetchemployees({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Delete
        async deletesale(id) {
            try {
                await axios.delete(`employees/${id}`);

                await this.fetchemployees({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },
    },
});

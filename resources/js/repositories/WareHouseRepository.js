// stores/AccountRepository.js

import { defineStore } from "pinia";
import axios from "@/plugins/axios";

export let useWareHouseRepository = defineStore("WareHouseRepository", {
    state() {
        return {
            warehouses: [],
            warehouse: [], // ✅ IMPORTANT FIX
            producttype: [],
            producttypes: [], // ✅ IMPORTANT FIX
            products: ([]),
            product: ([]), // ✅ IMPORTANT FIX
            ProductTypesForDropDown: [], // ✅ IMPORTANT FIX
            warehouseForDropDown:[],
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
                this.ProductTypesForDropDown = response.data.items.map((acc) => ({
                    label: acc.name, // display name
                    value: acc.id, // actual id
                }));
            } catch (error) {
                console.error(error);
            }
        },
        async fetchwarehouseForDropDowns() {
            try {
                const response = await axios.get(`warehouses`);
                // Store in dropdown format { label, value }
                this.warehouseForDropDown = response.data.items.map(
                    (acc) => ({
                        label: acc.name, // display name
                        value: acc.id, // actual id
                    }),
                );
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
                const response = await axios.get(`product-type/${id}`);
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
                await axios.delete(`prosuct-types/${id}`);

                await this.fetchproducttype({
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

                this.Expenses = response.data.items;
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
                this.Expense = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Create
        async createproduct(formData) {
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
                await axios.delete(`products/${id}`);

                await this.fetchproducts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },
      
        },
});

// stores/AccountRepository.js

import { defineStore } from "pinia";
import axios from "@/plugins/axios"; 

export let useAccountRepository = defineStore("AccountRepository", {
    state() {
        return {
            accounts: [],
            account: {}, // ✅ IMPORTANT FIX
            isLoading: false,
            error: null,
            loading: false,
            itemsPerPage: 5,
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
        // ✅ Fetch all
        async fetchAccounts({ page, itemsPerPage }) {
            this.loading = true;
            try {
                const response = await axios.get(
                    `accounts?page=${page}&perPage=${itemsPerPage}`
                );

                this.accounts = response.data.items;
                this.page = page;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        // ✅ Fetch one
        async fetchAccount(id) {
            try {
                const response = await axios.get(`accounts/${id}`);
                this.account = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Create
        async createAccount(formData) {
            try {
                await axios.post("accounts", formData);

                this.createDialog = false;

                await this.fetchAccounts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Update
        async updateAccount(id, data) {
            try {
                await axios.put(`accounts/${id}`, data);

                this.updateDialog = false;

                await this.fetchAccounts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Delete
        async deleteAccount(id) {
            try {
                await axios.delete(`accounts/${id}`);

                await this.fetchAccounts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },
    },
});
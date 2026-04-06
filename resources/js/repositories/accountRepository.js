// stores/AccountRepository.js

import { defineStore } from "pinia";
import axios from "@/plugins/axios";

export let useAccountRepository = defineStore("AccountRepository", {
    state() {
        return {
            accounts: [],
            account: [], // ✅ IMPORTANT FIX
            ExpenseCategory: [],
            ExpenseCategories: [], // ✅ IMPORTANT FIX
            Expense: [],
            Expenses: [], // ✅ IMPORTANT FIX
            Ownerpickups: ([]),
            Ownerpickup: ([]), // ✅ IMPORTANT FIX
            AccountForDropDown: [{}], // ✅ IMPORTANT FIX
            ExpenseCategoryForDropDown: [{}], // ✅ IMPORTANT FIX
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
        async fetchAccountsForDropDowns() {
            try {
                const response = await axios.get(`accounts`);
                // Store in dropdown format { label, value }
                this.AccountForDropDown = response.data.items.map((acc) => ({
                    label: acc.name, // display name
                    value: acc.id, // actual id
                }));
            } catch (error) {
                console.error(error);
            }
        },
        async fetchExpenseCategoryForDropDowns() {
            try {
                const response = await axios.get(`expense-categories`);
                // Store in dropdown format { label, value }
                this.ExpenseCategoryForDropDown = response.data.items.map(
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
        async fetchAccounts({ page, itemsPerPage }) {
            this.loading = true;
            try {
                const response = await axios.get(
                    `accounts?page=${page}&perPage=${itemsPerPage}`,
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
        // this is for the expense category
        async fetchExpenseCategories({ page, itemsPerPage }) {
            this.loading = true;
            try {
                const response = await axios.get(
                    `expense-categories?page=${page}&perPage=${itemsPerPage}`,
                );

                this.ExpenseCategories = response.data.items;
                this.page = page;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        // ✅ Fetch one
        async fetchExpenseCategory(id) {
            try {
                const response = await axios.get(`expense-categories/${id}`);
                this.ExpenseCategory = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Create
        async createExpenseCategory(formData) {
            try {
                await axios.post("expense-categories", formData);

                this.createDialog = false;

                await this.fetchExpenseCategories({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Update
        async updateExpenseCategory(id, data) {
            try {
                await axios.put(`expense-categories/${id}`, data);

                this.updateDialog = false;

                await this.fetchExpenseCategories({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Delete
        async deleteExpenseCategory(id) {
            try {
                await axios.delete(`expense-categories/${id}`);

                await this.fetchExpenseCategories({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // this is for the expenses
        async fetchExpenses({ page, itemsPerPage }) {
            this.loading = true;
            try {
                const response = await axios.get(
                    `expenses?page=${page}&perPage=${itemsPerPage}`,
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
        async fetchExpense(id) {
            try {
                const response = await axios.get(`expenses/${id}`);
                this.Expense = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Create
        async createExpense(formData) {
            try {
                await axios.post("expenses", formData);

                this.createDialog = false;

                await this.fetchExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Update
        async updateExpense(id, data) {
            try {
                await axios.put(`expenses/${id}`, data);

                this.updateDialog = false;

                await this.fetchExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Delete
        async deleteExpense(id) {
            try {
                await axios.delete(`expenses/${id}`);

                await this.fetchExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },
        // ✅ this is for owner pickup
        async fetchOwnerpickups({ page, itemsPerPage }) {
            this.loading = true;
            try {
                const response = await axios.get(
                    `owner-pickups?page=${page}&perPage=${itemsPerPage}`,
                );

                this.Ownerpickups = response.data.items;
                this.page = page;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        // ✅ Fetch one
        async fetchOwnerpickup(id) {
            try {
                const response = await axios.get(`owner-pickups/${id}`);
                this.Ownerpickup = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Create
        async createOwnerpickup(formData) {
            try {
                await axios.post("owner-pickups", formData);

                this.createDialog = false;

                await this.fetchOwnerpickups({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Update
        async updateOwnerpickup(id, data) {
            try {
                await axios.put(`owner-pickups/${id}`, data);

                this.updateDialog = false;

                await this.fetchOwnerpickups({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Delete
        async deleteOwnerpickup(id) {
            try {
                await axios.delete(`owner-pickups/${id}`);

                await this.fetchOwnerpickups({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },
    },
});

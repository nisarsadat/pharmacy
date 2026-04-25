// stores/PeopleRepository.js

import { defineStore } from "pinia";
import axios from "@/plugins/axios";
import Createattendances from "../pages/attendances/createattendances.vue";

export let usePeopleRepository = defineStore("PeopleRepository", {
    state() {
        return {
            attendances: [],
            attendance: [], //IMPORTANT FIX
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
        // ✅ Fetch all
        async fetchattendances({ page, itemsPerPage }) {
            this.loading = true;
            try {
                const response = await axios.get(
                    `attendances?page=${page}&perPage=${itemsPerPage}`,
                );
                this.attendances = response.data.items;
                this.page = page;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        // ✅ Fetch one
        async fetchattendance(id) {
            try {
                const response = await axios.get(`attendances/${id}`);
                this.attendance = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Create
        async Createattendances(formData) {
            try {
                await axios.post("attendances", formData);

                this.createDialog = false;

                await this.fetchattendances({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Update
        async updateattendance(id, data) {
            try {
                await axios.put(`attendances/${id}`, data);

                this.updateDialog = false;

                await this.fetchattendances({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },

        // ✅ Delete
        async deleteattendance(id) {
            try {
                await axios.delete(`attendances/${id}`);

                await this.fetchattendances({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error(error);
            }
        },
    },
});

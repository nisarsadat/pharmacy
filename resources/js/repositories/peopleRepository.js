// stores/PeopleRepository.js

import { defineStore } from "pinia";
import axios from "@/plugins/axios";

export let usePeopleRepository = defineStore("PeopleRepository", {
    state() {
        return {
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
       
        },
    },
);

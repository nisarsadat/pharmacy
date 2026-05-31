// src/utils/axios.js

import axios from "axios";
import { toast } from "vue3-toastify";
import router from "@/router";

// ===================================
// BASE CONFIG
// ===================================

const api = axios.create({
    baseURL: "/api",
    headers: {
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
    },
});

// ===================================
// REQUEST INTERCEPTOR
// ===================================

api.interceptors.request.use(
    (config) => {
        const token = sessionStorage.getItem("token");

        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }

        return config;
    },
    (error) => Promise.reject(error)
);

// ===================================
// RESPONSE INTERCEPTOR
// ===================================

api.interceptors.response.use(
    (response) => response,

    async (error) => {
        const status = error?.response?.status;

        const message =
            error?.response?.data?.message ||
            "Something went wrong";

        // =========================
        // UNAUTHORIZED
        // =========================
        if (status === 401) {
            sessionStorage.removeItem("token");
            sessionStorage.removeItem("user");

            if (router.currentRoute.value.name !== "auth.login") {
                toast.error("Session expired");

                await router.push({
                    name: "auth.login",
                });
            }
        }

        // =========================
        // SHOW ERROR
        // =========================
        if (status !== 422) {
            toast.error(message);
        }

        return Promise.reject(error);
    }
);

export default api;
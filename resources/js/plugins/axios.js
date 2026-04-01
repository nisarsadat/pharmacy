// utils/axios.js  (or wherever you placed it)

import axios from "axios";
import { toast } from "vue3-toastify";
import router from "@/router";

// ✅ base config
axios.defaults.baseURL = "/api";
axios.defaults.headers.common["Accept"] = "application/json";
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.withCredentials = true;

// ✅ request interceptor (token)
axios.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem("token");

        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }

        return config;
    },
    (error) => Promise.reject(error)
);

// ✅ response interceptor (errors)
axios.interceptors.response.use(
    (response) => response,
    async (error) => {
        const status = error?.response?.status;

        const msg =
            error?.response?.data?.message ||
            error?.response?.data?.error ||
            "Server error, try again.";

        if (status === 401) {
            localStorage.removeItem("token");
            localStorage.removeItem("user");

            if (router.currentRoute.value.name !== "auth.login") {
                toast.error("Session expired, login again.");
                await router.push({ name: "auth.login" });
            }
        }

        if (status !== 422) {
            toast.error(msg);
        }

        return Promise.reject(error);
    }
);

export default axios;
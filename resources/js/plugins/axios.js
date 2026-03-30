import axios from "axios";
import { toast } from "vue3-toastify";
import router from "@/router";

// ✅ global defaults
axios.defaults.baseURL = "/api";
axios.defaults.headers.common["Accept"] = "application/json";
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.withCredentials = true;

// ✅ attach bearer token automatically
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

// ✅ global error handling
axios.interceptors.response.use(
    (response) => response,
    async (error) => {
        const status = error?.response?.status;

        const msg =
            error?.response?.data?.message ||
            error?.response?.data?.error ||
            "مشکل در ارتباط با سرور. لطفاً دوباره تلاش کنید.";

        // session expired
        if (status === 401) {
            localStorage.removeItem("token");
            localStorage.removeItem("user");

            if (router.currentRoute.value.name !== "auth.login") {
                toast.error("نشست شما منقضی شد. لطفاً دوباره وارد شوید.");
                await router.push({ name: "auth.login" });
            }

            return Promise.reject(error);
        }

        // validation errors handled in forms
        if (status === 422) {
            return Promise.reject(error);
        }

        toast.error(msg);

        return Promise.reject(error);
    }
);

// make globally accessible (optional)
window.axios = axios;

export default axios;
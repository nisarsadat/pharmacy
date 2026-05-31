import axios from "@/plugins/axios";

export default {

    // =========================
    // LOGIN
    // =========================
    async login(data) {
        const response = await axios.post("/login", data);

        return response.data;
    },

    // =========================
    // LOGOUT
    // =========================
    async logout() {
        const response = await axios.post("/logout");

        return response.data;
    },

    // =========================
    // USER
    // =========================
    async getUser() {
        const response = await axios.get("/user");

        return response.data;
    },
};
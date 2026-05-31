import axios from "@/plugins/axios";

export default {

    // =========================
    // GET USERS
    // =========================

    async getUsers() {
        const response = await axios.get("/users");

        return response.data;
    },

    // =========================
    // CREATE USER
    // =========================

    async createUser(data) {
        const response = await axios.post("/users", data);

        return response.data;
    },

    // =========================
    // UPDATE USER
    // =========================

    async updateUser(id, data) {
        const response = await axios.put(`/users/${id}`, data);

        return response.data;
    },

    // =========================
    // DELETE USER
    // =========================

    async deleteUser(id) {
        const response = await axios.delete(`/users/${id}`);

        return response.data;
    },
};
<template>
    <div class="login-page">

        <div class="login-card">
            <h1>Login</h1>

            <form @submit.prevent="submitLogin">

                <!-- EMAIL -->
                <div class="form-group">
                    <label>Email</label>

                    <input
                        v-model="form.email"
                        type="email"
                        placeholder="Enter email"
                    />
                </div>

                      <!-- Password (SHOW / HIDE BUTTON HERE) -->
                <v-text-field
                    v-model="form.password"
                    :type="showPassword ? 'text' : 'password'"
                    label="Password"
                    prepend-inner-icon="mdi-lock"
                    :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                    @click:append-inner="showPassword = !showPassword"
                    variant="outlined"
                    class="mb-3"
                />

                <!-- BUTTON -->
                <button :disabled="loading">

                    <span v-if="loading">
                        Logging in...
                    </span>

                    <span v-else>
                        Login
                    </span>

                </button>

            </form> 
        </div>

    </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";

import authRepository from "@/repositories/authRepository";

const router = useRouter();

const loading = ref(false);

const form = reactive({
    email: "",
    password: "",
});

/* show/hide password */
const showPassword = ref(false);

// ===================================
// LOGIN
// ===================================

const submitLogin = async () => {

    try {

        loading.value = true;

        const response = await authRepository.login(form);

        // =========================
        // SAVE TOKEN
        // =========================

        sessionStorage.setItem(
            "token",
            response.token
        );

        sessionStorage.setItem(
            "user",
            JSON.stringify(response.user)
        );

        toast.success(response.message);

        // =========================
        // REDIRECT
        // =========================

        router.push({
            name: "Home",
        });

    } catch (error) {

        console.log(error);

    } finally {

        loading.value = false;

    }
};
</script>

<style scoped>

.login-page {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f5f5f5;
}

.login-card {
    width: 400px;
    background: white;
    padding: 30px;
    border-radius: 12px;
}

h1 {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
}

button {
    width: 100%;
    padding: 12px;
    border: none;
    background: #111827;
    color: white;
    border-radius: 8px;
    cursor: pointer;
}

button:disabled {
    opacity: 0.7;
}

</style>
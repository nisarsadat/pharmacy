<template>
    <v-app>
        <v-app-bar>
            <v-btn
                color="red"
                variant="tonal"
                @click="logout"
                icon="mdi-logout"
            ></v-btn>
            
        </v-app-bar>

        <SidebarMenu />

        <v-main>
            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script setup>
import SidebarMenu from "./pages/components/SidebarMenu.vue";
import authRepository from "@/repositories/authRepository";
import { useRouter } from "vue-router";
const router = useRouter();

const logout = async () => {
    try {
        await authRepository.logout();
    } catch (error) {
        console.log(error);
    } finally {
        sessionStorage.removeItem("token");
        sessionStorage.removeItem("user");

        router.push({
            name: "auth.login",
        });
    }
};
</script>

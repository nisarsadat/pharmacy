<template>
    <v-app>
        <v-app-bar title="App bar"></v-app-bar>

        <v-navigation-drawer>
            <SidebarMenu />
        </v-navigation-drawer>

        <v-main>
            <v-container><router-view></router-view> </v-container>
        </v-main>
    </v-app>
</template>
<script setup>
import SidebarMenu from "./pages/components/SidebarMenu.vue";
</script>

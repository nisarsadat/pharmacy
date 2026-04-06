<template>
  <v-app>
    <!-- Navigation Drawer / Sidebar -->
    <v-navigation-drawer
      v-model="drawer"
      app
      permanent
      width="250"
      class="bg-deep-purple darken-3"
    >
      <v-list nav>
        <v-list-item
          v-for="route in routes"
          :key="route.name"
          :to="route.path"
          link
          rounded
          class="mb-1"
        >
          <v-list-item-icon>
            <v-icon :icon="route.icon"></v-icon>
          </v-list-item-icon>
          <v-list-item-title class="white--text">
            {{ route.meta.title }}
          </v-list-item-title>
        </v-list-item>
      </v-list>

      <v-spacer></v-spacer>

      <v-btn block color="red" class="ma-2" @click="logout">
        Logout
      </v-btn>
    </v-navigation-drawer>

    <!-- Main content -->
    <v-main>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
import { ref } from "vue";
import { useRouter } from "vue-router";

// Sidebar routes
const routes = [
  { path: "/", name: "Home", meta: { title: "خانه" }, icon: "mdi-home" },
  { path: "/accounts", name: "Accounts", meta: { title: "حساب‌ها" }, icon: "mdi-account" },
  { path: "/expense-category", name: "Expense-Category", meta: { title: "کتگوری مصارفات " }, icon: "mdi-book " },
  { path: "/expenses", name: "Expenses", meta: { title: "مصارفات " }, icon: "mdi-book-outline " },
  { path: "/Owner-pickup", name: "Expenses", meta: { title: "صاحب  " }, icon: "mdi-account " },

];

export default {
  name: "Sidebar",
  setup() {
    const drawer = ref(true);
    const router = useRouter();

    const logout = () => {
      console.log("Logout clicked");
      // Add your logout logic here
      router.push("/"); // Example: redirect to home
    };

    return { drawer, routes, logout };
  },
};
</script>

<style>
/* Optional: tweak list item appearance */
.v-list-item-title {
  font-weight: 500;
}
</style>
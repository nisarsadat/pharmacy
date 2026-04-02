<template>
  <div id="app">
    <!-- App Bar -->
    <header class="appbar">
      <div class="appbar-content">
        <h1>{{ pageTitle }}</h1>
        <p>{{ pageSubtitle }}</p>
      </div>
    </header>

    <div class="layout">
      <!-- Content -->
      <main class="content">
        <router-view />
      </main>

      <!-- Right Sidebar Menu -->
      <aside class="sidebar">

        <router-link to="/accounts" class="menu-item">🏠 اکونت</router-link>
        <router-link to="/" class="menu-item">🏠 خانه</router-link>
        <router-link to="/about" class="menu-item">ℹ️ درباره ما</router-link>
        <router-link to="/contact" class="menu-item">📞 تماس با ما</router-link>

        <!-- Fake Items -->
        <div class="menu-item">📊 گزارشات</div>
        <div class="menu-item">⚙️ تنظیمات</div>
        <div class="menu-item">👤 پروفایل</div>
        <div class="menu-item">💬 پیام‌ها</div>
      </aside>
    </div>
  </div>
</template>

<script>
export default {
  name: "App",

  computed: {
    pageTitle() {
      return this.$route.meta.title || "خانه";
    },
    pageSubtitle() {
      return this.$route.meta.subtitle || "به برنامه خوش آمدید";
    },
  },
};
</script>

<style>
#app {
  font-family: Arial, sans-serif;
}

/* App Bar */
.appbar {
  background: #1976d2;
  color: white;
  padding: 15px;
}

/* Layout */
.layout {
  display: flex;
  flex-direction: row-reverse; /* Sidebar on RIGHT */
}

/* Sidebar */
.sidebar {
  width: 220px;
  background: #f4f4f4;
  padding: 15px;
  min-height: 100vh;
  border-left: 1px solid #ddd;
}

.menu-title {
  margin-bottom: 10px;
}

/* Menu Items */
.menu-item {
  display: block;
  padding: 10px;
  margin-bottom: 5px;
  text-decoration: none;
  color: black;
  border-radius: 5px;
  cursor: pointer;
}

.menu-item:hover {
  background: #ddd;
}

.router-link-active {
  background: #1976d2;
  color: white;
}

/* Content */
.content {
  flex: 1;
  padding: 20px;
}
</style>
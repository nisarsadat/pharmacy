import { createRouter, createWebHistory } from 'vue-router'

// Pages
import Home from './pages/Home.vue'
import About from './pages/About.vue'
import Contact from './pages/Contact.vue'
import Accounts from './pages/accounts/Accounts.vue'

const routes = [

  {
    path: "/accounts",
    name: "Accounts",
    component: Accounts ,
    meta: {
      title: "حساب‌ها",
      subtitle: "مدیریت حساب‌ها",
    },
  },


  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      title: 'خانه',
      subtitle: 'به صفحه اصلی خوش آمدید',
    },
  },
  {
    path: '/about',
    name: 'About',
    component: About,
    meta: {
      title: 'درباره ما',
      subtitle: 'معلومات در مورد ما',
    },
  },
  {
    path: '/contact',
    name: 'Contact',
    component: Contact,
    meta: {
      title: 'تماس با ما',
      subtitle: 'با ما در ارتباط باشید',
    },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
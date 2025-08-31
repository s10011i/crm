import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import AdminDashboard from '../components/admin/AdminDashboard.vue';
import OperatorDashboard from '../components/operator/OperatorDashboard.vue';
import BackofficeDashboard from '../components/backoffice/BackofficeDashboard.vue';

import NotFound from '../components/NotFound.vue';

import DisplayAllEntries from '../components/entries/frontoffice/DisplayAllEntries.vue';
import EntryFrontEdit from '../components/entries/frontoffice/EntryFrontEdit.vue';

// import CreateEmployee from '../components/admin/CreateEmployee.vue';
import MyEntries from '../components/entries/backoffice/MyEntries.vue';

const routes = [
  {
    path: "/",
    name: "login",
    component: Login
  },
  {
    path: "/admin",
    name: "admin_dashboard",
    component: AdminDashboard,
    meta: { requiresAuth: true, role: "admin" }
  },
  {
    path: "/operator",
    name: "operator_dashboard",
    component: OperatorDashboard,
    meta: { requiresAuth: true, role: "operator" }
  },
  {
    path: "/backoffice",
    name: "backoffice_dashboard",
    component: BackofficeDashboard,
    meta: { requiresAuth: true, role: "backoffice" }
  },
  {
    path: "/display_all_entries",
    name: "display_all_entries",
    component: DisplayAllEntries
  },
  {
    path: "/entry_front_edit/:id",
    name: "entry_front_edit",
    component: EntryFrontEdit,
    props: true
  },
  {
    path: "/my_entries/:id",
    name: "my_entries",
    component: MyEntries,
    props: true
  },
  {
    path: "/:pathMatch(.*)*",
    name: "not_found",
    component: NotFound
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// 🔒 Route Guard
// router.beforeEach((to, from, next) => {
//   const token = sessionStorage.getItem("token");
//   const user = sessionStorage.getItem("user") ? JSON.parse(sessionStorage.getItem("user")) : null;
//   const userRole = user?.roles?.[0]?.name;

//   if (to.meta.requiresAuth) {
//     if (!token || !user) {
//       // Not logged in
//       return next("/");
//     }
//     if (to.meta.role && to.meta.role !== userRole) {
//       // Wrong role → redirect to their dashboard
//       if (userRole === "admin") return next("/admin");
//       if (userRole === "operator") return next("/operator");
//       if (userRole === "backoffice") return next("/backoffice");
//       return next("/"); // fallback
//     }
//   }

//   next(); // allow navigation
// });

export default router;
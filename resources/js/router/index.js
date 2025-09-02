import { createRouter, createWebHistory } from 'vue-router';

import Login from '../views/Login.vue';
import AdminDashboard from '../views/admin/AdminDashboard.vue';
import OperatorDashboard from '../views/operator/OperatorDashboard.vue';
import BackofficeDashboard from '../views/backoffice/BackofficeDashboard.vue';
import NotFound from '../views/NotFound.vue';


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
    path: "/:any(.*)*",
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

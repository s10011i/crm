<script setup>
import { ref, computed } from "vue";
import UserList from "./UserList.vue";
import CreateUser from "./CreateUser.vue";

const activeTab = ref("users"); // default active tab

const activeComponent = computed(() => {
  return activeTab.value === "users" ? UserList : CreateUser;
});

const logout = () => {
  sessionStorage.clear();
  window.location.href = "/";
};
</script>

<template>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2>Admin Panel</h2>
      <ul>
        <li :class="{ active: activeTab === 'users' }" @click="activeTab='users'">Users</li>
        <li :class="{ active: activeTab === 'create' }" @click="activeTab='create'">Create User</li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="header-section">
        <div class="title-section">
          <h1>Admin Dashboard</h1>
          <p class="subtitle">Welcome, <strong>Admin</strong></p>
        </div>
        <div>
          <button class="logout-btn" @click="logout">Logout</button>
        </div>
      </header>

      <component :is="activeComponent"></component>
    </main>
  </div>
</template>

<style scoped>
.dashboard-container {
  display: flex;
  min-height: 100vh;
  font-family: Arial, sans-serif;
  background: #fafafa;
}

/* Sidebar */
.sidebar {
  width: 220px;
  background: #2c3e50;
  color: white;
  padding: 20px;
}
.sidebar ul {
  list-style: none;
  padding: 0;
}
.sidebar ul li {
  margin: 10px 0;
  padding: 8px;
  cursor: pointer;
  border-radius: 4px;
}
.sidebar ul li.active {
  background: #34495e;
}

/* Main content */
.main-content {
  flex: 1;
  padding: 20px;
}
/* Header */
.header-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 24px;
  background: #2c3e50;
  color: white;
}
.title-section h1 {
  margin: 0;
  font-size: 1.8rem;
}
.subtitle {
  margin-top: 4px;
  font-size: 0.95rem;
}
/* Buttons */
.logout-btn {
  background: #e74c3c;
  color: white;
  padding: 8px 14px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}
.logout-btn:hover {
  background: #c0392b;
}

/* Responsive */
@media (max-width: 768px) {
  .dashboard-container {
    flex-direction: column;
  }
  .sidebar {
    width: 100%;
  }
}
</style>


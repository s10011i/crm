<script setup>
import { ref, computed } from "vue";
import Entries from "./Entries.vue";
import CreateEntry from "./CreateEntry.vue";


const activeTab = ref("entries");

const activeComponent = computed(() => {
  return activeTab.value === "entries" ? Entries : CreateEntry;
});

const logout = () => {
  sessionStorage.clear();
  window.location.href = "/";
};
</script>

<template>
  <div class="dashboard-container">
    <!-- Header -->
    <header class="header-section">
      <div class="title-section">
        <h1>Operator Dashboard</h1>
        <p class="subtitle">Welcome, <strong>John</strong></p>
      </div>
      <div>
        <button class="logout-btn" @click="logout">Logout</button>
      </div>
    </header>

    <!-- Horizontal Navbar -->
    <nav class="horizontal-navbar">
      <ul>
        <li :class="{ active: activeTab === 'entries' }" @click="activeTab = 'entries'">
          Entries
        </li>
        <li :class="{ active: activeTab === 'create' }" @click="activeTab = 'create'">
          Create Entry
        </li>
      </ul>
    </nav>

    <!-- Main content -->
    <main class="main-content">
      <component :is="activeComponent"></component>
    </main>
  </div>
</template>

<style scoped>
.dashboard-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  font-family: Arial, sans-serif;
  background: #fafafa;
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
/* Horizontal navbar */
.horizontal-navbar {
  background: #ecf0f1;
  border-bottom: 1px solid #ccc;
}
.horizontal-navbar ul {
  list-style: none;
  display: flex;
  margin: 0;
  padding: 0 24px;
}
.horizontal-navbar ul li {
  margin-right: 20px;
  padding: 12px 8px;
  cursor: pointer;
}
.horizontal-navbar ul li.active {
  border-bottom: 3px solid #2980b9;
  font-weight: bold;
  color: #2980b9;
}

/* Main content */
.main-content {
  flex: 1;
  padding: 24px;
}
</style>

<script setup>
import { ref, computed } from "vue";
import Header from "../../components/ui-comps/Header.vue";
import Entries from "../../components/operator/Entries.vue";
import CreateEntry from "../../components/operator/CreateEntry.vue";


const activeTab = ref("entries");

const activeComponent = computed(() => {
    return activeTab.value === "entries" ? Entries : CreateEntry;
});

// get user
const user = JSON.parse(sessionStorage.getItem("user"));

</script>

<template>
    <div class="container">
        <!-- Header -->
        <Header title="Operator Dashboard" :user="user.name" />

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
.container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    font-family: Arial, sans-serif;
    background: #fafafa;
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
    padding: 25px;
}
</style>

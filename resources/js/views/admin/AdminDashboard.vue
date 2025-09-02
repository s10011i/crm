<script setup>
import { ref, computed } from "vue";
import Header from "../../components/ui-comps/Header.vue";
import UserList from "../../components/admin/UserList.vue";
import CreateUser from "../../components/admin/CreateUser.vue";

const activeTab = ref("users");

const activeComponent = computed(() => {
    return activeTab.value === "users" ? UserList : CreateUser;
});

// get user
const user = JSON.parse(sessionStorage.getItem("user"));

</script>

<template>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li :class="{ active: activeTab === 'users' }" @click="activeTab = 'users'">Users</li>
                <li :class="{ active: activeTab === 'create' }" @click="activeTab = 'create'">Create User</li>
            </ul>
        </aside>
        <div class="content-wrapper">
            <!-- Header section -->
            <Header title="Admin Dashboard" :user="user.name" />

            <!-- Main section -->
            <main class="main-content">
                <component :is="activeComponent"></component>
            </main>
        </div>
    </div>
</template>

<style scoped>
.container {
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

.content-wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Main content */
.main-content {
    flex: 1;
    padding: 25px;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        text-align: center;
        padding: 15px 10px;
    }

    .sidebar ul li {
        display: inline-block;
        margin: 5px 8px;
    }
}
</style>

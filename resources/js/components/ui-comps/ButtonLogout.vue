<script setup>
const logout = () => {
    sessionStorage.clear()
    window.location.href = "/"
}
</script>

<template>
    <button class="logout-btn" @click="logout">
        Logout
    </button>
</template>

<style scoped>
.logout-btn {
    background: #e74c3c;
    color: white;
    padding: 8px 14px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
}

.logout-btn:hover {
    background: #c0392b;
}
</style>

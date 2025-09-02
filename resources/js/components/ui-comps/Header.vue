<script setup>
import ButtonLogout from './ButtonLogout.vue'

defineProps({
    title: {
        type: String,
        default: 'Dashboard'
    },
    user: {
        type: String,
        default: 'Guest'
    }
})
</script>

<template>
    <header class="header-section">
        <div class="title-section">
            <h1>{{ title }}</h1>
            <p class="subtitle">Welcome, <strong>{{ user }}</strong></p>
        </div>
        <div>
            <ButtonLogout />
        </div>
    </header>
</template>

<style scoped>
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

/* Responsive */
@media (max-width: 768px) {
    .header-actions {
        width: 100%;
        display: flex;
        justify-content: flex-end;
    }

    .title-section h1 {
        font-size: 1.4rem;
    }

    .subtitle {
        font-size: 0.85rem;
    }
}
</style>

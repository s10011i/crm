<script setup>
import axios from 'axios'
import { ref } from 'vue'
import { API_BASE_URL } from '../../constants/constants.js'

const loggingOut = ref(false)

const logout = async () => {
  loggingOut.value = true
  try {
    await axios.post(`${API_BASE_URL}/logout`, {}, {
      headers: {
        'Authorization': `Bearer ${sessionStorage.getItem("token")}`
      }
    })
    sessionStorage.clear()
    window.location.href = "/"
  } catch (error) {
    console.error(error)
    alert('Failed to logout')
  } finally {
    loggingOut.value = false
  }
}
</script>

<template>
    <button class="logout-btn" @click="logout" :disabled="loggingOut">
        {{ loggingOut ? 'Logging out...' : 'Logout' }}
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

/* Responsive */
@media (max-width: 768px) {
    .logout-btn {
        padding: 6px 12px;
        font-size: 0.9rem;
    }
}
</style>

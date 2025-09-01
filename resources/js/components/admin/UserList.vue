<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const users = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchUsers = async () => {
  loading.value = true;
  error.value = null;
  try {
    const res = await axios.get("http://127.0.0.1:8000/api/admin/users", {
      headers: {
        Authorization: `Bearer ${sessionStorage.getItem("token")}`
      }
    });
    users.value = res.data;
  } catch (err) {
    error.value = err.response?.data?.message || err.message;
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchUsers();
});
</script>


<template>
  <section class="user-list">
    <h2 tyle="margin-bottom: 30px">All Users</h2>
    <table v-if="!loading">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id" class="entry-row">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.roles[0]?.name || 'N/A' }}</td>
        </tr>
      </tbody>
    </table>
  </section>
</template>


<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}
th, td {
  border: 1px solid #ddd;
  padding: 8px;
}
th {
  background: #34495e;
  color: white;
}
.entry-row:hover {
  background: #ecf0f1;
}
</style>

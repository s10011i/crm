<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const users = ref([]);

const fetchUsers = async () => {
  console.log(sessionStorage.getItem("token"));
  try {
    const res = await axios.get("http://127.0.0.1:8000/api/admin/users", {
      headers: {
        Authorization: `Bearer ${sessionStorage.getItem("token")}`
      }
    });
    console.log(res.data)
    users.value = res.data;
  } catch (err) {
    console.error(err);
  }
};

onMounted(() => {
  fetchUsers();
});
</script>


<template>
  <section class="user-list">
    <h2>All Users</h2>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
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
</style>

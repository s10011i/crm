<script setup>
import { ref } from "vue";
import axios from "axios";

const form = ref({
  name: "",
  email: "",
  username: "",
  password: "",
  role: ""
});
const message = ref("");

const createUser = async () => {
  try {
    const res = await axios.post(
      "http://127.0.0.1:8000/api/admin/users",
      form.value,
      { headers: { Authorization: `Bearer ${sessionStorage.getItem("token")}` } }
    );
    message.value = res?.data?.message;
    alert("User created successfully");
    form.value = { name: "", email: "", username: "", password: "", role: "" };
  } catch (err) {
    console.error(err);
    alert("Error creating user");
  }
};
</script>


<template>
  <section class="create-user">
    <h2>Create New User</h2>
    <form @submit.prevent="createUser">
      <input type="text" v-model="form.name" placeholder="Name" required />
      <input type="email" v-model="form.email" placeholder="Email" required />
      <input type="text" v-model="form.username" placeholder="Username" required />
      <input type="password" v-model="form.password" placeholder="Password" required />
      <select v-model="form.role" required>
        <option disabled value="">Select Role</option>
        <option value="operator">Operator</option>
        <option value="backoffice">Backoffice</option>
      </select>
      <button type="submit">Create User</button>
    </form>
    <p v-if="message" class="message">{{ message }}</p>
  </section>
</template>


<style scoped>
form {
  display: flex;
  flex-direction: column;
  max-width: 400px;
}
input, select {
  margin-bottom: 10px;
  padding: 8px;
}
button {
  padding: 10px;
  background: #2980b9;
  border: none;
  color: white;
  cursor: pointer;
}
button:hover {
  background: #1c5980;
}
.message {
  margin-top: 12px;
  color: #1c5980;
}
</style>

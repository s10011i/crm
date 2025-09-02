<script setup>
import { ref } from "vue";
import axios from "axios";
import { API_BASE_URL } from '../../constants/constants.js'

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
      `${API_BASE_URL}/admin/users`,
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
    <form @submit.prevent="createUser" class="entry-form">
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
h2 {
  margin-bottom: 20px;
}
/* Form */
.entry-form {
  display: flex;
  flex-direction: column;
  width: 100%;
  max-width: 450px;
  padding: 20px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
input, select {
  margin-bottom: 10px;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
  width: 100%;
  box-sizing: border-box;
}
/* Button */
button {
  padding: 10px;
  background: #1c5980;
  border: none;
  color: white;
  cursor: pointer;
  font-weight: 600;
  font-size: 1rem;
  border-radius: 6px;
}
button:hover {
  background: #2980b9;
}
.message {
  margin-top: 12px;
  color: #1c5980;
  font-weight: 500;
}
</style>

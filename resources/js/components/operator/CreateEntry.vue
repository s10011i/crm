<script setup>
import { reactive, ref } from "vue";
import axios from "axios";
import { API_BASE_URL } from '../../constants/constants.js'

const form = reactive({
  first_name: "",
  last_name: "",
  phone_number: "",
  complain: "",
});

const message = ref("");

const submitEntry = async () => {
  // Simple validation
  if (!form.first_name || !form.last_name || !form.phone_number || !form.complain) {
    message.value = "All fields are required!";
    return;
  }

  try {
    const res = await axios.post(
      `${API_BASE_URL}/operator/entries`,
      form,
      {
        headers: {
          Authorization: `Bearer ${sessionStorage.getItem("token")}`,
        },
      }
    );
    message.value = res?.data?.message;
    // Reset form
    form.first_name = "";
    form.last_name = "";
    form.phone_number = "";
    form.complain = "";
  } catch (err) {
    console.error(err);
    message.value = "Error creating entry!";
  }
};
</script>

<template>
  <div class="form-wrapper">
    <h2>Create New Entry</h2>
    <form @submit.prevent="submitEntry" class="entry-form">
      <label>
        First Name:
        <input type="text" v-model="form.first_name" />
      </label>

      <label>
        Last Name:
        <input type="text" v-model="form.last_name" />
      </label>

      <label>
        Phone Number:
        <input type="number" v-model="form.phone_number" min="1" />
      </label>

      <label>
        Complain:
        <textarea v-model="form.complain"></textarea>
      </label>

      <button type="submit">Create</button>
    </form>

    <p v-if="message" class="message">{{ message }}</p>
  </div>
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
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.entry-form label {
  margin-bottom: 10px;
  display: flex;
  flex-direction: column;
  font-weight: 500;
}
.entry-form input,
.entry-form textarea {
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
  width: 100%;
  box-sizing: border-box;
}
.entry-form textarea {
  resize: vertical;
  min-height: 80px;
}
/* Button */
.entry-form button {
  padding: 12px;
  background: #1c5980;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 1rem;
  font-weight: 600;
  margin-top: 10px;
}
.entry-form button:hover {
  background: #2980b9;
}
.message {
  margin-top: 12px;
  color: #1c5980;
  font-weight: 500;
}
/* Responsive  */
@media (max-width: 768px) {
  .form-wrapper {
    padding: 10px;
  }

  .entry-form {
    padding: 15px;
  }

  .entry-form input,
  .entry-form textarea {
    font-size: 0.95rem;
    padding: 8px;
  }

  .entry-form button {
    font-size: 0.95rem;
    padding: 10px;
  }
}
</style>

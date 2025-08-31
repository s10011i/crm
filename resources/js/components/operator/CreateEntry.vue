<script setup>
import { reactive, ref } from "vue";
import axios from "axios";

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
      "http://127.0.0.1:8000/api/operator/entries",
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
  <div class="create-entry">
    <h2 style="margin-bottom: 30px">Create New Entry</h2>
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
.entry-form {
  display: flex;
  flex-direction: column;
  max-width: 400px;
}
.entry-form label {
  margin-bottom: 12px;
  display: flex;
  flex-direction: column;
}
.entry-form input,
.entry-form textarea {
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.entry-form button {
  padding: 10px 12px;
  background: #1c5980;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.entry-form button:hover {
  background: #2980b9;
}
.message {
  margin-top: 12px;
  color: #1c5980;
}
</style>

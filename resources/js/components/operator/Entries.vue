<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";

const entries = ref([]);
const loading = ref(true);
const error = ref(null);
const searchQuery = ref("");

// Fetch entries
const fetchEntries = async () => {
  loading.value = true;
  error.value = null;
  try {
    const res = await axios.get("http://127.0.0.1:8000/api/operator/entries", {
      headers: {
        Authorization: `Bearer ${sessionStorage.getItem("token")}`,
      },
    });
    entries.value = res.data;
  } catch (err) {
    error.value = err.response?.data?.message || err.message;
  } finally {
    loading.value = false;
  }
};

// Filtered entries for search
const filteredEntries = computed(() => {
  if (!searchQuery.value) return entries.value;

  const query = searchQuery.value.toLowerCase();
  return entries.value.filter(entry =>
    entry.first_name.toLowerCase().includes(query) ||
    entry.last_name.toLowerCase().includes(query) ||
    entry.phone_number.toLowerCase().includes(query)
  );
});

onMounted(() => {
  fetchEntries();
});
</script>

<template>
  <div class="entries-container">
    <h2>Entries</h2>

    <!-- Search input -->
    <input
      type="text"
      v-model="searchQuery"
      placeholder="Search by first name, last name or phone number"
      class="search-input"
    />

    <div v-if="loading">Loading entries...</div>
    <div v-if="error" class="error">{{ error }}</div>

    <table v-if="!loading && filteredEntries.length">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Phone Number</th>
          <th>Status</th>
          <th>Assigned To</th>
          <th>Comments</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="entry in filteredEntries" :key="entry.id">
          <td>{{ entry.first_name }}</td>
          <td>{{ entry.last_name }}</td>
          <td>{{ entry.phone_number }}</td>
          <td>{{ entry.status }}</td>
          <td>{{ entry.assignee?.username || "Unassigned" }}</td>
          <td>
            <ul v-if="entry.comments && entry.comments.length">
              <li v-for="comment in entry.comments" :key="comment.id">
                <strong>{{ comment.user.username }}:</strong> {{ comment.body }}
              </li>
            </ul>
            <span v-else>No comments</span>
          </td>
        </tr>
      </tbody>
    </table>

    <div v-if="!loading && filteredEntries.length === 0">No entries found.</div>
  </div>
</template>

<style scoped>
.entries-container {
  font-family: Arial, sans-serif;
  padding: 20px;
}

.search-input {
  margin-top: 10px;
  padding: 8px 12px;
  width: 100%;
  max-width: 400px;
  border-radius: 4px;
  border: 1px solid #ccc;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  padding: 10px;
  border: 1px solid #ccc;
  text-align: left;
}

th {
  background-color: #f4f6f9;
}

.error {
  color: red;
  margin-top: 10px;
}
</style>

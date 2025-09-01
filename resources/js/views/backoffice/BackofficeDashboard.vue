<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import Header from "../../components/ui-comps/Header.vue";
import EntryDetail from "../../components/backoffice/EntryDetail.vue";

const entries = ref([]);
const loading = ref(true);
const error = ref(null);
const searchQuery = ref("");

const selectedEntry = ref(null);
const showModal = ref(false);

// get user from sessionStorage
const user = JSON.parse(sessionStorage.getItem("user"));

// Fetch entries
const fetchEntries = async () => {
  loading.value = true;
  error.value = null;
  try {
    const res = await axios.get("http://127.0.0.1:8000/api/backoffice/entries", {
      headers: { Authorization: `Bearer ${sessionStorage.getItem("token")}` },
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
  return entries.value.filter(
    (entry) =>
      entry.first_name.toLowerCase().includes(query) ||
      entry.last_name.toLowerCase().includes(query) ||
      entry.phone_number.toLowerCase().includes(query)
  );
});

const selectEntry = (entry) => {
  selectedEntry.value = entry;
  showModal.value = true;
};

const closeModal = () => {
  selectedEntry.value = null;
  showModal.value = false;
};

const handleUpdated = (updatedEntry) => {
  // update only the changed entry in the list
  const idx = entries.value.findIndex(e => e.id === updatedEntry.id);
  if (idx !== -1) {
    entries.value[idx] = updatedEntry;
  }
  closeModal();
};

onMounted(() => {
  fetchEntries();
});
</script>

<template>
  <div class="container">
    <!-- Header -->
    <Header title="Backoffice Dashboard" :user="user.name" />

    <!-- Entries Section -->
    <section class="entries-container">
      <h2 style="margin-bottom: 30px">Entries</h2>

      <!-- Search Bar -->
      <input
        type="text"
        v-model="searchQuery"
        placeholder="🔍 Search by first name, last name or phone..."
        class="search-bar"
      />

      <div v-if="loading" class="loading">Loading entries...</div>
      <div v-if="error" class="error">{{ error }}</div>

      <!-- Entries Table -->
      <table v-if="!loading && filteredEntries.length" class="entries-table">
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
          <tr
            v-for="entry in filteredEntries"
            :key="entry.id"
            @click="selectEntry(entry)"
            class="entry-row"
          >
            <td>{{ entry.first_name }}</td>
            <td>{{ entry.last_name }}</td>
            <td>{{ entry.phone_number }}</td>
            <td>
              <span :class="['status-badge', entry.status]">{{ entry.status }}</span>
            </td>
            <td>{{ entry.assignee?.username || "Unassigned" }}</td>
            <td>
              <ul v-if="entry.comments && entry.comments.length">
                <li v-for="comment in entry.comments" :key="comment.id">
                  <strong>{{ comment.user.username }}:</strong><span class="comments">{{ comment.body }}</span>
                </li>
              </ul>
              <span v-else class="comments">No comments</span>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="!loading && filteredEntries.length === 0" class="no-results">
        No entries found.
      </div>
    </section>
    <!-- Entry Detail Modal -->
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <EntryDetail
          v-if="selectedEntry"
          :entry="selectedEntry"
          @close="closeModal"
          @updated="handleUpdated"
        />
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Layout */
.container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  font-family: Arial, sans-serif;
  background: #fafafa;
}
.entries-container{
  flex: 1;
  padding: 25px;
}

/* Search */
.search-bar {
  margin-bottom: 14px;
  padding: 8px 12px;
  width: 100%;
  max-width: 420px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 0.95rem;
}

/* Table */
.entries-table {
  width: 100%;
  border-collapse: collapse;
  background: white;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  border-radius: 8px;
  overflow: hidden;
}
.entries-table th {
  background: #1c5980;
  color: white;
  padding: 10px;
  text-align: left;
}
.entries-table td {
  border-bottom: 1px solid #eee;
  padding: 10px;
  vertical-align: top;
}
.entry-row:hover {
  background: #ecf0f1;
  cursor: pointer;
}

/* Status badges */
.status-badge {
  padding: 3px 8px;
  border-radius: 12px;
  font-size: 0.8rem;
  font-weight: bold;
  text-transform: capitalize;
}
.status-badge.pending {
  background: #f39c12;
  color: white;
}
.status-badge.in_progress {
  background: #3498db;
  color: white;
}
.status-badge.closed {
  background: #2ecc71;
  color: white;
}
ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

/* Comments */
.comments {
  color: #888;
  font-style: italic;
  font-size: 0.9rem;
}
/* Modal */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
.modal-content {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  max-width: 800px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
}

/* Misc */
.loading,
.error,
.no-results {
  margin-top: 15px;
  font-size: 1rem;
}
</style>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { API_BASE_URL } from '../../constants/constants.js'

const props = defineProps({
  entry: Object,
});
const emit = defineEmits(["close", "updated"]);

const status = ref(props.entry.status);
const assignee_id = ref(props.entry.assignee?.id || null);
const comment = ref("");

// Fetch operators
const operators = ref([]);
const fetchOperators = async () => {
  try {
    const res = await axios.get(`${API_BASE_URL}/backoffice/users`, {
      headers: { Authorization: `Bearer ${sessionStorage.getItem("token")}` }
    });
    operators.value = res.data.filter(user => user.roles?.some(r => r.name === 'operator'));
  } catch (err) {
    console.error(err);
  }
};

fetchOperators();

const updateEntry = async () => {
  try {
    const res = await axios.put(
      `${API_BASE_URL}/backoffice/entries/${props.entry.id}`,
      { status: status.value,
        assignee_id: assignee_id.value,
        comment: comment.value
      },
      { headers: { Authorization: `Bearer ${sessionStorage.getItem("token")}` } }
    );
    comment.value = "";
    // send the fresh entry back to parent
    emit("updated", res.data.entry);
    emit("close");
  } catch (err) {
    console.error(err);
  }
};

const closeModal = () => emit("close");
</script>

<template>
  <div class="modal">
    <h3>Update Entry</h3>
    <p class="entry-name"><strong>{{ entry.first_name }} {{ entry.last_name }}</strong></p>

    <label>
      Status:
      <select v-model="status">
        <option value="pending">Pending</option>
        <option value="in_progress">In Progress</option>
        <option value="closed">Closed</option>
      </select>
    </label>

    <label>
      Assign to Operator:
      <select v-model="assignee_id">
        <option :value="null">Unassigned</option>
        <option v-for="op in operators" :key="op.id" :value="op.id">{{ op.name }}</option>
      </select>
    </label>

    <label>
      Comment:
      <textarea v-model="comment" placeholder="Add a comment"></textarea>
    </label>

    <div class="modal-actions">
      <button class="btn-save" @click="updateEntry">Save</button>
      <button class="btn-cancel" @click="closeModal">Cancel</button>
    </div>
  </div>
</template>

<style scoped>
.modal {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

h3 {
  margin-bottom: 5px;
  font-size: 1.4rem;
  color: #2c3e50;
}

.entry-name {
  margin-bottom: 10px;
  font-size: 1rem;
  color: #444;
}

label {
  display: flex;
  flex-direction: column;
  font-size: 0.95rem;
  color: #333;
}

select,
textarea {
  margin-top: 6px;
  padding: 8px;
  font-size: 0.95rem;
  border: 1px solid #ccc;
  border-radius: 6px;
}

textarea {
  min-height: 80px;
  resize: vertical;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 10px;
}

button {
  padding: 8px 14px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 0.95rem;
}

.btn-save {
  background: #1c5980;
  color: #fff;
}

.btn-save:hover {
  background: #2980b9;
}

.btn-cancel {
  background: #ccc;
  color: #333;
}

.btn-cancel:hover {
  background: #999;
}

/* 🔹 Responsive Styles */
@media (max-width: 768px) {
  .modal {
    padding: 10px;
  }

  h3 {
    font-size: 1.2rem;
  }

  select,
  textarea,
  button {
    font-size: 0.9rem;
  }

  .modal-actions {
    flex-direction: column;
    align-items: stretch;
  }

  .btn-save,
  .btn-cancel {
    width: 100%;
  }
}

@media (max-width: 480px) {
  .modal {
    gap: 10px;
  }

  h3 {
    font-size: 1.1rem;
    text-align: center;
  }

  .entry-name {
    text-align: center;
    font-size: 0.95rem;
  }

  label {
    font-size: 0.9rem;
  }

  .modal-actions {
    gap: 8px;
  }
}
</style>

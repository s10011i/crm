<script setup>
import { ref } from "vue";
import axios from "axios";

const props = defineProps({
  entry: Object,
  operators: Object
});
const emit = defineEmits(["close", "updated"]);

const status = ref(props.entry.status);
const assignee_id = ref(props.entry.assignee?.id || null);
const comment = ref("");

// Fetch operators
const operators = ref([]);
const fetchOperators = async () => {
  try {
    const res = await axios.get("http://127.0.0.1:8000/api/backoffice/users", {
      headers: { Authorization: `Bearer ${sessionStorage.getItem("token")}` }
    });
    operators.value = res.data.filter(user => user.roles?.some(r => r.name === 'operator'));
  } catch (err) {
    console.error(err);
  }
};

// onMounted(() => {
  fetchOperators();
// });

const updateEntry = async () => {
  try {
    const res = await axios.put(
      `http://127.0.0.1:8000/api/backoffice/entries/${props.entry.id}`,
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
    <p><strong>{{ entry.first_name }} {{ entry.last_name }}</strong></p>

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
        <option v-for="op in operators" :key="op.id" :value="op.id">{{ op.username }}</option>
      </select>
    </label>

    <label>
      Comment:
      <textarea v-model="comment" placeholder="Add a comment"></textarea>
    </label>

    <button @click="updateEntry">Save</button>
    <button @click="closeModal">Cancel</button>
  </div>
</template>

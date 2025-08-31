<script setup>
import { onMounted, ref } from 'vue';
import router from '../../../router';
import { RouterLink, RouterView } from 'vue-router';


let form = ref({})
let employees = ref([])
let employee_id = ref()

const props = defineProps({
  id: {
    type: String,
    default: ''
  }
})

onMounted(async () => {
  getEntry();
  getBackofficeEmployees();
})

const getBackofficeEmployees = async () => {
  let response = await axios.get("/api/get_backoffice_employees")
  employees.value = response.data.employees;
}

const getEntry = async () => {
  let response = await axios.get(`/api/entry_front_edit/${props.id}`)
  form.value = response.data.entry
}

const assignToEmployee = async () => {
  if (employee_id.value != undefined) {
    const { assignee_id, ...rest } = form.value;
    const payload = { ...rest, 'assignee_id': employee_id.value };
    $response = await axios.post("api/assign_to_employee", payload)
    if ($response.status == 200) {
      alert('assigned successfully');
      router.push('/display_all_entries')
    }
  }
}

</script>

<template>
  <div class="container">
    <h1 class="invoice__title">Assign Entry to Backoffice Employee</h1>
    <RouterLink class="btn btn-secondary" style="float:right;margin:-50px 20px 0 0" to="/display_all_entries">Back
    </RouterLink>
    <div class="card__content">
      <div style="display: flex; padding: 30px;">
        <div>
          <div style="display: flex; flex-direction:row; margin:15px">
            <h3 style="margin-right:10px;">Customer:</h3>
            <p>{{ form?.requester }}</p>
          </div>
          <div style="display: flex; flex-direction:row; margin:15px">
            <h3 style="margin-right:10px;">Date:</h3>
            <p>{{ form?.date }}</p>
          </div>
          <div style="display: flex; flex-direction:row; margin:15px">
            <h3 style="margin-right:10px;">Complains:</h3>
            <p>{{ form?.complains }}</p>
          </div>
          <div style="display: flex; flex-direction:row; margin:15px">
            <h3 style="margin-right:10px;">Status:</h3>
            <p>{{ form?.status }}</p>
          </div>
          <div v-if="form?.assignee_id" style="display: flex; flex-direction:row; margin:15px">
            <h3 style="margin-right:10px;">Assigned To:</h3>
            <p>{{ form?.user?.name }}</p>
          </div>
          <div v-else></div>
          <div v-if="form?.comment" style="display: flex; flex-direction:row; margin:15px">
            <h3 style="margin-right:10px;">Comment:</h3>
            <p>{{ form?.comment }}</p>
          </div>
          <div v-else></div>
          <div v-if="!form.assignee_id" style="display: flex; flex-direction:row; margin:15px;">
            <h3 style="margin-right:10px;">Assign To Backoffice Employee:</h3>
            <select name="" id="" style="margin-top:-7px;padding: 5px;border: 1px solid #e0e0e0;
            border-radius: 4px; width:250px;height:35px" v-model="employee_id">
              <option disabled>Assign to</option>
              <option v-if="employees.length > 0" v-for="employee in employees" :value="employee?.id" :key="employee?.id">
                {{ employee?.name }}</option>
            </select>
          </div>
          <div v-else></div>
        </div>
      </div>
      <div style="float:right; margin:0 20px 0 0">
        <div>
          <a class="btn btn-secondary" @click="assignToEmployee()">
            Save
          </a>
        </div>
      </div>
    </div>
  </div>
</template>


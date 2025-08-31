<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
  id: {
    type: String,
    default: ''
  }
})

let my_comment = ref()
let stat = ref()
let my_entries = ref([])

const showModal = ref(false)

onMounted(async () => {
  getEntries();
})

const getEntries = async () => {
  let response = await axios.get(`/api/my_entries/${props.id}`)
  my_entries.value = response.data.my_entries
}

const openModal = () => {
  showModal.value = !showModal.value
}

const closeModal = () => {
  showModal.value = !showModal.value
}

const changeStatus = (idx) => {
  my_entries.value[idx].status = stat.value
  showModal.value = !showModal.value
}

const onSave = async (idx) => {
  my_entries.value[idx].comment = my_comment.value

  if (stat.value != undefined || my_comment.value != undefined) {
    $response = await axios.post("api/entry_back_update", my_entries.value[id])
    if ($response.status == 200) {
      alert('updated successfully');
    }
  }
}
</script>

<template>
  <div class="container">
    <div class="invoices">
      <div class="card__header">
        <div>
          <h1 class="invoice__title">My Entries</h1>
        </div>
      </div>

      <div class="table card__content">
        <div class="table--heading">
          <p>Customer</p>
          <p>Complain</p>
          <p>Status</p>
          <p>Comment</p>
        </div>

        <div class="table--items" v-if="my_entries.length > 0" v-for="(item, idx) in my_entries" :key="item.id">
          <p>{{ item?.requester }}</p>
          <p>{{ item?.complains }}</p>
          <div style="margin-left: 50px;">
            <a class="btn btn-secondary" @click="openModal()">{{ item?.status }}</a>
          </div>
          <textarea cols="70" rows="4" class="textarea" v-model="my_comment">{{ item?.comment }}</textarea>
          <div style="margin-left: 100px;">
            <a class="btn btn-secondary" @click="onSave(idx)">
              Save
            </a>
          </div>
          <!-- modal starts -->
          <div class="modal main__modal" :class="{ show: showModal }">
            <div class="modal__content">
              <span class="modal__close btn__close--modal" @click="closeModal()">×</span>
              <h3 class="modal__title">Change Status</h3>
              <hr><br>
              <div class="modal__items">
                <select class="input my-1" v-model="stat">
                  <option value="pending">Pending</option>
                  <option value="in_progress">In Progress</option>
                  <option value="completed">Completed</option>
                </select>
              </div>
              <br>
              <hr>
              <div class="model__footer">
                <button class="btn btn-light mr-2 btn__close--modal" @click="closeModal()">
                  Cancel
                </button>
                <button class="btn btn-light btn__close--modal" @click="changeStatus(idx)">Save</button>
              </div>
            </div>
          </div>

        </div>
        <div class="table--items" v-else>
          <p>No Entries yet</p>
        </div>
      </div>
    </div>
  </div>
</template>
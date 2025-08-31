<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';


const router = useRouter();

let entries = ref([])
let search = ref([])

onMounted(async () => {
  getEntries();
})

const getEntries = async () => {
  let response = await axios.get("/api/get_all_entries")
  entries.value = response.data.entries;
}

const getSearch = async () => {
  let response = await axios.get("/api/search_entries?s=" + search.value)
  entries.value = response.data.entries;
}

const onEdit = async (id) => {
  router.push('/entry_front_edit/' + id)
}
</script>

<template>
  <div class="container">
    <div class="invoices">

      <div class="card__header">
        <div>
          <h1 class="invoice__title">Entries</h1>
        </div>
      </div>

      <div class="table card__content">
        <div class="table--search">
          <div class="table--search--wrapper">
            <select class="table--search--select" name="" id="">
              <option value="">Filter</option>
            </select>
          </div>
          <div class="relative">
            <i class="table--search--input--icon fas fa-search "></i>
            <input class="table--search--input" type="text" placeholder="Search entries" v-model="search"
              @keyup="getSearch()">
          </div>
        </div>

        <div class="table--heading">
          <p>ID</p>
          <p>Customer</p>
          <p>Complain</p>
          <p>Status</p>
          <p>AssignedTo</p>
          <p>Comment</p>
        </div>

        <div class="table--items" v-for="item in entries" :key="item.id" v-if="entries.length > 0">
          <a href="#" class="table--items--transactionId" @click="onEdit(item?.id)">#{{ item?.id }}</a>
          <p>{{ item?.requester }}</p>
          <p>{{ item?.complains }}</p>
          <p>{{ item?.status }}</p>
          <p v-if="item?.user">
            {{ item?.user?.name }}
          </p>
          <p v-else></p>
          <p>{{ item?.comment }}</p>
        </div>
        <div class="table--items" v-else>
          <p>No Entries yet</p>
        </div>
      </div>

    </div>
  </div>
</template>

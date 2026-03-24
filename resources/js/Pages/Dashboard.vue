<script setup>
import { ref, computed, reactive, watch} from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import SemiTab from '@/Components/SemiTab.vue'
import CommoditiesTable from '@/Components/CommoditiesList.vue'
import PesticidesTable from '@/Components/PesticidesList.vue'
import AddModal from '@/Components/AddModal.vue'

const props = defineProps({
  commodities: Array,
  pesticides: Array,
  filters: Object
})

const activeTab = ref('commodities')

const tabs = [
  { label: 'Commodities', value: 'commodities' },
  { label: 'Pesticides', value: 'pesticides' }
]


const showModal = ref(false)
const formType = ref(null)

const form = reactive({
  name: '',
  type: ''
})

const openForm = (payload) => {
  formType.value = payload.type

  form.name = ''
  form.type = payload.type

  showModal.value = true
}

const currentForm = computed(() => {
  switch (formType.value) {
    case 'commodity':
      return CommodityForm
    case 'pesticide':
      return PesticideForm
    default:
      return null
  }
})

const submit = () => {
  console.log('Submitting:', form)

  // later → Inertia.post('/route', form)

  showModal.value = false

  form.name = ''
  form.type = ''
}
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Overview
        </h2>
      </div>
    </template>

  <SemiTab v-model="activeTab" :tabs="tabs" />

  <CommoditiesTable
    v-if="activeTab === 'commodities'"
    :commodities="commodities"
    :filters="filters"
    @open-form="openForm"
  />

  <PesticidesTable
    v-if="activeTab === 'pesticides'"
    :pesticides="pesticides"
    :filters="filters"
    @open-form="openForm"
  />

  </AuthenticatedLayout>

<AddModal :show="showModal" @close="showModal = false">
  <h2 class="text-lg font-bold mb-4">
    Add {{ form.type }}
  </h2>

  <form @submit.prevent="submit">
    
    <!-- Name input -->
    <div class="mb-4">
      <label class="block text-sm mb-1">Name</label>
      <input
        v-model="form.name"
        type="text"
        class="w-full border rounded px-3 py-2"
        placeholder="Enter name"
      />
    </div>

    <!-- Optional: show type (readonly) -->
    <div class="mb-4">
      <label class="block text-sm mb-1">Type</label>
      <input
        :value="form.type"
        disabled
        class="w-full border rounded px-3 py-2 bg-gray-100"
      />
    </div>

    <!-- Actions -->
    <div class="flex justify-end gap-2">
      <button
        type="button"
        @click="showModal = false"
        class="px-4 py-2 bg-gray-200 rounded"
      >
        Cancel
      </button>

      <button
        type="submit"
        class="px-4 py-2 bg-green-600 text-white rounded"
      >
        Save
      </button>
    </div>

  </form>
</AddModal>


</template>
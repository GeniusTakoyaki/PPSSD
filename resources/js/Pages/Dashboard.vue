<script setup>
import { ref, watch} from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm, router, usePage } from '@inertiajs/vue3'
import SemiTab from '@/Components/SemiTab.vue'
import CommoditiesTable from '@/Components/CommoditiesList.vue'
import PesticidesTable from '@/Components/PesticidesList.vue'
import AddModal from '@/Components/AddModal.vue'
import SlidingPanel from '@/Components/SlidingPanel.vue'
import MrlTable from '@/Components/MrlTable.vue'


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

const form = useForm({
  name: '',
  type: '',
  subtype: ''
})

const openForm = (payload) => {
  formType.value = payload.type

  form.name = ''
  form.type = ''
  form.subtype = ''
  form.title = payload.type

  showModal.value = true
}


const submit = () => {
  const url = form.title === 'pesticides'
    ? '/pesticides'
    : '/commodities'

  form.post(url, {
    onSuccess: () => {
      showModal.value = false

      form.reset()
    },

    onError: () => {
      // do nothing → modal stays open, errors show
    }
  })
}


const showPanel = ref(false)
const selectedItem = ref(null)


const selectedId = ref(null)
const selectedType = ref(null)

const openPanel = async ({ type, id }) => {
  const response = await fetch(`/dashboard/${type}/${id}/data`)
  selectedItem.value = await response.json()
  selectedId.value = id        // ← store the id
  selectedType.value = type    // ← store the type
  showPanel.value = true
}


watch(showPanel, (val) => {
  document.body.style.overflow = val ? 'hidden' : ''
})

const showSuccess = ref(false)
const showError = ref(false)

const handleSave = (dirtyItems) => {
  console.log('Sending to backend:', JSON.stringify(dirtyItems, null, 2))

  router.post(route('mrl.bulkUpdate'), {
    items: dirtyItems.map(item => ({
      ...item,
      commodity_id: selectedType.value === 'commodity' ? selectedId.value : item.id,
      pesticide_id: selectedType.value === 'pesticide' ? selectedId.value : item.id,
    }))
  }, {
    preserveScroll: true,
  })
}

const page = usePage()

const successKey = ref(0)
const errorKey = ref(0)

watch(() => page.props.flash?.success, (val) => {
  if (val) {
    successKey.value++
  }
})

watch(() => page.props.flash?.error, (val) => {
  if (val) {
    errorKey.value++
  }
})

watch(successKey, () => {
  showSuccess.value = true
  setTimeout(() => showSuccess.value = false, 3000)
})

watch(errorKey, () => {
  showError.value = true
  setTimeout(() => showError.value = false, 3000)
})



</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <!-- <template #header>
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Overview
        </h2>
      </div>
    </template> -->

  <SemiTab v-model="activeTab" :tabs="tabs" />

  <CommoditiesTable
    v-if="activeTab === 'commodities'"
    :commodities="commodities"
    :filters="filters"
    @open-form="openForm"
    @openPanel="openPanel"
  />

  <PesticidesTable
    v-if="activeTab === 'pesticides'"
    :pesticides="pesticides"
    :filters="filters"
    @open-form="openForm"
    @openPanel="openPanel"
  />

  </AuthenticatedLayout>

 

<AddModal :show="showModal" @close="showModal = false">
  <h2 class="text-lg font-bold mb-4">
    Add {{ form.title }}
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
        required
      />
    </div>

    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">
    {{ form.errors.name }}
    </div>
   

    <div v-if="form.title ==='commodities'" class="mb-4" >
      <label class="block text-sm mb-1">Type</label>
      <input
        v-model="form.type"
        type="text"
        class="w-full border rounded px-3 py-2"
        placeholder="Select Type"
        required
      />
    </div>


    <div v-if="form.title ==='commodities'" class="mb-4">
      <label class="block text-sm mb-1">Subtype</label>
      <input
        v-model="form.subtype"
        type="text"
        class="w-full border rounded px-3 py-2"
        placeholder="Select Subtype"
        required
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


<SlidingPanel
  :show="showPanel"
  @close="showPanel = false"
>   <h2 class="text-lg font-bold">
      {{ selectedItem?.name }}
    </h2>

  <MrlTable
    :items="selectedItem"
    mode="commodity"
    :title="activeTab === 'pesticides' ? 'List of Pesticides with MRLs' : 'List of Commodities with MRLs'"
    :label="activeTab.charAt(0).toUpperCase() + activeTab.slice(1)"
    @saveAll="handleSave"
  />


</SlidingPanel>

<div 
  v-if="showSuccess"
  class="fixed top-4 right-4 z-50 bg-green-600 text-white px-4 py-2 rounded shadow-lg text-sm"
>
  ✓ MRL values updated.
</div>

<div v-if="showError"
     class="fixed top-4 right-4 z-50 bg-red-600 text-white px-4 py-2 rounded shadow-lg text-sm">
    ✕ Something went wrong.
</div>

</template>
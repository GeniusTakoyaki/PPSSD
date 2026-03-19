<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import SemiTab from '@/Components/SemiTab.vue'
import CommoditiesTable from '@/Components/CommoditiesList.vue'
import PesticidesTable from '@/Components/PesticidesList.vue'

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
  />

  <PesticidesTable
    v-if="activeTab === 'pesticides'"
    :pesticides="pesticides"
    :filters="filters"
  />

  </AuthenticatedLayout>
</template>
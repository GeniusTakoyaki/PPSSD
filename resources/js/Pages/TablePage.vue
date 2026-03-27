<template>
  <Head title="List"></Head>
  <div>
    <!-- Navbar -->
    <Navbar />

    <DataTable
        :results="results"
        :category="category"
        :name="name"
      />
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import Navbar from '@/Components/Navbar.vue'
import DataTable from '@/Components/DataTable.vue'

const props = defineProps({
  name:   String,
  category:    String,
  results: { type: Array, default: () => [] }
})


</script>
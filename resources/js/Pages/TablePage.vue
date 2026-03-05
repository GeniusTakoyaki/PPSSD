<template>
  <Head title="List"></Head>
  <div>
    <!-- Navbar -->
    <Navbar />

    <!-- Front Page Body -->
    <SearchBox />

  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import Navbar from '@/Components/Navbar.vue'
import SearchBox from '@/Components/DataTable.vue'
</script>
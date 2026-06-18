<template>
  <Head title="Search"></Head>
  <div class="relative min-h-screen">
    <!-- Background image -->
    <div
      class="absolute inset-0 bg-cover bg-center"
      :style="{ backgroundImage: `url(${fruitsbackground})` }"
    ></div>

    <!-- Classy dark gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70"></div>

    <!-- Actual content -->
    <div class="relative z-10">
      <Navbar />
      <SearchBox />
    </div>
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import Navbar from '@/Components/Navbar.vue'
import SearchBox from '@/Components/SearchBox.vue'
import fruitsbackground from '@/assets/fruits.png'
</script>
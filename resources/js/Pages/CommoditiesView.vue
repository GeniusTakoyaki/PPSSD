<template>
  <Navbar />
  <div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-green-800 mb-6">Commodities</h1>

    <!-- Header + Search -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
      <p class="text-gray-500 text-sm">Browse items alphabetically</p>
      <div class="relative md:w-80">
        <input
          v-model="search"
          type="text"
          placeholder="Search..."
          class="w-full px-4 py-2 pl-10 rounded-xl border border-gray-200 shadow-sm focus:ring-2 focus:ring-green-600 focus:outline-none"
        />
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
      </div>
    </div>

    <!-- Alphabet Filter -->
    <div class="sticky top-0 z-10 bg-white/80 backdrop-blur border border-gray-100 rounded-2xl shadow-sm p-2 mb-6">
      <div class="flex flex-wrap gap-2 justify-center p-1">
        <button
          @click="activeLetter = 'ALL'"
          :class="activeLetter === 'ALL' ? 'bg-green-800 text-white shadow' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
          class="px-4 py-1.5 rounded-full text-sm font-medium transition"
        >
          All
        </button>
        <button
          v-for="letter in alphabet"
          :key="letter"
          @click="activeLetter = letter"
          :class="activeLetter === letter ? 'bg-green-700 text-white shadow-md scale-105' : 'bg-green-50 text-green-800 hover:bg-green-100'"
          class="px-3 py-1.5 rounded-full text-sm font-semibold transition"
        >
          {{ letter }}
        </button>
      </div>
    </div>

    <AZList :items="commodities" />
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import Navbar from '@/Components/Navbar.vue'
import AZList from '@/Components/AZList.vue'

const props = defineProps({
  commodities: Array,
  filters: Object
})

const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("")
const search = ref(props.filters?.search || '')
const activeLetter = ref(props.filters?.letter || 'ALL')

watch([search, activeLetter], () => {
  router.get(
    route('commodities.index'),
    {
      search: search.value || null,
      letter: activeLetter.value === 'ALL' ? null : activeLetter.value
    },
    { preserveState: true, replace: true }
  )
}, { debounce: 300 })
</script>
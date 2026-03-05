<template>
  <div class="min-h-screen bg-gradient-to-b from-slate-50 to-slate-100 p-6 lg:p-10">
    <div class="mx-auto max-w-7xl">
      
      <!-- Header: Title left, Controls right -->
      <div class="mb-10 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6">
        
        <!-- Title -->
        <div class="flex-1">
          <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Pesticides & MRL Dashboard</h1>
          <p class="mt-1.5 text-sm text-slate-600">Maximum Residue Limits overview</p>
        </div>

        <div class="flex w-full max-w-2xl items-center gap-3">
          <select
            v-model="selectedType"
            class="h-12 w-44 rounded-full border border-slate-200 bg-white/80 px-5 text-slate-900 shadow-sm backdrop-blur-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300/50 focus:outline-none"
          >
            <option value="pesticides">Pesticides</option>
            <option value="commodities">Commodities</option>
          </select>

          <div class="relative flex-1">
            <input
              v-model.trim="search"
              type="search"
              :placeholder="`Search ${selectedType === 'pesticides' ? 'pesticide' : 'commodity'}...`"
              class="h-12 w-full rounded-full border border-slate-200 bg-white/80 px-5 pl-12 text-slate-900 shadow-sm backdrop-blur-sm transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300/50 focus:outline-none"
            />
            <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2m1.2-4.8a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
        </div>
      </div>

      <!-- Table/Card -->
      <div class="rounded-2xl border border-slate-200/70 bg-white/70 shadow-2xl shadow-slate-200/30 backdrop-blur-xl ring-1 ring-slate-900/5 overflow-x-auto">
        <table class="min-w-full table-auto">
          <thead class="bg-indigo-50 sticky top-0">
            <tr>
              <th class="px-6 py-3 text-left text-indigo-700 font-semibold">ID</th>
              <th class="px-6 py-3 text-left text-indigo-700 font-semibold">Pesticide</th>
              <th class="px-6 py-3 text-left text-indigo-700 font-semibold">Category</th>
              <th class="px-6 py-3 text-left text-indigo-700 font-semibold">Dose</th>
              <th class="px-6 py-3 text-left text-indigo-700 font-semibold">MRL (mg/kg)</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="p in filteredPesticides"
              :key="p.id"
              class="hover:bg-indigo-50 transition-colors duration-200"
            >
              <td class="px-6 py-3 border-b border-gray-200">{{ p.id }}</td>
              <td class="px-6 py-3 border-b border-gray-200 font-medium">{{ p.name }}</td>
              <td class="px-6 py-3 border-b border-gray-200">{{ p.category }}</td>
              <td class="px-6 py-3 border-b border-gray-200">{{ p.dose }}</td>
              <td
                class="px-6 py-3 border-b border-gray-200"
                :class="{'text-red-600 font-bold': p.mrl > 0.05}"
              >
                {{ p.mrl }}
              </td>
            </tr>
          </tbody>
        </table>

        <div v-if="filteredPesticides.length === 0" class="p-4 text-center text-gray-500">
          No pesticides found.
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const selectedType = ref('pesticides')
const search = ref('')

const pesticides = ref([
  { id: 1, name: 'Acibenzolar-s-methyl', category: 'Fungicide', dose: '1.001c', mrl: 0.01 },
  { id: 2, name: 'Afidopyropen', category: 'Insecticide', dose: '5.001c', mrl: 0.05 },
  { id: 3, name: 'Broflanilide', category: 'Insecticide', dose: '2.001b', mrl: 0.02 },
  { id: 4, name: 'Cyazofamid', category: 'Fungicide', dose: '15.001c', mrl: 0.15 },
  { id: 5, name: 'Dimehypo', category: 'Herbicide', dose: '1.002', mrl: 0.01 },
  { id: 6, name: 'Fludioxonil', category: 'Fungicide', dose: '15.001c', mrl: 0.15 },
  { id: 7, name: 'Flutolanil', category: 'Fungicide', dose: '0.071c', mrl: 0.007 },
  { id: 8, name: 'Fluxapyroxad', category: 'Fungicide', dose: '4.001c', mrl: 0.04 },
  { id: 9, name: 'Metaflumizone', category: 'Insecticide', dose: '6.001a', mrl: 0.06 },
  { id: 10, name: 'Oxathiapiprolin', category: 'Fungicide', dose: '1.5c', mrl: 0.015 },
])

const filteredPesticides = computed(() => {
  if (!search.value) return pesticides.value
  return pesticides.value.filter(p =>
    p.name.toLowerCase().includes(search.value.toLowerCase())
  )
})
</script>
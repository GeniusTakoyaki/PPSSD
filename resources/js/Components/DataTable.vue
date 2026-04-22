<template>
  <div class="min-h-screen bg-gradient-to-b from-slate-50 to-slate-100 p-6 lg:p-10">
    <div class="mx-auto max-w-7xl">
      
      <!-- Header: Title left, Controls right -->
      <div class="mb-10 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6">

  

        
        <!-- Title -->
        <div class="flex-1">
          <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ searchCategory }} MRL List</h1>
          <p class="mt-1.5 text-sm text-slate-600">Maximum Residue Limits overview</p>
        </div>

        <div class="flex w-full max-w-2xl items-center gap-3">
          <select
            v-model="searchCategory" @change="updateSearch"
            class="h-12 w-44 rounded-full border border-slate-200 bg-white/80 px-5 text-slate-900 shadow-sm backdrop-blur-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300/50 focus:outline-none"
          >
            <option value="Pesticides">Pesticide</option>
            <option value="Commodities">Commodity</option>
          </select>

          <div class="relative flex-1">
            <input
              v-model="search"
              type="search"
              :placeholder="`Search ${searchCategory === 'pesticides' ? 'pesticide' : 'commodity'}...`"
              class="h-12 w-full rounded-full border border-slate-200 bg-white/80 px-5 pl-12 text-slate-900 shadow-sm backdrop-blur-sm transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300/50 focus:outline-none"
            />
            <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2m1.2-4.8a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
        </div>

        <button
          class="flex items-center justify-center gap-2 h-12 w-24 rounded-full border border-green-700 bg-green-700 px-5 text-white shadow-sm backdrop-blur-sm hover:bg-green-800 focus:ring-2 focus:ring-green-400/50 focus:outline-none"
          @click="goback(searchCategory)"
          >
          <span class="text-xl">‹</span>
          <span class="text-sm font-medium">Back</span>
        </button>
      </div>



      <div class="rounded-2xl border border-slate-200/70 bg-white/70 shadow-2xl overflow-x-auto">
        <table class="min-w-full table-auto">
          <thead class="bg-indigo-50 sticky top-0">
            <tr>
              <th class="px-6 py-3 text-left text-indigo-700 font-semibold">ID</th>
              <th class="px-6 py-3 text-left text-indigo-700 font-semibold">Name</th>
              <th class="px-6 py-3 text-left text-indigo-700 font-semibold">MRL (mg/kg)</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="(p, index) in filteredItems"
              :key="index"
              class="hover:bg-indigo-50 transition-colors duration-200"
            >
              <td class="px-6 py-3 border-b">{{ index + 1 }}</td>
              <td class="px-6 py-3 border-b font-medium">
                {{ category === 'Commodities' ? p.pesticide : p.commodity }}
              </td>
              <td class="px-6 py-3 border-b">{{ p.mrl }}</td>
            </tr>
          </tbody>
        </table>

        <div v-if="filteredItems.length === 0" class="p-4 text-center text-gray-500">
          No results found.
        </div>
</div>

    </div>
  </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import debounce from 'lodash/debounce'

const props = defineProps({
  name: { type: String, default: '' },
  results: { type: Array, default: () => [] },
  category: { type: String, default: '' }
})

const searchCategory = ref(props.category)
const search = ref(props.name)


// Computed: current items to render
const filteredItems = computed(() => {
  return props.results || []
})

console.log(props.name);


function goback(condition){
  search.value = '';
  if (condition == 'Pesticide'){
    router.get(route('pesticides.index'), {
      search: search.value || null,
    }, {
      preserveState: true,   // optional: keeps current component state
    })
  } else {
    router.get(route('commodities.index'), {
      search: search.value || null,

    }, {
      preserveState: true,   // optional: keeps current component state
    })
  }
}




// Watch search inputs and trigger search
watch([search, searchCategory], debounce(([newSearch, newCategory]) => {
  if (newSearch && newCategory) {
    router.get('/search', { 
      category: newCategory, 
      search: newSearch
    }, {
      preserveState: true
    })
  }
}, 350))

// ✅ Watch for results changes and log them
watch(
  () => props.results,
  (newResults) => {
    console.log('Updated search results:', newResults)
  }
)
</script>
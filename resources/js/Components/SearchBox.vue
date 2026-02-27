<script setup>
import { ref } from 'vue'


// reactive variables
const searchName = ref('')
const searchCategory = ref('')
const searchType = ref('') // make sure template uses this exact name

// handle search
const handleSearch = () => {
  router.push({
    path: '/search',
    query: {
      name: searchName.value,
      category: searchCategory.value,
      type: searchType.value
    }
  })
}
</script>

<template>
  <section class="min-h-[80vh] flex items-center justify-center bg-green-800 px-6">
    <div class="w-full max-w-5xl text-center">
      
      <h1 class="text-4xl font-bold text-white mb-4">
        PPSSD Database Search
      </h1>

      <p class="text-green-100 mb-10">
        Search pesticide data, commodity MRLs, and other food safety information.
      </p>

      <form 
        @submit.prevent="handleSearch"
        class="bg-white rounded-2xl shadow-lg p-4 flex flex-col md:flex-row gap-4"
      >
        <input 
          v-model="searchName"
          type="text" 
          placeholder="Name"
          class="flex-1 px-4 py-3 border border-gray-200 rounded-xl"
        />

        <input 
          v-model="searchCategory"
          type="text" 
          placeholder="Category"
          class="flex-1 px-4 py-3 border border-gray-200 rounded-xl"
        />

        <input 
          v-model="searchType"
          type="text" 
          placeholder="Type"
          class="flex-1 px-4 py-3 border border-gray-200 rounded-xl"
        />

        <button 
          type="submit"
          class="bg-green-700 text-white px-6 py-3 rounded-xl hover:bg-green-900 transition"
        >
          Search
        </button>
      </form>
    </div>
  </section>
</template>
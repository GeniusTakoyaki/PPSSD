<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import fao from "@/assets/fao.png"
import asean from "@/assets/asean-logo.png"
import useCountries from '@/Composables/useCountries'


// reactive variables
const searchName = ref('')
const searchCategory = ref('')

const handleSearch = () => {
  router.get('/search', {
    search: searchName.value,
    category: searchCategory.value
  })
}


const { countries } = useCountries()
const selectedCountry = ref('')
</script>

<template>
  <section class="min-h-[80vh] flex items-center justify-center bg-green-800 px-6">
    <div class="w-full max-w-5xl text-center">
      
     
      <h1 class="text-4xl font-bold text-white mb-4">
        PNS Pesticide MRL Database
      </h1>

      <p class="text-green-100 mb-10">
        Search Maximum Residue Limits of pesticides or commodities.
      </p>

      <form 
        @submit.prevent="handleSearch"
        class="bg-white rounded-2xl shadow-lg p-4 flex flex-col md:flex-row gap-4"
      >

        <!-- <select v-model="selectedCountry" 
        :class="[
            'flex-1 px-4 py-3 border border-gray-200 rounded-xl appearance-none',
            !selectedCountry ? 'text-gray-500' : 'text-black'
          ]" >
          <option hidden class="text-gray-400" disabled value="">Select Country</option>

          <option 
            v-for="country in countries" 
            :key="country.ID" 
            :value="country.ID"
          >
            {{ country.Country }}
          </option>
        </select> -->

        <select 
          required
          v-model="searchCategory"
          :class="[
            'flex-1 px-4 py-3 border border-gray-200 rounded-xl appearance-none',
            !searchCategory ? 'text-gray-500' : 'text-black'
          ]"
        >
          <option disabled hidden value="" class="text-gray-400">Select Category</option>
          <option value="Pesticides">Pesticide</option>
          <option value="Commodities">Commodity</option>
        </select>


        <input 
          v-model="searchName"
          type="text" 
          placeholder="Name"
          required
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




<footer class="min-h-[10vh] flex-shrink-0 bg-green-900 text-green-100 flex items-center">
  <div class="max-w-5xl w-full px-6 flex md:flex-row items-center gap-4 md:gap-0">
   
    <!-- LEFT: Logos -->
    <div class="flex items-center gap-6 flex-1">
      <a href="https://www.fao.org/fao-who-codexalimentarius/codex-texts/dbs/pestres/en/" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 hover:opacity-90 transition">
        <img :src="fao" class="h-8 w-auto" />
        <span class="text-white text-[10px] md:text-sm font-medium">Codex Alimentarius</span>
      </a>
      <a href="https://asean.org/" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 hover:opacity-90 transition">
        <img :src="asean" class="h-8 w-auto" />
        <span class="text-white text-[10px] md:text-sm font-medium">ASEAN Pesticide MRLs</span>
      </a>
    </div>
    
    <!-- RIGHT: BPI Text - forced to rightmost -->
    
  </div>

  <p class="text-right text-xs md:text-sm md:ml-auto whitespace-nowrap p-5">
      Bureau of Plant Industry
  </p>
</footer>


  
</template>
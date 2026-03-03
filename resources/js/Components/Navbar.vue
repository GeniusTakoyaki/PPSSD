<script setup>
import { ref } from 'vue'
import logo from '@/assets/ppssd.png'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()

const showMenu = ref(false)
const showDropdown = ref(false)

const toggleNav = () => (showMenu.value = !showMenu.value)
const toggleDropdown = () => (showDropdown.value = !showDropdown.value)

const closeAll = () => {
  showMenu.value = false
  showDropdown.value = false
}

const notMainPage = true
</script>

<template>
  <div class="bg-green-800">
    <nav class="container px-6 py-8 mx-auto md:flex md:justify-between md:items-center">
      <div class="flex items-center justify-between">
        <Link href="/" class="flex items-center space-x-3 text-xl font-bold text-gray-100 md:text-2xl hover:text-indigo-400">
          <img :src="logo" alt="PPSSD Logo" class="h-8 w-auto" />
          <span>PPSSD</span>
        </Link>
        <div @click="toggleNav" class="flex md:hidden">
          <button type="button" class="text-gray-100 hover:text-gray-400 focus:outline-none focus:text-gray-400">
            <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current">
              <path fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z" />
            </svg>
          </button>
        </div>
      </div>

      <ul :class="showMenu ? 'flex' : 'hidden'" class="flex-col mt-8 space-y-4 md:flex md:space-y-0 md:flex-row md:items-center md:space-x-10 md:mt-0">
        <li>
          <a href="https://ppssd.buplant.da.gov.ph/" class="text-gray-100 hover:text-indigo-400">Home</a>
        </li>
        <li v-if="page.url !== '/'">
          <Link href="/" class="text-gray-100 hover:text-indigo-400">Search</Link>
        </li>
        <li class="relative">
          <button @click="toggleDropdown" class="text-gray-100 hover:text-indigo-400 focus:outline-none">List</button>
          <ul v-if="showDropdown" class="absolute left-0 mt-2 w-48 bg-green-900 rounded-md shadow-lg z-50">
            <li><Link href="/pesticides" class="block px-4 py-2 text-gray-100 hover:bg-green-700" @click="closeAll">Pesticides</Link></li>
            <li><Link href="/commodities" class="block px-4 py-2 text-gray-100 hover:bg-green-700" @click="closeAll">Commodities</Link></li>
          </ul>
        </li>
        <li>
          <Link
            v-if="!page.props.auth.user"
            :href="route('login')"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
          >
            Login
          </Link>
        </li>
      </ul>
    </nav>
  </div>
</template>
<template>
    <div class="bg-green-800">
        <nav class="container px-6 py-8 mx-auto md:flex md:justify-between md:items-center">
            <div class="flex items-center justify-between">
                <router-link 
                    to="/" 
                    class="flex items-center space-x-3 text-xl font-bold text-gray-100 md:text-2xl hover:text-indigo-400"
                    >
                    <img 
                        :src="logo" 
                        alt="PPSSD Logo"
                        class="h-8 w-auto"
                    />
                    <span>PPSSD</span>
                    </router-link>
                <!-- Mobile menu button -->
                <div @click="toggleNav" class="flex md:hidden">
                    <button type="button"
                        class="text-gray-100 hover:text-gray-400 focus:outline-none focus:text-gray-400">
                        <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current">
                            <path fill-rule="evenodd"
                                d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
            <ul :class="showMenu ? 'flex' : 'hidden'"
                class="flex-col mt-8 space-y-4 md:flex md:space-y-0 md:flex-row md:items-center md:space-x-10 md:mt-0">
                <li>
                    <a href="https://ppssd.buplant.da.gov.ph/" class="text-gray-100 hover:text-indigo-400">
                        Home
                    </a>
                    </li>
                <li>
                    <RouterLink 
                        to="/" 
                        class="text-gray-100 hover:text-indigo-400"
                    >
                        Search
                    </RouterLink>
                </li>
                
                <li class="relative">
                    <button
                        @click="toggleDropdown"
                        class="text-gray-100 hover:text-indigo-400 focus:outline-none"
                    >
                        List
                    </button>

                    <!-- Dropdown -->
                    <ul
                        v-if="showDropdown"
                        class="absolute left-0 mt-2 w-48 bg-green-900 rounded-md shadow-lg z-50"
                    >
                        <li>
                            <router-link
                                to="/pesticides"
                                class="block px-4 py-2 text-gray-100 hover:bg-green-700"
                                @click="closeAll"
                            >
                                Pesticides
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                to="/commodities"
                                class="block px-4 py-2 text-gray-100 hover:bg-green-700"
                                @click="closeAll"
                            >
                                Commodities
                            </router-link>
                        </li>
                    </ul>
                </li>

            
                <li class="text-gray-100 hover:text-indigo-400">Login</li>
            </ul>
        </nav>
    </div>
</template>
<script>
import { ref } from "vue";
import logo from '@/assets/ppssd.png'
export default {
    setup() {
        let showMenu = ref(false);
        const toggleNav = () => (showMenu.value = !showMenu.value);


        const showDropdown = ref(false);


        const toggleDropdown = () => {
            showDropdown.value = !showDropdown.value;
        };

        const closeAll = () => {
            showMenu.value = false;
            showDropdown.value = false;
        };

        return { 
            showMenu, 
            toggleNav, 
            showDropdown, 
            toggleDropdown, 
            closeAll,
            logo 
        };
    },

};
</script>
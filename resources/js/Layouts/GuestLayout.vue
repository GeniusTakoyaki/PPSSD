<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="flex min-h-screen flex-col items-center bg-green-700 pt-6 sm:justify-center sm:pt-0">
    
    <!-- Logo container with gray background -->
    <div class="w-full sm:max-w-md bg-gray-200 flex justify-center p-4 rounded-t-lg shadow">
      <Link href="/">
        <ApplicationLogo class="h-64 w-64 fill-current text-gray-500 border-none outline-none" />
      </Link>
    </div>

    <!-- Login form card -->
    <div class="w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-b-lg">
      <slot />
    </div>

  </div>
</template>
<template>
  <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    
    <!-- 🔹 Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-5 border-b">
      <div>
        <h2 class="text-lg font-semibold text-gray-800">Commodity Records</h2>
        <p class="text-sm text-gray-500">Manage commodity list</p>
      </div>

      <div class="flex gap-2 items-center">
        <!-- Search -->
        <div class="relative">
          <input
            v-model="search"
            type="text"
            placeholder="Search commodity..."
            class="pl-9 pr-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-green-600"
          />
          <span class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
        </div>

        <!-- Add Button -->
        <button @click="emit('open-form', { type: 'commodities' })" class="bg-green-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-800">
          + Add Commodity
        </button>
      </div>
    </div>

    <!-- 🔹 Table -->
    <table class="w-full text-sm">
      <thead class="bg-gray-50 text-gray-600">
        <tr>
          <th class="text-left px-6 py-3">Commodity</th>
          <th class="text-right px-6 py-3">Actions</th>
        </tr>
      </thead>

      <tbody>
        <tr
          v-for="item in commodities"
          :key="item['Commodity ID']"
          class="border-t hover:bg-gray-50"
          @click="handleClick(item)"
        >
          <td class="px-6 py-3 font-medium text-gray-800">
            {{ item.name }}
          </td>

          <td class="px-6 py-3 text-right space-x-2">
            <button class="text-blue-600 hover:underline"
              @click.stop="deleteItem(item)">Edit</button>
            <button class="text-red-500 hover:underline"
              @click.stop="deleteItem(item)">Delete</button>
          </td>
        </tr>

        <!-- Empty state -->
        <tr v-if="commodities.length === 0">
          <td colspan="3" class="text-center py-6 text-gray-400">
            📦 No commodities found
          </td>
        </tr>
      </tbody>
    </table>

  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    commodities: {
        type: Array,
        default: () => []
    },
    filters: {
        type: Object,
        default: () => ({})
    }
})

const search = ref(props.filters?.search || '')
console.log(props['commodities']);

watch([search], () => {
  router.get(
    route('dashboard'),
    {
      search: search.value || null,
    },
    { preserveState: true, replace: true }
  )
}, { debounce: 300 })


const emit = defineEmits(['open-form', 'openPanel'])

const handleClick = (item) => {
  console.log(item);
  emit('openPanel', { type: 'commodity', id: item['Commodity ID'] })
}
</script>
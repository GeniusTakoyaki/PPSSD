<template>
  <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    
    <!-- 🔹 Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-5 border-b bg-gradient-to-r from-green-700 to-green-400">
      <div>
        <h2 class="text-lg font-semibold text-white">Pesticide Records</h2>
        <p class="text-sm text-gray-100">Manage pesticide list</p>
      </div>

      <div class="flex gap-2 items-center">

        <!-- Add Button -->
        <button @click="emit('open-form', { type: 'pesticides' })" class="bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-emerald-800">
          + Add Pesticide
        </button>

                <!-- Search -->
        <div class="relative">
          <input
            v-model="search"
            type="text"
            placeholder="Search pesticide..."
            class="pl-9 pr-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-600"
          />
          <span class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
        </div>

      </div>
    </div>

    <!-- 🔹 Table -->
    <table class="w-full text-sm">
      <thead class="bg-gradient-to-r from-amber-700 to-amber-400">
        <tr>
          <th class="text-left px-6 py-3 text-white">Pesticide</th>
          <th class="text-right px-6 py-3">Actions</th>
        </tr>
      </thead>

      <tbody>
        <tr
          v-for="item in pesticides"
          :key="item['Pesticide ID']"
          class="border-t hover:bg-green-100"
          @click="handleClick(item)"
        >

          <td class="px-6 py-3 font-medium text-gray-800">
            {{ item.name }}
          </td>

          <td class="px-6 py-3 text-right space-x-2">
            <!-- <button class="text-blue-600 hover:underline"
              @click.stop="deleteItem(item)">Edit</button> -->
            <button class="text-red-500 hover:underline"
              @click.stop="deletePesticide(item['Pesticide ID'])">Delete</button>
          </td>
        </tr>

        <!-- Empty state -->
        <tr v-if="pesticides.length === 0">
          <td colspan="3" class="text-center py-6 text-gray-400">
            📦 No pesticides found
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
    pesticides: {
        type: Array,
        default: () => []
    },
    filters: {
        type: Object,
        default: () => ({})
    }
})

const search = ref(props.filters?.search || '')


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
  emit('openPanel', { type: 'pesticide', id: item['Pesticide ID'] })
}

const deletePesticide = (id) => {
    if (!confirm('Are you sure you want to delete this pesticide?')) return

    router.delete(route('pesticides.destroy', { id: id }), {
        preserveScroll: true,
    })
}
</script>
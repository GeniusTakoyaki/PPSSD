<template>
  <div class="space-y-8">
    <div v-for="(items, letter) in grouped" :key="letter" class="space-y-4">
      <!-- Letter Header -->
      <div class="flex items-center mt-2">
        <div
          class="w-12 flex items-center justify-center p-2 rounded-xl bg-green-800 text-white font-bold text-xl shadow"
        >
          {{ letter }}
        </div>
        <div class="h-px flex-1 bg-gray-200"></div>
      </div>

      <!-- Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        <div
          v-for="item in items"
          :key="item[idField]"
          @click="handleSearch(item)"
          class="group p-5 rounded-2xl border border-gray-100 bg-white shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 cursor-pointer"
        >
          <div class="flex items-center justify-between">
            <h3
              class="font-semibold text-lg text-green-900 group-hover:text-green-700 transition"
            >
              {{ item.name }}
            </h3>
            <span
              class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700"
            >
              {{ item.name?.charAt(0)?.toUpperCase() || '' }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- No Data -->
    <div v-if="props.items.length === 0" class="text-center py-16">
      <div class="text-5xl mb-4">📦</div>
      <h3 class="text-xl font-semibold text-gray-700">No data found</h3>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  items: {
    type: Array,
    default: () => []
  },
  field: {
    type: String,
    required: true
  },
  idField: {
    type: String,
    default: 'id' // default primary key if your data uses 'id'
  }
})


const basis = 'name';


const handleSearch = (item) => {
  router.get('/search', {
    search: item[basis],
    category: props.field,
    type: "test"
  })

}

const grouped = computed(() => {
  const groups = {}
  props.items.forEach(item => {
    const value = item?.[basis]
    if (!value) return
    const letter = value.charAt(0).toUpperCase()
    if (!groups[letter]) groups[letter] = []
    groups[letter].push(item)
  })

  // Sort each group alphabetically
  Object.keys(groups).forEach(k => {
    groups[k].sort((a, b) => a[basis].localeCompare(b[basis]))
  })

 

  return groups
})
</script>
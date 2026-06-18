<template>
  <div class="space-y-3">

    <!-- Header -->
    <div class="flex justify-between items-center">
      <h2 class="text-lg font-semibold">
        {{ title }}
      </h2>

      <button
        @click="saveAll"
        :disabled="dirty.size === 0"
        class="text-xs px-4 py-1.5 rounded text-white bg-green-600
               disabled:opacity-40 disabled:cursor-not-allowed"
      >
        Save Changes
        <span
          v-if="dirty.size > 0"
          class="ml-1 bg-white text-green-700 rounded-full px-1.5 font-bold"
        >
          {{ dirty.size }}
        </span>
      </button>
    </div>

    <!-- Table -->
    <div class="overflow-y-auto max-h-[70vh]">
      <table class="w-full text-sm">

        <thead class="sticky top-0 bg-white border-b">
          <tr class="text-left text-gray-600">
            <th class="py-2">{{ label }}</th>
            <th class="py-2 w-28">MRL</th>
            <th class="py-2 w-8"></th>
          </tr>
        </thead>

        <tbody>
          <tr v-if="!items?.length">
            <td colspan="3" class="py-6 text-center text-gray-400">
              No items found
            </td>
          </tr>

          <tr
            v-for="item in items"
            :key="item.id"
            class="border-b hover:bg-green-100 transition-colors"
            :class="dirty.has(item.id) ? 'bg-amber-50 hover:bg-amber-100' : ''"
          >
            <!-- Name -->
            <td class="py-2 pr-2 font-medium">
              {{ item.name }}
            </td>

            <!-- MRL input -->
            <td class="py-2">
              <input
                v-model="item.mrl_value"
                type="number"
                step="0.01"
                min="0"
                class="w-full border rounded px-2 py-1"
                :class="dirty.has(item.id) ? 'border-amber-400' : ''"
                placeholder="—"
                @input="markDirty(item)"
                @wheel.prevent="$event.target.blur()"
              />
            </td>

            <!-- Dirty indicator -->
            <td class="py-2 text-center">
              <span
                v-if="dirty.has(item.id)"
                title="Unsaved changes"
                class="text-amber-500 text-xs"
              >
                ●
              </span>
            </td>
          </tr>
        </tbody>

      </table>
    </div>

  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  items: Array,
  mode: String,
  title: {
    type: String,
    default: 'MRL Table'
  },
  label: {
    type: String,
    default: 'Name'
  }
})

const emit = defineEmits(['saveAll'])

const dirty = ref(new Set())
const originalValues = new Map()

// capture original values once items load
watch(() => props.items, (items) => {
  items?.forEach(item => {
    if (!originalValues.has(item.id)) {
      originalValues.set(item.id, item.mrl_value ?? null)
    }
  })
}, { immediate: true })

const markDirty = (item) => {
  const original = originalValues.get(item.id)
  const current = item.mrl_value === '' ? null : item.mrl_value

  if (current == original) {
    dirty.value.delete(item.id)
  } else {
    dirty.value.add(item.id)
  }
  dirty.value = new Set(dirty.value) // trigger reactivity
}

const saveAll = () => {
  const dirtyItems = props.items.filter(i => dirty.value.has(i.id))

  if (!dirtyItems.length) return

  emit('saveAll', dirtyItems.map(item => ({
    id: item.id,
    mrl_id: item.mrl_id,
    value: item.mrl_value === '' ? null : item.mrl_value  // ← converts empty string to null
  })))

  dirty.value = new Set()
}
</script>
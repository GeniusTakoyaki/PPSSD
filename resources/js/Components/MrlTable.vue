<template>
  <div class="space-y-3">

    <!-- Header -->
    <div class="flex justify-between items-center">
      <h2 class="text-lg font-semibold">
        {{ title }}
      </h2>
    </div>

    <!-- Table -->
    <div class="overflow-y-auto max-h-[70vh]">
      <table class="w-full text-sm">

        <thead class="sticky top-0 bg-white border-b">
          <tr class="text-left text-gray-600">
            <th class="py-2">
              {{ label }}
            </th>
            <th class="py-2 w-28">MRL</th>
            <th class="py-2 w-24 text-right">Action</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="item in items"
            :key="item.id"
            class="border-b"
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
                class="w-full border rounded px-2 py-1"
                placeholder="—"
              />
            </td>

            <!-- Action -->
            <td class="py-2 text-right">
              <button
                @click="save(item)"
                class="text-white px-3 py-1 rounded text-xs"
                :class="item.mrl_id ? 'bg-blue-600' : 'bg-green-600'"
              >
                {{ item.mrl_id ? 'Update' : 'Add' }}
              </button>
            </td>
          </tr>
        </tbody>

      </table>
    </div>

  </div>
</template>

<script setup>
const props = defineProps({
  items: Array,

  // "commodity" or "pesticide"
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

const emit = defineEmits(['save'])

const save = (item) => {
  emit('save', {
    id: item.id,
    mrl_id: item.mrl_id,
    value: item.mrl_value
  })
}
</script>
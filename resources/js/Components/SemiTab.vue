<template>
  <div class="border-b border-gray-200">
    <nav class="flex gap-2 mt-1 mx-4">
      <button
        v-for="tab in tabs"
        :key="tab.value"
        @click="selectTab(tab.value)"
        class="relative px-4 py-2 text-sm font-medium rounded-t-lg transition"
        :class="active === tab.value
          ? 'text-green-700 bg-white border border-b-0 border-gray-200'
          : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100'"
      >
        <!-- Label -->
        {{ tab.label }}

        <!-- Active underline -->
        <span
          v-if="active === tab.value"
          class="absolute left-0 bottom-0 w-full h-[2px] bg-green-700"
        ></span>
      </button>
    </nav>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  tabs: {
    type: Array,
    required: true
    [{ label: 'Commodities', value: 'commodities' }]
  },
  modelValue: {
    type: String,
    required: true
  }
})

const emit = defineEmits(['update:modelValue'])

const active = computed(() => props.modelValue)

function selectTab(value) {
  emit('update:modelValue', value)
}
</script>
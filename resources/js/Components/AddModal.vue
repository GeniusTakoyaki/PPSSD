<script setup>
defineProps({
  show: Boolean,
})

const emit = defineEmits(['close'])
</script>

<template>
  <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center">
    <!-- backdrop -->
    <div
      class="absolute inset-0 bg-black/50"
      @click="emit('close')"
    ></div>

    <!-- modal box -->
    <div class="relative bg-white p-6 rounded-lg shadow-lg w-96 z-10">
      <slot />
    </div>
  </div>
</template>
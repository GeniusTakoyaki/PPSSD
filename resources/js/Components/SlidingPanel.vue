<template>
  <!-- Backdrop -->
  <div
    v-if="show"
    class="fixed inset-0 bg-black/30 z-40"
    @click="close"
  />

  <!-- Panel -->
  <transition name="slide-up">
    <div
      v-if="show"
      class="fixed left-0 right-0 bottom-0 bg-white rounded-t-2xl shadow-xl z-50 overflow-hidden flex flex-col"
      :style="{ height: height }"
    >
      <!-- Drag handle -->
      <div class="w-12 h-1.5 bg-gray-300 rounded-full mx-auto my-3"></div>

      <!-- Content -->
      <div class="flex-1 overflow-y-auto p-4">
        <slot />
      </div>
    </div>
  </transition>
</template>

<script setup>
import { watch, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
  show: Boolean,
  height: {
    type: String,
    default: '85vh'
  }
})

const emit = defineEmits(['close'])

const close = () => emit('close')

// lock body scroll
watch(
  () => props.show,
  (val) => {
    document.body.style.overflow = val ? 'hidden' : ''
  }
)

// ESC close
const handleEsc = (e) => {
  if (e.key === 'Escape') close()
}

onMounted(() => window.addEventListener('keydown', handleEsc))
onBeforeUnmount(() => window.removeEventListener('keydown', handleEsc))
</script>

<style scoped>
.slide-up-enter-active,
.slide-up-leave-active {
  transition: transform 0.3s ease;
}

.slide-up-enter-from,
.slide-up-leave-to {
  transform: translateY(100%);
}

.slide-up-enter-to,
.slide-up-leave-from {
  transform: translateY(0);
}
</style>
<template>
  
  <div class="space-y-8">
    <!-- Header + Search -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
      <div>
        <p class="text-gray-500 text-sm">
          Browse items alphabetically
        </p>
      </div>

      <!-- Search -->
        <div class="relative md:w-80">
        <input
            v-model="search"
            type="text"
            placeholder="Search..."
            class="w-full px-4 py-2 pl-10 rounded-xl border border-gray-200 
                shadow-sm focus:ring-2 focus:ring-green-600 focus:outline-none"
        />
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
        </div>
    </div>

    <!-- Sticky Alphabet Filter -->
    <div class="sticky top-0 z-10 bg-white/80 backdrop-blur 
                border border-gray-100 rounded-2xl shadow-sm p-2">
      <div class="flex flex-wrap gap-2 justify-center p-1">
        <button
          @click="activeLetter = 'ALL'"
          class="px-4 py-1.5 rounded-full text-sm font-medium transition"
          :class="activeLetter === 'ALL'
            ? 'bg-green-800 text-white shadow'
            : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
        >
          All
        </button>

        <button
          v-for="letter in alphabet"
          :key="letter"
          @click="activeLetter = letter"
          class="px-3 py-1.5 rounded-full text-sm font-semibold transition"
          :class="activeLetter === letter
            ? 'bg-green-700 text-white shadow-md scale-105'
            : 'bg-green-50 text-green-800 hover:bg-green-100'"
        >
          {{ letter }}
        </button>
      </div>
    </div>

    <!-- Grouped Sections -->
    <div
      v-for="(items, letter) in filteredGrouped"
      :key="letter"
      class="space-y-4"
    >
      <!-- Letter Header -->
      <div class="flex items-center mt-2">
        <div class="w-12 flex items-center justify-center p-2
                    rounded-xl bg-green-800 text-white font-bold text-xl shadow">
          {{ letter }}
        </div>
        <div class="h-px flex-1 bg-gray-200"></div>
      </div>

      <!-- Cards Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        <div
          v-for="item in items"
          :key="item.id"
          @click="$emit('select', item)"
          class="group p-5 rounded-2xl border border-gray-100 
                 bg-white shadow-sm hover:shadow-xl 
                 hover:-translate-y-1 transition-all duration-200 
                 cursor-pointer"
        >
          <div class="flex items-center justify-between">
            <h3 class="font-semibold text-lg text-green-900 
                       group-hover:text-green-700 transition">
              {{ item.name }}
            </h3>

            <span class="text-xs px-2 py-1 rounded-full 
                         bg-green-100 text-green-700">
              {{ item.name.charAt(0).toUpperCase() }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div
      v-if="Object.keys(filteredGrouped).length === 0"
      class="text-center py-16"
    >
      <div class="text-5xl mb-4">📦</div>
      <h3 class="text-xl font-semibold text-gray-700">
        No data found
      </h3>
      <p class="text-gray-500 text-sm mt-1">
        Try adjusting your search or letter filter.
      </p>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";

const props = defineProps({
  items: {
    type: Array,
    required: true
  }
});

const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");
const activeLetter = ref("ALL");
const search = ref("");

// Filter by search first
const filteredItems = computed(() => {
  if (!search.value) return props.items;

  return props.items.filter((item) =>
    item.name.toLowerCase().includes(search.value.toLowerCase())
  );
});

// Group items by first letter
const grouped = computed(() => {
  const groups = {};

  filteredItems.value.forEach((item) => {
    if (!item.name) return;

    const letter = item.name.charAt(0).toUpperCase();

    if (!groups[letter]) {
      groups[letter] = [];
    }

    groups[letter].push(item);
  });

  Object.keys(groups).forEach((letter) => {
    groups[letter].sort((a, b) => a.name.localeCompare(b.name));
  });

  return groups;
});

// Apply alphabet filter
const filteredGrouped = computed(() => {
  if (activeLetter.value === "ALL") return grouped.value;

  return grouped.value[activeLetter.value]
    ? { [activeLetter.value]: grouped.value[activeLetter.value] }
    : {};
});
</script>
<template>
  <Navbar></Navbar>
  <div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-green-800 mb-6">
      Commodities
    </h1>

    <AZList :items="commodities" @select="goToDetail" />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import AZList from "@/Components/AZList.vue";
import Navbar from '@/Components/Navbar.vue'

const commodities = ref([]);

const goToDetail = (item) => {
  console.log("Selected commodity:", item);
  // later: router.push(`/commodities/${item.id}`)
};

onMounted(() => {
  // Dummy (DB-ready)
  commodities.value = [
    { id: 1, name: "Apple" },
    { id: 2, name: "Banana" },
    { id: 3, name: "Rice" },
    { id: 4, name: "Corn" }
  ];
});
</script>
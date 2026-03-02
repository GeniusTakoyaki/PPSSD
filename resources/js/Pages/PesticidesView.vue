<template>
  <Navbar></Navbar>
  <div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-green-800 mb-6">
      Pesticides
    </h1>

    <AZList :items="pesticides" @select="goToDetail" />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import AZList from "@/Components/AZList.vue";
import Navbar from '../Components/Navbar.vue'

const pesticides = ref([]);

const goToDetail = (item) => {
  console.log("Selected pesticide:", item);
};

onMounted(() => {
  pesticides.value = [
    { id: 1, name: "Abamectin" },
    { id: 2, name: "Carbaryl" },
    { id: 3, name: "Glyphosate" }
  ];
});
</script>
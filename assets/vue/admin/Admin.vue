<template>
    <Header :currentRoute="'/admin'" />
    <AnimalListAdmin />


</template>


<script setup>
import Header from "../Header.vue";
import AnimalListAdmin from "./AnimalListAdmin.vue";
</script>
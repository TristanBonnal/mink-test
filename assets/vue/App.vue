<template>
    <Header :currentRoute="'/'" />
    <AnimalList />
</template>


<script setup>
    import Header from "./Header.vue";
    import AnimalList from "./AnimalList.vue";
</script>

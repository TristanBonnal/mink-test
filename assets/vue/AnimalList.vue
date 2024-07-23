<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Liste des animaux</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <AnimalTableHead />
                <tbody>
                    <AnimalRow v-for="animal in animals" :key="animal['@id']" :animal="animal" />
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';

import AnimalTableHead from './AnimalTableHead.vue';
import AnimalRow from './AnimalRow.vue';

const animals = ref([]);

const fetchAnimals = async () => {
    try {
        const response = await axios.get('/api/animals');
        animals.value = response.data['hydra:member'];
    } catch (error) {
        console.error('Failed to fetch animals:', error);
    }
};

onMounted(fetchAnimals);
</script>

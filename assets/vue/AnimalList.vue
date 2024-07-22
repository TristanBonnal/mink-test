<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Liste des animaux</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Nom</th>
                    <th class="px-4 py-2 border-b">Age</th>
                    <th class="px-4 py-2 border-b">Description</th>
                    <th class="px-4 py-2 border-b">Prix</th>
                    <th class="px-4 py-2 border-b">Photo</th>
                    <th class="px-4 py-2 border-b">Type</th>
                    <th class="px-4 py-2 border-b">Race</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="animal in animals" :key="animal['@id']" class="hover:bg-gray-100">
                    <td class="px-4 py-2 border-b">{{ animal.name }}</td>
                    <td class="px-4 py-2 border-b">{{ animal.age }}</td>
                    <td class="px-4 py-2 border-b">{{ animal.description }}</td>
                    <td class="px-4 py-2 border-b">{{ animal.price }} €</td>
                    <td class="px-4 py-2 border-b">
                        <img :src="'img/' + animal.picture[0].url" :alt="animal.name" class="h-16 w-16 object-cover">
                    </td>
                    <td class="px-4 py-2 border-b">{{ animal.type.name }}</td>
                    <td class="px-4 py-2 border-b">{{ animal.breed.name }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>


<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";

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
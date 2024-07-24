<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Administration des animaux</h1>
        <button @click="openModal(null)" class="mb-4 px-4 py-2 bg-blue-500 text-white rounded">Ajouter un animal</button>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <AnimalTableHead />
                <tbody>
                <AdminAnimalRow
                    v-for="animal in animals"
                    :key="animal['@id']"
                    :animal="animal"
                    @edit="openModal(animal)"
                    @delete="handleDelete"
                />
                </tbody>
            </table>
        </div>
        <AnimalModal v-if="showModal" :animal="selectedAnimal" :types="types" :breeds="breeds" @close="closeModal" @save="saveAnimal" />
    </div>
</template>

<script setup>
import {onMounted, ref} from 'vue';
import axios from 'axios';

import AnimalTableHead from '../AnimalTableHead.vue';
import AdminAnimalRow from './AnimalRowAdmin.vue';
import AnimalModal from './AnimalModal.vue';

const animals = ref([]);
const showModal = ref(false);
const selectedAnimal = ref(null);
const types = ref([]);
const breeds = ref([]);

const fetchAnimals = async () => {
    try {
        const response = await axios.get('/api/animals');
        animals.value = response.data['hydra:member'];
    } catch (error) {
        console.error('Failed to fetch animals:', error);
    }
};

const fetchTypesAndBreeds = async () => {
    try {
        const [typesResponse, breedsResponse] = await Promise.all([
            axios.get('/api/types'),
            axios.get('/api/breeds')
        ]);
        types.value = typesResponse.data['hydra:member'];
        breeds.value = breedsResponse.data['hydra:member'];
    } catch (error) {
        console.error('Failed to fetch types and breeds:', error);
    }
};

const openModal = (animal) => {
    selectedAnimal.value = animal ? {...animal} : null; // Copier l'objet animal pour éviter les mutations
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedAnimal.value = null;
};

const saveAnimal = async (animalData) => {
    try {
        if (selectedAnimal.value) {
            await axios.put(`/api/animals/${selectedAnimal.value.id}`, animalData); // Assurez-vous que selectedAnimal a un ID
        } else {
            await axios.post('/api/animals', animalData);
        }
        closeModal();
        fetchAnimals();
    } catch (error) {
        console.error('Failed to save animal:', error);
    }
};

const handleDelete = async (animal) => {
    try {
        await axios.delete(animal['@id']);
        animals.value = animals.value.filter(a => a['@id'] !== animal['@id']);
        console.log('Animal deleted:', animal);
    } catch (error) {
        console.error('Failed to delete animal:', error);
    }
};

onMounted(async () => {
    await fetchAnimals();
    await fetchTypesAndBreeds();
});
</script>

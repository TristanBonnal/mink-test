<template>
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl mb-4">{{ animal ? 'Modifier Animal' : 'Ajouter Animal' }}</h2>
            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <label class="block text-gray-700">Nom</label>
                    <input v-model="formData.name" type="text" class="w-full px-3 py-2 border rounded" :class="{'border-red-500': errors.name}" />
                    <span v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</span>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Age</label>
                    <input v-model="formData.age" type="number" class="w-full px-3 py-2 border rounded" :class="{'border-red-500': errors.age}" />
                    <span v-if="errors.age" class="text-red-500 text-sm">{{ errors.age }}</span>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Description</label>
                    <textarea v-model="formData.description" class="w-full px-3 py-2 border rounded" :class="{'border-red-500': errors.description}"></textarea>
                    <span v-if="errors.description" class="text-red-500 text-sm">{{ errors.description }}</span>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Prix</label>
                    <input v-model="formData.price" type="number" step="0.01" class="w-full px-3 py-2 border rounded" :class="{'border-red-500': errors.price}" />
                    <span v-if="errors.price" class="text-red-500 text-sm">{{ errors.price }}</span>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Status</label>
                    <div class="flex items-center">
                        <label class="mr-2">
                            <input type="radio" v-model="formData.status" :value="false" class="form-radio">
                            Vendu
                        </label>
                        <label>
                            <input type="radio" v-model="formData.status" :value="true" class="form-radio">
                            À vendre
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Type</label>
                    <select v-model="formData.type" class="w-full px-3 py-2 border rounded" :class="{'border-red-500': errors.type}">
                        <option v-for="type in types" :key="type['@id']" :value="type['@id']">{{ type.name }}</option>
                    </select>
                    <span v-if="errors.type" class="text-red-500 text-sm">{{ errors.type }}</span>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Race</label>
                    <select v-model="formData.breed" class="w-full px-3 py-2 border rounded" :class="{'border-red-500': errors.breed}">
                        <option v-for="breed in breeds" :key="breed['@id']" :value="breed['@id']">{{ breed.name }}</option>
                    </select>
                    <span v-if="errors.breed" class="text-red-500 text-sm">{{ errors.breed }}</span>
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="$emit('close')" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive, watch } from 'vue';

const props = defineProps({
    animal: Object,
    types: Array,
    breeds: Array
});

const emits = defineEmits(['close', 'save']);

const formData = reactive({
    id: null,
    name: '',
    age: '',
    description: '',
    price: '',
    status: true,
    type: '',
    breed: ''
});

const errors = reactive({});

watch(props.animal, (newVal) => {
    if (newVal) {
        formData.id = newVal.id;
        formData.name = newVal.name;
        formData.age = newVal.age;
        formData.description = newVal.description;
        formData.price = newVal.price;
        formData.status = newVal.status;
        formData.type = newVal.type['@id'];
        formData.breed = newVal.breed['@id'];
    } else {
        formData.id = null;
        formData.name = '';
        formData.age = '';
        formData.description = '';
        formData.price = '';
        formData.status = true;
        formData.type = '';
        formData.breed = '';
    }
});

const submitForm = async () => {
    errors.name = !formData.name ? 'Le nom est requis' : '';
    errors.age = !formData.age ? 'L\'âge est requis' : '';
    errors.description = !formData.description ? 'La description est requise' : '';
    errors.price = !formData.price ? 'Le prix est requis' : '';
    errors.type = !formData.type ? 'Le type est requis' : '';
    errors.breed = !formData.breed ? 'La race est requise' : '';

    if (!errors.name && !errors.age && !errors.description && !errors.price && !errors.type && !errors.breed) {
        emits('save', {
            id: formData.id,
            name: formData.name,
            age: formData.age,
            description: formData.description,
            price: formData.price,
            status: formData.status,
            type: formData.type,
            breed: formData.breed
        });
    }
};
</script>

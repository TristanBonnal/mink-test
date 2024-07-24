<template>
    <tr class="hover:bg-gray-100">
        <td class="px-4 py-2 border-b">{{ animal.name }}</td>
        <td class="px-4 py-2 border-b">{{ animal.age }}</td>
        <td class="px-4 py-2 border-b">{{ animal.description }}</td>
        <td class="px-4 py-2 border-b">{{ animal.price }} €</td>
        <td class="px-4 py-2 border-b">
            <img v-if="!!animal.picture[0]" :src="'img/' + animal.picture[0].url" :alt="animal.name" class="h-16 w-16 object-cover">
        </td>
        <td class="px-4 py-2 border-b">{{ animal.type.name }}</td>
        <td class="px-4 py-2 border-b">{{ animal.breed.name }}</td>
        <td class="px-4 py-2 border-b">
            <button @click="editAnimal" class="text-blue-500 hover:underline">Editer</button>
            <button @click="deleteAnimal" class="text-red-500 hover:underline ml-2">Supprimer</button>
        </td>
    </tr>
</template>

<script setup>
const props = defineProps({
    animal: {
        type: Object,
        required: true
    }
});

const emits = defineEmits(['edit', 'delete']);

const editAnimal = () => {
    emits('edit', props.animal);
};

const deleteAnimal = () => {
    emits('delete', props.animal);
};
</script>


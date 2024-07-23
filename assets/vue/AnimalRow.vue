<template>
    <tr class="hover:bg-gray-100">
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
</template>

<script setup>

const props = defineProps({
    animal: {
        type: Object,
        required: true
    }
});
</script>



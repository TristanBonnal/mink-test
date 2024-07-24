<template>
    <transition name="fade">
        <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-gray-800 p-4 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-white">Connexion</h2>
                    <button @click="closeModal" class="text-white hover:text-gray-300">
                        &times;
                    </button>
                </div>
                <div class="p-6">
                    <form @submit.prevent="handleSubmit">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input
                                v-model="email"
                                type="email"
                                required
                                @input="clearEmailError"
                                @invalid="setEmailError"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                            <p v-if="emailError" class="text-red-600 text-sm mt-1">{{ emailError }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input
                                v-model="password"
                                type="password"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                        </div>
                        <div v-if="loginError" class="mb-4 text-red-600 text-sm">
                            {{ loginError }}
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Connexion</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </transition>
</template>

<script setup>
import {ref} from 'vue'
import axios from 'axios'
import Cookies from 'js-cookie'

const props = defineProps({
    isOpen: Boolean
})

const emit = defineEmits(['close', 'login-success'])

const email = ref('')
const password = ref('')
const loginError = ref('')
const emailError = ref('')

const closeModal = () => {
    emit('close')
}

const handleSubmit = async () => {
    loginError.value = ''

    try {
        const response = await axios.post('/api/login_check', {
            username: email.value,
            password: password.value
        })

        const token = response.data.token

        // Stocker le token JWT
        Cookies.set('BEARER', token, { secure: true, sameSite: 'Strict',  })

        // Configurer axios pour utiliser le token dans les futures requêtes
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

        emit('login-success')

        closeModal()
    } catch (error) {
        loginError.value = 'Email ou mot de passe incorrect.' 
        console.error('Failed to login:', error)
    }
}

const clearEmailError = () => {
    emailError.value = ''
}

const setEmailError = (event) => {
    event.preventDefault()
    emailError.value = 'Entrez une adresse email valide.'
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>

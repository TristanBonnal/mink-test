<template>
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <DisclosureButton class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="absolute -inset-0.5" />
                        <span class="sr-only">Open main menu</span>
                        <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                        <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center font-bold text-xl text-green-500">
                        MinkFarm
                    </div>
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
                        </div>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:block">
                    <button v-if="!isConnected" @click="openLoginModal" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Connexion</button>
                    <button v-else @click="logoutHandle" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Déconnexion</button>
                </div>
            </div>
        </div>

        <DisclosurePanel class="sm:hidden">
            <div class="space-y-1 px-2 pb-3 pt-2">
                <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
                <DisclosureButton @click="openLoginModal" class="block text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-base font-medium">Login</DisclosureButton>
            </div>
        </DisclosurePanel>

        <LoginModal :isOpen="isLoginModalOpen" @close="closeLoginModal" @login-success="checkAuthStatus"/>
    </Disclosure>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'
import { ref, onMounted } from 'vue'
import Cookies from 'js-cookie'
import LoginModal from './LoginModal.vue'

const props = defineProps({
    currentRoute: String,
})

const navigation = [
    { name: 'Accueil', href: '/', current: false },
    { name: 'Admin', href: '/admin', current: false },
]

const isLoginModalOpen = ref(false)
const isConnected = ref(false)

const openLoginModal = () => {
    isLoginModalOpen.value = true
}

const closeLoginModal = () => {
    isLoginModalOpen.value = false
}

const logoutHandle = () => {
    Cookies.remove('BEARER')
    isConnected.value = false
}

const checkAuthStatus = () => {
    isConnected.value = !!Cookies.get('BEARER');
};

navigation.forEach(item => {
    item.current = item.href === props.currentRoute
})

onMounted(() => {
    checkAuthStatus();
});
</script>

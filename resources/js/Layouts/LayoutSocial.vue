<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, reactive, onMounted, onUnmounted  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'

import SideBar from '@/Components/Social/SideBar.vue'
import NavBar from '@/Components/Social/NavBar.vue'

import FlashMessages from '@/Components/FlashMessages.vue'
import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'

const props = defineProps({

});

const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()


</script>

<template>
  <div class="bg-white dark:bg-slate-700 relative">

    <!-- Sidebar -->
    <SideBar />

    <!-- Navbar -->
    <NavBar />

    <slot />
  </div>
</template>

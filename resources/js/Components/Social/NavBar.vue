<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, reactive, onMounted, onUnmounted  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'

import FlashMessages from '@/Components/FlashMessages.vue'
import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'

const props = defineProps({

});

const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const collapse_nav_padding = ref(window.scrollY >= 10 ? true : false);

onMounted(() => window.addEventListener('scroll', update))
onUnmounted(() => window.removeEventListener('scroll', update))

const update = (event) => {
  collapse_nav_padding.value = window.scrollY >= 10 ? true : false;
}

</script>

<template>
  <div class="w-full inline-block relative">

    <div @click="mainStore.toggleSidebar" class="transition-all ease-linear duration-500 fixed top-0 bottom-0 h-screen w-screen z-20" :class="mainStore.sidebar_open ? 'bg-black opacity-50': 'hidden'"></div>

    <div class="md:w-1/12 lg:w-3/12 w-0 inline-block">

    </div>

    <div class="md:w-11/12 lg:w-9/12 w-full h-[21px] inline-block">
      <nav :class="collapse_nav_padding ? 'py-3' : 'py-6'" class="bg-white dark:bg-slate-700 px-5 border-b-[1px] border-secondary-300 dark:border-slate-500 fixed md:w-11/12 lg:w-9/12 w-full transition-all ease-linear duration-300 shadow-sm z-10">
        <div class="hidden sm:grid grid-cols-12 gap-6">
          <div class="col-span-7">
            <form >
              <div class="relative text-secondary-400">
                <font-awesome-icon icon="fa-solid fa-magnifying-glass" class="absolute top-0 bottom-0 my-auto text-secondary-200" />
                <input type="text" class="w-full border-0 text-sm pl-7 focus:outline-0 focus:outline-none focus:ring-0 bg-transparent dark:text-gray-200" placeholder="Search....">
              </div>
            </form>
          </div>

          <div class="col-span-5 px-2 pr-7">
            <div class="mt-[5px] float-right">
              <font-awesome-icon class="nav-icons" icon="fa-regular fa-bell" />
              <font-awesome-icon @click="darkModeStore.set()" class="nav-icons"  icon="fa-solid fa-circle-half-stroke" title="Toggle dark mode" />
              <!-- <font-awesome-icon class="nav-icons" icon="fa-regular fa-bell" /> -->
              <font-awesome-icon class="nav-icons" icon="fa-solid fa-arrow-right-from-bracket" />

              <Link href="" class="ml-7">
                <img  class="w-6 inline-block mt-[-10px] mr-1 rounded-full" :src="Avatar"/>
                <span class="hidden lg:inline-block text-xs font-semibold mt-[-10px] dark:text-secondary-300">@dave1614</span>
              </Link>
            </div>
          </div>
        </div>

        <div class="sm:hidden block">
          <div class="grid grid-cols-12 gap-6">
            <font-awesome-icon @click="mainStore.toggleSidebar()" class="nav-icons ml-3" icon="fa-solid fa-bars" />
            <font-awesome-icon class="nav-icons" icon="fa-solid fa-magnifying-glass" />
            <font-awesome-icon class="nav-icons" icon="fa-regular fa-bell" />
            <font-awesome-icon @click="darkModeStore.set()" class="nav-icons"  icon="fa-solid fa-circle-half-stroke" title="Toggle dark mode" />
            <font-awesome-icon class="nav-icons" icon="fa-solid fa-gear" />
            <!-- <font-awesome-icon class="nav-icons" icon="fa-solid fa-arrow-right-from-bracket" /> -->

            <Link href="" class="nav-icons p-0 mx-1 inline-block mt-0 bg-transparent">
              <img  class="w-8 h-8 inline-block  rounded-full" :src="Avatar"/>
            </Link>
          </div>
        </div>
      </nav>


    </div>
  </div>
</template>

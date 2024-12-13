<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, reactive, onMounted, onUnmounted  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'

import FlashMessages from '@/Components/FlashMessages.vue'
import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'
import Loader from '@/Loaders/loader.gif'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'

const props = defineProps({

});

const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()
const auth_user = page.props.auth.user


</script>

<template>
  <div v-if="mainStore.show_about_user_modal"  class="fixed top-0 bottom-0 left-0 right-0 z-[1000] ">
    <div @click.stop="mainStore.closeAboutAccountModal" class="h-screen w-screen bg-gradient-to-br from-slate-600/60 via-slate-700/60 to-slate-800/60 dark:bg-slate-900/80">

    </div>


    <div class="absolute m-auto min-h-fit sm:max-h-[90%] md:max-h-[55%] lg:max-h-[90%]  top-0 bottom-0 left-0 right-0 bg-white dark:bg-slate-700 sm:w-4/12 w-full   z-[1050] rounded-xl flex dark:text-slate-300">
      <div class=" w-full">
        <div class="border-b border-secondary-300 dark:border-slate-500 py-2 px-4 text-center">
          <span class=" text-lg font-bold inline-block">About this account</span>

          <font-awesome-icon @click="mainStore.closeAboutAccountModal" class="text-xl float-right cursor-pointer" icon="fa-solid fa-xmark" />
        </div>
        <div class="h-[420px] overflow-x-hidden px-5 py-2">
          <div class="text-center relative">
            <img class="rounded-[50%] w-[80px] h-[80px]  left-0 right-0 mx-auto" :src="mainStore.current_post.user.profile_picture" alt="">
          </div>
          <div class="text-center my-2">
            <h5 class="text-sm font-semibold">{{ mainStore.current_post.user.user_name }}</h5>
            <h5 class="text-xl font-bold">{{ mainStore.current_post.user.name }}</h5>

            <span class="text-xs leading-tight inline-block mt-3">
              {{ mainStore.current_post.user.bio }}
            </span>

          </div>

          <div class="mt-5">
            <h5 class="text-lg font-semibold">Date Joined</h5>
            <p class="text-sm">{{ mainStore.formatDate(mainStore.current_post.user.created_at, false) }}</p>
          </div>
          <div class="mt-3">
            <h5 class="text-lg font-semibold">Location</h5>
            <p class="text-sm "><span class="font-bold">Country: </span><span class="capitalize">{{ mainStore.current_post.user.country_details.name}}</span></p>
            <p class="text-sm "><span class="font-bold">State: </span><span class="capitalize">{{ mainStore.current_post.user.state_details.name}}</span></p>
            <p class="text-sm "><span class="font-bold">LGA: </span><span class="capitalize">{{ mainStore.current_post.user.lga_details.name}}</span></p>
            <p class="text-sm "><span class="font-bold">Community: </span><span class="capitalize">{{ mainStore.current_post.user.ward_details.name}}</span></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

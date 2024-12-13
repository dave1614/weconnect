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
  <div v-if="mainStore.show_user_followers_modal"  class="fixed top-0 bottom-0 left-0 right-0 z-[1000] ">
    <div @click.stop="mainStore.closeUserFollowerssModal" class="h-screen w-screen bg-gradient-to-br from-slate-600/60 via-slate-700/60 to-slate-800/60 dark:bg-slate-900/80">

    </div>


    <div class="absolute m-auto min-h-fit sm:max-h-[90%] md:max-h-[55%] lg:max-h-[90%]  top-0 bottom-0 left-0 right-0 bg-white dark:bg-slate-700 sm:w-4/12 w-full   z-[1050] rounded-xl flex dark:text-slate-300">
      <div class=" w-full">
        <div class="border-b border-secondary-300 dark:border-slate-500 py-2 px-4 text-center">
          <span class=" text-lg font-bold inline-block">Followers</span>

          <font-awesome-icon @click="mainStore.closeUserFollowerssModal" class="text-xl float-right cursor-pointer" icon="fa-solid fa-xmark" />
        </div>
        <div class="h-[380px] overflow-x-hidden px-3 py-2">
          <div v-if="mainStore.user_followers.length > 0" class="">
            <div v-for="(follower, index) in mainStore.user_followers" class="grid grid-cols-12 gap-1 my-3" :key="index">
              <div class="col-span-2">
                <Link @click="mainStore.closeUserFollowerssModal" :href="route('profile.show', follower.follower_details.slug)">
                  <img class="rounded-[50%] w-10 h-10" :src="follower.follower_details.profile_picture" alt="">
                </Link>
              </div>

              <div class="text-sm col-span-7">
                <h4 @click="mainStore.closeUserFollowerssModal" class="font-semibold"><Link @click="mainStore.closeUserFollowerssModal" :href="route('profile.show', follower.follower_details.slug)">{{ follower.follower_details.user_name }}</Link></h4>
                <h4 class="text-gray-400">{{ follower.follower_details.name }}</h4>
              </div>

              <div v-if="auth_user.id != follower.follower_details.id" class="col-span-3 text-sm">
                <button @click="mainStore.toggleFollowUser(follower.follower_details)" :class="!follower.follower_details.following_loading ? 'bg-gradient-to-r from-primary-100 to-primary-200' : 'bg-white border-[1px] border-secondary-200'" class=" rounded text-center font-semibold py-1 px-3 text-white w-[86px]">
                  <img v-if="follower.follower_details.following_loading" class="w-6 mx-auto" :src="Loader" alt="">

                  <span v-else v-text="follower.follower_details.following_status ? 'Following' : 'Follow'"></span>
                </button>
              </div>
            </div>

          </div>
          <div class="flex justify-center">
            <font-awesome-icon v-if="!mainStore.loading_user_followers && !mainStore.last_user_follower" @click="mainStore.loadUserFollowers()" class="text-3xl my-3 mt-6 cursor-pointer text-black dark:text-slate-300" icon="fa-regular fa-square-plus" />

            <img v-if="mainStore.loading_user_followers" class="w-[50px]" :src="Loader" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

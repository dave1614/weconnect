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

// console.log(mainStore.user_following[0].following_details)
</script>

<template>
  <div v-if="mainStore.show_community_leaders_modal"  class="fixed top-0 bottom-0 left-0 right-0 z-[1000] ">
    <div @click.stop="mainStore.closeCommunityLeadersModal" class="h-screen w-screen bg-gradient-to-br from-slate-600/60 via-slate-700/60 to-slate-800/60 dark:bg-slate-900/80">

    </div>


    <div class="absolute m-auto min-h-fit sm:max-h-[90%] md:max-h-[55%] lg:max-h-[90%]  top-0 bottom-0 left-0 right-0 bg-white dark:bg-slate-700 sm:w-4/12 w-full   z-[1050] rounded-xl flex dark:text-slate-300">
      <div class=" w-full">
        <div class="border-b border-secondary-300 dark:border-slate-500 py-2 px-4 text-center">
          <span class=" text-lg font-bold inline-block">Community Leaders</span>

          <font-awesome-icon @click="mainStore.closeCommunityLeadersModal" class="text-xl float-right cursor-pointer" icon="fa-solid fa-xmark" />
        </div>
        <div class="h-[380px] overflow-x-hidden px-3 py-2">
          <div v-if="mainStore.community_leaders.kings.length > 0" class="">
            <h3 class="mt-2 mb-5 font-bold text-xl">King</h3>
            <div v-for="(king, index) in mainStore.community_leaders.kings" class="grid grid-cols-12 gap-1 my-3" :key="index">
              <div class="col-span-2">
                <Link @click="mainStore.closeCommunityLeadersModal" :href="route('profile.show', king.slug)">
                  <img class="rounded-[50%] w-10 h-10" :src="king.profile_picture" alt="">
                </Link>
              </div>

              <div class="text-sm col-span-7">
                <h4 @click="mainStore.closeCommunityLeadersModal" class="font-semibold"><Link @click="mainStore.closeCommunityLeadersModal" :href="route('profile.show', king.slug)">{{ king.user_name }}</Link></h4>
                <h4 class="text-gray-400">{{ king.name }}</h4>
              </div>

              <div v-if="auth_user.id != king.id" class="col-span-3 text-sm">
                <button @click="mainStore.toggleFollowUser(king)" :class="!king.following_loading ? 'bg-gradient-to-r from-primary-100 to-primary-200' : 'bg-white border-[1px] border-secondary-200'" class=" rounded text-center font-semibold py-1 px-3 text-white w-[86px]">
                  <img v-if="king.following_loading" class="w-6 mx-auto" :src="Loader" alt="">

                  <span v-else v-text="king.following_status ? 'Following' : 'Follow'"></span>
                </button>
              </div>
            </div>

          </div>

          <div v-if="mainStore.community_leaders.chiefs.length > 0" class="my-[50px]">
            <h3 class="mt-2 mb-5 font-bold text-xl">Chiefs</h3>
            <div v-for="(chief, index) in mainStore.community_leaders.chiefs" class="grid grid-cols-12 gap-1 my-3" :key="index">
              <div class="col-span-2">
                <Link @click="mainStore.closeCommunityLeadersModal" :href="route('profile.show', chief.slug)">
                  <img class="rounded-[50%] w-10 h-10" :src="chief.profile_picture" alt="">
                </Link>
              </div>

              <div class="text-sm col-span-7">
                <h4 @click="mainStore.closeCommunityLeadersModal" class="font-semibold"><Link @click="mainStore.closeCommunityLeadersModal" :href="route('profile.show', chief.slug)">{{ chief.user_name }}</Link></h4>
                <h4 class="text-gray-400">{{ chief.name }}</h4>
              </div>

              <div v-if="auth_user.id != chief.id" class="col-span-3 text-sm">
                <button @click="mainStore.toggleFollowUser(chief)" :class="!chief.following_loading ? 'bg-gradient-to-r from-primary-100 to-primary-200' : 'bg-white border-[1px] border-secondary-200'" class=" rounded text-center font-semibold py-1 px-3 text-white w-[86px]">
                  <img v-if="chief.following_loading" class="w-6 mx-auto" :src="Loader" alt="">

                  <span v-else v-text="chief.following_status ? 'Following' : 'Follow'"></span>
                </button>
              </div>
            </div>

          </div>

          <div v-if="mainStore.community_leaders.cabinet_members.length > 0" class="mb-[50px]">
            <h3 class="mt-2 mb-5 font-bold text-xl">Cabinet Members</h3>
            <div v-for="(cabinet_member, index) in mainStore.community_leaders.cabinet_members" class="grid grid-cols-12 gap-1 my-3" :key="index">
              <div class="col-span-2">
                <Link @click="mainStore.closeCommunityLeadersModal" :href="route('profile.show', cabinet_member.slug)">
                  <img class="rounded-[50%] w-10 h-10" :src="cabinet_member.profile_picture" alt="">
                </Link>
              </div>

              <div class="text-sm col-span-7">
                <h4 @click="mainStore.closeCommunityLeadersModal" class="font-semibold"><Link @click="mainStore.closeCommunityLeadersModal" :href="route('profile.show', cabinet_member.slug)">{{ cabinet_member.user_name }}</Link></h4>
                <h4 class="text-gray-400">{{ cabinet_member.name }}</h4>
              </div>

              <div v-if="auth_user.id != cabinet_member.id" class="col-span-3 text-sm">
                <button @click="mainStore.toggleFollowUser(cabinet_member)" :class="!cabinet_member.following_loading ? 'bg-gradient-to-r from-primary-100 to-primary-200' : 'bg-white border-[1px] border-secondary-200'" class=" rounded text-center font-semibold py-1 px-3 text-white w-[86px]">
                  <img v-if="cabinet_member.following_loading" class="w-6 mx-auto" :src="Loader" alt="">

                  <span v-else v-text="cabinet_member.following_status ? 'Following' : 'Follow'"></span>
                </button>
              </div>
            </div>

          </div>

          <div class="flex justify-center">


            <img v-if="mainStore.loading_community_leaders" class="w-[50px]" :src="Loader" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

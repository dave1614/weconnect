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
  highlight_type: {
    type: String,
    default: null,
  }
});

const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()
const auth_user = page.props.auth.user

const sideBarListClasses = computed(() => {
  return `text-lg mx-3 ${mainStore.sidebar_open ? 'lg:hidden inline' : 'hidden lg:inline' } `;
})

const openSearch = () => {
  mainStore.show_form_box = true
  mainStore.show_search_box = true
}
</script>

<template>
  <div class="w-full">
    <div :class="mainStore.sidebar_open ? 'block shadow-md w-7/12 sm:w-full' : 'hidden'" class="md:w-1/12 lg:w-3/12  bg-secondary-100 dark:bg-slate-800 dark:text-secondary-100 h-screen sm:inline-block fixed social-media-sidebar top-0 left-0 z-30 ">
      <div class="w-full p-1">
        <h3 class="text-4xl font-bold font-grey_qo text-center my-2 lg:block hidden">WeConnect</h3>
        <h3 class="text-4xl font-bold font-grey_qo text-center my-2 lg:hidden block">We</h3>

        <ul class="mt-7 lg:px-5 px-1">
          <li class="list" :class="highlight_type == 'home' ? 'active' : ''">
            <Link :href="route('home_page')" >
              <font-awesome-icon icon="fa-solid fa-house" />
              <span :class="sideBarListClasses" class="mx-2">Home</span>

            </Link>
          </li>

          <li class="list"  :class="mainStore.show_form_box || mainStore.show_search_box ? 'active' : ''">
            <Link :href="`#`"  @click="openSearch">
              <font-awesome-icon icon="fa-solid fa-magnifying-glass" />
              <span :class="sideBarListClasses" class="mx-2">Search</span>
            </Link>
          </li>

          <li class="list" :class="highlight_type == 'edit_profile' ? 'active' : ''">
            <Link href="" >
              <font-awesome-icon icon="fa-solid fa-user-pen" />
              <span :class="sideBarListClasses" class="mx-2">Edit Profile</span>
            </Link>
          </li>

          <li class="list">
            <Link href="" >
              <font-awesome-icon icon="fa-regular fa-square-plus" />
              <span :class="sideBarListClasses" class="mx-2">Create</span>
            </Link>
          </li>

          <li class="list">
            <Link href="" >
              <font-awesome-icon icon="fa-regular fa-bell" />
              <span :class="sideBarListClasses" class="mx-2">Notifications</span>
            </Link>
          </li>

          <li  class="list" :class="highlight_type == 'community' ? 'active' : ''">
            <Link :href="route('community.profile', auth_user.ward_id)" >
              <font-awesome-icon icon="fa-regular fa-compass" />
              <span :class="sideBarListClasses" class="mx-2">Community</span>
            </Link>
          </li>

          <li  class="list" :class="highlight_type == 'bookmarks' ? 'active' : ''">
            <Link :href="route('bookmark.index')">
              <font-awesome-icon icon="fa-solid fa-bookmark" />
              <span :class="sideBarListClasses" class="mx-2">Bookmarks</span>
            </Link>
          </li>

          <li  class="list">
            <Link href="" >
              <font-awesome-icon icon="fa-solid fa-briefcase" />
              <span :class="sideBarListClasses" class="mx-2">VTU</span>
            </Link>
          </li>

          <li  class="list">
            <Link href="" >
              <font-awesome-icon icon="fa-solid fa-briefcase" />
              <span :class="sideBarListClasses" class="mx-2">Jobs</span>
            </Link>
          </li>



          <!-- <li class="list">
            <Link href="" >
              <font-awesome-icon icon="fa-solid fa-gear" />
              <span :class="sideBarListClasses" class="mx-2">Settings</span>
            </Link>
          </li> -->


        </ul>
      </div>
    </div>

  </div>
</template>

<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, reactive, onMounted, onUnmounted  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'

import SideBar from '@/Components/Social/SideBar.vue'
import NavBar from '@/Components/Social/NavBar.vue'
import PostLike from '@/Components/Social/PostLike.vue'
import CommentLike from '@/Components/Social/CommentLike.vue'
import ReplyLike from '@/Components/Social/ReplyLike.vue'
import PostMoreOptions from '@/Components/Social/PostMoreOptions.vue'
import CommentMoreOptions from '@/Components/Social/CommentMoreOptions.vue'
import ReplyMoreOptions from '@/Components/Social/ReplyMoreOptions.vue'
import AboutUser from '@/Components/Social/AboutUser.vue'


import Toast from '@/Components/Toast.vue'


import Loader from '@/Loaders/loader.gif'

import FlashMessages from '@/Components/FlashMessages.vue'
import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'
import UserFollowers from '@/Components/Social/UserFollowers.vue'
import UserFollowing from '@/Components/Social/UserFollowing.vue'

import CommunityMoreOptions from '@/Components/Social/CommunityMoreOptions.vue'
import CommunityLeaderForm from '@/Components/Social/CommunityLeaderForm.vue'
import CommunityLeaders from '@/Components/Social/CommunityLeaders.vue'
import CommunityResidents from '@/Components/Social/CommunityResidents.vue'
import ManageCommunityHistory from '@/Components/Social/ManageCommunityHistory.vue'
import NewCommunityImage from '@/Components/Social/NewCommunityImage.vue'






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


</script>

<template>
  <div class="bg-white dark:bg-slate-700 relative">

    <!-- Sidebar -->
    <SideBar :highlight_type="highlight_type" />

    <!-- Navbar -->
    <NavBar />

    <slot />
    <PostLike />
    <CommentLike />
    <ReplyLike />
    <PostMoreOptions />
    <CommentMoreOptions />
    <ReplyMoreOptions />
    <AboutUser />

    <UserFollowers />
    <UserFollowing />

    <CommunityMoreOptions />
    <CommunityLeaderForm />
    <CommunityLeaders />
    <CommunityResidents />
    <ManageCommunityHistory />
    <NewCommunityImage />


  </div>
  <!-- <div @click="mainStore.hideNotiBox()" v-if="mainStore.show_noti_box" class="fixed w-screen h-screen top-0 bottom-0 left-0 right-0 z-[-13] bg-black opacity-40"></div> -->
  <Toast />
</template>

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
  <div v-if="mainStore.show_reply_more_options_modal"  class="fixed top-0 bottom-0 left-0 right-0 z-[1000] ">
    <div @click.stop="mainStore.closeCommentReplyMoreOptionsModal" class="h-screen w-screen bg-gradient-to-br from-slate-600/60 via-slate-700/60 to-slate-800/60 dark:bg-slate-900/80">

    </div>


    <div class="absolute m-auto min-h-fit sm:max-h-[90%] md:max-h-[55%] lg:max-h-[90%]  top-0 bottom-0 left-0 right-0 bg-white dark:bg-slate-700 sm:w-4/12 w-full   z-[1050] rounded-xl flex dark:text-slate-300">
      <div class="text-center w-full text-sm">
        <div v-if="auth_user.id != mainStore.current_reply.user.id" @click="mainStore.toggleFollowUser(mainStore.current_reply.user)" class="py-3 divider" :class="mainStore.current_reply.user.following_loading ? 'opacity-50 cursor-not-allowed' : ''">
          <span class="font-bold" >
            <span v-if="mainStore.current_reply.user.following_status" class="text-red-500">Unfollow</span>
            <span v-else class="text-primary-100">Follow</span>
          </span>
        </div>

        <div v-else @click="mainStore.deleteCommentReply(mainStore.current_reply)" class="py-3 divider" :class="mainStore.current_reply.deleting_loading ? 'opacity-50 cursor-not-allowed' : ''">
          <span class="font-bold" >
            <span class="text-red-500">Delete</span>

          </span>
        </div>




        <div @click="mainStore.closeCommentReplyMoreOptionsModal" class="py-3 divider border-0">
          <span class="">
            Cancel
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

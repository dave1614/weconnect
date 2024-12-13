<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, reactive, onMounted, onUnmounted, watch  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'

import FlashMessages from '@/Components/FlashMessages.vue'
import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'
import Loader from '@/Loaders/loader.gif'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'
import { useAxios } from '@/composables/axios.js'

const props = defineProps({

});

const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()
const auth_user = page.props.auth.user


const openEditPostPage = () => {
  var id = mainStore.current_post.id;
  mainStore.closePostMoreOptionsModal()
  router.visit(route('post.edit', id))
}

const deletePost = () => {
//   mainStore.post_deleted_evt = mainStore.current_post_index
  var id = mainStore.current_post.id
  Swal.fire({
    title: `Are you sure you want to delete this post?`,
    html: '<b class="text-primary-100">Note: This process is irreversible</b>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes Proceed!',
  }).then((result) => {

    if (result.isConfirmed) {
      mainStore.closePostMoreOptionsModal()
      router.visit(route('post.edit', id)+ '?delete=true')

    } else if (result.isDenied) {
      // Swal.fire('Changes are not saved', '', 'info')
    }
  })
}

const processDeletePost = async () => {
  let queryRoute = route('post.destroy', mainStore.current_post.id);

  const { response, error, loading  } = await useAxios(queryRoute, `Deleting this post .....`, {delete_post: true});

  if (response?.value?.data) {
    if(response.value.data.success){
      mainStore.toast = `This post has been deleted successfully`;

      mainStore.post_deleted_evt = mainStore.current_post_index
    }

  }
}

</script>

<template>
  <div v-if="mainStore.show_post_more_options_modal"  class="fixed top-0 bottom-0 left-0 right-0 z-[1000] ">
    <div @click.stop="mainStore.closePostMoreOptionsModal" class="h-screen w-screen bg-gradient-to-br from-slate-600/60 via-slate-700/60 to-slate-800/60 dark:bg-slate-900/80">

    </div>


    <div class="absolute m-auto min-h-fit sm:max-h-[90%] md:max-h-[55%] lg:max-h-[90%]  top-0 bottom-0 left-0 right-0 bg-white dark:bg-slate-700 sm:w-4/12 w-full   z-[1050] rounded-xl flex dark:text-slate-300">
      <div class="text-center w-full text-sm">
        <div v-if="auth_user.id != mainStore.current_post.user.id" @click="mainStore.toggleFollowUser(mainStore.current_post.user)" class="py-3 divider" :class="mainStore.current_post.user.following_loading ? 'opacity-50 cursor-not-allowed' : ''">
          <span class="font-bold" >
            <span v-if="mainStore.current_post.user.following_status" class="text-red-500">Unfollow</span>
            <span v-else class="text-primary-100">Follow</span>
          </span>
        </div>

        <div v-if="auth_user.id == mainStore.current_post.user.id" @click="openEditPostPage" class="py-3 divider">
          <span class="" >
            <span class="">Edit this post</span>

          </span>
        </div>

        <div v-if="auth_user.id == mainStore.current_post.user.id" @click="deletePost" class="py-3 divider">
          <span class="font-bold" >
            <span class="text-red-500">Delete Post</span>

          </span>
        </div>

        <div @click="mainStore.addPostToFavorites(mainStore.current_post)" class="py-3 divider" :class="mainStore.current_post.favorite_loading ? 'opacity-50 cursor-not-allowed' : ''">
          <span class="font-bold" >
            <span v-if="mainStore.current_post.is_favorite" class="text-red-500">Remove from favorites</span>
            <span v-else class="text-primary-100">Add to favorites</span>
          </span>
        </div>

        <div @click="mainStore.sharePost(mainStore.current_post)" class="py-3 divider">
          <span class="">
            Share to...
          </span>
        </div>

        <div @click="mainStore.copyPostLink(mainStore.current_post)" class="py-3 divider">
          <span class="">
            Copy link
          </span>
        </div>

        <div @click="mainStore.aboutAccount(mainStore.current_post.user)" class="py-3 divider" :class="mainStore.current_post.user.about_user_loading ? 'opacity-50 cursor-not-allowed' : ''">
          <span class="">
            About this account
          </span>
        </div>

        <div @click="mainStore.closePostMoreOptionsModal" class="py-3 divider border-0">
          <span class="">
            Cancel
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

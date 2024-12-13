<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, reactive, onMounted, onUnmounted  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'
import LayoutSocial from '@/Layouts/LayoutSocial.vue'

import Loader from '@/Loaders/loader.gif'
import FormLoaderDark from '@/Loaders/form_loader_dark.gif'
import FormLoaderLight from '@/Loaders/form_loader_light.gif'
import FlashMessages from '@/Components/FlashMessages.vue'
import CardBoxModal from '@/Components/CardBoxModal.vue'
import BaseButton from '@/Components/BaseButton.vue'


import Post from '@/Components/Social/Post.vue'
import PostPopup from '@/Components/Social/PostPopup.vue'


import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'
import { useAxios } from '@/composables/axios.js'

const props = defineProps({
  post: {
    type: Object,
  },
  auth_user: {
    type: Object,
  },


});



const post = ref(props.post);
console.log(post.value)
const auth_user = ref(props.auth_user);



const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()


const comment_input = ref(null);
const open_post_index = ref(false);
const open_media_index = ref(false);
const current_media_index = ref(0);
const make_comment_open = ref(false);




onMounted(() => {

})


const make_comment_form = useForm({
  comment: "",
})

const openBiggerPost = (post_index, media_index) => {
  open_post_index.value = post_index;
  open_media_index.value = media_index;
  current_media_index.value = media_index;

  console.log(open_post_index.value)
  console.log(open_media_index.value)
}


const makeCommentAction = (index) => {
  openBiggerPost(index, 0);
  comment_input.value.focus();
}


const toggleCommentLike = (post_index, id) => {
  let index = id - 1;
  console.log(post.value.liked);
  let post = post.value;
  post.comments[index].liked = !post.comments[index].liked;
}


</script>

<template>
  <LayoutSocial>

    <!-- <div class="fixed top-0 bottom-0 left-0 right-0 w-screen h-screen ">
      <div class="relative w-full h-full">

      </div>
    </div> -->

    <div class="w-full">
      <div class="w-full min-h-screen mt-[30px]">
        <div class="grid grid-cols-12 gap-6">
          <div class="hidden sm:inline-block sm:col-span-3">

          </div>



          <div class="col-span-12 sm:col-span-9 border-0  min-h-screen dark:text-slate-400">
            <div class="sm:px-7 px-2 py-4">
              <div class="mt-[50px]">
                <div class="flex justify-center mx-2">
                  <Post class="sm:w-8/12 w-full" :post="post" :index="0" :make_comment_open="make_comment_open" @open-bigger-post="openBiggerPost" @make-comment-action="makeCommentAction" @toggle-comment-like="toggleCommentLike" />
                </div>
              </div>
            </div>
          </div>


        </div>

      </div>
    </div>


    <PostPopup v-model:open-post-index="open_post_index" v-model:open-media-index="open_media_index"  v-model:current-media-index="current_media_index" :post="open_post_index !== false && open_media_index !== false ? post : {}"  :make_comment_form="make_comment_form"/>
  </LayoutSocial>
</template>

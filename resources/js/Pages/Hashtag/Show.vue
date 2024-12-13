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
import CardBox from '@/Components/CardBox.vue'
import BaseButton from '@/Components/BaseButton.vue'
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";


import Post from '@/Components/Social/Post.vue'
import PostPopup from '@/Components/Social/PostPopup.vue'


import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'
import { useAxios } from '@/composables/axios.js'

import {

  mdiPound,
  mdiEmailNewsletter,
  mdiCurrencyUsd,
  mdiClose,
  mdiClipboardText,
  mdiAccountCash,
  mdiImageMove,
  mdiClipboard,
  mdiRefresh,
  mdiViewListOutline,
  mdiGithub,

} from "@mdi/js";

const props = defineProps({
  tag: {
    type: String,
  },
  auth_user: {
    type: Object,
  },
  posts: {
    type: Array,
    default: [],
  }


});



const posts = ref(props.posts);
const auth_user = ref(props.auth_user);
console.log(posts.value)
const make_comment_open = ref(false);
const open_post_index = ref(false);
const open_media_index = ref(false);
const current_media_index = ref(0);
const max_post_length = ref(3000);


const posts_loading = ref(false);
const last_post = ref(false);


const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()


onMounted(() => window.addEventListener('scroll', windowScrolled))
onUnmounted(() => window.removeEventListener('scroll', windowScrolled))

const windowScrolled = (event) => {

  // let content_scroll_pos =
  // var percentage_value = content_scroll_pos * 100 / content_height;

  // if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight) {
      // you're at the bottom of the page

  if (document.documentElement.scrollTop + window.innerHeight > document.documentElement.scrollHeight * 0.75) {

    fetchMorePosts();
  }
}

const fetchMorePosts = async () => {
  try {
    if(posts_loading.value || last_post.value){
      return
    }

    var last_id = posts.value[posts.value.length - 1].id;
    posts_loading.value = true;

    let queryRoute = route('tag.load_more_posts', props.tag);

    const response = await axios.post(queryRoute, {last_id: last_id});
    console.log(response)
    posts_loading.value = false;

    if (response.data.posts.length > 0 && !response.data.last_post) {
      posts.value = posts.value.concat(response.data.posts);
      // form.city = cities.value[0];

    } else if(response.data.last_post){
      last_post.value = true;
    } else {
      console.log('Something went wrong')
    }
  } catch (error) {

    posts_loading.value = false;
    if (error.response) {
      // Request made but the server responded with an error
      var status = error.response.status;
      if (status == 419) {
        document.location.reload()
      }

    } else if (error.request) {
      // Request made but no response is received from the server.
    } else {
      // Error occured while setting up the request
    }

    console.log('Something went wrong' + error)

    // Swal.fire({
    //   title: 'Ooops!',
    //   html: 'Something went wrong',
    //   icon: 'error',


    // });
  }
}


const show_drop = ref(false);

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

const togglePostLike = async (index, id) => {

try {
  if(mainStore.post_like_loading){
    return
  }

  let post = posts.value[index].post

  mainStore.post_like_loading = true;

  let queryRoute = route('post.toggle_like', {post: post.id});

  const response = await axios.post(queryRoute);
  console.log(response)
  mainStore.post_like_loading = false;

  if (response.data.success && response.data.action != "") {

    post.liked = response.data.action == "liked" ? true : false;
    post.likes_num = post.liked ? post.likes_num + 1 : post.likes_num - 1;
    // form.city = cities.value[0];

  } else {
    console.log('Something went wrong')
  }
} catch (error) {

  mainStore.post_like_loading = false;
  if (error.response) {
    // Request made but the server responded with an error
    var status = error.response.status;
    if (status == 419) {
      document.location.reload()
    }

  } else if (error.request) {
    // Request made but no response is received from the server.
  } else {
    // Error occured while setting up the request
  }

  console.log('Something went wrong' + error)

  // Swal.fire({
  //   title: 'Ooops!',
  //   html: 'Something went wrong',
  //   icon: 'error',


  // });
}
}

const toggleCommentLike = (post_index, id) => {
  // let index = id - 1;
  // console.log(posts.value[post_index].post.comments[index].liked);
  // let post = posts.value[post_index].post;
  // post.comments[index].liked = !post.comments[index].liked;
}


</script>

<template>
  <Head :title="`Search results for hashtag ${tag}`" />
  <LayoutSocial>

    <!-- <div class="fixed top-0 bottom-0 left-0 right-0 w-screen h-screen ">
      <div class="relative w-full h-full">

      </div>
    </div> -->

    <div class="w-full bg-gray-100 dark:bg-slate-700">
      <div class="w-full min-h-screen mt-[30px]">
        <div class="grid grid-cols-12 gap-6">
          <div class="hidden sm:inline-block sm:col-span-3">

          </div>



          <div class="col-span-12 sm:col-span-9 border-0  min-h-screen dark:text-slate-400">
            <div class="sm:px-7 px-2 py-4">
              <div class="mt-[50px]">
                <SectionTitleLineWithButton :icon="mdiPound" :title="`Search results for hashtag <em class='text-primary-100'>#${tag}</em>`" main>
                  <!-- <BaseButton
                  href="https://github.com/justboil/admin-one-vue-tailwind"
                  target="_blank"
                  :icon="mdiGithub"
                  label="Star on GitHub"
                  color="contrast"
                  rounded-full
                  small
                /> -->
                </SectionTitleLineWithButton>


                <div v-if="posts.length > 0" class="">

                  <div class="sm:grid sm:grid-cols-12 sm:gap-6">
                    <Post class="sm:col-span-6" v-for="(post, index) in posts" :key="index" :post="post.post" :index="index" :make_comment_open="make_comment_open" @open-bigger-post="openBiggerPost" @make-comment-action="makeCommentAction" @toggle-post-like="togglePostLike" @toggle-comment-like="toggleCommentLike" />

                  </div>
                  <div v-if="posts_loading" class="flex justify-center">
                    <img class="w-[50px]" :src="Loader" alt="">
                  </div>
                </div>

                <div v-else class="">
                  <h4 class="text-xl font-semibold text-orange-500">No posts under this hashtag</h4>
                </div>

              </div>
            </div>
          </div>


        </div>

      </div>
    </div>

    <PostPopup v-model:open-post-index="open_post_index" v-model:open-media-index="open_media_index"  v-model:current-media-index="current_media_index" :post="open_post_index !== false && open_media_index !== false ? posts[open_post_index].post : {}"  :make_comment_form="make_comment_form"/>
  </LayoutSocial>
</template>

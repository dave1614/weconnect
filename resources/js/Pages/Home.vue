<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, reactive, onMounted, onUnmounted  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'
import LayoutSocial from '@/Layouts/LayoutSocial.vue'

import Loader from '@/Loaders/loader.gif'
import FormLoaderDark from '@/Loaders/form_loader_dark.gif'
import FormLoaderLight from '@/Loaders/form_loader_light.gif'
import FlashMessages from '@/Components/FlashMessages.vue'
import CreatePost from '@/Components/Social/CreatePost.vue'
import Post from '@/Components/Social/Post.vue'
import PostPopup from '@/Components/Social/PostPopup.vue'



import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'

const props = defineProps({
  posts: {
    type: Array,
    default: []
  },
  user: {
    type: Object,
  }

});

console.log(props.posts)

const posts = ref(props.posts);


const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()






// const state = reactive({files});

const comment_input = ref(null);
const open_post_index = ref(false);
const open_media_index = ref(false);
const current_media_index = ref(0);
const make_comment_open = ref(false);

const post_liked = ref(false);
const show_more = ref(false);


const posts_loading = ref(false);
const last_post = ref(false);

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




const outputPostText = (str) => {
  let truncated_res = mainStore.truncateStr(str, 224);

  return truncated_res;
};

const submit = () => {

  if (!form.processing) {
    form.post(route('register'), {
      preserveScroll: true,
      onSuccess: (page) => {

        var response = page.props.flash.data;
        if (response.success) {

        }
        else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong.',
          })
        }
      }, onError: (errors) => {
        var size = Object.keys(errors).length;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `There are ${size} form errors. Please fix them`,
        })
      },
    });
  }
}





const togglePostLike = async (index, id) => {

try {
  if(mainStore.post_like_loading){
    return
  }

  let post = posts.value[index]

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

const toggleCommentLike = async (post_index, comment) => {
  // let index = id - 1;
  // console.log(posts.value[post_index].comments[index].liked);
  // let post = posts.value[post_index];
  // post.comments[index].liked = !post.comments[index].liked;

  try {
    if(mainStore.comments_like_loading){
      return
    }
    let post = posts.value[post_index];
    mainStore.comments_like_loading = true;

    let queryRoute = route('comment.toggle_like', {post: post.id, comment: comment.id});

    const response = await axios.post(queryRoute);
    console.log(response)
    mainStore.comments_like_loading = false;

    if (response.data.success && response.data.action != "") {
      console.log(comment)
      comment.liked = response.data.action == "liked" ? true : false;
      comment.likes_num = comment.liked ? comment.likes_num + 1 : comment.likes_num - 1;
      // form.city = cities.value[0];

    } else {
      console.log('Something went wrong')
    }
  } catch (error) {
    mainStore.comments_like_loading = false;

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



const fetchMorePosts = async () => {
  try {
    if(posts_loading.value || last_post.value){
      return
    }

    var last_id = posts.value[posts.value.length - 1].id;
    posts_loading.value = true;

    let queryRoute = route('load_more_posts_home');

    const response = await axios.post(queryRoute, {last_id: last_id});
    console.log(response)
    posts_loading.value = false;

    if (response.data.posts.length > 0 && !response.data.last_post) {
      posts.value = posts.value.concat(response.data.posts);
      // form.city = cities.value[0];

      console.log(posts.value)

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
</script>

<template>
  <LayoutSocial :highlight_type="'home'">

    <!-- <div class="fixed top-0 bottom-0 left-0 right-0 w-screen h-screen ">
      <div class="relative w-full h-full">

      </div>
    </div> -->

    <div class="w-full">
      <div class="w-full min-h-screen mt-[85px]">
        <div class="grid grid-cols-12 gap-6">
          <div class="hidden sm:inline-block sm:col-span-3">

          </div>



          <div class="col-span-12 sm:col-span-6 border-0 sm:border-r-[1px] border-secondary-300 dark:border-slate-500 min-h-screen">
            <div class="px-2 sm:px-5 py-4">
              <CreatePost />

              <div class="posts mt-[70px] text-secondary-200 dark:text-slate-300">
                <Post v-for="(post, index) in posts" :key="index" :post="post" :index="index" :make_comment_open="make_comment_open" @open-bigger-post="openBiggerPost" @make-comment-action="makeCommentAction" @toggle-post-like="togglePostLike" @toggle-comment-like="toggleCommentLike" />

                <div v-if="posts_loading" class="flex justify-center">
                  <img class="w-[50px]" :src="Loader" alt="">
                </div>
              </div>
            </div>
          </div>

          <div class="hidden sm:inline-block sm:col-span-3">

          </div>
        </div>

      </div>
    </div>

    <PostPopup v-model:open-post-index="open_post_index" v-model:open-media-index="open_media_index"  v-model:current-media-index="current_media_index" :post="open_post_index !== false && open_media_index !== false ? posts[open_post_index] : {}" />
  </LayoutSocial>
</template>

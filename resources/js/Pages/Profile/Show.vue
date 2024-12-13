<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, reactive, onMounted, onUnmounted, watch  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'
import LayoutSocial from '@/Layouts/LayoutSocial.vue'

import Loader from '@/Loaders/loader.gif'
import FormLoaderDark from '@/Loaders/form_loader_dark.gif'
import FormLoaderLight from '@/Loaders/form_loader_light.gif'
import FlashMessages from '@/Components/FlashMessages.vue'
import CardBoxModal from '@/Components/CardBoxModal.vue'
import BaseButton from '@/Components/BaseButton.vue'
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
  auth_user: {
    type: Object,
  },
  user: {
    type: Object,
  },


});

console.log(props.user)

const posts = ref(props.posts);
const auth_user = ref(props.auth_user);
const user = ref(props.user);

console.log(posts.value)
const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()





let files = []
// const state = reactive({files});
const post_medias = ref(null);
const profile_photo_medias = ref(null);
const comment_input = ref(null);
const open_post_index = ref(false);
const open_media_index = ref(false);
const current_media_index = ref(0);
const make_comment_open = ref(false);
const max_post_length = ref(3000);
const post_liked = ref(false);
const show_more = ref(false);
const rem_chars = ref(max_post_length.value);
const create_post_input_fcsd = ref(false);

const showUpdateCoverPhotoModal = ref(false)
const showUpdateProfilePhotoModal = ref(false)

const posts_loading = ref(false);
const last_post = ref(false);




const watchPostDeltdEvt = () => {
  if(mainStore.post_deleted_evt != false){
    console.log('deleted')
    var index = mainStore.post_deleted_evt

    posts.value.splice(index, 1)
    mainStore.post_deleted_evt = false
  }
}

onMounted(() => {
  // watch(mainStore.post_deleted_evt, watchPostDeltdEvt)


})




const make_comment_form = useForm({
  comment: "",
})


const cover_photo_form = useForm({
  image: null
})

const profile_picture_form = useForm({
  image: null
})


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

    let queryRoute = route('profile.load_more_posts', auth_user.value.slug);

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

const toggleCommentLike = (post_index, id) => {
  let index = id - 1;
  console.log(posts.value[post_index].comments[index].liked);
  let post = posts.value[post_index];
  post.comments[index].liked = !post.comments[index].liked;
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



const changeCoverPhoto = () => {
  showUpdateCoverPhotoModal.value = true
}

const submitCoverPhotoForm = () => {

if (!cover_photo_form.processing) {
  cover_photo_form.post(route('profile.update_cover_photo'), {
    preserveScroll: true,
    onSuccess: (page) => {

      var response = page.props.flash.data;
      if (response.success) {
        auth_user.value = response.user
        user.value = response.user

        mainStore.toast = 'cover photo changed successfully'
        showUpdateCoverPhotoModal.value = false;
        cover_photo_form.image = null;

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

const updateAddCoverPhotoFiles = (event) => {
  let files = event.target.files;
  if (! files) return;



    let file = files[0];
    if (! file) return;
    // file.open = false;


    if(file.type == 'image/jpeg' || file.type == 'image/jpg' || file.type == 'image/png'){
      const reader = new FileReader();

      reader.onload = (e) => {

          file.preview = e.target.result;
      };

      reader.readAsDataURL(file);
    }

    setTimeout(() => {
      cover_photo_form.image = file
    }, 500);


}


const selectCoverPhotoFiles = () => {
  post_medias.value.click();
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

const changeProfilePicture = () => {
  if(auth_user.value.id != user.value.id){
    return;
  }

  showUpdateProfilePhotoModal.value = true
}

const selectProfilePictureFiles = () => {
  profile_photo_medias.value.click();
}

const updateAddProfilePictureFiles = (event) => {
  let files = event.target.files;
  if (! files) return;



    let file = files[0];
    if (! file) return;
    // file.open = false;


    if(file.type == 'image/jpeg' || file.type == 'image/jpg' || file.type == 'image/png'){
      const reader = new FileReader();

      reader.onload = (e) => {

          file.preview = e.target.result;
      };

      reader.readAsDataURL(file);
    }

    setTimeout(() => {
      profile_picture_form.image = file
    }, 500);


}

const submitProfilePictureForm = () => {

if (!profile_picture_form.processing) {
  profile_picture_form.post(route('profile.update_profile_picture'), {
    preserveScroll: true,
    onSuccess: (page) => {

      var response = page.props.flash.data;
      if (response.success) {
        auth_user.value = response.user
        user.value = response.user

        mainStore.toast = 'Profile picture changed successfully'
        showUpdateProfilePhotoModal.value = false;
        profile_picture_form.image = null;

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



          <div class="col-span-12 sm:col-span-9 border-0  min-h-screen">
            <div class="-px-2 py-4">
              <div class="">
                <div class="w-full h-[300px] relative" :style="`background:linear-gradient(rgba(0, 0, 0,0.3),rgba(0, 0, 0,0.3)), url('${user.cover_photo}'); -webkit-background-size:cover; -moz-background-size:cover; background-size: cover; -o-background-size:cover; background-repeat: no-repeat; background-position: center;`">

                  <div  @click="changeProfilePicture" v-if="auth_user.id == user.id" :class="auth_user.id == user.id ? 'cursor-pointer' : ''" class="absolute w-[150px] h-[150px]  left-0 right-0 sm:mx-0 bottom-0 rounded-full sm:rounded-lg sm:ml-9 mx-auto bg-white p-[2px] -mb-[50px] z-[2]">
                    <img :src="user.profile_picture" class="w-full h-full rounded-full sm:rounded-lg" alt="">

                  </div>

                  <div @click="changeCoverPhoto" v-if="auth_user.id == user.id" class="absolute top-0 right-0 mt-7 mr-6 bg-black opacity-70 rounded-full p-2 px-3 cursor-pointer" title="Change cover photo">
                    <font-awesome-icon class="text-white font-bold text-xl " icon="fa-regular fa-pen-to-square" />
                  </div>
                </div>


                <div class=" bg-white dark:bg-slate-800 rounded-xl mx-4 -mt-9 z-[1] relative my-2 dark:text-slate-300">
                  <div class="sm:ml-[200px]">
                    <div class="h-[100px] sm:h-[10px]"></div>

                    <div v-if="auth_user.id != user.id" class="mr-7 text-sm float-right sm:block hidden">
                      <button @click="mainStore.toggleFollowUser(user)" :class="!user.following_loading ? 'bg-gradient-to-r from-primary-100 to-primary-200' : 'bg-white border-[1px] border-secondary-200'" class=" rounded-full text-center font-semibold py-3 px-9 text-white ">
                        <img v-if="user.following_loading" class="w-[35px] mx-auto" :src="Loader" alt="">

                        <span v-else v-text="user.following_status ? 'Following' : 'Follow'"></span>
                      </button>
                    </div>

                    <div v-else class="mr-7 text-sm float-right sm:block hidden mt-3">
                      <Link :href="route('edit_profile')" class="bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-full text-center font-semibold py-3 px-9 text-white ">

                        <span>Edit Profile</span>
                      </Link>
                    </div>


                    <h4 class="text-lg  font-semibold sm:text-left text-center text-gray-400 ">{{ user.user_name }}</h4>
                    <h4 class="text-2xl sm:text-xl font-bold sm:text-left text-center sm:mt-1 mt-1">{{ user.name }}</h4>

                    <p class="text-xs leading-tight text-center sm:text-left my-2">{{ user.bio }}</p>
                    <p class="text-sm text-gray-400 text-center sm:text-left my-2"><font-awesome-icon class="text-red-400" icon="fa-solid fa-location-dot" /> {{ user.lga_details.name}}, {{ user.state_details.name}}, Nigeria</p>
                    <div v-if="auth_user.id != user.id" class="text-lg my-3 text-center block sm:hidden">
                      <button @click="mainStore.toggleFollowUser(user)" :class="!user.following_loading ? 'bg-gradient-to-r from-primary-100 to-primary-200' : 'bg-white border-[1px] border-secondary-200'" class=" rounded-full text-center font-semibold py-2 px-9 text-white ">
                        <img v-if="user.following_loading" class="w-6 mx-auto" :src="Loader" alt="">

                        <span v-else v-text="user.following_status ? 'Following' : 'Follow'"></span>
                      </button>
                    </div>
                    <div v-else class="text-sm text-center block sm:hidden my-3 mt-6">
                      <Link :href="route('edit_profile')" class="bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-full text-center font-semibold py-3 px-9 text-white ">

                        <span>Edit Profile</span>
                      </Link>
                    </div>



                  </div>

                  <div class="flex justify-center items-center my-6 mb-3 bg-gray-100 dark:bg-slate-600 mx-2 rounded-xl px-3 py-2">
                    <div class="text-center">
                      <div class="inline-block mx-3 p-2 px-4 border-4 border-primary-200 rounded-xl cursor-pointer">
                        <h4 class="text-3xl font-bold">{{ mainStore.convertNumberToKOrMorB(user.total_posts_num) }}</h4>
                        <h6 class="text-sm font-bold">Posts</h6>
                      </div>

                      <div @click="mainStore.loadUserFollowers(user.slug)" class="inline-block mx-3 cursor-pointer">
                        <h4 class="text-3xl font-bold">{{ mainStore.convertNumberToKOrMorB(user.followers_num) }}</h4>
                        <h6 class="text-sm font-bold">Followers</h6>
                      </div>

                      <div @click="mainStore.loadUserFollowing(user.slug)" class="inline-block mx-3 cursor-pointer">
                        <h4 class="text-3xl font-bold">{{ mainStore.convertNumberToKOrMorB(user.following_num) }}</h4>
                        <h6 class="text-sm font-bold">Following</h6>
                      </div>
                    </div>
                  </div>

                  <div class="bg-gray-100 dark:bg-slate-600 mx-2 px-3 py-2 rounded-xl posts mt-6 text-secondary-200 dark:text-slate-300 ">

                    <div class="sm:w-6/12 flex justify-center mx-auto my-4" v-if="auth_user.id == user.id">
                      <CreatePost :placeholder="`What's on your mind ${auth_user.name}?`"  />
                    </div>

                    <div v-if="posts.length > 0" class="mt-[40px]">

                      <div class="sm:grid sm:grid-cols-12 sm:gap-6">
                        <Post class="sm:col-span-6" v-for="(post, index) in posts" :key="index" :post="post" :index="index" :make_comment_open="make_comment_open" @open-bigger-post="openBiggerPost" @make-comment-action="makeCommentAction" @toggle-post-like="togglePostLike" @toggle-comment-like="toggleCommentLike" />

                      </div>
                      <div v-if="posts_loading" class="flex justify-center">
                        <img class="w-[50px]" :src="Loader" alt="">
                      </div>
                    </div>

                    <div v-else class="">

                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>


        </div>

      </div>
    </div>

    <CardBoxModal v-model="showUpdateCoverPhotoModal" button="danger" buttonLabel="Close"
      :title="`Update cover photo`">

      <form @submit.prevent="submitCoverPhotoForm" class="mt-5">
        <h6 class="text-sm italic font-semibold my-2 text-primary-100">Select an image to upload. Max size: 3MB</h6>
        <div @click="selectCoverPhotoFiles" class="w-full h-[200px] relative border rounded border-gray-300  cursor-pointer">
          <div class="absolute top-0 bottom-0 right-0 left-0 m-auto h-[80px] w-[80px]  text-gray-400">
            <font-awesome-icon class="text-3xl" icon="fa-solid fa-file-circle-plus" />
            <h5 class="text-lg font-semibold" v-text="cover_photo_form.image ? 'Change image' : 'Select an image'"></h5>
          </div>
        </div>
        <input type="file" class="hidden"
              ref="post_medias"
              accept=".jpg, .png, .jpeg"
              @change="updateAddCoverPhotoFiles">


        <div v-if="cover_photo_form.errors.image" class="my-2">
          <h5 class="text-xl">The following error occured</h5>
          <p class="text-red-500 italic my-3">{{ cover_photo_form.errors.image }}</p>
        </div>

        <div v-if="cover_photo_form.image" class="text-xs py-2 text-secondary-400 dark:text-slate-600 max-h-[140px] overflow-x-hidden">
          <h4 class="text-2xl font-bold text-center">Preview</h4>

          <img v-if="cover_photo_form.image.type == 'image/jpeg' || cover_photo_form.image.type == 'image/jpg' || cover_photo_form.image.type == 'image/png'" :src="cover_photo_form.image.preview" class="inline-block mr-1" alt="">

        </div>
        <div :style="`width: ${cover_photo_form.progress ? cover_photo_form.progress.percentage : 0}%`" class="h-1 bg-gradient-to-r from-primary-100 via-purple-400 to-primary-200 my-2"></div>
        <button class="form-button" :class="cover_photo_form.processing ? 'opacity-60 cursor-not-allowed' : ''">Upload</button>
      </form>
    </CardBoxModal>

    <CardBoxModal v-model="showUpdateProfilePhotoModal" button="danger" buttonLabel="Close"
      :title="`Update profile photo`">

      <form @submit.prevent="submitProfilePictureForm" class="mt-5">
        <h6 class="text-sm italic font-semibold my-2 text-primary-100">Select an image to upload. Max size: 3MB</h6>
        <div @click="selectProfilePictureFiles" class="w-full h-[200px] relative border rounded border-gray-300  cursor-pointer">
          <div class="absolute top-0 bottom-0 right-0 left-0 m-auto h-[80px] w-[80px]  text-gray-400">
            <font-awesome-icon class="text-3xl" icon="fa-solid fa-file-circle-plus" />
            <h5 class="text-lg font-semibold" v-text="profile_picture_form.image ? 'Change image' : 'Select an image'"></h5>
          </div>
        </div>
        <input type="file" class="hidden"
              ref="profile_photo_medias"
              accept=".jpg, .png, .jpeg"
              @change="updateAddProfilePictureFiles">


        <div v-if="profile_picture_form.errors.image" class="my-2">
          <h5 class="text-xl">The following error occured</h5>
          <p class="text-red-500 italic my-3">{{ profile_picture_form.errors.image }}</p>
        </div>

        <div v-if="profile_picture_form.image" class="text-xs py-2 text-secondary-400 dark:text-slate-600 max-h-[140px] overflow-x-hidden">
          <h4 class="text-2xl font-bold text-center">Preview</h4>

          <img v-if="profile_picture_form.image.type == 'image/jpeg' || profile_picture_form.image.type == 'image/jpg' || profile_picture_form.image.type == 'image/png'" :src="profile_picture_form.image.preview" class="inline-block mr-1" alt="">

        </div>
        <div :style="`width: ${profile_picture_form.progress ? profile_picture_form.progress.percentage : 0}%`" class="h-1 bg-gradient-to-r from-primary-100 via-purple-400 to-primary-200 my-2"></div>
        <button class="form-button" :class="profile_picture_form.processing ? 'opacity-60 cursor-not-allowed' : ''">Upload</button>
      </form>
    </CardBoxModal>

    <PostPopup v-model:open-post-index="open_post_index" v-model:open-media-index="open_media_index"  v-model:current-media-index="current_media_index" :post="open_post_index !== false && open_media_index !== false ? posts[open_post_index] : {}"  :make_comment_form="make_comment_form"/>
  </LayoutSocial>
</template>

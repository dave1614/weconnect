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
  community_details: {
    type: Object,
  },
  community: {
    type: Object,
  },
  position: {
    type: String,
    default: 'visitor'
  },
  roles: {
    type: Array,

  },
  gallery: {
    type: Array,
    default: []
  },
  last_gallery_image: {
    type: Boolean,
    default: true,
  }



});

console.log(props.community)

const lightbox = ref(null)
const galleryID = ref('my-test-gallery')
const index = ref(null)

const posts = ref(props.posts);
const auth_user = ref(props.auth_user);
const user = ref(props.auth_user);
const community_details = ref(props.community_details);
const default_section = ref('posts');
const gallery = ref(props.gallery);
console.log(posts.value)


const loading_gallery_images = ref(false);
const last_gallery_image = ref(props.last_gallery_image);
console.log(last_gallery_image.value)



const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()





let files = []
// const state = reactive({files});
const post_medias = ref(null);
const logo_medias = ref(null);
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
const showUpdateLogoModal = ref(false)

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


})

onUnmounted(() => {

})




const make_comment_form = useForm({
  comment: "",
})


const cover_photo_form = useForm({
  image: null
})

const logo_form = useForm({
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

    let queryRoute = route('community.load_more_posts', props.community.id);

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
  cover_photo_form.post(route('community.update_cover_photo'), {
    preserveScroll: true,
    onSuccess: (page) => {

      var response = page.props.flash.data;
      if (response.success) {
        // auth_user.value = response.user
        // user.value = response.user
        community_details.value = response.community_details

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

const viewCommunityMoreOptions = () => {

}

const changeLogo = () => {

  if(props.position == 'visitor' || props.position == 'subject'){
    return;
  }
  showUpdateLogoModal.value = true
}

const selectLogoFiles = () => {
  logo_medias.value.click();
}

const updateAddLogoFiles = (event) => {
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
      logo_form.image = file
    }, 500);


}

const submitLogoForm = () => {


if (!logo_form.processing) {
  logo_form.post(route('community.update_logo'), {
    preserveScroll: true,
    onSuccess: (page) => {

      var response = page.props.flash.data;
      if (response.success) {
        // auth_user.value = response.user
        // user.value = response.user
        community_details.value = response.community_details

        mainStore.toast = 'Logo changed successfully'
        showUpdateLogoModal.value = false;
        logo_form.image = null;

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

const switchSection = (section) => {
  if(default_section.value != section){
    default_section.value = section
  }
}

const loadGalleryImages = async () =>  {


  try {
    if(loading_gallery_images.value){
      return
    }


    loading_gallery_images.value = true;
    var last_id = gallery.value.length > 0 ? gallery.value[gallery.value.length - 1].id : 0

    let queryRoute = route('community.gallery', props.community.id);

    const response = await axios.post(queryRoute, { last_id: last_id });
    console.log(response)
    loading_gallery_images.value = false;

    if (response.data.success && response.data.gallery.length > 0) {

      gallery.value = gallery.value.concat(response.data.gallery);
      last_gallery_image.value = response.data.last_image;

      console.log(gallery.value)
    } else {
      toast.value = 'Something went wrong'
    }
  } catch (error) {

    loading_gallery_images.value = false;
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

    toast.value = 'Something went wrong'
    console.log('Something went wrong' + error)


    // Swal.fire({
    //   title: 'Ooops!',
    //   html: 'Something went wrong',
    //   icon: 'error',


    // });
  }
}



const deleteGalleryImage = (image, index) => {
  Swal.fire({
    title: `You are about to delete this image from this community's gallery. Do you wish to proceed?`,
    html: '',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes Proceed!',
  }).then((result) => {

    if (result.isConfirmed) {
      proceedDeleteGalleryImage(image, index)

    } else if (result.isDenied) {
      // Swal.fire('Changes are not saved', '', 'info')
    }
  })
}

const proceedDeleteGalleryImage = async (image, index) => {

try {

  Swal.fire({
    title: 'Please wait',
    html: `Deleting image.....`,
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });


  let queryRoute = route('community.delete_gallery_image', {community: props.community.id, image: image.id});

  const response = await axios.post(queryRoute, null, { params: {'delete_image': true} });

  console.log(response)
  Swal.close()

  if (response.data.success) {


    mainStore.toast = `Gallery image at position ${index + 1} has been deleted successfully`;

    gallery.value.splice(index, 1);
    // setTimeout(() => {
    //   document.location.reload()
    // }, 2000);
  }else{
    Swal.fire({
      title: 'Ooops!',
      html: 'Something went wrong',
      icon: 'error',


    });
  }




} catch (error) {

  Swal.close()
  console.log(error);

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

  Swal.fire({
    title: 'Ooops!',
    html: 'Something went wrong',
    icon: 'error',


  });
}

};
</script>

<template>
  <LayoutSocial :highlight_type="'community'">

    <!-- <div class="fixed top-0 bottom-0 left-0 right-0 w-screen h-screen ">
      <div class="relative w-full h-full">

      </div>
    </div> -->

    <Head :title="`${community.name} community page `" />
    <div class="w-full">
      <div class="w-full min-h-screen mt-[30px]">
        <div class="grid grid-cols-12 gap-6">
          <div class="hidden sm:inline-block sm:col-span-3">

          </div>



          <div class="col-span-12 sm:col-span-9 border-0  min-h-screen">
            <div class="-px-2 py-4">
              <div class="">
                <div class="w-full h-[300px] relative" :style="`background:linear-gradient(rgba(0, 0, 0,0.3),rgba(0, 0, 0,0.3)), url('${community_details.cover_photo}'); -webkit-background-size:cover; -moz-background-size:cover; background-size: cover; -o-background-size:cover; background-repeat: no-repeat; background-position: center;`">

                  <div @click="changeLogo" v-if="position != 'visitor' && position != 'subject'" :class="position != 'visitor' && position != 'subject' ? 'cursor-pointer' : ''" class="absolute w-[150px] h-[150px]  left-0 right-0 sm:mx-0 bottom-0 rounded-full sm:rounded-lg sm:ml-9 mx-auto bg-white p-[2px] -mb-[50px] z-[2]">
                    <img :src="community_details.logo == null ? '/default/community_logo.jpg' : community_details.logo" class="w-full h-full rounded-full sm:rounded-lg" alt="">

                  </div>

                  <div @click="changeCoverPhoto" v-if="position != 'visitor' && position != 'subject'" class="absolute top-0 right-0 mt-7 mr-6 bg-black opacity-70 rounded-full p-2 px-3 cursor-pointer" title="Change cover photo">
                    <font-awesome-icon class="text-white font-bold text-xl " icon="fa-regular fa-pen-to-square" />
                  </div>
                </div>


                <div class=" bg-white dark:bg-slate-800 rounded-xl mx-4 -mt-9 z-[1] relative my-2 dark:text-slate-300">
                  <div class="sm:ml-[200px]">
                    <div class="h-[100px] sm:h-[10px]"></div>

                    <!-- <div v-if="auth_user.id != user.id" class="mr-7 text-sm float-right sm:block hidden">
                      <button @click="mainStore.toggleFollowUser(user)" :class="!user.following_loading ? 'bg-gradient-to-r from-primary-100 to-primary-200' : 'bg-white border-[1px] border-secondary-200'" class=" rounded-full text-center font-semibold py-3 px-9 text-white ">
                        <img v-if="user.following_loading" class="w-[35px] mx-auto" :src="Loader" alt="">

                        <span v-else v-text="user.following_status ? 'Following' : 'Follow'"></span>
                      </button>
                    </div>

                    <div v-else class="mr-7 text-sm float-right sm:block hidden mt-3">
                      <Link :href="route('edit_profile')" class="bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-full text-center font-semibold py-3 px-9 text-white ">

                        <span>Edit Profile</span>
                      </Link>
                    </div> -->

                    <font-awesome-icon @click="mainStore.showCommunityMoreOptions(community, auth_user, community_details, position, roles)" class="cursor-pointer mr-7 text-3xl float-right sm:block hidden" icon="fa-solid fa-ellipsis" />


                    <!-- <h4 class="text-lg  font-semibold sm:text-left text-center text-gray-400 ">{{ community.name }}</h4> -->
                    <h4 class="text-2xl sm:text-xl font-bold sm:text-left text-center sm:mt-1 mt-1">{{ community.name }}</h4>

                    <!-- <p class="text-xs leading-tight text-center sm:text-left my-2">{{ user.bio }}</p> -->
                    <p class="text-sm text-gray-400 text-center sm:text-left my-2"><font-awesome-icon class="text-red-400" icon="fa-solid fa-location-dot" /> {{ community.lga.name}}, {{ community.state.name}}, Nigeria</p>
                    <!-- <div v-if="auth_user.id != user.id" class="text-lg my-3 text-center block sm:hidden">
                      <button @click="mainStore.toggleFollowUser(user)" :class="!user.following_loading ? 'bg-gradient-to-r from-primary-100 to-primary-200' : 'bg-white border-[1px] border-secondary-200'" class=" rounded-full text-center font-semibold py-2 px-9 text-white ">
                        <img v-if="user.following_loading" class="w-6 mx-auto" :src="Loader" alt="">

                        <span v-else v-text="user.following_status ? 'Following' : 'Follow'"></span>
                      </button>
                    </div>
                    <div v-else class="text-sm text-center block sm:hidden my-3 mt-6">
                      <Link :href="route('edit_profile')" class="bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-full text-center font-semibold py-3 px-9 text-white ">

                        <span>Edit Profile</span>
                      </Link>
                    </div> -->

                    <div class="mx-auto left-0 right-0 absolute inline-block sm:hidden bg-gray-100 dark:bg-slate-600 p-2 rounded-full w-fit ">
                      <font-awesome-icon @click="viewCommunityMoreOptions" v-if="position == 'subject'"  class="text-3xl text-center " icon="fa-solid fa-ellipsis" />
                    </div>



                  </div>

                  <div class="flex justify-center items-center my-[60px] mb-3 bg-gray-100 dark:bg-slate-600 mx-2 rounded-xl px-3 py-2">
                    <div class="text-center">
                      <div @click="switchSection('posts')" :class="default_section == 'posts' ? 'community-tabs-selected' : ''" class="community-tabs">
                        <h4 class="text-3xl font-bold">{{ mainStore.convertNumberToKOrMorB(community.total_posts_num) }}</h4>
                        <h6 class="text-sm font-bold">Posts</h6>
                      </div>

                      <div @click="mainStore.loadAllCommunityLeaders(community.id)" class="community-tabs">
                        <h4 class="text-3xl font-bold">{{ mainStore.convertNumberToKOrMorB(community.leaders_num) }}</h4>
                        <h6 class="text-sm font-bold">Leaders</h6>
                      </div>

                      <div @click="mainStore.loadAllCommunityResidents(community.id)" class="community-tabs">
                        <h4 class="text-3xl font-bold">{{ mainStore.convertNumberToKOrMorB(community.residents_num) }}</h4>
                        <h6 class="text-sm font-bold">Residents</h6>
                      </div>

                      <div @click="switchSection('history')" :class="default_section == 'history' ? 'community-tabs-selected' : ''" class="community-tabs">
                        <font-awesome-icon class="text-2xl" icon="fa-solid fa-clock-rotate-left" />
                        <h6 class="text-sm font-bold">History</h6>
                      </div>

                      <div @click="switchSection('gallery')" :class="default_section == 'gallery' ? 'community-tabs-selected' : ''" class="community-tabs">
                        <font-awesome-icon class="text-2xl" icon="fa-solid fa-images" />
                        <h6 class="text-sm font-bold">Gallery</h6>
                      </div>
                    </div>
                  </div>

                  <div class="bg-gray-100 dark:bg-slate-600 mx-2 px-3 py-2 rounded-xl posts mt-6 text-secondary-200 dark:text-slate-300 ">

                    <div v-if="default_section == 'posts'" class="">

                      <div class="sm:w-6/12 flex justify-center mx-auto my-4" v-if="position != 'visitor'">
                        <CreatePost :placeholder="`What's on your mind ${auth_user.name}?`" :for_community="true" />
                      </div>
                      <div v-if="posts.length > 0" class="">

                        <div class="sm:grid sm:grid-cols-12 sm:gap-6">
                          <Post class="sm:col-span-6" v-for="(post, index) in posts" :key="index" :post="post" :index="index" :make_comment_open="make_comment_open" @open-bigger-post="openBiggerPost" @make-comment-action="makeCommentAction" @toggle-post-like="togglePostLike" @toggle-comment-like="toggleCommentLike" :for_community="true"/>

                        </div>
                        <div v-if="posts_loading" class="flex justify-center">
                          <img class="w-[50px]" :src="Loader" alt="">
                        </div>
                      </div>

                      <div v-else class="">
                        <h4 class="text-2xl font-semibold text-orange-400">Nothing to show here</h4>
                      </div>
                    </div>

                    <div v-if="default_section == 'history'" class="my-3">
                      <h4 class="text-center font-bold text-2xl">Community History</h4>

                      <div class="mt-[30px] mx-3">
                        <p class="text-sm leading-normal whitespace-pre-line" v-html="community_details.history"></p>
                      </div>
                    </div>

                    <div v-if="default_section == 'gallery'" class="my-3">
                      <h4 class="text-center font-bold text-2xl">Community Gallery</h4>

                      <div class="mt-[30px] mx-3">

                        <div v-if="gallery.length > 0">
                          <div  class="sm:grid sm:grid-cols-12 sm:gap-6">
                            <div class="sm:col-span-6 sm:my-3 my-[50px]" v-for="(image, index) in gallery" :key="index">

                              <div v-if="props.position != 'visitor' && props.position != 'subject'" class="">
                                <button @click="deleteGalleryImage(image, index)"  class="bg-red-500 rounded text-white my-2 mx-1 p-1">
                                  <font-awesome-icon icon="fa-solid fa-trash-can" />
                                </button>

                                <p class="font-semibold mb-3 text-xs text-secondary-200">Uploaded by <Link :href="route('profile.show', image.leader.slug)">{{ image.leader.id == auth_user.id  ? 'you' : image.leader.name}}</Link></p>

                                <a :href="image.path" target="_blank" class="w-full" >
                                  <img :src="image.path" alt="" class="w-full h-[300px] rounded-xl hover:scale-105 cursor-pointer transition-all duration-300 ease-in-out" >
                                </a>
                              </div>
                            </div>
                          </div>

                          <div class="flex justify-center">
                            <font-awesome-icon v-if="!loading_gallery_images && !last_gallery_image" @click="loadGalleryImages()" class="text-5xl my-3 mt-6 cursor-pointer text-black dark:text-slate-300" icon="fa-solid fa-circle-plus" />

                            <img v-if="loading_gallery_images" class="w-[50px]" :src="Loader" alt="">
                          </div>
                        </div>

                        <h4 v-else class="text-orange-500 text-xl">No gallery uploaded for this community.</h4>

                      </div>


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

    <CardBoxModal v-model="showUpdateLogoModal" button="danger" buttonLabel="Close"
      :title="`Update logo`">

      <form @submit.prevent="submitLogoForm" class="mt-5">
        <h6 class="text-sm italic font-semibold my-2 text-primary-100">Select an image to upload. Max size: 3MB</h6>
        <div @click="selectLogoFiles" class="w-full h-[200px] relative border rounded border-gray-300  cursor-pointer">
          <div class="absolute top-0 bottom-0 right-0 left-0 m-auto h-[80px] w-[80px]  text-gray-400">
            <font-awesome-icon class="text-3xl" icon="fa-solid fa-file-circle-plus" />
            <h5 class="text-lg font-semibold" v-text="logo_form.image ? 'Change image' : 'Select an image'"></h5>
          </div>
        </div>
        <input type="file" class="hidden"
              ref="logo_medias"
              accept=".jpg, .png, .jpeg"
              @change="updateAddLogoFiles">


        <div v-if="logo_form.errors.image" class="my-2">
          <h5 class="text-xl">The following error occured</h5>
          <p class="text-red-500 italic my-3">{{ logo_form.errors.image }}</p>
        </div>

        <div v-if="logo_form.image" class="text-xs py-2 text-secondary-400 dark:text-slate-600 max-h-[140px] overflow-x-hidden">
          <h4 class="text-2xl font-bold text-center">Preview</h4>

          <img v-if="logo_form.image.type == 'image/jpeg' || logo_form.image.type == 'image/jpg' || logo_form.image.type == 'image/png'" :src="logo_form.image.preview" class="inline-block mr-1" alt="">

        </div>
        <div :style="`width: ${logo_form.progress ? logo_form.progress.percentage : 0}%`" class="h-1 bg-gradient-to-r from-primary-100 via-purple-400 to-primary-200 my-2"></div>
        <button class="form-button" :class="logo_form.processing ? 'opacity-60 cursor-not-allowed' : ''">Upload</button>
      </form>
    </CardBoxModal>

    <PostPopup v-model:open-post-index="open_post_index" v-model:open-media-index="open_media_index"  v-model:current-media-index="current_media_index" :post="open_post_index !== false && open_media_index !== false ? posts[open_post_index] : {}"  :make_comment_form="make_comment_form" :for_community="true"/>
  </LayoutSocial>
</template>

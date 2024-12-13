<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, reactive, onMounted, onUnmounted  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'
import LayoutSocial from '@/Layouts/LayoutSocial.vue'

import FormLoaderDark from '@/Loaders/form_loader_dark.gif'
import FormLoaderLight from '@/Loaders/form_loader_light.gif'
import FlashMessages from '@/Components/FlashMessages.vue'
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





let files = []
// const state = reactive({files});
const post_medias = ref(null);
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


const updateAddMediaFiles = (event) => {
  let files = event.target.files;
  if (! files) return;

  for(let i = 0; i < files.length; i++){

    let file = files[i];
    if (! file) break;
    // file.open = false;


    if(file.type == 'image/jpeg' || file.type == 'image/jpg' || file.type == 'image/png' || file.type == 'image/gif'){
      const reader = new FileReader();

      reader.onload = (e) => {

          file.preview = e.target.result;
      };

      reader.readAsDataURL(file);
    }

    setTimeout(() => {
      make_post_form.media.files.push(file)

      make_post_form.media_details.push({
        open: false,
        name: file.name,
        description: '',
      });

      console.log(make_post_form.media.files)
      console.log(make_post_form.media_details)
    }, 500);
  }

}

const selectMediaFiles = () => {
  post_medias.value.click();
}

const make_post_form = useForm({
  input: null,
  media: {files},
  media_details: [],
})

const make_comment_form = useForm({
  comment: "",
})





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


const createPostFocused = () => {
  create_post_input_fcsd.value = true;
}

const checkPostLength = () => {
  // max_post_length

  rem_chars.value = max_post_length.value - make_post_form.input.length;
  console.log(rem_chars.value)
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

const removeMediaFromQueue = (index) => {
  make_post_form.media.files.splice(index, 1);
  make_post_form.media_details.splice(index, 1);

  console.log(make_post_form.media.files)
  console.log(make_post_form.media_details)
}

const toggleEnterMoreDetailsPostMedia = (index) => {
  // console.log(make_post_form.media.files[index].open)

  make_post_form.media_details[index].open = !make_post_form.media_details[index].open

}
</script>

<template>
  <LayoutSocial>

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
              <div class="relative">
                <div class="absolute bottom-0 bg-gray-50 w-[96%] h-[50px] mb-[-12px] rounded-[200px] z-[1] mx-auto left-0 right-0 shadow-xl opacity-50 dark:bg-slate-800"></div>

                <div class="bg-white dark:bg-slate-800 shadow-xl sm:px-7 px-2 py-5 rounded-md relative z-[2]">

                  <div>
                    <form>
                      <div v-show="!create_post_input_fcsd" class="grid grid-cols-12 gap-6" >
                        <img :src="user.profile_picture" alt="" class="rounded-full col-span-2">

                        <input @focus="createPostFocused" class="col-span-10 dark:text-white dark:bg-slate-700 rounded-full border-secondary-300 text-sm focus:outline-0 focus:outline-none focus:ring-0 focus:border-secondary-300" placeholder="What's new?">
                      </div>

                      <div  v-show="create_post_input_fcsd" >

                        <div class="grid grid-cols-12 gap-3 border-b border-secondary-300">
                          <div class="col-span-2 relative">
                            <img :src="user.profile_picture" alt="" class="rounded-full w-full">

                            <span :class="rem_chars <= 0 ? 'text-red-500' : ''" class="absolute bottom-0 text-sm mb-1 text-secondary-200 font-semibold">{{ rem_chars }}</span>
                          </div>


                          <textarea @keyup="checkPostLength" v-model="make_post_form.input"  class="col-span-10 dark:text-white bg-transparent  border-0 text-sm focus:outline-0 focus:outline-none focus:ring-0 focus:border-0 " placeholder="What's new?" cols="50" rows="4"> </textarea>

                        </div>

                        <div class="border-b border-secondary-300 pt-2 pb-1">

                          <input type="file" class="hidden"
                          ref="post_medias"
                          accept=".jpg, .png, .jpeg, .gif, .mp4"
                          multiple
                          @change="updateAddMediaFiles">

                          <div @click="selectMediaFiles" class="cursor-pointer">
                            <font-awesome-icon class="text-xs text-primary-100 p-2 bg-secondary-500 dark:bg-slate-900 rounded-full" icon="fa-solid fa-paperclip" />

                            <span class="text-primary-100 text-sm inline-block mb-[-5px] ml-2">Attach media</span>
                          </div>

                          <div v-if="make_post_form.media.files.length" class="text-xs py-2 text-secondary-400 dark:text-slate-600">
                            <div v-for="(file, index) in make_post_form.media.files" class="rounded-xl my-1 px-3 py-2 bg-gray-100 dark:bg-slate-300" :key="index">
                              <div class="grid grid-cols-12 gap-1">
                                <div class="col-span-1">
                                  <img v-if="file.type == 'image/jpeg' || file.type == 'image/jpg' || file.type == 'image/png' || file.type == 'image/gif'" :src="file.preview" class="w-5 h-5 inline-block mr-1" alt="">

                                  <img v-else-if="file.type == 'video/mp4'" src="/images/video_thumb.png" class="w-5 inline-block mr-1" alt="">
                                </div>

                                <div class="col-span-7">
                                  <span v-if="!make_post_form.media_details[index].open">{{ mainStore.truncateStr(make_post_form.media_details[index].name, 25) }}</span>
                                  <form v-else class="">
                                    <div class="">
                                      <span>Title: </span>

                                      <input type="text" v-model="make_post_form.media_details[index].name" class="w-full border border-secondary-300 rounded-full py-3 px-3 focus:outline-0 focus:outline-none focus:ring-0 bg-white  text-xs my-2" placeholder="">
                                    </div>

                                    <div class="my-2">
                                      <span>Description: </span>

                                      <textarea type="text" v-model="make_post_form.media_details[index].description" class="w-full border border-secondary-300 rounded-full py-3 px-3 focus:outline-0 focus:outline-none focus:ring-0 bg-white  text-xs my-2" placeholder=""></textarea>
                                    </div>
                                  </form>
                                </div>

                                <div class="col-span-4 float-right">
                                  <span class="text-gray-400">{{ mainStore.convertbytesToMbOrKb(file.size) }}</span>
                                  <span class="text-gray-400 inline-block mx-2">|</span>

                                  <font-awesome-icon @click="toggleEnterMoreDetailsPostMedia(index)" v-if="!make_post_form.media_details[index].open" class="mr-1 cursor-pointer" icon="fa-solid fa-pen" />
                                  <font-awesome-icon @click="toggleEnterMoreDetailsPostMedia(index)" v-else class="mr-1 cursor-pointer" icon="fa-regular fa-circle-check" />

                                  <font-awesome-icon @click="removeMediaFromQueue(index)" class="ml-1 cursor-pointer" icon="fa-regular fa-circle-xmark" />
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="text-right pt-3">
                          <span @click="create_post_input_fcsd = false" class="text-primary-100 text-sm inline-block cursor-pointer hover:underline">Cancel</span>

                          <button class="text-center px-4 py-1 bg-gradient-to-r from-primary-100 to-primary-200 rounded-full ml-3 text-white text-sm">Post Update</button>
                        </div>

                      </div>



                    </form>
                  </div>
                </div>
              </div>

              <div class="posts mt-[70px] text-secondary-200 dark:text-slate-300">
                <Post v-for="(post, index) in posts" :key="index" :post="post" :index="index" :make_comment_open="make_comment_open" @open-bigger-post="openBiggerPost" @make-comment-action="makeCommentAction" @toggle-comment-like="toggleCommentLike" />
              </div>
            </div>
          </div>

          <div class="hidden sm:inline-block sm:col-span-3">

          </div>
        </div>

      </div>
    </div>

    <PostPopup v-model:open-post-index="open_post_index" v-model:open-media-index="open_media_index"  v-model:current-media-index="current_media_index" :post="open_post_index !== false && open_media_index !== false ? posts[open_post_index] : {}"  :make_comment_form="make_comment_form"/>
  </LayoutSocial>
</template>

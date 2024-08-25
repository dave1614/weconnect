<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, reactive, onMounted, onUnmounted  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'
import LayoutSocial from '@/Layouts/LayoutSocial.vue'
import FormLoaderDark from '@/Loaders/form_loader_dark.gif'
import FormLoaderLight from '@/Loaders/form_loader_light.gif'
import FlashMessages from '@/Components/FlashMessages.vue'
import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'

const props = defineProps({
  posts: {
    type: Array,
    default: []
  }
});

console.log(props.posts)

const posts = ref(props.posts);


const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()


const show_select_emoji = ref(false);


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

const toggleCommentLike = (id) => {
  let index = id - 1;
  console.log(posts.value.comments[index].liked);
  posts.value.comments[index].liked = !posts.value.comments[index].liked
}


const openBiggerPost = (post_index, media_index) => {
  open_post_index.value = post_index;
  open_media_index.value = media_index;
  current_media_index.value = media_index;

  console.log(open_post_index.value)
  console.log(open_media_index.value)
}

const closeBigPostModal = () => {
  open_post_index.value = false;
  open_media_index.value = false;
}

const onSelectEmoji = (emoji) => {
  console.log(emoji)

  make_comment_form.comment = make_comment_form.comment + emoji.i;
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
                        <img :src="Avatar" alt="" class="rounded-full col-span-2">

                        <input @focus="createPostFocused" class="col-span-10 dark:text-white dark:bg-slate-700 rounded-full border-secondary-300 text-sm focus:outline-0 focus:outline-none focus:ring-0 focus:border-secondary-300" placeholder="What's new?">
                      </div>

                      <div  v-show="create_post_input_fcsd" >

                        <div class="grid grid-cols-12 gap-3 border-b border-secondary-300">
                          <div class="col-span-2 relative">
                            <img :src="Avatar" alt="" class="rounded-full w-full">

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
                <div v-for="(post, index) in posts" class="bg-white dark:bg-slate-800 rounded-lg shadow-lg" :key="index">
                  <div class="px-4 py-2 pt-5 border-b border-secondary-300">
                    <div class="inline-block">
                      <img class="w-8 rounded-full inline-block" :src="Avatar" alt="">
                      <span class="text-sm font-semibold inline-block ml-3">{{ post.user_name }}</span>
                      <span class="text-secondary-600 text-xs font-bold inline-block ml-1">• {{post.relative_time}}</span>

                    </div>

                    <div class="float-right inline-block">
                      <font-awesome-icon class="cursor-pointer" icon="fa-solid fa-ellipsis" />
                    </div>
                  </div>
                  <div class=" px-3 py-1 ">

                    <p class="transition-all ease-linear duration-300 text-sm leading-[26px]">
                      <span v-if="post.caption == post.caption_short" class="inline-block" v-html="post.caption"></span>

                      <span v-else-if="(post.caption != post.caption_short) && post.show_more" class="inline-block" ><span v-html="post.caption"></span> <span @click="post.show_more = !post.show_more" class="text-primary-100 inline-block ml-1 cursor-pointer hover:underline">less</span></span>

                      <span v-else-if="(post.comment != post.caption_short) && !post.show_more" class="inline-block" ><span v-html="post.caption_short"></span> <span @click="post.show_more = !post.show_more" class="text-primary-100 inline-block ml-1 cursor-pointer hover:underline">read more</span> </span>
                  </p>

                  </div>

                  <div class="px-3 py-3">
                    <div class="grid grid-cols-12 gap-2">
                      <template v-for="(media, media_index) in post.media" :key="media_index">

                        <template v-if="media_index == 0">
                          <div @click="openBiggerPost(index, 0)" v-if="media.type == 'image'" class="col-span-12 max-h-[300px] overflow-hidden rounded-xl cursor-pointer shadow-md">
                            <img class="hover:transform hover:scale-110 transition-all ease-in-out duration-300 w-full h-full" :src="media.path" alt="">
                          </div>

                          <div @click="openBiggerPost(index, 0)" v-else class="col-span-12 max-h-[300px] overflow-hidden rounded-xl cursor-pointer shadow-xl relative">
                            <div class="absolute bg-black w-full h-full opacity-50">
                              <div class="relative h-full w-full">
                                <font-awesome-icon class="absolute text-7xl top-0 bottom-0 right-0 left-0 m-auto text-white" icon="fa-solid fa-play" />
                              </div>
                            </div>
                            <video class="hover:transform hover:scale-110 transition-all ease-in-out duration-300 w-full h-full" :src="media.path" alt=""></video>
                          </div>
                        </template>


                        <template v-if="media_index == 1 || media_index == 2">

                          <div @click="openBiggerPost(index, media_index)" v-if="media.type == 'image'" class="col-span-5 max-h-[300px] overflow-hidden rounded-xl cursor-pointer shadow-xl">
                            <img class="hover:transform hover:scale-110 transition-all ease-in-out duration-300 w-full h-full" :src="media.small_path" alt="">
                          </div>

                          <div @click="openBiggerPost(index, media_index)" v-else class="col-span-5 max-h-[300px] overflow-hidden rounded-xl cursor-pointer shadow-xl relative">
                            <div class="absolute bg-black w-full h-full opacity-50">
                              <div class="relative h-full w-full">
                                <font-awesome-icon class="absolute text-5xl top-0 bottom-0 right-0 left-0 m-auto text-white" icon="fa-solid fa-play" />
                              </div>
                            </div>
                            <video class="hover:transform hover:scale-110 transition-all ease-in-out duration-300 w-full h-full" :src="media.path" alt=""></video>
                          </div>
                        </template>

                        <div @click="openBiggerPost(index, 4)" v-if="post.media.length > 3 && media_index == post.media.length - 1" class="col-span-2 max-h-[300px] overflow-hidden rounded-xl cursor-pointer shadow-xl">
                          <div class="w-full h-full bg-secondary-400 relative">
                            <h5 class="text-lg text-white absolute top-0 bottom-0 left-0 right-0 m-auto ">+{{ post.media.length - 3 }} more</h5>
                          </div>

                        </div>
                      </template>



                    </div>
                  </div>

                  <div class="px-3 py-4 border-b border-secondary-300 dark:border-slate-500 ">
                    <Link href="" class="text-sm">{{ post.likes }} likes</Link>
                  </div>

                  <div class="px-3 py-4 border-b border-secondary-300 dark:border-slate-500 ">
                    <div class="text-sm">
                      <div class="inline-block mr-8">
                        <span @click="post.liked = !post.liked" class="cursor-pointer">
                          <font-awesome-icon v-if="!post.liked" class=" " icon="fa-regular fa-heart" />
                          <font-awesome-icon v-else class="text-primary-100 " icon="fa-solid fa-heart" />

                          <span :class="post.liked ? 'text-primary-100' : ''" v-text="post.liked ? 'Liked' : 'Like'" class="inline-block ml-1">

                          </span>
                        </span>
                      </div>

                      <div @click="makeCommentAction(index)" :class="make_comment_open ? 'text-primary-100' : ''" class="inline-block mr-8 cursor-pointer hover:text-primary-100">
                        <font-awesome-icon icon="fa-solid fa-comments" />
                        <span class="inline-block mx-1">Comment</span>
                        <span class="text-xs border-[1px] p-[1px] px-1 border-secondary-300 dark:border-slate-500 rounded-md">{{ posts.comments.length }}</span>
                      </div>

                      <div class="inline-block  cursor-pointer hover:text-primary-100">
                        <font-awesome-icon icon="fa-solid fa-share" />
                        <span class="inline-block mx-1">Share</span>

                      </div>
                    </div>
                  </div>

                  <div class="px-3 py-4 ">
                    <div class="">
                      <span @click="openBiggerPost(index, 0)" class="text-primary-100 hover:underline text-sm cursor-pointer inline-block my-2"><font-awesome-icon icon="fa-regular fa-eye" /> Show all {{ posts.comments.length }} comments</span>

                      <div v-if="make_comment_open" class="my-4">
                        <form class="grid grid-cols-12 gap-1">
                          <div class="col-span-1">
                            <img class="rounded-full w-full" :src="Avatar" alt="">
                          </div>

                          <div class="col-span-11">
                            <textarea class="w-full rounded-full h-[40px] dark:text-white bg-transparent  border border-secondary-300 dark:border-slate-500 text-sm focus:outline-0 focus:outline-none focus:ring-0 focus:border-primary-100 overflow-hidden" placeholder=""></textarea>

                            <div class="my-1">
                              <button class="text-white bg-gradient-to-r from-primary-100 to-primary-200 rounded-full text-center text-sm py-1 px-8 shadow hover:from-primary-200 hover:to-primary-100">Post</button>

                              <span @click="make_comment_open = false" class="inline-block mx-2 cursor-pointer text-primary-100 text-xs hover:underline">Cancel</span>
                            </div>
                          </div>
                        </form>
                      </div>

                      <div class="">
                        <div class="my-1" v-for="(comment, index) in posts.comments.slice(Math.max(posts.comments.length - 2, 0))" :key="index">

                          <div class="grid grid-cols-12 gap-2">
                            <p class="text-sm col-span-11">
                              <span class="text-secondary-400 font-bold inline-block mr-2">{{ comment.user_name }}</span>
                              <span v-if="comment.comment == comment.comment_shrt" class="inline-block">{{ comment.comment }}</span>

                              <span v-else-if="(comment.comment != comment.comment_shrt) && comment.show_more" class="inline-block">{{ comment.comment }}</span>

                              <span v-else-if="(comment.comment != comment.comment_shrt) && !comment.show_more" class="inline-block">{{ comment.comment_shrt }} <span @click="comment.show_more = true" class="cursor-pointer  font-semibold inline-block ml-1">show more</span> </span>

                            </p>

                            <span class="float-right col-span-1">
                              <font-awesome-icon @click="toggleCommentLike(comment.id)" v-if="!comment.liked" class="text-xs cursor-pointer" icon="fa-regular fa-heart" />
                              <font-awesome-icon @click="toggleCommentLike(comment.id)" v-else class="text-primary-100 text-xs cursor-pointer" icon="fa-solid fa-heart" />
                            </span>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="hidden sm:inline-block sm:col-span-3">

          </div>
        </div>

      </div>
    </div>

    <div v-if="open_post_index !== false && open_media_index !== false"  class="fixed top-0 bottom-0 left-0 right-0 z-[900] ">
      <div @click.stop="closeBigPostModal" class="h-screen w-screen bg-gradient-to-br from-slate-600/60 via-slate-700/60 to-slate-800/60 dark:bg-slate-900/80">

      </div>

      <div class="absolute top-0 right-0 m-2 mx-9">
        <font-awesome-icon @click.stop="closeBigPostModal" class="cursor-pointer text-3xl dark:text-gray-300 text-gray-100" icon="fa-solid fa-xmark" />
      </div>

      <div class="absolute m-auto min-h-fit sm:max-h-[90%] md:max-h-[55%] lg:max-h-[90%]  top-0 bottom-0 left-0 right-0 bg-white dark:bg-slate-700 w-10/12  z-[1000] rounded flex">

        <div class="relative h-full">


          <div class="w-full sm:h-full h-screen sm:grid sm:grid-cols-12 sm:gap-0 relative">
            <div v-if="posts[open_post_index].media.length > 0" class="sm:col-span-6 sm:h-full h-[35%] col-span-12 relative">

              <font-awesome-icon @click="current_media_index -= 1" v-if="current_media_index > 0 || (posts[open_post_index].media.length == 1)" class="absolute top-0 bottom-0 my-auto left-0 text-white mx-2 bg-gray-300 p-2 rounded-full cursor-pointer" icon="fa-solid fa-angle-left" />


              <font-awesome-icon @click="current_media_index += 1" v-if="(current_media_index < posts[open_post_index].media.length - 1)" class="absolute top-0 bottom-0 my-auto right-0 text-white mx-2 bg-gray-300 p-2 rounded-full cursor-pointer" icon="fa-solid fa-angle-right" />

              <div class="absolute bottom-0 right-0 left-0 m-auto  my-4 flex justify-center">
                <template v-for="(media, index) in posts[open_post_index].media" :key="index">
                  <div :class="current_media_index == index ? 'bg-white' : 'bg-gray-200/80'" class="p-[3px] rounded-full  mx-[2px] inline-block">

                  </div>
                </template>
              </div>

              <template v-for="(media, index) in posts[open_post_index].media" :key="index">
                <div v-if="current_media_index == index" class="h-full sm:h-full bg-black" >
                  <div v-if="media.type == 'image'" class="h-full">
                    <!-- <img class="w-full h-full" :src="media.path" alt=""> -->
                    <div class="w-full h-full bg-contain bg-no-repeat bg-center" :style="`background-image: url('${media.path}') `">

                    </div>
                  </div>
                  <div v-else class="">
                    <video class="w-full h-full" :src="media.path" alt=""> </video>
                  </div>
                </div>
              </template>

            </div>

            <div class="sm:col-span-6 col-span-12 sm:h-full h-[65%] text-secondary-200 dark:text-slate-300 text-sm ">
              <div class="py-2 h-full">
                <div class="flex h-[12%] sm:h-fit justify-between py-3 px-6 border-b-[1px] border-secondary-300 dark:border-slate-500">
                  <div class="">
                    <img class="w-7 rounded-full inline-block " :src="Avatar" alt="">
                    <Link href="#" class="text-sm font-semibold inline-block mx-3 mr-1 hover:text-slate-300">{{ posts[open_post_index].user_name }}</Link>
                    <span>•</span>
                    <Link href="#" class="text-primary-100 hover:text-primary-200 inline-block ml-3">Follow</Link>
                  </div>

                  <div class="">
                    <font-awesome-icon class="cursor-pointer text-xl" icon="fa-solid fa-ellipsis" />
                  </div>
                </div>

                <div class="px-6 py-3 h-[53%] sm:h-[330px] border-b-[1px] border-secondary-300 dark:border-slate-500 overflow-y-scroll">
                  <div class="grid grid-cols-12 gap-3">
                    <div class="col-span-1">
                      <img class="w-full rounded-full inline-block " :src="Avatar" alt="">
                    </div>

                    <div class="col-span-11">
                      <p><Link href="#" class="text-sm font-semibold inline-block hover:text-slate-300 mr-1">{{ posts[open_post_index].user_name }}</Link> <span v-html="posts[open_post_index].caption"></span>  </p>
                    </div>
                  </div>

                  <div v-for="(comment, index) in posts.comments" :key="index" class="grid grid-cols-12 gap-3 mt-4">
                    <!-- <template > -->
                      <div class="col-span-1">
                        <img class="w-full rounded-full inline-block " :src="`/images/${comment.photo}`" alt="">
                      </div>

                      <div class="col-span-10">
                        <p><Link href="#" class="text-sm font-semibold inline-block hover:text-slate-300 mr-1">{{ comment.user_name }}</Link> <span v-html="comment.comment"></span>  </p>
                      </div>

                      <div class="col-span-1">
                        <font-awesome-icon @click="toggleCommentLike(comment.id)" v-if="!comment.liked" class="text-xs cursor-pointer" icon="fa-regular fa-heart" />
                        <font-awesome-icon @click="toggleCommentLike(comment.id)" v-else class="text-primary-100 text-xs cursor-pointer" icon="fa-solid fa-heart" />
                      </div>
                    <!-- </template> -->
                  </div>

                </div>

                <div class="px-6 h-[25%] sm:h-fit py-2 border-b-[1px] border-secondary-300 dark:border-slate-500 ">

                  <div class="text-2xl">
                    <font-awesome-icon @click="posts[open_post_index].liked = !posts[open_post_index].liked" v-if="posts[open_post_index].liked" icon="fa-regular fa-heart" class="cursor-pointer"/>

                    <font-awesome-icon @click="posts[open_post_index].liked = !posts[open_post_index].liked" v-else icon="fa-solid fa-heart" class=" text-primary-100 cursor-pointer"/>

                    <font-awesome-icon icon="fa-regular fa-comment"  class="cursor-pointer mx-3"/>

                    <font-awesome-icon icon="fa-regular fa-share-from-square" class="cursor-pointer"/>
                  </div>

                  <span class="text-[16px] inline-block mt-3 my-2 mb-1 cursor-pointer">{{ posts[open_post_index].likes }} likes</span>

                  <p class="text-xs text-secondary-600">{{ posts[open_post_index].relative_time }} ago</p>

                </div>

                <div class="px-6 py-2 h-[10%] sm:h-full">
                  <div v-if="show_select_emoji" class="absolute top-0">
                    <div class="relative p-3">
                      <EmojiPicker  tabindex="0" class="" :native="true" @select="onSelectEmoji" />

                      <font-awesome-icon @click.stop="show_select_emoji = false" class="absolute bottom-0  cursor-pointer text-xl dark:text-slate-400 text-slate-700 mt-3 -ml-3 p-2 dark:bg-white bg-slate-200 rounded-full" icon="fa-solid fa-xmark" />
                    </div>
                  </div>
                  <form>
                    <div class="grid grid-cols-12 gap-3">
                      <div class="col-span-1">
                        <font-awesome-icon @click="show_select_emoji = !show_select_emoji" class="sm:text-2xl  text-xl cursor-pointer" icon="fa-regular fa-face-smile" />
                      </div>

                      <div class="col-span-10">
                        <input type="text" v-model="make_comment_form.comment" class="w-full border-0 text-sm p-0 focus:outline-0 focus:outline-none focus:ring-0 bg-transparent dark:text-gray-200" placeholder="Add Comment...." ref="comment_input">
                      </div>

                      <div class="col-span-1">
                        <button :class="make_comment_form.comment == '' ? 'opacity-65 cursor-not-allowed' : ''" class="text-primary-100 font-semibold bg-transparent">Post</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </LayoutSocial>
</template>

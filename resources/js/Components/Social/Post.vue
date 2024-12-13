<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, reactive, onMounted, onUnmounted  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'

import FlashMessages from '@/Components/FlashMessages.vue'
import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'

const props = defineProps({
  post: {
    type: Object
  },
  index: {
    type: Number
  },
  make_comment_open: {
    type: Boolean,
    default: false
  },
  for_community: {
    type: Boolean,
    default: false
  },

});

const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()



</script>
<template>
  <div class="bg-white dark:bg-slate-800 rounded-lg shadow my-4" >
    <div class="px-4 pb-2 pt-3 border-b border-secondary-300">

      <div v-if="post.community != null && !for_community" class=" mb-4" >
        <span class="text-secondary-200 text-xs font-bold">Posted on <Link class="text-blue-600" target="_blank" :href="route('community.profile', post.community.id)">{{ post.community.name }} community</Link></span>
      </div>
      <div class="inline-block">
        <img class="w-8 h-8 rounded-full inline-block" :src="post.user.profile_picture" alt="">
        <Link :href="route('profile.show', post.user.slug)" class="text-sm font-semibold inline-block ml-3">{{ post.user.user_name }}</Link>
        <span class="text-secondary-600 text-xs font-bold inline-block ml-1">• {{post.relative_time}}</span>

      </div>

      <div class="float-right inline-block">
        <font-awesome-icon @click="mainStore.loadPostMoreOptions(post, index)" class="cursor-pointer" icon="fa-solid fa-ellipsis" />
      </div>
    </div>
    <div class=" px-3 py-1 ">

      <p class="transition-all ease-linear duration-300 text-sm leading-[26px]">
        <span v-if="post.caption == post.caption_short" class="inline-block" v-html="post.html_caption"></span>

        <span v-else-if="(post.caption != post.caption_short) && post.show_more" class="inline-block" ><span v-html="post.html_caption"></span> <span @click="post.show_more = !post.show_more" class="text-primary-100 inline-block ml-1 cursor-pointer hover:underline">less</span></span>

        <span v-else-if="(post.caption != post.caption_short) && !post.show_more" class="inline-block" ><span v-html="post.html_caption_short"></span> <span @click="post.show_more = !post.show_more" class="text-primary-100 inline-block ml-1 cursor-pointer hover:underline">read more</span> </span>
    </p>

    </div>

    <div class="px-3 py-3">
      <div class="grid grid-cols-12 gap-2">
        <template v-for="(media, media_index) in post.media" :key="media_index">

          <template v-if="media_index == 0">
            <div @click="$emit('openBiggerPost', index, 0)" v-if="media.type == 'image'" class="col-span-12 max-h-[300px] overflow-hidden rounded-xl cursor-pointer shadow-md relative">

              <div class="absolute bg-black w-full h-[300px] opacity-20 hover:hidden"></div>

              <div class="w-full h-[300px] hover:transform hover:scale-110 transition-all ease-in-out duration-300 " :style="`background-image: url('${media.path}');`" style="-webkit-background-size:contain; -moz-background-size:contain; background-size: contain; -o-background-size:contain; background-repeat: no-repeat; background-position: center;"></div>
            </div>

            <div @click="$emit('openBiggerPost', index, 0)" v-else class="col-span-12 max-h-[300px] overflow-hidden rounded-xl cursor-pointer shadow-xl relative">
              <div class="absolute bg-black w-full h-full opacity-20">
                <div class="relative h-full w-full">
                  <font-awesome-icon class="absolute text-7xl top-0 bottom-0 right-0 left-0 m-auto text-white" icon="fa-solid fa-play" />
                </div>
              </div>
              <video class="hover:transform hover:scale-110 transition-all ease-in-out duration-300 w-full h-full" :src="media.path" alt=""></video>
            </div>
          </template>


          <template v-if="media_index == 1 || media_index == 2">

            <div @click="$emit('openBiggerPost', index, media_index)" v-if="media.type == 'image'" class="col-span-5 max-h-[200px] overflow-hidden rounded-xl cursor-pointer shadow-xl relative">

              <!-- <img class="hover:transform hover:scale-110 transition-all ease-in-out duration-300 w-full h-full" :src="media.small_path" alt=""> -->

              <div class="absolute bg-black w-full h-[150px] opacity-20 hover:hidden"></div>
              <div class="w-full h-[150px] hover:transform hover:scale-110 transition-all ease-in-out duration-300" :style="`background:url('${media.small_path}'); -webkit-background-size:contain; -moz-background-size:contain; background-size: contain; -o-background-size:contain; background-repeat: no-repeat; background-position: center;`">
              </div>
            </div>


            <div @click="$emit('openBiggerPost', index, media_index)" v-else class="col-span-5 max-h-[300px] overflow-hidden rounded-xl cursor-pointer shadow-xl relative">
              <div class="absolute bg-black w-full h-full opacity-50">
                <div class="relative h-full w-full">
                  <font-awesome-icon class="absolute text-5xl top-0 bottom-0 right-0 left-0 m-auto text-white" icon="fa-solid fa-play" />
                </div>
              </div>
              <video class="hover:transform hover:scale-110 transition-all ease-in-out duration-300 w-full h-full" :src="media.path" alt=""></video>
            </div>
          </template>

          <div @click="$emit('openBiggerPost', index, 4)" v-if="post.media.length > 3 && media_index == post.media.length - 1" class="col-span-2 max-h-[300px] overflow-hidden rounded-xl cursor-pointer shadow-xl">
            <div class="w-full h-full bg-secondary-400 relative">
              <h5 class="text-lg text-white absolute top-0 bottom-0 left-0 right-0 m-auto ">+{{ post.media.length - 3 }} more</h5>
            </div>

          </div>
        </template>



      </div>
    </div>

    <div class="px-3 py-4 border-b border-secondary-300 dark:border-slate-500 ">
      <span @click="mainStore.loadPostLikes(post.id)" class="text-sm cursor-pointer">{{ mainStore.addCommas(post.likes_num) }} likes</span>
    </div>

    <div class="px-3 py-4 border-b border-secondary-300 dark:border-slate-500 ">
      <div class="text-sm">
        <div class="inline-block mr-8">
          <span @click="$emit('togglePostLike', index, id)" class="cursor-pointer">
            <font-awesome-icon  v-if="!post.liked" class=" " icon="fa-regular fa-heart" />
            <font-awesome-icon v-else class="text-primary-100 " icon="fa-solid fa-heart" />

            <span :class="post.liked ? 'text-primary-100' : ''" v-text="post.liked ? 'Liked' : 'Like'" class="inline-block ml-1">

            </span>
          </span>
        </div>

        <div @click="$emit('makeCommentAction', index)" :class="make_comment_open ? 'text-primary-100' : ''" class="inline-block mr-8 cursor-pointer hover:text-primary-100">
          <font-awesome-icon icon="fa-solid fa-comments" />
          <span class="inline-block mx-1">Comment</span>
          <span class="text-xs border-[1px] p-[1px] px-1 border-secondary-300 dark:border-slate-500 rounded-md">{{ post.comments_num }}</span>
        </div>

        <div class="inline-block  cursor-pointer hover:text-primary-100">
          <font-awesome-icon icon="fa-solid fa-share" />
          <span class="inline-block mx-1">Share</span>

        </div>

        <div class="inline-block  cursor-pointer :text-primary-100 float-right mx-2">
          <!-- <font-awesome-icon icon="fa-solid fa-bookmark" /> -->
          <!-- <span class="inline-block mx-1">Share</span> -->
          <font-awesome-icon @click="mainStore.addPostToFavorites(post)" v-if="!post.is_favorite" class="float-right mr-1 cursor-pointer" icon="fa-regular fa-bookmark" />
          <font-awesome-icon @click="mainStore.addPostToFavorites(post)" v-else class="float-right mr-1 cursor-pointer text-primary-100" icon="fa-solid fa-bookmark" />
        </div>
      </div>
    </div>

    <div class="px-3 py-4 ">
      <div class="">
        <span @click="$emit('openBiggerPost', index, 0)" class="text-primary-100 hover:underline text-sm cursor-pointer inline-block my-2"><font-awesome-icon icon="fa-regular fa-eye" /> Show all {{ post.comments_num }} comments</span>

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
          <div class="my-1" v-for="(comment, comment_index) in post.comments.slice(Math.max(post.comments.length - 2, 0))" :key="comment_index">

            <div class="grid grid-cols-12 gap-2">
              <p class="text-sm col-span-11">
                <Link :href="route('profile.show', comment.user.slug)" class="text-secondary-400 font-bold inline-block mr-2">{{ comment.user.user_name }}</Link>
                <span class="inline-block" v-html="comment.html_comment"></span>

                <!-- <span v-if="comment.comment == comment.comment_short" class="inline-block">{{ comment.comment }}</span> -->

                <!-- <span v-else-if="(comment.comment != comment.comment_short) && comment.show_more" class="inline-block">{{ comment.comment }}</span>

                <span v-else-if="(comment.comment != comment.comment_short) && !comment.show_more" class="inline-block">{{ comment.comment_short }} <span @click="comment.show_more = true" class="cursor-pointer  font-semibold inline-block ml-1">show more</span> </span> -->

              </p>

              <span class="float-right col-span-1">
                <font-awesome-icon @click="$emit('toggleCommentLike', index, comment)" v-if="!comment.liked" class="text-xs cursor-pointer" icon="fa-regular fa-heart" />
                <font-awesome-icon @click="$emit('toggleCommentLike', index, comment)" v-else class="text-primary-100 text-xs cursor-pointer" icon="fa-solid fa-heart" />
              </span>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

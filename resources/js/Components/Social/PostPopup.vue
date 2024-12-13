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
  post: {
    type: Object
  },
  for_community: {
    type: Boolean,
    default: false
  }



});

const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()
const auth_user = page.props.auth.user

const follow_author_loading = ref(false);
const comments_like_loading = ref(false)
const show_select_emoji = ref(false);
const comments_loading = ref(false);
// const last_comment = ref();

const openPostIndex = defineModel('openPostIndex');
const openMediaIndex = defineModel('openMediaIndex');
const currentMediaIndex = defineModel('currentMediaIndex');


const closeBigPostModal = () => {
  openPostIndex.value = false;
  openMediaIndex.value = false;
}


const onSelectEmoji = (emoji) => {
  console.log(emoji)

  mainStore.make_comment_form.comment = mainStore.make_comment_form.comment + emoji.i;
}

const toggleCommentLike = async (id, index) => {

  try {
    if(mainStore.comments_like_loading){
      return
    }

    mainStore.comments_like_loading = true;

    let queryRoute = route('comment.toggle_like', {post: props.post.id, comment: id});

    const response = await axios.post(queryRoute);
    console.log(response)
    mainStore.comments_like_loading = false;

    if (response.data.success && response.data.action != "") {
      let comment = props.post.comments[index]
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

const toggleReplyLike = async (comment_index ,index) => {

try {
  if(mainStore.replies_like_loading){
    return
  }

  var comment = props.post.comments[comment_index];
  var reply = comment.replies[index];
  mainStore.replies_like_loading = true;

  let queryRoute = route('reply.toggle_like', {post: props.post.id, comment: comment.id, reply: reply.id});

  const response = await axios.post(queryRoute);
  console.log(response)
  mainStore.replies_like_loading = false;

  if (response.data.success && response.data.action != "") {
    reply.liked = response.data.action == "liked" ? true : false;
    reply.likes_num = reply.liked ? reply.likes_num + 1 : reply.likes_num - 1;
    // form.city = cities.value[0];

  } else {
    mainStore.toast = 'Something went wrong'
  }
} catch (error) {

  mainStore.replies_like_loading = false;
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
  mainStore.toast = 'Something went wrong'

  // Swal.fire({
  //   title: 'Ooops!',
  //   html: 'Something went wrong',
  //   icon: 'error',


  // });
}
}


const loadMoreComments = async () => {
  try {
    if(comments_loading.value || props.post.last_comment){
      return
    }

    var last_id = props.post.comments[props.post.comments.length - 1].id;
    comments_loading.value = true;

    let queryRoute = route('post.more_comments', {post: props.post.id});

    const response = await axios.post(queryRoute,{last_id: last_id});
    console.log(response)
    comments_loading.value = false;

    if (response.data.comments.length > 0 && !response.last_comment) {
      props.post.comments = props.post.comments.concat(response.data.comments);
      // form.city = cities.value[0];

    } else if(response.last_comment){
      props.post.last_comment = true;
    } else {
      console.log('Something went wrong')
    }
  } catch (error) {

    comments_loading.value = false;
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

const togglePostLike = async () => {

try {
  if(mainStore.post_like_loading){
    return
  }


  mainStore.post_like_loading = true;

  let queryRoute = route('post.toggle_like', {post: props.post.id});

  const response = await axios.post(queryRoute);
  console.log(response)
  mainStore.post_like_loading = false;

  if (response.data.success && response.data.action != "") {

    props.post.liked = response.data.action == "liked" ? true : false;
    props.post.likes_num = props.post.liked ? props.post.likes_num + 1 : props.post.likes_num - 1;
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


const toggleFollowAuthor = async () => {

try {
  if(follow_author_loading.value){
    return
  }


  follow_author_loading.value = true;

  let queryRoute = route('user.toggle_follow', {user: props.post.user.id});

  const response = await axios.post(queryRoute);
  console.log(response)
  follow_author_loading.value = false;

  if (response.data.success && response.data.action != "") {

    props.post.following_author = response.data.action == "followed" ? true : false;

  } else {
    console.log('Something went wrong')
  }
} catch (error) {

  follow_author_loading.value = false;
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



const loadReplies = async (index) => {

try {

  var comment = props.post.comments[index];
  // console.log(comment)
  // return
  if(comment.loading_replies){
    return
  }


  comment.loading_replies = true;
  var last_id = comment.replies.length > 0 ? comment.replies[comment.replies.length - 1].id : 0;
  // console.log(last_id)

  let queryRoute = route('comment.replies', {post: props.post.id, comment: comment.id});

  const response = await axios.post(queryRoute, {last_id: last_id});
  console.log(response)
  comment.loading_replies = false;

  if (response.data.success && response.data.rem != null) {

    comment.replies = comment.replies.concat(response.data.replies)
    comment.replies_num = response.data.rem;

    console.log(comment)
    var last_id = comment.replies.length > 0 ? comment.replies[comment.replies.length - 1].id : 0;
    console.log(last_id)

  } else {
    console.log('Something went wrong')
  }
} catch (error) {

  comment.loading_replies = false;
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

const hideReplies = async (index) => {

  var comment = props.post.comments[index];

  comment.replies = [];
  comment.replies_num = comment.total_replies_num
}




</script>

<template>
  <div v-if="openPostIndex !== false && openMediaIndex !== false"  class="fixed top-0 bottom-0 left-0 right-0 z-[900] ">
    <div @click.stop="closeBigPostModal" class="h-screen w-screen bg-gradient-to-br from-slate-600/60 via-slate-700/60 to-slate-800/60 dark:bg-slate-900/80">

    </div>

    <div class="absolute top-0 right-0 m-2 mx-9">
      <font-awesome-icon @click.stop="closeBigPostModal" class="cursor-pointer text-3xl dark:text-gray-300 text-gray-100" icon="fa-solid fa-xmark" />
    </div>

    <div class="absolute m-auto min-h-fit sm:max-h-[90%] md:max-h-[55%] lg:max-h-[90%]  top-0 bottom-0 left-0 right-0 bg-white dark:bg-slate-700 w-10/12  z-[1000] rounded flex">

      <div class="relative h-full">


        <div class="w-full sm:h-full h-screen sm:grid sm:grid-cols-12 sm:gap-0 relative">
          <div v-if="post.media.length > 0" class="sm:col-span-6 sm:h-full h-[35%] col-span-12 relative">

            <font-awesome-icon @click="currentMediaIndex -= 1" v-if="currentMediaIndex > 0 || (post.media.length == 1)" class="absolute top-0 bottom-0 my-auto left-0 text-white mx-2 bg-gray-300 p-2 rounded-full cursor-pointer z-[500]" icon="fa-solid fa-angle-left" />


            <font-awesome-icon @click="currentMediaIndex += 1" v-if="(currentMediaIndex < post.media.length - 1)" class="absolute top-0 bottom-0 my-auto right-0 text-white mx-2 bg-gray-300 p-2 rounded-full cursor-pointer z-[500]" icon="fa-solid fa-angle-right" />

            <div class="absolute bottom-0 right-0 left-0 m-auto  my-4 flex justify-center z-[500]">
              <template  v-for="(media, index) in post.media" :key="index">
                <div :class="currentMediaIndex == index ? 'bg-white' : 'bg-gray-200/80'" @click="currentMediaIndex = index"  class="cursor-pointer p-[3px] rounded-full  mx-[2px] inline-block">

                </div>
              </template>
            </div>

            <template v-for="(media, index) in post.media" :key="index">
              <div v-if="currentMediaIndex == index" class="h-full sm:h-full bg-black" >
                <div v-if="media.type == 'image'" class="h-full">
                  <!-- <img class="w-full h-full" :src="media.path" alt=""> -->
                  <div class="w-full h-full bg-contain bg-no-repeat bg-center" :style="`background-image: url('${media.path}') `">

                  </div>
                </div>
                <div v-else class="">
                  <video controls class="w-full h-full" :src="media.path" alt=""> </video>
                </div>
              </div>
            </template>

          </div>

          <div class="sm:col-span-6 col-span-12 sm:h-full h-[65%] text-secondary-200 dark:text-slate-300 text-sm ">
            <div class="py-2 h-full">
              <div class=" h-[12%] sm:h-fit  py-2 px-6 border-b-[1px] border-secondary-300 dark:border-slate-500">
                <div v-if="post.community != null && !for_community" class=" mb-4 block" >
                  <span class="text-secondary-200 text-xs font-bold">Posted on <Link class="text-blue-600" target="_blank" :href="route('community.profile', post.community.id)">{{ post.community.name }} community</Link></span>
                </div>

                <div class="flex justify-between">
                  <div class="">
                    <img class="w-7 h-7 rounded-full inline-block " :src="post.user.profile_picture" alt="">
                    <Link :href="route('profile.show', post.user.slug)" class="text-sm font-semibold inline-block mx-3 mr-1 hover:text-slate-300">{{ post.user.user_name }}</Link>
                    <span>•</span>

                    <span @click="mainStore.toggleFollowUser(post.user)" v-if="post.user.following_status" :class="post.user.following_loading ? 'cursor-not-allowed opacity-50' : ''" class=" text-primary-100 hover:text-primary-200 inline-block ml-3 cursor-pointer">Following</span>
                    <span @click="mainStore.toggleFollowUser(post.user)" v-else :class="post.user.following_loading ? 'cursor-not-allowed opacity-50' : ''"  class="text-primary-100 hover:text-primary-200 inline-block ml-3 cursor-pointer">Follow</span>
                  </div>

                  <div @click="mainStore.loadPostMoreOptions(post, openPostIndex)" class="">
                    <font-awesome-icon class="cursor-pointer text-xl" icon="fa-solid fa-ellipsis" />
                  </div>

                </div>

              </div>

              <div class="px-6 py-3 h-[53%] sm:h-[330px] border-b-[1px] border-secondary-300 dark:border-slate-500 overflow-y-scroll">
                <div class="grid grid-cols-12 gap-0">
                  <div class="sm:col-span-1 col-span-2">
                    <img class="w-7 h-7 rounded-full inline-block " :src="post.user.profile_picture" alt="">
                  </div>

                  <div class="sm:col-span-11 col-span-10">
                    <p><Link :href="route('profile.show', post.user.slug)" class="text-sm font-semibold inline-block hover:text-slate-300 mr-1">{{ post.user.user_name }}</Link> <span v-html="post.caption"></span>  </p>
                  </div>
                </div>

                <div v-for="(comment, comment_index) in post.comments" :key="comment_index" class="grid grid-cols-12 gap-0 sm:gap-1 mt-7 group">
                  <!-- <template > -->
                    <div class="sm:col-span-1 col-span-2">
                      <img class="w-7 h-7 rounded-full inline-block " :src="`${comment.user.profile_picture}`" alt="">
                    </div>

                    <div class="sm:col-span-10 col-span-9">
                      <p><Link :href="route('profile.show', comment.user.slug)" class="text-sm font-semibold inline-block hover:text-slate-300 mr-1">{{ comment.user.user_name }}</Link> <span v-html="comment.html_comment"></span>  </p>

                      <div class="mt-2 mb-1">
                        <div class="text-xs">
                          <span class="inline-block mr-2">{{ comment.relative_time }}</span>
                          <span v-if="comment.likes_num > 0" @click="mainStore.loadCommentLikes(comment.id)" class="inline-block mr-2 cursor-pointer" v-text="comment.likes_num > 1 ? `${comment.likes_num} likes` : `1 like`">

                          </span>

                          <span v-else class="inline-block mr-2">No Likes</span>
                          <span @click="mainStore.makeReply(post, comment, comment_index)" class="inline-block mr-2 cursor-pointer">Reply</span>
                          <font-awesome-icon @click="mainStore.loadCommentMoreOptions(post, comment, comment_index)" class="cursor-pointer ml-2 hidden group-hover:inline-block" icon="fa-solid fa-ellipsis" />
                        </div>
                      </div>

                      <div  class="mt-4 mb-0 text-xs relative">
                        <!-- <div class="inline-block bg-black dark:bg-slate-300 h-[1px] w-4 mx-2 absolute left-0 top-0 bottom-0 my-auto"></div> -->

                        <span v-if="comment.replies.length > 0" @click="hideReplies(comment_index)" class="inline-block cursor-pointer ml-[35px]">Hide all replies</span>

                        <div v-if="comment.replies.length > 0" class="my-1">

                          <div v-for="(reply, reply_index) in comment.replies" :key="reply_index" class="grid grid-cols-12 gap-3 mt-4">
                          <!-- <template > -->

                            <div class="col-span-2">
                              <img class="w-7 h-7 rounded-full inline-block " :src="`${reply.user.profile_picture}`" alt="">
                            </div>

                            <div class="col-span-9">
                              <p><Link :href="route('profile.show', reply.user.slug)" class="text-sm font-semibold inline-block hover:text-slate-300 mr-1">{{ reply.user.user_name }}</Link> <span class="text-sm" v-html="reply.html_reply"></span>  </p>

                              <div class="mt-2 mb-1">
                                <div class="text-xs">
                                  <span class="inline-block mr-2">{{ reply.relative_time }}</span>
                                  <span v-if="reply.likes_num > 0" @click="mainStore.loadReplyLikes(reply.id)" class="inline-block mr-2 cursor-pointer" v-text="reply.likes_num > 1 ? `${reply.likes_num} likes` : `1 like`">

                                  </span>

                                  <span v-else class="inline-block mr-2">No Likes</span>
                                  <span class="inline-block mr-2 cursor-pointer">Reply</span>
                                  <font-awesome-icon @click="mainStore.loadCommentReplyMoreOptions(post, comment, reply, comment_index, reply_index)" class="cursor-pointer ml-2 inline-block" icon="fa-solid fa-ellipsis" />
                                </div>
                              </div>
                            </div>

                            <div class="col-span-1">
                              <font-awesome-icon @click="toggleReplyLike(comment_index, reply_index)" v-if="!reply.liked" class="text-xs cursor-pointer" icon="fa-regular fa-heart" />
                              <font-awesome-icon @click="toggleReplyLike(comment_index, reply_index)" v-else class="text-primary-100 text-xs cursor-pointer" icon="fa-solid fa-heart" />
                            </div>
                          </div>

                        </div>


                        <span v-if="comment.replies_num > 0" @click="loadReplies(comment_index)" class="inline-block cursor-pointer ml-[35px]">View replies ({{ comment.replies_num }})</span>

                        <img v-if="comment.loading_replies" class="w-8 ml-2 inline-block" :src="Loader" alt="">
                      </div>
                    </div>

                    <div class="col-span-1">
                      <font-awesome-icon @click="toggleCommentLike(comment.id, comment_index)" v-if="!comment.liked" class="text-xs cursor-pointer" icon="fa-regular fa-heart" />
                      <font-awesome-icon @click="toggleCommentLike(comment.id, comment_index)" v-else class="text-primary-100 text-xs cursor-pointer" icon="fa-solid fa-heart" />
                    </div>
                  <!-- </template> -->
                </div>

                <div class="flex justify-center">
                  <font-awesome-icon v-if="!comments_loading && !post.last_comment" @click="loadMoreComments" class="text-3xl my-3 mt-6 cursor-pointer text-black dark:text-slate-300" icon="fa-regular fa-square-plus" />

                  <img v-if="comments_loading" class="w-[50px]" :src="Loader" alt="">
                </div>
              </div>

              <div class="px-6 h-[25%] sm:h-fit py-2 border-b-[1px] border-secondary-300 dark:border-slate-500 ">

                <div class="text-2xl">
                  <font-awesome-icon @click="togglePostLike" v-if="!post.liked" icon="fa-regular fa-heart" class="cursor-pointer"/>

                  <font-awesome-icon @click="togglePostLike" v-else icon="fa-solid fa-heart" class=" text-primary-100 cursor-pointer"/>

                  <font-awesome-icon icon="fa-regular fa-comment"  class="cursor-pointer mx-3"/>

                  <font-awesome-icon icon="fa-regular fa-share-from-square" class="cursor-pointer"/>

                  <font-awesome-icon @click="mainStore.addPostToFavorites(post)" v-if="!post.is_favorite" class="float-right mr-1 cursor-pointer" icon="fa-regular fa-bookmark" />
                  <font-awesome-icon @click="mainStore.addPostToFavorites(post)" v-else class="float-right mr-1 cursor-pointer text-primary-100" icon="fa-solid fa-bookmark" />
                </div>

                <span @click="mainStore.loadPostLikes(post.id)" class="text-[16px] inline-block mt-3 my-2 mb-1 cursor-pointer">
                  <span v-text="post.likes_num > 0 ? post.likes_num : 'No'"></span>
                   like<span v-if="post.likes_num > 1 || post.likes_num == 0">s</span>
                </span>

                <p class="text-xs text-secondary-600">{{ post.relative_time }} ago</p>

              </div>

              <div class="px-6 py-2 h-[10%] sm:h-full">
                <div v-if="show_select_emoji" class="absolute top-0">
                  <div class="relative p-3">
                    <EmojiPicker  tabindex="0" class="" :native="true" @select="onSelectEmoji" />

                    <font-awesome-icon @click.stop="show_select_emoji = false" class="absolute bottom-0  cursor-pointer text-xl dark:text-slate-400 text-slate-700 mt-3 -ml-3 p-2 dark:bg-white bg-slate-200 rounded-full" icon="fa-solid fa-xmark" />
                  </div>
                </div>
                <form @submit.prevent="mainStore.makeComment(post)">
                  <div class="grid grid-cols-12 gap-3">
                    <div class="col-span-1">
                      <font-awesome-icon @click="show_select_emoji = !show_select_emoji" class="sm:text-2xl  text-xl cursor-pointer" icon="fa-regular fa-face-smile" />
                    </div>

                    <div class="col-span-10">
                      <input type="text" v-model="mainStore.make_comment_form.comment" class="w-full border-0 text-sm p-0 focus:outline-0 focus:outline-none focus:ring-0 bg-transparent dark:text-gray-200" placeholder="Add Comment...." ref="comment_input">
                    </div>

                    <div class="col-span-1 relative">
                      <button :class="mainStore.make_comment_form.processing ? 'opacity-65 cursor-not-allowed' : ''" class="text-primary-100 font-semibold bg-transparent">Post</button>


                      <img v-if="mainStore.make_comment_form.processing" class="w-10 inline-block absolute top-0 bottom-0" :src="Loader" alt="">

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
</template>

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
  for_community: {
    type: Boolean,
    default: false,
  },
  placeholder: {
    type: String,
    default: "What's on your mind?"
  }
});

const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()
const user = page.props.auth.user

let files = []
const post_medias = ref(null);
const create_post_input_fcsd = ref(false);
const max_post_length = ref(3000);
const rem_chars = ref(max_post_length.value);
const placeholder = ref(props.placeholder);

const progress = ref(0);




const make_post_form = useForm({
  caption: null,
  media: files,
  media_details: [],
  for_community: props.for_community
})

const createPostFocused = () => {
  create_post_input_fcsd.value = true;
}

const checkPostLength = () => {
  // max_post_length

  rem_chars.value = max_post_length.value - make_post_form.caption.length;
  console.log(rem_chars.value)
}

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
      make_post_form.media.push(file)

      make_post_form.media_details.push({
        open: false,
        name: file.name,
        description: '',
      });

      console.log(make_post_form.media)
      console.log(make_post_form.media_details)
    }, 500);
  }

}

const selectMediaFiles = () => {
  post_medias.value.click();
}



const removeMediaFromQueue = (index) => {
  make_post_form.media.splice(index, 1);
  make_post_form.media_details.splice(index, 1);

  console.log(make_post_form.media)
  console.log(make_post_form.media_details)
}

const toggleEnterMoreDetailsPostMedia = (index) => {
  // console.log(make_post_form.media.files[index].open)

  make_post_form.media_details[index].open = !make_post_form.media_details[index].open

}

const increaseProgress = () => {
  if(progress.value >= 100){
    return;
  }
  progress.value++;
  setTimeout(() => {
    increaseProgress();
  }, 1000);

}

const getMediaErrors = () => {
  var errors = [];
  var no_errors = true;
  var files = make_post_form.media;
  if(files.length > 0){
    if(files.length <= 10){
      for(let i = 0; i < files.length; i++){
        console.log(files[i])

        var file = files[i];
        errors.push({
          position: i + 1,
          message: '',
        })
        if(file.type == 'image/jpeg' || file.type == 'image/jpg' || file.type == 'image/png' || file.type == 'image/gif' || file.type == 'video/mp4'){
          if(file.size <= 10000000){

          }else{
            no_errors = false;
            errors[i].message += '<h5>The file size here exceeds 10MB</h5>'

          }
        }else{
          no_errors = false;
          errors[i].message += '<h5>Only jpeg, jpg, png, gif and mp4 files are allowed</h5>'
        }
      }
    }else{
      no_errors = false;

      errors.push({
        position: files.length,
        message: 'Maximum number of media files to upload is 10.',
      })
    }
  }else{
    no_errors = false;
    errors.push({
      position: 1,
      message: 'You need to select at least one media file to proceed.',
    })
  }
  return no_errors ? [] : errors;
}

const presentMediaErrors = (errors) => {
  if(errors.length > 0){
    var issues = `<h4 class="text-xl mb-3">Please fix the issues below </h4>`;

    for(let i = 0; i < errors.length; i++){
      var value = errors[i];
      issues += `<div class='my-2'>`
      issues += `<h5 class="text-lg capitalize"><em class="text-primary-100 font-bold">Media Position ${value.position}</em></h5>`;

      issues += `<div>${value.message}</div>`;
      issues += `</div>`
    }


    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      html: issues,
    })
  }
}

const submitMakePostForm = () => {
  console.log(make_post_form)
  // progress.value = 0;
  // increaseProgress();

  if(make_post_form.processing){
    return
  }

  // var errors = getMediaErrors();
  // if(errors.length > 0){
  //   presentMediaErrors(errors)
  //   return;
  // }


  let url = route('post.store');


  make_post_form.post(url, {
    preserveScroll: true,
    onSuccess: (page) => {

      var response = page.props.flash.data;
      console.log(response)
      if (response.success) {
        Swal.fire({
          title: 'Success',
          html: `Your post has been made sucessfully`,
          icon: 'success',

          allowEscapeKey: false,
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            document.location.reload();
          }
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `Something went wrong`,
        })
      }
    }, onError: (errors) => {
      console.log(errors)

      if(Object.keys(errors).length > 0){


        var issues = `<h4 class="text-xl mb-3">Please fix the issues below </h4>`;
        Object.keys(errors).map(function(objectKey, index) {
          var value = errors[objectKey];
          issues += `<h5 class="text-lg capitalize"><em class="text-primary-100 font-bold">${value}</em></h5>`;
        });
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          html: issues,
        })
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `Something went wrong`,
        })
      }


    },
  });

}
</script>

<template>
  <div class="relative">
    <div class="absolute bottom-0 bg-gray-50 w-[96%] h-[50px] mb-[-12px] rounded-[200px] z-[1] mx-auto left-0 right-0 shadow-xl opacity-50 dark:bg-slate-800"></div>

    <div class="bg-white dark:bg-slate-800 shadow-xl sm:px-7 px-2 py-5 rounded-md relative z-[2]">

      <div>
        <form @submit.prevent="submitMakePostForm">
          <div v-show="!create_post_input_fcsd" class="grid grid-cols-12 gap-6" >
            <img :src="user.profile_picture" alt="" class="rounded-full col-span-2">

            <input @focus="createPostFocused" class="col-span-10 dark:text-white dark:bg-slate-700 rounded-full border-secondary-300 text-sm focus:outline-0 focus:outline-none focus:ring-0 focus:border-secondary-300" :placeholder="placeholder">
          </div>

          <div v-show="create_post_input_fcsd" >

            <div class="grid grid-cols-12 gap-3 border-b border-secondary-300">
              <div class="col-span-2 relative">
                <img :src="user.profile_picture" alt="" class="rounded-full w-full">

                <span :class="rem_chars <= 0 ? 'text-red-500' : ''" class="absolute bottom-0 text-sm mb-1 text-secondary-200 font-semibold">{{ rem_chars }}</span>
              </div>


              <textarea @keyup="checkPostLength" v-model="make_post_form.caption"  class="col-span-10 dark:text-white bg-transparent  border-0 text-sm focus:outline-0 focus:outline-none focus:ring-0 focus:border-0 " :placeholder="placeholder" cols="50" rows="4"> </textarea>

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

              <div v-if="make_post_form.media.length" class="text-xs py-2 text-secondary-400 dark:text-slate-600">
                <div v-for="(file, index) in make_post_form.media" class="rounded-xl my-1 px-3 py-2 bg-gray-100 dark:bg-slate-300" :key="index">
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

                <div :style="`width: ${make_post_form.progress ? make_post_form.progress.percentage : 0}%`" class="h-1 bg-gradient-to-r from-primary-100 via-purple-400 to-primary-200 my-2"></div>
              </div>
            </div>

            <div class="text-right pt-3">
              <span @click="create_post_input_fcsd = false" class="text-primary-100 text-sm inline-block cursor-pointer hover:underline">Cancel</span>

              <button :class="make_post_form.processing ? 'cursor-not-allowed opacity-60': ''" class="text-center px-4 py-1 bg-gradient-to-r from-primary-100 to-primary-200 rounded-full ml-3 text-white text-sm">Post Update</button>
            </div>

          </div>



        </form>
      </div>
    </div>
  </div>
</template>

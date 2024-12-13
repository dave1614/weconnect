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
  deletePost: {
    type: Boolean,
    default: false
  }

});

console.log(props.post)

const post = ref(props.post);
const auth_user = ref(props.auth_user);



const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()





let files = []
// const state = reactive({files});
const new_medias = ref(null);
const update_medias = ref(null);

const showSelectNewMediaModal = ref(false)
const showSelectUpdateMediaModal = ref(false)

const caption_form = useForm({
  // caption: mainStore.stripHtml(post.value.caption)
  caption: post.value.caption

})


const new_media_form = useForm({
  media: null
})


const update_media_form = useForm({
  media: null,
  index: null,
  type: null,
  path: null,
})


onMounted(() => {
  if(props.deletePost){
    processDeletePost()
  }
})



const addNewMediaFile = () => {
  showSelectNewMediaModal.value = true
}

const submitNewMediaFileForm = () => {

if (!new_media_form.processing) {
  new_media_form.post(route('post.add_new_media_file', post.value.id), {
    preserveScroll: true,
    onSuccess: (page) => {

      var response = page.props.flash.data;
      console.log(response)
      if (response.success) {
        post.value.media = response.media

        mainStore.toast = 'media file uploaded successfully'
        showSelectNewMediaModal.value = false;
        new_media_form.media = null;

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

const updateAddNewMediaFiles = (event) => {
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
      new_media_form.media = file
    }, 500);


}


const selectNewMediaFiles = () => {
  new_medias.value.click();
}

const deleteMedia = (index, type, file_name) => {
  Swal.fire({
    title: `Are you sure you want to delete this ${type} file at position ${index + 1}?`,
    html: '<b class="text-primary-100">Note: This process is irreversible</b>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes Proceed!',
  }).then((result) => {

    if (result.isConfirmed) {
      processDeleteMedia(index, type, file_name)

    } else if (result.isDenied) {
      // Swal.fire('Changes are not saved', '', 'info')
    }
  })
}

const processDeleteMedia = async (index, type, file_name) => {
  let queryRoute = route('post.delete_media', post.value.id);

  const { response, error, loading  } = await useAxios(queryRoute, `Deleting ${type} file .....`, {index: index, file_name: file_name});

  if (response?.value?.data) {
    if(response.value.data.success){
      mainStore.toast = `${type} file deleted successfully`;
      post.value.media = response.value.data.media
    }

  }
}

const addUpdateMediaFile = (index, type, path) => {
  showSelectUpdateMediaModal.value = true
  update_media_form.index = index;
  update_media_form.type = type;
  update_media_form.path = path;
}

const submitUpdateMediaFileForm = () => {

if (!update_media_form.processing) {
  update_media_form.post(route('post.update_media_file', post.value.id), {
    preserveScroll: true,
    onSuccess: (page) => {

      var response = page.props.flash.data;
      console.log(response)
      if (response.success) {
        post.value.media = response.media

        mainStore.toast = `media file at position ${update_media_form.index + 1} updated successfully`

        showSelectUpdateMediaModal.value = false;
        update_media_form.media = null;
        update_media_form.index = null;
        update_media_form.type = null;
        update_media_form.path = null;

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

const updateMediaFiles = (event) => {
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
      update_media_form.media = file
    }, 500);


}


const selectUpdateMediaFiles = () => {
  update_medias.value.click();
}


const editPostCaption = () => {

if (!caption_form.processing) {
  caption_form.post(route('post.update', post.value.id), {
    preserveScroll: true,
    onSuccess: (page) => {

      var response = page.props.flash.data;
      console.log(response)
      if (response.success) {

        mainStore.toast = `Caption Edited successfully`

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

const deletePost = () => {
  Swal.fire({
    title: `Are you sure you want to delete this post?`,
    html: '<b class="text-primary-100">Note: This process is irreversible</b>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes Proceed!',
  }).then((result) => {

    if (result.isConfirmed) {
      processDeletePost()

    } else if (result.isDenied) {
      // Swal.fire('Changes are not saved', '', 'info')
    }
  })
}

const processDeletePost = async () => {
  let queryRoute = route('post.destroy', post.value.id);

  const { response, error, loading  } = await useAxios(queryRoute, `Deleting this post .....`, {delete_post: true});

  if (response?.value?.data) {
    if(response.value.data.success){
      mainStore.toast = `This post has been deleted successfully`;

      router.visit(route('profile.show', auth_user.value.slug))

    }

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



          <div class="col-span-12 sm:col-span-9 border-0  min-h-screen dark:text-slate-400">
            <div class="sm:px-7 px-2 py-4">
              <div class="mt-[20px]">
                <h3 class="text-2xl font-bold text-center">Edit post</h3>

                <div class="">
                  <h4 class="text-xl font-bold my-3">Details:</h4>
                  <h6>
                    <p>Date posted: <em class="text-primary-100">{{ mainStore.formatDate(post.created_at) }} ({{ post.relative_time }} ago)</em></p>
                    <p v-if="post.created_at != post.updated_at">Date last edited: <em class="text-primary-100">{{ mainStore.formatDate(post.updated_at) }}</em></p>
                    <p>No. of media: <em class="text-primary-100">{{ post.media.length }}</em></p>
                    <p>No. Of Likes: <em class="text-primary-100">{{ post.likes_num }}</em></p>
                    <p>No. Of Comments: <em class="text-primary-100">{{ post.comments_num }}</em></p>
                  </h6>
                </div>


                <BaseButton :href="route('post.show', post.id)" color="success" label="View post"  class="my-3 "/>
                <BaseButton @click="deletePost" color="danger" label="Delete this post"  class="my-3 mx-2"/>


                <div class="mt-[40px]">
                  <h4 class="text-2xl font-bold">Edit post details</h4>
                  <form @submit.prevent="editPostCaption">
                    <div class="my-3">
                      <label for="edit-caption" class="text-lg text-primary-100 font-semibold">Edit caption: </label>
                      <textarea v-model="caption_form.caption" cols="30" rows="10" id="edit-caption" class="w-full rounded">

                      </textarea>
                      <span class="form-error">{{ caption_form.errors.caption }}</span>
                    </div>

                    <button class="form-button" :class="caption_form.processing ? 'opacity-60 cursor-not-allowed' : ''">SUBMIT</button>
                  </form>

                </div>
              </div>


              <div class="mt-[50px]">
                <h3 class="text-2xl font-bold text-center my-4 ">Edit media files</h3>

                <div v-if="post.media.length > 0" class="sm:grid sm:grid-cols-12 sm:gap-6 mt-[40px]">
                  <div v-for="(file, index) in post.media" class="sm:col-span-6 m-3" :key="index">
                    <div class="">
                      <button @click="addUpdateMediaFile(index, file.type, file.path)" class="bg-emerald-500 rounded-md px-2 py-1 m-2 text-white" title="Change this file"><font-awesome-icon icon="fa-solid fa-pen-to-square" /></button>
                      <button @click="deleteMedia(index, file.type, file.path)" class="bg-red-500 rounded-md px-2 py-1 m-2 text-white" title="delete this file"><font-awesome-icon icon="fa-solid fa-trash-can" /></button>

                      <img v-if="file.type == 'image'" :src="file.path" :alt="`Image file in position ${index + 1}`" class="h-[200px] w-full ">
                      <video v-else :src="file.path" :alt="`Video file in position ${index + 1}`" class="h-[200px] w-full "></video>
                    </div>
                  </div>

                  <div @click="addNewMediaFile" v-if="post.media.length < 10" class="inline-block border-[10px] border-black rounded-full w-[200px] h-[200px] sm:mt-[40px] sm:ml-3 cursor-pointer relative">
                    <font-awesome-icon class="absolute text-black top-0 bottom-0 left-0 right-0 m-auto text-6xl" icon="fa-solid fa-plus" />
                  </div>
                </div>
              </div>


            </div>
          </div>


        </div>

      </div>
    </div>

    <CardBoxModal v-model="showSelectUpdateMediaModal" button="danger" buttonLabel="Close"
      :title="`Update media file at position ${update_media_form.index + 1}`">

      <form @submit.prevent="submitUpdateMediaFileForm" class="mt-5">
        <h6 class="text-sm italic font-semibold my-2 text-primary-100">Select a media file to upload. <br>Max size: 10MB. <br>Permitted files: jpeg,jpg,png,gif,mp4</h6>
        <div @click="selectUpdateMediaFiles" class="w-full h-[200px] relative border rounded border-gray-300  cursor-pointer">
          <div class="absolute top-0 bottom-0 right-0 left-0 m-auto h-[80px] w-[80px]  text-gray-400">
            <font-awesome-icon class="text-3xl" icon="fa-solid fa-file-circle-plus" />
            <h5 class="text-lg font-semibold" v-text="update_media_form.media ? 'Change file' : 'Select a new  file'"></h5>
          </div>
        </div>
        <input type="file" class="hidden"
              ref="update_medias"
              accept=".jpg, .png, .jpeg, .gif, .mp4"
              @change="updateMediaFiles">


        <div v-if="update_media_form.errors.media" class="my-2">
          <h5 class="text-xl">The following error occured</h5>
          <p class="text-red-500 italic my-3">{{ update_media_form.errors.media }}</p>
        </div>

        <div v-if="update_media_form.media" class="text-xs py-2 text-secondary-400 dark:text-slate-600 max-h-[140px] overflow-x-hidden">
          <h4 class="text-2xl font-bold text-center">Preview</h4>

          <img v-if="update_media_form.media.type == 'image/jpeg' || update_media_form.media.type == 'image/jpg' || update_media_form.media.type == 'image/png'" :src="update_media_form.media.preview" class="inline-block mr-1" alt="">

          <div v-else class="text-lg my-2">
            1 video file selected with name <span class="font-semibold text-primary-100">{{ update_media_form.media.name }}</span>
          </div>

        </div>
        <div :style="`width: ${update_media_form.progress ? update_media_form.progress.percentage : 0}%`" class="h-1 bg-gradient-to-r from-primary-100 via-purple-400 to-primary-200 my-2"></div>
        <button class="block w-full text-lg font-semibold text-center py-2 px-4 rounded bg-primary-100 text-white hover:bg-transparent hover:text-primary-100 transition-all ease-in-out duration-300 hover:border hover:border-primary-100" :class="update_media_form.processing ? 'opacity-60 cursor-not-allowed' : ''">Upload</button>
      </form>
    </CardBoxModal>

    <CardBoxModal v-model="showSelectNewMediaModal" button="danger" buttonLabel="Close"
      :title="`Add new media file`">

      <form @submit.prevent="submitNewMediaFileForm" class="mt-5">
        <h6 class="text-sm italic font-semibold my-2 text-primary-100">Select a media file to upload. <br>Max size: 10MB. <br>Permitted files: jpeg,jpg,png,gif,mp4</h6>
        <div @click="selectNewMediaFiles" class="w-full h-[200px] relative border rounded border-gray-300  cursor-pointer">
          <div class="absolute top-0 bottom-0 right-0 left-0 m-auto h-[80px] w-[80px]  text-gray-400">
            <font-awesome-icon class="text-3xl" icon="fa-solid fa-file-circle-plus" />
            <h5 class="text-lg font-semibold" v-text="new_media_form.media ? 'Change file' : 'Select a new  file'"></h5>
          </div>
        </div>
        <input type="file" class="hidden"
              ref="new_medias"
              accept=".jpg, .png, .jpeg, .gif, .mp4"
              @change="updateAddNewMediaFiles">


        <div v-if="new_media_form.errors.media" class="my-2">
          <h5 class="text-xl">The following error occured</h5>
          <p class="text-red-500 italic my-3">{{ new_media_form.errors.media }}</p>
        </div>

        <div v-if="new_media_form.media" class="text-xs py-2 text-secondary-400 dark:text-slate-600 max-h-[140px] overflow-x-hidden">
          <h4 class="text-2xl font-bold text-center">Preview</h4>

          <img v-if="new_media_form.media.type == 'image/jpeg' || new_media_form.media.type == 'image/jpg' || new_media_form.media.type == 'image/png'" :src="new_media_form.media.preview" class="inline-block mr-1" alt="">

          <div v-else class="text-lg my-2">
            1 video file selected with name <span class="font-semibold text-primary-100">{{ new_media_form.media.name }}</span>
          </div>

        </div>
        <div :style="`width: ${new_media_form.progress ? new_media_form.progress.percentage : 0}%`" class="h-1 bg-gradient-to-r from-primary-100 via-purple-400 to-primary-200 my-2"></div>
        <button class="block w-full text-lg font-semibold text-center py-2 px-4 rounded bg-primary-100 text-white hover:bg-transparent hover:text-primary-100 transition-all ease-in-out duration-300 hover:border hover:border-primary-100" :class="new_media_form.processing ? 'opacity-60 cursor-not-allowed' : ''">Upload</button>
      </form>
    </CardBoxModal>


  </LayoutSocial>
</template>

<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, reactive, onMounted, onUnmounted  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'

import FlashMessages from '@/Components/FlashMessages.vue'
import CardBoxModal from '@/Components/CardBoxModal.vue'

import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'
import Loader from '@/Loaders/loader.gif'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'
import FormLoaderDark from '@/Loaders/form_loader_dark.gif'
import FormLoaderLight from '@/Loaders/form_loader_light.gif'

const props = defineProps({

});

const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()
const auth_user = page.props.auth.user

const login_btn_hovered = ref(false);
const loading = ref(false);

const post_medias = ref(null);

// console.log(mainStore.user_following[0].following_details)



const submit = () => {


  Swal.fire({
    title: `You are about to modify your community history. Do you wish to proceed?`,
    html: '',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes Proceed!',
  }).then((result) => {

    if (result.isConfirmed) {
      proceedSubmit()

    } else if (result.isDenied) {
      // Swal.fire('Changes are not saved', '', 'info')
    }
  })
}

const proceedSubmit = async () => {

try {

  console.log(mainStore.community_details_global.community_details.history)

  Swal.fire({
    title: 'Please wait',
    html: `Submitting your history modifications.....`,
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });

  loading.value = true;


  let queryRoute = route('community.modify_history', mainStore.community_details_global.community_details.id);

  const response = await axios.post(queryRoute, null, { params: {history: mainStore.community_details_global.community_details.history} });

  console.log(response)
  Swal.close()

  loading.value = false;
  if (response.data.success) {


    mainStore.toast = `History modified successfully`;

    setTimeout(() => {
      document.location.reload()
    }, 2000);
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
  loading.value = false;

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

const photo_form = useForm({
  image: null
})

const selectPhotoFiles = () => {
  post_medias.value.click();
}

const updateAddPhotoFiles = (event) => {
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
      photo_form.image = file
    }, 500);


}

const submitPhotoForm = () => {

if (!photo_form.processing) {
  photo_form.post(route('community.upload_new_gallery_image'), {
    preserveScroll: true,
    onSuccess: (page) => {

      var response = page.props.flash.data;
      if (response.success) {

        mainStore.toast = 'Image uploaded successfully'

        setTimeout(() => {
          document.location.reload()
        }, 2000);

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
  <CardBoxModal v-model="mainStore.show_upload_community_image_modal" button="danger" buttonLabel="Close"
      :title="`Upload new gallery image`">

      <form @submit.prevent="submitPhotoForm" class="mt-5">
        <h6 class="text-sm italic font-semibold my-2 text-primary-100">Select an image to upload. Max size: 3MB</h6>
        <div @click="selectPhotoFiles" class="w-full h-[200px] relative border rounded border-gray-300  cursor-pointer">
          <div class="absolute top-0 bottom-0 right-0 left-0 m-auto h-[80px] w-[80px]  text-gray-400">
            <font-awesome-icon class="text-3xl" icon="fa-solid fa-file-circle-plus" />
            <h5 class="text-lg font-semibold" v-text="photo_form.image ? 'Change image' : 'Select an image'"></h5>
          </div>
        </div>
        <input type="file" class="hidden"
              ref="post_medias"
              accept=".jpg, .png, .jpeg"
              @change="updateAddPhotoFiles">


        <div v-if="photo_form.errors.image" class="my-2">
          <h5 class="text-xl">The following error occured</h5>
          <p class="text-red-500 italic my-3">{{ photo_form.errors.image }}</p>
        </div>

        <div v-if="photo_form.image" class="text-xs py-2 text-secondary-400 dark:text-slate-600 max-h-[140px] overflow-x-hidden">
          <h4 class="text-2xl font-bold text-center">Preview</h4>

          <img v-if="photo_form.image.type == 'image/jpeg' || photo_form.image.type == 'image/jpg' || photo_form.image.type == 'image/png'" :src="photo_form.image.preview" class="inline-block mr-1" alt="">

        </div>
        <div :style="`width: ${photo_form.progress ? photo_form.progress.percentage : 0}%`" class="h-1 bg-gradient-to-r from-primary-100 via-purple-400 to-primary-200 my-2"></div>
        <button class="form-button" :class="photo_form.processing ? 'opacity-60 cursor-not-allowed' : ''">Upload</button>
      </form>

    </CardBoxModal>
</template>

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
</script>

<template>
  <div v-if="mainStore.show_manage_community_history_modal"  class="fixed top-0 bottom-0 left-0 right-0 z-[1000] ">
    <div @click.stop="mainStore.closeCommunityHistoryModal" class="h-screen w-screen bg-gradient-to-br from-slate-600/60 via-slate-700/60 to-slate-800/60 dark:bg-slate-900/80">

    </div>


    <div class="absolute m-auto min-h-fit sm:max-h-[90%] md:max-h-[55%] lg:max-h-[90%]  top-0 bottom-0 left-0 right-0 bg-white dark:bg-slate-700 sm:w-4/12 w-full   z-[1050] rounded-xl flex dark:text-slate-300">
      <div class="text-center w-full text-sm mx-4 my-5">

        <h3 class="text-xl font-bold mb-6">Community History</h3>
        <form @submit.prevent="submit" class="mt-[20px]">
          <h4 class="text-sm font-semibold text-left my-2">Mange community history</h4>
          <div class="mb-2 transition-all ease-linear duration-200">


            <textarea class="w-full rounded-lg p-2 text-sm h-[220px]" id="history" v-model="mainStore.community_details_global.community_details.history">

            </textarea>
          </div>



          <button name="login-btn" :class="loading ? 'opacity-80 cursor-not-allowed' : ''"
            @mouseleave="login_btn_hovered = false" @mouseover="login_btn_hovered = true" type="submit"
            class="login-button mt-[40px] uppercase ">
            Save
            <img v-if="loading" class="inline-block w-7 h-6 float-right"
              :src="login_btn_hovered ? FormLoaderDark : FormLoaderLight" alt="">
          </button>
        </form>


        <div @click="mainStore.closeCommunityHistoryModal" class="py-3 divider border-0">
          <span class="text-red-500">
            Cancel
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

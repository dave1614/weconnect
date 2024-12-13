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

});

const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()
const auth_user = page.props.auth.user

// console.log(mainStore.user_following[0].following_details)

const removeCommunityLeaderRequest = () => {
  Swal.fire({
    title: `You are about to remove your request to become a leader of your community? Do you wish to proceed?`,
    html: '',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes Proceed!',
  }).then((result) => {

    if (result.isConfirmed) {
      proceedRemoveCommunityLeaderRequest()

    } else if (result.isDenied) {
      // Swal.fire('Changes are not saved', '', 'info')
    }
  })
}

const proceedRemoveCommunityLeaderRequest = async () => {

try {

  Swal.fire({
    title: 'Please wait',
    html: `Removing your request.....`,
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });


  let queryRoute = route('community.remove_leader_request');

  const response = await axios.post(queryRoute, null, { params: {'remove_request': true} });

  console.log(response)
  Swal.close()

  if (response.data.success) {


    mainStore.toast = `Your request has been removed successfully`;
    mainStore.community_details_global.user.community_leader_pending = 0;
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

const resignAsCommunityLeader = () => {
  Swal.fire({
    title: `You are about to resign as ${mainStore.community_details_global.position} of your community? Do you wish to proceed?`,
    html: '<b class="text-primary-100">Note: This process is irreversible</b>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes Proceed!',
  }).then((result) => {

    if (result.isConfirmed) {
      proceedResignAsCommunityLeader()

    } else if (result.isDenied) {
      // Swal.fire('Changes are not saved', '', 'info')
    }
  })
}

const proceedResignAsCommunityLeader = async () => {

try {

  Swal.fire({
    title: 'Please wait',
    html: `Processsing your resignation.....`,
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });


  let queryRoute = route('community.resign_leader_request');

  const response = await axios.post(queryRoute, null, { params: {'resign_request': true} });

  console.log(response)
  Swal.close()

  if (response.data.success) {


    mainStore.toast = `Your request to resign from your community leader position has been granted successfully`;
    mainStore.community_details_global.user.community_leader = 0;
    mainStore.community_details_global.position = 'subject';
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
  <div v-if="mainStore.show_community_more_options_modal"  class="fixed top-0 bottom-0 left-0 right-0 z-[1000] ">
    <div @click.stop="mainStore.closeCommunityMoreOptionsModal" class="h-screen w-screen bg-gradient-to-br from-slate-600/60 via-slate-700/60 to-slate-800/60 dark:bg-slate-900/80">

    </div>


    <div class="absolute m-auto min-h-fit sm:max-h-[90%] md:max-h-[55%] lg:max-h-[90%]  top-0 bottom-0 left-0 right-0 bg-white dark:bg-slate-700 sm:w-4/12 w-full   z-[1050] rounded-xl flex dark:text-slate-300">
      <div class="text-center w-full text-sm">
        <div v-if="mainStore.community_details_global.position != 'visitor'" class="py-3 divider" :class="mainStore.community_details_global.loading ? 'opacity-50 cursor-not-allowed' : ''">
          <span class="font-bold" >
            <span @click="resignAsCommunityLeader" v-if="mainStore.community_details_global.user.community_leader" class="text-red-500">Resign As Community Leader ({{ mainStore.community_details_global.position }})</span>
            <span @click="removeCommunityLeaderRequest" v-else-if="mainStore.community_details_global.user.community_leader_pending" class="text-red-500">Remove Community Leader Request</span>
            <span @click="mainStore.applyAsCommunityLeader" v-else-if="mainStore.community_details_global.position == 'subject'" class="text-primary-100">Apply As Community Leader</span>
          </span>
        </div>

        <div v-if="mainStore.community_details_global.user.community_leader" @click="mainStore.manageCommunityHistory" class="py-3 divider">
          <span class="" >
            <span class="">Manage Community History</span>

          </span>
        </div>

        <div  @click="mainStore.viewCommunityHistory(mainStore.community_details_global.community.id)" class="py-3 divider">
          <span class="" >
            <span class="">View Community History</span>

          </span>
        </div>

        <div v-if="mainStore.community_details_global.user.community_leader" @click="mainStore.newCommunityGalleryImage" class="py-3 divider">
          <span class="" >
            <span class="">Upload New Gallery Image</span>

          </span>
        </div>




        <div @click="mainStore.loadAllCommunityLeaders(mainStore.community_details_global.community.id)" class="py-3 divider">
          <span class="" >
            <span class="">View Community Leaders</span>

          </span>
        </div>

        <div @click="mainStore.loadAllCommunityResidents(mainStore.community_details_global.community.id)" class="py-3 divider">
          <span class="" >
            <span class="">View Community Residents</span>

          </span>
        </div>


        <div @click="mainStore.closeCommunityMoreOptionsModal" class="py-3 divider border-0">
          <span class="text-red-500">
            Cancel
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

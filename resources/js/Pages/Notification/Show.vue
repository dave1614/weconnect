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
import CardBox from '@/Components/CardBox.vue'
import BaseButton from '@/Components/BaseButton.vue'
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";


import Post from '@/Components/Social/Post.vue'
import PostPopup from '@/Components/Social/PostPopup.vue'


import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'
import { useAxios } from '@/composables/axios.js'

import {

  mdiEmailNewsletter,
  mdiCurrencyUsd,
  mdiClose,
  mdiClipboardText,
  mdiAccountCash,
  mdiImageMove,
  mdiClipboard,
  mdiRefresh,
  mdiViewListOutline,
  mdiGithub,

} from "@mdi/js";

const props = defineProps({
  notification: {
    type: Object,
    default: {},
  },
  auth_user: {
    type: Object,
  },


});



const notification = ref(props.notification);
const auth_user = ref(props.auth_user);



const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()



onMounted(() => {

})

const show_drop = ref(false);



</script>

<template>
  <Head :title="`Notification from ${notification.data.from} with subject '${notification.data.subject}'`" />
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
              <div class="mt-[50px]">
                <SectionTitleLineWithButton :icon="mdiEmailNewsletter" :title="`${notification.data.subject}`" main>
                  <!-- <BaseButton
                  href="https://github.com/justboil/admin-one-vue-tailwind"
                  target="_blank"
                  :icon="mdiGithub"
                  label="Star on GitHub"
                  color="contrast"
                  rounded-full
                  small
                /> -->
                </SectionTitleLineWithButton>


                <div class="bg-gray-100 dark:bg-slate-800 rounded-xl shadow-md py-4 px-3">
                  <h4 class="text-xl text-gray-500 font-semibold">From: {{ notification.data.from }}</h4>


                  <div class="btn-group">
                    <button type="button" class="bg-green-400 px-6 py-3  shadow-lg text-white font-bold rounded-l-md text-xs">To: ME</button>
                    <button @click="show_drop = !show_drop" type="button" class="mt-[1px] bg-green-400 px-6 py-2 shadow-lg text-white font-bold rounded-r-md dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                      <font-awesome-icon icon="fa-solid fa-caret-down text-xs" />
                    </button>
                    <ul class="dropdown-menu " :class="show_drop ? 'block' : 'hidden'">
                      <li><a class="dropdown-item" href="#"><b>from:</b> {{ notification.data.from }}</a></li>
                      <li><a class="dropdown-item" href="#"><b>reply-to:</b>{{ notification.data.from }}</a></li>
                      <li><a class="dropdown-item" href="#"><b>to:</b> {{ notification.data.to }}</a></li>
                      <!-- <li><hr class="dropdown-divider"></li> -->
                      <li><a class="dropdown-item " href="#"><b>date:</b> {{ notification.date }}</a></li>
                      <li><a class="dropdown-item" href="#"><b>time:</b> {{ notification.time }}</a></li>
                      <li><a class="dropdown-item" href="#"><b>status:</b> read</a></li>
                      <li><a class="dropdown-item" href="#"><b>read at:</b> {{ notification.read_at_str }}</a></li>
                    </ul>
                  </div>

                  <div class="my-2">
                    <p class="text-sm">
                      <p class="text-lg font-semibold">{{ notification.data.greeting }}, </p>

                      <div class=" my-2" v-html="notification.data.first_message">

                      </div>

                      <div class="my-3 mb-2">
                        <div v-for="(btn, index) in notification.data.action_button" class="" :key="index">
                          <BaseButton v-if="btn[0] != 'Login'" target="_blank" :href="btn[1]" type="button" :color="index == 0 ? 'bg-green-600' : index == 1 ? 'bg-blue-500' : 'bg-orange-500'" :label="btn[0]" class=" text-white" />
                        </div>
                      </div>

                      <p class="mt-5">
                        {{ notification.data.closing_message }}
                      </p>
                    </p>
                  </div>
                </div>

              </div>
            </div>
          </div>


        </div>

      </div>
    </div>


  </LayoutSocial>
</template>

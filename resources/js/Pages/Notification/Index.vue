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
import BaseButtons from '@/Components/BaseButtons.vue'
import BaseLevel from '@/Components/BaseLevel.vue'

import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";


import Post from '@/Components/Social/Post.vue'
import PostPopup from '@/Components/Social/PostPopup.vue'


import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'
import { useAxios } from '@/composables/axios.js'

import {
  mdiBell,
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
  notis: {
    type: Object,
    default: {},
  },
  auth_user: {
    type: Object,
  },


});



const notis = ref(props.notis);
const auth_user = ref(props.auth_user);
console.log(notis.value)


const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()



onMounted(() => {

})

const show_drop = ref(false);



</script>

<template>
  <Head :title="`Your Notifications`" />
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
                <SectionTitleLineWithButton :icon="mdiBell" :title="`Notifications`" main>
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


                <div class="">
                  <div v-if="notis.data.length > 0" class="">

                    <div @click="router.visit(route('notification.show', noti.id))" v-for="(noti, index) in notis.data" class="my-3 mx-1 rounded-lg px-4 py-3  cursor-pointer" :class="noti.read_at == null ? 'bg-gray-300 dark:bg-slate-600' : 'bg-gray-100 dark:bg-slate-400'" :key="index">
                      <div class="">
                        <h5 class="text-sm font-semibold inline-block">{{ mainStore.truncateStr(noti.data.subject, 40) }}</h5>

                        <span class="text-xs font-bold float-right">{{ noti.social_time }}</span>
                      </div>

                      <span class="text-xs">{{ mainStore.truncateStr(mainStore.stripHtml(noti.data.first_message), 100) }}</span>
                    </div>

                    <div class="p-3 lg:px-6 border-t border-gray-100 ">
                      <BaseLevel>
                        <BaseButtons>
                          <BaseButton v-for="page in notis.links" :key="page" :active="page.active" :label="page.label"
                            :color="page.active ? 'lightDark' : 'whiteDark'" small :href="page.url"
                            :disabled="page.url === null" />
                        </BaseButtons>
                        <small>Page {{ notis.current_page }} of {{ notis.last_page }}</small>
                        <small>{{ notis.total }} total notifications</small><br>
                      </BaseLevel>
                    </div>
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

<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, reactive, onMounted, onUnmounted  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'

import FlashMessages from '@/Components/FlashMessages.vue'
import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'
import Loader from '@/Loaders/loader.gif'

const props = defineProps({

});

const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage();
const user = page.props.auth.user;

const notifications = ref(page.props.notifications)
const notifications_num = ref(page.props.notifications_num)
console.log(notifications.value)

const collapse_nav_padding = ref(window.scrollY >= 10 ? true : false);

onMounted(() => window.addEventListener('scroll', update))
onUnmounted(() => window.removeEventListener('scroll', update))

const update = (event) => {
  collapse_nav_padding.value = window.scrollY >= 10 ? true : false;
}


const openNoti = (id) => {
  mainStore.hideNotiBox()
  router.visit(route('notification.show', id))
}

const searchFocusEvt = () => {
  mainStore.showSearchBox()
}


const search_form = useForm({
  search: null
})

const searchBoxHeadingText = computed(() => {
  var text = "";
  if(mainStore.search_value == ""){
    text = "Recent";
  }else{
    if(mainStore.search_loading){
      text = `Searching for <em class='text-primary-100'>${mainStore.search_value}</em>`
    }else{
      text = `Search results for <em class='text-primary-100'>${mainStore.search_value}</em>`
    }
  }
  return text;
})

const proceedToSearchResults = (search) => {
  if(search_form.processing){
    return
  }

  // var errors = getMediaErrors();
  // if(errors.length > 0){
  //   presentMediaErrors(errors)
  //   return;
  // }

  search_form.search = search;
  let url = route('search.store');
  search_form.post(url, {
    preserveScroll: true,
    onSuccess: (page) => {

      var response = page.props.flash.data;
      console.log(response)
      if (response.success) {
        let ret_url = "";
        if(search.type == "user"){

          ret_url = route('profile.show', search.searched_user.slug);
        }else if(search.type == "tag"){

          ret_url = route('tag.show', search.search.slice(1));

        }else{
          ret_url = route('search.show') + '?search='+search.search;
        }

        mainStore.hideSearchFormBox();
        mainStore.hideSearchBox()
        mainStore.search_value = ""
        router.visit(ret_url)
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `Something went wrong`,
        })
      }
    }, onError: (errors) => {
      console.log(errors)


      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: `Something went wrong`,
      })



    },
  });

}
</script>

<template>
  <div class="w-full inline-block relative">

    <div @click="mainStore.toggleSidebar" class="transition-all ease-linear duration-500 fixed top-0 bottom-0 h-screen w-screen z-20" :class="mainStore.sidebar_open ? 'bg-black opacity-50': 'hidden'"></div>

    <div class="md:w-1/12 lg:w-3/12 w-0 inline-block">

    </div>

    <div class="md:w-11/12 lg:w-9/12 w-full h-[21px] inline-block">
      <nav :class="collapse_nav_padding ? 'py-3' : 'py-6'" class="bg-white dark:bg-slate-700 px-5 border-b-[1px] border-secondary-300 dark:border-slate-500 fixed md:w-11/12 lg:w-9/12 w-full transition-all ease-linear duration-300 shadow-sm z-10">
        <div class="hidden sm:grid grid-cols-12 gap-6">
          <div class="col-span-7">
            <form @submit.prevent="null">
              <div class="relative text-secondary-400">
                <font-awesome-icon icon="fa-solid fa-magnifying-glass" class="absolute top-0 bottom-0 my-auto text-secondary-200" />
                <input @focus="searchFocusEvt" v-model="mainStore.search_value" type="text" class="w-full border-0 text-sm pl-7 focus:outline-0 focus:outline-none focus:ring-0 bg-transparent dark:text-gray-200" placeholder="Search....">
              </div>

              <div @click="mainStore.hideSearchBox" v-if="mainStore.show_search_box" class="fixed left-0 right-0 top-0 bottom-0 bg-transparent opacity-15 w-screen h-screen"></div>

              <div v-if="mainStore.show_search_box" class="absolute mt-[30px] z-[500] sm:w-8/12 w-full">

                <div class="bg-white w-full  rounded-lg shadow dark:bg-slate-700 dark:text-secondary-300">
                  <div class="py-2 px-2 border-b border-b-gray-300 grid grid-cols-12 gap-6">
                    <span class="font-semibold col-span-10" v-html="searchBoxHeadingText"></span>

                    <span @click="mainStore.deleteAllRecentSearches" v-if="mainStore.search_value == '' && !mainStore.deleting_all_recent" class="text-primary-100 font-semibold cursor-pointer col-span-2 float-right">Clear all</span>

                    <div  v-if="mainStore.search_value == '' && mainStore.deleting_all_recent" class="col-span-2">
                      <img class="inline-block  w-9 h-9 float-right" :src="Loader" alt="">
                    </div>

                  </div>
                  <div class="h-[300px] overflow-x-hidden px-2 py-2">
                    <div v-if="mainStore.search_value == ''" class="">
                      <div v-if="mainStore.recent_search_loading" class="flex justify-center">
                        <img class="w-[50px] h-[50px]  inline-block" :src="Loader" alt="">
                      </div>
                      <div v-else class="">
                        <div v-if="mainStore.recent_searches.length > 0" class="">
                          <div @click="proceedToSearchResults(recent)" class="grid grid-cols-12 gap-6 my-3 px-2 py-2 cursor-pointer hover:bg-gray-200 dark:hover:bg-slate-800" v-for="(recent, index) in mainStore.recent_searches" :key="index">
                            <div class="col-span-2">
                              <div v-if="recent.type == 'user'" class="">
                                <img :src="recent.searched_user.profile_picture" alt="" class="rounded-full w-[45px] h-[45px]">
                              </div>

                              <div v-else class="rounded-full w-[45px] h-[45px] bg-slate-200 dark:bg-slate-600 p-2">
                                <font-awesome-icon v-if="recent.type == 'search'" class="ml-2 mt-2" icon="fa-solid fa-magnifying-glass" />
                                <font-awesome-icon v-else class="ml-2 mt-2" icon="fa-solid fa-hashtag" />
                              </div>
                            </div>

                            <div class="col-span-8">
                              <h4 class="text-sm font-semibold">
                                <span v-if="recent.type == 'user'">{{ recent.searched_user.user_name }}</span>
                                <span v-else>{{ recent.search }}</span>
                              </h4>

                              <h4 v-if="recent.type == 'user'" class="text-sm  text-gray-400">
                                {{ recent.searched_user.name }} •
                                <span v-if="recent.searched_user.following_status"> Following</span>
                                <span v-else> {{ mainStore.convertNumberToKOrMorB(recent.searched_user.followers_num) }} Followers</span>
                              </h4>

                            </div>

                            <div class="col-span-2 ">
                              <font-awesome-icon @click="mainStore.clearSingleRecentSearch(index)" v-if="!recent.deleting_search" class="text-lg cursor-pointer float-right" icon="fa-solid fa-xmark" />

                              <img v-else class="w-[40px] h-[40px]  inline-block float-right" :src="Loader" alt="">
                            </div>
                          </div>
                        </div>
                        <div  class="text-center">
                          <h5 class="text-orange-500 font-semibold">No recent searches</h5>
                        </div>
                      </div>
                    </div>
                    <div v-else class="">
                      <div v-if="mainStore.search_loading" class="flex justify-center">
                        <img class="w-[50px] h-[50px]  inline-block" :src="Loader" alt="">
                      </div>
                      <div v-else class="">
                        <div v-if="mainStore.search_results.length > 0" class="">
                          <div @click="proceedToSearchResults(search)" class="grid grid-cols-12 gap-6 my-3 px-2 py-2 cursor-pointer hover:bg-gray-200 dark:hover:bg-slate-800" v-for="(search, index) in mainStore.search_results" :key="index">
                            <div class="col-span-2">
                              <div v-if="search.type == 'user'" class="">
                                <img :src="search.searched_user.profile_picture" alt="" class="rounded-full w-[45px] h-[45px]">
                              </div>

                              <div v-else class="rounded-full w-[45px] h-[45px] bg-slate-200 dark:bg-slate-600  p-2">
                                <font-awesome-icon v-if="search.type == 'search'" class="ml-2 mt-2" icon="fa-solid fa-magnifying-glass" />
                                <font-awesome-icon v-else class="ml-2 mt-2" icon="fa-solid fa-hashtag" />
                              </div>
                            </div>

                            <div class="col-span-8">
                              <h4 class="text-sm font-semibold">
                                <span v-if="search.type == 'user'">{{ search.searched_user.user_name }}</span>
                                <span v-else>{{ search.search }}</span>
                              </h4>

                              <h4 v-if="search.type == 'user'" class="text-sm  text-gray-400">
                                {{ search.searched_user.name }} •
                                <span v-if="search.searched_user.following_status"> Following</span>
                                <span v-else> {{ mainStore.convertNumberToKOrMorB(search.searched_user.followers_num) }} Followers</span>
                              </h4>

                            </div>

                            <div class="col-span-2 ">

                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                  </div>

                </div>

              </div>
            </form>
          </div>

          <div class="col-span-5 px-2 pr-7">
            <div class="mt-[5px] float-right">
              <font-awesome-icon @click="mainStore.toggleNotiBox()" class="nav-icons" icon="fa-regular fa-bell" />

              <div @click="mainStore.hideNotiBox" v-if="mainStore.show_noti_box" class="fixed left-0 right-0 top-0 bottom-0 bg-transparent opacity-15 w-screen h-screen"></div>
              <div v-if="mainStore.show_noti_box" class="absolute mt-[30px] z-[500]">
                <div class="w-0 h-0 border-l-[7px] border-l-transparent border-r-[7px] border-r-transparent border-b-[15px]  border-b-white dark:border-b-slate-700 ml-3">

                </div>

                <div class="bg-white w-[250px]  rounded-lg shadow dark:bg-slate-700 dark:text-secondary-300">
                  <div class="py-2 px-2 border-b border-b-gray-300">
                    <span class="font-semibold">Notifications</span>
                  </div>
                  <div class="h-[250px] overflow-x-hidden px-2 py-2">
                    <div v-if="notifications.length > 0" class="">
                      <div @click="openNoti(noti.id)" v-for="(noti, index) in notifications" class="my-1 mx-1 rounded-lg px-2 py-1  cursor-pointer" :class="noti.read_at == null ? 'bg-gray-300 dark:bg-slate-600' : 'bg-gray-100 dark:bg-slate-400'" :key="index">
                        <div class="">
                          <h5 class="text-sm font-semibold inline-block">{{ mainStore.truncateStr(noti.data.subject, 40) }}</h5>

                          <span class="text-xs font-bold float-right">{{ noti.social_time }}</span>
                        </div>

                        <span class="text-xs">{{ mainStore.truncateStr(mainStore.stripHtml(noti.data.first_message), 100) }}</span>
                      </div>
                    </div>
                    <div v-else class="">
                      <div class="bg-orange-200 rounded px-3 py-3">
                        <span class="text-orange-600 text-sm">No notifications found</span>
                      </div>
                    </div>
                  </div>
                  <div class="px-3 py-2 border-t border-gray-300">
                    <Link class="rounded-full px-4 py-2 bg-transparent border border-primary-100 text-primary-100 block text-sm text-center hover:text-white hover:bg-primary-100 transition-all ease-in-out duration-300" :href="route('notification.index')">All Notifications ({{ notifications_num }})</Link>
                  </div>
                </div>

              </div>
              <font-awesome-icon @click="darkModeStore.set()" class="nav-icons"  icon="fa-solid fa-circle-half-stroke" title="Toggle dark mode" />
              <!-- <font-awesome-icon class="nav-icons" icon="fa-regular fa-bell" /> -->
              <font-awesome-icon @click="router.post('logout')" class="nav-icons" icon="fa-solid fa-arrow-right-from-bracket" />

              <Link :href="route('profile.show', user.slug)" class="ml-7">
                <img  class="w-6 inline-block mt-[-10px] mr-1 rounded-full" :src="user.profile_picture"/>
                <span class="hidden lg:inline-block text-xs font-semibold mt-[-10px] dark:text-secondary-300">@{{ user.user_name }}</span>
              </Link>
            </div>
          </div>
        </div>

        <div class="sm:hidden block relative">

          <div class="grid grid-cols-12 gap-6">
            <font-awesome-icon @click="mainStore.toggleSidebar()" class="nav-icons ml-3" icon="fa-solid fa-bars" />
            <font-awesome-icon  @click="mainStore.toggleSearchFormBox()" class="nav-icons" icon="fa-solid fa-magnifying-glass" />

            <div v-if="mainStore.show_form_box" class="w-full absolute bg-white rounded-md min-h-[50px] mt-[70px] dark:bg-slate-700">
              <form @submit.prevent="null">
                <input @focus="searchFocusEvt" v-model="mainStore.search_value" type="text" class="rounded-full py-1 px-3 my-2 mx-2 w-[95%] bg-transparent dark:text-slate-300 dark:border-slate-300" placeholder="Search.....">
              </form>
            </div>

            <div @click="mainStore.hideSearchBox" v-if="mainStore.show_search_box" class="fixed left-0 right-0 top-0 bottom-0 bg-transparent opacity-15 w-screen h-screen"></div>

            <div v-if="mainStore.show_search_box" class="absolute mt-[130px] z-[500] sm:w-8/12 w-full">

              <div class="bg-white w-full  rounded-lg shadow dark:bg-slate-700 dark:text-secondary-300">
                <div class="py-2 px-2 border-b border-b-gray-300 grid grid-cols-12 gap-6 text-xs">
                  <span class="font-semibold col-span-9" v-html="searchBoxHeadingText"></span>

                  <span @click="mainStore.deleteAllRecentSearches" v-if="mainStore.search_value == '' && !mainStore.deleting_all_recent" class="text-primary-100 font-semibold cursor-pointer col-span-3 float-right">Clear all</span>

                  <div  v-if="mainStore.search_value == '' && mainStore.deleting_all_recent" class="col-span-3">
                    <img class="inline-block  w-9 h-9 float-right" :src="Loader" alt="">
                  </div>

                </div>
                <div class="h-[300px] overflow-x-hidden px-2 py-2">
                  <div v-if="mainStore.search_value == ''" class="">
                    <div v-if="mainStore.recent_search_loading" class="flex justify-center">
                      <img class="w-[50px] h-[50px]  inline-block" :src="Loader" alt="">
                    </div>
                    <div v-else class="">
                      <div v-if="mainStore.recent_searches.length > 0" class="">
                        <div @click="proceedToSearchResults(recent)" class="grid grid-cols-12 gap-6 my-3 px-2 py-2 cursor-pointer hover:bg-gray-200 dark:hover:bg-slate-800" v-for="(recent, index) in mainStore.recent_searches" :key="index">
                          <div class="col-span-3">
                            <div v-if="recent.type == 'user'" class="">
                              <img :src="recent.searched_user.profile_picture" alt="" class="rounded-full w-[45px] h-[45px]">
                            </div>

                            <div v-else class="rounded-full w-[45px] h-[45px] bg-slate-200 dark:bg-slate-600  p-2">
                              <font-awesome-icon v-if="recent.type == 'search'" class="ml-2 mt-2" icon="fa-solid fa-magnifying-glass" />
                              <font-awesome-icon v-else class="ml-2 mt-2" icon="fa-solid fa-hashtag" />
                            </div>
                          </div>

                          <div class="col-span-8">
                            <h4 class="text-sm font-semibold">
                              <span v-if="recent.type == 'user'">{{ recent.searched_user.user_name }}</span>
                              <span v-else>{{ recent.search }}</span>
                            </h4>

                            <h4 v-if="recent.type == 'user'" class="text-sm  text-gray-400">
                              {{ recent.searched_user.name }} •
                              <span v-if="recent.searched_user.following_status"> Following</span>
                              <span v-else> {{ mainStore.convertNumberToKOrMorB(recent.searched_user.followers_num) }} Followers</span>
                            </h4>

                          </div>

                          <div class="col-span-1 ">
                            <font-awesome-icon @click="mainStore.clearSingleRecentSearch(index)" v-if="!recent.deleting_search" class="text-lg cursor-pointer float-right" icon="fa-solid fa-xmark" />

                            <img v-else class="w-[40px] h-[40px]  inline-block float-right" :src="Loader" alt="">
                          </div>
                        </div>
                      </div>
                      <div  class="text-center">
                        <h5 class="text-orange-500 font-semibold">No recent searches</h5>
                      </div>
                    </div>
                  </div>
                  <div v-else class="">
                    <div v-if="mainStore.search_loading" class="flex justify-center">
                      <img class="w-[50px] h-[50px]  inline-block" :src="Loader" alt="">
                    </div>
                    <div v-else class="">
                      <div v-if="mainStore.search_results.length > 0" class="">
                        <div @click="proceedToSearchResults(search)" class="grid grid-cols-12 gap-6 my-3 px-2 py-2 cursor-pointer hover:bg-gray-200 dark:hover:bg-slate-800" v-for="(search, index) in mainStore.search_results" :key="index">
                          <div class="col-span-3">
                            <div v-if="search.type == 'user'" class="">
                              <img :src="search.searched_user.profile_picture" alt="" class="rounded-full w-[45px] h-[45px]">
                            </div>

                            <div v-else class="rounded-full w-[45px] h-[45px] bg-slate-200 dark:bg-slate-600  p-2">
                              <font-awesome-icon v-if="search.type == 'search'" class="ml-2 mt-2" icon="fa-solid fa-magnifying-glass" />
                              <font-awesome-icon v-else class="ml-2 mt-2" icon="fa-solid fa-hashtag" />
                            </div>
                          </div>

                          <div class="col-span-8">
                            <h4 class="text-sm font-semibold">
                              <span v-if="search.type == 'user'">{{ search.searched_user.user_name }}</span>
                              <span v-else>{{ search.search }}</span>
                            </h4>

                            <h4 v-if="search.type == 'user'" class="text-sm  text-gray-400">
                              {{ search.searched_user.name }} •
                              <span v-if="search.searched_user.following_status"> Following</span>
                              <span v-else> {{ mainStore.convertNumberToKOrMorB(search.searched_user.followers_num) }} Followers</span>
                            </h4>

                          </div>


                        </div>
                      </div>

                    </div>
                  </div>

                </div>

              </div>

            </div>


            <font-awesome-icon @click="mainStore.toggleNotiBox()" class="nav-icons" icon="fa-regular fa-bell" />

            <div @click="mainStore.hideNotiBox" v-if="mainStore.show_noti_box" class="fixed left-0 right-0 top-0 bottom-0 bg-transparent opacity-15 w-screen h-screen"></div>

            <div v-if="mainStore.show_noti_box" class="absolute mt-[50px] ">


              <div class="bg-white w-full  rounded-lg shadow dark:bg-slate-700 dark:text-secondary-300">
                <div class="py-2 px-2 border-b border-b-gray-300">
                  <span class="font-semibold">Notifications</span>
                </div>
                <div class="h-[250px] overflow-x-hidden px-2 py-2">
                  <div v-if="notifications.length > 0" class="">
                    <div @click="openNoti(noti.id)" v-for="(noti, index) in notifications" class="my-1 mx-1 rounded-lg px-2 py-1  cursor-pointer" :class="noti.read_at == null ? 'bg-gray-300 dark:bg-slate-600' : 'bg-gray-100 dark:bg-slate-400'" :key="index">
                      <div class="">
                        <h5 class="text-sm font-semibold inline-block">{{ mainStore.truncateStr(noti.data.subject, 40) }}</h5>

                        <span class="text-xs font-bold float-right">{{ noti.social_time }}</span>
                      </div>

                      <span class="text-xs">{{ mainStore.truncateStr(mainStore.stripHtml(noti.data.first_message), 100) }}</span>
                    </div>
                  </div>
                  <div v-else class="">
                    <div class="bg-orange-200 rounded px-3 py-3">
                      <span class="text-orange-600 text-sm">No notifications found</span>
                    </div>
                  </div>
                </div>
                <div class="px-3 py-2 border-t border-gray-300">
                  <Link class="rounded-full px-4 py-2 bg-transparent border border-primary-100 text-primary-100 block text-sm text-center hover:text-white hover:bg-primary-100 transition-all ease-in-out duration-300" :href="route('notification.index')">All Notifications ({{ notifications_num }})</Link>
                </div>
              </div>

            </div>
            <font-awesome-icon @click="darkModeStore.set()" class="nav-icons"  icon="fa-solid fa-circle-half-stroke" title="Toggle dark mode" />
            <font-awesome-icon class="nav-icons" icon="fa-solid fa-gear" />
            <!-- <font-awesome-icon class="nav-icons" icon="fa-solid fa-arrow-right-from-bracket" /> -->

            <Link href="" class="nav-icons p-0 mx-1 inline-block mt-0 bg-transparent">
              <img  class="w-8 h-8 inline-block  rounded-full" :src="user.profile_picture"/>
            </Link>
          </div>
        </div>
      </nav>


    </div>
  </div>
</template>

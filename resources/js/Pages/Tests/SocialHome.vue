<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref, onMounted, onUnmounted  } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'
import FormLoaderDark from '@/Loaders/form_loader_dark.gif'
import FormLoaderLight from '@/Loaders/form_loader_light.gif'
import FlashMessages from '@/Components/FlashMessages.vue'
import { useDarkModeStore } from '@/Stores/darkMode.js'
import { useMainStore } from '@/Stores/main.js'

import SecondLoginImage from '@/Images/second_login.jpg'
import Avatar from '@/Images/avatar.jpg'

const props = defineProps({

});

const darkModeStore = useDarkModeStore()
const mainStore = useMainStore()

const page = usePage()

const sidebar_open = ref(false);
const max_post_length = ref(3000);
const show_more = ref(false);
const rem_chars = ref(max_post_length.value);
const create_post_input_fcsd = ref(false);
const collapse_nav_padding = ref(window.scrollY >= 10 ? true : false);

onMounted(() => window.addEventListener('scroll', update))
onUnmounted(() => window.removeEventListener('scroll', update))

const update = (event) => {
  collapse_nav_padding.value = window.scrollY >= 10 ? true : false;
}

const make_post_form = useForm({
  input: null,
})


const toggleSidebar = () => {
  sidebar_open.value = !sidebar_open.value;
}

const sideBarListClasses = computed(() => {
  return `text-lg mx-3 ${sidebar_open.value ? 'lg:hidden inline' : 'hidden lg:inline' } `;
})

const outputPostText = (str) => {
  let truncated_res = mainStore.truncateStr(str, 224);

  return truncated_res;
};

const submit = () => {

  if (!form.processing) {
    form.post(route('register'), {
      preserveScroll: true,
      onSuccess: (page) => {

        var response = page.props.flash.data;
        if (response.success) {

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


const createPostFocused = () => {
  create_post_input_fcsd.value = true;
}

const checkPostLength = () => {
  // max_post_length

  rem_chars.value = max_post_length.value - make_post_form.input.length;
  console.log(rem_chars.value)
}

</script>

<template>
  <div class="bg-white dark:bg-slate-700">

    <div class="w-full">
      <div :class="sidebar_open ? 'block shadow-md w-7/12 sm:w-full' : 'hidden'" class="md:w-1/12 lg:w-3/12  bg-secondary-100 dark:bg-slate-800 dark:text-secondary-100 h-screen sm:inline-block fixed social-media-sidebar top-0 left-0 z-30 ">
        <div class="w-full p-1">
          <h3 class="text-4xl font-bold font-grey_qo text-center my-2 lg:block hidden">WeConnect</h3>
          <h3 class="text-4xl font-bold font-grey_qo text-center my-2 lg:hidden block">We</h3>

          <ul class="mt-7 lg:px-5 px-1">
            <li class="list active">
              <font-awesome-icon icon="fa-solid fa-house" />
              <span :class="sideBarListClasses" class="mx-2">Home</span>
            </li>

            <li class="list">
              <Link href="" >
                <font-awesome-icon icon="fa-solid fa-magnifying-glass" />
                <span :class="sideBarListClasses" class="mx-2">Search</span>
              </Link>
            </li>

            <li class="list">
              <Link href="" >
                <font-awesome-icon icon="fa-solid fa-user-pen" />
                <span :class="sideBarListClasses" class="mx-2">Edit Profile</span>
              </Link>
            </li>

            <li class="list">
              <Link href="" >
                <font-awesome-icon icon="fa-regular fa-square-plus" />
                <span :class="sideBarListClasses" class="mx-2">Create</span>
              </Link>
            </li>

            <li class="list">
              <Link href="" >
                <font-awesome-icon icon="fa-regular fa-bell" />
                <span :class="sideBarListClasses" class="mx-2">Notifications</span>
              </Link>
            </li>

            <li  class="list">
              <Link href="" >
                <font-awesome-icon icon="fa-regular fa-compass" />
                <span :class="sideBarListClasses" class="mx-2">Community</span>
              </Link>
            </li>

            <li class="list">
              <Link href="" >
                <font-awesome-icon icon="fa-solid fa-gear" />
                <span :class="sideBarListClasses" class="mx-2">Settings</span>
              </Link>
            </li>
          </ul>
        </div>
      </div>

      <div  class="w-full inline-block relative">

        <div @click="toggleSidebar" class="transition-all ease-linear duration-500 fixed top-0 bottom-0 h-screen w-screen z-20" :class="sidebar_open ? 'bg-black opacity-50': 'hidden'"></div>

        <div class="md:w-1/12 lg:w-3/12 w-0 inline-block">

        </div>

        <div class="md:w-11/12 lg:w-9/12 w-full  h-[1500px] inline-block">
          <nav :class="collapse_nav_padding ? 'py-3' : 'py-6'" class="bg-white dark:bg-slate-700 px-5 border-b-[1px] border-secondary-300 dark:border-slate-500 fixed md:w-11/12 lg:w-9/12 w-full transition-all ease-linear duration-300 shadow-sm z-10">
            <div class="hidden sm:grid grid-cols-12 gap-6">
              <div class="col-span-7">
                <form >
                  <div class="relative text-secondary-400">
                    <font-awesome-icon icon="fa-solid fa-magnifying-glass" class="absolute top-0 bottom-0 my-auto text-secondary-200" />
                    <input type="text" class="w-full border-0 text-sm pl-7 focus:outline-0 focus:outline-none focus:ring-0 bg-transparent dark:text-gray-200" placeholder="Search....">
                  </div>
                </form>
              </div>

              <div class="col-span-5 px-2 pr-7">
                <div class="mt-[5px] float-right">
                  <font-awesome-icon class="nav-icons" icon="fa-regular fa-bell" />
                  <font-awesome-icon @click="darkModeStore.set()" class="nav-icons"  icon="fa-solid fa-circle-half-stroke" title="Toggle dark mode" />
                  <!-- <font-awesome-icon class="nav-icons" icon="fa-regular fa-bell" /> -->
                  <font-awesome-icon class="nav-icons" icon="fa-solid fa-arrow-right-from-bracket" />

                  <Link href="" class="ml-7">
                    <img  class="w-6 inline-block mt-[-10px] mr-1 rounded-full" :src="Avatar"/>
                    <span class="hidden lg:inline-block text-xs font-semibold mt-[-10px] dark:text-secondary-300">@dave1614</span>
                  </Link>
                </div>
              </div>
            </div>

            <div class="sm:hidden block">
              <div class="grid grid-cols-12 gap-6">
                <font-awesome-icon @click="toggleSidebar" class="nav-icons ml-3" icon="fa-solid fa-bars" />
                <font-awesome-icon class="nav-icons" icon="fa-solid fa-magnifying-glass" />
                <font-awesome-icon class="nav-icons" icon="fa-regular fa-bell" />
                <font-awesome-icon @click="darkModeStore.set()" class="nav-icons"  icon="fa-solid fa-circle-half-stroke" title="Toggle dark mode" />
                <font-awesome-icon class="nav-icons" icon="fa-solid fa-gear" />
                <!-- <font-awesome-icon class="nav-icons" icon="fa-solid fa-arrow-right-from-bracket" /> -->

                <Link href="" class="nav-icons p-0 mx-1 inline-block mt-0 bg-transparent">
                  <img  class="w-8 h-8 inline-block  rounded-full" :src="Avatar"/>
                </Link>
              </div>
            </div>
          </nav>

          <div class="w-full min-h-screen mt-[85px]">
            <div class="grid grid-cols-12 gap-6">
              <div class="col-span-12 sm:col-span-7 border-0 sm:border-r-[1px] border-secondary-300 dark:border-slate-500 min-h-screen">
                <div class="px-5 py-4">
                  <div class="relative">
                    <div class="absolute bottom-0 bg-gray-50 w-[96%] h-[50px] mb-[-12px] rounded-[200px] z-[1] mx-auto left-0 right-0 shadow-xl opacity-50 dark:bg-slate-800"></div>

                    <div class="bg-white dark:bg-slate-800 shadow-xl px-7 py-5 rounded-md relative z-[2]">

                      <div>
                        <form>
                          <div v-show="!create_post_input_fcsd" class="grid grid-cols-12 gap-6" >
                            <img :src="Avatar" alt="" class="rounded-full col-span-2">

                            <input @focus="createPostFocused" class="col-span-10 dark:text-white dark:bg-slate-700 rounded-full border-secondary-300 text-sm focus:outline-0 focus:outline-none focus:ring-0 focus:border-secondary-300 " placeholder="What's new?">
                          </div>

                          <div  v-show="create_post_input_fcsd" >

                            <div class="grid grid-cols-12 gap-3 border-b border-secondary-300">
                              <div class="col-span-2 relative">
                                <img :src="Avatar" alt="" class="rounded-full w-full">

                                <span :class="rem_chars <= 0 ? 'text-red-500' : ''" class="absolute bottom-0 text-sm mb-1 text-secondary-200 font-semibold">{{ rem_chars }}</span>
                              </div>


                              <textarea @keyup="checkPostLength" v-model="make_post_form.input"  class="col-span-10 dark:text-white bg-transparent  border-0 text-sm focus:outline-0 focus:outline-none focus:ring-0 focus:border-0 " placeholder="What's new?" cols="50" rows="4"> </textarea>

                            </div>

                            <div class="border-b border-secondary-300 pt-2 pb-1">
                              <font-awesome-icon class="text-xs text-primary-100 p-2 bg-secondary-500 dark:bg-slate-900 rounded-full" icon="fa-solid fa-paperclip" />

                              <span class="text-primary-100 text-sm inline-block mb-[-5px] ml-2">Attach media</span>
                            </div>

                            <div class="text-right pt-3">
                              <span @click="create_post_input_fcsd = false" class="text-primary-100 text-sm inline-block cursor-pointer hover:underline">Cancel</span>

                              <button class="text-center px-4 py-1 bg-gradient-to-r from-primary-100 to-primary-200 rounded-full ml-3 text-white text-sm">Post Update</button>
                            </div>

                          </div>



                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="posts mt-[70px] text-secondary-200 dark:text-slate-300">
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg">
                      <div class="px-4 py-2 pt-5 border-b border-secondary-300">
                        <div class="inline-block">
                          <img class="w-8 rounded-full inline-block" :src="Avatar" alt="">
                          <span class="text-sm font-semibold inline-block ml-3">dave1614</span>
                          <span class="text-secondary-600 text-xs font-bold inline-block ml-1">• 5m</span>

                        </div>

                        <div class="float-right inline-block">
                          <font-awesome-icon class="cursor-pointer" icon="fa-solid fa-ellipsis" />
                        </div>
                      </div>
                      <div class=" px-3 py-1 ">
                        <p @click="show_more = !show_more" v-if="!show_more" class="transition-all ease-linear duration-300 text-sm leading-[26px]">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in cul... <span class='text-primary-100 inline-block ml-1 cursor-pointer hover:underline'>read more</span></p>

                        <p @click="show_more = !show_more" v-else class="transition-all ease-linear duration-300 text-sm leading-[26px]">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
                          <span class='text-primary-100 inline-block ml-1 cursor-pointer hover:underline'>#beehive
                          </span> <span class='text-primary-100 inline-block ml-1 cursor-pointer hover:underline'>#social</span> <span class='text-primary-100 inline-block ml-1 cursor-pointer hover:underline'>#network</span> <span class='text-primary-100 inline-block ml-1 cursor-pointer hover:underline'>#photos</span> <span class='text-primary-100 inline-block ml-1 cursor-pointer hover:underline'>#videos</span><span class='text-primary-100 block ml-1 cursor-pointer hover:underline'>less</span></p>
                      </div>

                      <div class="px-3 py-3">
                        <div class="grid grid-cols-12 gap-6">
                          <div class="col-span-12 max-h-[300px] overflow-hidden rounded-xl cursor-pointer">
                            <img class="hover:transform hover:scale-110 transition-all ease-in-out duration-300 w-full h-full" src="/images/maxresdefault-1-800x450-2-450x320.jpg" alt="">
                          </div>

                          <div class="col-span-4 max-h-[300px] overflow-hidden rounded-xl cursor-pointer">
                            <img class="hover:transform hover:scale-110 transition-all ease-in-out duration-300 w-full h-full" src="/images/woman-wearing-white-knitted-dress-709790-1-800x1200-2-450x320.jpg" alt="">
                          </div>

                          <div class="col-span-4 max-h-[300px] overflow-hidden rounded-xl cursor-pointer">
                            <img class="hover:transform hover:scale-110 transition-all ease-in-out duration-300 w-full h-full" src="/images/shallow-focus-photo-of-woman-in-white-dress-shirt-1963481-1-800x1200-2-450x320.jpg" alt="">
                          </div>

                          <div class="col-span-4 max-h-[300px] overflow-hidden rounded-xl cursor-pointer">
                            <img class="hover:transform hover:scale-110 transition-all ease-in-out duration-300 w-full h-full" src="/images/maxresdefault-1-800x450-2-450x320.jpg" alt="">
                          </div>


                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="hidden sm:col-span-5">

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

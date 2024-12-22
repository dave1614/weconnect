<style>
  .main-background{
    background: linear-gradient(to right bottom, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/public/img/pexels-hillaryfox-1595390.jpg') no-repeat center center fixed;


    -webkit-background-size: cover;
    -moz-background-size: cover;
    background-size: cover;
    -o-background-size: cover;
  }
</style>

<script setup>
import { computed, ref, onMounted, onUnmounted  } from "vue";
import { Head, Link, useForm, router} from '@inertiajs/vue3';
import { useMainStore } from "@/Stores/main";


import CardBoxWidget from "@/Components/CardBoxWidget.vue";
import CardBox from "@/Components/CardBox.vue";
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import BaseDivider from '@/Components/BaseDivider.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import FormValidationErrors from '@/Components/FormValidationErrors.vue'
// import Logo from '@/Icons/onehealth_logo_icon.svg'
import Logo from '@/Icons/easybizu_logo.jpeg'
import GoogleIcon from '@/Icons/google_icon.svg'
import FacebookIcon from '@/Icons/facebook_icon.svg'
import AppleIcon from '@/Icons/apple_icon.svg'
import FacilityIcon from '@/Icons/facility_icon.svg'
import PatientIcon from '@/Icons/patient_icon.svg'
import MainSiteInput from '@/Components/MainSiteInput.vue'
// import MainSiteTextArea from '@/Components/MainSiteTextArea.vue'
import FormLoaderDark from '@/Loaders/form_loader_dark.gif'
import FormLoaderLight from '@/Loaders/form_loader_light.gif'
import FlashMessages from '@/Components/FlashMessages.vue'

import ServiceImage1 from "@/Images/pexels-flodahm-699459.jpg";
import ServiceImage2 from "@/Images/pexels-luis-gomes-166706-546819.jpg";
import ServiceImage3 from "@/Images/pexels-pixabay-267350.jpg";




const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,

  auth: Object,
});

console.log(props.auth)

const mainStore = useMainStore();

const sections = ref([]);
const scrollX = ref(0);
const scrollY = ref(0);

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});

const handleScroll = (event) => {
  scrollX.value = window.scrollX;
  scrollY.value = window.scrollY;


};

const form = useForm({
  name: '',
  email: '',
  subject: '',
  message: '',
});

const newsletter_form = useForm({
  email: null,
});


const submit = () => {
  if(!form.processing){
    form.post(route('submit_front_page_message'), {
      preserveScroll: true,
      onSuccess: (page) => {

        var response = page.props.flash.data;
        console.log(response)
        if (response.success){
          Swal.fire({
            title: 'Success',
            html: `Your message has been sent to the admin sucessfully`,
            icon: 'success',

            allowEscapeKey: false,
            allowOutsideClick: false,
          }).then((result) => {
            if (result.isConfirmed) {
              document.location.reload();
            }
          });
        }else {
          Swal.fire({
            title: 'Ooops!',
            html: `Something went wrong`,
            icon: 'error',
          });
        }

      }, onError: (errors) => {
        Swal.close();
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

const addToNewsLetter = () => {

  if(!newsletter_form.processing){
    newsletter_form.post(route('news_letter_list.store'), {
      preserveScroll: true,
      onSuccess: (page) => {

        var response = page.props.flash.data;
        console.log(response)
        if (response.success){
          Swal.fire({
            title: 'Success',
            html: `Your email address has been added sucessfully. You'll receive our latest updates.`,
            icon: 'success',
          });

          newsletter_form.email = null;
        }else {
          Swal.fire({
            title: 'Ooops!',
            html: `Something went wrong`,
            icon: 'error',
          });
        }

      }, onError: (errors) => {
        Swal.close();
        var size = Object.keys(errors).length;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `There are ${size} form errors. Please fix them`,
        })
      },

    });
  }
};
</script>
<template>
  <Head title="Welcome" />

  <div class="font-montserrat text-slate-700">
    <div class="h-screen main-background relative" style="">
      <nav class="sm:px-11 py-5 bg-white shadow-md fixed w-full z-30 top-0" id="header" >
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-2">
          <div class="inline-block ml-6">
            <Link :href="route('main_page')">
              <h1 class="font-pacifico text-[28px] font-bold text-slate-700"><span class="text-primary inline-block mr-[1px]">Cos</span>Rosmos</h1>
            </Link>
          </div>


          <div class="block lg:hidden pr-4">
            <button @click="mainStore.toggleMainNavMenu()" id="nav-toggle"
              class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-800 hover:border-green-500 appearance-none focus:outline-none">
              <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
              </svg>
            </button>
          </div>

          <div :class="mainStore.show_nav_menu ? '' : 'hidden'"
            class="w-full flex-grow lg:flex lg:items-center lg:w-auto  lg:block mt-2 text-slate-700 p-4 lg:p-0 z-20 "
            id="nav-content">
            <ul class="list-reset lg:flex justify-end flex-1 items-center">
              <li class="home-nav-li"><Link :class="scrollY >= 0 && scrollY <= 500 ? 'text-primary' : ''" href="#">Home</Link></li>
              <li class="home-nav-li"><Link :class="scrollY >= 500  && scrollY <= 1000? 'text-primary' : ''" href="#about-us">About Us</Link></li>
              <li class="home-nav-li"><Link :class="scrollY >= 1000  && scrollY <= 1500? 'text-primary' : ''" href="#our-services">Our Services</Link></li>
              <li class="home-nav-li"><Link :class="scrollY >= 1500  && scrollY <= 2000 ? 'text-primary' : ''" href="#contact-us">Contact Us</Link></li>
              <li class="home-nav-li"><Link :href="route('register')">Register</Link></li>
              <li class="home-nav-li"><Link :href="route('login')">Login</Link></li>
            </ul>
          </div>

        </div>
      </nav>


      <div class="absolute bottom-[33%] pl-[36px] pr-[15px] text-white">
        <h3 class="text-5xl font-bold mb-4">Weconnect Technologies</h3>

        <span class="text-sm italic font-semibold block  mb-[40px]">Lorem ipsum dolor sit amet consectetur adipisicing...</span>

        <Link :href="route('register')" class="bg-gradient-to-r from-pink-400 to-primary inline-block py-4 px-7 shadow rounded-full text-xs uppercase font-bold  transition-all duration-300 ease-in-out hover:mt-[-2px]">Create your free account</Link>
      </div>
    </div>

    <section id="about-us">
      <div class="pb-[15px] pt-[30px] px-[20px]">
        <h4 class="main-subhead">About Us</h4>

        <div class="subhead-underline"></div>

        <div class="mt-[40px] px-3 text-center">
          <p class="text-lg text-slate-600">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque iusto possimus corrupti vel, adipisci animi. Cumque quisquam, odit sint tempora neque vel laudantium nam. Modi, possimus? Saepe repellat corrupti consequuntur. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque iusto possimus corrupti vel, adipisci animi? Cumque quisquam, odit sint tempora neque vel laudantium nam. Modi, possimus? Saepe repellat corrupti consequuntur?</p>

          <p class="text-lg text-slate-600 mt-[30px]">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque iusto possimus corrupti vel, adipisci animi. Cumque quisquam, odit sint tempora neque vel laudantium nam. Modi, possimus? Saepe repellat corrupti consequuntur. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque iusto possimus corrupti vel, adipisci animi? Cumque quisquam, odit sint tempora neque vel laudantium nam. Modi, possimus? Saepe repellat corrupti consequuntur?</p>
        </div>
      </div>

    </section>

    <div class="bg-gradient-to-r from-pink-100 to-orange-100  mt-[30px] py-6">

      <section id="our-services" class="">
        <div class="pb-[15px] pt-[30px] px-[20px] mt-[35px]">
          <h4 class="main-subhead">Our Services</h4>

          <div class="subhead-underline mb-[20px]"></div>

          <div class="mt-[40px] px-3">
            <div class="sm:grid sm:grid-cols-12 sm:gap-6">
              <div class="sm:col-span-4 sm:my-2 my-4">
                <div class="bg-white rounded-lg shadow-lg">
                  <div class="w-full">
                    <img class="w-full h-[260px]" :src="ServiceImage1" alt="">
                  </div>
                  <div class="mt-[14px]">
                    <h4 class="main-subhead text-2xl">Lorem Ipsum</h4>
                    <div class="subhead-underline"></div>

                    <div class="mt-[20px] p-4">
                      <span class="text-xs">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure, facere maiores est dolorem perferendis adipisci, vero aspernatur dicta, aut saepe sequi odio aliquid accusantium. Cumque modi quisquam ipsum sapiente accusantium.
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="sm:col-span-4 sm:my-2 my-4">
                <div class="bg-white rounded-lg shadow-lg">
                  <div class="w-full">
                    <img class="w-full h-[260px]" :src="ServiceImage2" alt="">
                  </div>
                  <div class="mt-[14px]">
                    <h4 class="main-subhead text-2xl">Lorem Ipsum</h4>
                    <div class="subhead-underline"></div>

                    <div class="mt-[20px] p-4">
                      <span class="text-xs">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure, facere maiores est dolorem perferendis adipisci, vero aspernatur dicta, aut saepe sequi odio aliquid accusantium. Cumque modi quisquam ipsum sapiente accusantium.
                      </span>
                    </div>
                  </div>
                </div>
              </div>


              <div class="sm:col-span-4 sm:my-2 my-4">
                <div class="bg-white rounded-lg shadow-lg">
                  <div class="w-full">
                    <img class="w-full h-[260px]" :src="ServiceImage3" alt="">
                  </div>
                  <div class="mt-[14px]">
                    <h4 class="main-subhead text-2xl">Lorem Ipsum</h4>
                    <div class="subhead-underline"></div>

                    <div class="mt-[20px] p-4">
                      <span class="text-xs">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure, facere maiores est dolorem perferendis adipisci, vero aspernatur dicta, aut saepe sequi odio aliquid accusantium. Cumque modi quisquam ipsum sapiente accusantium.
                      </span>
                    </div>
                  </div>
                </div>
              </div>


              <div class="sm:col-span-4 sm:my-2 my-4 transition-all duration-300 ease-in-out hover:mt-[-15px] cursor-pointer">
                <div class="bg-white rounded-lg shadow-lg">
                  <div class="w-full">
                    <img class="w-full h-[260px]" :src="ServiceImage1" alt="">
                  </div>
                  <div class="mt-[14px]">
                    <h4 class="main-subhead text-2xl">Lorem Ipsum</h4>
                    <div class="subhead-underline"></div>

                    <div class="mt-[20px] p-4">
                      <span class="text-xs">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure, facere maiores est dolorem perferendis adipisci, vero aspernatur dicta, aut saepe sequi odio aliquid accusantium. Cumque modi quisquam ipsum sapiente accusantium.
                      </span>
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>

      </section>

      <section id="contact-us" class="pt-[30px] ">
        <div class="pb-[15px] pt-[30px] px-[20px] mt-[35px]">
          <h4 class="main-subhead">Contact Us</h4>

          <div class="subhead-underline mb-[20px]"></div>

          <div class="mt-[60px] px-6">
            <div class="sm:grid sm:grid-cols-12 sm:gap-6">
              <div class="sm:col-span-6 sm:mx-3">
                <CardBox class="min-h-[400px] bg-white">
                  <span class="text-primary block">
                    <font-awesome-icon class="text-2xl " icon="fa-solid fa-phone" />
                    <Link href="tel:+234705194235" class="inline-block ml-2 font-bold text-lg hover:underline">0705194235</Link>,
                    <Link href="tel:+234705194235" class="inline-block ml-1 font-bold text-lg hover:underline">082726655355</Link>
                  </span>

                  <span class="text-primary block mt-2">
                    <font-awesome-icon class="text-2xl" icon="fa-solid fa-envelope" />
                    <Link href="mailto:admin@cosrosmos.com" class="inline-block ml-2 font-bold text-lg hover:underline">admin@cosrosmos.com</Link>
                  </span>

                  <span class="text-primary block mt-2">
                    <font-awesome-icon class="text-2xl" icon="fa-solid fa-location-dot" />
                    <span class="ml-2 font-bold text-lg capitalize">20, adeboun street iyana ipaja alimosho lagos</span>
                  </span>

                  <div class="bg-gradient-to-r from-pink-300 to-primary mt-4 p-2 rounded-lg">
                    <iframe class="w-full" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.2426666203196!2d3.297865991451924!3d6.616745155855144!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b9102385c253b%3A0xb635b13fb55b5f48!2s20%20Adeboun%20St%2C%20Alagba%2C%20Lagos%20102213%2C%20Lagos!5e0!3m2!1sen!2sng!4v1718880465249!5m2!1sen!2sng" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
                </CardBox>
              </div>

              <div class="sm:col-span-6 sm:mx-3">
                <h4 class="uppercase text-xl font-bold mb-3 sm:mt-1 mt-8">Get in touch</h4>

                <form @submit.prevent="submit" class="pt-1">
                  <flash-messages />
                  <div class="">


                    <MainSiteInput v-model="form.name" :error="form.errors.name" type="text"
                      placeholder="Your name" id="name" class="" />

                    <MainSiteInput v-model="form.email" :error="form.errors.email" type="email"
                      placeholder="Your email address" id="email" class="" />

                    <MainSiteInput v-model="form.subject" :error="form.errors.subject" type="text"
                      placeholder="Subject of enquiry" id="subject" class="" />

                    <textarea id="message" class="main-input h-[120px]" cols="30" rows="10" v-model="form.message" placeholder="What would you like to tell us?"></textarea>

                    <span class="login-form-error">{{ form.errors.message }}</span>

                  </div>


                  <button name="login-btn" :class="form.processing ? 'opacity-80 cursor-not-allowed' : ''"
                    @mouseleave="login_btn_hovered = false" @mouseover="login_btn_hovered = true" type="submit"
                    class="main-page-button  mt-[55px]">
                    SUBMIT
                    <img v-if="form.processing" class="inline-block w-7 h-6 float-right"
                      :src="login_btn_hovered ? FormLoaderDark : FormLoaderLight" alt="">
                  </button>


                </form>
              </div>
            </div>
          </div>
        </div>
      </section>



    </div>

    <footer class=" bg-slate-700 px-5 py-3 pt-[20px] text-white">
      <div class="sm:grid sm:grid-cols-12 sm:gap-6">
        <div class="sm:col-span-4">
          <h4 class="main-subhead text-white text-xl">Our Mission</h4>
          <div class="subhead-underline"></div>

          <div class="text-sm my-2 mx-2">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dicta mollitia rem nam, aperiam quisquam quo omnis, blanditiis nemo quibusdam eum beatae? </p>
          </div>

          <div class="text-center my-2 mt-4 hidden sm:block">
            <Link :href="route('main_page')" class="">
              <h1 class="font-pacifico text-[28px] font-bold text-gray-200"><span class="text-primary inline-block mr-[1px]">Cos</span>Rosmos</h1>
            </Link>
          </div>
        </div>

        <div class="sm:col-span-3 px-2 text-center sm:text-left">
          <h4 class="font-bold text-xl sm:mt-0 mt-4">Quick Links</h4>

          <ul class="mt-5">
            <li class="text-[14px] font-semibold my-[3px]"><Link href="#" class="hover:text-primary transition-all ease-in-out duration-150">Home</Link></li>
            <li class="text-[14px] font-semibold my-[3px]"><Link href="#about-us" class="hover:text-primary transition-all ease-in-out duration-150">About Us</Link></li>
            <li class="text-[14px] font-semibold my-[3px]"><Link href="#our-services" class="hover:text-primary transition-all ease-in-out duration-150">Our Services</Link></li>
            <li class="text-[14px] font-semibold my-[3px]"><Link href="#contact-us" class="hover:text-primary transition-all ease-in-out duration-150">Contact Us</Link></li>
            <li class="text-[14px] font-semibold my-[3px]"><Link :href="route('register')" class="hover:text-primary transition-all ease-in-out duration-150">Register</Link></li>
            <li class="text-[14px] font-semibold my-[3px]"><Link :href="route('login')" class="hover:text-primary transition-all ease-in-out duration-150">Sign In</Link></li>
          </ul>
        </div>

        <div class="sm:col-span-5 text-center sm:text-left">
          <div class="sm:mt-0 mt-4">
            <h4 class="font-bold text-xl">Our Socials</h4>

            <div class="my-4">
              <font-awesome-icon @click="router.visit('')" icon="fa-brands fa-facebook" class="text-3xl text-gray-200 hover:text-primary cursor-pointer transition-all ease-in-out duration-150 mx-3" />
              <font-awesome-icon @click="router.visit('')" icon="fa-brands fa-square-x-twitter" class="text-3xl text-gray-200 hover:text-primary cursor-pointer transition-all ease-in-out duration-150 mx-3" />
              <font-awesome-icon @click="router.visit('')" icon="fa-brands fa-instagram" class="text-3xl text-gray-200 hover:text-primary cursor-pointer transition-all ease-in-out duration-150 mx-3" />
              <font-awesome-icon @click="router.visit('')" icon="fa-solid fa-envelopes-bulk" class="text-3xl text-gray-200 hover:text-primary cursor-pointer transition-all ease-in-out duration-150 mx-3" />

            </div>

            <div class="my-3 mt-6">
              <h4 class="font-bold text-xl">Subscribe to newsletter</h4>


              <form @submit.prevent="addToNewsLetter">

                <div class="w-full grid grid-cols-12 gap-2 mt-4">
                  <input type="email" v-model="newsletter_form.email" placeholder="Enter your email address" class="text-xs rounded-full col-span-9 py-3 text-gray-700">

                  <button :class="newsletter_form.processing ? 'opacity-30 cursor-not-allowed' : ''" class="col-span-3 rounded-full bg-gradient-to-r from-pink-400 to-primary px-3 py-2 text-sm">Subscribe</button>
                </div>
                <span class="text-xs font-bold italic text-red-600">{{ newsletter_form.errors.email }}</span>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="w-full bg-gray-500 h-[1px] my-2 mt-[13px]"></div>

      <div class="my-5 mb-1 text-center">
        <div class="text-center my-2 mt-4 block sm:hidden">
          <Link :href="route('main_page')" class="">
            <h1 class="font-pacifico text-[28px] font-bold text-gray-200"><span class="text-primary inline-block mr-[1px]">Cos</span>Rosmos</h1>
          </Link>
        </div>
        <p class="text-sm font-bold">&copy;2024 Cosrosmos, All rights reserved.</p>
      </div>
    </footer>
  </div>
</template>

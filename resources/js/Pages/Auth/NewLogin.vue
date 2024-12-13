<script setup>
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from '@mdi/js'
import LayoutGuest from '@/Layouts/LayoutGuest.vue'
import SectionFullScreen from '@/Components/SectionFullScreen.vue'
import CardBox from '@/Components/CardBox.vue'
import FormCheckRadioGroup from '@/Components/FormCheckRadioGroup.vue'
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
import LoginInput from '@/Components/LoginInput.vue'
import FormLoaderDark from '@/Loaders/form_loader_dark.gif'
import FormLoaderLight from '@/Loaders/form_loader_light.gif'
import FlashMessages from '@/Components/FlashMessages.vue'

import SecondLoginImage from '@/Images/second_login.jpg'

const props = defineProps({

});



const page = usePage()
const hasTermsAndPrivacyPolicyFeature = computed(() => page.props.jetstream?.hasTermsAndPrivacyPolicyFeature)



const login_btn_hovered = ref(false);

const form = useForm({
  login: '',
  password: '',
  remember_me: false,
})


const submit = () => {

  if (!form.processing) {

    form.post(route('login'), {
      preserveScroll: true,
    });
  }
}


</script>

<template>
  <LayoutGuest class="font-nunito">

    <Head title="Login to weconnect" />

    <SectionFullScreen v-slot="{ cardClass }" bg="" class="bg-gradient-to-r from-gray-200 to-gray-300">


      <div class="w-full mx-3 sm:w-10/12 my-5  shadow-lg bg-white ">
        <div class="bg-white rounded-[30px]">

          <div class="sm:grid sm:grid-cols-12 sm:gap-6">

            <div class="px-[40px] py-4 sm:col-span-6 text-black">

              <div class="logo-icon mt-[55px] justify-center flex">
                <span class="text-black font-bold text-lg">WeConnect</span>
              </div>
              <h4 class="text-black text-3xl font-extrabold my-2 text-center mt-4">Sign In</h4>
              <p class="text-gray-400 text-center text-sm">Please enter your details</p>

              <div class="py-2 grid grid-cols-12 gap-6 my-2">
                <div
                  class="col-span-4 px-2 py-2 border border-gray-300 h-[40px] rounded cursor-pointer hover:bg-gray-100 transition ease-in-out duration-500">
                  <img :src="GoogleIcon" alt="" class="w-full h-full">
                </div>

                <div
                  class="col-span-4 px-2 py-2 border border-gray-300 h-[40px] rounded cursor-pointer hover:bg-gray-100 transition ease-in-out duration-500">
                  <img :src=" FacebookIcon" alt="" class="w-full h-full">
                </div>

                <div
                  class="col-span-4 px-2 py-2 border border-gray-300 h-[40px] rounded cursor-pointer hover:bg-gray-100 transition ease-in-out duration-500">
                  <img :src=" AppleIcon" alt="" class="w-full h-full">
                </div>

              </div>

              <div class="grid grid-cols-11 gap-2 mt-4">
                <div class="col-span-5 bg-gray-300 h-[1px] mt-[8px]"></div>
                <span class="col-span-1 text-sm text-slate-600 font-semibold text-center">or</span>
                <div class="col-span-5 bg-gray-300 h-[1px] mt-[8px]"></div>
              </div>


              <form @submit.prevent="submit" class="pt-1">
                <flash-messages />
                <div class="max-h-[260px] overflow-x-hidden">


                  <login-input v-model="form.login" :error="form.errors.login" type="text"
                    placeholder="Username or email" id="user_name" class="" />


                  <login-input v-model="form.password" name="password" :error="form.errors.password" type="password"
                    placeholder="Password" icon="fa-solid fa-lock" id="password" class="" />


                </div>

                <div class="mt-4 mb-3 px-1">
                  <div class="inline-block">
                    <input type="checkbox" name="remember_me" class="login-checkbox" id="terms"
                    v-model="form.remember_me" />
                    <label for="terms" class="login-checkbox-label text-gray-400">Remember me</label>

                  </div>

                  <Link :href="route('password.request')"
                    class="login-checkbox-label mt-1 float-right hover:text-primary text-slate-700 hover:underline">
                  Forgot Password?
                  </Link>
                </div>

                <button name="login-btn" :class="form.processing ? 'opacity-80 cursor-not-allowed' : ''"
                  @mouseleave="login_btn_hovered = false" @mouseover="login_btn_hovered = true" type="submit"
                  class="login-button mt-[40px]">
                  Sign in
                  <img v-if="form.processing" class="inline-block w-7 h-6 float-right"
                    :src="login_btn_hovered ? FormLoaderDark : FormLoaderLight" alt="">
                </button>




                <p class=" text-xs font-bold mt-[40px]">Don't have an account?
                    <Link :href="route('register')" class="text-primary hover:underline">Register now</Link>
                </p>
              </form>
            </div>

            <div
              class="sm:col-span-6 sm:block hidden bg-login-left-background bg-cover bg-no-repeat bg-center min-h-[500px]">
              <!-- <img :src="SecondLoginImage" alt="" class="w-full h-full rounded-[30px]"> -->
            </div>


          </div>


        </div>
      </div>

    </SectionFullScreen>
  </LayoutGuest>
</template>

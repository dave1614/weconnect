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
  props_states: {
    type: Array,
  },
  props_cities: {
    type: Array,
  },
  state: {
    type: Number
  },
  city: {
    type: Number
  },
});



const page = usePage()
const states = ref(props.props_states);
const cities = ref(props.props_cities);

console.log(states.value)
console.log(cities.value)
const hasTermsAndPrivacyPolicyFeature = computed(() => page.props.jetstream?.hasTermsAndPrivacyPolicyFeature)



const login_btn_hovered = ref(false);

const form = useForm({
  name: null,
  user_name: null,
  email: null,
  state: props.state,
  city: props.city,
  // country: 1,
  phone: null,
  password: null,
  password_confirmation: null,
})


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


</script>

<template>
  <LayoutGuest class="font-nunito">

    <Head title="Create a new cosrosmos account" />

    <SectionFullScreen v-slot="{ cardClass }" bg="" class="bg-gradient-to-r from-gray-200 to-gray-300">


      <div class="w-full mx-3 sm:w-10/12 my-5  shadow-lg bg-white ">
        <div class="bg-white rounded-[30px]">

          <div class="sm:grid sm:grid-cols-12 sm:gap-6">

            <div class="px-[40px] py-4 sm:col-span-6 text-black">

              <div class="logo-icon mt-[55px] justify-center flex">
                <span class="text-black font-bold text-lg">WeConnect</span>
              </div>
              <h4 class="text-black text-3xl font-extrabold my-2 text-center mt-4">Create Account</h4>
              <p class="text-gray-400 text-center text-sm">Please enter your details to register</p>

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
                <div class="">


                  <login-input v-model="form.name" :error="form.errors.name" type="text" id="name"
                    placeholder="Full Name" class="" icon="fa-solid fa-user" />

                  <login-input v-model="form.user_name" :error="form.errors.user_name" type="text"
                    placeholder="Username" id="user_name" class=""  icon="fa-solid fa-user-tie"/>

                  <login-input v-model="form.email" :error="form.errors.email" type="email" placeholder="Email Address"
                    id="email" class="" icon="fa-solid fa-envelope" />


                  <login-input v-model="form.phone" :error="form.errors.phone" type="number" placeholder="Phone Number"
                    id="phone" class="" icon="fa-solid fa-phone" />

                  <div class="mb-2 transition-all ease-linear duration-200">
                    <font-awesome-icon class="login-icon" icon="fa-regular fa-compass" />
                    <select @change="loadNewCities" class="p-3 py-2 pl-9" id="state" v-model="form.state"
                      :class="form.errors.state ? 'login-input-error' : 'login-input'">
                      <option v-for="state in states" :value="state.id" :key="state.id" v-html="`${state.name}`"></option>
                    </select>
                    <div v-if="form.errors.state" class="login-form-error">{{ form.errors.state }}</div>
                  </div>


                  <div class="mb-2 transition-all ease-linear duration-200">
                    <div class="relative">
                      <font-awesome-icon class="login-icon" icon="fa-solid fa-map-location-dot" />
                      <select class="p-3 py-2 pl-9" id="city" v-model="form.city"
                        :class="form.errors.city ? 'login-input-error' : 'login-input'">
                        <option v-for="city in cities" :value="city.id" :key="city.id" v-html="`${city.name}`"></option>
                      </select>

                    </div>
                    <div v-if="form.errors.city" class="login-form-error">{{ form.errors.city }}</div>
                  </div>


                  <login-input v-model="form.password" :error="form.errors.password" type="password"
                    placeholder="Password" id="password" class="" icon="fa-solid fa-lock"/>

                  <login-input v-model="form.password_confirmation" :error="form.errors.password_confirmation"
                    type="password" placeholder="Confirm Password" id="password_confirmation" class="mb-6" icon="fa-solid fa-lock" />



                </div>

                <!-- <div class="mt-4 mb-3 px-1">
                  <div class="inline-block">
                    <input type="checkbox" name="remember_me" class="login-checkbox" id="terms"
                    v-model="form.remember_me" />
                    <label for="terms" class="login-checkbox-label text-gray-400">Remember me</label>

                  </div>

                  <Link :href="route('password.request')"
                    class="login-checkbox-label mt-1 float-right hover:text-primary-100 text-slate-700 hover:underline">
                  Forgot Password?
                  </Link>
                </div> -->

                <button name="login-btn" :class="form.processing ? 'opacity-80 cursor-not-allowed' : ''"
                  @mouseleave="login_btn_hovered = false" @mouseover="login_btn_hovered = true" type="submit"
                  class="login-button mt-[20px]">
                  Register
                  <img v-if="form.processing" class="inline-block w-7 h-6 float-right"
                    :src="login_btn_hovered ? FormLoaderDark : FormLoaderLight" alt="">
                </button>


                <p class=" text-xs font-bold mt-[20px]">Already registered?
                    <Link :href="route('register')" class="text-primary-100 hover:underline">Login</Link>
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

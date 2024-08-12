import '../css/main.css'

import { createPinia } from 'pinia'
import { useDarkModeStore } from '@/Stores/darkMode.js'
import { createApp, h } from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import swal from 'sweetalert2';
import AOS from 'aos'
import 'aos/dist/aos.css'

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import { faUserSecret, faFloppyDisk, faDollarSign, faNairaSign, faMoneyBill1Wave, faEnvelope, faPhone, faArrowLeft, faUser, faLock, faHospital, faLocationPin, faBars, faBriefcase, faHouse, faUserTie, faArrowRight, faPlus, faUsers , faFileExport, faArrowDown, faCheck, faPenToSquare, faCheckToSlot, faPrint, faEdit, faLocationDot, faEnvelopesBulk, faMapLocationDot, faMagnifyingGlass, faUserPen, faGear, faCircleHalfStroke, faArrowRightFromBracket, faPaperclip, faEllipsis } from '@fortawesome/free-solid-svg-icons'


import { faBell, faSquarePlus, faCompass } from '@fortawesome/free-regular-svg-icons'

import { faFacebookF, faTwitter, faYoutube, faLinkedinIn, faFacebook, faSquareXTwitter, faInstagram } from '@fortawesome/free-brands-svg-icons'

/* add icons to the library */
library.add(faUserSecret, faFloppyDisk, faDollarSign, faNairaSign, faMoneyBill1Wave, faFacebookF, faTwitter, faYoutube, faLinkedinIn, faEnvelope, faPhone, faArrowLeft, faUser, faLock, faHospital, faLocationPin, faBars, faBriefcase, faHouse, faUserTie, faArrowRight, faPlus, faUsers, faBell, faFileExport, faArrowDown, faCheck, faPenToSquare, faCheckToSlot, faPrint, faEdit, faLocationDot, faFacebook, faSquareXTwitter, faInstagram, faEnvelopesBulk, faCompass, faMapLocationDot, faMagnifyingGlass, faUserPen, faSquarePlus, faGear, faCircleHalfStroke, faArrowRightFromBracket, faPaperclip, faEllipsis)


window.Swal = swal;

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Cosrosmos'

const pinia = createPinia()

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(pinia)
      .use(AOS.init())
      .use(ZiggyVue, Ziggy)
      .component('font-awesome-icon', FontAwesomeIcon)
      .mount(el)
  },
  progress: {
    color: '#4B5563'
  }
})

// const darkModeStore = useDarkModeStore(pinia)

// if (
//   (!localStorage['darkMode'] && window.matchMedia('(prefers-color-scheme: dark)').matches) ||
//   localStorage['darkMode'] === '1'
// ) {
//   darkModeStore.set(true)
// }

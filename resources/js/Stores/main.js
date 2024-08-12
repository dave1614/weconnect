import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

export const useMainStore = defineStore('main', () => {



  const userName = ref('John Doe')
  const userEmail = ref('doe.doe.doe@example.com')

  const userAvatar = computed(
    () =>
      `https://api.dicebear.com/7.x/avataaars/svg?seed=${userEmail.value.replace(
        /[^a-z0-9]+/gi,
        '-'
      )}`
  )

  const isFieldFocusRegistered = ref(false)

  const clients = ref([])
  const history = ref([])

  const show_nav_menu = ref(false)
  const useSearchBtn = ref(true)
  const is_admin = ref(false)
  const notiDismissed = ref(true)
  const email_changed = ref(false)


  function truncateStr(str, num) {
    return str.length > num ?  {edited: true, text: str.slice(0, num) + '...'}  : {edited: false, text: str};
  }

  function replaceUnderscoreWithSpace(str){
    return str.replace(/_/g, ' ');
  };

  function toggleMainNavMenu(){
    show_nav_menu.value = !show_nav_menu.value
  };

  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
  };

  function goBack(){
    window.history.back()
  };

  function changeIsAdminVal(val = false){
    is_admin.value = val
  };

  function isNumeric(str) {
    if (typeof str != "string") return false // we only process strings!
    return !isNaN(str) && // use type coercion to parse the _entirety_ of the string (`parseFloat` alone does not do this)...
      !isNaN(parseFloat(str)) // ...and ensure strings of whitespace fail
  };

  function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
  };

  function setUser(payload) {
    if (payload.name) {
      userName.value = payload.name
    }
    if (payload.email) {
      userEmail.value = payload.email
    }
  }

  function fetchSampleClients() {
    axios
      .get(`data-sources/clients.json?v=3`)
      .then((result) => {
        clients.value = result?.data?.data
      })
      .catch((error) => {
        alert(error.message)
      })
  }

  function fetchSampleHistory() {
    axios
      .get(`data-sources/history.json`)
      .then((result) => {
        history.value = result?.data?.data
      })
      .catch((error) => {
        alert(error.message)
      })
  }

  return {
    userName,
    userEmail,
    userAvatar,
    isFieldFocusRegistered,
    clients,
    history,
    show_nav_menu,
    useSearchBtn,
    is_admin,
    notiDismissed,
    email_changed,
    setUser,
    fetchSampleClients,
    fetchSampleHistory,
    replaceUnderscoreWithSpace,
    toggleMainNavMenu,
    getCookie,
    goBack,
    changeIsAdminVal,
    isNumeric,
    addCommas,
    truncateStr,
  }
})

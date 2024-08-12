
<script setup>
import {
  mdiMonitorCellphone,
  mdiTableBorder,
  mdiTableOff,
  mdiGithub,
  mdiHospitalBuilding,
  mdiClose,
  mdiClipboardTextClock,
  mdiAccountCog,
  mdiAccountCash,
  mdiWalletOutline,
  mdiBriefcaseEditOutline,
} from "@mdi/js";

import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import SectionMain from "@/Components/SectionMain.vue";
import NotificationBar from "@/Components/NotificationBar.vue";
import CardBox from "@/Components/CardBox.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import BaseLevel from "@/Components/BaseLevel.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import CardBoxModal from "@/Components/CardBoxModal.vue";
import FloatingActionButton from "@/Components/FloatingActionButton.vue";
import FormLoaderDark from '@/Loaders/form_loader_dark.gif'
import FormLoaderLight from '@/Loaders/form_loader_light.gif'

import { useMainStore } from "@/Stores/main";
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
//import { Inertia } from '@inertiajs/inertia'
import { computed, ref, reactive, watch, onMounted } from 'vue'
import axios from "axios";
import _ from 'lodash';

const page = usePage();
const props = defineProps({
  user: {
    type: Object,
  },
  networks: {
    type: Array,
    default: ['mtn', 'airtel', 'glo', '9mobile'],
  },
  tvs: {
    type: Array,
    default: ['dstv', 'gotv', 'startimes'],
  },
  routers: {
    type: Array,
    default: ['smile', 'spectranet'],
  },
  educationals: {
    type: Array,
    default: ['waec', 'neco'],
  },
  airtime_platforms: {
    type: Object,
  },
  data_platforms: {
    type: Object,
  },
  electricity_platforms: {
    type: Object,
  },
  cable_platforms: {
    type: Object,
  },
  router_platforms: {
    type: Object,
  },
  educational_platforms: {
    type: Object,
  },
  history_opened: {
    type: Boolean,
    default: false,
  }
})
const mainStore = useMainStore();

const btn_hovered = ref(false);
const current_page = ref(1);
const useSearchBtn = mainStore.useSearchBtn;
const vtu_history = ref([]);
const selected_airtime_network = ref(props.networks[0]);
const airtimePlansOptions = ref(props.airtime_platforms);

const current_airtime_plans_options = ref([]);
const selected_data_network = ref(props.networks[0]);
const selected_cable_network = ref(props.tvs[0]);
const selected_router_network = ref(props.routers[0]);
const selected_educational_network = ref(props.educationals[0]);
const data_network_details = ref({});
const cable_network_details = ref({});
const airtime_network_details = ref({});
const router_network_details = ref({});
const educational_network_details = ref({});


const electricity_details = ref({});
const dataPlansOptions = ref(props.data_platforms);
const cablePlansOptions = ref(props.cable_platforms);
const routerPlansOptions = ref(props.router_platforms);
const educationalPlansOptions = ref(props.educational_platforms);
const current_data_plans_options = ref([]);
const current_cable_plans_options = ref([]);
const current_router_plans_options = ref([]);
const current_educational_plans_options = ref([]);
const priceAlterationOptions = ref({ percentage: 'percentage', direct: 'direct' });
// const yesOrNoOptions = ref({ yes: 'Yes', no: 'No' });
const yesOrNoOptions = ref({ yes: 'yes', no: 'no' });
// const mtnDataPlansOptions = ref({ gsubz_mtn_sme: 'gsubz_mtn_sme', gsubz_mtn_cg: 'gsubz_mtn_cg', gsubz_mtncg: 'gsubz_mtncg', gsubz_mtn_cg_lite:  'gsubz_mtn_cg_lite', gsubz_mtn_coupon: 'gsubz_mtn_coupon', clubkonnect: 'clubkonnect', eminence: 'eminence' })

// const hasTermsAndPrivacyPolicyFeature = computed(() => page.props.jetstream?.hasTermsAndPrivacyPolicyFeature)

const lengthOptions = ref([
  10,
  20,
  50,
  100
]);

const airtime_settings_form = useForm({
  'platform': props.airtime_platforms[props.networks[0]][Object.keys(props.airtime_platforms[props.networks[0]])[0]],
  'network': props.networks[0],
  'discount': 0.00,
  
})

const data_settings_form = useForm({
  'platform': props.data_platforms[props.networks[0]][Object.keys(props.data_platforms[props.networks[0]])[0]],
  'network': props.networks[0],
  'modify_prices_status': yesOrNoOptions.value.no,
  'price_alteration_option': priceAlterationOptions.value.percentage,
  'percentage': null,
  'added_amount': null,
  'plans': []
})

const electricity_settings_form = useForm({
  'platform': props.electricity_platforms[Object.keys(props.electricity_platforms)[0]],
  
})


console.log()
const cable_settings_form = useForm({
  'platform': props.cable_platforms[props.tvs[0]][Object.keys(props.cable_platforms[props.tvs[0]])[0]],
  'network': props.tvs[0],
  'modify_prices_status': yesOrNoOptions.value.no,
  'price_alteration_option': priceAlterationOptions.value.percentage,
  'percentage': null,
  'added_amount': null,
  'plans': []
})

const router_settings_form = useForm({
  'platform': props.cable_platforms[props.tvs[0]][Object.keys(props.cable_platforms[props.tvs[0]])[0]],
  'network': props.routers[0],
  'modify_prices_status': yesOrNoOptions.value.no,
  'price_alteration_option': priceAlterationOptions.value.percentage,
  'percentage': null,
  'added_amount': null,
  'plans': []
})

const educational_settings_form = useForm({
  'platform': props.educational_platforms[props.educationals[0]][Object.keys(props.educational_platforms[props.educationals[0]])[0]],
  'network': props.educationals[0],
  'modify_prices_status': yesOrNoOptions.value.no,
  'price_alteration_option': priceAlterationOptions.value.percentage,
  'percentage': null,
  'added_amount': null,
  'plans': []
})

const vtu_history_props = ref({

  'page': 1,
  'length': 10,

  'name': null,
  'user_name': null,
  'email': null,
  'type': null,
  'sub_type': null,
  'order_id': null,
  'number': null,
  'amount': null,
  
  'date': null,
  'start_date': null,
  'end_date': null,
})

const clearFilterFormVtuHistory = () => {
  vtu_history_props.value.page = 1;
  vtu_history_props.value.length = 10;

  vtu_history_props.value.name = null;
  vtu_history_props.value.user_name = null;
  vtu_history_props.value.email = null;
  vtu_history_props.value.type = null;
  vtu_history_props.value.sub_type = null;
  vtu_history_props.value.order_id = null;
  vtu_history_props.value.number = null;
  vtu_history_props.value.amount = null;
  
  vtu_history_props.value.date = null;
  vtu_history_props.value.start_date = null;
  vtu_history_props.value.end_date = null;
}



const openPage = (page) => {
  current_page.value = page
}

onMounted(() => {
  if (props.history_opened){
    viewVtuHistory();
  }
});

const manageVtuSettings = () => {
  openPage(2);
}

const manageDataSettings = () => {
  openPage(3);
}

const manageCableSettings = () => {
  openPage(9);
}

const manageRouterSettings = () => {
  openPage(11);
}


const manageDataNetwork = (index) => {
  data_settings_form.platform = props.data_platforms[props.networks[index]][Object.keys(props.data_platforms[props.networks[index]])[0]];
  selected_data_network.value = index;
  loadDataPlanDetails();
}




const loadDataPlanDetails = async (temp = false, platform_changed = false) => {
  
  try {
    
    delete data_settings_form.temp;
    var network = props.networks[selected_data_network.value];
    data_settings_form.network = network;
    current_data_plans_options.value = dataPlansOptions.value[data_settings_form.network];
    Swal.fire({
      title: 'Please wait',
      html: `<span class='capitalize'>Loading .....</span>`,
      icon: 'info',
      showConfirmButton: false,
      allowEscapeKey: false,
      allowOutsideClick: false,
    });

    let queryRoute = route('load_data_plans_details_by_network_admin');
    console.log(data_settings_form)
    let params = data_settings_form;
    console.log(data_settings_form)
    console.log(temp)
    if(temp){
      params.temp = true;
    }else{
      clearDataSettingsForm();
    }

    console.log(params)

    if (platform_changed) {
      params.platform_changed = true;
    }

    const response = await axios.post(queryRoute,  params );

    console.log(response)
    Swal.close()

    // tests.value = response.data;
    if(response.data.success){
      
      data_network_details.value = response.data;
      
      //data_settings_form.platform = dataPlansOptions.value[network][data_network_details.value.current_platform];
      if(!temp){
        data_settings_form.platform = data_network_details.value.current_platform;
      }
      
      if(response.data.modify_prices_status == 'yes'){
        if (response.data.plans.length == 0){
          Swal.fire({
            title: 'Ooops!',
            html: 'Seems this plan is not available at the moment. Please select another one.',
            icon: 'error',

          });
          // data_settings_form.platform = data_network_details.value.current_platform;
          clearDataSettingsForm();
          openPage(4);
          return;
        }
      }

      data_settings_form.modify_prices_status = data_network_details.value.modify_prices_status;
      data_settings_form.price_alteration_option = data_network_details.value.price_alteration_option;
      data_settings_form.percentage = data_network_details.value.percentage;
      data_settings_form.added_amount = data_network_details.value.added_amount;
      
      data_settings_form.plans = response.data.plans;
      console.log(data_settings_form.platform)
      // console.log(dataPlansOptions.value[network])
      openPage(4);
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

const clearDataSettingsForm = () => {
  
  data_settings_form.modify_prices_status = yesOrNoOptions.value.no;
  data_settings_form.price_alteration_option = 'percentage';
  data_settings_form.percentage = 0;
  data_settings_form.added_amount = 0.00;

  data_settings_form.plans = [];
}

const calcPlansPricesWithPercAndAddAmt = () => {
  if (data_settings_form.plans.length > 0){
    for (let i = 0; i < data_settings_form.plans.length; i++){
      data_settings_form.plans[i].old_price = Number(data_settings_form.plans[i].old_price);
      data_settings_form.plans[i].old_price = data_settings_form.plans[i].old_price;
      var new_price = data_settings_form.percentage / 100;
      new_price = new_price * data_settings_form.plans[i].old_price;
      console.log(new_price)
      new_price += data_settings_form.plans[i].old_price;
      new_price = new_price + Number(data_settings_form.added_amount);

      data_settings_form.plans[i].new_price = parseFloat(new_price).toFixed(2);
    }
  }
}




const submitDataSettingsForm = () => {
  Swal.fire({
    title: 'Proceed?',
    html: `Are you sure you want to proceed with saving these settings and prices?`,
    icon: 'question',
    showCancelButton: false,
    showDenyButton: true,
    confirmButtonColor: '#3085d6',
    denyButtonColor: '#059669',
    confirmButtonText: 'Yes Proceed?',
    denyButtonText: "No"

  }).then((result) => {
    if (result.isConfirmed) {
      if (!data_settings_form.processing) {


        data_settings_form.post(route('save_data_plans_settings'), {
          preserveScroll: true,
          onSuccess: (page) => {

            var response = page.props.flash.data;
            console.log(response)
            if (response.success) {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: `Data settings and prices saved succesfully`,
              })
            }else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `Something went wrong`,
              })
            }

          }, onError: (errors) => {
            var size = Object.keys(errors).length;
            // errors_size.value = size;
            // console.log(errors_size.value)
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: size > 1 ? `There are ${size} form errors. Please fix them` : `There is ${size} form error. Please fix them`,
            })
          },

        });
      }
      

    }
  });
}

const manageAirtimeSettings = () => {
  openPage(5);
}

const manageAirtimeNetwork = (index) => {
  airtime_settings_form.platform = props.airtime_platforms[props.networks[index]][Object.keys(props.airtime_platforms[props.networks[index]])[0]];
  selected_airtime_network.value = index;
  loadAirtimePlanDetails();
}

const loadAirtimePlanDetails = async (temp = false) => {

  try {

    delete airtime_settings_form.temp;
    var network = props.networks[selected_airtime_network.value];
    airtime_settings_form.network = network;
    current_airtime_plans_options.value = airtimePlansOptions.value[airtime_settings_form.network];
    Swal.fire({
      title: 'Please wait',
      html: `<span class='capitalize'>Loading .....</span>`,
      icon: 'info',
      showConfirmButton: false,
      allowEscapeKey: false,
      allowOutsideClick: false,
    });

    let queryRoute = route('load_airtime_details_by_network_admin');
    var params = airtime_settings_form;
    
    if (temp) {
      params.temp = true;
    }else{
      clearAirtimeSettingsForm();
    }

    const response = await axios.post(queryRoute, params);

    console.log(response)
    Swal.close()

    // tests.value = response.data;
    if (response.data.success) {

      airtime_network_details.value = response.data;


      airtime_settings_form.discount = airtime_network_details.value.discount;
      
      if (!temp) {
        airtime_settings_form.platform = airtime_network_details.value.current_platform;
      }

      console.log(airtime_settings_form.platform)
      openPage(6);
    } else {
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

const clearAirtimeSettingsForm = () => {
  airtime_settings_form.discount = 0.00;
}

const submitAirtimeSettingsForm = () => {
  Swal.fire({
    title: 'Proceed?',
    html: `Are you sure you want to proceed with saving these settings?`,
    icon: 'question',
    showCancelButton: false,
    showDenyButton: true,
    confirmButtonColor: '#3085d6',
    denyButtonColor: '#059669',
    confirmButtonText: 'Yes Proceed?',
    denyButtonText: "No"

  }).then((result) => {
    if (result.isConfirmed) {
      if (!airtime_settings_form.processing) {


        airtime_settings_form.post(route('save_airtime_plans_settings'), {
          preserveScroll: true,
          onSuccess: (page) => {

            var response = page.props.flash.data;
            console.log(response)
            if (response.success) {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: `Airtime settings saved succesfully`,
              })
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `Something went wrong`,
              })
            }

          }, onError: (errors) => {
            var size = Object.keys(errors).length;
            // errors_size.value = size;
            // console.log(errors_size.value)
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: size > 1 ? `There are ${size} form errors. Please fix them` : `There is ${size} form error. Please fix them`,
            })
          },

        });
      }


    }
  });
}

const manageElectricitySettings = async () => {
  try {

    
    Swal.fire({
      title: 'Please wait',
      html: `<span class='capitalize'>Loading .....</span>`,
      icon: 'info',
      showConfirmButton: false,
      allowEscapeKey: false,
      allowOutsideClick: false,
    });

    let queryRoute = route('load_electricity_details_admin');

    const response = await axios.post(queryRoute, electricity_settings_form);

    console.log(response)
    Swal.close()
    if (response.data.success) {

      electricity_details.value = response.data;
      electricity_settings_form.platform = electricity_details.value.current_platform;
      
      openPage(7);
    } else {
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
}

const submitElectricitySettingsForm = () => {
  Swal.fire({
    title: 'Proceed?',
    html: `Are you sure you want to proceed with saving these settings?`,
    icon: 'question',
    showCancelButton: false,
    showDenyButton: true,
    confirmButtonColor: '#3085d6',
    denyButtonColor: '#059669',
    confirmButtonText: 'Yes Proceed?',
    denyButtonText: "No"

  }).then((result) => {
    if (result.isConfirmed) {
      if (!electricity_settings_form.processing) {


        electricity_settings_form.post(route('save_electricity_plans_settings'), {
          preserveScroll: true,
          onSuccess: (page) => {

            var response = page.props.flash.data;
            console.log(response)
            if (response.success) {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: `Electricity settings saved succesfully`,
              })
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `Something went wrong`,
              })
            }

          }, onError: (errors) => {
            var size = Object.keys(errors).length;
            // errors_size.value = size;
            // console.log(errors_size.value)
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: size > 1 ? `There are ${size} form errors. Please fix them` : `There is ${size} form error. Please fix them`,
            })
          },

        });
      }


    }
  });
}



const viewVtuHistory = async (url = null) => {
  
  try {

    
    console.log(url)
    if (url != null) {
      var urlParams = new URLSearchParams(url);
      console.log(urlParams)
      var page = urlParams.get('page');
      vtu_history_props.value.page = page
      console.log(page)
    }


    // return

    Swal.fire({
      title: 'Please wait',
      html: 'Loading Vtu History.....',
      icon: 'info',
      showConfirmButton: false,
      allowEscapeKey: false,
      allowOutsideClick: false,
    });
    
    let queryRoute = route('load_all_vtu_history_admin');

    const response = await axios.post(queryRoute, null, { params: vtu_history_props.value });

    console.log(response)
    Swal.close()
    
    vtu_history.value = response.data;
    openPage(8);
    
    
    
    
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

const manageCableTvOption = (index) => {
  cable_settings_form.platform = props.cable_platforms[props.tvs[index]][Object.keys(props.cable_platforms[props.tvs[index]])[0]];
  selected_cable_network.value = index;
  loadCablePlanDetails();
}

const loadCablePlanDetails = async (temp = false, platform_changed = false) => {
  // console.log(platform_changed)
  // console.log(cable_settings_form.platform)
  
  try {
    delete cable_settings_form.temp;
    var network = props.tvs[selected_cable_network.value];
    cable_settings_form.network = network;
    current_cable_plans_options.value = cablePlansOptions.value[cable_settings_form.network];
    Swal.fire({
      title: 'Please wait',
      html: `<span class='capitalize'>Loading .....</span>`,
      icon: 'info',
      showConfirmButton: false,
      allowEscapeKey: false,
      allowOutsideClick: false,
    });

    let queryRoute = route('load_cable_plans_details_by_network_admin');
    var params = cable_settings_form;
    if (temp) {
      params.temp = true;
    } else {
      clearCableSettingsForm();
    }

    if (platform_changed) {
      params.platform_changed = true;
    }

    const response = await axios.post(queryRoute, params);

    console.log(response)
    Swal.close()

    // tests.value = response.data;
    if (response.data.success) {

      cable_network_details.value = response.data;

      //data_settings_form.platform = dataPlansOptions.value[network][data_network_details.value.current_platform];
      if (!temp) {
        cable_settings_form.platform = cable_network_details.value.current_platform;
      }

      if (response.data.modify_prices_status == 'yes') {
        if (response.data.plans.length == 0) {
          Swal.fire({
            title: 'Ooops!',
            html: 'Seems this plan is not available at the moment. Please select another one.',
            icon: 'error',

          });
          // data_settings_form.platform = data_network_details.value.current_platform;
          clearCableSettingsForm();
          openPage(10);
          return;
        }
      }

      cable_settings_form.modify_prices_status = cable_network_details.value.modify_prices_status;
      cable_settings_form.price_alteration_option = cable_network_details.value.price_alteration_option;
      cable_settings_form.percentage = cable_network_details.value.percentage;
      cable_settings_form.added_amount = cable_network_details.value.added_amount;

      cable_settings_form.plans = response.data.plans;
      console.log(cable_settings_form.platform)
      // console.log(dataPlansOptions.value[network])
      openPage(10);
    } else {
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

const clearCableSettingsForm = () => {
  
  cable_settings_form.modify_prices_status = yesOrNoOptions.value.no;
  cable_settings_form.price_alteration_option = 'percentage';
  cable_settings_form.percentage = 0;
  cable_settings_form.added_amount = 0.00;

  cable_settings_form.plans = [];
}

const submitCableSettingsForm = () => {
  Swal.fire({
    title: 'Proceed?',
    html: `Are you sure you want to proceed with saving these settings and prices?`,
    icon: 'question',
    showCancelButton: false,
    showDenyButton: true,
    confirmButtonColor: '#3085d6',
    denyButtonColor: '#059669',
    confirmButtonText: 'Yes Proceed?',
    denyButtonText: "No"

  }).then((result) => {
    if (result.isConfirmed) {
      if (!cable_settings_form.processing) {


        cable_settings_form.post(route('save_cable_plans_settings'), {
          preserveScroll: true,
          onSuccess: (page) => {

            var response = page.props.flash.data;
            console.log(response)
            if (response.success) {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: `Cable tv settings and prices saved succesfully`,
              })
            }else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `Something went wrong`,
              })
            }

          }, onError: (errors) => {
            var size = Object.keys(errors).length;
            // errors_size.value = size;
            // console.log(errors_size.value)
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: size > 1 ? `There are ${size} form errors. Please fix them` : `There is ${size} form error. Please fix them`,
            })
          },

        });
      }
      

    }
  });
}

const calcCablePlansPricesWithPercAndAddAmt = () => {
  if (cable_settings_form.plans.length > 0){
    for (let i = 0; i < cable_settings_form.plans.length; i++){
      cable_settings_form.plans[i].old_price = Number(cable_settings_form.plans[i].old_price);
      cable_settings_form.plans[i].old_price = cable_settings_form.plans[i].old_price;
      var new_price = cable_settings_form.percentage / 100;
      new_price = new_price * cable_settings_form.plans[i].old_price;
      console.log(new_price)
      new_price += cable_settings_form.plans[i].old_price;
      new_price = new_price + Number(cable_settings_form.added_amount);

      cable_settings_form.plans[i].new_price = parseFloat(new_price).toFixed(2);
    }
  }
}

const manageRouterOption = (index) => {
  router_settings_form.platform = props.router_platforms[props.routers[index]][Object.keys(props.router_platforms[props.routers[index]])[0]];
  selected_router_network.value = index;
  loadRouterPlanDetails();
}

const loadRouterPlanDetails = async (temp = false, platform_changed = false) => {
  // console.log(platform_changed)
  // console.log(router_settings_form.platform)
  try {
    delete router_settings_form.temp;
    var network = props.routers[selected_router_network.value];
    router_settings_form.network = network;
    current_router_plans_options.value = routerPlansOptions.value[router_settings_form.network];
    Swal.fire({
      title: 'Please wait',
      html: `<span class='capitalize'>Loading .....</span>`,
      icon: 'info',
      showConfirmButton: false,
      allowEscapeKey: false,
      allowOutsideClick: false,
    });

    let queryRoute = route('load_router_plans_details_by_network_admin');
    var params = router_settings_form;
    if (temp) {
      params.temp = true;
    }else{
      clearRouterSettingsForm();
    }


    if (platform_changed) {
      params.platform_changed = true;
    }

    const response = await axios.post(queryRoute, params);

    console.log(response)
    Swal.close()

    // tests.value = response.data;
    if (response.data.success) {

      router_network_details.value = response.data;

      //data_settings_form.platform = dataPlansOptions.value[network][data_network_details.value.current_platform];
      if (!temp) {
        router_settings_form.platform = router_network_details.value.current_platform;
      }

      if (response.data.modify_prices_status == 'yes') {
        if (response.data.plans.length == 0) {
          Swal.fire({
            title: 'Ooops!',
            html: 'Seems this plan is not available at the moment. Please select another one.',
            icon: 'error',

          });
          // data_settings_form.platform = data_network_details.value.current_platform;
          clearRouterSettingsForm();
          openPage(12);
          return;
        }
      }

      router_settings_form.modify_prices_status = router_network_details.value.modify_prices_status;
      router_settings_form.price_alteration_option = router_network_details.value.price_alteration_option;
      router_settings_form.percentage = router_network_details.value.percentage;
      router_settings_form.added_amount = router_network_details.value.added_amount;

      router_settings_form.plans = response.data.plans;
      console.log(router_settings_form.platform)
      // console.log(dataPlansOptions.value[network])
      openPage(12);
    } else {
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

const clearRouterSettingsForm = () => {
  
  router_settings_form.modify_prices_status = yesOrNoOptions.value.no;
  router_settings_form.price_alteration_option = 'percentage';
  router_settings_form.percentage = 0;
  router_settings_form.added_amount = 0.00;

  router_settings_form.plans = [];
}

const calcRouterPlansPricesWithPercAndAddAmt = () => {
  if (router_settings_form.plans.length > 0){
    for (let i = 0; i < router_settings_form.plans.length; i++){
      router_settings_form.plans[i].old_price = Number(router_settings_form.plans[i].old_price);
      router_settings_form.plans[i].old_price = router_settings_form.plans[i].old_price;
      var new_price = router_settings_form.percentage / 100;
      new_price = new_price * router_settings_form.plans[i].old_price;
      console.log(new_price)
      new_price += router_settings_form.plans[i].old_price;
      new_price = new_price + Number(router_settings_form.added_amount);

      router_settings_form.plans[i].new_price = parseFloat(new_price).toFixed(2);
    }
  }
}

const submitRouterSettingsForm = () => {
  Swal.fire({
    title: 'Proceed?',
    html: `Are you sure you want to proceed with saving these settings and prices?`,
    icon: 'question',
    showCancelButton: false,
    showDenyButton: true,
    confirmButtonColor: '#3085d6',
    denyButtonColor: '#059669',
    confirmButtonText: 'Yes Proceed?',
    denyButtonText: "No"

  }).then((result) => {
    if (result.isConfirmed) {
      if (!router_settings_form.processing) {


        router_settings_form.post(route('save_router_plans_settings'), {
          preserveScroll: true,
          onSuccess: (page) => {

            var response = page.props.flash.data;
            console.log(response)
            if (response.success) {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: `Router settings and prices saved succesfully`,
              })
            }else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `Something went wrong`,
              })
            }

          }, onError: (errors) => {
            var size = Object.keys(errors).length;
            // errors_size.value = size;
            // console.log(errors_size.value)
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: size > 1 ? `There are ${size} form errors. Please fix them` : `There is ${size} form error. Please fix them`,
            })
          },

        });
      }
      

    }
  });
}

const manageEductaionalSettings = () => {
  openPage(13);
}

const manageEductaionalsOption = (index) => {
  educational_settings_form.platform = props.educational_platforms[props.educationals[index]][Object.keys(props.educational_platforms[props.educationals[index]])[0]];
  selected_educational_network.value = index;
  loadEducationalPlanDetails();
}

const loadEducationalPlanDetails = async (temp = false, platform_changed = false) => {
  // console.log(platform_changed)
  // console.log(educational_settings_form.platform)
  try {

    delete educational_settings_form.temp;
    var network = props.educationals[selected_educational_network.value];
    educational_settings_form.network = network;
    current_educational_plans_options.value = educationalPlansOptions.value[educational_settings_form.network];

    Swal.fire({
      title: 'Please wait',
      html: `<span class='capitalize'>Loading .....</span>`,
      icon: 'info',
      showConfirmButton: false,
      allowEscapeKey: false,
      allowOutsideClick: false,
    });

    let queryRoute = route('load_educational_plans_details_by_network_admin');
    var params = educational_settings_form;
    if (temp) {
      params.temp = true;
    } else {
      clearEducationalSettingsForm();
    }

    if (platform_changed) {
      params.platform_changed = true;
    }

    const response = await axios.post(queryRoute, params);

    console.log(response)
    Swal.close()

    // tests.value = response.data;
    if (response.data.success) {

      educational_network_details.value = response.data;

      //data_settings_form.platform = dataPlansOptions.value[network][data_network_details.value.current_platform];
      if (!temp) {
        educational_settings_form.platform = educational_network_details.value.current_platform;
      }

      if (response.data.modify_prices_status == 'yes') {
        if (response.data.plans.length == 0) {
          Swal.fire({
            title: 'Ooops!',
            html: 'Seems this plan is not available at the moment. Please select another one.',
            icon: 'error',

          });
          // data_settings_form.platform = data_network_details.value.current_platform;
          clearEducationalSettingsForm();
          openPage(14);
          return;
        }
      }

      educational_settings_form.modify_prices_status = educational_network_details.value.modify_prices_status;
      educational_settings_form.price_alteration_option = educational_network_details.value.price_alteration_option;
      educational_settings_form.percentage = educational_network_details.value.percentage;
      educational_settings_form.added_amount = educational_network_details.value.added_amount;

      educational_settings_form.plans = response.data.plans;
      console.log(educational_settings_form.platform)
      // console.log(dataPlansOptions.value[network])
      openPage(14);
    } else {
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

const clearEducationalSettingsForm = () => {
  
  educational_settings_form.modify_prices_status = yesOrNoOptions.value.no;
  educational_settings_form.price_alteration_option = 'percentage';
  educational_settings_form.percentage = 0;
  educational_settings_form.added_amount = 0.00;

  educational_settings_form.plans = [];
}

const calcEducationalPlansPricesWithPercAndAddAmt = () => {
  if (educational_settings_form.plans.length > 0){
    for (let i = 0; i < educational_settings_form.plans.length; i++){
      educational_settings_form.plans[i].old_price = Number(educational_settings_form.plans[i].old_price);
      educational_settings_form.plans[i].old_price = educational_settings_form.plans[i].old_price;
      var new_price = educational_settings_form.percentage / 100;
      new_price = new_price * educational_settings_form.plans[i].old_price;
      console.log(new_price)
      new_price += educational_settings_form.plans[i].old_price;
      new_price = new_price + Number(educational_settings_form.added_amount);

      educational_settings_form.plans[i].new_price = parseFloat(new_price).toFixed(2);
    }
  }
}

const submitEducationalSettingsForm = () => {
  Swal.fire({
    title: 'Proceed?',
    html: `Are you sure you want to proceed with saving these settings and prices?`,
    icon: 'question',
    showCancelButton: false,
    showDenyButton: true,
    confirmButtonColor: '#3085d6',
    denyButtonColor: '#059669',
    confirmButtonText: 'Yes Proceed?',
    denyButtonText: "No"

  }).then((result) => {
    if (result.isConfirmed) {
      if (!educational_settings_form.processing) {


        educational_settings_form.post(route('save_educational_plans_settings'), {
          preserveScroll: true,
          onSuccess: (page) => {

            var response = page.props.flash.data;
            console.log(response)
            if (response.success) {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: `Educational voucher settings and prices saved succesfully`,
              })
            }else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `Something went wrong`,
              })
            }

          }, onError: (errors) => {
            var size = Object.keys(errors).length;
            // errors_size.value = size;
            // console.log(errors_size.value)
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: size > 1 ? `There are ${size} form errors. Please fix them` : `There is ${size} form error. Please fix them`,
            })
          },

        });
      }
      

    }
  });
}
</script>

<template inheritAttrs="false">
  <LayoutAuthenticated>

    <Head :title="`Manage VTU`" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiBriefcaseEditOutline" :title="`Manage VTU`" main>
        <!-- <BaseButton href="https://github.com/justboil/admin-one-vue-tailwind" target="_blank" :icon="mdiGithub"
          label="Star on GitHub" color="contrast" rounded-full small /> -->
      </SectionTitleLineWithButton>
      <!-- <NotificationBar color="info" :icon="mdiMonitorCellphone">
        <b>Responsive table.</b> Collapses on mobile
      </NotificationBar> -->

      <div v-if="current_page == 14" class="mt-[30px]">
        <CardBox class="mb-6" @submit.prevent="submitEducationalSettingsForm" isForm>
          <h2 class="text-2xl font-semibold capitalize"
            v-html="`Manage ${educational_settings_form.network} educational vouchers settings`">
          </h2>

          <div class="sm:grid sm:grid-cols-12 sm:gap-6 mt-[50px]">
            <FormField class="w-full sm:col-span-12 my-2" label="Select Platform" wrap-body>
              <FormCheckRadioGroup @change="loadEducationalPlanDetails(true, true)"
                v-model="educational_settings_form.platform" :error="educational_settings_form.errors.platform"
                name="platform" :options="current_educational_plans_options" type="radio" />


            </FormField>

            <FormField class="w-full sm:col-span-12 my-1" label="Alter prices">
              <FormCheckRadioGroup @change="loadEducationalPlanDetails(true)"
                v-model="educational_settings_form.modify_prices_status"
                :error="educational_settings_form.errors.modify_prices_status" name="modify_prices_status" type="radio"
                :options="yesOrNoOptions" />
            </FormField>

            <FormField v-if="educational_settings_form.modify_prices_status == yesOrNoOptions.yes"
              class="w-full sm:col-span-12 my-1" label="Choose price alteration option">
              <FormCheckRadioGroup @change="loadEducationalPlanDetails(true)"
                v-model="educational_settings_form.price_alteration_option"
                :error="educational_settings_form.errors.price_alteration_option" name="price_alteration_option"
                type="radio" :options="priceAlterationOptions" />
            </FormField>

            <FormField
              v-if="educational_settings_form.modify_prices_status == yesOrNoOptions.yes && educational_settings_form.price_alteration_option == 'percentage'"
              class="sm:col-span-4" label="Percentage">
              <FormControl v-model="educational_settings_form.percentage"
                :error="educational_settings_form.errors.percentage" type="number" />
            </FormField>

            <FormField
              v-if="educational_settings_form.modify_prices_status == yesOrNoOptions.yes && educational_settings_form.price_alteration_option == 'percentage'"
              class="sm:col-span-4" label="Additional Amount">
              <FormControl v-model="educational_settings_form.added_amount"
                :error="educational_settings_form.errors.added_amount" type="number" />
            </FormField>

            <div
              v-if="educational_settings_form.modify_prices_status == yesOrNoOptions.yes && educational_settings_form.price_alteration_option == 'percentage'"
              class="sm:col-span-2">
              <BaseButton @click="calcEducationalPlansPricesWithPercAndAddAmt"
                :disabled="educational_settings_form.processing" type="button" color="bg-blue-500" label="Refresh Plans"
                class="w-full text-white my-4 mt-6" />
            </div>

            <div
              v-if="educational_settings_form.plans.length > 0 && educational_settings_form.modify_prices_status == yesOrNoOptions.yes"
              class="sm:col-span-12">
              <table>
                <thead>
                  <tr>

                    <th>#</th>
                    <th>Plan Name</th>
                    <th>Old Price</th>
                    <th>New Price</th>


                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(row, index) in educational_settings_form.plans" :key="index">

                    <td>{{ index + 1 }}. </td>


                    <td class="capitalize" data-label="Plan Name">
                      {{ row.name }}
                    </td>
                    <td class="" data-label="Old Price">
                      {{ mainStore.addCommas(row.old_price) }}
                    </td>
                    <td v-if="educational_settings_form.price_alteration_option == 'percentage'" data-label="New Price">
                      {{ mainStore.addCommas(row.new_price) }}
                    </td>

                    <td v-else data-label="New Price">
                      <FormControl v-model="educational_settings_form.plans[index].new_price" type="number" />
                    </td>

                  </tr>
                </tbody>
              </table>
            </div>



          </div>
          <BaseButton :disabled="educational_settings_form.processing" type="submit" color="bg-green-600"
            label="Save Settings" class="w-full text-white my-4 mt-6" />
        </CardBox>
      </div>

      <div v-if="current_page == 13" class="mt-[30px]">
        <CardBox class="mb-6">
          <h2 class="text-2xl font-semibold">Manage Educational Voucher Settings</h2>

          <ul v-if="educationals.length > 0" class="divide-y-2 divide-gray-400 mt-[50px]">

            <li v-for="(educational, index) in educationals" @click="manageEductaionalsOption(index)"
              class="listview-list" :key="index">
              <span class="font-semibold capitalize">{{ index + 1 }}. {{ educational }}</span>
            </li>


          </ul>
        </CardBox>
      </div>

      <div v-if="current_page == 12" class="mt-[30px]">
        <CardBox class="mb-6" @submit.prevent="submitRouterSettingsForm" isForm>
          <h2 class="text-2xl font-semibold capitalize"
            v-html="`Manage ${router_settings_form.network} router settings`">
          </h2>

          <div class="sm:grid sm:grid-cols-12 sm:gap-6 mt-[50px]">
            <FormField class="w-full sm:col-span-12 my-2" label="Select Platform" wrap-body>
              <FormCheckRadioGroup @change="loadRouterPlanDetails(true, true)" v-model="router_settings_form.platform"
                :error="router_settings_form.errors.platform" name="platform" :options="current_router_plans_options"
                type="radio" />


            </FormField>

            <FormField class="w-full sm:col-span-12 my-1" label="Alter prices">
              <FormCheckRadioGroup @change="loadRouterPlanDetails(true)"
                v-model="router_settings_form.modify_prices_status"
                :error="router_settings_form.errors.modify_prices_status" name="modify_prices_status" type="radio"
                :options="yesOrNoOptions" />
            </FormField>

            <FormField v-if="router_settings_form.modify_prices_status == yesOrNoOptions.yes"
              class="w-full sm:col-span-12 my-1" label="Choose price alteration option">
              <FormCheckRadioGroup @change="loadRouterPlanDetails(true)"
                v-model="router_settings_form.price_alteration_option"
                :error="router_settings_form.errors.price_alteration_option" name="price_alteration_option" type="radio"
                :options="priceAlterationOptions" />
            </FormField>

            <FormField
              v-if="router_settings_form.modify_prices_status == yesOrNoOptions.yes && router_settings_form.price_alteration_option == 'percentage'"
              class="sm:col-span-4" label="Percentage">
              <FormControl v-model="router_settings_form.percentage" :error="router_settings_form.errors.percentage"
                type="number" />
            </FormField>

            <FormField
              v-if="router_settings_form.modify_prices_status == yesOrNoOptions.yes && router_settings_form.price_alteration_option == 'percentage'"
              class="sm:col-span-4" label="Additional Amount">
              <FormControl v-model="router_settings_form.added_amount" :error="router_settings_form.errors.added_amount"
                type="number" />
            </FormField>

            <div
              v-if="router_settings_form.modify_prices_status == yesOrNoOptions.yes && router_settings_form.price_alteration_option == 'percentage'"
              class="sm:col-span-2">
              <BaseButton @click="calcRouterPlansPricesWithPercAndAddAmt" :disabled="router_settings_form.processing"
                type="button" color="bg-blue-500" label="Refresh Plans" class="w-full text-white my-4 mt-6" />
            </div>

            <div
              v-if="router_settings_form.plans.length > 0 && router_settings_form.modify_prices_status == yesOrNoOptions.yes"
              class="sm:col-span-12">
              <table>
                <thead>
                  <tr>

                    <th>#</th>
                    <th>Plan Name</th>
                    <th>Old Price</th>
                    <th>New Price</th>


                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(row, index) in router_settings_form.plans" :key="index">

                    <td>{{ index + 1 }}. </td>


                    <td class="capitalize" data-label="Plan Name">
                      {{ row.name }}
                    </td>
                    <td class="" data-label="Old Price">
                      {{ mainStore.addCommas(row.old_price) }}
                    </td>
                    <td v-if="router_settings_form.price_alteration_option == 'percentage'" data-label="New Price">
                      {{ mainStore.addCommas(row.new_price) }}
                    </td>

                    <td v-else data-label="New Price">
                      <FormControl v-model="router_settings_form.plans[index].new_price" type="number" />
                    </td>

                  </tr>
                </tbody>
              </table>
            </div>



          </div>
          <BaseButton :disabled="router_settings_form.processing" type="submit" color="bg-green-600"
            label="Save Settings" class="w-full text-white my-4 mt-6" />
        </CardBox>
      </div>

      <div v-if="current_page == 11" class="mt-[30px]">
        <CardBox class="mb-6">
          <h2 class="text-2xl font-semibold">Manage Router Recharge Settings</h2>

          <ul v-if="routers.length > 0" class="divide-y-2 divide-gray-400 mt-[50px]">

            <li v-for="(router, index) in routers" @click="manageRouterOption(index)" class="listview-list"
              :key="index">
              <span class="font-semibold capitalize">{{ index + 1 }}. {{ router }}</span>
            </li>


          </ul>
        </CardBox>
      </div>

      <div v-if="current_page == 10" class="mt-[30px]">
        <CardBox class="mb-6" @submit.prevent="submitCableSettingsForm" isForm>
          <h2 class="text-2xl font-semibold capitalize"
            v-html="`Manage ${cable_settings_form.network} cable tv settings`">
          </h2>

          <div class="sm:grid sm:grid-cols-12 sm:gap-6 mt-[50px]">
            <FormField class="w-full sm:col-span-12 my-2" label="Select Platform" wrap-body>
              <FormCheckRadioGroup @change="loadCablePlanDetails(true, true)" v-model="cable_settings_form.platform"
                :error="cable_settings_form.errors.platform" name="platform" :options="current_cable_plans_options"
                type="radio" />


            </FormField>

            <FormField class="w-full sm:col-span-12 my-1" label="Alter prices">
              <FormCheckRadioGroup @change="loadCablePlanDetails(true)"
                v-model="cable_settings_form.modify_prices_status"
                :error="cable_settings_form.errors.modify_prices_status" name="modify_prices_status" type="radio"
                :options="yesOrNoOptions" />
            </FormField>

            <FormField v-if="cable_settings_form.modify_prices_status == yesOrNoOptions.yes"
              class="w-full sm:col-span-12 my-1" label="Choose price alteration option">
              <FormCheckRadioGroup @change="loadCablePlanDetails(true)"
                v-model="cable_settings_form.price_alteration_option"
                :error="cable_settings_form.errors.price_alteration_option" name="price_alteration_option" type="radio"
                :options="priceAlterationOptions" />
            </FormField>

            <FormField
              v-if="cable_settings_form.modify_prices_status == yesOrNoOptions.yes && cable_settings_form.price_alteration_option == 'percentage'"
              class="sm:col-span-4" label="Percentage">
              <FormControl v-model="cable_settings_form.percentage" :error="cable_settings_form.errors.percentage"
                type="number" />
            </FormField>

            <FormField
              v-if="cable_settings_form.modify_prices_status == yesOrNoOptions.yes && cable_settings_form.price_alteration_option == 'percentage'"
              class="sm:col-span-4" label="Additional Amount">
              <FormControl v-model="cable_settings_form.added_amount" :error="cable_settings_form.errors.added_amount"
                type="number" />
            </FormField>

            <div
              v-if="cable_settings_form.modify_prices_status == yesOrNoOptions.yes && cable_settings_form.price_alteration_option == 'percentage'"
              class="sm:col-span-2">
              <BaseButton @click="calcCablePlansPricesWithPercAndAddAmt" :disabled="cable_settings_form.processing"
                type="button" color="bg-blue-500" label="Refresh Plans" class="w-full text-white my-4 mt-6" />
            </div>

            <div
              v-if="cable_settings_form.plans.length > 0 && cable_settings_form.modify_prices_status == yesOrNoOptions.yes"
              class="sm:col-span-12">
              <table>
                <thead>
                  <tr>

                    <th>#</th>
                    <th>Plan Name</th>
                    <th>Old Price</th>
                    <th>New Price</th>


                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(row, index) in cable_settings_form.plans" :key="index">

                    <td>{{ index + 1 }}. </td>


                    <td class="capitalize" data-label="Plan Name">
                      {{ row.name }}
                    </td>
                    <td class="" data-label="Old Price">
                      {{ mainStore.addCommas(row.old_price) }}
                    </td>
                    <td v-if="cable_settings_form.price_alteration_option == 'percentage'" data-label="New Price">
                      {{ mainStore.addCommas(row.new_price) }}
                    </td>

                    <td v-else data-label="New Price">
                      <FormControl v-model="cable_settings_form.plans[index].new_price" type="number" />
                    </td>

                  </tr>
                </tbody>
              </table>
            </div>



          </div>
          <BaseButton :disabled="cable_settings_form.processing" type="submit" color="bg-green-600"
            label="Save Settings" class="w-full text-white my-4 mt-6" />
        </CardBox>
      </div>

      <div v-if="current_page == 9" class="mt-[30px]">
        <CardBox class="mb-6">
          <h2 class="text-2xl font-semibold">Manage Cable Tv Settings</h2>

          <ul v-if="tvs.length > 0" class="divide-y-2 divide-gray-400 mt-[50px]">

            <li v-for="(tv, index) in tvs" @click="manageCableTvOption(index)" class="listview-list" :key="index">
              <span class="font-semibold capitalize">{{ index + 1 }}. {{ tv }}</span>
            </li>


          </ul>
        </CardBox>
      </div>

      <div v-if="current_page == 8" class="">

        <CardBox isForm @submit.prevent="viewVtuHistory" class="">
          <div class="sm:grid sm:grid-cols-12 sm:gap-6">
            <FormField class="sm:col-span-4" label="Length">
              <FormControl v-model="vtu_history_props.length" :options="lengthOptions" />
            </FormField>

            <FormField class="sm:col-span-4" label="Full Name">
              <FormControl v-model="vtu_history_props.name" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="User Name">
              <FormControl v-model="vtu_history_props.user_name" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="Email">
              <FormControl v-model="vtu_history_props.email" type="email" />
            </FormField>

            <FormField class="sm:col-span-4" label="Recharge Type">
              <FormControl v-model="vtu_history_props.type" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="Recharge Sub Type">
              <FormControl v-model="vtu_history_props.sub_type" type="text" />
            </FormField>


            <FormField class="sm:col-span-4" label="Amount">
              <FormControl v-model="vtu_history_props.amount" type="number" />
            </FormField>

            <FormField class="sm:col-span-4" label="Order ID">
              <FormControl v-model="vtu_history_props.order_id" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="Number">
              <FormControl v-model="vtu_history_props.number" type="number" />
            </FormField>

            <FormField class="sm:col-span-4" label="Transaction Date ">
              <FormControl v-model="vtu_history_props.date" type="date" />
            </FormField>

            <FormField class="sm:col-span-4" label="Start Date">
              <FormControl v-model="vtu_history_props.start_date" type="date" />
            </FormField>

            <FormField class="sm:col-span-4" label="End Date">
              <FormControl v-model="vtu_history_props.end_date" type="date" />
            </FormField>



          </div>
          <BaseButtons class="mt-5 mb-2">
            <BaseButton type="submit" color="info" label="Filter" class="px-5 mb-0" />

            <BaseButton @click="clearFilterFormVtuHistory" type="reset" color="info" outline label="Clear"
              :icon="mdiClose" class="px-5 mb-0" />
          </BaseButtons>
          <BaseDivider />
        </CardBox>

        <CardBox class="mb-4" has-table>

          <div v-if="vtu_history.data.length > 0" class="">
            <div class="">
              <table class="">
                <thead>
                  <tr>

                    <th></th>

                    <th>Actions</th>
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Sub Type</th>
                    <th>Amount</th>
                    <th>Number</th>
                    <th>Order Id</th>
                    <th>Date</th>
                    <th>Time</th>
                  </tr>
                </thead>


                <tbody class="text-sm">
                  <tr v-for="(row, index) in vtu_history.data" :key="row.id">
                    <td v-html="`${(index + 1) + ((vtu_history.current_page - 1) * vtu_history_props.length)}.`"></td>

                    <td class="before:hidden lg:w-1 whitespace-nowrap">
                      <BaseButtons type="justify-start lg:justify-end" no-wrap>
                        <BaseButton @click="trackThisOrder(row)" color="success" label="Track This Order" small />

                      </BaseButtons>
                    </td>

                    <td class="capitalize">{{ row.name }}</td>
                    <td class="lowercase">{{ row.user_name }}</td>
                    <td class="lowercase">{{ row.email }}</td>
                    <td class="capitalize">{{ row.type }}</td>
                    <td v-html="row.sub_type == 'reloadly' ? '' : row.sub_type"></td>

                    <td data-label="Amount" v-html="mainStore.addCommas((row.amount - 0).toFixed(2))">

                    </td>

                    <td>{{ row.number }}</td>
                    <td><em class="text-primary">{{ row.order_id }}</em></td>
                    <td class="date">{{ row.date }}</td>
                    <td class="time">{{ row.time }}</td>
                  </tr>

                </tbody>
              </table>
            </div>
            <div class="p-3 lg:px-6 border-t border-gray-100 ">
              <BaseLevel>
                <BaseButtons>
                  <BaseButton v-for="page in vtu_history.links" :key="page" :active="page.active" :label="page.label"
                    :color="page.active ? 'lightDark' : 'whiteDark'" small @click="viewVtuHistory(page.url)"
                    :disabled="page.url === null" />
                </BaseButtons>
                <small>Page {{ vtu_history.current_page }} of {{ vtu_history.last_page }}</small>
                <small>{{ vtu_history.total }} total records</small><br>
              </BaseLevel>
            </div>
          </div>

        </CardBox>

      </div>

      <div v-if="current_page == 7" class="mt-[30px]">
        <CardBox class="mb-6" @submit.prevent="submitElectricitySettingsForm" isForm>
          <h2 class="text-2xl font-semibold capitalize" v-html="`Manage electricity recharge settings`">
          </h2>

          <div class="sm:grid sm:grid-cols-12 sm:gap-6 mt-[50px]">
            <FormField class="w-full sm:col-span-12 my-2" label="Select Platform" wrap-body>
              <FormCheckRadioGroup v-model="electricity_settings_form.platform"
                :error="electricity_settings_form.errors.platform" name="platform" :options="electricity_platforms"
                type="radio" />

            </FormField>

          </div>
          <BaseButton :disabled="electricity_settings_form.processing" type="submit" color="bg-green-600"
            label="Save Settings" class="w-full text-white my-4 mt-6" />
        </CardBox>
      </div>

      <div v-if="current_page == 6" class="mt-[30px]">
        <CardBox class="mb-6" @submit.prevent="submitAirtimeSettingsForm" isForm>
          <h2 class="text-2xl font-semibold capitalize"
            v-html="`Manage ${airtime_settings_form.network} airtime topup settings`">
          </h2>

          <div class="sm:grid sm:grid-cols-12 sm:gap-6 mt-[50px]">
            <FormField class="w-full sm:col-span-12 my-2" label="Select Platform" wrap-body>
              <FormCheckRadioGroup @change="loadAirtimePlanDetails(true)" v-model="airtime_settings_form.platform"
                :error="airtime_settings_form.errors.platform" name="platform" :options="current_airtime_plans_options"
                type="radio" />

            </FormField>


            <FormField class="sm:col-span-12" label="Discount">
              <FormControl v-model="airtime_settings_form.discount" :error="airtime_settings_form.errors.discount"
                type="number" />
            </FormField>


          </div>
          <BaseButton :disabled="airtime_settings_form.processing" type="submit" color="bg-green-600"
            label="Save Settings" class="w-full text-white my-4 mt-6" />
        </CardBox>
      </div>

      <div v-if="current_page == 5" class="mt-[30px]">
        <CardBox class="mb-6">
          <h2 class="text-2xl font-semibold">Manage Airtime Topup Settings</h2>

          <ul v-if="networks.length > 0" class="divide-y-2 divide-gray-400 mt-[50px]">

            <li v-for="(network, index) in networks" @click="manageAirtimeNetwork(index)" class="listview-list"
              :key="index">
              <span class="font-semibold capitalize">{{ index + 1 }}. {{ network }}</span>
            </li>


          </ul>
        </CardBox>
      </div>

      <div v-if="current_page == 4" class="mt-[30px]">
        <CardBox class="mb-6" @submit.prevent="submitDataSettingsForm" isForm>
          <h2 class="text-2xl font-semibold capitalize" v-html="`Manage ${data_settings_form.network} data settings`">
          </h2>

          <div class="sm:grid sm:grid-cols-12 sm:gap-6 mt-[50px]">
            <FormField class="w-full sm:col-span-12 my-2" label="Select Platform" wrap-body>
              <FormCheckRadioGroup @change="loadDataPlanDetails(true, true)" v-model="data_settings_form.platform"
                :error="data_settings_form.errors.platform" name="platform" :options="current_data_plans_options"
                type="radio" />


            </FormField>

            <FormField class="w-full sm:col-span-12 my-1" label="Alter prices">
              <FormCheckRadioGroup @change="loadDataPlanDetails(true)" v-model="data_settings_form.modify_prices_status"
                :error="data_settings_form.errors.modify_prices_status" name="modify_prices_status" type="radio"
                :options="yesOrNoOptions" />
            </FormField>

            <FormField v-if="data_settings_form.modify_prices_status == yesOrNoOptions.yes"
              class="w-full sm:col-span-12 my-1" label="Choose price alteration option">
              <FormCheckRadioGroup @change="loadDataPlanDetails(true)"
                v-model="data_settings_form.price_alteration_option"
                :error="data_settings_form.errors.price_alteration_option" name="price_alteration_option" type="radio"
                :options="priceAlterationOptions" />
            </FormField>

            <FormField
              v-if="data_settings_form.modify_prices_status == yesOrNoOptions.yes && data_settings_form.price_alteration_option == 'percentage'"
              class="sm:col-span-4" label="Percentage">
              <FormControl v-model="data_settings_form.percentage" :error="data_settings_form.errors.percentage"
                type="number" />
            </FormField>

            <FormField
              v-if="data_settings_form.modify_prices_status == yesOrNoOptions.yes && data_settings_form.price_alteration_option == 'percentage'"
              class="sm:col-span-4" label="Additional Amount">
              <FormControl v-model="data_settings_form.added_amount" :error="data_settings_form.errors.added_amount"
                type="number" />
            </FormField>

            <div
              v-if="data_settings_form.modify_prices_status == yesOrNoOptions.yes && data_settings_form.price_alteration_option == 'percentage'"
              class="sm:col-span-2">
              <BaseButton @click="calcPlansPricesWithPercAndAddAmt" :disabled="data_settings_form.processing"
                type="button" color="bg-blue-500" label="Refresh Plans" class="w-full text-white my-4 mt-6" />
            </div>

            <div
              v-if="data_settings_form.plans.length > 0 && data_settings_form.modify_prices_status == yesOrNoOptions.yes"
              class="sm:col-span-12">
              <table>
                <thead>
                  <tr>

                    <th>#</th>
                    <th>Plan Name</th>
                    <th>Old Price</th>
                    <th>New Price</th>


                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(row, index) in data_settings_form.plans" :key="index">

                    <td>{{ index + 1 }}. </td>


                    <td class="capitalize" data-label="Plan Name">
                      {{ row.name }}
                    </td>
                    <td class="" data-label="Old Price">
                      {{ mainStore.addCommas(row.old_price) }}
                    </td>
                    <td v-if="data_settings_form.price_alteration_option == 'percentage'" data-label="New Price">
                      {{ mainStore.addCommas(row.new_price) }}
                    </td>

                    <td v-else data-label="New Price">
                      <FormControl v-model="data_settings_form.plans[index].new_price" type="number" />
                    </td>

                  </tr>
                </tbody>
              </table>
            </div>



          </div>
          <BaseButton :disabled="data_settings_form.processing" type="submit" color="bg-green-600" label="Save Settings"
            class="w-full text-white my-4 mt-6" />
        </CardBox>
      </div>

      <div v-if="current_page == 3" class="mt-[30px]">
        <CardBox class="mb-6">
          <h2 class="text-2xl font-semibold">Manage Internet Data Settings</h2>

          <ul v-if="networks.length > 0" class="divide-y-2 divide-gray-400 mt-[50px]">

            <li v-for="(network, index) in networks" @click="manageDataNetwork(index)" class="listview-list"
              :key="index">
              <span class="font-semibold capitalize">{{ index + 1 }}. {{ network }}</span>
            </li>


          </ul>
        </CardBox>
      </div>

      <div v-if="current_page == 2" class="mt-[30px]">
        <CardBox class="mb-6">

          <h3 class="text-2xl font-semibold">Manage VTU Settings</h3>

          <ul class="divide-y-2 divide-gray-400 mt-[50px]">

            <li @click="manageAirtimeSettings" class="listview-list">
              <span class="font-semibold ">1. Airtime Topup </span>
            </li>

            <li @click="manageDataSettings" class="listview-list">
              <span class="font-semibold ">2. Data Recharge </span>
            </li>

            <li @click="manageCableSettings" class="listview-list">
              <span class="font-semibold ">3. Cable Tv Recharge </span>
            </li>

            <li @click="manageElectricitySettings" class="listview-list">
              <span class="font-semibold ">4. Electricity Recharge </span>
            </li>

            <li @click="manageRouterSettings" class="listview-list">
              <span class="font-semibold ">5. Router Recharge </span>
            </li>

            <li @click="manageEductaionalSettings" class="listview-list">
              <span class="font-semibold ">6. Educational Vouchers </span>
            </li>


          </ul>
        </CardBox>
      </div>

      <div v-if="current_page == 1" class="mt-[30px]">
        <CardBox class="mb-6">

          <h3 class="text-2xl font-semibold">Choose Action</h3>

          <ul class="divide-y-2 divide-gray-400 mt-[50px]">

            <li @click="manageVtuSettings" class="listview-list">
              <span class="font-semibold ">1. Manage VTU Settings </span>
            </li>

            <li @click="viewVtuHistory" class="listview-list">
              <span class="font-semibold ">2. View Vtu History</span>
            </li>


          </ul>
        </CardBox>
      </div>

      <FloatingActionButton v-if="current_page == 14" @click="openPage(13)" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>

      <FloatingActionButton v-if="current_page == 13" @click="openPage(2)" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>

      <FloatingActionButton v-if="current_page == 12" @click="openPage(11)" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>

      <FloatingActionButton v-if="current_page == 11" @click="openPage(2)" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>

      <FloatingActionButton v-if="current_page == 10" @click="openPage(9)" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>

      <FloatingActionButton v-if="current_page == 9" @click="openPage(2)" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>

      <FloatingActionButton v-if="current_page == 8" @click="openPage(1)" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>

      <FloatingActionButton v-if="current_page == 7" @click="openPage(2)" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>

      <FloatingActionButton v-if="current_page == 6" @click="openPage(5)" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>

      <FloatingActionButton v-if="current_page == 5" @click="openPage(2)" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>

      <FloatingActionButton v-if="current_page == 4" @click="openPage(3)" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>


      <FloatingActionButton v-if="current_page == 3" @click="current_page = 2" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>

      <FloatingActionButton v-if="current_page == 2" @click="current_page = 1" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>
    </SectionMain>

  </LayoutAuthenticated>
</template>

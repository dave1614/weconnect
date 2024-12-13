
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
  mdiAccountGroup,
  mdiViewDashboard,
  mdiBriefcaseEdit,
  mdiTrashCan,
  mdiCheck,

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
  community_leader_roles: {
    type: Array,
  },

})
const mainStore = useMainStore();

const btn_hovered = ref(false);
const current_page = ref(1);
const useSearchBtn = mainStore.useSearchBtn;
const communities = ref([]);
const community_leaders = ref([]);
const community_members = ref([]);
const community_leaders_requests = ref([]);
const current_leaders = ref([]);

const community_info_temp = ref({});
const community_leader_roles = ref(props.community_leader_roles);

community_leader_roles.value.unshift('all');
community_leader_roles.value.push('subject');
console.log(community_leader_roles.value)

const priceAlterationOptions = ref({ percentage: 'percentage', direct: 'direct' });
// const yesOrNoOptions = ref({ yes: 'Yes', no: 'No' });
const yesOrNoOptions = ref({ yes: 'yes', no: 'no' });

const lengthOptions = ref([
  10,
  20,
  50,
  100
]);

const sortAllCommunitiesOptions = ref([
  'id_asc',
  'id_desc',
  'name_asc',
  'name_desc',
  'lga_asc',
  'lga_desc',
  'state_asc',
  'state_desc',

  'users_num_asc',
  'users_num_desc',
  'last_user_registered_date_asc',
  'last_user_registered_date_desc',
  'community_leaders_num_asc',
  'community_leaders_num_desc',
  'last_community_leader_date_asc',
  'last_community_leader_date_desc',
  'pending_community_leaders_num_asc',
  'pending_community_leaders_num_desc',
  'last_pending_community_leader_date_asc',
  'last_pending_community_leader_date_desc',
])


const all_communities_props = ref({

  'page': 1,
  'length': 10,
  'sort': sortAllCommunitiesOptions.value[1],

  'name': null,
  'lga': null,
  'state': null,

  'users_num': null,
  'last_user_registered_date': null,
  'community_leaders_num': null,
  'last_community_leader_date': null,
  'pending_community_leaders_num': null,
  'last_pending_community_leader_date': null,



})

const clearFilterFormAllCommunitiesHistory = () => {
  all_communities_props.value.page = 1;
  all_communities_props.value.length = 10;
  all_communities_props.value.sort = sortAllCommunitiesOptions.value[1];

  all_communities_props.value.name = null;
  all_communities_props.value.lga = null;
  all_communities_props.value.state = null;

  all_communities_props.value.users_num = null;
  all_communities_props.value.last_user_registered_date = null;
  all_communities_props.value.community_leaders_num = null;
  all_communities_props.value.last_community_leader_date = null;
  all_communities_props.value.pending_community_leaders_num = null;

  all_communities_props.value.last_pending_community_leader_date = null;

}

const sortCommunityLeadersOptions = ref([

  'name_asc',
  'name_desc',
  'user_name_asc',
  'user_name_desc',
  'email_asc',
  'email_desc',
  'phone_asc',
  'phone_desc',

  'position_asc',
  'position_desc',
  'approved_date_asc',
  'approved_date_desc',
  'registration_date_asc',
  'registration_date_desc',
]);


const community_leaders_props = ref({

  'page': 1,
  'length': 10,
  'sort': sortCommunityLeadersOptions.value[10],

  'name': null,
  'user_name': null,
  'email': null,
  'phone': null,

  'position': null,
  'approved_date': null,
  'registration_date': null,


})


const clearFilterFormCommunityLeaders = () => {
  community_leaders_props.value.page = 1;
  community_leaders_props.value.length = 10;
  community_leaders_props.value.sort = sortAllCommunitiesOptions.value[10];

  community_leaders_props.value.name = null;
  community_leaders_props.value.user_name = null;
  community_leaders_props.value.email = null;
  community_leaders_props.value.phone = null;

  community_leaders_props.value.position = null;
  community_leaders_props.value.approved_date = null;
  community_leaders_props.value.registration_date = null;
}


const sortCommunityMembersOptions = ref([

  'name_asc',
  'name_desc',
  'user_name_asc',
  'user_name_desc',
  'email_asc',
  'email_desc',
  'phone_asc',
  'phone_desc',

  'position_asc',
  'position_desc',
  'registration_date_asc',
  'registration_date_desc',
]);

const community_members_props = ref({

'page': 1,
'length': 10,
'sort': sortCommunityMembersOptions.value[11],

'name': null,
'user_name': null,
'email': null,
'phone': null,

'position': community_leader_roles.value[0],
'registration_date': null,


})


const clearFilterFormCommunityMembers = () => {
community_members_props.value.page = 1;
community_members_props.value.length = 10;
community_members_props.value.sort = sortCommunityMembersOptions.value[11];

community_members_props.value.name = null;
community_members_props.value.user_name = null;
community_members_props.value.email = null;
community_members_props.value.phone = null;

community_members_props.value.position = community_leader_roles.value[0];
community_members_props.value.registration_date = null;
}


const sortCommunityLeadersRequestsOptions = ref([

  'name_asc',
  'name_desc',
  'user_name_asc',
  'user_name_desc',
  'community_asc',
  'community_desc',
  'lga_asc',
  'lga_desc',
  'state_asc',
  'state_desc',
  'email_asc',
  'email_desc',
  'phone_asc',
  'phone_desc',

  'position_asc',
  'position_desc',

  'request_date_asc',
  'request_date_desc',
]);


const community_leaders_requests_props = ref({

  'page': 1,
  'length': 10,
  'sort': sortCommunityLeadersRequestsOptions.value[17],

  'name': null,
  'user_name': null,
  'community': null,
  'lga': null,
  'state': null,
  'email': null,
  'phone': null,

  'position': null,
  'request_date': null,


})


const clearFilterFormCommunityRequestsLeaders = () => {
  community_leaders_requests_props.value.page = 1;
  community_leaders_requests_props.value.length = 10;
  community_leaders_requests_props.value.sort = sortCommunityLeadersRequestsOptions.value[17];

  community_leaders_requests_props.value.name = null;
  community_leaders_requests_props.value.user_name = null;
  community_leaders_requests_props.value.community = null;
  community_leaders_requests_props.value.lga = null;
  community_leaders_requests_props.value.state = null;
  community_leaders_requests_props.value.email = null;
  community_leaders_requests_props.value.phone = null;

  community_leaders_requests_props.value.position = null;
  community_leaders_requests_props.value.request_date = null;

}

const sortCurrentLeadersOptions = ref([

  'name_asc',
  'name_desc',
  'user_name_asc',
  'user_name_desc',
  'community_asc',
  'community_desc',
  'lga_asc',
  'lga_desc',
  'state_asc',
  'state_desc',
  'email_asc',
  'email_desc',
  'phone_asc',
  'phone_desc',

  'position_asc',
  'position_desc',

  'approval_date_asc',
  'approval_date_desc',
]);


const current_leaders_props = ref({

  'page': 1,
  'length': 10,
  'sort': sortCurrentLeadersOptions.value[17],

  'name': null,
  'user_name': null,
  'community': null,
  'lga': null,
  'state': null,
  'email': null,
  'phone': null,

  'position': null,
  'approval_date': null,


})


const clearFilterFormCurrentLeaders = () => {
  current_leaders_props.value.page = 1;
  current_leaders_props.value.length = 10;
  current_leaders_props.value.sort = sortCurrentLeadersOptions.value[17];

  current_leaders_props.value.name = null;
  current_leaders_props.value.user_name = null;
  current_leaders_props.value.community = null;
  current_leaders_props.value.lga = null;
  current_leaders_props.value.state = null;
  current_leaders_props.value.email = null;
  current_leaders_props.value.phone = null;

  current_leaders_props.value.position = null;
  current_leaders_props.value.approval_date = null;

}






const openPage = (page) => {
  current_page.value = page
}

onMounted(() => {

});

const manageVtuSettings = () => {
  openPage(2);
}



const viewAllCommunities = async (url = null) => {

  try {


    console.log(url)
    if (url != null) {
      var urlParams = new URLSearchParams(url);
      console.log(urlParams)
      var page = urlParams.get('page');
      all_communities_props.value.page = page
      console.log(page)
    }


    // return

    Swal.fire({
      title: 'Please wait',
      html: 'Loading Communities.....',
      icon: 'info',
      showConfirmButton: false,
      allowEscapeKey: false,
      allowOutsideClick: false,
    });

    let queryRoute = route('load_communities_for_work');

    const response = await axios.post(queryRoute, null, { params: all_communities_props.value });

    console.log(response)
    Swal.close()

    communities.value = response.data;
    openPage(2);




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


const manageCommLeadersInit = (row) => {
  community_info_temp.value = row
  manageCommLeaders();
}

const manageCommLeaders = async (url = null) => {

try {


  console.log(url)
  if (url != null) {
    var urlParams = new URLSearchParams(url);
    console.log(urlParams)
    var page = urlParams.get('page');
    community_leaders_props.value.page = page
    console.log(page)
  }


  // return

  Swal.fire({
    title: 'Please wait',
    html: `Loading community leaders in <em class='text-emerald-500'>${community_info_temp.value.name}</em> community.....`,
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });

  let queryRoute = route('load_community_leaders', community_info_temp.value.id);

  const response = await axios.post(queryRoute, null, { params: community_leaders_props.value });

  console.log(response)
  Swal.close()

  community_leaders.value = response.data;
  openPage(3);




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

const removeLeader = (row, index) => {
  Swal.fire({
    title: `Are you sure you want to remove <em class='text-emerald-500'>${row.name}</em> as ${row.position} of <em class='text-emerald-500'>${community_info_temp.value.name}</em> community? `,
    html: '<b class="text-primary-100">Note: This process is irreversible</b>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes Proceed!',
  }).then((result) => {

    if (result.isConfirmed) {
      proceedWithRemovingLeader(row, index)

    } else if (result.isDenied) {
      // Swal.fire('Changes are not saved', '', 'info')
    }
  })
}


const proceedWithRemovingLeader = async (row, index) => {

try {



  Swal.fire({
    title: 'Please wait',
    html: `Removing <em class='text-emerald-500'>${row.name}</em> as ${row.position} of <em class='text-emerald-500'>${community_info_temp.value.name} community</em>.....`,
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });

  let queryRoute = route('remove_community_leader', row.id);

  const response = await axios.post(queryRoute, null, { params: {'delete': true} });

  console.log(response)
  Swal.close()

  if (response.data.success) {

    community_leaders.value.data.splice(index, 1);

    mainStore.toast = `${row.name} has been removed as ${row.position} of ${community_info_temp.value.name} community successfully`;
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

const manageCommUsersInit = (row) => {
  community_info_temp.value = row
  manageCommUsers();
}


const manageCommUsers = async (url = null) => {

try {


  console.log(url)
  if (url != null) {
    var urlParams = new URLSearchParams(url);
    console.log(urlParams)
    var page = urlParams.get('page');
    community_members_props.value.page = page
    console.log(page)
  }


  // return

  Swal.fire({
    title: 'Please wait',
    html: `Loading community members in <em class='text-emerald-500'>${community_info_temp.value.name}</em> community.....`,
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });

  let queryRoute = route('load_community_members', community_info_temp.value.id);

  const response = await axios.post(queryRoute, null, { params: community_members_props.value });

  console.log(response)
  Swal.close()

  community_members.value = response.data;
  openPage(4);




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



const viewComunityLeaderRequests = async (url = null) => {

try {


  console.log(url)
  if (url != null) {
    var urlParams = new URLSearchParams(url);
    console.log(urlParams)
    var page = urlParams.get('page');
    community_leaders_requests_props.value.page = page
    console.log(page)
  }


  // return

  Swal.fire({
    title: 'Please wait',
    html: `Loading pending community leader requests.....`,
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });

  let queryRoute = route('load_community_leader_requests');

  const response = await axios.post(queryRoute, null, { params: community_leaders_requests_props.value });

  console.log(response)
  Swal.close()

  community_leaders_requests.value = response.data;
  openPage(5);




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

const approveLeaderRequest = (row, index) => {
  Swal.fire({
    title: `Are you sure you want to approve <em class='text-emerald-500'>${row.name}</em> as ${row.position} of <em class='text-emerald-500'>${row.community}</em> community? `,
    html: `<b class="text-primary-100">${row.position == 'King' ? 'Note: All requests for king in this community will be automatically dismissed and no new requests possible till this user is removed.' : ''}</b>`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes Proceed!',
  }).then((result) => {

    if (result.isConfirmed) {
      proceedWithApprovingLeaderRequest(row, index)

    } else if (result.isDenied) {
      // Swal.fire('Changes are not saved', '', 'info')
    }
  })
}

const proceedWithApprovingLeaderRequest = async (row, index) => {

try {



  Swal.fire({
    title: 'Please wait',
    html: `Approving <em class='text-emerald-500'>${row.name}</em> as ${row.position} of <em class='text-emerald-500'>${row.community} community</em>.....`,
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });

  let queryRoute = route('approve_community_leader', row.id);

  const response = await axios.post(queryRoute, null, { params: {'approve': true} });

  console.log(response)
  Swal.close()

  if (response.data.success) {



    mainStore.toast = `${row.name} has been approved as ${row.position} of ${row.community} community successfully`;

    viewComunityLeaderRequests();
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



const dismissLeaderRequest = (row, index) => {
  Swal.fire({
    title: `Are you sure you want to dismiss the request of <em class='text-emerald-500'>${row.name}</em> as ${row.position} of <em class='text-emerald-500'>${row.community}</em> community? `,
    html: ``,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes Proceed!',
  }).then((result) => {

    if (result.isConfirmed) {
      proceedWithDismissingLeaderRequest(row, index)

    } else if (result.isDenied) {
      // Swal.fire('Changes are not saved', '', 'info')
    }
  })
}

const proceedWithDismissingLeaderRequest = async (row, index) => {

try {



  Swal.fire({
    title: 'Please wait',
    html: `Dismissing the request of <em class='text-emerald-500'>${row.name}</em> as ${row.position} of <em class='text-emerald-500'>${row.community} community</em>.....`,
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });

  let queryRoute = route('dismiss_community_leader_request', row.id);

  const response = await axios.post(queryRoute, null, { params: {'dismiss': true} });

  console.log(response)
  Swal.close()

  if (response.data.success) {

    community_leaders_requests.value.data.splice(index, 1);

    mainStore.toast = `The request of ${row.name}  as ${row.position} of ${row.community} community has been dismissed successfully`;
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

const viewAllCurrentLeaders = async (url = null) => {

try {


  console.log(url)
  if (url != null) {
    var urlParams = new URLSearchParams(url);
    console.log(urlParams)
    var page = urlParams.get('page');
    current_leaders_props.value.page = page
    console.log(page)
  }


  // return

  Swal.fire({
    title: 'Please wait',
    html: `Loading all current community leaders.....`,
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });

  let queryRoute = route('load_all_current_community_leaders');

  const response = await axios.post(queryRoute, null, { params: current_leaders_props.value });

  console.log(response)
  Swal.close()

  current_leaders.value = response.data;
  openPage(6);




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

const removeLeaderCurrent = (row, index) => {
  Swal.fire({
    title: `Are you sure you want to remove <em class='text-emerald-500'>${row.name}</em> as ${row.position} of <em class='text-emerald-500'>${row.community}</em> community? `,
    html: '<b class="text-primary-100">Note: This process is irreversible</b>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes Proceed!',
  }).then((result) => {

    if (result.isConfirmed) {
      proceedWithRemovingLeaderCurrent(row, index)

    } else if (result.isDenied) {
      // Swal.fire('Changes are not saved', '', 'info')
    }
  })
}

const proceedWithRemovingLeaderCurrent = async (row, index) => {

try {



  Swal.fire({
    title: 'Please wait',
    html: `Removing <em class='text-emerald-500'>${row.name}</em> as ${row.position} of <em class='text-emerald-500'>${row.community} community</em>.....`,
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });

  let queryRoute = route('remove_community_leader', row.id);

  const response = await axios.post(queryRoute, null, { params: {'delete': true} });

  console.log(response)
  Swal.close()

  if (response.data.success) {

    current_leaders.value.data.splice(index, 1);

    mainStore.toast = `${row.name} has been removed as ${row.position} of ${row.community} community successfully`;
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
</script>

<template inheritAttrs="false">
  <LayoutAuthenticated>

    <Head :title="`Manage Communities`" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiAccountGroup" :title="`Manage Communities`" main>
        <!-- <BaseButton href="https://github.com/justboil/admin-one-vue-tailwind" target="_blank" :icon="mdiGithub"
          label="Star on GitHub" color="contrast" rounded-full small /> -->
      </SectionTitleLineWithButton>
      <!-- <NotificationBar color="info" :icon="mdiMonitorCellphone">
        <b>Responsive table.</b> Collapses on mobile
      </NotificationBar> -->


      <div v-if="current_page == 6" class="">
        <h4 class="font-bold text-2xl mb-5 mt-2" v-html="`All current community leaders`"></h4>


        <CardBox isForm @submit.prevent="viewAllCurrentLeaders" class="">
          <div class="sm:grid sm:grid-cols-12 sm:gap-6">
            <FormField class="sm:col-span-4" label="Length">
              <FormControl v-model="current_leaders_props.length" :options="lengthOptions" />
            </FormField>

            <FormField class="sm:col-span-8" label="Sort By">
              <FormControl v-model="current_leaders_props.sort" :options="sortCurrentLeadersOptions" />
            </FormField>

            <FormField class="sm:col-span-4" label="Full Name">
              <FormControl v-model="current_leaders_props.name" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="User name">
              <FormControl v-model="current_leaders_props.user_name" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="Community">
              <FormControl v-model="current_leaders_props.community" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="LGA">
              <FormControl v-model="current_leaders_props.lga" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="State">
              <FormControl v-model="current_leaders_props.state" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="Email Address">
              <FormControl v-model="current_leaders_props.email" type="email" />
            </FormField>


            <FormField class="sm:col-span-4" label="Phone">
              <FormControl v-model="current_leaders_props.phone" type="number" />
            </FormField>

            <FormField class="sm:col-span-4" label="Position">
              <FormControl v-model="current_leaders_props.position" type="text" />
            </FormField>


            <FormField class="sm:col-span-4" label="Approval Date ">
              <FormControl v-model="current_leaders_props.approval_date" type="date" />
            </FormField>



          </div>
          <BaseButtons class="mt-5 mb-2">
            <BaseButton type="submit" color="info" label="Filter" class="px-5 mb-0" />

            <BaseButton @click="clearFilterFormCurrentLeaders" type="reset" color="info" outline label="Clear"
              :icon="mdiClose" class="px-5 mb-0" />
          </BaseButtons>
          <BaseDivider />
        </CardBox>

        <CardBox class="mb-4" has-table>

          <div v-if="current_leaders.data.length > 0" class="">
            <div class="">
              <table class="">
                <thead>
                  <tr>

                    <th></th>
                    <th>Actions</th>
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Community</th>
                    <th>LGA</th>
                    <th>State</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Approval Date </th>

                  </tr>
                </thead>


                <tbody class="text-sm">
                  <tr v-for="(row, index) in current_leaders.data" :key="row.id">
                    <td v-html="`${(index + 1) + ((current_leaders.current_page - 1) * current_leaders_props.length)}.`"></td>

                    <td class="before:hidden lg:w-1 whitespace-nowrap">
                      <BaseButtons type="justify-start lg:justify-end" no-wrap>
                        <BaseButton @click="removeLeaderCurrent(row, index)" color="danger" :icon="mdiTrashCan" small title="Remove this community leader" />


                      </BaseButtons>
                    </td>

                    <td class="capitalize">{{ row.name }}</td>
                    <td class="lowercase">{{ row.user_name }}</td>
                    <td class="capitalize">{{ row.community }}</td>
                    <td class="capitalize">{{ row.lga }}</td>
                    <td class="capitalize">{{ row.state }}</td>
                    <td class="text-emerald-500 italic text-xs">{{ row.email }}</td>
                    <td class="lowercase italic text-xs">{{ row.phone }}</td>
                    <td class="text-emerald-500 italic">{{ row.position }}</td>
                    <td class="text-emerald-500 italic">{{ row.approval_date }}</td>


                  </tr>

                </tbody>
              </table>
            </div>
            <div class="p-3 lg:px-6 border-t border-gray-100 ">
              <BaseLevel>
                <BaseButtons>
                  <BaseButton v-for="page in current_leaders.links" :key="page" :active="page.active" :label="page.label"
                    :color="page.active ? 'lightDark' : 'whiteDark'" small @click="viewAllCurrentLeaders(page.url)"
                    :disabled="page.url === null" />
                </BaseButtons>
                <small>Page {{ current_leaders.current_page }} of {{ current_leaders.last_page }}</small>
                <small>{{ current_leaders.total }} current community leader(s)</small><br>
              </BaseLevel>
            </div>
          </div>

        </CardBox>

      </div>

      <div v-if="current_page == 5" class="">
        <h4 class="font-bold text-2xl mb-5 mt-2" v-html="`Pending community leader requests`"></h4>


        <CardBox isForm @submit.prevent="viewComunityLeaderRequests" class="">
          <div class="sm:grid sm:grid-cols-12 sm:gap-6">
            <FormField class="sm:col-span-4" label="Length">
              <FormControl v-model="community_leaders_requests_props.length" :options="lengthOptions" />
            </FormField>

            <FormField class="sm:col-span-8" label="Sort By">
              <FormControl v-model="community_leaders_requests_props.sort" :options="sortCommunityLeadersRequestsOptions" />
            </FormField>

            <FormField class="sm:col-span-4" label="Full Name">
              <FormControl v-model="community_leaders_requests_props.name" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="User name">
              <FormControl v-model="community_leaders_requests_props.user_name" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="Community">
              <FormControl v-model="community_leaders_requests_props.community" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="LGA">
              <FormControl v-model="community_leaders_requests_props.lga" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="State">
              <FormControl v-model="community_leaders_requests_props.state" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="Email Address">
              <FormControl v-model="community_leaders_requests_props.email" type="email" />
            </FormField>


            <FormField class="sm:col-span-4" label="Phone">
              <FormControl v-model="community_leaders_requests_props.phone" type="number" />
            </FormField>

            <FormField class="sm:col-span-4" label="Position">
              <FormControl v-model="community_leaders_requests_props.position" type="text" />
            </FormField>


            <FormField class="sm:col-span-4" label="Request Date ">
              <FormControl v-model="community_leaders_requests_props.request_date" type="date" />
            </FormField>



          </div>
          <BaseButtons class="mt-5 mb-2">
            <BaseButton type="submit" color="info" label="Filter" class="px-5 mb-0" />

            <BaseButton @click="clearFilterFormCommunityRequestsLeaders" type="reset" color="info" outline label="Clear"
              :icon="mdiClose" class="px-5 mb-0" />
          </BaseButtons>
          <BaseDivider />
        </CardBox>

        <CardBox class="mb-4" has-table>

          <div v-if="community_leaders_requests.data.length > 0" class="">
            <div class="">
              <table class="">
                <thead>
                  <tr>

                    <th></th>
                    <th>Actions</th>
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Community</th>
                    <th>LGA</th>
                    <th>State</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Request Date </th>

                  </tr>
                </thead>


                <tbody class="text-sm">
                  <tr v-for="(row, index) in community_leaders_requests.data" :key="row.id">
                    <td v-html="`${(index + 1) + ((community_leaders_requests.current_page - 1) * community_leaders_requests_props.length)}.`"></td>

                    <td class="before:hidden lg:w-1 whitespace-nowrap">
                      <BaseButtons type="justify-start lg:justify-end" no-wrap>
                        <BaseButton @click="approveLeaderRequest(row, index)" color="success" :icon="mdiCheck" small title="Approve Request community leader" />

                        <BaseButton @click="dismissLeaderRequest(row, index)" color="danger" :icon="mdiClose" small title="Dismiss Request" />


                      </BaseButtons>
                    </td>

                    <td class="capitalize">{{ row.name }}</td>
                    <td class="lowercase">{{ row.user_name }}</td>
                    <td class="capitalize">{{ row.community }}</td>
                    <td class="capitalize">{{ row.lga }}</td>
                    <td class="capitalize">{{ row.state }}</td>
                    <td class="text-emerald-500 italic text-xs">{{ row.email }}</td>
                    <td class="lowercase italic text-xs">{{ row.phone }}</td>
                    <td class="text-emerald-500 italic">{{ row.position }}</td>
                    <td class="text-emerald-500 italic">{{ row.request_date }}</td>


                  </tr>

                </tbody>
              </table>
            </div>
            <div class="p-3 lg:px-6 border-t border-gray-100 ">
              <BaseLevel>
                <BaseButtons>
                  <BaseButton v-for="page in community_leaders_requests.links" :key="page" :active="page.active" :label="page.label"
                    :color="page.active ? 'lightDark' : 'whiteDark'" small @click="viewComunityLeaderRequests(page.url)"
                    :disabled="page.url === null" />
                </BaseButtons>
                <small>Page {{ community_leaders_requests.current_page }} of {{ community_leaders_requests.last_page }}</small>
                <small>{{ community_leaders_requests.total }} community leader request(s)</small><br>
              </BaseLevel>
            </div>
          </div>

        </CardBox>

      </div>

      <div v-if="current_page == 4" class="">
        <h4 class="font-bold text-2xl mb-5 mt-2" v-html="`All community members in ${community_info_temp.name} community`"> </h4>



        <CardBox isForm @submit.prevent="manageCommUsers" class="">
          <div class="sm:grid sm:grid-cols-12 sm:gap-6">
            <FormField class="sm:col-span-4" label="Length">
              <FormControl v-model="community_members_props.length" :options="lengthOptions" />
            </FormField>

            <FormField class="sm:col-span-8" label="Sort By">
              <FormControl v-model="community_members_props.sort" :options="sortCommunityMembersOptions" />
            </FormField>

            <FormField class="sm:col-span-4" label="Full Name">
              <FormControl v-model="community_members_props.name" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="User name">
              <FormControl v-model="community_members_props.user_name" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="Email Address">
              <FormControl v-model="community_members_props.email" type="email" />
            </FormField>


            <FormField class="sm:col-span-4" label="Phone">
              <FormControl v-model="community_members_props.phone" type="number" />
            </FormField>

            <FormField class="sm:col-span-4" label="Position">

              <FormControl v-model="community_members_props.position" :options="community_leader_roles" />
            </FormField>


            <FormField class="sm:col-span-4" label="Registration Date ">
              <FormControl v-model="community_members_props.registration_date" type="date" />
            </FormField>



          </div>
          <BaseButtons class="mt-5 mb-2">
            <BaseButton type="submit" color="info" label="Filter" class="px-5 mb-0" />

            <BaseButton @click="clearFilterFormCommunityMembers" type="reset" color="info" outline label="Clear"
              :icon="mdiClose" class="px-5 mb-0" />
          </BaseButtons>
          <BaseDivider />
        </CardBox>

        <CardBox class="mb-4" has-table>

          <div v-if="community_members.data.length > 0" class="">
            <div class="">
              <table class="">
                <thead>
                  <tr>

                    <th></th>
                    <!-- <th>Actions</th> -->
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Registration Date </th>

                  </tr>
                </thead>


                <tbody class="text-sm">
                  <tr v-for="(row, index) in community_members.data" :key="row.id">
                    <td v-html="`${(index + 1) + ((community_members.current_page - 1) * community_members_props.length)}.`"></td>

                    <!-- <td class="before:hidden lg:w-1 whitespace-nowrap">
                      <BaseButtons type="justify-start lg:justify-end" no-wrap>
                        <BaseButton @click="removeLeader(row, index)" color="danger" :icon="mdiTrashCan" small title="Remove this community leader" />


                      </BaseButtons>
                    </td> -->

                    <td class="capitalize">{{ row.name }}</td>
                    <td class="lowercase">{{ row.user_name }}</td>
                    <td class="text-emerald-500 italic text-xs">{{ row.email }}</td>
                    <td class="lowercase italic text-xs">{{ row.phone }}</td>
                    <td class="text-emerald-500 italic" v-html="row.position == null ? 'Subject' : row.position "></td>
                    <td class="text-emerald-500 italic">{{ row.registration_date }}</td>


                  </tr>

                </tbody>
              </table>
            </div>
            <div class="p-3 lg:px-6 border-t border-gray-100 ">
              <BaseLevel>
                <BaseButtons>
                  <BaseButton v-for="page in community_members.links" :key="page" :active="page.active" :label="page.label"
                    :color="page.active ? 'lightDark' : 'whiteDark'" small @click="manageCommUsers(page.url)"
                    :disabled="page.url === null" />
                </BaseButtons>
                <small>Page {{ community_members.current_page }} of {{ community_members.last_page }}</small>
                <small>{{ community_members.total }} community member(s)</small><br>
              </BaseLevel>
            </div>
          </div>

        </CardBox>

      </div>

      <div v-if="current_page == 3" class="">
        <h4 class="font-bold text-2xl mb-5 mt-2" v-html="`All community leaders in ${community_info_temp.name} community`"> </h4>



        <CardBox isForm @submit.prevent="manageCommLeaders" class="">
          <div class="sm:grid sm:grid-cols-12 sm:gap-6">
            <FormField class="sm:col-span-4" label="Length">
              <FormControl v-model="community_leaders_props.length" :options="lengthOptions" />
            </FormField>

            <FormField class="sm:col-span-8" label="Sort By">
              <FormControl v-model="community_leaders_props.sort" :options="sortCommunityLeadersOptions" />
            </FormField>

            <FormField class="sm:col-span-4" label="Full Name">
              <FormControl v-model="community_leaders_props.name" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="User name">
              <FormControl v-model="community_leaders_props.user_name" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="Email Address">
              <FormControl v-model="community_leaders_props.email" type="email" />
            </FormField>


            <FormField class="sm:col-span-4" label="Phone">
              <FormControl v-model="community_leaders_props.phone" type="number" />
            </FormField>

            <FormField class="sm:col-span-4" label="Position">
              <FormControl v-model="community_leaders_props.position" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="Approved Date ">
              <FormControl v-model="community_leaders_props.approved_date" type="date" />
            </FormField>

            <FormField class="sm:col-span-4" label="Registration Date ">
              <FormControl v-model="community_leaders_props.registration_date" type="date" />
            </FormField>



          </div>
          <BaseButtons class="mt-5 mb-2">
            <BaseButton type="submit" color="info" label="Filter" class="px-5 mb-0" />

            <BaseButton @click="clearFilterFormCommunityLeaders" type="reset" color="info" outline label="Clear"
              :icon="mdiClose" class="px-5 mb-0" />
          </BaseButtons>
          <BaseDivider />
        </CardBox>

        <CardBox class="mb-4" has-table>

          <div v-if="community_leaders.data.length > 0" class="">
            <div class="">
              <table class="">
                <thead>
                  <tr>

                    <th></th>
                    <th>Actions</th>
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Approved Date </th>
                    <th>Registration Date </th>

                  </tr>
                </thead>


                <tbody class="text-sm">
                  <tr v-for="(row, index) in community_leaders.data" :key="row.id">
                    <td v-html="`${(index + 1) + ((community_leaders.current_page - 1) * community_leaders_props.length)}.`"></td>

                    <td class="before:hidden lg:w-1 whitespace-nowrap">
                      <BaseButtons type="justify-start lg:justify-end" no-wrap>
                        <BaseButton @click="removeLeader(row, index)" color="danger" :icon="mdiTrashCan" small title="Remove this community leader" />


                      </BaseButtons>
                    </td>

                    <td class="capitalize">{{ row.name }}</td>
                    <td class="lowercase">{{ row.user_name }}</td>
                    <td class="text-emerald-500 italic text-xs">{{ row.email }}</td>
                    <td class="lowercase italic text-xs">{{ row.phone }}</td>
                    <td class="text-emerald-500 italic">{{ row.position }}</td>
                    <td class="lowercase italic">{{ row.approved_date }}</td>
                    <td class="text-emerald-500 italic">{{ row.registration_date }}</td>


                  </tr>

                </tbody>
              </table>
            </div>
            <div class="p-3 lg:px-6 border-t border-gray-100 ">
              <BaseLevel>
                <BaseButtons>
                  <BaseButton v-for="page in community_leaders.links" :key="page" :active="page.active" :label="page.label"
                    :color="page.active ? 'lightDark' : 'whiteDark'" small @click="manageCommLeaders(page.url)"
                    :disabled="page.url === null" />
                </BaseButtons>
                <small>Page {{ community_leaders.current_page }} of {{ community_leaders.last_page }}</small>
                <small>{{ community_leaders.total }} community leader(s)</small><br>
              </BaseLevel>
            </div>
          </div>

        </CardBox>

      </div>

      <div v-if="current_page == 2" class="">

        <CardBox isForm @submit.prevent="viewAllCommunities" class="">
          <div class="sm:grid sm:grid-cols-12 sm:gap-6">
            <FormField class="sm:col-span-4" label="Length">
              <FormControl v-model="all_communities_props.length" :options="lengthOptions" />
            </FormField>

            <FormField class="sm:col-span-8" label="Sort By">
              <FormControl v-model="all_communities_props.sort" :options="sortAllCommunitiesOptions" />
            </FormField>

            <FormField class="sm:col-span-4" label="Community Name">
              <FormControl v-model="all_communities_props.name" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="LGA">
              <FormControl v-model="all_communities_props.lga" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="State">
              <FormControl v-model="all_communities_props.state" type="text" />
            </FormField>

            <FormField class="sm:col-span-4" label="Number Of Users">
              <FormControl v-model="all_communities_props.users_num" type="number" />
            </FormField>

            <FormField class="sm:col-span-4" label="Last User Registered Date ">
              <FormControl v-model="all_communities_props.last_user_registered_date" type="date" />
            </FormField>

            <FormField class="sm:col-span-4" label="Number Of Comm. Leaders">
              <FormControl v-model="all_communities_props.community_leaders_num" type="number" />
            </FormField>

            <FormField class="sm:col-span-4" label="Last Commu. Leader Registered Date ">
              <FormControl v-model="all_communities_props.last_community_leader_date" type="date" />
            </FormField>

            <FormField class="sm:col-span-4" label="Pending Comm. Leaders Num.">
              <FormControl v-model="all_communities_props.pending_community_leaders_num" type="number" />
            </FormField>

            <FormField class="sm:col-span-4" label="Last Pending Commu. Leader  Date ">
              <FormControl v-model="all_communities_props.last_pending_community_leader_date" type="date" />
            </FormField>




          </div>
          <BaseButtons class="mt-5 mb-2">
            <BaseButton type="submit" color="info" label="Filter" class="px-5 mb-0" />

            <BaseButton @click="clearFilterFormAllCommunitiesHistory" type="reset" color="info" outline label="Clear"
              :icon="mdiClose" class="px-5 mb-0" />
          </BaseButtons>
          <BaseDivider />
        </CardBox>

        <CardBox class="mb-4" has-table>

          <div v-if="communities.data.length > 0" class="">
            <div class="">
              <table class="">
                <thead>
                  <tr>

                    <th></th>

                    <th>Actions</th>
                    <th>Community Name</th>
                    <th>State</th>
                    <th>LGA</th>
                    <th>Number Of Users</th>
                    <th>Last User Registered Date </th>
                    <th>Number Of Comm. Leaders</th>
                    <th>Last Commu. Leader Registered Date </th>
                    <th>Pending Comm. Leaders Num.</th>
                    <th>Last Pending Commu. Leader  Date </th>

                  </tr>
                </thead>


                <tbody class="text-sm">
                  <tr v-for="(row, index) in communities.data" :key="row.id">
                    <td v-html="`${(index + 1) + ((communities.current_page - 1) * all_communities_props.length)}.`"></td>

                    <td class="before:hidden lg:w-1 whitespace-nowrap">
                      <BaseButtons type="justify-start lg:justify-end" no-wrap>
                        <BaseButton @click="manageCommUsersInit(row)" color="warning" :icon="mdiAccountGroup" small title="View users in community" />
                        <BaseButton @click="manageCommLeadersInit(row)" color="success" :icon="mdiBriefcaseEdit" small title="Manage community leaders" />

                        <BaseButton @click="manageCommLeaders(row)" color="info" :icon="mdiViewDashboard" small title="View Community page" />



                      </BaseButtons>
                    </td>

                    <td class="capitalize">{{ row.name }}</td>
                    <td class="capitalize">{{ row.state }}</td>
                    <td class="capitalize">{{ row.lga }}</td>
                    <td class="text-emerald-500 italic">{{ row.users_num }}</td>
                    <td class="lowercase italic">{{ row.last_user_registered_date }}</td>
                    <td class="text-emerald-500 italic">{{ row.community_leaders_num }}</td>
                    <td class="lowercase italic">{{ row.last_community_leader_date }}</td>
                    <td class="text-emerald-500 italic">{{ row.pending_community_leaders_num }}</td>
                    <td class="lowercase italic">{{ row.last_pending_community_leader_date }}</td>



                  </tr>

                </tbody>
              </table>
            </div>
            <div class="p-3 lg:px-6 border-t border-gray-100 ">
              <BaseLevel>
                <BaseButtons>
                  <BaseButton v-for="page in communities.links" :key="page" :active="page.active" :label="page.label"
                    :color="page.active ? 'lightDark' : 'whiteDark'" small @click="viewAllCommunities(page.url)"
                    :disabled="page.url === null" />
                </BaseButtons>
                <small>Page {{ communities.current_page }} of {{ communities.last_page }}</small>
                <small>{{ communities.total }} communities</small><br>
              </BaseLevel>
            </div>
          </div>

        </CardBox>

      </div>






      <div v-if="current_page == 1" class="mt-[30px]">
        <CardBox class="mb-6">

          <h3 class="text-2xl font-semibold">Choose Action</h3>

          <ul class="divide-y-2 divide-gray-400 mt-[50px]">

            <li @click="viewAllCommunities" class="listview-list">
              <span class="font-semibold ">1. View and manage all communities </span>
            </li>

            <li @click="viewComunityLeaderRequests" class="listview-list">
              <span class="font-semibold ">2. View pending community leader requests</span>
            </li>

            <li @click="viewAllCurrentLeaders" class="listview-list">
              <span class="font-semibold ">3. View all current community leaders</span>
            </li>


          </ul>
        </CardBox>
      </div>

      <FloatingActionButton v-if="current_page == 6" @click="current_page = 1" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>

      <FloatingActionButton v-if="current_page == 5" @click="current_page = 1" :styles="'background: 9124a3;'"
        :title="'Go Back'">
        <font-awesome-icon class="text-white text-2xl" icon="fa-solid fa-arrow-left" />
      </FloatingActionButton>

      <FloatingActionButton v-if="current_page == 4" @click="current_page = 2" :styles="'background: 9124a3;'"
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

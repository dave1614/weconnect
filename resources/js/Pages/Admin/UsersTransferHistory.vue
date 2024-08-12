<template inheritAttrs="false">
  <LayoutAuthenticated>

    <Head :title="`${user.name} Funds Transfer History`" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiCashRefund" :title="`${user.name} Funds Transfer History`" main>
        <!-- <BaseButton href="https://github.com/justboil/admin-one-vue-tailwind" target="_blank" :icon="mdiGithub"
          label="Star on GitHub" color="contrast" rounded-full small /> -->
      </SectionTitleLineWithButton>
      <!-- <NotificationBar color="info" :icon="mdiMonitorCellphone">
        <b>Responsive table.</b> Collapses on mobile
      </NotificationBar> -->

      <!-- <CardBox v-if="useSearchBtn" form @submit.prevent="submitFilterForm" class=""> -->
      <CardBox isForm @submit.prevent="submitFilterForm" class="">
        <div class="sm:grid sm:grid-cols-12 sm:gap-6">
          <FormField class="sm:col-span-4" label="Length: ">
            <FormControl v-model="form.length" :options="lengthOptions" />
          </FormField>
          <FormField class="sm:col-span-4 capitalize" label="Role: " wrap-body>
            <FormCheckRadioGroup v-model="form.role" name="role" :options="roleOptions" type="radio" />
          </FormField>
          <FormField class="sm:col-span-4" label="Sender's Name">
            <FormControl v-model="form.sender_name" />
          </FormField>
          <FormField class="sm:col-span-4" label="Sender's Phone Number">
            <FormControl v-model="form.sender_phone" />
          </FormField>
          <FormField class="sm:col-span-4" label="Sender's Email">
            <FormControl v-model="form.sender_email" />
          </FormField>
          <FormField class="sm:col-span-4" label="Recepient's Name">
            <FormControl v-model="form.recepient_name" />
          </FormField>
          <FormField class="sm:col-span-4" label="Recepient's Phone Number">
            <FormControl v-model="form.recepient_phone" />
          </FormField>
          <FormField class="sm:col-span-4" label="Recepient's Email">
            <FormControl v-model="form.recepient_email" />
          </FormField>
          <FormField class="sm:col-span-4" label="Amount">
            <FormControl v-model="form.amount" type="number" step="any" />
          </FormField>
          
          <FormField class="sm:col-span-4" label="Transfer Date">
            <FormControl v-model="form.date" type="date" />
          </FormField>
          <FormField class="sm:col-span-4" label="Start Date">
            <FormControl v-model="form.start_date" type="date" />
          </FormField>

          <FormField class="sm:col-span-4" label="End Date">
            <FormControl v-model="form.end_date" type="date" />
          </FormField>


        </div>
        <BaseButtons>
          <BaseButton v-if="useSearchBtn" type="submit" color="info" label="Filter" class="px-9 mb-8" />
          <BaseButton @click="clearFilterForm" type="reset" color="info" outline label="Clear" :icon="mdiClose"
            class="px-9 mb-8" />
        </BaseButtons>
        <BaseDivider />
      </CardBox>

      <CardBox class="mb-6" has-table>

        <div v-if="history.data.length > 0" class="">
          <table>
            <thead>
              <tr>

                <th></th>
                <th>Amount (₦)</th>
                <th>Transfer Date / Time</th>
                <th>Role</th>
                <th>Sender's Name</th>
                <th>Sender's Phone Number</th>
                <th>Sender's Email</th>
                
                <th>Recepient's Name</th>
                <th>Recepient's Phone Number</th>
                <th>Recepient's Email</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row,index) in history.data" :key="row.id">

                <td v-html="`${(index + 1) +((history.current_page - 1) * form.length)}.`"></td>
                <td data-label="Amount" v-html="mainStore.addCommas((row.amount - 0).toFixed(2))">
                
                </td>

                <td data-label="Date / Time" v-html="`${row.date} ${row.time}`">
                
                </td>

                <td data-label="Role" :class="row.sender == user.id ? 'text-red-500' : 'text-primary'" class="text-xs italic"
                  v-html="row.sender == user.id ? 'Sender' : 'Recepient'">
                
                </td>

                
                <td class="capitalize" data-label="Sender's Name">
                  {{ row.sender_name }}
                </td>
                <td class="capitalize" data-label="Sender's Phone Number">
                  {{ row.sender_phone }}
                </td>
                <td class="text-xs" data-label="Sender's Email">
                  {{ row.sender_email }}
                </td>

                <td class="capitalize" data-label="Recepient's Name">
                  {{ row.recepient_name }}
                </td>
                <td class="capitalize" data-label="Recepient's Phone Number">
                  {{ row.recepient_phone }}
                </td>
                <td class="text-xs" data-label="Recepient's Email">
                  {{ row.recepient_email }}
                </td>

              </tr>
            </tbody>
          </table>
          <div class="p-3 lg:px-6 border-t border-gray-100 dark:border-slate-800">
            <BaseLevel>
              <BaseButtons>
                <BaseButton v-for="page in history.links" :key="page" :active="page.active" :label="page.label"
                  :color="page.active ? 'lightDark' : 'whiteDark'" small @click="currentPage = page"
                  :href="page.url != null ? page.url : ''" :disabled="page.url === null" />
              </BaseButtons>
              <small>Page {{ history.current_page }} of {{ history.last_page }}</small>
            </BaseLevel>
          </div>
        </div>
      </CardBox>


    </SectionMain>
    <FloatingActionButton :title="'Go Back'"
      @click="router.visit(route('view_members_list') + '?length=10&user_name='+ user.user_name +'&isDirty=true&__rememberable=true')">

      <i class="fas fa-arrow-left" style="font-size: 25px; color: #fff;"></i>
    </FloatingActionButton>
  </LayoutAuthenticated>
</template>
<script setup>
import {
  mdiMonitorCellphone,
  mdiTableBorder,
  mdiTableOff,
  mdiGithub,
  mdiHospitalBuilding,
  mdiClose,
  mdiCashRefund,
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
import FloatingActionButton from "@/Components/FloatingActionButton.vue";
import { useMainStore } from "@/Stores/main";
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
//import { Inertia } from '@inertiajs/inertia'
import { computed, ref, reactive, watch } from 'vue'
import _ from 'lodash';

const page = usePage();
const mainStore = useMainStore();

// const hasTermsAndPrivacyPolicyFeature = computed(() => page.props.jetstream?.hasTermsAndPrivacyPolicyFeature)
const props = page.props;
const user = props.user;
const history = props.history;
const useSearchBtn = mainStore.useSearchBtn;
console.log(history)

const lengthOptions = ref([
  10,
  20,
  50,
  100
]);

const roleOptions = ref({
  all: 'all',
  sender: 'sender',
  recepient: 'recepient',
});




const form = useForm({
  length: props.length,

  sender_name: props.sender_name,
  sender_phone: props.sender_phone,
  sender_email: props.sender_email,
  sender_country_name: props.sender_country_name,

  recepient_name: props.recepient_name,
  recepient_phone: props.recepient_phone,
  recepient_email: props.recepient_email,
  recepient_country_name: props.recepient_country_name,

  role: roleOptions.value[props.role],

  amount: props.amount,

  date: props.date,
  start_date: props.start_date,
  end_date: props.end_date,

})
// console.log(form)

const clearFilterForm = () => {
  form.length = 10

  form.sender_name = null
  form.sender_phone = null
  form.sender_email = null
  form.sender_country_name = null

  form.recepient_name = null
  form.recepient_phone = null
  form.recepient_email = null
  form.recepient_country_name = null

  form.role = "all"

  form.amount = null

  form.date = null
  form.start_date = null
  form.end_date = null


  // console.log(form)
}



const submitFilterForm = () => {
  // console.log()
  let query = _.pickBy(form);
  let queryRoute = route('users_transfer_history', user.id);
  let params = Object.keys(query).length ? query : {
    remember: 'forget'
  }
  // console.log(queryRoute)



  router.get(queryRoute, params, {}, {
    // preserveState: true, 
    preserveScroll: true

  });
}

watch(form,
  _.throttle(() => {
    if (useSearchBtn) { return }
    submitFilterForm();
  }, 200), {
  deep: true
}
);


const submit = () => {

};
</script>


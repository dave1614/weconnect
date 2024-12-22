<script setup>
import { useForm, usePage, Head, router } from '@inertiajs/vue3';
import { computed, ref, onMounted } from "vue";
import { useMainStore } from "@/Stores/main";
import {
  mdiAccountMultiple,
  mdiCartOutline,
  mdiChartTimelineVariant,
  mdiMonitorCellphone,
  mdiReload,
  mdiGithub,
  mdiChartPie,
  mdiWallet,
  mdiCash,
  mdiCashCheck,
  mdiTable,
  mdiOpenInNew,
  mdiFacebook,
  mdiTwitter,
  mdiWhatsapp,
  mdiAccount,
  mdiCashPlus,
  mdiCellphoneWireless,
  mdiCellphoneDock,
  mdiTelevisionClassic,
  mdiLightningBoltOutline,
  mdiRouterWireless,
  mdiSchoolOutline,
  mdiWalletBifold
} from "@mdi/js";
import * as chartConfig from "@/Components/Charts/chart.config.js";
import LineChart from "@/Components/Charts/LineChart.vue";
import SectionMain from "@/Components/SectionMain.vue";
import CardBoxWidget from "@/Components/CardBoxWidget.vue";
import CardBox from "@/Components/CardBox.vue";
import TableSampleClients from "@/Components/TableSampleClients.vue";
import NotificationBar from "@/Components/NotificationBar.vue";
import BaseButton from "@/Components/BaseButton.vue";
import CardBoxTransaction from "@/Components/CardBoxTransaction.vue";
import CardBoxClient from "@/Components/CardBoxClient.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import SectionBannerStarOnGitHub from "@/Components/SectionBannerStarOnGitHub.vue";
import UserCard from "@/Components/UserCard.vue";
import UserAvatarCurrentUser from "@/Components/UserAvatarCurrentUser.vue";
import MultipurposeButton from '@/Components/MultipurposeButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import UserAvatar from '@/Components/UserAvatar.vue';
import BaseIcon from '@/Components/BaseIcon.vue';



const props = defineProps({
  monnify_details: {},
  top_ten_earners: {

  },
  downline_arr_num: {

  },
  left_team_total: {

  },
  right_team_total: {

  },
  last_week_commission: {

  },
  total_upteam_earnings: {

  },

  has_current_savings: {

  },
  saving: {

  },

  total_spent_on_vtu_today: {

  },
  total_credited_today: {},
  vtu_services: {
    type: Array
  }


});

const page = usePage()
const chartData = ref(null);

const fillChartData = () => {
  chartData.value = chartConfig.sampleChartData();
};

const mainStore = useMainStore();
onMounted(() => {
  fillChartData();
  // mainStore.changeIsAdminVal(true)
});

const i = 1;


const clientBarItems = computed(() => mainStore.clients.slice(0, 4));

const transactionBarItems = computed(() => mainStore.history);


const hasTermsAndPrivacyPolicyFeature = computed(() => page.props.jetstream?.hasTermsAndPrivacyPolicyFeature)
const user = page.props.user;
const monnify_details = page.props.monnify_details;
console.log(monnify_details)


const vtu_services = ref([
    {
        id: 'Airtime Topup',
        route:  'airtime_topup',
        icon:  mdiCellphoneWireless,
    },
    {
        id: 'Internet Data',
        route:  'internet_data',
        icon:  mdiCellphoneDock,
    },
    {
        id: 'Cable TV',
        route:  'cable_tv',
        icon:  mdiTelevisionClassic,
    },
    {
        id: 'Electricity',
        route:  'electricity_topup',
        icon:  mdiLightningBoltOutline,
    },
    {
        id: 'Router Recharge',
        route:  'router_recharge',
        icon:  mdiRouterWireless,
    },
    {
        id: 'Educational Vouchers',
        route:  'educational_vouchers',
        icon:  mdiSchoolOutline,
    }
]);

// const total_amount_wthdrawn = page.props.user;

const displayForm = useForm({
  url: route('register', {
    c: user.country_id,
    p: user.phone,
  }),
  social_url: route('register', {

    p: user.phone,
  })
})

Swal.close();

const account_created = page.props.account_created;
const last_account_statement = page.props.last_account_statement;


console.log(last_account_statement)

if (account_created) {
  setTimeout(() => {
    Swal.fire({
      title: 'Account creation successful',
      html: 'Your account has been successfully created. Welcome to Go-Easybiz',
      icon: 'success',
    })
  }, 3000);


}

const openPage = (url) => {
  router.visit(route(url))
  // console.log(route(url))
}
</script>


<template>
  <LayoutAuthenticated>

    <Head title="Vtu Dashboard" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Vtu Dashboard" main>
        <!-- <BaseButton
          href="https://github.com/justboil/admin-one-vue-tailwind"
          target="_blank"
          :icon="mdiGithub"
          label="Star on GitHub"
          color="contrast"
          rounded-full
          small
        /> -->
      </SectionTitleLineWithButton>
      <!-- <div class="text-center mt-[80px] mb-6">
        <a class="text-white text-lg font-semibold bg-emerald-500 hover:bg-emerald-600 rounded-[30px] px-8 py-2"
          target="_blank" href="https://chat.whatsapp.com/FVMmkYNHEva0zP5xmWOTxC"><i
            class="fab fa-whatsapp pr-2 text-xl"></i>
          Join Our Whatsapp Group</a>
      </div> -->
      <CardBox class="mb-5" v-if="user.providus_account_number != null && user.providus_account_name != null">
        <div class="mx-3 my-5 text-sm">
          <h3 class="mb-3 text-2xl font-bold">Personalized Account Funding</h3>

          <p class="font-bold text-primary mb-4 mt-2">
            <span>Funding less than ₦9000 is ₦25, while above ₦9000 cost ₦75 only.</span>
          </p>

          <h4 class="text-lg ">Bank Name</h4>
          <p class="text-primary">Providus Bank</p>

          <h4 class="text-lg mt-2">Account Name</h4>
          <p class="text-primary" v-html="user.providus_account_name"></p>


          <h4 class="text-lg mt-2">Account Number</h4>
          <p class="text-primary">{{user.providus_account_number}}</p>

          <table>
            <thead>
              <tr>

                <th></th>

                <th>Bank Name</th>
                <th>Account Name</th>
                <th>Account Number</th>
              </tr>
            </thead>
            <tbody>

              <tr v-if="user.providus_account_number != null">
                <td></td>
                <td data-label="Bank Name">Providus Bank</td>
                <td data-label="Account Name">{{ user.providus_account_name }}</td>
                <td data-label="Account Number">{{ user.providus_account_number }}</td>
              </tr>

              <!-- <tr v-if="monnify_details.wema_account_number != null">
                <td></td>
                <td>Wema Bank</td>
                <td>{{ monnify_details.wema_account_name }}</td>
                <td>{{ monnify_details.wema_account_number }}</td>
              </tr>

              <tr v-if="monnify_details.sterling_account_number != null">
                <td></td>
                <td>Sterling Bank</td>
                <td>{{ monnify_details.sterling_account_name }}</td>
                <td>{{ monnify_details.sterling_account_number }}</td>
              </tr>

              <tr v-if="monnify_details.fidelity_account_number != null">
                <td></td>
                <td>Fidelity Bank</td>
                <td>{{ monnify_details.fidelity_account_name }}</td>
                <td>{{ monnify_details.fidelity_account_number }}</td>
              </tr>

              <tr v-if="monnify_details.moniepoint_account_number != null">
                <td>Moniepoint</td>
                <td>{{ monnify_details.moniepoint_account_name }}</td>
                <td>{{ monnify_details.moniepoint_account_number }}</td>
              </tr> -->
            </tbody>
          </table>

        </div>
      </CardBox>



      <div class="grid grid-cols-1 gap-6 lg:grid-cols-4 mb-6">
        <CardBoxWidget
          :trend="(last_account_statement.amount != 0.00) ? `${(((last_account_statement.amount_after - last_account_statement.amount_before) / last_account_statement.amount_before) * 100).toFixed(2)}%` : null"
          :trend-type="parseFloat(last_account_statement.amount_before) < parseFloat(last_account_statement.amount_after) ? 'up' : 'down'"
          color="text-yellow-500" :icon="mdiWallet" :number="parseFloat(last_account_statement.amount_after)"
          label="E-Wallet" prefix="₦" :href="route('wallet.overview')" />



        <!-- <CardBoxWidget color="text-red-500" :icon="mdiCashCheck" :number="parseFloat(user.total_withdrawan)" prefix="₦"
          label="Withdrawn" /> -->



        <CardBoxWidget color="text-primary" :icon="mdiTable" :number="total_spent_on_vtu_today" prefix="₦"
          label="Total Spent On Vtu Today" />

        <CardBoxWidget color="text-slate-500" :icon="mdiCashPlus" :number="total_credited_today" prefix="₦"
          label="Total Credited Today" />
        <!-- <CardBoxWidget
          trend="Overflow"
          trend-type="alert"
          color="text-red-500"
          :icon="mdiChartTimelineVariant"
          :number="total_amount_wthdrawn"
          suffix="%"
          label="Withdrawn"
        /> -->

      </div>

      <div class="my-6" v-if="vtu_services.length > 0">

        <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Vtu Services" >

        </SectionTitleLineWithButton>



        <div class="sm:grid sm:grid-cols-12 sm:gap-6">
          <CardBox @click="openPage(service.route)" v-for="(service, index) in  vtu_services" :key="index" class="cursor-pointer sm:col-span-4 relative my-5 py-4 mx-4 shadow-xl hover:shadow-2xl transition-all ease-in-out duration-500 hover:my-5">
            <div class="flex justify-center items-center">
              <BaseIcon  :path="service.icon" class="flex-shrink-0" size="50" w="50" h="50" />
            </div>

            <p class="text-center text-xl font-bold block">{{ service.id }}</p>
          </CardBox>
        </div>
      </div>

      <SectionTitleLineWithButton :icon="mdiWalletBifold" title="E-wallet" >

      </SectionTitleLineWithButton>


      <div  class="mt-[30px]">
        <CardBox class="mb-6">

          <ul class="divide-y-2 divide-gray-400 mt-[10px]">

            <li @click="openPage('wallet.overview')" class="listview-list">
              <span class="font-semibold ">1. Overview </span>
            </li>

            <li @click="openPage('wallet.credit_history')" class="listview-list">
              <span class="font-semibold ">2. Wallet Credit History </span>
            </li>

            <li @click="openPage('wallet.transfer')" class="listview-list">
              <span class="font-semibold ">3. Funds Transfer </span>
            </li>

            <li @click="openPage('wallet.transfer_history')" class="listview-list">
              <span class="font-semibold ">4. Transfer History </span>
            </li>

            <li @click="openPage('wallet.statement')" class="listview-list">
              <span class="font-semibold ">5. E-wallet Statement</span>
            </li>


          </ul>
        </CardBox>
      </div>

      <!-- <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-1">
        <CardBox class="">
          <UserAvatarCurrentUser class="h-24 w-24 mx-auto" />

          <div class="mt-6 text-center">
            <p class="text-xs text-gray-400 font-semibold">{{ user.email }}</p>
            <p class="text-lg text-gray-500 font-bold mt-3" v-html="`${user.phone_code}${user.phone}`"></p>
            <p class="text-2xl dark:text-white text-black font-bold mt-3" v-html="`${user.name}`"></p>
          </div>
          <div class="flex justify-center mt-6 text-center">
            <MultipurposeButton :href="route('edit_profile')" label="Edit Profile" />
          </div>

        </CardBox>
      </div> -->


      <!-- <SectionBannerStarOnGitHub class="mt-6 mb-6" /> -->

      <!-- <SectionTitleLineWithButton :icon="mdiChartPie" title="Trends overview">
        <BaseButton
          :icon="mdiReload"
          color="whiteDark"
          @click="fillChartData"
        />
      </SectionTitleLineWithButton>

      <CardBox class="mb-6">
        <div v-if="chartData">
          <line-chart :data="chartData" class="h-96" />
        </div>
      </CardBox> -->

      <!-- <SectionTitleLineWithButton :icon="mdiAccountMultiple" title="Team Perfomance" />

      <NotificationBar color="info" :icon="mdiMonitorCellphone">
        <b>Top 10 Mlm Earners</b>
      </NotificationBar> -->

      <!-- <CardBox has-table>
        <table>
          <thead>
            <tr>

              <th>#</th> -->
      <!-- <th /> -->
      <!-- <th>Full Name</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user,index) in top_ten_earners.data" :key="user.id"> -->
      <!-- <td>{{ i++ }}.</td> -->
      <!-- <td v-html="`${(index + 1) + ((top_ten_earners.current_page - 1) * 10)}.`"></td> -->
      <!-- <td class="border-b-0 lg:w-6 before:hidden">
                <UserAvatar :username="user.name" class="w-24 h-24 mx-auto lg:w-6 lg:h-6" />
              </td> -->
      <!-- <td data-label="Name">
                {{ user.name }}
              </td>
              <td data-label="Amount" v-html="mainStore.addCommas(user.total_earnings)">

              </td>

            </tr>
          </tbody>
        </table> -->
      <!-- <TableSampleClients /> -->


      <!-- </CardBox> -->


    </SectionMain>
  </LayoutAuthenticated>
</template>


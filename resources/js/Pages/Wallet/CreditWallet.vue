<template inheritAttrs="false">
  <LayoutAuthenticated>

    <Head :title="`Credit Your Wallet`" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiWalletPlus" :title="`Credit Your Wallet`" main>
        <BaseButton :href="route('wallet.credit_history')"  :icon="mdiHistory"
          label="WALLET CREDIT HISTORY" color="success" rounded-full small />
      </SectionTitleLineWithButton>
      <!-- <NotificationBar color="info" :icon="mdiMonitorCellphone">
        <b>Responsive table.</b> Collapses on mobile
      </NotificationBar> -->

      <CardBox class="mb-6">
        <h4 class="text-xl font-bold">Wallet Balance <span class="italic text-primary" v-html="`₦${mainStore.addCommas((user.total_income - user.withdrawn).toFixed(2))}`"></span></h4>

        <h5 class="text-lg font-semibold">Personalized Account Funding</h5>
        
        <p class="my-3">Funding less than ₦9000 is ₦25, while above ₦9000 cost ₦75 only.</p>
        
      </CardBox>

      <CardBox class="mb-6" has-table>

        <div class="">
          <table>
            
            <tbody>
              <tr>
                <td>Bank Name</td>
                <td>Providus Bank</td>
              </tr>
              <tr>
                <td>Account Name</td>
                <td class="text-bold italic text-sm text-primary">{{ user.providus_account_name }}</td>
              </tr>
              <tr>
                <td>Account Number</td>
                <td class="text-bold italic text-sm text-primary">{{ user.providus_account_number }}</td>
              </tr>
            </tbody>
          </table>
          
        </div>
      </CardBox>




    </SectionMain>
    
  </LayoutAuthenticated>
</template>
<script setup>
import {
  mdiMonitorCellphone,
  mdiTableBorder,
  mdiTableOff,
  mdiHistory,
  mdiHospitalBuilding,
  mdiClose,
  mdiClipboardTextClock,
  mdiAccountCog,
  mdiAccountCash,
  mdiWalletPlus,
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
import { computed, ref, reactive, watch } from 'vue'
import axios from "axios";
import _ from 'lodash';

const page = usePage();
const mainStore = useMainStore();

const btn_hovered = ref(false);

// const hasTermsAndPrivacyPolicyFeature = computed(() => page.props.jetstream?.hasTermsAndPrivacyPolicyFeature)
const props = page.props;
const user = props.user;

const useSearchBtn = mainStore.useSearchBtn;





</script>


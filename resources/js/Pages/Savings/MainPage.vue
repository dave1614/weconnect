<style>

</style>
<template inheritAttrs="false">
	<LayoutAuthenticated>

		<Head :title="`Go-Easy Savings`" />
		<SectionMain>
			<SectionTitleLineWithButton :icon="mdiWalletOutline" :title="`Go-Easy Savings`" main>

				<!-- <BaseButton :href="route('easy_loan_history_page') + '?length=10&type=airtime&isDirty=true&__rememberable=true'"
					:icon="mdiHistory" label="View Loans." color="success" rounded-full small /> -->
			</SectionTitleLineWithButton>
			<!-- <NotificationBar color="info" :icon="mdiMonitorCellphone">
        <b>Responsive table.</b> Collapses on mobile
      </NotificationBar> -->



			<CardBox class="">
				<div class="font-semibold">
					<h3 class="text-center font-bold text-3xl mb-7">Go-Easy Community Multipurpose Cooperative Saving.</h3>
					<p>
						If You Save Money, Money Will Save You. Start The Year With Savings Plan.
						Saving money is vital for your financial future.<br>
						If you want to focus on building wealth, you must save money. Your savings attracts 2% monthly. <br><br>
						
						We have 365 days in a year. You can save something great. <br><br><br>
						
						
						<b>DAILY SAVINGS</b><br>
						100 naira daily------ 36,500 naira <br>
						200 naira daily------ 73,000 <br>
						300 naira daily------ 109,500 <br>
						500 naira daily------ 182,500 <br>
						1,000 naira daily------ 365,000 <br>
						1500 naira daily------ 547,500 <br>
						2,000 naira daily------ 730,000 <br>
						2,500 naira daily------ 912,500 <br>
						3,000 naira daily------ 1,095,000 <br><br>
						
						<b>WEEKLY SAVINGS</b> <br>
						500 naira weekly ——— 26,500 <br>
						1,000 naira weekly------ 53,000 <br>
						1500 naira weekly ------ 79,500 <br>
						2,000 naira weekly ------ 106,000 <br>
						2,500 naira weekly------ 132,500 <br>
						3,000 naira weekly ------ 159,000 <br><br>
						
						<b>MONTHLY SAVINGS</b><br>
						2,000 naira monthly ------ 24,000 <br>
						2,500 naira monthly ------ 30,000 <br>
						3,000 naira monthly ------ 36,000 <br>
						5,000 naira monthly —— 60,000 <br>
						10,000 naira monthly — 120,000 <br>
						15,000 naira monthly — 180,000 <br>
						20,000 naira monthly — 240,000 <br><br>
						
						Choose any plan you can be consistent with and enjoy savings.

						
					</p>

					<h5 class="font-bold text-2xl text-center my-6">Choose Action</h5>

					<CardBox class="mb-6" has-table>

						<div v-if="filtered_params.length > 0" class="">
							<table>

								<tbody>
									<!-- <tr class="cursor-pointer" @click="showApplyCard = true">
										<td>1.</td>
										<td class="capitalize">Apply For Savings</td>
										
									</tr> -->
									<tr @click="router.visit(param.url)" class="cursor-pointer"
										:class="param.color == '' ? '' : param.color" v-for="(param, index) in filtered_params"
										:key="index">
										<!-- <td>{{ param.num }}. </td> -->
										<td class="capitalize">{{ param.name }}</td>
									</tr>

								</tbody>
							</table>

						</div>
					</CardBox>

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
	mdiGithub,
	mdiHospitalBuilding,
	mdiClose,
	mdiCellphoneWireless,
	mdiAccountCog,
	mdiAccountCash,
	mdiCurrencyNgn,
	mdiPhone,
	mdiHistory,
	mdiWalletOutline,
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
const user = props.auth.user;

const has_current_savings = props.has_current_savings;
const saving_id = props.saving_id;


const useSearchBtn = mainStore.useSearchBtn;


const table_params = ref([
	{
		'id': 1,
		'num': 1,
		'name': 'Apply For Savings',
		'url': route('apply_for_savings'),
		'color': '',
	},
	{
		'id': 2,
		'num': 1,
		'name': 'View your current saving details',
		'url': route('view_saving_details', saving_id),
		'color': '',
	},
	{
		'id': 3,
		'num': 2,
		'name': 'View Savings History',
		'url': route('savings_history'),
		'color': '',
	},
	{
		'id': 4,
		'num': 3,
		'name': 'Auto Withdrawal History',
		'url': route('savings_auto_withd_history'),
		'color': '',
	},
	{
		'id': 5,
		'num': 1,
		'name': 'Deactivate current plan',
		'url': route('deactivate_saving_plan'),
		'color': 'text-red-500',
	},
]);

const filtered_params = ref([]);



const getFilteredTableParams = () => {
	filtered_params.value = table_params.value;
	// console.log(filtered_params.value)
	// let index = (has_current_savings) ? 0 : 1;

	// filtered_params.value.splice(index,1);
	if (has_current_savings) {
		filtered_params.value.splice(0, 1);
	} else {
		filtered_params.value.splice(1, 1);
		filtered_params.value.splice(3, 1);
	}

}



getFilteredTableParams()






</script>


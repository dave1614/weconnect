<template inheritAttrs="false">
	<LayoutAuthenticated>

		<Head :title="`${user.name}'s Earnings Wallet`" />
		<SectionMain>
			<SectionTitleLineWithButton :icon="mdiCashClock" :title="`${user.name}'s Earnings Wallet`" main>
				<!-- <BaseButton href="https://github.com/justboil/admin-one-vue-tailwind" target="_blank" :icon="mdiGithub"
          label="Star on GitHub" color="contrast" rounded-full small /> -->
			</SectionTitleLineWithButton>
			<!-- <NotificationBar color="info" :icon="mdiMonitorCellphone">
        <b>Responsive table.</b> Collapses on mobile
      </NotificationBar> -->

			<CardBox isForm @submit.prevent="submitFilterForm" class="mb-9">
				<h4 class="text-2xl font-bold">Earnings Wallet Balance:</h4>
				<h5 class="text-xl font-semibold my-4">₦ {{ mainStore.addCommas(user.earnings_wallet) }}</h5>
				<BaseDivider />
			</CardBox>
			
			<h5 class="text-2xl my-4 font-bold text-center">Earnings History</h5>


			<CardBox isForm @submit.prevent="submitFilterForm" class="">
				<div class="sm:grid sm:grid-cols-12 sm:gap-6">
					<FormField class="sm:col-span-4" label="Length: ">
						<FormControl v-model="form.length" :options="lengthOptions" />
					</FormField>
					<FormField class="sm:col-span-4" label="Amount">
						<FormControl v-model="form.amount" type="number" step="any" />
					</FormField>
			
					<FormField class="sm:col-span-4" label="Balance">
						<FormControl v-model="form.balance" type="number" step="any" />
					</FormField>
			
			
					<FormField class="sm:col-span-4" label="Withdrawal Date">
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
								<th>Balance After (₦)</th>
								<th>Date/ Time</th>
			
			
			
							</tr>
						</thead>
						<tbody>
							<tr v-for="(row, index) in history.data" :key="row.id">
			
								<!-- <td>{{ row.index }}. </td> -->
			
								<td v-html="`${(index + 1) + ((history.current_page - 1) * form.length)}.`"></td>
			
								<td data-label="Amount" v-html="mainStore.addCommas(row.amount)">
			
								</td>
			
								<td data-label="Balance After" v-html="mainStore.addCommas(row.balance)">
			
								</td>
			
								<td data-label="Date / Time" v-html="`${row.date} ${row.time}`">
			
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
			@click="router.visit(route('view_members_list') + '?length=10&name=' + user.name + '&isDirty=true&__rememberable=true')">

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
	mdiClipboardTextClock,
	mdiAccountCog,
	mdiAccountCash,
	mdiCashClock,
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
const history = page.props.history;

const useSearchBtn = mainStore.useSearchBtn;
console.log(history)

const lengthOptions = ref([
	10,
	20,
	50,
	100
]);



const form = useForm({
	length: props.length,
	amount: props.amount,
	balance: props.balance,
	date: props.date,

	start_date: props.start_date,
	end_date: props.end_date,

})



const clearFilterForm = () => {
	form.length = 10
	form.amount = null
	form.balance = null
	form.date = null
	form.start_date = null
	form.end_date = null
}



const submitFilterForm = () => {
	// console.log('test')
	let query = _.pickBy(form);
	let queryRoute = route('users_earnings_wallet', user.id);
	let params = Object.keys(query).length ? query : {
		remember: 'forget'
	}
	// console.log(queryRoute)


	router.get(queryRoute, params, {
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


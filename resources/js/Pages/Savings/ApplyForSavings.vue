<style>

</style>
<template inheritAttrs="false">
	<LayoutAuthenticated>

		<Head :title="`Savings Application`" />
		<SectionMain>
			<SectionTitleLineWithButton :icon="mdiWalletOutline" :title="`Go-Easy Savings`" main>

				<BaseButton :href="route('goeasy_savings_main_page')"
					:icon="mdiArrowLeft" label="Go Back" color="warning" rounded-full small />
			</SectionTitleLineWithButton>
			<!-- <NotificationBar color="info" :icon="mdiMonitorCellphone">
        <b>Responsive table.</b> Collapses on mobile
      </NotificationBar> -->


			<CardBox isForm @submit.prevent="submit">

				<h4 class="font-bold text-center text-2xl mt-2 mb-7">Apply For For Go-easybiz Savings</h4>
				<h6 class="text-lg font-semibold mb-9">Please choose your plan: </h6>

				<div class="sm:grid sm:grid-cols-12 sm:gap-6 mt-5">
					<FormField class="sm:col-span-6" label="Enter Amount">
						<FormControl v-model="form.amount" type="number" :icon="mdiCurrencyNgn" :error="form.errors.amount" />

					</FormField>

					<FormField class="sm:col-span-6" label="Choose Frequency">
						<FormControl v-model="form.frequency" :options="frequencies" :error="form.errors.frequency" />
					</FormField>

					<FormField class="sm:col-span-6" label="Choose Savings Duration">
						<FormControl v-model="form.duration" :options="duration_types" :error="form.errors.duration" />
					</FormField>

				</div>

				<template #footer>
					<!-- <BaseButtons>
                  <BaseButton type="submit" color="info" label="Submit" />
                  
                </BaseButtons> -->
					<button :class="form.processing ? 'opacity-80 cursor-not-allowed' : ''" @mouseleave="btn_hovered = false"
						@mouseover="btn_hovered = true" type="submit" class="app-form-button">
						Submit
						<img v-if="form.processing" class="inline-block w-7 h-6 float-right"
							:src="btn_hovered ? FormLoaderDark : FormLoaderLight" alt="">
					</button>

				</template>
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
	mdiArrowLeft,
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
const frequencies = props.frequencies;
const duration_types = props.duration_types;

console.log(frequencies)
console.log(duration_types)

const has_current_savings = props.has_current_savings;

const errors_size = ref(0);


const useSearchBtn = mainStore.useSearchBtn;


const form = useForm({
	amount: null,
	frequency: frequencies[0],
	duration: duration_types[0],
	
});



const submit = () => {
	if (!form.processing) {

		errors_size.value = 0;

		if (form.amount != null && form.amount != ""){
			if(form.amount >= 100){
				Swal.fire({
					title: 'Procceed?',
					icon: 'question',
					html: `<p class='capitalize'>You have chosen to save <em class='text-emerald-500'>₦${mainStore.addCommas(form.amount)}</em> ${form.frequency.label} for ${form.duration.label}.</p> Are you sure you want to proceed?`,
					showCancelButton: true,
					confirmButtonText: 'Yes, Proceed',
					cancelButtonText: `No, Cancel`,
				}).then((result) => {
					if (result.isConfirmed) {

						form.post(route('process_apply_for_easy_savings'), {
							preserveScroll: true,
							onSuccess: (page) => {

								var response = page.props.flash.data;
								console.log(response)
								if (response.success) {

									Swal.fire({
										title: 'Success',
										icon: 'success',
										html: `You request to save <em class='text-emerald-500'>₦${mainStore.addCommas(form.amount)}</em> ${form.frequency.label} for ${form.duration.label} has been approved.`,
										allowEscapeKey: false,
										allowOutsideClick: false,

									}).then((result) => {
										router.visit(route('goeasy_savings_main_page'));

									});
								} else if (response.already_saving) {
									
									Swal.fire({
										title: 'Error',
										icon: 'error',
										html: 'You already have a saving plan ongoing. Please end that before you proceed.',
									});
								} 
							}, onError: (errors) => {
								var size = Object.keys(errors).length;
								errors_size.value = size;
								console.log(errors)
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: `There are ${size} form error(s). Please fix them`,
								})
							},
						});
					}
				});
			} else {
				Swal.fire({
					title: 'Error!',
					icon: 'error',
					html: `Minimum saveable amount is ₦100`,

				})
			}
		}else{
			Swal.fire({
				title: 'Error!',
				icon: 'error',
				html: `Invalid amount entered.`,
				
			})
		}
	}
};




</script>


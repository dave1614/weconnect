<style>

</style>
<template inheritAttrs="false">
	<LayoutAuthenticated>

		<Head :title="`Go-Easy Savings`" />
		<SectionMain>
			<SectionTitleLineWithButton :icon="mdiWalletOutline" :title="`Go-Easy Savings`" main>

				<BaseButton :href="route('goeasy_savings_main_page')" :icon="mdiArrowLeft" label="Go Back" color="warning"
					rounded-full small />
			</SectionTitleLineWithButton>
			<!-- <NotificationBar color="info" :icon="mdiMonitorCellphone">
        <b>Responsive table.</b> Collapses on mobile
      </NotificationBar> -->







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


const has_current_savings = props.has_current_savings;

const errors_size = ref(0);


const useSearchBtn = mainStore.useSearchBtn;


const form = useForm({


});

Swal.fire({
	icon: 'warning',
	title: 'Note deactivation incurs forfeiting 10% of you money saved?',
	html: 'Are you sure you want to proceed?',
	showDenyButton: true,
	showCancelButton: false,
	confirmButtonText: 'Yes, Proceed',
	denyButtonText: `No, Go Back`,
	allowEscapeKey: false,
	allowOutsideClick: false,
}).then((result) => {
	/* Read more about isConfirmed, isDenied below */
	if (result.isConfirmed) {
		deactivateSaving();
	} else if (result.isDenied) {
		router.visit(route('goeasy_savings_main_page'));
	}
})



const deactivateSaving = () => {

	if (!form.processing) {

		errors_size.value = 0;

		
		
		
		form.post(route('process_savings_deactivation'), {
			preserveScroll: true,
			onSuccess: (page) => {

				var response = page.props.flash.data;
				console.log(response)
				if (response.success) {

					Swal.fire({
						title: 'Success',
						icon: 'success',
						html: `You have successfully deactivated your savings plan. You have been credited.`,
						allowEscapeKey: false,
						allowOutsideClick: false,

					}).then((result) => {
						router.visit(route('goeasy_savings_main_page'));

					});
				} else if (!response.already_saving) {

					Swal.fire({
						title: 'Error',
						icon: 'error',
						html: 'You dont currently a saving plan ongoing. Please choose one first.',
						allowEscapeKey: false,
						allowOutsideClick: false,
					}).then((result) => {
						router.visit(route('goeasy_savings_main_page'));

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
};




</script>


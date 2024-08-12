<template inheritAttrs="false">
	<LayoutAuthenticated>

		<Head title="Saving Details" />
		<SectionMain>
			<SectionTitleLineWithButton :icon="mdiClipboardTextClock" title="Saving Details" main>
				<!-- <BaseButton href="https://github.com/justboil/admin-one-vue-tailwind" target="_blank" :icon="mdiGithub"
          label="Star on GitHub" color="contrast" rounded-full small /> -->
			</SectionTitleLineWithButton>
			<!-- <NotificationBar color="info" :icon="mdiMonitorCellphone">
        <b>Responsive table.</b> Collapses on mobile
      </NotificationBar> -->

			

			<CardBox class="mb-6" >

				<div  class="">

					<div class="mb-7">
						<div v-for="(value, key) in saving" :key="key">
							<div v-if="key != 'id' && key != 'user_id' && key != 'savings_frequency_id' && key != 'savings_duration_id' && key != 'created_at' && key != 'updated_at'" class="grid grid-cols-12 gap-6 my-2">
								<h5 class="text-lg font-semibold capitalize col-span-6">
									<span>{{ mainStore.replaceUnderscoreWithSpace(key) }}</span>
								</h5>
								<h5 class="text-lg font-semibold capitalize text-gray-500 col-span-6">
									<span class="" v-if="key == 'defaulted' || key == 'disbursed'">{{ Boolean(Number(value)) }}</span>
								
									<span v-else>{{ value }}</span>
								</h5>
							</div>
							
						</div>
					</div>

					<BaseButton target="_blank" :href="route('savings_debit_history', saving.id)" color="success" label="View Debit History" class="px-9 mt-8" />
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
	mdiClipboardTextClock
} from "@mdi/js";

import CardBoxModal from "@/Components/CardBoxModal.vue";
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
import { useMainStore } from "@/Stores/main";
import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
//import { Inertia } from '@inertiajs/inertia'
import { computed, ref, reactive, watch } from 'vue'
import _ from 'lodash';

const page = usePage();
const mainStore = useMainStore();

// const hasTermsAndPrivacyPolicyFeature = computed(() => page.props.jetstream?.hasTermsAndPrivacyPolicyFeature)
const props = page.props;
const saving = props.saving;

console.log(saving)


</script>


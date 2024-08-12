<script setup>
import { mdiCog } from "@mdi/js";
import CardBox from "@/Components/CardBox.vue";
import NumberDynamic from "@/Components/NumberDynamic.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import BaseLevel from "@/Components/BaseLevel.vue";
import PillTagTrend from "@/Components/PillTagTrend.vue";
import BaseButton from "@/Components/BaseButton.vue";

defineProps({
    href: {
        type: String,
        default: "0",
    },
    
    label: {
        type: String,
        default: null,
    },
    
});
</script>

<template>
    <a  :href="href" class="text-white dark:hover:text-white hover:text-black dark:text-black dark:hover:bg-primary dark:bg-secondary bg-primary hover:bg-secondary mx-5 block w-full py-2 rounded-full">{{ label }}</a>
</template>

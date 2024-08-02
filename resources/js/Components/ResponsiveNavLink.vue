<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'block w-full ps-3 pe-4 py-2 text-center font-medium text-gray-600 hover:text-black hover:font-bold'
        : 'block w-full ps-3 pe-4 py-2 text-center font-medium text-gray-600 hover:text-black hover:font-bold'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

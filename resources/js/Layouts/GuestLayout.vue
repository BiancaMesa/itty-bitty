<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <Link class="shrink-0 flex flex-col items-center justify-center" href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
                <span class="text-s font-bold text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">Itty Bitty</span>
            </Link>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>

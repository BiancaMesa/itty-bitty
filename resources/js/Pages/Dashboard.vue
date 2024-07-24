<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import ShortenUrl from './ShortenUrl.vue';
import ManageUrls from './ManageUrls.vue';
import Analytics from './Analytics.vue';

const currentView = ref('shortenUrl');

const showManageUrls = () => {
    currentView.value = 'manageUrls';
};

const showShortenUrl = () => {
    currentView.value = 'shortenUrl';
};

const showAnalytics = () => {
    currentView.value = 'analytics';
};

const { props } = usePage();
const latestFullShortenedUrl = props.latestFullShortenedUrl || '';
const shortUrls = props.shortUrls || [];

</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="py-4">
            <button @click="showShortenUrl" :class="{ 'text-sky-800 bg-white border border-gray rounded-md': currentView === 'shortenUrl' }" class="px-4 py-2 font-bold">Shorten URL</button>

            <button @click="showManageUrls" :class="{ 'text-sky-800 bg-white border border-gray rounded-md' : currentView === 'manageUrls' }" class="px-4 py-2 font-black">Manage Your URLs</button>

            <button @click="showAnalytics" :class="{ 'text-sky-800 bg-white border border-gray rounded-md': currentView === 'analytics' }" class="px-4 py-2 font-bold">Analytics</button>
        </div>

        <main class="w-screen h-screen bg-sky-50">
            <ShortenUrl v-if="currentView === 'shortenUrl'" :latestFullShortenedUrl="latestFullShortenedUrl" />
            <ManageUrls v-if="currentView === 'manageUrls'" :shortUrls="shortUrls" />
            <analytics v-if="currentView === 'analytics'" :shortUrls="shortUrls" />
        </main>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useUrlStore } from '@/stores/urlStore';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ShortenUrl from './ShortenUrl.vue';
import ManageUrls from './ManageUrls.vue';
import Analytics from './Analytics.vue';

const currentView = ref('shortenUrl');
const showManageUrls = () => { currentView.value = 'manageUrls'; };
const showShortenUrl = () => { currentView.value = 'shortenUrl'; };
const showAnalytics = () => { currentView.value = 'analytics'; };

const urlStore = useUrlStore();

</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="py-4 bg-sky-50">
            <button @click="showShortenUrl" :class="{ 'text-sky-800 bg-white border border-gray rounded-md': currentView === 'shortenUrl' }" class="px-4 py-2 font-bold">Shorten URL</button>

            <button @click="showManageUrls" :class="{ 'text-sky-800 bg-white border border-gray rounded-md' : currentView === 'manageUrls' }" class="px-4 py-2 font-black">Manage Your URLs</button>

            <button @click="showAnalytics" :class="{ 'text-sky-800 bg-white border border-gray rounded-md': currentView === 'analytics' }" class="px-4 py-2 font-bold">Analytics</button>
        </div>

        <main class="w-screen h-screen">
            <!-- <ShortenUrl v-if="currentView === 'shortenUrl'" :latestFullShortenedUrl="latestFullShortenedUrl" />
            <ManageUrls v-if="currentView === 'manageUrls'" :shortUrls="shortUrls" />
            <Analytics v-if="currentView === 'analytics'" :shortUrls="shortUrls" /> -->

            <ShortenUrl v-if="currentView === 'shortenUrl'" />
            <ManageUrls v-if="currentView === 'manageUrls'" />
            <Analytics v-if="currentView === 'analytics'" />
        </main>
    </AuthenticatedLayout>
</template>

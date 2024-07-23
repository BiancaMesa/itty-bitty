<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import ShortenUrl from './ShortenUrl.vue';
import ManageUrls from './ManageUrls.vue';

// Reactive property to track the current view
const currentView = ref('shortenUrl');

// Switch to the URL management view
const showManageUrls = () => {
    currentView.value = 'manageUrls';
};

// Switch to the URL shortening form view
const showShortenUrl = () => {
    currentView.value = 'shortenUrl';
};

// Get props from Inertia
const { props } = usePage();
const latestFullShortenedUrl = props.latestFullShortenedUrl || '';
const shortUrls = props.shortUrls || [];
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="py-4">
            <button @click="showShortenUrl" :class="{ 'bg-sky-300': currentView === 'shortenUrl' }" class="px-4 py-2 font-bold">Shorten URL</button>
            <button @click="showManageUrls" :class="{ 'bg-sky-300': currentView === 'manageUrls' }" class="px-4 py-2 font-bold">Handle Your URLs</button>
        </div>

        <main class="w-screen h-screen bg-sky-50">
            <ShortenUrl v-if="currentView === 'shortenUrl'" :latestFullShortenedUrl="latestFullShortenedUrl" />
            <ManageUrls v-if="currentView === 'manageUrls'" :shortUrls="shortUrls" />
        </main>
    </AuthenticatedLayout>
</template>

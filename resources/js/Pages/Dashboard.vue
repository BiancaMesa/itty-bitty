<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useUrlStore } from '@/stores/urlStore';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ShortenUrl from './ShortenUrl.vue';
import ManageUrls from './ManageUrls.vue';
import Analytics from './Analytics.vue';
//import Navigation from '@/Components/Navigation.vue'; 


const currentView = ref('shortenUrl');

//Methods to switch views
const showView = (view) => { currentView.value = view};

const views = {
    shortenUrl: 'Shorten URL', 
    manageUrls: 'Manage Your URLs',
    analytics: 'Analytics'
};

const urlStore = useUrlStore();

</script>

<template>
    <Head title="Shorten URL" />
    <AuthenticatedLayout>

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

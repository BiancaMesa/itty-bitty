<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue'; //needed for reactive variables
import { Head, useForm, usePage } from '@inertiajs/vue3';

// Initialize form data 
const form = useForm({
    original_url: ''
});

// Initialize the variable to display error message
const errorMessage = ref('');
const successMessage = ref('');

// Function to submit form ---> POST 
const submitForm = () => {
    form.post(route('short.url'), {
        // Handling potential errors
        onError: (errors) => {
            errorMessage.value = errors.original_url ? 'Please, introduce a valid URL' : 'An unexpected error occurred. Please try again.';
        }
    });
};

// We use the usePage to get the props from backend 
const { props } = usePage();
const latestFullShortenedUrl = props.latestFullShortenedUrl || '';

//Reactive properties
const fullShortenedUrl = ref(latestFullShortenedUrl);
</script>

<template >
    <Head title="Dashboard" />

    <AuthenticatedLayout >
        <!-- <main class="w-screen h-screen bg-white bg-gradient-to-b from-sky-100 via-emerald-50 via-white via-emerald-50 to-emerald-100"> -->
        <main class="w-screen h-screen bg-sky-50">

            <!-- // URL Shortening form // -->
            <div class="py-16 flex justify-center text-center">
                <form class="flex flex-col" @submit.prevent="submitForm">
                    <label class="text-sky-800 mb-4 font-extrabold  md:text-3xl" for="original_url">Enter Your Long URL:</label>

                    <input 
                        class="border border-gray-300 rounded-lg w-full sm:w-96 mt-2" 
                        type="url" 
                        v-model="form.original_url" 
                        name="original_url" 
                        id="original_url" 
                        required
                    >

                    <button class="m-2 px-6 py-2 bg-sky-200 font-bold  text-gray-700 hover:bg-sky-300 hover:text-gray-800 rounded-lg" type="submit">Submit</button>
                </form>
            </div>

            <!-- Display error message -->
            <span v-if="errorMessage" class="text-red-400 m-2 p-2">
                {{ errorMessage }}
            </span>

            <!-- Display latest shortened URL -->
            <div v-if="fullShortenedUrl" class="mt-10 text-center">
                <h3 class="font-semibold mb-2 text-cyan-700 mb-8 md:text-3xl">Your Full Shortened URL:</h3>
                <a class="px-8 py-4 rounded border border-slate-800 bg-white text-gray-900 font-bold hover:text-sky-600" :href="fullShortenedUrl" target="_blank" rel="noopener noreferrer">
                    {{ fullShortenedUrl }}
                </a>
            </div>
        </main>
    </AuthenticatedLayout>
</template>

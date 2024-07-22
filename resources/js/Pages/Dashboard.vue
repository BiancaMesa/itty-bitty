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

// Submit function for the form ---> POST 
const submitForm = () => {
    form.post(route('short.url'), {
        // onSuccess: () => {
        //     form.reset();  // Reset form after successful submission if needed //REMOVE ???
        //     errorMessage.value = ''; // Clear any previous error message
        // },
         // Expecting JSON response
         onSuccess: (data) => {
            shortenedUrl.value = data.shortenedUrl;
            successMessage.value = data.successMessage;
            form.reset(); // Reset form after successful submission
            errorMessage.value = ''; // Clear any previous error message
        },
        // Handling potential errors
        // onError: (errors) => {
        //     if (errors.original_url) {
        //         errorMessage.value = 'Please, introduce a valid URL';
        //     } else {
        //         errorMessage.value = 'An unexpected error occurred. Please try again.';
        //     }
        // },
        onError: (errors) => {
            errorMessage.value = errors.original_url ? 'Please, introduce a valid URL' : 'An unexpected error occurred. Please try again.';
        }
    });
};

// We use the usePage to get the shortenedUrl and successMessage (props) from backend. 
const { props } = usePage();
const shortUrls = props.shortUrls || [];
//const shortenedUrl = props.shortenedUrl || '';
const successMessage = props.successMessage || '';

// Base URL for the shortened links
const baseUrl = 'https://itty-bitty.com/';

// Find the last (most recent) url shortened key
const lastShortUrl = shortUrls.length ? shortUrls[shortUrls.length - 1] : null;

// Compute the full shortened URL
const fullShortenedUrl = lastShortUrl ? `${baseUrl}${lastShortUrl.short_url}` : '';

//Reactive properties
const successfulMessage = ref(successMessage);
</script>

<template >
    <Head title="Dashboard" />

    <AuthenticatedLayout >
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template> -->

        <!-- <main class="w-screen h-screen bg-white bg-gradient-to-b from-sky-100 via-emerald-50 via-white via-emerald-50 to-emerald-100"> -->
        <main class="w-screen h-screen bg-sky-50">

        <!-- // URL SHORTENING FORM SECTION // -->
        <section class="py-16 flex justify-center text-center">
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

                <!-- Display Shorten URL if successful -->
                <!-- <div v-if="successfulMessage" class="text-green-500 m-2 p-2">
                    {{ successfulMessage }}
                </div> -->
            </form>
        </section>

        <!-- Display validation errors  -->
        <span v-if="errorMessage" class="text-red-400 m-2 p-2">
            {{ errorMessage }}
        </span>


           <!-- Display existing short URLs -->
           <div v-if="lastShortUrl" class="mt-4 text-center" >
            <h3 class="font-semibold mb-2 text-cyan-700 mb-8  md:text-3xl">Your Shortened URL:</h3>
            <a class="m-2 px-8 py-4 rounded border border-slate-800 bg-white text-gray-900 font-bold hover:text-sky-600" :href="lastShortUrl.original_url" target="_blank" rel="noopener noreferrer">
                {{ lastShortUrl.short_url }}
            </a>
        </div>

         <!-- Display existing short URLs -->
         <div v-if="fullShortenedUrl" class="mt-10 text-center">
            <h3 class="font-semibold mb-2 text-cyan-700 mb-8  md:text-3xl">Your Shortened URL:</h3>
            <a class=" px-8 py-4 rounded border border-slate-800 bg-white text-gray-900 font-bold hover:text-sky-600" :href="fullShortenedUrl" target="_blank" rel="noopener noreferrer">
                {{ fullShortenedUrl }} 
            </a>
            </div>

        </main>
    </AuthenticatedLayout>
</template>

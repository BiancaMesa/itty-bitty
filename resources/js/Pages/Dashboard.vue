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
        onSuccess: () => {
            form.reset();  // Reset form after successful submission if needed //REMOVE ???
            errorMessage.value = ''; // Clear any previous error message
        },
        // Handling potential errors
        onError: (errors) => {
            if (errors.original_url) {
                errorMessage.value = 'Please, introduce a valid URL';
            } else {
                errorMessage.value = 'An unexpected error occurred. Please try again.';
            }
        }
    });
};

// We use the usePage to get the shortenedUrl and successMessage (props) from backend. 
const { props } = usePage();
const shortUrls = props.shortUrls || [];
const shortenedUrl = props.shortenedUrl || '';
const successMessage = props.successMessage || '';

// const shortUrls = props.value.shortUrls || [];
// const shortenedUrl = props.value.shortenedUrl || '';
// const successMessage = props.value.successMessage || '';

// Find the last (most recent) short URL
const lastShortUrl = shortUrls.length ? shortUrls[shortUrls.length - 1] : null;

//Reactive properties
const successfulMessage = ref(successMessage);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>
        
        <!-- // URL SHORTENING FORM SECTION // -->
        <section class="py-12 flex justify-center">
            <form class="flex flex-col" @submit.prevent="submitForm">
                <label class="text-2xl text-sky-700" for="original_url">Enter Long URL:</label>

                <input 
                    class="border border-gray-300 rounded-lg" 
                    type="url" 
                    v-model="form.original_url" 
                    name="original_url" 
                    id="original_url" 
                    required
                >

                <!-- Display validation errors  -->
                <span v-if="errorMessage" class="text-red-400 m-2 p-2">
                    {{ errorMessage }}
                </span>

                <button class="m-2 px-6 py-2 bg-sky-200 hover:bg-sky-300 rounded-lg" type="submit">Submit</button>

                <!-- Display Shorten URL if successful -->
                <div v-if="successfulMessage" class="text-green-500 m-2 p-2">
                    {{ successfulMessage }}
                </div>
            </form>
        </section>


        <!-- // DISPLAY SHORTENED URL if there is one // -->
        <!-- <div v-if="shortenedUrl" class="mt-4 text-center">
            <h2 class="text-black-800">Shortened URL: 
                <a :href="shortenedUrl" class="text-indigo-600" target="_blank" rel="noopener noreferrer">
                    {{ shortenedUrl }}
                </a>
            </h2>
        </div> -->

        <!-- Display ALL existing short URLs -->
        <!-- <div v-if="shortUrls.length" class="mt-4 text-center">
            <h3 class="text-lg font-semibold">Your Shortened URLs:</h3>
            <ul>
                <li v-for="url in shortUrls" :key="url.id">
                    <a :href="url.original_url" target="_blank" rel="noopener noreferrer"> -->
                        <!-- {{ url.short_url }} (Original: {{ url.original_url }}) -->
                        <!-- {{ url.short_url }}
                    </a>
                </li>
            </ul>
        </div> -->

           <!-- Display existing short URLs -->
           <div v-if="lastShortUrl" class="mt-4 text-center">
            <h3 class="text-lg font-semibold">Your Last Shortened URL:</h3>
            <a :href="lastShortUrl.original_url" target="_blank" rel="noopener noreferrer">
                {{ lastShortUrl.short_url }}
            </a>
        </div>

    </AuthenticatedLayout>
</template>

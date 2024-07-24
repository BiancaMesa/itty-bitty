<script setup>
import { ref } from 'vue'; //needed for reactive variables
import { useForm, usePage } from '@inertiajs/vue3';

// Initialize form data 
const form = useForm({
    title: '', 
    original_url: '',
});

// Initialize the variable to display error message
const errorMessage = ref('');


// We use the usePage to get the props from backend 
const { props } = usePage();
const initialFullShortenedUrl = props.latestFullShortenedUrl || '';

//Set the initial value of fullShortenedUrl
const fullShortenedUrl = ref(initialFullShortenedUrl);

// Function to submit form ---> POST 
const submitForm = async () => {
    // URL format validation 
    // Before submitting the form, We check the input follows the regex pattern we defined 
    const urlPattern = new RegExp(/^(https?:\/\/(www\.)?|www\.)/);

    if (!urlPattern.test(form.original_url)) {
        errorMessage.value = 'The URL must start with "https://www.", "http://www.", "www.", "https://", or "http://".';
        return;
    }

    try {
        // Post the form data to the server
        const response = await form.post(route('short.url'), {
            preserveState: true, // Preserve state during the request
        });

        // Check for successful response
        if (response.data?.shortenedUrl) {
            // Update local state with the new URL
            fullShortenedUrl.value = response.data.shortenedUrl;
            // form.reset();
            errorMessage.value = '';
        } else {
            throw new Error('Unexpected response structure');
        }
    } catch (error) {
        errorMessage.value = error.response?.data?.original_url || 'An unexpected error occurred. Please try again.';
    }
};


// Function to copy the shortened URL to clipboard
const copyToClipboard = () => {
    if (fullShortenedUrl.value) {
        navigator.clipboard.writeText(fullShortenedUrl.value)
    }
};
</script>

<template >
        <section class="w-screen h-screen bg-sky-50">

            <!-- // URL Shortening form // -->
            <div class="py-16 flex flex-col justify-center text-center">
                <h1 class="text-sky-800 mb-4 font-extrabold  md:text-3xl" for="original_url">Enter Your Long URL:</h1>
                <form class="flex flex-col self-center" @submit.prevent="submitForm">
                    <input 
                        class="border border-gray-300 rounded-lg w-full sm:w-96 mt-2" 
                        type="text" 
                        v-model="form.title" 
                        name="title" 
                        id="title" 
                        placeholder="Title"
                        required
                    >

                    <input 
                        class="border border-gray-300 rounded-lg w-full sm:w-96 mt-2" 
                        type="url" 
                        v-model="form.original_url" 
                        name="original_url" 
                        id="original_url" 
                        placeholder="Original URL"
                        required
                    >

                    <button class="m-2 px-6 py-2 bg-sky-200 font-bold  text-gray-700 hover:bg-sky-300 hover:text-gray-800 rounded-lg" type="submit">Submit</button>
                </form>

                <p class="text-gray-400 py-2">Refresh the page to get the shortened URL.</p>
            </div>

            <!-- Display error message -->
            <span v-if="errorMessage" class="text-red-400 m-2 p-2 text-center self-center">
                {{ errorMessage }}
            </span>

            <!-- Display latest shortened URL -->
            <div class="mt-10 text-center">
                <h3 class="font-semibold mb-2 text-cyan-700 mb-8 md:text-3xl">Your Shortened URL:</h3>
                <a 
                    class="px-12 py-4 rounded border border-slate-800 bg-white text-gray-900 font-bold sm:w-96 mt-2 hover:text-sky-600" 
                    :href="fullShortenedUrl"
                    target="_blank" 
                    rel="noopener noreferrer">
                        {{ fullShortenedUrl }}
                </a>
            </div>
            <div class="text-center mt-7">
                <button class="m-2 px-6 py-2 bg-emerald-200 font-bold text-gray-700 hover:bg-emerald-300 hover:text-gray-800 rounded-lg" @click="copyToClipboard">
                    Copy to Clipboard
                </button>
            </div>
        </section>
</template>

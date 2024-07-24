<script setup>
//import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, watch, onMounted } from 'vue'; //needed for reactive variables
import { useForm, usePage } from '@inertiajs/vue3';


// Initialize form data 
const form = useForm({
    title: '', 
    original_url: '',
});

// Initialize the variable to display error message
const errorMessage = ref('');
// Initialize the reactive variable for the shortened URL
const fullShortenedUrl = ref('');

// We use the usePage to get the props from backend 
const { props } = usePage();
const initialFullShortenedUrl = props.latestFullShortenedUrl || '';
//const initialFullShortenedUrl = props.existingFullShortenedUrl || '';
//Set the initial value of fullShortenedUrl
fullShortenedUrl.value = initialFullShortenedUrl;

// Function to submit form ---> POST 
const submitForm = () => {
    // URL format validation 
    // Before submitting the form, We check the input follows the regex pattern we defined 
    const urlPattern = new RegExp(/^(https?:\/\/(www\.)?|www\.)/);

    if (!urlPattern.test(form.original_url)) {
        errorMessage.value = 'The URL must start with "https://www.", "http://www.", "www.", "https://", or "http://".';
        return;
    }

    form.post(route('short.url'), {
        onSuccess: (data) => {
            // Update the reactive properties with the new URL
            fullShortenedUrl.value = data.shortenedUrl || initialFullShortenedUrl; // Adjust according to backend response
            form.reset();
            errorMessage.value = '';
        },
        //Handling potential errors
        onError: (errors) => {
            errorMessage.value = errors.original_url ? errors.original_url : 'An unexpected error occurred. Please try again.';
        }
    });
};

// Reset input field on component mount
// onMounted(() => {
//     fullShortenedUrl;
// });

// // Watch the input field and clear the shortened URL when the input changes 
// watch(() => form.original_url, (newValue) => {
//     if (newValue.trim() === '') {
//         fullShortenedUrl.value = '';
//     }
// });





// Function to copy the shortened URL to clipboard
const copyToClipboard = () => {
    if (fullShortenedUrl.value) {
        navigator.clipboard.writeText(fullShortenedUrl.value)
            // .then(() => {
            //     alert('Shortened URL copied to clipboard!');
            // })
            // .catch(() => {
            //     alert('Failed to copy URL. Please try again.');
            // });
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
                    <!-- <label class="text-sky-800 mb-4 font-extrabold  md:text-3xl" for="original_url">Enter Your Long URL:</label> -->

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
            </div>

            <!-- Display error message -->
            <span v-if="errorMessage" class="text-red-400 m-2 p-2 text-center self-center">
                {{ errorMessage }}
            </span>

            <!-- Display latest shortened URL -->
            <!-- <div v-if="fullShortenedUrl" class="mt-10 text-center">
                <h3 class="font-semibold mb-2 text-cyan-700 mb-8 md:text-3xl">Your Full Shortened URL:</h3>
                <a class="px-8 py-4 rounded border border-slate-800 bg-white text-gray-900 font-bold hover:text-sky-600" :href="fullShortenedUrl" target="_blank" rel="noopener noreferrer">
                    {{ fullShortenedUrl }}
                </a>
            </div> -->

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

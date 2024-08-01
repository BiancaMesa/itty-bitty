<script setup>
import { ref } from 'vue'; 
import { useForm } from '@inertiajs/vue3';
import { useUrlStore } from '@/stores/urlStore';
//import Navigation from '@/Components/Navigation.vue';

const form = useForm({
    title: '', 
    original_url: '',
});

const errorMessage = ref('');

const urlStore = useUrlStore();

// Function to submit form (POST)
const submitForm = async () => {
    const urlPattern = new RegExp(/^(https?:\/\/(www\.)?|www\.)/);

    if (!urlPattern.test(form.original_url)) {
        errorMessage.value = 'The URL must start with "https://www.", "http://www.", "www.", "https://", or "http://".';
        return;
    }

    // The Inertia form is submitted,
    // it sends a request to the server, 
    // which then responds with a "page" object 
    // containing the new component props, including any updates to the data. 
    // To access the props in data, we use data.props. 
    form.post(route('short.url'), {
        preserveState: true, // Preserve state during the request
        onSuccess: (page) => {
            //fullShortenedUrl.value = page.props?.shortenedUrl;
            // The new short Url is found within the page object, in the prop property, in its property shortenedUrl. 
            const newUrl = page.props.shortenedUrl;

            // We pass this newUrl as an argument to this function to add the newUrl in the database. 
            urlStore.addShortUrl(newUrl);
            urlStore.setLatestFullShortenedUrl(newUrl);
        },
        onError: (error) => {
            errorMessage.value = error.response?.data?.original_url || 'An unexpected error occurred. Please try again.';1
        },
    });
   
};

const copyLink = () => {
    if (urlStore.latestFullShortenedUrl) {
        navigator.clipboard.writeText(urlStore.latestFullShortenedUrl);
    }
};
</script>

<template>
    <!-- <Navigation /> -->
    <section class="w-screen h-screen bg-white flex flex-col items-center py-16 px-4">
        <!-- URL Shortening Form -->
        <div class="text-center w-full max-w-md mx-auto">
            <h1 class="text-sky-800 mb-4 font-extrabold text-3xl lg:text-3xl ">Enter Your Long URL:</h1>
            <form class="flex flex-col gap-4 w-full mx-auto" @submit.prevent="submitForm">
                <input 
                    class="border border-gray-300 rounded-lg w-full p-3 text-sm md:text-base"
                    type="text" 
                    v-model="form.title" 
                    name="title" 
                    id="title" 
                    placeholder="Title"
                    required
                >
                <input 
                    class="border border-gray-300 rounded-lg w-full p-3 text-sm md:text-base"
                    type="url" 
                    v-model="form.original_url" 
                    name="original_url" 
                    id="original_url" 
                    placeholder="Original URL"
                    required
                >
                <button class="px-6 py-2 bg-sky-200 font-bold text-gray-700 hover:bg-sky-300 hover:text-gray-800 rounded-lg text-sm md:text-base" type="submit">Submit</button>
            </form>
        </div>

        <!-- Display error message -->
        <span v-if="errorMessage" class="text-red-400 m-2 p-2 text-center text-sm md:text-base">
            {{ errorMessage }}
        </span>

        <!-- Display latest shortened URL -->
        <div class="text-center w-full max-w-md mx-auto mt-16">
            <h3 class="font-semibold mb-4 text-cyan-700 text-3xl lg:text-3xl">Your Shortened URL:</h3>
            <span class="block px-6 py-3 rounded border border-gray-300 rounded-lg bg-white text-gray-900 font-bold mx-auto w-full overflow-hidden text-ellipsis whitespace-nowrap hover:text-sky-600">
                <a 
                class="bg-white text-gray-900 font-bold mx-auto w-full overflow-hidden text-ellipsis whitespace-nowrap hover:text-sky-600"
                :href="urlStore.latestFullShortenedUrl"
                target="_blank" 
                rel="noopener noreferrer">
                      {{ urlStore.latestFullShortenedUrl }}
                </a>
        </span>
        </div>

        <!-- Copy to Clipboard Button -->
        <div class="text-center mt-6">
            <button class="px-6 py-2 bg-emerald-100 font-bold text-gray-700 hover:bg-emerald-200 hover:text-gray-800 rounded-lg text-sm md:text-base" @click="copyLink">
                Copy Link
            </button>
        </div>
    </section>
</template>

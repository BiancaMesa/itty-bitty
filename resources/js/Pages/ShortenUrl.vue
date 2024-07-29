<script setup>
import { ref } from 'vue'; 
import { useForm, usePage } from '@inertiajs/vue3';

const form = useForm({
    title: '', 
    original_url: '',
});

const errorMessage = ref('');

const { props } = usePage();
const initialFullShortenedUrl = props.latestFullShortenedUrl || '';

const fullShortenedUrl = ref(initialFullShortenedUrl);

// Function to submit form ---> POST 
const submitForm = async () => {
    const urlPattern = new RegExp(/^(https?:\/\/(www\.)?|www\.)/);

    if (!urlPattern.test(form.original_url)) {
        errorMessage.value = 'The URL must start with "https://www.", "http://www.", "www.", "https://", or "http://".';
        return;
    }

    form.post(route('short.url'), {
        preserveState: true, // Preserve state during the request
        // onBefore: () => {
        //         window.confirm('Create?');
        // },
        onSuccess: (page) => {
            console.log(page.props);
            fullShortenedUrl.value = page.props?.shortenedUrl;
        },
        onError: (error) => {
            errorMessage.value = error.response?.data?.original_url || 'An unexpected error occurred. Please try again.';1
        },
    });
};

const copyLink = () => {
    if (fullShortenedUrl.value) {
        navigator.clipboard.writeText(fullShortenedUrl.value)
    }
};
</script>

<template>
    <section class="w-screen h-screen bg-sky-50 flex flex-col items-center py-8 px-4">
        <!-- URL Shortening Form -->
        <div class="text-center w-full max-w-md mx-auto">
            <h1 class="text-sky-800 mb-4 font-extrabold text-2xl lg:text-3xl">Enter Your Long URL:</h1>
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

            <p class="text-gray-400 py-4 text-sm md:text-base">Refresh the page to get the shortened URL.</p>
        </div>

        <!-- Display error message -->
        <span v-if="errorMessage" class="text-red-400 m-2 p-2 text-center text-sm md:text-base">
            {{ errorMessage }}
        </span>

        <!-- Display latest shortened URL -->
        <div class="text-center w-full max-w-md mx-auto mt-10">
            <h3 class="font-semibold mb-4 text-cyan-700 text-2xl lg:text-3xl">Your Shortened URL:</h3>
            <a 
                class="block px-6 py-3 rounded border border-slate-800 bg-white text-gray-900 font-bold mx-auto w-full overflow-hidden text-ellipsis whitespace-nowrap hover:text-sky-600"
                :href="fullShortenedUrl"
                target="_blank" 
                rel="noopener noreferrer">
                    {{ fullShortenedUrl }}
            </a>
        </div>

        <!-- Copy Link Button -->
        <div class="text-center mt-6">
            <button class="px-6 py-2 bg-emerald-100 font-bold text-gray-700 hover:bg-emerald-200 hover:text-gray-800 rounded-lg text-sm md:text-base" @click="copyLink">
                Copy Link
            </button>
        </div>
    </section>
</template>

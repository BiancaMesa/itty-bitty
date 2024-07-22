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

// We use the usePage to get the shortenedUrl and successMessage from backend. 
const { props } = usePage();
const shortenedUrl = props.value.shortenedUrl || '';
const successMessage = props.value.successMessage || '';

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
        <div v-if="shortenedUrl" class="mt-4 text-center">
            <h2 class="text-black-800">Shortened URL: 
                <a :href="shortenedUrl" class="text-indigo-600" target="_blank" rel="noopener noreferrer">
                    {{ shortenedUrl }}
                </a>
            </h2>
        </div>

    </AuthenticatedLayout>
</template>

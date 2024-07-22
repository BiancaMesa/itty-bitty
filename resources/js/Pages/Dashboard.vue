<!-- <script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const form = useForm({
    url: '',
});

const submit = () => {
    form.post('/shorten-url', {
        onSuccess: () => {
            form.reset();
        },
    });
};

const shortenedUrl = usePage().props.value.shortenedUrl;
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label for="original_url" class="block text-sm font-medium text-gray-700">URL to Shorten</label>
                                <input v-model="form.url" id="original_url" type="url" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Shorten URL
                            </button>
                        </form>

                        <div v-if="shortenedUrl" class="mt-4">
                            <p>Shortened URL: <a :href="shortenedUrl" class="text-indigo-600" target="_blank">{{ shortenedUrl }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> -->


<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <!-- <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div> -->
        
        <!-- // NEW - VERIFY VUE CODE// -->
        <section class="py-12 flex justify-center">
            <form class="flex flex-col" @submit.prevent="submitForm" method="POST" action="{{ route('short.url') }}">
                <label class="text-2xl text-sky-700" for="original_url">Enter Long URL:</label>
                <input class="border border-gray-300 rounded-lg" type="url" v-model="original_url" name="original_url" id="original_url">
                <button class="m-2 px-6 py-2 bg-sky-200 hover:bg-sky-300 rounded-lg" type="submit">Submit</button>
            </form>
        </section>

    </AuthenticatedLayout>
</template>

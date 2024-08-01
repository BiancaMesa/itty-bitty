<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { useUrlStore } from '@/stores/urlStore';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const urlStore = useUrlStore();
//const shortUrls = ref(urlStore.shortUrls);

const deleteUrl = async (id) => {
    if (confirm('Are you sure you want to delete this URL?')) {
        try {
            // CSRF token is included in the request headers
            const response = await fetch(route('short.url.delete', { id }), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            });

            if (response.ok) {
                // Remove the deleted URL and update shortUrls array
                urlStore.deleteShortUrl(id);
            } else {
                const errorData = await response.json();
                alert(errorData.message || 'Failed to delete URL');
            }
        } catch (error) {
            alert('An error occurred while trying to delete the URL');
        }
    }
};

const deleteAll = async () => {
    if (confirm('Are you sure you want to delete all URLs?')) {
        try {
            // CSRF token is included in the request headers
            const response = await fetch(route('short.url.delete.all'), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            });

            if (response.ok) {
                // Delete all and update the shortUrls array 
                urlStore.deleteAllShortUrls();
            } else {
                const errorData = await response.json();
                alert(errorData.message || 'Failed to delete URLs');
            }
        } catch (error) {
            alert('An error occurred while trying to delete the URLs');
        }
    }
}

onMounted(async () => {
    await urlStore.fetchShortUrls();
}

)
</script>

<template>
    <Head title="Manage Your URLs" />
    <AuthenticatedLayout>
    <main class="bg-white py-16 px-4 sm:px-6 lg:px-20 min-h-screen flex flex-col">
        <h2 class="text-sky-800 pb-8 font-extrabold text-center text-3xl">Manage Your URLs</h2>
        <div v-if="urlStore.shortUrls.length === 0" class="text-center">
            <p>You have no URLs to manage.</p>
        </div>
        <div v-else>
            <div class="flex justify-center mb-4">
                <button class="border border-gray-300 px-6 py-2 rounded mb-4 font-bold bg-emerald-50 hover:text-red-400 hover:bg-white hover:border-red-200" @click="deleteAll" >Delete All</button>
            </div>
            <ul>
                <li v-for="url in urlStore.shortUrls" :key="url.id" class="mb-4">
                    <div class="flex sm:flex-row items-start sm:items-center justify-between p-4 border border-gray-300 rounded-lg bg-white">
                        <div class="flex-1 w-full sm:w-auto">
                            <p><strong>Name:</strong> 
                                <a 
                                    :href="url.original_url" 
                                    class="text-gray-600 hover:text-blue-400 pl-2 break-all" 
                                    target="_blank" 
                                    rel="noopener noreferrer">
                                        {{ url.title }}
                                </a>
                            </p>
                            <p><strong>Original URL:</strong> 
                                <a 
                                    :href="url.original_url" 
                                    class="text-gray-600 hover:text-blue-400 pl-2 break-all" 
                                    target="_blank" 
                                    rel="noopener noreferrer">
                                        {{ url.original_url }}
                                </a>
                            </p>
                            <p><strong>Shortened URL:</strong> 
                                <a 
                                    :href="url.full_shortened_url"  
                                    class="text-gray-600 hover:text-blue-400 pl-2 break-all" 
                                    target="_blank" 
                                    rel="noopener noreferrer">    
                                        {{ url.full_shortened_url }}
                                </a>
                            </p>
                        </div>
                        <button @click="deleteUrl(url.id)" class="mt-4 sm:mt-0 border border-gray-300 px-6 py-2 rounded mb-4 font-bold bg-emerald-50 hover:text-red-400 hover:bg-white hover:border-red-200">Delete</button>
                    </div>
                </li>
            </ul>
        </div>
    </main>
</AuthenticatedLayout>
</template>

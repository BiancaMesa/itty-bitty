<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const shortUrls = ref(props.shortUrls || []);

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
                // Remove the deleted URL from the list
                shortUrls.value = shortUrls.value.filter(url => url.id !== id);
            } else {
                const errorData = await response.json();
                alert(errorData.message || 'Failed to delete URL');
            }
        } catch (error) {
            alert('An error occurred while trying to delete the URL');
        }
    }
};
</script>

<template>
    <section class="bg-sky-50 py-16 px-4 sm:px-6 lg:px-20 min-h-screen">
        <h2 class="text-sky-800 pb-4 font-extrabold text-center text-3xl">Manage Your URLs</h2>
        <div v-if="shortUrls.length === 0" class="text-center">
            <p>You have no URLs to manage.</p>
        </div>
        <div v-else>
            <ul>
                <li v-for="url in shortUrls" :key="url.id" class="mb-4">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 border border-gray-300 rounded-lg bg-white">
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
                        <button @click="deleteUrl(url.id)" class="mt-4 sm:mt-0 text-red-600 hover:text-red-800">Delete</button>
                    </div>
                </li>
            </ul>
        </div>
    </section>
</template>

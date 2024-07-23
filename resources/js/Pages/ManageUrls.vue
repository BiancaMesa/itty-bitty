<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

// Access short URLs from props
const { props } = usePage();
const shortUrls = ref(props.shortUrls || []);

// Function to delete a URL
const deleteUrl = async (id) => {
    if (confirm('Are you sure you want to delete this URL?')) {
        try {
            // Ensure the CSRF token is included in the request headers
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
    <section class="py-16 p-20 h-screen">
        <h2 class="text-sky-800 mb-4 font-extrabold text-center text-3xl">Manage Your URLs</h2>
        <div v-if="shortUrls.length === 0" class="text-center">
            <p>You have no URLs to manage.</p>
        </div>
        <div v-else>
            <ul>
                <li v-for="url in shortUrls" :key="url.id" class="mb-4">
                    <div class="flex items-center justify-between p-4 border border-gray-300 rounded-lg">
                        <div>
                             <!-- <p><strong>Original URL:</strong> {{ url.original_url }}</p>  -->
                             <p><strong>Shortened URL:</strong> 
                                <a :href="url.full_shortened_url" target="_blank" rel="noopener noreferrer">    
                                    {{ url.full_shortened_url }}
                                </a>
                            </p>
                        </div>
                        <button @click="deleteUrl(url.id)" class="text-red-600 hover:text-red-800">Delete</button>
                    </div>
                </li>
            </ul>
        </div>
    </section>
</template> 

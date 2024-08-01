<!-- <script setup>
import { usePage } from '@inertiajs/vue3'; 
import NavLink from '@/Components/NavLink.vue';

// Get the current URL from the page props
const { url } = usePage().props;

// Function to check if the link is active
const isActive = (path) => url.startsWith(path);
</script>

<template>
    <div class="py-4 bg-sky-50 flex space-x-4">
        <NavLink 
            href="/dashboard" 
            :active="isActive('/dashboard')">
                Shorten URL
        </NavLink>
        <NavLink 
            href="/manage-urls" 
            :active="isActive('/manage-urls')">
                Manage Your URLs
        </NavLink>
        <NavLink 
            href="/analytics" 
            :active="isActive('/analytics')">
                Analytics
        </NavLink>
    </div>
</template> -->

<script setup>
//import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Logo from './ApplicationLogo.vue';

const page = usePage();

const isActive = (path) => {
    return page.url.startsWith(path);
};
</script>

<template>
    <div class="py-4 bg-sky-50 flex space-x-4">
        <Logo />
        <NavLink 
            href="/dashboard" 
            :active="isActive('/dashboard')">
                Shorten URL
        </NavLink>
        <NavLink 
            href="/manage-urls" 
            :active="isActive('/manage-urls')">
                Manage Your URLs
        </NavLink>
        <NavLink 
            href="/analytics" 
            :active="isActive('/analytics')">
                Analytics
        </NavLink>
    </div>
</template>

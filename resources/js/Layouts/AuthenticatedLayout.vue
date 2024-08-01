<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

const page = usePage();

</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">

                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex flex-col items-center justify-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-10 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                                <span class="text-xs font-bold text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">Itty Bitty</span>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Shorten URL
                                </NavLink>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('manage.urls')" :active="route().current('manage.urls')">
                                    Manage Your URLs
                                </NavLink>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('analytics')" :active="route().current('analytics')">
                                    Analytics
                                </NavLink>
                            </div>
                        </div>

                         <!-- Account Settings Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger icon -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400" 
                            >
                                <font-awesome-icon :icon="showingNavigationDropdown ? 'times' : 'bars'" class="h-7 w-7 text-gray-400 " />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Shorten URL
                        </ResponsiveNavLink>
                    </div>
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('manage.urls')" :active="route().current('manage.urls')">
                            Manage Your URLs
                        </ResponsiveNavLink>
                    </div>
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('analytics')" :active="route().current('analytics')">
                            Analytics
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Account Options -->
                    <div class="pt-4 pb-1 border-t border-gray-100">
                        <div class="px-4">
                            <div class="font-bold text-center text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">
                                {{ $page.props.auth.user.name }}'s account:
                            </div>
                            <!-- <div class="font-medium text-center text-sm text-gray-500">{{ $page.props.auth.user.email }}</div> -->
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <!-- <ShortenUrl v-if="currentView === 'shortenUrl'" />
                <ManageUrls v-if="currentView === 'manageUrls'" />
                <Analytics v-if="currentView === 'analytics'" /> -->
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <!-- <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg"
        /> -->
        <div
            class="relative flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-4 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                    </div>
                    <nav v-if="canLogin" class="-mx-3 mt-0 flex flex-1 justify-end pt-3">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="-mt-16 pb-16 flex flex-col justify-center min-h-screen text-center items-center">
                    <!-- <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Welcome to Itty Bitty, Your URL Shortener.</h1> -->

                    <h1 class="mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl">Welcome to <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">Itty Bitty</span>, Your URL Shortener.</h1>

                    <h2 class="text-2xl text-center">Register or log in to shorten your URL.</h2>
                </main>

                <!-- <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer> -->
            </div>
        </div>
    </div>
</template>

import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createPinia } from 'pinia';

// Import Font Awesome
// Import Font Awesome core
import { library } from '@fortawesome/fontawesome-svg-core';
// Import specific icons
import {faBars, faTimes } from '@fortawesome/free-solid-svg-icons';
// Import the FontAwesomeIcon component
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

// Add icons to the library
library.add(faBars, faTimes);

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const pinia = createPinia();
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia)
            .component('font-awesome-icon', FontAwesomeIcon) // Register FontAwesomeIcon component globally
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

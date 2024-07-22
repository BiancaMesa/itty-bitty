import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        //Vue provides a way to handle asset URLs in templates, ensuring that they are correctly resolved and included in the build process. 
        //We call this function to include the Vue plugin in the Vite configuration enabling Vite to handle '.vue' files and process them correctly. By setting base to null and includeAbsolute to false, you have more control over how asset URLs are handled in your templates. This means that local asset URLs are correctly processed and included in the build, while absolute URLs remain untouched
        // vue({
                //This option allows you to configure how asset URLs are transformed within Vue templates.
        //     template: {
                    //This is a specific option within the template configuration that deals with how asset URLs are processed.
        //         transformAssetUrls: {
                        //The base option specifies a base URL to prepend to all asset URLs. Setting it to null means that no base URL will be prepended. This is useful if you want to use URLs as they are specified in the template without modification.
        //             base: null,
                        //The includeAbsolute option determines whether absolute URLs should be processed. Setting this to false means that URLs starting with a scheme (e.g., http://, https://, //) will not be transformed. This allows you to use absolute URLs directly without any interference from Vite’s URL transformation logic.
        //             includeAbsolute: false,
        //         },
        //     },
        // }),
        vue({
            template: {
                transformAssetUrls: true,
            }
        }),
    ],
});

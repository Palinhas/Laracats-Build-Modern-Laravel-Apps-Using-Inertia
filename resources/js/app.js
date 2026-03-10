// import './bootstrap';
import { createApp, h } from 'vue'
import {createInertiaApp, Head, Link} from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import Layout from '@/Components/Layout.vue'
import '../css/app.css'

createInertiaApp({
    resolve: async (name) => {
        const page = await resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        )
        if (page.default.layout === undefined) {
            page.default.layout = Layout
        }

        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('Link', Link)
            .component('Head', Head)
            .mount(el)
    },
    title: (title) => `My App - ${title}`,
     progress: {
         showSpinner: true,
         color: 'red',
     }
});



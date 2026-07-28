import '../css/app.css'
import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import ui from '@nuxt/ui/vue-plugin'
import { Link } from '@inertiajs/vue3';
import {ZiggyVue} from '../../vendor/tightenco/ziggy'

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue')
        return pages[`./Pages/${name}.vue`]()
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ui)
            .use(ZiggyVue)
            .component('Link', Link)
            .mount(el)
    },
    progress: {
        color: '#0f172a',
    },
}).then(r => {
})

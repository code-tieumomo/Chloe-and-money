require("./bootstrap");

import {createApp, h} from "vue";
import {createInertiaApp} from "@inertiajs/inertia-vue3";
import {InertiaProgress} from "@inertiajs/progress";

const appName = window.document.getElementsByTagName("title")[0]?.innerText || "cờ lâu i and money";

createInertiaApp({
    title: (title) => `${title} - cờ lâu i and money`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({el, app, props, plugin}) {
        return createApp({render: () => h(app, props)})
            .use(plugin)
            .mixin({methods: {route}})
            .mount(el);
    },
});

InertiaProgress.init({color: "#4dcfe0"});

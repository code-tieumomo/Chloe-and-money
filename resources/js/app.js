require("./bootstrap");

import {createApp, h} from "vue";
import {createInertiaApp} from "@inertiajs/inertia-vue3";
import {InertiaProgress} from "@inertiajs/progress";
import "flowbite";

const mq = window.matchMedia("(max-width: 768px)");
if (mq.matches) {
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
    }).then(r => console.log(
        `%c ༼ つ ◕_◕ ༽つ %c ✔ App ready %c`,
        "background:#35495e; padding: 1px; border-radius: 3px 0 0 3px; color: #fff; display: inline-block;",
        `background:#41b883; padding: 1px; border-radius: 0 3px 3px 0; color: #fff; display: inline-block;`,
        "background:transparent",
    ));

    InertiaProgress.init({color: "#4dcfe0"});
} else {
    alert("Not support large screen!");
}


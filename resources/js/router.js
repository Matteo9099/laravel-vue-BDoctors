import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Home from "./views/Home";
import SingleProfessional from "./pages/SingleProfessional";
import Search from "./pages/Search";

const router = new VueRouter({
    mode: "history",

    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
        },
        {
            path: "/professionals/:slug",
            name: "single-professional",
            component: SingleProfessional,
        },
        {
            path: "/search/:slug?",
            name: "search",
            component: Search,
        },
        {
            path: "/:pathMatch(.*)*",
            name: "NotFound",
            component: Home,
        },
    ],
});

export default router;

import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Home from "./views/Home";
import SingleDoctor from "./pages/SingleDoctor";
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
            path: "/doctors/:slug",
            name: "single-doctor",
            component: SingleDoctor,
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

import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Index from "./pages";

const router = new VueRouter({
    mode: "history",
    base: '/admin',
    routes: [
        {path: "/", name: "index", component: Index},
        {path: "/index", name: "index", component: Index},
    ]
})

export default router;

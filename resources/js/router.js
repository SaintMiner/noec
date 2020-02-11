import NotFoundComponent from "./components/noecRoot";
import login from "./components/login/login";
import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: '/', 
            component: login,
        },

        {
            path: '/dashboard', 
            component: login,
        },

        { 
            path: '/404', 
            name: '404', 
            component: NotFoundComponent 
        },

        { 
            path: '*', 
            redirect: '/404' 
        },
    ],
    mode: "history",
});
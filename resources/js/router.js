import rootComp from "./components/noecRoot";
import login from "./components/login/login";
import Vue from "vue";
import VueRouter from "vue-router";
import notFound from "./components/404";

/**************************************************/
/****             SystemContent                ****/
/**************************************************/

import personal from "./components/content/personal";
import dashboard from "./components/content/dashboard";


/**************************************************/
/****                 Routes                   ****/
/**************************************************/

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: '/', 
            component: login,
        },

        {
            path: "/system",
            component: rootComp,
            
            children: [
                {
                    path: "personal",
                    name: "personal",
                    components: {
                        content: personal,
                    },
                },
                {
                    path: "dashboard",
                    name: "dashboard",
                    components: {
                        content: dashboard,
                    },
                },
                {
                    path: "*",
                    redirect: "dashboard",
                },
            ],


        },

        { 
            path: '/404', 
            name: '404', 
            component: notFound, 
        },

        { 
            path: '*', 
            redirect: '/404' 
        },
    ],
    mode: "history",
});
import rootComp from "./components/noecRoot";
import login from "./components/login/login";
import Vue from "vue";
import VueRouter from "vue-router";
import notFound from "./components/404";

/**************************************************/
/****             SystemContent                ****/
/**************************************************/

import personal from "./components/content/personal/personal";
import department from "./components/content/department/department";
import dashboard from "./components/content/dashboard";
import enterprise from "./components/content/enterprise/enterprise";
import product from "./components/content/product/product";
import storage from "./components/content/storage/storage";
import shippingOrder from "./components/content/order/shippingOrder";

/**************************************************/
/****                 Routes                   ****/
/**************************************************/

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: '/', 
            component: login,
            name: "login",
        },

        {
            path: "/system",
            component: rootComp,
            name: "system",
            children: [
                {
                    path: "resources",
                    name: "resources",
                    components: {
                        content: personal,
                    },
                },
                {
                    path: "department",
                    name: "department",
                    components: {
                        content: department,
                    }
                },
                {
                    path: "dashboard",
                    name: "dashboard",
                    components: {
                        content: dashboard,
                    },
                },
                {
                    path: "enterprises",
                    name: "enterprises",
                    components: {
                        content: enterprise,
                    },
                },
                {
                    path: "products",
                    name: "products",
                    components: {
                        content: product,
                    }
                },
                {
                    path: "storages",
                    name: "storages",
                    components: {
                        content: storage,
                    }
                },
                {
                    path: "shippingOrder",
                    name: "shippingOrder",
                    components: {
                        content: shippingOrder,
                    }
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
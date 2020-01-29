import Vue from "vue";
import router from "./router.js";
import App from "./components/App"


require('./bootstrap');

Vue.mixin({
    
})

const app = new Vue({
    el: '#app',
    
    router,

    components: {
        App
    },
});
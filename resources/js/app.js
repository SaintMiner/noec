import Vue from "vue";
import router from "./router.js";
import App from "./components/App";
import { library } from '@fortawesome/fontawesome-svg-core';
import { faUser, faKey, faUsers, faTachometerAlt, faSearch } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
require('./bootstrap');

library.add([faUsers, faUser, faKey, faTachometerAlt, faSearch]);
Vue.component('font-awesome-icon', FontAwesomeIcon)    

Vue.mixin({
    
})

const app = new Vue({
    el: '#app',
    
    router,
    components: {
        App
    },
});
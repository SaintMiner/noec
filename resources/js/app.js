import Vue from "vue";
import router from "./router.js";
import store from "./store.js";
import webService from "./webService.js";
import App from "./components/App";
import { library } from '@fortawesome/fontawesome-svg-core';
import {
        faUser, faKey, faUsers, 
        faTachometerAlt, faSearch, faPen,
        faInfo, faUsersCog, faProjectDiagram,
        faUserTag, faSolarPanel, faPlus,
        faWrench, faBoxes, faTrash,
        faEllipsisV
        } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
require('./bootstrap');
library.add([
            faUsers, faUser, faKey, 
            faTachometerAlt, faSearch, faPen,
            faInfo, faUsersCog, faProjectDiagram,
            faUserTag, faSolarPanel, faPlus,
            faWrench, faBoxes, faTrash,
            faEllipsisV
        ]);

Vue.component('font-awesome-icon', FontAwesomeIcon)    


Vue.mixin({
});

Vue.prototype.$webService = webService;
const app = new Vue({
    el: '#app',
    
    router,
    store,
    
    components: {
        App
    },
});
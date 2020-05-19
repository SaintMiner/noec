import Vue from 'vue'
import Vuex from 'vuex'
import webService from "./webService.js";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        hasPermission: false,
    },

    mutations: {
        hasRole: function(state, reqRoles) {
            webService.post("auth/me").then(response => {
                let hasPermission = false;
                response.data.roles.forEach(role => {
                    if(reqRoles.includes(role.slug)) {
                        hasPermission = true;
                    }
                });
                state.hasPermission = hasPermission;
            }).catch(e => {
                console.error(e);
                state.hasPermission = false;
            });
        }
    }
});
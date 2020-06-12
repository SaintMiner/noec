import Vue from 'vue'
import Vuex from 'vuex'
import webService from "./webService.js";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        hasPermission: false,
        roles: [],
    },

    mutations: {
        hasRole: function(state, reqRoles) {
            let hasPermission = false;
            let user_roles = state.roles;
            user_roles.forEach(role => {
                if(reqRoles.includes(role)) {
                    hasPermission = true;
                }
            });
            state.hasPermission = hasPermission;
        },

        getRoles: function(state) {
            webService.post("auth/me").then(response => {
                state.roles = response.data.roles.map(role => role.slug);
            }).catch(e => {
                console.error(e);
            })
        }
    }
});
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        roles: [],
    },

    mutations: {
        addRole(role) {
            state.roles.push(role);
        }
    }
});
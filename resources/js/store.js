import Vuex from "vuex";
import Vue from "vue";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        token: localStorage.getItem("token")
    },

    getters: {
        getToken: function(state) {
            return state.token;
        }
    },
    mutations: {
        setToken(state, token) {
            state.token = token;
        }
    },

    actions: {
        setToken(context, token) {
            context.commit("setToken", token);
        }
    }
});

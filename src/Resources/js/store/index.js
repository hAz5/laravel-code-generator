import Vue from "vue";
import Vuex from "vuex";
import {keyBy}from 'lodash';

Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        themeDark: false,
        authenticated: false,
        user: {},
        ui: {
            snack: false,
            message: '',
            color: ''
        },
        roles: [],
    },
    mutations: {
        setTheme(state) {
            state.themeDark = !state.themeDark
        },
        message(state, message) {
            state.ui.snack = true;
            state.ui.message = message;
            state.ui.color = 'green'
        },
        error(state, message) {
            state.ui.snack = true;
            state.ui.message = message;
            state.ui.color = 'red'
        },
        setAuth(state, user){
            state.user = user;
            state.authenticated = true;
        },
        setData(state, data){
            state.roles = keyBy(data.roles, 'id');
        },
        updateRoles(state, roles){
            state.roles = keyBy(roles, 'id');
        }
    },
    actions: {
        checkToken({state, commit}, callback = undefined) {
            if (!Vue.prototype.getCookie("token")) {
                callback(false);
                return;
            }

            Vue.prototype.getAuth()
                .then((response) => {
                    if (response.data.user !== undefined) {
                        commit('setAuth', response.data.user);
                        callback(true);
                    } else {
                        Vue.prototype.setCookie("token", "", 1);
                        callback(false);
                    }
                })
                .catch((error) => {
                    Vue.prototype.setCookie("token", "", 1);
                    callback(false);
                });
        }
    }
});

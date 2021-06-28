import Vue from "vue";
import Vuetify from "./plugins/vuetify";
import {Model} from "vue-api-query";
import axios from "axios";

import router from "./router.js";
import layout from "./layout";
import store from "./store";

Model.$http = axios;

Vue.config.productionTip = false;

new Vue({
    el: "layout",
    components: { layout },
    store,
    router,
   vuetify: Vuetify
});

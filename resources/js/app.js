require("./bootstrap");

import store from "./store";
import router from "./router";

import AppComponent from "./components/AppComponent.vue";

window.Vue = require("vue");

const app = new Vue({
    el: "#app",
    components: { AppComponent },
    router,
    store
});

require('./bootstrap');

import Vue from "vue";
import VueRouter from "vue-router";
import axios from "axios";
import VueAxios from "vue-axios";

import App from "./components/app.vue";
import router from "./router.js"

Vue.use(VueRouter);
Vue.use(axios,VueAxios);

new Vue({
    render : h => h(App),
    router
}).$mount("#app");
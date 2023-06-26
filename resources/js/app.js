// import 'babel-polyfill'
import axios from 'axios'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import App from './components/App'
import router from './plugins/router'
import vuetify from "./plugins/vuetifyy";

import 'viewerjs/dist/viewer.css'
import Viewer from 'v-viewer'
import wysiwyg from "vue-wysiwyg";
import "vue-wysiwyg/dist/vueWysiwyg.css";
import auth from './plugins/auth'



Vue.use(Viewer)

// Set Vue globally
window.Vue = Vue
// Set Vue router
Vue.router = router
Vue.use(VueRouter)

// Set Vue authentication
Vue.use(VueAxios, axios)
//axios.defaults.baseURL = 'http://127.0.0.1:8000/api'

// Load Index
Vue.component('app', App)
Vue.use(wysiwyg, {}); // config is optional. more below

Vue.use(VueAuth, auth)


const app = new Vue({
    router,
    vuetify,
    el: '#app',
});


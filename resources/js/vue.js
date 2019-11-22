/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import VueRouter from 'vue-router';
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
import SecureLS from "secure-ls";
import Logout from './components/user_components/logout';
import Login from './components/login';
import Register from './components/user_components/register';
import Home from './components/home/home';
import Welcome from './components/welcome';
import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(BootstrapVue)
Vue.config.productionTip = false

const ls = new SecureLS({ isCompression: false });
const store = new Vuex.Store({
    state: {
        store_token: "",
        store_mail: "",
        store_isLogged: false
    },
    plugins: [
      createPersistedState({
        storage: {
          getItem: key => ls.get(key),
          setItem: (key, value) => ls.set(key, value),
          removeItem: key => ls.remove(key)
        }
      })
    ],
    mutations: {
        mut_isLogged: (state, value) => state.store_isLogged = value,
        mut_token: (state, value) => value ? (state.store_token = value) : (state.store_token = ""),
        mut_email: (state, value) => value ? (state.store_mail = value) : (state.store_mail = "")
    }
  });

const routes=[
    {path:'/login',component:Login},
    {path:'/register',component:Register},
    {path:'/welcome',component:Welcome},
    {path:'/logout',component:Logout},
    {path:'/home',component:Home},
    {path:'/',redirect:'/welcome'}
];

const router = new VueRouter({
    routes
})

const app = new Vue({
    el: '#app',
    router,
    data() {
        return {
            store_token: "",
            store_email: "",
            store_isLogged: false
          };
    },
    computed: {
        getToken() {
          return store.state.store_token;
        },
        getEmail() {
          return store.state.store_mail;
        },
        isLogged() {
          return store.state.store_isLogged;
        },
    },
    methods: {
        setToken(token) {
            this.store_token = token;
            store.commit("mut_isLogged", true);
            store.commit("mut_token", token);
            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        },
        setEmail(email) {
            this.store_email = email;
            store.commit("mut_email", email);
        },
        deleteToken() {
            store.commit("mut_isLogged", false);
            store.commit("mut_token", '');
        },
        setAuthorization() {      
            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.state.store_token;   
            //this.store_email = store.state.store_mail;  
        }
    },
    created() {
        this.setAuthorization()
    }
});

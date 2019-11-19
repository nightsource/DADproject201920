/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Login from './components/login';
import Register from './components/user_components/register';
import Welcome from './components/welcome';

const routes=[
    {path:'/login',component:Login},
    {path:'/register',component:Register},
    {path:'/welcome',component:Welcome},
    {path:'/',redirect:'/welcome'}
];

const router = new VueRouter({
    routes
})

const app = new Vue({
    el: '#app',
    router,
    data: {
        usertoken: undefined,
    },
    methods: {
        
    },
    mounted() {

    }
});

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// import Users from './components/users';
// import Departments from './components/departments';
// import Game from './components/game';

const routes=[
    // {path:'/',redirect:'/users'},
    // {path:'/users',component:Users},
    // {path:'/game',component:Game},
    // {path:'/departments',component:Departments}
];

const router = new VueRouter({
    routes
})

const app = new Vue({
    el: '#app',
    router,
    data: {

    },
    methods: {
        
    },
    mounted() {

    }
});

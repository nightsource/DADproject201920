/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import VueRouter from 'vue-router';
import VueCurrencyInput from 'vue-currency-input'
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
import SecureLS from "secure-ls";
import Moment from 'moment';
import Home from './components/home/home';
import Welcome from './components/welcome';
import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import Users from './components/users';
import Profile from './components/user_components/profile';
import NavBar from './components/home/navbar';
import AddMovement from './components/movements/registerMovement';
import Transactions from './components/movements/ListMovements/movements';
import Register from './components/user_components/adminRegister';
import DatePicker from 'vue2-datepicker'
import 'vue2-datepicker/index.css';
import VueSocketIO from 'vue-socket.io';

window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(BootstrapVue)
Vue.use(DatePicker)
Vue.use(Moment)

const pluginOptions = {
    /* see config reference */
    globalOptions: { currency: 'EUR' }
  }
  Vue.use(VueCurrencyInput, pluginOptions)
Vue.config.productionTip = false
Vue.use(new VueSocketIO({
    debug: true,
    connection: 'http://134.209.187.220/:8080'
   }));

const ls = new SecureLS({ isCompression: false });
const store = new Vuex.Store({
    state: {
        store_token: ""
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
        mut_token: (state, value) => value ? (state.store_token = value) : (state.store_token = "")
    }
  });

const routes=[
    //{path:'/login',component:Login},
    //{path:'/register',component:Register},
    {path:'/welcome',component:Welcome},
    {path:'/users',component:Users},
    {path:'/home',component:Home},
    {path:'/profile',component:Profile},
    {path:'/addmovement',component:AddMovement},
    {path:'/transactions',component:Transactions},
    {path:'/register',component:Register},
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
            user: {},
            userWallet: {},
            date:''
          };
    },
    computed: {
        isLogged() {
          return store.state.store_token != "";
        },        
    },
    methods: {
        setToken(token) {
            this.store_token = token;
            store.commit("mut_token", token);
            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

            axios
                .get('/api/user/')
                .then(response => {       
                    this.user_logged = response.data;
                  })
                  .catch((error) => {
                      console.log(error.response.data.msg)
                  });
        },
        deleteToken() {
            store.commit("mut_token", '');
        },
        setAuthorization() {    
            if(store.state.store_token == "") {
                this.$router.push('welcome')
            } else {
              window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.state.store_token;

              this.getLoggedUser()
              this.getLoggedUserWallet()
              
            //   this.$router.push('home')
            }
        },
        getLoggedUser() {
            axios
                .get('/api/user/')
                .then(response => {
                    this.user = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data.msg)
                });
        },
        getLoggedUserWallet() {
            axios
                .get('/api/user/wallet')
                .then(response => {
                    this.userWallet = response.data.data;
                })
                .catch((error) => {
                    console.log(error.response.data.msg)
                });
        },
    },
    components: {
      "nav-bar": NavBar,
    },
    created() {
        this.setAuthorization()
    }
});

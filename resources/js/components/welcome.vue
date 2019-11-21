<style>
  .centered {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  .centerStuff{
    z-index: 2;
    display: flex;
    flex-flow: column;
    justify-content: center;
    position: relative;
  }

  h1 {
      position: relative;
      display: inline-block;
      text-align: center;      
      z-index: 1;
      font-size: 65px;
      color: #333333;
      text-shadow: -1px 1px 3px rgba(0,0,0,0.7);
  }

  .head-link {
    position: relative;
    display: inline-block;
    font-size: 25px;    
    text-decoration: overline;
    color: #333333;
    -webkit-font-smoothing: antialiased;
    text-shadow: -1px 1px 3px rgba(0,0,0,0.7);
  }

  .logo {    
    max-width: 100px;
    height: auto;
    margin: auto;
    padding-bottom: 3em;
  }
</style>


<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="dark">
        <b-navbar-brand class="w-25" :to="'home'">
            <b-img class="w-50" :src="'/media/logo.png'"></b-img>
            </b-navbar-brand>


        <b-collapse id="nav-collapse" is-nav>
          <!-- Right aligned nav items -->
          <b-navbar-nav class="ml-auto">

            <!-- logged -->
            <b-navbar-nav v-if="isLogged">
              <b-nav-item :to="'profile'">Profile</b-nav-item>
              <b-nav-item-dropdown right v-if="!isLogged">
                <template v-slot:button-content>
                  <em>User</em>
                </template>
                <b-dropdown-item :to="'profile'" >Profile</b-dropdown-item>
                <b-dropdown-item :to="'logout'">Sign Out</b-dropdown-item>
              </b-nav-item-dropdown>
            </b-navbar-nav>

            <!-- not logged -->
            <b-navbar-nav v-if="!isLogged">
              <b-nav-item v-on:click.prevent="userWantsToLogin()">Login</b-nav-item>
              <b-nav-item v-on:click.prevent="userWantsToRegister()">Register</b-nav-item>
            </b-navbar-nav>

          </b-navbar-nav>
        </b-collapse>
    </b-navbar>-->
    <!--<nav-bar
      @user_Wants_To_Login="userWantsToLogin"
      @user_Wants_To_Register="userWantsToRegister"></nav-bar>-->

    <div class="centered">    
      <div class="centerStuff" v-if="!user_wants_login && !user_wants_register">
        <img class="logo" :src="'/favicon.ico'" > 
        <h1>Virtual Wallet</h1>
        <a class="head-link"> The only wallet you will ever need </a>   
      </div>       

      <user-login v-if="user_wants_login"></user-login>
      <user-register v-if="user_wants_register"></user-register>
    </div>    
  </div>
</template>

<script>
import LoginComponent from "./login";
import RegisterComponent from "./user_components/register";
import NavbarComponent from "./home/navbar";


export default {
    data: function(){
            return {
              user_wants_login: false,
              user_wants_register: false
            }
        },
    methods: {   
      userWantsToLogin() {        
          this.user_wants_login=true;       
          this.user_wants_register=false; 
      },
      userWantsToRegister() {
          this.user_wants_login=false;       
          this.user_wants_register=true;
      },  
    },
  components: {
    "user-login": LoginComponent,
    "user-register": RegisterComponent,
    "nav-bar": NavbarComponent
  },
}
</script>
<style>

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
                <b-nav-item-dropdown right>
                    <template v-slot:button-content>
                    <em>{{ username }}</em>
                    </template>
                    <b-dropdown-item v-on:click.prevent="user_wants_to_see_profile()">Profile</b-dropdown-item>
                    <b-dropdown-item v-on:click.prevent="user_wants_to_logout()">Sign Out</b-dropdown-item>
                </b-nav-item-dropdown>
                </b-navbar-nav>

            </b-navbar-nav>
            </b-collapse>
        </b-navbar>

    <div class="centered">    
      <div class="centerStuff" v-if="!userWantsToSeeProfile">
        <img class="logo" :src="'/favicon.ico'" > 
        <h1>Virtual Wallet</h1>
        <a class="head-link"> The only wallet you will ever need </a>   
      </div>       

      <user-profile v-if="userWantsToSeeProfile"></user-profile>
    </div>    
  </div>
</template>

<script>
import ProfileComponent from "../user_components/profile";

export default {
    data: function(){
            return {
              isLogged: this.$root.isLogged,              
              username: this.$root.getEmail,
              userWantsToSeeProfile: false
            }
        },
    methods: {    
      user_wants_to_see_profile() {   
          this.userWantsToSeeProfile = !this.userWantsToSeeProfile;
      },   
      user_wants_to_logout() {   
          this.$router.push( 'logout' )   
      }, 
    },
  components: {
    "user-profile": ProfileComponent
  },
}
</script>
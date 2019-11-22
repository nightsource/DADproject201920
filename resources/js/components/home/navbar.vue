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
                <b-dropdown-item v-on:click.prevent="$emit('user_wants_to_see_profile')">My Profile</b-dropdown-item>
                <b-dropdown-item v-on:click.prevent="$emit('user_wants_to_logout')">Sign Out</b-dropdown-item>
              </b-nav-item-dropdown>
            </b-navbar-nav>

            <!-- not logged -->
            <b-navbar-nav v-if="!isLogged">
              <b-nav-item v-on:click.prevent="$emit('user_wants_to_login')">Login</b-nav-item>
              <b-nav-item v-on:click.prevent="$emit('user_wants_to_register')">Register</b-nav-item>
            </b-navbar-nav>

          </b-navbar-nav>
        </b-collapse>
    </b-navbar>   
  </div>
</template>

<script>
export default {
    props:['isLogged','username'],
    data: function(){
            return {
            }
        },
    methods: { 
        cenas() {
            console.log(this.username);
            console.log(this.isLogged);
        },    
    },
    components: {
    },
    mounted() {
        this.cenas()
    }
}
</script>
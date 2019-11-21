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
              <b-nav-item v-on:click.prevent="$emit('user_Wants_To_Login')">Login</b-nav-item>
              <b-nav-item v-on:click.prevent="$emit('user_Wants_To_Register')">Register</b-nav-item>
            </b-navbar-nav>

          </b-navbar-nav>
        </b-collapse>
    </b-navbar>   
  </div>
</template>

<script>
export default {
    data: function(){
            return {
            }
        },
    methods: {         
    },
  components: {
  },
}
</script>
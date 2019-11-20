<template>
    <div>
        <!--<div class="header">
            <img class="logo" :src="'/media/logo.png'" >
        </div>

        <div>
            <b-button>Button</b-button>
            <b-button variant="danger">Button</b-button>
            <b-button variant="success">Button</b-button>
            <b-button variant="outline-primary">Button</b-button>
        </div>-->

    <b-navbar toggleable="lg" type="dark" variant="dark">
    <b-navbar-brand :to="'home'">NavBar</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav>
        <b-nav-item href="#">Link</b-nav-item>
        <b-nav-item href="#" disabled>Disabled</b-nav-item>
      </b-navbar-nav>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <b-nav-item-dropdown right>
          <!-- Using 'button-content' slot -->
          <template v-slot:button-content>
            <em>User</em>
          </template>
          <b-dropdown-item v-if="!isLogged" :to="'profile'">Profile</b-dropdown-item>
          <b-dropdown-item v-if="!isLogged" :to="'logout'">Sign Out</b-dropdown-item>
        </b-nav-item-dropdown>
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
}
</script>

<style scoped>
.logo {
    text-align :center;
    width: 900px;
    }
</style>
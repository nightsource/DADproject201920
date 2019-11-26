@extends('master')

@section('title', 'Virtual Wallet Application')

@section('content')

<nav-bar></nav-bar>


<router-link to="/home">Home</router-link>
<!-- <router-link to="/login">Login</router-link>
<router-link to="/register">Register</router-link> -->
<router-link v-if="isLogged" to="/profile">My Profile</router-link>


<router-view></router-view>


@endsection
@section('pagescript')
<script src="js/vue.js">

</script>
 @stop  

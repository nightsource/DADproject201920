@extends('master')

@section('title', 'Virtual Wallet Application')

@section('content')

<router-link v-if="isLogged" to="/home">Home</router-link>
<router-link v-if="!isLogged" to="/login">Login</router-link>
<router-link v-if="isLogged" to="/logout">Logout</router-link>
<router-link v-if="!isLogged" to="/register">Register</router-link>
<router-view></router-view>

@endsection
@section('pagescript')
<script src="js/vue.js"></script>
 @stop  

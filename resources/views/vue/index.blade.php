@extends('master')

@section('title', 'Virtual Wallet Application')

@section('content')

<router-link to="/home">Home</router-link>
<router-link to="/login">Login</router-link>

<router-view></router-view>


@endsection
@section('pagescript')
<script src="js/vue.js"></script>
 @stop  
<template>
<div style="float:left;">
    <div class="side-nav" id="show-side-navigation1">

        <div class="heading">
            <img :src="'/storage/fotos/' + $root.user.photo">
            <div class="info">
                <h3><a>{{$root.user.name}}</a></h3>
                <p>{{$root.user.email}}</p>
                <router-link to="/profile">My Profile</router-link>
            </div>
        </div>

        <ul class="categories">
            <li class="withoutAfter"><i class="fa fa-home fa-fw"></i>
                <router-link to="/home">Dashboard</router-link>
            </li>

            <li>
                <i class="fa fa-th-list fa-fw"></i>
                <a> <router-link to="/transactions"> Transactions</router-link>
                    <span class="num succ">2 new</span>
                </a>
                <ul class="side-nav-dropdown">
                    <!-- <li><a>List transactions</a></li> -->
                    <li><router-link v-if="$root.user.type==='u'" to="/addmovement">Register Expense</router-link></li>
                    </ul>
            </li>
            <li @click="user_wants_to_logout"><i class="fa fa-sign-out fa-fw"></i><a> Logout</a></li>
            <li v-if="$root.user.type==='a'">Admin only:</li>
            <li v-if="$root.user.type==='a'"><i class="fa fa-users fa-fw"></i>
                <router-link to="/users">Users</router-link>
            </li>
            <li v-if="$root.user.type==='a'"><i class="fa fa-user-plus fa-fw"></i>
                <router-link to="/register">Create User</router-link>
            </li>

            <li v-if="$root.user.type==='o'"></li>
            <p v-if="$root.user.type==='o'">Operator only:</p>
            <li v-if="$root.user.type==='o'"><i class="fa fa fa-users fa-fw"></i>
                <router-link to="/users">Users</router-link>
            </li>
        </ul>

        <img class="bottom" :src="'/media/logo.png'">
    </div>
</div>
</template>

<script>
import ProfileComponent from "../user_components/profile";

export default {
    data: function () {
        return {
            userWantsToSeeProfile: false
        }
    },
    methods: {       
        user_wants_to_see_profile() {
            this.userWantsToSeeProfile = !this.userWantsToSeeProfile;
        },
        user_wants_to_logout() {
            this.$router.push('logout')
        },
    },
    components: {
        "user-profile": ProfileComponent
    }
}
</script>

<style scoped>
.side-nav {
    float: left;
    height: 100%;
    width: 15%;
    background-color: #252636;
    color: #CCC;
    -webkit-transform: translateX(0);
    -moz-transform: translateX(0);
    transform: translateX(0);
    -webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    transition: .3s;
    position: fixed;
    top: 0;
    left: 0;
    overflow: auto;
}

.side-nav .close-aside {
    position: absolute;
    top: 7px;
    right: 7px;
    cursor: pointer;
    color: #EEE;
}

.side-nav .heading {
    background-color: #252636;
    padding: 15px 15px 15px 30px;
    overflow: hidden;
    border-bottom: 1px solid #2a2b3c
}

.side-nav .heading>img {
    border-radius: 50%;
    float: left;
    width: 28%;
}

.side-nav .info {
    float: left;
    width: 69%;
    margin-left: 3%;
}

.side-nav .heading .info>h3 {
    margin: 0 0 5px
}

.side-nav .heading .info>h3>a {
    color: #EEE;
    font-weight: 100;
    margin-top: 4px;
    display: block;
    text-decoration: none;
    font-size: 18px;
}

.side-nav .heading .info>h3>a:hover {
    color: #FFF;
}

.side-nav .heading .info>p {
    color: #BBB;
    font-size: 13px;
}

.side-nav .categories>li {
    padding: 17px 30px 17px 30px;
    overflow: hidden;
    border-bottom: 1px solid rgba(255, 255, 255, 0.02);
    cursor: pointer;
}

.side-nav .categories>li>a {
    color: #AAA;
    text-decoration: none;
}

.side-nav .categories>li>a>.num {
    line-height: 0;
    border-radius: 3px;
    font-size: 14px;
    color: #FFF;
    padding: 0px 5px
}

.dang {
    background-color: #f35959
}

.prim {
    background-color: #0275d8
}

.succ {
    background-color: #5cb85c
}

.side-nav .categories>li>a:hover {
    color: #FFF
}

.side-nav .categories>li>i {
    font-size: 18px;
    margin-right: 5px
}

.side-nav .categories>li>a:after {
    /*content: "\f053";*/
    font-family: fontAwesome;
    font-size: 11px;
    line-height: 1.8;
    float: right;
    color: #AAA;
    -webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    transition: all .3s ease-in-out;
}

.side-nav .categories .opend>a:after {
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    transform: rotate(-90deg);
}

.side-nav .categories .side-nav-dropdown {
    padding-top: 10px;
    padding-left: 30px;
    list-style: none;
}

.side-nav .categories .side-nav-dropdown>li>a {
    color: #AAA;
    text-decoration: none;
    padding: 3px 0;
    display: block;
}

.side-nav .categories .side-nav-dropdown>li>a:hover {
    color: #FFF;
}

.side-nav .categories p {
    margin-left: 30px;
    color: #eeeeee;
    margin-top: 10px;
}

.bottom {
    width: 100%;
    position: absolute;
    bottom: 5px;
    opacity: 0.6;
    padding: 25px;
}

.show-side-nav {
    -webkit-transform: translateX(-290px);
    -moz-transform: translateX(-290px);
    transform: translateX(-290px);
}

@media (max-width: 767px) {
    .side-nav .categories>li {
        padding-top: 12px;
        padding-bottom: 12px;
    }

    .side-nav .search {
        padding: 10px 0 10px 30px
    }
}
</style>

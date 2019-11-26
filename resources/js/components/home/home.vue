<style>
* {
    padding: 0;
    margin: 0;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    outline: none;
}

::-webkit-scrollbar {
    background: transparent;
    width: 5px;
    height: 5px;
}

::-webkit-scrollbar-thumb {
    background-color: #888;
}

::-webkit-scrollbar-thumb:hover {
    background-color: rgba(0, 0, 0, 0.3);
}

body {
    background-color: #2a2b3d
}

#contents {
    position: relative;
    transition: .3s;
    margin-left: 290px;
    background-color: #2a2b3d;
}

.margin {
    margin-left: 0 !important;
}

/* Start side navigation bar  */

.side-nav {
    float: left;
    height: 100%;
    width: 290px;
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
    z-index: 9999999
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

/* End heading */
/* Start search */
.side-nav .search {
    text-align: center;
    padding: 15px 30px;
    margin: 15px 0;
    position: relative;
}

.side-nav .search>input {
    width: 100%;
    background-color: transparent;
    border: none;
    border-bottom: 1px solid #23262d;
    padding: 7px 0 7px;
    color: #DDD
}

.side-nav .search>input~i {
    position: absolute;
    top: 22px;
    right: 40px;
    display: block;
    color: #2b2f3a;
    font-size: 19px;
}

/* End search */

.side-nav .categories>li {
    padding: 17px 40px 17px 30px;
    overflow: hidden;
    border-bottom: 1px solid rgba(255, 255, 255, 0.02);
    cursor: pointer;
}

.side-nav .categories>li>a {
    color: #AAA;
    text-decoration: none;
}

/* Start num: there are three options primary, danger and success like Bootstrap */
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

/* End num */
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

#id100:after {
    content: "\f053";
}

.side-nav .categories .opend>a:after {
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    transform: rotate(-90deg);
}

/* End categories */
/* Start dropdown menu */
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

/* End dropdown menu */

.show-side-nav {
    -webkit-transform: translateX(-290px);
    -moz-transform: translateX(-290px);
    transform: translateX(-290px);
}

/* Start media query */
@media (max-width: 767px) {
    .side-nav .categories>li {
        padding-top: 12px;
        padding-bottom: 12px;
    }

    .side-nav .search {
        padding: 10px 0 10px 30px
    }
}

/* End side navigation bar  */
/* Start welcome */

.welcome {
    color: #CCC;
}

.welcome .content {
    background-color: #313348;
    padding: 15px;
    margin-top: 25px;
}

.welcome h2 {
    font-family: Calibri;
    font-weight: 100;
    margin-top: 0
}

.welcome p {
    color: #999;
}

/* Start statistics */
.statistics {
    margin-top: 25px;
    color: #CCC;
}

.statistics .box {
    background-color: #313348;
    padding: 15px;
    overflow: hidden;
}

.statistics .box>i {
    float: left;
    color: #FFF;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    line-height: 60px;
    font-size: 22px;
}

.statistics .box .info {
    float: left;
    width: auto;
    margin-left: 10px;
}

.statistics .box .info h3 {
    margin: 5px 0 5px;
    display: inline-block;
}

.statistics .box .info p {
    color: #BBB
}

/* End statistics */
/* Start charts */
.charts {
    margin-top: 25px;
    color: #BBB
}

.charts .chart-container {
    background-color: #313348;
    padding: 15px;
}

.charts .chart-container h3 {
    margin: 0 0 10px;
    font-size: 17px;
}

/* Start users */

.admins {
    margin-top: 25px;
}

.admins .box {}

.admins .box>h3 {
    color: #ccc;
    font-family: Calibri;
    font-weight: 300;
    margin-top: 0;
}

.admins .box .admin {
    margin-bottom: 20px;
    overflow: hidden;
    background-color: #313348;
    padding: 10px;
}

.admins .box .admin .img {
    width: 20%;
    margin-right: 5%;
    float: left;
}

.admins .box .admin .img img {
    border-radius: 50%;
}

.admins .box .info {
    width: 75%;
    color: #EEE;
    float: left;
}

.admins .box .info h3 {
    font-size: 19px
}

.admins .box .info p {
    color: #BBB
}

/* End users */
/* Start statis */

.statis {
    color: #EEE;
    margin-top: 15px;
}

.statis .box {
    position: relative;
    padding: 15px;
    overflow: hidden;
    border-radius: 3px;
    margin-bottom: 25px;
}

.statis .box h3:after {
    content: "";
    height: 2px;
    width: 70%;
    margin: auto;
    background-color: rgba(255, 255, 255, 0.12);
    display: block;
    margin-top: 10px;
}

.statis .box i {
    position: absolute;
    height: 70px;
    width: 70px;
    font-size: 22px;
    padding: 15px;
    top: -25px;
    left: -25px;
    background-color: rgba(255, 255, 255, 0.15);
    line-height: 60px;
    text-align: right;
    border-radius: 50%;
}

/*chart*/
.chrt3 {
    padding-bottom: 50px;
}

.chrt3 .chart-container {
    height: 350px;
    padding: 15px;
    margin-top: 25px;
}

.chrt3 .box {
    padding: 15px;
}

.main-color {
    color: #ffc107
}

.warning {
    background-color: #f0ad4e
}

.danger {
    background-color: #d9534f
}

.success {
    background-color: #5cb85c
}

.inf {
    background-color: #5bc0de
}

/* Start bootstrap */
.navbar-right .dropdown-menu {
    right: auto !important;
    left: 0 !important;
}

.navbar-default {
    background-color: #6f6486 !important;
    border: none !important;
    border-radius: 0 !important;
    margin: 0 !important
}

.navbar-default .navbar-nav>li>a {
    color: #EEE !important;
    line-height: 55px !important;
    padding: 0 10px !important;
}

.navbar-default .navbar-brand {
    color: #FFF !important
}

.navbar-default .navbar-nav>li>a:focus,
.navbar-default .navbar-nav>li>a:hover {
    color: #EEE !important
}

.navbar-default .navbar-nav>.open>a,
.navbar-default .navbar-nav>.open>a:focus,
.navbar-default .navbar-nav>.open>a:hover {
    background-color: transparent !important;
    color: #FFF !important
}

.navbar-default .navbar-brand {
    line-height: 55px !important;
    padding: 0 !important
}

.navbar-default .navbar-brand:focus,
.navbar-default .navbar-brand:hover {
    color: #FFF !important
}

.navbar>.container .navbar-brand,
.navbar>.container-fluid .navbar-brand {
    margin: 0 !important
}

@media (max-width: 767px) {
    .navbar>.container-fluid .navbar-brand {
        margin-left: 15px !important;
    }

    .navbar-default .navbar-nav>li>a {
        padding-left: 0 !important;
    }

    .navbar-nav {
        margin: 0 !important;
    }

    .navbar-default .navbar-collapse,
    .navbar-default .navbar-form {
        border: none !important;
    }

}

.navbar-default .navbar-nav>li>a {
    float: left !important;
}

.navbar-default .navbar-nav>li>a>span:not(.caret) {
    background-color: #e74c3c !important;
    border-radius: 50% !important;
    height: 25px !important;
    width: 25px !important;
    padding: 2px !important;
    font-size: 11px !important;
    position: relative !important;
    top: -10px !important;
    right: 5px !important
}

.dropdown-menu>li>a {
    padding-top: 5px !important;
    padding-right: 5px !important;
}

.navbar-default .navbar-nav>li>a>i {
    font-size: 18px !important;
}

/* Start media query */

@media (max-width: 767px) {
    #contents {
        margin: 0 !important
    }

    .statistics .box {
        margin-bottom: 25px !important;
    }

    .navbar-default .navbar-nav .open .dropdown-menu>li>a {
        color: #CCC !important
    }

    .navbar-default .navbar-nav .open .dropdown-menu>li>a:hover {
        color: #FFF !important
    }

    .navbar-default .navbar-toggle {
        border: none !important;
        color: #EEE !important;
        font-size: 18px !important;
    }

    .navbar-default .navbar-toggle:focus,
    .navbar-default .navbar-toggle:hover {
        background-color: transparent !important
    }
}
</style>

<template>
<div>
    <aside class="side-nav" id="show-side-navigation1">

        <div class="heading">
            <img :src="'/storage/fotos/' + user.photo">
            <div class="info">
                <h3><a>{{user.name}}</a></h3>
                <p>{{user.email}}</p>
            </div>
        </div>

        <ul class="categories">
            <li class="withoutAfter"><i class="fa fa-home fa-fw"></i><a> Dashboard</a></li>

            <li>
                <i class="fa fa-th-list fa-fw"></i>
                <a> Transactions
                    <span class="num succ">2 new</span>
                </a>
                <ul class="side-nav-dropdown">
                    <li><a>List transactions</a></li>
                    <li><a>Create transaction</a></li>
                </ul>
            </li>
            <li @click="user_wants_to_logout"><i class="fa fa-sign-out fa-fw"></i><a> Logout</a></li>

            <li v-if="user.type==='a'"></li>
            <p v-if="user.type==='a'">Admin only:</p>
            <li v-if="user.type==='a'"><i class="fa fa fa-users fa-fw"></i><a> Users</a></li>

            <li v-if="user.type==='o'"></li>
            <p v-if="user.type==='o'">Operator only:</p>
            <li v-if="user.type==='o'"><i class="fa fa fa-users fa-fw"></i><a> Users</a></li>
        </ul>

        <img class="bottom" :src="'/media/logo.png'">
    </aside>
    <!--<b-navbar toggleable="lg" type="dark" variant="dark">
        <b-navbar-brand class="w-25" :to="'home'">
            <b-img class="w-50" :src="'/media/logo.png'"></b-img>
        </b-navbar-brand>

        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav class="ml-auto">

                <b-navbar-nav v-if="!isLogged">
                    <b-nav-item-dropdown right>
                        <template v-slot:button-content>
                            <em>{{user.name}}</em>
                        </template>
                        <b-dropdown-item>My Profile</b-dropdown-item>
                        <b-dropdown-item>Sign Out</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>

    <div class="centered">
        <div class="centerStuff" v-if="!userWantsToSeeProfile">
            <img class="logo" :src="'/favicon.ico'">
            <h1>Virtual Wallet</h1>
            <a class="head-link"> The only wallet you will ever need </a>
        </div>

        <user-profile v-if="userWantsToSeeProfile"></user-profile>
    </div>-->
</div>
</template>

<script>
import ProfileComponent from "../user_components/profile";

export default {
    data: function () {
        return {
            is_user_logged: this.$root.isLogged,
            user: {
                active: undefined,
                created_at: undefined,
                email: '',
                email_verified_at: undefined,
                id: 0,
                name: '',
                nif: '',
                photo: '',
                type: '',
                updated_at: undefined
            },
            userWantsToSeeProfile: false
        }
    },
    methods: {
        isUserLogged() {
            if (!this.is_user_logged)
                this.$router.push('welcome')

            this.getLoggedUser()
        },
        getLoggedUser() {
            axios
                .get('/api/user/')
                .then(response => {
                    this.user = response.data;
                    console.log(this.user)
                })
                .catch((error) => {
                    console.log(error.response.data.msg)
                });
        },
        user_wants_to_see_profile() {
            this.userWantsToSeeProfile = !this.userWantsToSeeProfile;
        },
        user_wants_to_logout() {
            this.$router.push('logout')
        },
    },
    components: {
        "user-profile": ProfileComponent
    },
    created() {
        this.isUserLogged();
    }
}
</script>

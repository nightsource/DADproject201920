<template>
    <div class="myProfile">
        <!--<aside class="side-nav" id="show-side-navigation1">
        <div class="heading">
            <img :src="'/storage/fotos/' + user.photo">
            <div class="info">
                <h3><a>{{user.name}}</a></h3>
                <p>{{user.email}}</p>
                <a href="/#/profile">My Profile</a>
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
    </aside>-->
        <div class="headerTitle">
            <span>My Profile</span>
        </div>
        <b-form>
            <b-alert v-if="showSuccess" show variant="success">{{successMessage}}</b-alert>            
            <b-alert v-if="showFailure" show variant="danger">{{failMessage}}</b-alert>

            <b-form-group label="Name:">
                <b-form-input id="input_name" :state="val_username" v-model="user.name" type="text" required placeholder="Enter name"></b-form-input>

                <b-form-invalid-feedback :state="val_username">
                    Your username must be more then 3 characters long and only contain letters and spaces
                </b-form-invalid-feedback>
                <b-form-valid-feedback :state="val_username">

                </b-form-valid-feedback>

                <b-form-group label="Email:">
                <b-form-input id="input_email" :state="val_email" v-model="user.email" type="email" required placeholder="Enter email"></b-form-input>

                <b-form-invalid-feedback :state="val_email">
                    Your email is invalid
                </b-form-invalid-feedback>
                <b-form-valid-feedback :state="val_email">

                </b-form-valid-feedback>
            </b-form-group>
            </b-form-group>

        </b-form>
        <div class="body">
            <div class="form-group">
                <!-- <label for="inputName">Name</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="user.name"
                    name="name"
                    id="inputName"
                    placeholder="Fullname"
                    state="val_username"
                /> -->
            </div>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="user.email"
                    name="email"
                    id="inputEmail"
                    placeholder="Email"
                />
            </div>
            <div class="form-group">
                <label for="inputNIF">NIF</label>
                <input
                    type="number"
                    class="form-control"
                    v-model="user.nif"
                    name="nif"
                    id="inputNIF"
                    placeholder="NIF"
                />
            </div>

            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="saveUser()">Save</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
    return { 
        showSuccess: false,
        showFailure: false,
        successMessage: '',
        failMessage: '',
        user: {
            name: "",
            email: "",
            password: "",
            access_token: ""
        },
    }
    },
    methods: {
        getUser(){
            axios.get("api/user").then(response => {
            console.log('user logged: ',response.data);
            this.user = response.data;
        });
        },
        saveUser: function(){
            if(this.canUpdate()){
                axios.put('api/users/'+this.user.id,this.user)
                .then(response=>{
                    console.log('response to save ',response)
                    this.showSuccess = true;
                    this.successMessage = 'User saved successfully!';
                    Object.assign(this.user, response.data.data);
                });
            }
        },
        canUpdate(){
            return (this.val_username);
        }
    },
    computed: {
        val_username() {
            if (this.user.name == '')
                return false;
            return this.user.name.length > 2 && this.user.name.length < 255;
        },
        val_email() {
            if (this.user.email == '')
                return null;

            let reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
            return reg.test(this.user.email);
        },
        val_password() {
            if (this.user.password == '' || this.user.retyped_password == '')
                return null;

            if (this.user.password.length > 2 && this.user.password === this.user.retyped_password)
                return true;

            return false;
        }
    },
    mounted(){
        this.getUser();
    }
}
</script>

<style scoped>
.headerTitle{
    font-size:25px;
    font-weight:bold;
    text-align:center;
}
</style>
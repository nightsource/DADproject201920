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
        <div class="body">
            <div class="form-group">
                <label for="inputName">Name</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="user.name"
                    name="name"
                    id="inputName"
                    placeholder="Fullname"
                    value
                />
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
                    value
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
                    value
                />
            </div>

            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="saveUser()">Save</a>
                <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
    return { 
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
            this.currentUser=this.user;         
            axios.put('api/users/'+this.currentUser.id,this.currentUser)
                .then(response=>{
                    console.log('response to save ',response)
                    this.showSuccess = true;
                    this.successMessage = 'User Saved';
                    Object.assign(this.currentUser, response.data.data);
                    this.currentUser = null;
                    this.editingUser = false;
                    this.$refs.userListReference.currentUser = null;
                });
        },
        cancelEdit() {
            this.$emit("cancel-edit");
        }
    },
    computed: {
        val_username() {
            console.log('valUserName ',this.user)
            //TO-DO - falta verificação de letras e espaços
            if (this.user.name == '')
                return null;

            return this.user.name.length > 2 && this.user.name.length < 255
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
        },
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
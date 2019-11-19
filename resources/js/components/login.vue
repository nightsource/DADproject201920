<template>
    <div class="jumbotron">
        <h2>Login</h2>
        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input
                type="email" class="form-control" v-model="user.email"
                name="email" id="inputEmail"
                placeholder="Email address"/>
        </div>
        <div class="form-group">
            <label for="inputPassword">Password</label>
            <input
                type="password" class="form-control" v-model="user.password"
                name="password" id="inputPassword"/>
        </div>
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="login()">Login</a>
        </div>
    </div>
</template>

<script type="text/javascript">    
    export default {
        data: function(){
            return { 
                user: {
                    email: "",
                    password: "",
                    access_token: ""
                },
            }
        },
        methods: {
            login() {
                console.log(this.user);
                axios
                    .post("api/login", this.user)
                    .then(response => {
                        this.user.access_token = response.data.access_token;
                        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.user.access_token;
                                                
                        this.$root['usertoken'] = this.user.access_token;
                    });
            }
        },
    }
</script>
<template>
<div>
    <div class="form-group">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control" v-model="user.email" name="email" id="inputEmail" placeholder="Email address" />
    </div>
    <div class="form-group">
        <label for="inputPassword">Password</label>
        <input type="password" class="form-control" v-model="user.password" name="password" id="inputPassword" />
    </div>
</div>
</template>

<script>
    export default {
        data: function () {
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
                        this.$root.setToken(this.user.access_token);
                        this.$root.setEmail(this.user.email);

                        this.$router.push('home')
                    });
            }
        },
    }
</script>

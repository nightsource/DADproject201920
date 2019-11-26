<template>
    <div class="myProfile">
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
                <button>Reset Password</button>
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
                    email: "",
                    password: "",
                    access_token: ""
                },
            }
    },
    methods: {
        getUser(){
            axios.get("api/user").then(response => {
            console.log(response);
            this.user = response.data;
        });
        },
        saveUser() {
            this.$emit("save-user", this.user);
        },
        cancelEdit() {
            this.$emit("cancel-edit");
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
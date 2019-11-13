<template>
    <div class="jumbotron">
      <h2>Register User</h2>
      <div class="form-group">
        <label for="inputName">Name</label>
        <input
          type="text"
          class="form-control"
          v-model="user.name"
          v-validate="'required'"
          name="name"
          id="inputName"
          placeholder="Fullname"
          value
        />
      </div>

      <div class="form-group">
        <label for="inputEmail">Email</label>
        <input
          type="email"
          class="form-control"
          v-model="user.email"
          v-validate="'required'" 
          name="email"
          id="inputEmail"
          placeholder="Email address"
          value
        />
      </div>

        <div class="input-group">
            <div class="input-group-addon">
            Enter Password
            </div>

            <div class="input-fields">
            <input
                type="password"
                class="form-control"
                v-model="user.password"
                v-validate="'required'"
                name="password"
                id="inputPassword"
                placeholder="Password"
                value
            />
            <input
                type="password"
                class="form-control"
                v-validate="'required|confirmed:password'"
                data-vv-as="password"
                name="password_confirmation"
                id="inputPasswordConfirmation"
                placeholder="Re-type Password"
                value
            />            
            </div>
        </div>

      <div class="form-group">
        <label for="inputNif">NIF</label>
        <input
          type="text"
          class="form-control"
          v-model="user.nif"
          name="nif"
          id="inputnif"
          placeholder="NIF"
          value
        />
      </div>

      <input type="file" accept="image/*" @change="uploadImage($event)" id="file-input">

      <div class="form-group">
        <a class="btn btn-primary" v-on:click.prevent="registerUser()">Register</a>
        <a class="btn btn-light" v-on:click.prevent="cancelRegister()">Cancel</a>
      </div>
    </div>
</template>

<script type="text/javascript">    
    export default {
        data: function(){
            return { 
                user: {
                    name:"",
                    email:"",
                    password:"",
                    nif:"",
                    photo:"",
                    type:"u",                    
                },
            }
        },
        methods: {
            registerUser() {
                //this.$emit('register-user', this.user)
                axios
                    .post("api/register/", user)
                    .then(response => {
                    /*this.showSuccess = true;
                    this.successMessage = "User Registeres";
                    // Copies response.data.data properties to this.currentUser
                    // without changing this.currentUser reference
                    Object.assign(this.currentUser, response.data.data);
                    this.currentUser = null;
                    this.editingUser = false;
                    //this.$refs.userListReference.currentUser = null*/
                    });
            },
            cancelRegister() {
                this.$emit('cancel-register')
            },
            uploadImage(event) {

                const URL = 'http://foobar.com/upload'; 

                let data = new FormData();
                data.append('name', 'my-picture');
                data.append('file', event.target.files[0]); 

                let config = {
                    header : {
                        'Content-Type' : 'image/png'
                    }
                }                            
            }
        },
    }
</script>
<template>
    <div class="jumbotron">
      <h2>Register User</h2>
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
          type="email"
          class="form-control"
          v-model="user.email"
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
                name="password"
                id="inputPassword"
                placeholder="Password"
                value
            />
            <input
                type="password"
                class="form-control"
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
      <a class="btn btn-light" v-on:click.prevent="clearImage()">Limpar Imagem</a>

      <div class="form-group">
        <a class="btn btn-primary" v-on:click.prevent="registerUser(user)">Register</a>
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
                    type:"u",                    
                },
                photo:undefined,
            }
        },
        methods: {
            registerUser(user) {
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
    
                let formData = new FormData();
                formData.append('name', user.name);
                formData.append('email', user.email);
                formData.append('password', user.password);
                formData.append('nif', user.nif);
                formData.append('type', user.type);
                formData.append('file', this.photo);
   
                axios.post('/api/register', formData, config)
                .then(function (response) {
                    console.log(response)
                })
                .catch(function (error) {
                    console.log(error)
                });
                
                
                //this.$emit('register-user', this.user)
                //axios
                    //.post("api/register", user)
                    //.then(response => {
                        //console.log(response)/*this.showSuccess = true;
                    //this.successMessage = "User Registeres";
                    // Copies response.data.data properties to this.currentUser
                    // without changing this.currentUser reference
                    //Object.assign(this.currentUser, response.data.data);
                    //this.currentUser = null;
                    //this.editingUser = false;
                    //this.$refs.userListReference.currentUser = null*/
                    //});
            },
            cancelRegister() {
                //this.$emit('cancel-register')
            },
            uploadImage(event) {
                let files = event.target.files

                if(files[0] !== undefined) {                  
                    this.photo = files[0]         
                    console.log(this.photo);         
                } else {
                  this.photo = undefined;
                }
            },
            clearImage() {
              this.photo = undefined;
            }
        },
    }
</script>
<template>
    <div class="jumbotron">
      <h2>Register User</h2>
      <div class="form-group">
        <label for="inputName">Name</label>
        <input
          type="text"
          class="form-control"
          v-model="userRegisting.name"
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
          v-model="userRegisting.email"
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
                v-model="userRegisting.password"
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
          v-model="userRegisting.nif"
          name="nif"
          id="inputnif"
          placeholder="NIF"
          value
        />
      </div>

      <input type="file" accept="image/*" @change="uploadImage($event)" id="file-input">
      <a class="btn btn-light" v-on:click.prevent="clearImage()">Limpar Imagem</a>

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
                userRegisting: {
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
            registerUser() {
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
    
                let formData = new FormData();
                formData.append('name', this.userRegisting.name);
                formData.append('email', this.userRegisting.email);
                formData.append('password', this.userRegisting.password);
                formData.append('nif', this.userRegisting.nif);
                formData.append('type', this.userRegisting.type);
                formData.append('file', this.photo); 

                axios.post('/api/register', formData, config)
                .then(function (response) {
                    console.log("response register")
                    console.log(response)                   
                }) 
                .then(axios.post("api/login", this.userRegisting)
                    .then(response => {
                        console.log("response login")
                        console.log(response)
                        console.log(this.userRegisting);
                        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' +  response.data.access_token;
                        
                        this.$root.isLogged = true;         
                        this.$root.usertoken =  response.data.access_token;
                        this.$router.push( 'home' )
                    }))              
                .catch(function (error) {
                    console.log(error)
                });                
            },
            cancelRegister() {
                this.$router.push( 'welcome' )
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
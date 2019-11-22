<template>
    <div class="jumbotron">
      <h2>Register User</h2>
      <div class="form-group">
        <label for="inputName">Name</label>
        <input
          type="text"
          class="form-control"
          v-model="user_registering.name"
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
          v-model="user_registering.email"
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
                v-model="user_registering.password"
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
          v-model="user_registering.nif"
          name="nif"
          id="inputnif"
          placeholder="NIF"
          value
        />
      </div>

      <input type="file" accept="image/*" @change="uploadImage($event)" id="file-input">
      <a class="btn btn-light" v-on:click.prevent="clearImage()">Limpar Imagem</a>
    </div>
</template>

<script type="text/javascript">    
    export default {        
        props:['user_registering', 'photo'],
        data: function(){
            return { 
            }
        },
        methods: {            
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
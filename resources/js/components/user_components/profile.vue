<template>
  <div class="myProfile">
    
    <b-form>
      <b-alert v-if="showSuccess" show='3' variant="success">{{successMessage}}</b-alert>
      <b-alert v-if="showFailure" show='5' variant="danger">{{failMessage}}</b-alert>
	  
	  <div class="headerTitle">
      <span>My Profile</span>
    	</div>
      <b-form-group label="Name:">
        <b-form-input
          id="input_name"
          :state="val_username"
          v-model="user.name"
          type="text"
          required
          placeholder="Enter name"
        ></b-form-input>

        <b-form-invalid-feedback
          :state="val_username"
        >Your username must be more then 3 characters long and only contain letters and spaces</b-form-invalid-feedback>
        <b-form-valid-feedback :state="val_username"></b-form-valid-feedback>
      </b-form-group>
      <b-form-group label="Email:">
        <b-form-input
          id="input_email"
          :state="val_email"
          v-model="user.email"
          type="email"
          required
          placeholder="Enter email"
        ></b-form-input>

        <b-form-invalid-feedback :state="val_email">Your email is invalid</b-form-invalid-feedback>
        <b-form-valid-feedback :state="val_email"></b-form-valid-feedback>
      </b-form-group>
      <b-form-group label="Identification Number (NIF):" class="nifInput">
        <b-form-input id="input-nif" v-model="user.nif" placeholder="Enter NIF"></b-form-input>
      </b-form-group>

      <b-form inline>
        <b-form-group label="Your Password:" style="width: 49%;">
          <label class="sr-only" for="inline-form-input-password-1">Name</label>
          <b-input
            id="inline-form-input-password-1"
            :state="val_password"
            v-model="password"
            type="password"
            class="mb-2 mr-sm-2 mb-sm-0"
            style="width: 100%;"
          ></b-input>
        </b-form-group>
        <b-form-group label="Retype your Password:" style="width: 49%;margin-left: 2%;">
          <label class="sr-only" for="inline-form-input-password-2">Username</label>
          <b-input
            id="inline-form-input-password-2"
            :state="val_password"
            v-model="retyped_password"
            type="password"
            style="width: 100%;"
          ></b-input>
        </b-form-group>

        <b-form-invalid-feedback
          :state="val_password"
        >Your passwords don't match or have less then 3 characters long</b-form-invalid-feedback>
        <b-form-valid-feedback :state="val_password"></b-form-valid-feedback>
      </b-form>
      <b-form-text id="password-help-block">Your password must be more then 3 characters long</b-form-text>
      <b-button variant="outline-primary" v-on:click.prevent="saveUser()">Save</b-button>
    </b-form>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      password: "",
      retyped_password: "",
      showSuccess: false,
      showFailure: false,
      successMessage: "",
      failMessage: "",
      user: {
        name: "",
        email: "",
        password: "",
        access_token: ""
      }
    };
  },
  methods: {
    getUser() {
      axios.get("api/user").then(response => {
        console.log("user logged: ", response.data);
        this.user = response.data;
      });
    },
    saveUser: function() {
      if (this.canUpdate()) {
		  //TODO passar a pass para dentro do user
        axios.put("api/users/" + this.user.id, this.user).then(response => {
          console.log("response to save ", response);
          this.showSuccess = true;
          this.successMessage = "User saved successfully!";
          Object.assign(this.user, response.data.data);
        });
      }
    },
    canUpdate() {
      return this.val_username;
    }
  },
  computed: {
    val_username() {
      if (this.user.name == "") return false;
      return this.user.name.length > 2 && this.user.name.length < 255;
    },
    val_email() {
      if (this.user.email == "") return null;

      let reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/;
      return reg.test(this.user.email);
    },
    val_password() {
      if (this.password == "" || this.retyped_password == "")
        return null;

      if (
        this.password.length > 2 &&
        this.password === this.retyped_password
      )
        return true;

      return false;
    }
  },
  mounted() {
    this.getUser();
  }
};
</script>

<style scoped>
.headerTitle {
  font-size: 25px;
  font-weight: bold;
  text-align: center;
}

.smallInput {
  width: 49%;
}
</style>
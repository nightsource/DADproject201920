<template>
<div>
    <b-form>
        <b-alert v-if="user_register.response != ''" show variant="danger">{{user_register.response}}</b-alert>

        <b-form-group label="Name:">
            <b-form-input id="input_name" :state="val_username" v-model="user_register.name" type="text" required placeholder="Enter name"></b-form-input>

            <b-form-invalid-feedback :state="val_username">
                Your username must be more then 3 characters long and only contain letters and spaces
            </b-form-invalid-feedback>
            <b-form-valid-feedback :state="val_username">

            </b-form-valid-feedback>
        </b-form-group>

        <b-form-group label="Email:">
            <b-form-input id="input_email" :state="val_email" v-model="user_register.email" type="email" required placeholder="Enter email"></b-form-input>

            <b-form-invalid-feedback :state="val_email">
                Your email is invalid
            </b-form-invalid-feedback>
            <b-form-valid-feedback :state="val_email">

            </b-form-valid-feedback>
        </b-form-group>

        <b-form inline>
            <b-form-group label="Your Password:" style="width: 49%;">
                <label class="sr-only" for="inline-form-input-password-1">Name</label>
                <b-input id="inline-form-input-password-1" :state="val_password" v-model="user_register.password" type="password" class="mb-2 mr-sm-2 mb-sm-0" style="width: 100%;"></b-input>
            </b-form-group>
            <b-form-group label="Retype your Password:" style="width: 49%;margin-left: 2%;">
                <label class="sr-only" for="inline-form-input-password-2">Username</label>
                <b-input id="inline-form-input-password-2" :state="val_password" v-model="user_register.retyped_password" type="password" style="width: 100%;"></b-input>
            </b-form-group>

            <b-form-invalid-feedback :state="val_password">
                Your passwords don't match or have less then 3 characters long
            </b-form-invalid-feedback>
            <b-form-valid-feedback :state="val_password">

            </b-form-valid-feedback>
        </b-form>
        <b-form-text id="password-help-block">
            Your password must be more then 3 characters long
        </b-form-text>

        <b-form-group label="Identification Number (NIF):" style="width: 49%;">
            <b-form-input id="input-nif" v-model="user_register.nif" placeholder="Enter NIF"></b-form-input>
        </b-form-group>

        <b-form-group label="User image:">
            <b-form-file accept=".jpg, .png, .gif" v-model="user_register.photo" placeholder="Choose a file or drop it here..." drop-placeholder="Drop file here..."></b-form-file>
        </b-form-group>
    </b-form>
</div>
</template>

<script>
export default {
    props: ['user_register'],
    data: function () {
        return {}
    },
    methods: {
        canRegister() {
            return (this.val_username && this.val_email && this.val_password == null) ? false : this.val_username && this.val_email && this.val_password
        }
    },
    computed: {
        val_username() {
            if (this.user_register.name == '')
                return null;

            let reg = /^[a-zA-Z\s]*$/
            if (reg.test(this.user_register - name) == false)
                return false;

            return this.user_register.name.length > 2 && this.user_register.name.length < 255
        },
        val_email() {
            if (this.user_register.email == '')
                return null;

            let reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
            return reg.test(this.user_register.email);
        },
        val_password() {
            if (this.user_register.password == '' || this.user_register.retyped_password == '')
                return null;

            if (this.user_register.password.length > 2 && this.user_register.password === this.user_register.retyped_password)
                return true;

            return false;
        },
    }
}
</script>
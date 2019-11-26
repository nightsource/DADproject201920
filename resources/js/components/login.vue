<template>
    <div>
        <b-form>
            <b-alert v-if="user_login.response != ''" show variant="danger">{{user_login.response}}</b-alert>            

            <b-form-group label="Email address:">
                <b-form-input id="input_email" v-model="user_login.email" type="email" required placeholder="Enter email"></b-form-input>
            </b-form-group>

            <b-form-group label="Your Password:">
                <b-form-input id="input-password" v-model="user_login.password" type="password" required placeholder="Enter password"></b-form-input>
            </b-form-group>            
        </b-form>

    </div>
</template>

<script>
export default {
    props: ['user_login'],
    data: function () {
        return {
        }
    },
    methods: {        
    },
}
</script>

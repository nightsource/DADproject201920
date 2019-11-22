<style>
.centered {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -webkit-animation: fadein 2s;
    /* Safari, Chrome and Opera > 12.1 */
    -moz-animation: fadein 2s;
    /* Firefox < 16 */
    -ms-animation: fadein 2s;
    /* Internet Explorer */
    -o-animation: fadein 2s;
    /* Opera < 12.1 */
    animation: fadein 2s;
}

a {
    margin: auto;
    font-size: 15px;
}

h1 {
    position: relative;
    display: inline-block;
    text-align: center;
    z-index: 1;
    font-size: 65px;
    color: #333333;
    text-shadow: -1px 1px 3px rgba(0, 0, 0, 0.7);
}

.head-moto {
    position: relative;
    display: inline-block;
    font-size: 25px;
    text-decoration: overline;
    color: #333333;
    -webkit-font-smoothing: antialiased;
    text-shadow: -1px 1px 3px rgba(0, 0, 0, 0.7);
}

.head-link {
    position: relative;
    display: inline-block;
    margin: 1em 15px 0 15px;
    font-size: 35px;
    color: #333333;
    -webkit-font-smoothing: antialiased;
    text-align: center;
}

.logo {
    max-width: 25vw;
    height: auto;
    margin: auto;
    padding-bottom: 3em;
}

@keyframes fadein {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

/* Firefox < 16 */
@-moz-keyframes fadein {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

/* Safari, Chrome and Opera > 12.1 */
@-webkit-keyframes fadein {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

/* Internet Explorer */
@-ms-keyframes fadein {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

/* Opera < 12.1 */
@-o-keyframes fadein {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}
</style>

<template>
<div>
    <div class="centered">
        <b-container>
            <b-row class="text-center">
                <b-col><img class="logo" :src="'/media/logo.png'"> </b-col>
            </b-row>
            <b-row class="text-center">
                <b-col>
                    <h1>Virtual Wallet</h1>
                </b-col>
            </b-row>
            <b-row class="text-center">
                <b-col><a class="head-moto"> The only wallet you will ever need </a> </b-col>
            </b-row>

            <b-row class="text-center">
                <b-col><a v-b-modal.modal-login class="head-link">Login</a></b-col>
                <b-col><a v-b-modal.modal-register class="head-link">Register</a> </b-col>

                <b-modal id="modal-login" size="mg" title="Please do login your ass mothefocker" centered cancel-disabled ok-disabled modal-cancel no-stacking>
                    <user-login>
                    </user-login>

                    <template v-slot:modal-footer="{ ok, cancel }">
                        <b-button size="sm" variant="success" @click="register();ok()">Login</b-button>

                        <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
                    </template>

                </b-modal>

                <b-modal id="modal-register" size="mg" title="Please do register your self mothefocker" centered cancel-disabled ok-disabled modal-cancel no-stacking>
                    <user-register 
                    :user_registering=user_registering
                    :user_regestering_photo=user_regestering_photo>
                    </user-register>

                    <template v-slot:modal-footer="{ ok, cancel }">
                        <b-button size="sm" variant="success" @click="registerUser();ok()">Register</b-button>

                        <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
                    </template>

                </b-modal>
            </b-row>
        </b-container>
    </div>
</div>
</template>

<script>
import LoginComponent from "./login";
import RegisterComponent from "./user_components/register";
//import NavbarComponent from "./home/navbar";

export default {
    data: function () {
        return {
            is_user_logged: this.$root.isLogged,
            user_registering: {
                name: "",
                email: "",
                password: "",
                nif: "",
                type: "u",
            },
            user_regestering_photo: undefined
        }
    },
    methods: {
        isUserLogged() {
            if (this.is_user_logged)
                this.$router.push('home')
        },
        registerUser() {
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            let formData = new FormData();
            formData.append('name', this.user_registering.name);
            formData.append('email', this.user_registering.email);
            formData.append('password', this.user_registering.password);
            formData.append('nif', this.user_registering.nif);
            formData.append('type', this.user_registering.type);
            formData.append('file', this.user_regestering_photo);

            axios.post('/api/register', formData, config)
                .then(function (response) {
                    console.log("response register")
                    console.log(response)
                })
                .then(axios.post("api/login", this.user_registering)
                    .then(response => {
                        console.log("response login")
                        console.log(response)
                        console.log(this.user_registering);
                        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.access_token;

                        this.$root.isLogged = true;
                        this.$root.usertoken = response.data.access_token;
                        this.$router.push('home')
                    }))
                .catch(function (error) {
                    console.log(error)
                });
        }
    },
    components: {
        "user-login": LoginComponent,
        "user-register": RegisterComponent
    },
    created() {
        this.isUserLogged();
    }
}
</script>

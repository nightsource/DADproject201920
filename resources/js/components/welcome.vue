<template>
<div>
    <div class="centered">
        <b-container>
            <b-row class="text-center">
                <b-col><img class="logo" :src="'/media/logo.png'"></b-col>
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
                <b-col><a v-b-modal.modal-register class="head-link">Register</a></b-col>

                <b-modal id="modal-login" size="mg" title="" centered cancel-disabled ok-disabled modal-cancel no-stacking>
                    <div style="margin-bottom: 15px">
                        Don't have an account? <b-link v-b-modal.modal-register>Click here</b-link><br>
                    </div>

                    <user-login :user_login=user_login>
                    </user-login>

                    <template v-slot:modal-footer="{ ok, cancel }">
                        <b-button size="sm" variant="success" @click="loginUser()">Login</b-button>

                        <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
                    </template>

                </b-modal>

                <b-modal id="modal-register" size="mg" title="" centered cancel-disabled ok-disabled modal-cancel no-stacking>
                    <div style="margin-bottom: 15px">
                        Already have an account? <b-link v-b-modal.modal-login>Click here</b-link><br>
                    </div>

                    <user-register ref="userRegisterComponent" :user_register=user_register>
                    </user-register>

                    <template v-slot:modal-footer="{ ok, cancel }">
                        <b-button size="sm" variant="success" @click="registerUser()">Register</b-button>

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

export default {
    data: function () {
        return {
            is_user_logged: this.$root.isLogged,
            user_login: {
                email: "",
                password: "",
                access_token: "",
                response: ""
            },
            user_register: {
                name: "",
                email: "",
                password: "",
                retyped_password: "",
                photo: undefined,
                nif: "",
                type: "u",
                response: ""
            }
        }
    },
    methods: {
        isUserLogged() {
            if (this.is_user_logged) {
                this.$router.push('home')
            }
        },
        loginUser() {
            axios
                .post("api/login", this.user_login)
                .then(response => {
                    this.user_login.access_token = response.data.access_token;
                    console.log("this.user_login");
                    console.log(this.user_login);
                    this.$socket.emit('user_enter', this.user_login);
                    this.$root.setToken(this.user_login.access_token);
                    this.$router.push('home')
                })
                .catch((error) => {
                    console.log(error.response.data.msg)
                    console.log(this.user_login.response)

                    this.user_login.response = error.response.data.msg
                });
        },
        registerUser() {
            if (this.$refs.userRegisterComponent.canRegister()) {
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }

                let formData = new FormData();
                formData.append('name', this.user_register.name);
                formData.append('email', this.user_register.email);
                formData.append('password', this.user_register.password);
                formData.append('nif', this.user_register.nif);
                formData.append('type', this.user_register.type);
                formData.append('file', this.user_register.photo);

                axios.post('/api/register', formData, config)
                    .then(response => {
                        this.user_login.email = this.user_register.email;
                        this.user_login.password = this.user_register.password;

                        this.loginUser();
                    })
                    .catch((error) => {
                        const cenas = error.response.data.errors;
                        console.log('cenas',cenas)
                        // console.log(cenas.name[0])
                        let str = '';
                        let value = '';

                        for (value of Object.keys(cenas)) {
                            str = str + "<br>" + cenas[value];
                        }
                        this.user_register.response = str
                    });
            } else {
                this.user_register.response = "Please fill the fields and correct the errors"
            }
        },
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

<style scoped>
.centered {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -webkit-animation: fadein 2s;
    -moz-animation: fadein 2s;
    -ms-animation: fadein 2s;
    -o-animation: fadein 2s;
    animation: fadein 2s;
}

a {
    margin: auto;
    font-size: 15px;
    color: #212121 !important;
}

h1 {
    position: relative;
    display: inline-block;
    text-align: center;
    z-index: 1;
    font-size: 65px;
    color: #212121;
    text-shadow: -1px 1px 3px rgba(33, 33, 33, 0.4);
}

.head-moto {
    position: relative;
    display: inline-block;
    font-size: 25px;
    text-decoration: overline;
    color: #212121;
    -webkit-font-smoothing: antialiased;
    text-shadow: -1px 1px 3px rgba(0, 0, 0, 0.7);
}

.head-link {
    position: relative;
    display: inline-block;
    margin: 1em 15px 0 15px;
    font-size: 35px;
    color: #212121;
    -webkit-font-smoothing: antialiased;
    text-align: center;
    cursor: pointer;
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

@-moz-keyframes fadein {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@-webkit-keyframes fadein {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@-ms-keyframes fadein {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@-o-keyframes fadein {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}
</style>
<template>
    <div class="login-bg">
        <div class="login-block row">
            <div class="left col mb-4 py-5">
                <login-input type="text" icon="user" placeholder="Username" @setValue="getUsername" @login="login" :success="success" :unsuccess="unsuccess"/>
                <login-input type="password" icon="key" placeholder="Password" @setValue="getPassword" @login="login" :success="success" :unsuccess="unsuccess"/>
                <div>
                    <div class="ml-auto loading">
                        <div class="spinner-border spinner-border-sm " 
                            :class="{'text-light': !loading}" 
                            role="status"
                        >
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <hr class="mb-5 mt-3">
                
                <!-- <div class="d-flex justify-content-between">
                    <div>
                        <a href=""><em> Forgot Password? </em> </a>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input">
                        <label class="form-check-label">Remember me</label>
                    </div>
                </div> -->

            </div>
            <button class="right col-4 btn" @click="login">
                <h3 class="text-light"> LOGIN </h3>
            </button>
        </div>
        
    </div>
</template>

<script>
import loginInput from "./elements/login-input";
export default {
    name: "login2",

    data() {
        return {
            access_token: "",
            password: "",
            username: "",
            loading: false,
            success: false,
            unsuccess: false,
        }
    },

    components: {
        "login-input": loginInput,
    },

    methods: {

        getPassword: function(password) {
            this.password = password;
        },

        getUsername: function(username) {
            this.username = username;
        },

        login: function() {
            this.loading = true;
            this.success = false;
            this.unsuccess = false;
            this.$webService.post("auth/login", {username: this.username, password: this.password}).then(response => {
                this.access_token = response.data.access_token;
                this.$webService.defaults.headers.common["Authorization"] = `Bearer ${this.access_token}`;
                localStorage.setItem("token", this.access_token);
                localStorage.setItem("token_expires_in", new Date().getTime()+1*1*10*60*1000);
                this.$router.push("system");
                this.loading = false;
                this.success = true;
                this.$store.commit("getRoles");
            }).catch(e => {
                console.error(e);
                this.loading = false;
                this.unsuccess = true;
            });
        },
    },

    mounted() {
        
    }
}
</script>

<style scoped>

    .login-block {
        /* position: fixed;
        top: 50%;
        left: 50%; */
        /* transform: translate(-50%, -50%); */
        margin-top: 10%;        
        margin-left: auto;
        margin-right: auto;
        width: 640px;
        background-color: white;
        border-radius: 5.5px;
        box-shadow: 32px 27px 43px -14px rgba(0,0,0,0.75);
        overflow: hidden;
        
    }

    .login-block .right {
        font-family: 'Lato', sans-serif;
        background: linear-gradient(to bottom, #2c3437 0%,#000 50%,#000 50%,#232b2e 100%);
        letter-spacing: 5.5px
    }

    .login-bg {
        font-family: 'PT Sans Caption', sans-serif;
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: aliceblue;
    }

    .login-color {
        background-color: #3a3a3a;
        border-color: #3a3a3a;
    }

    .login-forgot-password {
        background-color: #3a3a3a;
    }

    .login-forgot-password a {
        color: white;
    }

    .loading {
        width: fit-content;
    }
</style>
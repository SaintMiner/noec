<template>
    <div class="login-bg">
        <div class="login-block row">
            <div class="left col mb-4 py-5">
                
                <login-input type="text" icon="user" placeholder="Username"/>
                <login-input type="password" icon="key" placeholder="Password"/>

                <hr class="my-5">

                <div class="d-flex justify-content-between">
                    <div>
                        <a href=""><em> Forgot Password? </em> </a>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input">
                        <label class="form-check-label">Remember me</label>
                    </div>
                </div>

            </div>
            
            <button class="right col-4 btn">
                <h3 class="text-light"> LOGIN </h3>
            </button>
        </div>
        
    </div>
</template>

<script>
import loginInput from "./elements/login-input";
export default {
    name: "login2",

    components: {
        "login-input": loginInput,
    },
}
</script>

<style scoped>

    .login-block {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 640px;
        background-color: white;
        border-radius: 5.5px;
        box-shadow: 32px 27px 43px -14px rgba(0,0,0,0.75);
        overflow: hidden;
        
    }

    .login-block .right {
        font-family: 'Lato', sans-serif;
        background: linear-gradient(to bottom, #2c3437 0%,#232b2e 50%,#2c3437 50%,#232b2e 100%);
    }

    .login-bg {
        font-family: 'PT Sans Caption', sans-serif;
        position: absolute;
        width: 100%;
        height: 100%;
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
</style>
<template>
    <div class="login-bg d-flex">
        <div class="login-block p-5">
            <div class="left">
                kek
            </div>
            <div class="right">
                Login
            </div>
        </div>
        
    </div>
</template>

<script>
export default {
    name: "login2",
}
</script>

<style scoped>

    .login-block {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 567px;
        background-color: white;
        /* border-radius: 5.5px; */
        overflow: hidden;
    }

    .login-block .right {
        background-color: black;
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
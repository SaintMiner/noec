<template>
    <div class="login-bg login-color">
        <div class="login-block">
            <div>
                <h3 class="font-weight-bold text-center py-5">Login</h3>
            </div>
            <form class="mx-3 my-2">
                <div class="form-group mb-4">
                    <label>Email address</label>
                    <input type="email" class="form-control">
                </div>

                <div class="form-group mb-5">
                    <label>Password</label>
                    <input type="password" class="form-control">
                </div>
                
                <div class="">
                    <button type="submit" class="font-weight-bold btn btn-primary btn-block login-color">Login</button>
                </div>
            </form>

        </div>
        
    </div>
</template>

<script>
export default {
    name: "login",
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
        border-radius: 5.5px;
        overflow: hidden;
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
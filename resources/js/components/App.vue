<template>
    <router-view/>
</template>

<script>
export default {
    name: "App",
    beforeMount() {
        
        // console.log(this.$router.currentRoute)
        if (localStorage.getItem("token")) {
            this.$webService.defaults.headers.common["Authorization"] = `Bearer ${localStorage.getItem("token")}`;
            if (localStorage.getItem("token_expires_in") && localStorage.getItem("token_expires_in") > new Date().getTime()) {
                if (this.$router.currentRoute.name == "login") {
                    this.$router.push({ name: 'system' });
                }
            } else {
                localStorage.setItem("token", null);
                if (this.$router.currentRoute.name != "login") {
                    this.$router.push({ name: 'login' })
                }
            }
        } else if (this.$router.currentRoute.name != "login") {
            this.$router.push({ name: 'login' })
        }
    }
}
</script>

<style>
    html, body, #app {
        height: 100%;
    }
</style>
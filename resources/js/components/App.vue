<template>
    <router-view/>
</template>

<script>
export default {
    name: "App",
    beforeMount() {
        Popper.Defaults.modifiers.computeStyle.gpuAcceleration = false;
        if (localStorage.getItem("token")) {
            this.$webService.defaults.headers.common["Authorization"] = `Bearer ${localStorage.getItem("token")}`;
            if (localStorage.getItem("token_expires_in") && localStorage.getItem("token_expires_in") > new Date().getTime()) {
                this.$store.commit("getRoles");
                if (this.$router.currentRoute.name == "login") {
                    this.$router.push({ name: 'system' });
                }
            } else {
                localStorage.setItem("token", null);
                localStorage.setItem("token_expires_in", null);
                
                if (this.$router.currentRoute.name != "login") {
                    this.$router.push({ name: 'login' });
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
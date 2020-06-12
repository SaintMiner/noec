<template>
    <div class="sidebar overflow-auto" >
        <div class="text-light p-3">
            <div> {{user.nameSurname}} ({{user.username}})</div>
            
            <div>
                <button class="btn btn-danger" @click="logout">Logout</button>
            </div>
        </div>
        <div class="mx-2 text-light overflow-hidden">
            <hr>
            <div v-for="item in sidebarContent" :key="item  .id">
            <sidebarItem  :item="item"/>
            <hr>
            </div>
        </div>
    </div>
</template>

<script>

import sidebarItem from "./sidebar-item";

export default {
    name: "sidebar",

    data() {
        return {
            user: {
                username: null
            },
        }
    },

    components: {
        sidebarItem,
    },

    props: {
        sidebarContent: Array,
    },

    methods: {
        logout: function() {
            localStorage.setItem("token", null);
            localStorage.setItem("token_expires_in", null);
            this.$webService.post("auth/logout").then(response => {
                this.$router.push({ name: 'login' })
            }).catch(e => {
                console.error(e);
            });
        }
    },

    beforeMount() {
        this.$webService.post("auth/me").then(response => {
            this.user = response.data;
            this.$webService.get(`resource/${response.data.resource_id}`).then(response => {
                this.$set(this.user, "nameSurname", `${response.data.name} ${response.data.surname}`);
            }).catch(e => {
                console.error(e);
            });
        }).catch(e => {
            console.error(e);
        });
    }
}
</script>

<style scoped>
    .sidebar {
        width: 265px;
        background-color: #1b262c ;
        position: sticky;
        top: 0;
        height: 100vh;
    }

    .sidebar::-webkit-scrollbar {
        width: 5px;
        box-shadow: inset 0 0 5px grey;
        background: white;
    }

    ::-webkit-scrollbar-thumb {
        background: gray; 
        border-radius: 10px;
    }
    
</style>
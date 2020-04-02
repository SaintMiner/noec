<template>
    <div class="sidebar overflow-auto" >
        <div class="text-light p-3">
            {{user.name}}
        </div>
        <div class="mx-2 text-light overflow-hidden">
            <hr>
            <div v-for="i in sidebarContent" :key="i.id">
            <sidebarItem  
                :item="i"
            />
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
                name: null
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
    },

    mounted() {
        this.$webService.post("auth/me").then(response => {
            this.user = response.data;
        }).catch(e => {
            console.error(e);
        })
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
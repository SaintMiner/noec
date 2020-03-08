<template>
    <div class="sidebar overflow-auto" >
        <div class="mx-2 text-light overflow-hidden py-5">
            <sidebarItem v-for="i in sidebarContent" :key="i.id" 
                :item="i"
            />
        </div>
    </div>
</template>

<script>

import sidebarItem from "./sidebar-item";

export default {
    name: "sidebar",

    data() {
        return {
            
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

    
</style>
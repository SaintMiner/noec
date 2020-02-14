<template>
    <div class="sidebar h-100 overflow-auto" >
        <div class="mx-2 text-light overflow-hidden py-5">
            <sidebarItem v-for="i in sidebarContent" :key="i.id" 
                :itemName="i.name" 
                :routeName="i.routeName" 
                :icon="i.icon"
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

<style>
    .sidebar {
        width: 265px;
        background-color: #1b262c ;
    }
</style>
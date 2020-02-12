<template>
    <div class="sidebar" :style="{'min-height': clientHeight}">
        <div class="h-100 mx-2 text-light pt-5">
            <sidebarItem v-for="i in 10" :key="i.id" :itemName="i"/>
        </div>
    </div>
</template>

<script>

import sidebarItem from "./sidebar-item";

export default {
    name: "sidebar",

    data() {
        return {
            clientHeight: String,
        }
    },

    components: {
        sidebarItem,
    },

    methods: {
        getWindowInnerHeight() {
            this.clientHeight = window.innerHeight+"px";
        }
    },

    mounted() {
        window.addEventListener("resize", this.getWindowInnerHeight);
        this.getWindowInnerHeight();
    }
}
</script>

<style>
    .sidebar {
        min-height: 100%;
        max-width: 265px;
        background-color: #1b262c ;
    }
</style>
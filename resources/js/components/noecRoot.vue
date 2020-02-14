<template>
    <div class="root d-flex">
        <sidebar :sidebarContent="sidebarContent"/>
        <div class="m-4 w-100">
            <router-view name="content"/>
        </div>
    </div>
</template>

<script>
    import sidebar from "./sidebar/sidebar";
    import sidebarContent from "./content/content.json";
    export default {
        name: "system-root",
        
        data() {
            return {
                sidebarContent: sidebarContent,
            }
        },

        components: {
            sidebar,
        },
    }
</script>

<style >
    .root {
        height: 100%;
    }
</style>
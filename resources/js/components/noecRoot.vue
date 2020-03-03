<template>
    <div class="root d-flex">
        <sidebar :sidebarContent="sidebarContent"/>
        <div class="m-4 mb-5 w-100">
            <router-view name="content" class="h-100"/>
        </div>
    </div>
</template>

<script>
    import sidebar from "./sidebar/sidebar";
    import sidebarContent from "./sidebar/content.json";
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
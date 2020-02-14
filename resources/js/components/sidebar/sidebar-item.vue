<template>

    <router-link class="btn btn-block text-left text-light p-3 mt-3 font-weight-bold sidebar-item" :to="{name: routeName}">
        <span> <font-awesome-icon :icon="icon" class="mx-2"/> {{itemName}} </span>
    </router-link>
</template>

<script>
export default {
    name: "sidebar-item",

    props: {
        itemName: String,
        routeName: String,
        icon: String,
    },
}
</script>

<style>
    .sidebar-item:hover {
        background-color: #393e4638;
        border-radius: 5.5px;
    }
</style>
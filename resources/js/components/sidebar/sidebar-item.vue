<template>
    <div class="p-3  my-3 font-weight-bold sidebar-item">
        <span>
            <font-awesome-icon icon="user" class="mx-2"/> {{itemName}}
        </span>
    </div>
</template>

<script>
export default {
    name: "sidebar-item",

    props: {
        itemName: String
    },
}
</script>

<style>
    .sidebar-item:hover {
        background-color: #393e4638;
        border-radius: 5.5px;
    }
</style>
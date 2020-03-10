<template>
    <div class="sidebar-item mt-3" v-if="!item.subitems">
        <router-link class="btn btn-block text-left text-light p-3 font-weight-bold" :to="{name: item.routeName}">
            <span> <font-awesome-icon :icon="item.icon" class="mx-2"/> {{item.name}} </span>
        </router-link>
    </div>
    <div class="sidebar-item mt-3" v-else>
        <div class="btn btn-block text-left text-light p-3 font-weight-bold" data-toggle="collapse" :data-target="'#'+item.collapseID">
            <span> <font-awesome-icon :icon="item.icon" class="mx-2"/> {{item.name}} </span>
        </div>
        <div class="collapse pb-2" :id="item.collapseID">
            <div class="ml-3 mt-3 mr-1" v-for="subitem in item.subitems" :key="subitem.id">
                <router-link class="btn btn-block text-left text-light" :to="{name: subitem.routeName}">
                    <span> <font-awesome-icon :icon="subitem.icon" class="mx-2"/> {{subitem.name}} </span>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "sidebar-item",

    props: {
        item: Object,
        
    },
}
</script>

<style>
    .sidebar-item:hover {
        background-color: #393e4638;
        border-radius: 5.5px;
    }

</style>
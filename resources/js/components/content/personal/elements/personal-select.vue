<template>
    <select class="custom-select">
        <option selected disabled v-if="placeHolderValue"> {{placeHolderValue}} </option>
        <option :value="value.value" v-for="value in values" :key="value.id">
            {{value.name}}
        </option>
    </select>
</template>

<script>
export default {
    name: "personal-select",

    props: {
        values: Array,
        placeHolderValue: [Boolean, String],
    },
}
</script>

<style>

</style>
<template>
    <select class="custom-select" v-model="selected">
        <option value=0 selected disabled v-if="placeHolderValue"> {{placeHolderValue}}</option>
        <option :value="value.value" v-for="value in values" :key="value.id">
            {{value.name}}
        </option>
    </select>
</template>

<script>
export default {
    name: "personal-select",

    computed: {
        selected: {
            get() {
                return this.model;
            },

            set(val) {
                this.$emit("input", val);
            }
        }
    },

    props: {
        values: Array,
        placeHolderValue: [Boolean, String],
        model: String,
    },

    watch: {
        
    },
}
</script>

<style>

</style>
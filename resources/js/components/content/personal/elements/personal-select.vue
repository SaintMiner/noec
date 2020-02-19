<template>
    <select class="custom-select" v-model="selected">
        <option value=0 selected :disabled="!changed" v-if="placeHolderValue"> {{placeHolderValueData}}</option>
        <option :value="value.value" v-for="value in values" :key="value.id">
            {{value.name}}
        </option>
    </select>
</template>

<script>
export default {
    name: "personal-select",

    data() {
        return {
            changed: false,
            placeHolderValueData: this.placeHolderValue
        }
    },

    computed: {
        selected: {
            get() {
                return this.model;
            },

            set(val) {
                this.$emit("input", val);
                this.placeHolderValueData = "None";
                this.changed = true;
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
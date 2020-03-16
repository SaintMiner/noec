<template>
    <div class="input-group my-4">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">
                <font-awesome-icon :icon="icon" />
            </span>
        </div>
        <input :type="type" class="form-control" :placeholder="placeholder" v-model="inputValue">
    </div>
</template>

<script>
export default {
    name: "login-input",

    data() {
        return {
            value: "",
        }
    },

    props: {
        type: String,
        icon: String,
        placeholder: String,
    },

    computed: {
        inputValue: {
            set: function(value) {
                this.value = value;
                this.$emit("setValue", this.value);
            },

            get: function() {
                return this.value;
            }
        }
    }
}
</script>

<style>

</style>
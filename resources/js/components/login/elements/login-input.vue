<template>
    <div class="input-group my-4">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">
                <font-awesome-icon :icon="icon" />
            </span>
        </div>
        <input :type="type" class="form-control" :placeholder="placeholder">
    </div>
</template>

<script>
export default {
    name: "login-input",

    props: {
        type: String,
        icon: String,
        placeholder: String,
    },
}
</script>

<style>

</style>
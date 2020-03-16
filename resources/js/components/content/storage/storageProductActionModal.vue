<template>
    <div id="storageActionModal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{actionTitle}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="onClose">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <h3>Product: [{{actionProduct.name}}]</h3>
                    <label >{{actionText}}</label>
                    <input type="text" class="form-control mb-3" v-model="inputValue" :class="{'is-invalid': !isValid && focused}" @focus="focused = true">
                    <div class="invalid-feedback">
                        {{ error }}
                    </div>
                    <small class="form-text text-muted" v-if="isValid">
                        {{inputValue}} pallete = {{inputValue*actionProduct.amount_per_palete}} products
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="onClose">Close</button>
                <button type="button" class="btn btn-primary" :disabled="!isValid" @click="confirm">Confirm</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "storageProductActionModal",

    props: {
        actionText: String,
        actionTitle: String,
        actionProduct: Object,
        actionStorage: Object,
        actionFunction: {type: Function},
        
    },

    data() {
        return {
            value: "1",
            error: "a",
            isValid: true,
            focused: false,
        }
    },

    computed: {
        inputValue: {
            set: function(value) {
                if (!isNaN(value) && Number(value) != 0 && Number(value) % 1 == 0) {
                    if (Number(value) < 0) {
                        value = Math.abs(value);
                    }
                    this.isValid = true;
                    this.error = "";
                } else {
                    this.isValid = false;
                    this.error = "Value must be a positive number without places";
                }
                this.value = value;
            },

            get: function() {
                return this.value;
            }
        }
    },

    methods: {
        onClose: function() {
            this.$el.remove();
        },

        confirm: function() {
            $('#storageActionModal').modal('hide');
            this.actionFunction(this.actionStorage, this.actionProduct, this.value);
            this.$el.remove();
        }
    },

}
</script>

<style>
    
</style>
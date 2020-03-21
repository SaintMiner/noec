<template>
    <div id="storageActionModal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <h3 v-if="actionProducts.length == 1">Product: [{{actionProducts[0].name}}]</h3>
                    <label >{{actionText}}</label>
                    <input type="text" class="form-control mb-3" v-model="inputValue" :class="{'is-invalid': !isValid && focused}" @focus="focused = true">
                    <div class="invalid-feedback" v-for="error in errors" :key="error.id">
                        {{ error }}
                    </div>
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
        actionProducts: Array,
        actionStorage: Object,
        actionFunction: {type: Function},
        actionType: {type: String, default: null},
    },

    data() {
        return {
            value: "1",
            errors: [],
            isValid: true,
            focused: false,
        }
    },

    computed: {
        inputValue: {
            set: function(value) {
                this.errors = [];
                if (!isNaN(value) && Number(value) != 0 && Number(value) % 1 == 0) {
                    if (Number(value) < 0) {
                        value = Math.abs(value);
                    }

                    if (this.actionType == "add" && Number(value*this.actionProducts.length) > (this.actionStorage.freeSpace)) {
                        this.isValid = false;
                        this.errors.push(`Value is more than storage palletes capacity. Free: ${this.actionStorage.freeSpace}`);
                    } else if (this.actionType == "subtract") {
                        let errProd = this.actionProducts.filter(product => {
                           if (Number(value) > product.palete_amount) {
                                this.isValid = false;
                                this.errors.push(`Value is more than storage palletes count. [${product.name}]: ${product.palete_amount}`);
                           }
                        });
                    } else {
                        this.isValid = true;
                        this.errors = [];
                    }
                } else {
                    this.isValid = false;
                    this.errors.push("Value must be a positive number without places");
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
            this.actionFunction(this.actionStorage, this.actionProducts, this.value);
            this.$el.remove();
        }
    },

    mounted() {
        console.log(this.actionStorage.freeSpace);
        console.log(this.actionStorage.busySpace);
        if (1 > this.actionStorage.freeSpace && this.actionType == "add") {
            this.isValid = false;
            this.focused = true;
            this.errors.push("No space in storage");
        }
    }

}
</script>

<style>
    
</style>
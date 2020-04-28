<template>
    <div id="enterpriseActionModal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{actionTitle}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="onClose">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div v-if="actionType == 'order'" class="form-group">
                    <div class="d-flex">
                        <div>
                            <h4>Select storage</h4>
                        </div>
                        <div class="spinner-border spinner-border-sm m-1" role="status" v-if="selectedStorageLoading">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <select class="custom-select custom-select mb-3" v-model="storageModel" :class="{'is-invalid': notIncludedProducts.length}">
                            <option :value="null" selected disabled>Select storage</option>
                            <option v-for="storage in storages" :key="storage.storage_id" :value="storage.storage_id"> {{storage.title}} </option>
                        </select>
                        <div class="invalid-feedback" v-for="product in notIncludedProducts" :key="product.id">
                            <span> [{{product.name}}] is not included in this storage</span>
                        </div>
                    </div>
                </div>
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
                <button type="button" class="btn btn-primary" :disabled="!isValid || !isValidStorage" @click="confirm">Confirm</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "enterpriseProductActionModal",

    props: {
        actionText: String,
        actionTitle: String,
        actionProducts: Array,
        actionEnterprise: Object,
        actionFunction: {type: Function},
        actionType: {type: String, default: null},
    },

    data() {
        return {
            value: "1",
            errors: [],
            isValid: true,
            focused: false,

            storages: null,
            selectedStorage: null,
            selectedStorageLoading: false,
            notIncludedProducts: [],
            isValidStorage: true,
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

                    if (this.actionType == "subtract") {
                        let errProd = this.actionProducts.filter(product => {
                           if (Number(value) > product.amount) {
                                this.isValid = false;
                                this.errors.push(`Value is more than product amount. [${product.name}]: ${product.amount}`);
                                return product;
                           }
                        });
                        if (errProd.length) {
                            this.isValid = false;
                        } else {
                            this.isValid = true;
                        }
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
        },
        
        storageModel: {
            set: function(value) {
                this.selectedStorage = value;
                this.selectedStorageLoading = true;
                this.$webService.get(`storage/getProducts/${value}`).then(response => {
                    this.actionProducts.forEach(actionProd => {
                        let res = response.data.find(prod => prod.id == actionProd.id)
                        if (res != undefined) {
                            actionProd.storaged = true;
                        } else {
                            actionProd.storaged = false;
                        }
                    });
                    let notIncludedProducts = this.actionProducts.filter(prod => prod.storaged == false);
                    this.notIncludedProducts = notIncludedProducts;
                    if (notIncludedProducts.length) {
                        this.isValidStorage = false;
                    } else {
                        this.isValidStorage = true;
                    }
                    this.selectedStorageLoading = false;
                }).catch(e => {
                    console.error(e);
                })
            },

            get: function() {
                return this.selectedStorage;
            }
        }
    },

    methods: {
        onClose: function() {
            this.$el.remove();
        },

        confirm: function() {
            $('#enterpriseActionModal').modal('hide');
            if (this.actionType == "order") {
                this.actionFunction(this.actionEnterprise, this.selectedStorage, this.actionProducts, this.value);
            } else {
                this.actionFunction(this.actionEnterprise, this.actionProducts, this.value);
            }
            this.$el.remove();
        },

        laodStorages: function() {
            this.$webService.get(`enterprise/getStorages/${this.actionEnterprise.id}`).then(response => {
                this.storages = response.data;
            }).catch(e => {
                console.error(e);
            });
        }
    },

    mounted() {
        if (this.actionType == "order") {
            this.laodStorages();
            this.isValidStorage = false;
        }
    }
}
</script>

<style>
    
</style>
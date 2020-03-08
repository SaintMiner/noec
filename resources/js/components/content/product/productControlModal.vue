<template>
    <div class="modal fade" id="productControlModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-if="!editMode">Register new product</h5>
                    <h5 class="modal-title" v-else>Edit product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label class="col-form-label">Product name</label>
                            <input type="text"  class="form-control" 
                                :class="{'is-invalid': !nameValidator && focused.name}"
                                v-model="product.name"
                                @focus="focused.name = true"
                            >
                            <div class="invalid-feedback"> {{error.name}} </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Price</label>
                            <input type="text"  class="form-control" 
                                :class="{'is-invalid': !priceValidator && focused.price}"
                                v-model="product.price"
                                @focus="focused.price = true"
                                @blur="fixPrice"
                            >
                            <div class="invalid-feedback"> {{error.price}} </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Amount per palete</label>
                            <input type="text"  class="form-control"
                                :class="{'is-invalid': !amountPerPaletepaleteValidator && focused.amount_per_palete}"
                                v-model="product.amount_per_palete" 
                                @focus="focused.amount_per_palete = true"
                                @blur="fixAmountPerPalete"
                            >
                            <div class="invalid-feedback"> {{error.amount_per_palete}} </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" v-if="!editMode" :disabled="!validated" @click="registerProduct">Register</button>
                    <button type="button" class="btn btn-primary" v-else :disabled="!validated" @click="editProduct">Edit</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProductControlModal",

    props: {
        editMode: {type: Boolean, default: false},
        editingProduct: {type: Object, default: null},
    },

    data() {
        return {
            product: {
                name: "",
                price: "0.00",
                amount_per_palete: "0",
            },
            error: {
                name: "",
                price: "",
                amount_per_palete: "",
            },
            focused: {
                name: false,
                price: false,
                amount_per_palete: false,
            },
        }
    },

    computed: {
        nameValidator: function() {
            let name = this.product.name
            if (name.length >= 3 && name.length <= 255) {
                return true;
            } else {
                this.error.name = "Product name must contain more than 2 and less than 256 symbols"
                return false;
            }
        },

        priceValidator: function() {
            let price = this.product.price
            if (!isNaN(price) && String(price).length > 0 && Number(price) > 0) {
                return true;
            } else {
                this.error.price = "Product price must be a positive numbers and more than 0!"
                return false;
            }
        },

        amountPerPaletepaleteValidator: function() {
            let amountPerPalete = this.product.amount_per_palete;
            if (!isNaN(amountPerPalete) && String(amountPerPalete).length > 0 && Number(amountPerPalete) > 0 && !(Number(amountPerPalete) % 1)) {
                return true;
            } else {
                this.error.amount_per_palete = "Amount per palete must countain positive number wihout places";
                return false;
            }
        },

        validated: function() {
            return (this.priceValidator && this.nameValidator && this.amountPerPaletepaleteValidator);
        }
    },

    watch: {
        editingProduct: function() {
            this.clearData();
            if (this.editMode) {
                this.product = {
                    name: this.editingProduct.name,
                    price: this.editingProduct.price,
                    amount_per_palete: this.editingProduct.amount_per_palete,
                }
            }
        }
    },

    methods: {
        registerProduct: function() {
            this.$webService.post("product", this.product).then(response => {
                if (response.status == 201) {
                    this.$emit("loadProducts");
                    $('#productControlModal').modal('hide');
                    this.clearData();
                }
            }).catch(e => {
                console.error(e);
            })
        },

        editProduct: function() {
            this.$webService.put(`product/${this.editingProduct.id}`, this.product).then(response => {
                if (response.status == 201) {
                    this.$emit("loadProducts");
                    $('#productControlModal').modal('hide');
                    this.clearData();
                }
            }).catch(e => {
                console.error(e);
            })
        },

        clearData: function() {
            this.product.name = "";
            this.product.price = "0.00";
            this.product.amount_per_palete = "0";
            this.focused.name = false;
            this.focused.price = false;
            this.focused.amount_per_palete = false;
        },

        fixPrice: function () {
            if (this.priceValidator) {
                this.product.price = Number(this.product.price).toFixed(2);
            }
        },

        fixAmountPerPalete: function() {
            if (this.amountPerPaletepaleteValidator) {
                this.product.amount_per_palete = Number(this.product.amount_per_palete).toFixed(0);
            }
        },
    },
}
</script>

<style>

</style>

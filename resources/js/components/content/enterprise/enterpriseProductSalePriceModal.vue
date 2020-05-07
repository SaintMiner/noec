<template>
    <div class="modal fade" id="productSalePrice" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit sale price [{{productData.name}}]</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="onClose">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-form-label">Sale price</label>
                    <input type="text" class="form-control" v-model="productSalePrice">
                    <div class="invalid-feedback">  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="onClose">Close</button>
                <button type="button" class="btn btn-primary" @click="onChange">Change</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "enterpriseProductSalePriceModal",

    data() {
        return {
            productData: {
                name: "",
                salePrice: 0,
            }
        }
    },

    props: {
        product: Object,
        enterprise: Object,
        showEnterpriseLocalStorageProducts: {type: Function},
    },

    computed: {
        productSalePrice: {
            set: function(value) {
                this.productData.salePrice = value;
            },

            get: function() {
                return this.productData.salePrice;
            }
        }
    },

    methods: {
        onClose: function() {
            $('#productSalePrice').modal('hide');
            this.$el.remove();
            this.showEnterpriseLocalStorageProducts(this.enterprise);
        },

        onChange: function() {
            let data = {enterprise: this.enterprise.id, productID: this.product.id, salePrice: this.productData.salePrice};
            this.$webService.post("enterprise/updateProductSalePrice", data).then(response => {
                this.onClose();
            }).catch(e => {
                console.error(e);
            })
        }
    },

    mounted() {
        console.log("kek");
        this.productData = {name: this.product.name, salePrice: this.product.salePrice};
    }
}
</script>

<style>

</style>
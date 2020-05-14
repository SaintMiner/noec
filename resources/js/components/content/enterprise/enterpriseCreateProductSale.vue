<template>
    <div class="modal fade" id="createProductSale" tabindex="-1">
    <div class="modal-dialog modal-xl" >
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" >Create new Sale for [<span class="text-info"> {{enterprise.title}} </span>]</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="form-group discount-input">
                    <label class="font-weight-bold">Discount (%)</label>
                    <input type="text" class="form-control" v-model="discount">
                </div>
                <div class="modal-product-table">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Original Price</th>
                                <th>Enterprise Price</th>
                                <th class="sale-price">Selling Price</th>
                                <th>Product Count</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in actionProducts" :key="product.id">
                                    <td>
                                        {{product.name}} 
                                    </td>
                                    <td> {{product.price}} </td>
                                    <td> {{product.salePrice}} </td>
                                    <td class="sale-price">
                                        <div class="input-group input-group-sm mr-0">
                                            <input type="text" class="form-control" 
                                                :class="{'is-invalid': product.isInvalidPrice, 'is-valid': !product.isInvalidPrice && product.isInvalidPrice != undefined}" 
                                                v-model="product.sellingPrice"
                                            >
                                            
                                        </div>
                                    </td>
                                    <td class="sale-price">
                                        <div class="input-group input-group-sm mr-0">
                                            <input type="number" class="form-control" min="1"
                                                :class="{'is-invalid': product.isInvalidCount, 'is-valid': !product.isInvalidCount && product.isInvalidCount != undefined}" 
                                                v-model="product.count"
                                            >
                                            <!-- <div class="invalid-feedback">
                                                {{product.error}}
                                            </div> -->
                                        </div>
                                    </td>
                                    <td>
                                        {{(Number(product.sellingPrice)*Number(product.count)).toFixed(2)}}
                                    </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <div class="d-flex justify-content-between total">
                        <div>
                            Total:
                        </div>
                        
                        <div>
                            <span> {{(totalCost - totalCost*discount/100).toFixed(2)}} </span> <span v-if="discount"> ({{totalCost}}) </span>
                        </div>
                    </div>
                </div>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="createSale">
                    <span class="create-sale"> Create Sale </span>
                    <span class="spinner-border spinner-border-sm" role="status" v-if="loading">
                        <span class="sr-only">Loading...</span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    name: "createProductSale-modal",

    data() {
        return {
            discount: 0,
            loading: false,
        }
    },

    props: {
        actionProducts: Array,
        enterprise: Object,
        showEnterpriseLocalStorageProducts: {Type: Function},
    },

    computed: {
        totalCost: function() {
            let sum = 0;
            this.actionProducts.forEach(product => {
                let valid = true;
                if (isNaN(product.sellingPrice)) {
                    this.$set(product, "isInvalidPrice", true);
                    return;
                } else if (product.sellingPrice <= 0) {
                    this.$set(product, "isInvalidPrice", true);
                    return;
                } else {
                    this.$set(product, "isInvalidPrice", false);
                }

                if (isNaN(product.sellingPrice)) {
                    this.$set(product, "isInvalidCount", true);
                    return;
                } else if (product.count <= 0) {
                    this.$set(product, "isInvalidCount", true);
                    return;
                } else {
                    this.$set(product, "isInvalidCount", false);
                    product.count = Math.trunc(product.count);
                }

                if (valid) {
                    sum += Number(product.sellingPrice)*Number(product.count);
                }
            });
            return sum.toFixed(2);
        }
    },

    watch: {
        actionProducts: function() {
            if (!this.loading) {
                this.actionProducts.forEach(product => {
                    this.$set(product, "sellingPrice", product.salePrice);
                    this.$set(product, "count", 1);
                    this.discount = 0;
                });
            }
        }
    },

    methods: {
        createSale: function() {
            this.loading = true;
            let data = {
                enterprise_id: this.enterprise.id,
                discount: this.discount,
                products: this.actionProducts,
            }
            this.$webService.post("sale", data).then(response => {
                this.loading = false;
                this.showEnterpriseLocalStorageProducts(this.enterprise);
                $('#createProductSale').modal('hide');
            }).catch(e => {
                console.error(e);
            });
        }
    }
    
}
</script>

<style>
    .discount-input {
        width: 50%;
    }

    .total {
        margin: 0 10px 0 10px;
    }

    .create-sale {
        vertical-align: sub;
    }
</style>
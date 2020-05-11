<template>
    <div class="modal fade" id="createProductSale" tabindex="-1">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" >Add new enterprise</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="form-group discount-input">
                    <label class="font-weight-bold">Discount (%)</label>
                    <input type="text" class="form-control" >
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
                                                :class="{'is-invalid': product.isInvalid, 'is-valid': !product.isInvalid && product.isInvalid != undefined}" 
                                                v-model="product.sellingPrice"
                                            >
                                            <!-- <div class="invalid-feedback">
                                                {{product.error}}
                                            </div> -->
                                        </div>
                                    </td>
                                    <td class="sale-price">
                                        <div class="input-group input-group-sm mr-0">
                                            <input type="text" class="form-control" 
                                                :class="{'is-invalid': product.isInvalid, 'is-valid': !product.isInvalid && product.isInvalid != undefined}" 
                                                v-model="product.count"
                                            >
                                            <!-- <div class="invalid-feedback">
                                                {{product.error}}
                                            </div> -->
                                        </div>
                                    </td>
                                    <td>
                                        {{product.sellingPrice*product.count}}
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
                            {{totalCost}}
                        </div>
                    </div>
                </div>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" >Create Sale</button>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    name: "createProductSale-modal",

    props: {
        actionProducts: Array,
    },

    computed: {
        totalCost: function() {
            let sum = 0;
            this.actionProducts.forEach(product => {
                sum += product.sellingPrice*product.count;
            });
            return sum;
        }
    },

    watch: {
        actionProducts: function() {
            this.actionProducts.forEach(product => {
                this.$set(product, "sellingPrice", product.salePrice)
                this.$set(product, "count", 0)
            });
        }
    },
    
}
</script>

<style>
    .discount-input {
        width: 50%;
    }

    .total {
        margin: 0 10px 0 10px;
    }
</style>
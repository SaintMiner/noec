<template>
    <div class="modal fade" id="attachProductModal" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add product to Enterprise</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="onClose">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-product-table">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td></td>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Amount per Palete</th>
                                <th class="sale-price">Sale price</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr v-for="product in productList" :key="product.id">
                                <td class="small-column">
                                    <div class="form-check"> <input type="checkbox" class="form-check-input" v-model="product.checked"> </div> 
                                </td>
                                <td :class="{'text-danger': !product.included}">
                                    <font-awesome-icon class="text-danger" v-if="!product.included" icon="exclamation"/>
                                    {{product.name}} 
                                </td>
                                <td> {{product.price}} </td>
                                <td> {{product.amount_per_palete}} </td>
                                <td class="sale-price">
                                    <div class="input-group input-group-sm mr-0">
                                        <input type="text" class="form-control" 
                                            :class="{'is-invalid': product.isInvalid, 'is-valid': !product.isInvalid && product.isInvalid != undefined}" 
                                            :disabled="!product.checked" 
                                            v-model="product.salePrice"
                                        >
                                        <div class="invalid-feedback">
                                            {{product.error}}
                                        </div>
                                    </div>
                                </td>
                        </tr>
                        
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="onClose">Close</button>
                <button type="button" class="btn btn-primary" @click="onAdd">Add products</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AttachProductModal",

    data() {
        return {
            productList: [],
        }
    },

    props: {
        enterprise: Object,
        showEnterpriseLocalStorageProducts: {type: Function},
    },

    methods: {
        onAdd: function() {
            let checkedProducts = this.productList.filter(product => product.checked);
            if (checkedProducts.length) {
                checkedProducts.forEach(product => {
                    if (product.salePrice != undefined) {
                        let salePrice = Number(product.salePrice).toFixed(2);
                        if (salePrice == "" || isNaN(salePrice) || Number(salePrice) == 0) {
                            product.isInvalid = true;
                            product.error = "Fill sale price correctly!";
                        } else {
                            if (Number(salePrice) < 0) {
                                salePrice = Math.abs(salePrice);
                            }
                            product.isInvalid = false;
                            product.salePrice = salePrice;
                            product.error = "";
                        }
                        
                    } else {
                        product.isInvalid = true;
                        product.error = "Fill sale price correctly!";
                    }
                });
                this.$forceUpdate();
            let invalidCheckedProduct = checkedProducts.filter(product => product.isInvalid);
            if (!invalidCheckedProduct.length) {
                let products = checkedProducts.map(product => {return {product_id: product.id, sale_price: product.salePrice}});
                let data = {products: products, enterpriseID: this.enterprise.id};
                this.$webService.post("enterprise/attachProducts", data).then(response => {
                    console.log(response);
                    $('#attachProductModal').modal('hide');
                    this.onClose();
                    this.showEnterpriseLocalStorageProducts(this.enterprise);
                }).catch(e => {
                    console.error(e);
                })
            }
            } else {
                alert("Firstly check some product or products!");
            }
        },

        getNotIncludedProducts: function() {
            this.$webService(`enterprise/getNotIncludedProducts/${this.enterprise.id}`).then(response => {
                console.log(response);
                this.productList = response.data;
            }).catch(e => {
                console.error(e);
            });
        },

        onClose: function() {
            this.$el.remove();
        },
    },

    mounted() {
        this.getNotIncludedProducts();
    }
}
</script>

<style scoped>
    .sale-price {
        max-width: 130px!important;
    }

    

    .small-column input {
        margin-top: -45%;
    }

    .modal-product-table {
        max-height: 500px;
        overflow: auto;
    }

    .modal-product-table table {
        max-height: 100%;
    }
</style>
<template>
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add product to storage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                            </tr>
                        </thead>
                        <tbody>
                        <tr v-for="product in products" :key="product.id">
                                <td class="small-column">
                                    <div class="form-check"> <input type="checkbox" class="form-check-input" v-model="product.checked"> </div> 
                                </td>
                                <td> {{product.name}} </td>
                                <td> {{product.price}} </td>
                                <td> {{product.amount_per_palete}} </td>
                        </tr>
                        
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="addProductToStorage">Add products</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "addProductToStorage",

    data() {
        return {
            products: [],
        }
    },

    props: {
        selectedStorage: Number,
    },

    methods: {
        loadProducts: function() {
            this.$webService.get(`storage/getNotIncludedProduct/${this.selectedStorage}`).then(response => {
                console.log(response.data);
                this.products = response.data;
                console.log(this.products);

                // this.products.forEach(product => product.checked = false);
            }).catch(e => {
                console.error(e);
            });
        },

        getCheckedProducts: function() {
            // console.log(this.products);
            let checked = this.products.filter(product => product.checked);
            checked = checked.map(product => product.id);
            return checked;
        },

        addProductToStorage: function() {
            let data = {storage: this.selectedStorage, products: this.getCheckedProducts()};
            this.$webService.post("storage/addProductToStorage", data).then(response => {
                console.log(response.data);
            })
            
        }
    },

    watch: {
        selectedStorage: function() {
            this.loadProducts();
        }
    },

    mounted() {
        
    },

}
</script>

<style scoped>
    .small-column input {
        margin-top: 25%;
    }

    .modal-product-table {
        max-height: 500px;
        overflow: auto;
    }

    .modal-product-table table {
        max-height: 100%;
    }
</style>
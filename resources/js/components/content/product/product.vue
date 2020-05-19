<template>
    <div>
        <h1> Product control </h1>
        <hr>
        <productControlModal
            :editMode="editMode"
            :editingProduct="editingProduct"
            @loadProducts="loadProducts"
        />
        <confirmModal id="confirmDeleteModal" 
            confirmText="Are you sure you want to delete these products?"
            @confirmAction="deleteProduct(checkedProducts)"
        />
        <div>
            <div class="d-flex justify-content-between">
                <h2>Products</h2>
                <div>
                    <button class="btn btn-primary" @click="openRegisterProductModal">
                        <font-awesome-icon icon="plus"/>
                        <span class="ml-2">Register New Product</span>
                    </button>
                </div>
            </div>
            
            <div class="card product-control-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="w-50"> Name </th>
                            <th> Price </th>
                            <th> Amount per palete </th>
                            <th class="small-column"> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" :key="product.id">
                            <td class="small-column">
                                <div class="form-check"> <input type="checkbox" class="form-check-input" v-model="product.checked"> </div> 
                            </td>
                            <td> {{ product.name }} </td>
                            <td> {{ product.price }} </td>
                            <td> {{ product.amount_per_palete }} </td>
                            <td class="d-flex ptr-button-cube text-center">
                                <button class="btn btn-primary mx-1" @click="openEditProductModal(product)">
                                    <font-awesome-icon icon="pen" class=""/>
                                </button>
                                <button class="btn btn-danger mx-1" @click="deleteProductConfirm([product.id])">
                                    <font-awesome-icon icon="trash" class=""/>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="card ">
                <div class="m-2 d-flex justify-content-between">
                    <div>
                        <span class="with-checked-text">
                            Actions with checked:
                        </span>
                    </div>
                    <div>
                        <button class="btn btn-danger" @click="deleteProductConfirm(getCheckedProduct())"><font-awesome-icon icon="trash" class=""/></button>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</template>

<script>
import productControlModal from "./productControlModal";
import confirmModal from "../../elements/confirmModal";
export default {
    name: "product-control",

    components: {
        productControlModal,
        confirmModal,
    },

    data() {
        return {
            products: [],
            editMode: false,
            editingProduct: null,
            checkedProducts: [],
        }
    },

    methods: {
        loadProducts: function() {
            this.$webService.get("product").then(response => {
                this.products = response.data;
            }).catch(e => {
                console.error(e);
            })
        },

        openRegisterProductModal: function() {
            this.editMode = false;
            this.editingProduct = null;
            $('#productControlModal').modal('show');
        },

        openEditProductModal: function(product) {
            this.editMode = true;
            this.editingProduct = product;
            $('#productControlModal').modal('show');
        },

        getCheckedProduct: function() {
            let checkedProducts = this.products.filter(product => product.checked);
            checkedProducts = checkedProducts.map(product => product.id);
            return checkedProducts;
        },

        deleteProduct: function() {
            this.checkedProducts.forEach(product => {
                console.log(product);
                    this.$webService.delete(`product/${product}`).then(response => {
                    console.log(response);
                    this.loadProducts();
                    this.checkedProducts = [];
                    $('#confirmDeleteModal').modal('hide');
                }).catch(e => {
                    console.error(e);
                })
            })
        },

        deleteProductConfirm: function(productsIDArray) {
            if (productsIDArray.length) {
            this.checkedProducts = productsIDArray;
                $('#confirmDeleteModal').modal('show');
            } else {
                alert("Check product(s)");
            }
        },

        
    },

    mounted() {
        this.loadProducts();
    },

    beforeMount() {
        let reqRoles = ["admin","director","wh_manager"];
        this.$store.commit("hasRole", reqRoles);
        if (!this.$store.state.hasPermission) {
            this.$router.push({ name: 'system' });
        }
    }
}
</script>

<style>
    .small-column {
        width: 1px;
    }

    .small-column input {
        margin-top: -31%;
    }

    .product-control-table {
        height: 70vh;
        overflow: auto;
    }

    .product-control-table td {
        vertical-align: middle;
    }

    .with-checked-text {
        font-weight: bold;
        vertical-align: sub;
    }
</style>
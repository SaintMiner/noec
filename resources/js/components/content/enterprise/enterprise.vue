<template>
    <div ref="enterpriseControl">
        <addEnterpriseModal 
            @loadEnterPrises="loadEnterPrises" 
            :editMode="editMode" 
            :editingEnterprise="editingEnterprise"
        />
        <confirmModal id="confirmProductRemoveModal" 
            confirmText="Are you sure you want to remove these products?"
            @confirmAction="removeProducts(checkedProducts)"
        />
        <div class="enterprise-control mb-5">
            <div class="d-flex justify-content-between">
                <h2>Enterprises</h2>
                <div>
                    <button class="btn btn-primary" @click="openAddEnterpriseModal">
                        <font-awesome-icon icon="plus"/>
                        <span class="ml-2">New</span>
                    </button>
                </div>
            </div>
            <div class="card enterprise-control-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="w-50">Title</th>
                            <th>Personal</th>
                            <th>Location</th>
                            <th class="action-col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="enterprise in enterprises" :key="enterprise.id" >
                            <td @click="showEnterpriseLocalStorageProducts(enterprise)"> {{enterprise.title}} </td>
                            <td @click="showEnterpriseLocalStorageProducts(enterprise)"> 10/10 </td>
                            <td @click="showEnterpriseLocalStorageProducts(enterprise)"> {{enterprise.location}} </td>
                            <td class="d-flex ptr-button-cube text-center">
                                <button class="btn btn-primary mx-1" @click="openEditEnterpriseModal(enterprise)">
                                    <font-awesome-icon icon="pen" class=""/>
                                </button>
                                <button class="btn btn-primary mx-1" @click="showEnterpriseLocalStorageProducts(enterprise)">
                                    <font-awesome-icon icon="boxes" class=""/>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="local-storage">
            <div class="d-flex justify-content-between">
                <h2>Local Storage [<span :class="[selectedEnterprise.id == null ? 'text-danger' : 'text-primary']">{{selectedEnterprise.title}}</span>]</h2>
                <div>
                    <button class="btn btn-primary" @click="openAttachProductModal" :disabled="selectedEnterprise.id == null   "> 
                        <font-awesome-icon icon="plus"/>
                        <span class="ml-2">Add product</span>
                    </button>
                </div>
            </div>

            <div class="card local-storage-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Product name</th>
                            <th>Amount</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                            <th class="small-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in enterpriseStorage" :key="product.id">
                            <td class="small-column">
                                <div class="form-check"> <input type="checkbox" class="form-check-input" v-model="product.checked"> </div> 
                            </td>
                            <td> {{product.name}} </td>
                            <td> {{product.amount}} </td>
                            <td> {{product.price}} </td>
                            <td> {{product.salePrice}} </td>
                            <td class="ptr-button-cube text-center">
                                <button class="btn btn-outline-secondary " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <font-awesome-icon icon="ellipsis-v" class=""/>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Ordersss</a>
                                    <a class="dropdown-item" href="#" @click="openAddProductAmountModal([product])">Add</a>
                                    <a class="dropdown-item" href="#" @click="openSubtractProductAmountModal([product])">Subtract</a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" @click="openSingleRemoveProductConfirmModal(product)">Remove</a>
                                </div>
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
                        <button class="btn btn-success" @click="openAddProductAmountModal(getCheckedProducts())"><font-awesome-icon icon="plus" class=""/></button>
                        <button class="btn btn-danger" @click="openSubtractProductAmountModal(getCheckedProducts())"><font-awesome-icon icon="minus" class=""/></button>
                        <button class="btn btn-dark" @click="openMultipleRemoveProductConfirmModal"><font-awesome-icon icon="trash" class=""/></button>
                    </div>
                </div>  
            </div>
        </div>
    </div>

</template>

<script>
import enterpriseProductActionModal from "./enterpriseProductActionModal";
import addEnterpriseModal from "./enterpriseControlModal";
import attachProductModal from "./attachProductModal";
import confirmModal from "../../elements/confirmModal";
import Vue from "vue";
export default {
    name: "enterprise-control",

    data() {
        return {
            editingEnterprise: null,
            enterprises: [],
            enterpriseStorage: [],
            editMode: false,
            selectedEnterprise: {id: null, title: "Enterprise Not Selected"},
            checkedProducts: [],
        }
    },

    components: {
        addEnterpriseModal,
        attachProductModal,
        enterpriseProductActionModal,
        confirmModal,
    },

    methods: {
        
        

        getCheckedProducts: function() {
            let checkedProducts = this.enterpriseStorage.filter(product => product.checked);
            this.checkedProducts = checkedProducts.map(product => product.id);
            return checkedProducts;
        },

        openMultipleRemoveProductConfirmModal: function() {
            this.getCheckedProducts();
            $('#confirmProductRemoveModal').modal('show');
        },

        openSingleRemoveProductConfirmModal: function(product) {
            this.checkedProducts = [product.id];
            $('#confirmProductRemoveModal').modal('show');
        },
        
        removeProducts: function(checkedProducts) {
            if (checkedProducts.length) {
                let data = {enterprise: this.selectedEnterprise.id, products: checkedProducts}
                this.$webService.post("enterprise/removeProductFromEnterprise", data).then(response => {
                    this.showEnterpriseLocalStorageProducts(this.selectedEnterprise);
                    $('#confirmProductRemoveModal').modal('hide');
                }).catch(e => {
                    console.error(e);
                });
            } else {
                alert("Firstly check some products!");
            }
        },

        openSubtractProductAmountModal: function(products) {
            if (products.length) {
                let componentClass = Vue.extend(enterpriseProductActionModal);
                let instance = new componentClass({
                    propsData: {
                        actionTitle: "Decrease product amount",
                        actionText: "How many products need to be substracted?",
                        actionProducts: products,
                        actionEnterprise: this.selectedEnterprise,
                        actionFunction: this.subtractProducts,
                        actionType: "subtract",
                    },
                });
                instance.$mount(); 
                this.$refs.enterpriseControl.appendChild(instance.$el);
                $('#enterpriseActionModal').modal('show');
            } else {
                alert("Firstly check some product(s)");
            }
        },

        openAddProductAmountModal: function(products) {
            if (products.length) {
                let componentClass = Vue.extend(enterpriseProductActionModal);
                let instance = new componentClass({
                    propsData: {
                        actionTitle: "Increase product amount",
                        actionText: "How many products need to be added?",
                        actionProducts: products,
                        actionEnterprise: this.selectedEnterprise,
                        actionFunction: this.addProducts,
                        actionType: "add",
                    },
                });
                instance.$mount(); 
                this.$refs.enterpriseControl.appendChild(instance.$el);
                $('#enterpriseActionModal').modal('show');
            } else {
                alert("Firstly check some product(s)");
            }
        },

        addProducts: function(enterprise, product, amount) {
            let data = {productsID: product.map(prod => prod.id), amount: amount};
            this.$webService.put(`enterprise/addProductAmount/${enterprise.id}`, data).then(response => {
                if (response.status == 201) {
                    this.showEnterpriseLocalStorageProducts(enterprise);
                }
            }).catch(e => {
                console.error(e);
            });
            
        },

        subtractProducts: function(storage, product, amount) {
            this.addProducts(storage, product, -amount);
        },

        openAddEnterpriseModal: function() {
            this.editMode = false;
            this.editingEnterprise = null;
            $('#addEnterpriseModal').modal('show');
        },

        openEditEnterpriseModal: function(enterprise) {
            this.editingEnterprise = enterprise;
            this.editMode = true;
            $('#addEnterpriseModal').modal('show');
        },

        
        showEnterpriseLocalStorageProducts: function(enterprise) {
            this.$webService.get(`enterprise/getProducts/${enterprise.id}`).then(response => {
                this.selectedEnterprise = enterprise;
                this.enterpriseStorage = response.data;
            }).catch(e => {
                console.error(e);
            })
        },

        loadEnterPrises: function() {
            this.$webService.get("enterprise").then(response => {
                this.enterprises = response.data;
            }).catch(e => {
                console.error(e);
            })
        },

        openAttachProductModal: function() {
            if (this.selectedEnterprise.id != null) {
                console.log("ok")
                let componentClass = Vue.extend(attachProductModal);
                let instance = new componentClass({
                    propsData: {
                        enterprise: this.selectedEnterprise,
                        showEnterpriseLocalStorageProducts: this.showEnterpriseLocalStorageProducts,
                    },
                });
                instance.$mount(); 
                this.$refs.enterpriseControl.appendChild(instance.$el);
                $('#attachProductModal').modal('show');
            }
        }
    },

    mounted() {
        this.loadEnterPrises();
    }
}
</script>

<style>
    .enterprise-control {
        max-height: 500px;
    }

    .local-storage {
        max-height: 500px;
    }

    .local-storage-table td {
        vertical-align: middle;
    }

    .local-storage-table {
        max-height: 500px;
        overflow: auto;
    }

    .enterprise-control-table {
        max-height: 500px;
        overflow: auto;
    }

    .enterprise-control-table td {
        vertical-align: middle;
    }

    .action-col {
        width: 1px;
    }

    .ptr-button-cube button {
        width: 40px;
        height: 40px;
    }
</style>
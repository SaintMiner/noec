<template>
    <div ref="enterpriseControl">
        <addEnterpriseModal 
            @loadEnterPrises="loadEnterPrises" 
            :editMode="editMode" 
            :editingEnterprise="editingEnterprise"
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
                <h2>Local Storage</h2>
                <div>
                    <button class="btn btn-primary" @click="openAttachProductModal" :disabled="selectedEnterprise == null   "> 
                        <font-awesome-icon icon="plus"/>
                        <span class="ml-2">Add product</span>
                    </button>
                </div>
            </div>

            <div class="card local-storage-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product name</th>
                            <th>Amount</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in enterpriseStorage" :key="product.id">
                            <td> {{product.name}} </td>
                            <td> {{product.amount}} </td>
                            <td> {{product.price}} </td>
                            <td> {{product.salePrice}} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>
import addEnterpriseModal from "./enterpriseControlModal";
import attachProductModal from "./attachProductModal";
import Vue from "vue";
export default {
    name: "enterprise-control",

    data() {
        return {
            editingEnterprise: null,
            enterprises: [],
            enterpriseStorage: [],
            editMode: false,
            selectedEnterprise: null,
        }
    },

    components: {
        addEnterpriseModal,
        attachProductModal
    },

    methods: {
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
            if (this.selectedEnterprise != null) {
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
        min-height: 500px;
    }

    .local-storage {
        min-height: 500px;
    }

    .local-storage-table {
        height: 500px;
        overflow: auto;
    }

    .enterprise-control-table {
        height: 500px;
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
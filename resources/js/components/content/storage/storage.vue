<template>
    <div ref="storageControl">
        <confirmModal id="confirmProductRemoveModal" 
            confirmText="Are you sure you want to remove these products?"
            @confirmAction="removeProducts(checkedProducts)"
        />
        <addProductToStorage id="addProductToStorage" :selectedStorage="selectedStorage" :storageProducts="storageProducts" @loadStorageProducts="loadStorageProducts"/>
        <storageControlModal id="storageControlModal" :editMode="editMode" :editingStorage="editingStorage" @loadStorages="loadStorages"/>
        <div>
            <div class="d-flex justify-content-between">
                <h2>Storages</h2>
                <div>
                    <button class="btn btn-primary" @click="openAddStorageModal">
                        <font-awesome-icon icon="plus"/>
                        <span class="ml-2">Add Storage</span>
                    </button>
                </div>
            </div>

            <div class="card storage-control-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th> Title </th>
                            <th> Location </th>
                            <th> Class </th>
                            <th> Palete capacity </th>
                            <th class="small-column"> Actions  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="storage in storages" :key="storage.id">
                            <td @click="loadStorageProducts(storage)"> {{storage.title}} </td>
                            <td @click="loadStorageProducts(storage)"> {{storage.location}} </td>
                            <td @click="loadStorageProducts(storage)"> {{storage.class}} </td>
                            <td @click="loadStorageProducts(storage)"> {{storage.palete_capacity}} </td>
                            <td class="d-flex ptr-button-cube text-center">
                                <button class="btn btn-primary mx-1" @click="openEditStorageModal(storage)">
                                    <font-awesome-icon icon="pen" class=""/>
                                </button>
                                <button class="btn btn-danger mx-1" @click="">
                                    <font-awesome-icon icon="trash" class=""/>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>        

        <div class="mt-5">
            <div class="d-flex justify-content-between">
                <h2>Products [<span :class="[selectedStorage.id == null ? 'text-danger' : 'text-primary']">{{selectedStorage.title}}</span>]</h2>
                <div>
                    <button class="btn btn-primary" :disabled="selectedStorage.id == null" @click="openAddProductToStorageModal">
                        <font-awesome-icon icon="plus"/>
                        <span class="ml-2">Add product</span>
                    </button>
                </div>
            </div>

            <div class="card storage-product-control-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th> Name </th>
                            <th> Price </th>
                            <th> Palete amount </th>
                            <th class="small-column"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in storageProducts" :key="product.id">
                            <td class="small-column">
                                <div class="form-check"> <input type="checkbox" class="form-check-input" v-model="product.checked"> </div> 
                            </td>
                            <td> {{product.name}} </td>
                            <td> {{product.price}} </td>
                            <td> {{product.palete_amount}} </td>
                            <td class="d-flex ptr-button-cube text-center" :ref="`actionCell${product.id}`">
                                <button class="btn btn-outline-secondary " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <font-awesome-icon icon="ellipsis-v" class=""/>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Order</a>
                                    <a class="dropdown-item" href="#" @click="openAddPalletesModal(product)">Add</a>
                                    <a class="dropdown-item" href="#" @click="openSubtractPalletesModal(product)">Subtract</a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" @click="openSingleRemoveProductConfirmModal(product)">Remove</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</template>

<script>
import Vue from "vue";
import confirmModal from "../../elements/confirmModal";
import storageProductActionModal from "./storageProductActionModal";
import addProductToStorage from "./addProductToStorage";
import storageControlModal from "./storageControlModal";
export default {
    name: "storage-control",

    components: {
        storageControlModal,
        addProductToStorage,
        storageProductActionModal,
        confirmModal,
    },

    data() {
        return {
            storages: [],
            selectedStorage: {id: null, title: "Storage Not Selected"},
            storageProducts: [],

            editMode: false,
            editingStorage: null,

            actionProduct: null,
            actionFunction: null,

            checkedProducts: [],
        }
    },

    methods: {
        loadStorages: function() {
            this.$webService.get("storage").then(response => {
                this.storages = response.data;
            }).catch(e => {
                console.error(e);
            })
        },

        loadStorageProducts: function(storage) {
            console.log(storage)
            this.$webService.get(`storage/getProducts/${storage.id}`).then(response => {
                this.selectedStorage = storage;
                this.storageProducts = response.data;
            }).catch(e => {
                console.error(e);
            });
        },

        openAddStorageModal: function() {
            this.editMode = false;
            this.editingStorage = null;
            $('#storageControlModal').modal('show');
        },

        openEditStorageModal: function(storage) {
            this.editMode = true;
            this.editingStorage = storage;
            $('#storageControlModal').modal('show');
        },
        
        openAddProductToStorageModal: function() {
            if (this.selectedStorage.id != null) {
                $('#addProductToStorage').modal('show');
            } else {
                // Some warnings LATER...
            }
        },

        openAddPalletesModal: function(product) {
            let componentClass = Vue.extend(storageProductActionModal);
            let instance = new componentClass({
                propsData: {
                    actionTitle: "Add palletes",
                    actionText: "How many pallets need to be added?",
                    actionProduct: product,
                    actionStorage: this.selectedStorage,
                    actionFunction: this.addPalletes,
                },
            });
            instance.$mount(); 
            this.$refs.storageControl.appendChild(instance.$el);
            $('#storageActionModal').modal('show');
        },

        openSubtractPalletesModal: function(product) {
            let componentClass = Vue.extend(storageProductActionModal);
            let instance = new componentClass({
                propsData: {
                    actionTitle: "Subtract palletes",
                    actionText: "How many pallets need to be subtracted?",
                    actionProduct: product,
                    actionStorage: this.selectedStorage,
                    actionFunction: this.subtractPalletes,
                },
            });
            instance.$mount(); 
            this.$refs.storageControl.appendChild(instance.$el);
            $('#storageActionModal').modal('show');
        },

        openSingleRemoveProductConfirmModal: function(product) {
            this.checkedProducts = [product.id];
            $('#confirmProductRemoveModal').modal('show');
        },

        removeProducts: function(checkedProducts) {
            console.log(checkedProducts);
            let data = {storage: this.selectedStorage.id, products: checkedProducts}
            this.$webService.post("storage/removeProductFromStorage", data).then(response => {
                this.loadStorageProducts(this.selectedStorage);
                $('#confirmProductRemoveModal').modal('hide');
            }).catch(e => {
                console.error(e);
            })
        },

        addPalletes: function(storage, product, palleteCount) {
            let data = {productID: product.id, palleteCount: palleteCount};
            this.$webService.put(`storage/addPalletes/${storage.id}`, data).then(response => {
                if (response.status == 201) {
                    this.loadStorageProducts(storage);
                }
            }).catch(e => {
                console.error(e);
            });
            
        },

        subtractPalletes: function(storage, product, palleteCount) {
            this.addPalletes(storage, product, -palleteCount);
        },

    },

    mounted() {
        this.loadStorages();
        

    }
}
</script>

<style>
    .storage-control-table, .storage-product-control-table {
        max-height: 500px;
        overflow: auto;
    }

    .storage-control-table td, .storage-product-control-table td {
        vertical-align: middle;
    }
</style>
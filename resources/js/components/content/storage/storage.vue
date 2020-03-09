<template>
    <div>
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
                            <td @click="loadStorageProducts(storage.id)"> {{storage.title}} </td>
                            <td @click="loadStorageProducts(storage.id)"> {{storage.location}} </td>
                            <td @click="loadStorageProducts(storage.id)"> {{storage.class}} </td>
                            <td @click="loadStorageProducts(storage.id)"> {{storage.palete_capacity}} </td>
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
                <h2>Products</h2>
                <div>
                    <button class="btn btn-primary" @click="">
                        <font-awesome-icon icon="plus"/>
                        <span class="ml-2">Add product</span>
                    </button>
                </div>
            </div>

            <div class="card storage-product-control-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th> Name </th>
                            <th> price </th>
                            <th> Palete amount </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in storageProduct" :key="product.id">
                            <td> {{product.name}} </td>
                            <td> {{product.price}} </td>
                            <td> {{product.palete_amount}} </td>
                            <td> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import storageControlModal from "./storageControlModal";
export default {
    name: "storage-control",

    components: {
        storageControlModal,
    },

    data() {
        return {
            storages: [],
            storageProduct: [],
            editMode: false,
            editingStorage: null,

        }
    },

    methods: {
        loadStorages: function() {
            this.$webService.get("storage").then(response => {
                this.storages = response.data;
                console.log(this.storages);
            }).catch(e => {
                console.error(e);
            })
        },

        loadStorageProducts: function(id) {
            this.$webService.get(`storage/getProducts/${id}`).then(response => {
                this.storageProduct = response.data;
            }).catch(e => {
                console.error(e);
            })
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
        }
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
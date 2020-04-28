<template>
    <div ref="shippingControl">
        <confirmModal id="shippingCompleteConfirmModal" :confirmText="shippingCompleteConfirmModalText" @confirmAction="completeShippingConfirm(completingShipping)"/>
        <confirmModal id="shippingCancelConfirmModal" confirmText="Are you sure you want to cancel this shiiping?" @confirmAction="cancelShippingConfirm(cancelingShipping)"/>
        <h1>
            Shipping Orders
        </h1>
        <hr>
            
        <div class="card mb-3">
            <div class="d-flex">
                
                <div class="">
                    <select class="custom-select" v-model="statusFilterModel">
                        <option value="0" selected>Choose order status</option>
                        <option value="1">In progress</option>
                        <option value="2">Completed</option>
                        <option value="3">Canceled</option>
                    </select>
                </div>
                <div class="">
                    <select class="custom-select" v-model="typeFilterModel">
                        <option value="0" selected>Choose order type</option>
                        <option value="1">Replenish Storage</option>
                        <option value="2">Replenish Enterprise</option>
                    </select>
                </div>
            </div>
        </div>
         <div class="card shippingOrder-control-table">
                 
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="small-column"> ID </th>
                            <th> Enterprise </th>
                            <th> Storage </th>
                            <th> Type </th>
                            <th> Status </th>
                            <th> Products kind count </th>
                            <th> Created at </th>
                            <th class="small-column"> Actions  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="shipping in shippings" :key="shipping.id">
                            <td @click="openInfoModal(shipping)"> {{shipping.id}} </td>
                            <td @click="openInfoModal(shipping)" class="shipping-table-enterprise-title"> {{shipping.enterprise == null ? "" : shipping.enterprise.title}} </td>
                            <td @click="openInfoModal(shipping)"> {{shipping.storage.title}} </td>
                            <td @click="openInfoModal(shipping)"> {{shipping.type}} </td>
                            <td @click="openInfoModal(shipping)"> 
                                <span v-if="shipping.status == 'In progress'" class="text-primary">
                                    {{shipping.status}}
                                </span>
                                <span v-else-if="shipping.status == 'Completed'" class="text-success">
                                    {{shipping.status}}
                                </span>
                                <span v-else-if="shipping.status == 'Canceled'" class="text-danger">
                                    {{shipping.status}}
                                </span>
                            </td>
                            <td @click="openInfoModal(shipping)"> {{shipping.products.length}} </td>
                            <td @click="openInfoModal(shipping)"> {{formatDate(shipping.created_at)}} </td>
                            <td class="d-flex ptr-button-cube text-center">
                                <button class="btn btn-success mx-1" @click="completeShipping(shipping)" :disabled="shipping.status != 'In progress'">
                                    <font-awesome-icon icon="check" class=""/>
                                </button>
                                <button class="btn btn-danger mx-1" @click="cancelShipping(shipping)" :disabled="shipping.status != 'In progress'">
                                    <font-awesome-icon icon="times" class=""/>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

    </div>
</template>

<script>
import shippingOrderInfoModal from "./shippingOrderInfoModal";
import confirmModal from "../../elements/confirmModal";
import Vue from "vue";
export default {
    name: "shippingOrder",

    components: {
        shippingOrderInfoModal,
        confirmModal,
    },

    data() {
        return{
            shippings: [],
            selectedShipping: null,

            completingShipping: null,
            cancelingShipping: null,

            statusFilter: 0,
            typeFilter: 0,

            shippingCompleteConfirmModalText: "Are you sure you want to complete this shipping?",
        }
    },

    computed: {

        statusFilterModel: {
            set: function(value) {
                this.statusFilter = value;
                this.loadShippings();
            },

            get: function() {
                return this.statusFilter;
            }
        },

        typeFilterModel: {
            set: function(value) {
                this.typeFilter = value;
                this.loadShippings();
            },

            get: function() {
                return this.typeFilter;
            }
        },

    },

    methods: {
        loadShippings: function() {
            let filters = 
            this.$webService.get("shipping", {params: {
                typeFilter: this.typeFilter, 
                statusFilter: this.statusFilter
            }}).then(response => {
                console.log(response);
                this.shippings = response.data;
            }).catch(e => {
                console.error(e);
            })
        },

        formatDate: function(date) {
            let convertedDate = new Date(date);
            let year = convertedDate.getFullYear();
            let month = ("0"+convertedDate.getMonth()).slice(-2);
            let day = ("0"+convertedDate.getDate()).slice(-2);
            let hours = ("0"+convertedDate.getHours()).slice(-2);
            let minutes = ("0"+convertedDate.getMinutes()).slice(-2);
            let formatedDate = `${year}-${month}-${day} ${hours}:${minutes}`;
            return formatedDate;
        },

        openInfoModal: function(shipping) {
            let componentClass = Vue.extend(shippingOrderInfoModal);
            let instance = new componentClass({
                propsData: {
                    shipping: shipping,
                },
            });
            instance.$mount(); 
            this.$refs.shippingControl.appendChild(instance.$el);
            $('#shippingOrderInfoModal').modal('show');
        },

        completeShipping: function(shipping) {
            this.$webService.get(`shipping/getShippingUnperfomableProducts/${shipping.id}`).then(response => {
                let shippingUnperfomableProducts = response.data.filter(product => !product.perfomable);
                console.log(shippingUnperfomableProducts);
                if (shippingUnperfomableProducts.length == response.data.length) {
                    this.shippingCompleteConfirmModalText = `All shipping product are unperfomable. Are you sure you want to complete this shipping?`;
                } else if (shippingUnperfomableProducts.length) {
                    this.shippingCompleteConfirmModalText = `Shipping have ${shippingUnperfomableProducts.length} unperfomable product. Are you sure you want to complete this shipping?`;
                } else {
                    this.shippingCompleteConfirmModalText = "Are you sure you want to complete this shipping?";
                }
                this.completingShipping = shipping.id;
                // console.log(this.completingShipping);
                $('#shippingCompleteConfirmModal').modal('show');
            }).catch(e => {
                console.error(e);
            });
            
        },

        completeShippingConfirm: function(shipping) {
            this.$webService.get(`shipping/completeShipping/${shipping}`).then(response => {
                $('#shippingCompleteConfirmModal').modal('hide');
                this.loadShippings();
            }).catch(e => {
                console.error(e);
            })
        },

        cancelShipping: function(shipping) {
            this.cancelingShipping = shipping.id;
            console.log(this.cancelingShipping);
            $('#shippingCancelConfirmModal').modal('show');
        },

        cancelShippingConfirm: function(shipping) {
            this.$webService.get(`shipping/cancelShipping/${shipping}`).then(response => {
                $('#shippingCancelConfirmModal').modal('hide');
                this.loadShippings();
            }).catch(e => {
                console.error(e);
            })
        },


    },

    mounted() {
        this.loadShippings();
    }
}
</script>

<style>
    .shippingOrder-control-table {
        overflow: auto;
        max-height: 78vh;
    }

    .shippingOrder-control-table td {
        vertical-align: middle;
    }

    .shipping-table-enterprise-title {
        width: 30vh;
    }
</style>
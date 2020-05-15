<template>
    <div ref="saleControl">
        <saleOrderInfoModal :sale="actionSale"/>
        <confirmModal id="saleCompleteConfirmModal" :confirmText="saleCompleteConfirmModalText" @confirmAction="completeSaleConfirm(completingSale)"/>
        <confirmModal id="saleCancelConfirmModal" confirmText="Are you sure you want to cancel this sale?" @confirmAction="cancelSaleConfirm(cancelingSale)"/>
        <h1>
            Sales Orders
        </h1>
        <hr>
            
        <div class="card mb-3">
            <div class="d-flex">
                
                <!-- <div class="">
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
                </div> -->
            </div>
        </div>
         <div class="card shippingOrder-control-table">
                 
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th> ID </th>
                            <th> Enterprise </th>
                            <th> Discount </th>
                            <th> Product type count </th>
                            <th> Order cost </th>
                            <th> Order cost with discount </th>
                            <th> Status </th>
                            <th> Created at </th>
                            <th class="small-column"> Actions  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sale in sales" :key="sale.id">
                            <td @click="openInfoModal(sale)"> {{sale.id}} </td>
                            <td @click="openInfoModal(sale)"> {{sale.enterprise}} </td>
                            <td @click="openInfoModal(sale)"> {{sale.discount}}% </td>
                            <td @click="openInfoModal(sale)"> {{sale.products.length}} </td>
                            <td @click="openInfoModal(sale)" class=" text-right"> {{sale.total_cost.toFixed(2)}} </td>
                            <td @click="openInfoModal(sale)" class=" text-right"> {{(sale.total_cost*(1-sale.discount/100)).toFixed(2)}} </td>
                            <td @click="openInfoModal(sale)"> 
                                <span v-if="sale.status == 'In progress'" class="text-primary">
                                    {{sale.status}}
                                </span>
                                <span v-else-if="sale.status == 'Completed'" class="text-success">
                                    {{sale.status}}
                                </span>
                                <span v-else-if="sale.status == 'Canceled'" class="text-danger">
                                    {{sale.status}}
                                </span>
                            </td>
                            <td @click="openInfoModal(sale)"> {{formatDate(sale.created_at)}} </td>
                            <td class="d-flex ptr-button-cube text-center">
                                <button class="btn btn-success mx-1" @click="completeSale(sale)" :disabled="sale.status != 'In progress'">
                                    <font-awesome-icon icon="check" class=""/>
                                </button>
                                <button class="btn btn-danger mx-1" @click="cancelSale(sale)" :disabled="sale.status != 'In progress'">
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
import confirmModal from "../../elements/confirmModal";
import saleOrderInfoModal from "./saleOrderInfoModal";
export default {
    name: "sale-control",

    components: {
        confirmModal,
        saleOrderInfoModal,
    },

    data() {
        return {
            sales: [],
            actionSale: null,
            saleCompleteConfirmModalText: "",
            completingSale: null,
            cancelingSale: null,
        }
    },

    methods: {
        loadSales: function() {
            this.$webService.get("sale").then(response => {
                this.sales = response.data;
                console.log(response.data);
            }).catch(e => {
                console.error(e);
            });
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

        openInfoModal: function(sale) {
            $('#saleOrderInfoModal').modal('show');
            this.actionSale = sale;
        },

        completeSale: function(sale) {
            this.$webService.get(`sale/getUnperfomableProducts/${sale.id}`).then(response => {
                let unperfomableProducts = response.data.filter(product => !product.perfomable);
                if (unperfomableProducts.length == response.data.length) {
                    this.saleCompleteConfirmModalText = `All sale product are unperfomable. Are you sure you want to complete this sale?`;
                } else if (unperfomableProducts.length) {
                    this.saleCompleteConfirmModalText = `Sale have ${unperfomableProducts.length} unperfomable product(s). Are you sure you want to complete this sale?`;
                } else {
                    this.saleCompleteConfirmModalText = "Are you sure you want to complete this sale?";
                }
                this.completingSale = sale;
                $('#saleCompleteConfirmModal').modal('show');
            }).catch(e => {
                console.error(e);
            });
        },

        completeSaleConfirm: function(sale) {
            this.$webService.get(`sale/completeSale/${sale.id}`).then(response => {
                $('#saleCompleteConfirmModal').modal('hide');
                this.loadSales();
            }).catch(e => {
                console.error(e);
            });
        },

        cancelSale: function(sale) {
            this.cancelingSale = sale;
            $('#saleCancelConfirmModal').modal('show');
        },

        cancelSaleConfirm: function(sale) {
            this.$webService.get(`sale/cancelSale/${sale.id}`).then(response => {
                this.loadSales();
                $('#saleCancelConfirmModal').modal('hide');
            }).catch(e => {
                console.error(e);
            });
        }
    },

    mounted() {
        this.loadSales();
    }
}
</script>

<style>

</style>

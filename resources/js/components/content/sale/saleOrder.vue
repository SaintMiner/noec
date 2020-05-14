<template>
    <div ref="saleControl">
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
                            <th> Created at </th>
                            <th class="small-column"> Actions  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sale in sales" :key="sale.id">
                            <td> {{sale.id}} </td>
                            <td> {{sale.enterprise}} </td>
                            <td> {{sale.discount}}% </td>
                            <td> {{sale.products.length}} </td>
                            <td> {{sale.total_cost}} </td>
                            <td> {{(sale.total_cost*(1-sale.discount/100)).toFixed(2)}} </td>
                            <td> {{formatDate(sale.created_at)}} </td>
                            <td class="d-flex ptr-button-cube text-center">
                                <button class="btn btn-success mx-1" @click="">
                                    <font-awesome-icon icon="check" class=""/>
                                </button>
                                <button class="btn btn-danger mx-1" @click="">
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
export default {
    name: "sale-control",

    data() {
        return {
            sales: [],
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
    },

    mounted() {
        this.loadSales();
    }
}
</script>

<style>

</style>

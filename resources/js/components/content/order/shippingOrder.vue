<template>
    <div>
        <h1>
            Shipping Orders
        </h1>
        <hr>

         <div class="card storage-control-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="small-column"> ID </th>
                            <th> Enterprise </th>
                            <th> Storage </th>
                            <th> Type </th>
                            <th> Status </th>
                            <th> Products count </th>
                            <th> Created at </th>
                            <th class="small-column"> Actions  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="shipping in shippings" :key="shipping.id">
                            <td @click=""> {{shipping.id}} </td>
                            <td @click=""> {{shipping.enterprise == null ? "" : shipping.enterprise.title}} </td>
                            <td @click=""> {{shipping.storage.title}} </td>
                            <td @click=""> {{shipping.type}} </td>
                            <td @click=""> 
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
                            <td> {{shipping.products.length}} </td>
                            <td @click=""> {{formatDate(shipping.created_at)}} </td>
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
    name: "shippingOrder",

    data() {
        return{
            shippings: [],
            selectedShipping: null,
        }
    },

    methods: {
        loadShippings: function() {
            this.$webService.get("shipping").then(response => {
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
        }
    },

    mounted() {
        this.loadShippings();
    }
}
</script>

<style>

</style>
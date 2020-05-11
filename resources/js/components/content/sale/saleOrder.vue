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
                            <th class="small-column"> ID </th>
                            <th> Enterprise </th>
                            <th> Discount </th>
                            <th> Product count </th>
                            <th> Order cost </th>
                            <th> Created at </th>
                            <th class="small-column"> Actions  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr >
                            <td>1</td>
                            <td>Ent</td>
                            <td>10%</td>
                            <td>33</td>
                            <td>99.98 RUB</td>
                            <td>segodna</td>
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

}
</script>

<style>

</style>
<template>
    <div class="modal fade" id="shippingOrderInfoModal" data-backdrop="static">
        <div class="modal-dialog modal-lg" @click.stop>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Shipping order: №{{shipping.id}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="onClose">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-responsive-xl table-hover">
                        <thead>
                            <tr>
                                <th> Name </th>
                                <th> Standart price </th>
                                <th> Amount per palete </th>
                                <th> Ordered pallete count </th>
                                <th> Product amount sum </th>
                                <th> Perfomable now </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in shippingProducts" :key="product.id">
                                <td> {{product.name}} </td>
                                <td> {{product.price}} </td>
                                <td> {{product.amount_per_palete}} </td>
                                <td> {{product.pivot.pallete_count}} </td>
                                <td> {{product.amount_per_palete * product.pivot.pallete_count}} </td>
                                <td v-if="shipping.status == 'Completed'" class="text-success">Comleted</td>
                                <td v-else-if="shipping.status == 'Canceled'" class="text-danger">Canceled</td>
                                <td v-else :class="product.perfomable ? 'text-success': 'text-danger'"> {{product.perfomable ? "Yes" : "No"}} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="onClose">Close</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "shippingOrderInfoModal",

    data() {
        return {
            shippingProducts: [],
        }
    },

    props: {
        shipping: Object,
    },

    methods: {
        onClose: function() {
            $('#shippingOrderInfoModal').modal('hide');
            this.$el.remove();
        },

        getProductPerfoming: function() {
            this.$webService.get(`shipping/getShippingUnperfomableProducts/${this.shipping.id}`).then(response => {
                this.shippingProducts = response.data;
            }).catch(e => {
                console.error(e);
            });
        }
    },

    mounted() {
        this.getProductPerfoming();
    }

}
</script>

<style>
</style>

<template>
    <div class="modal fade" id="shippingOrderInfoModal" @click="onClose">
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
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in shipping.products" :key="product.id">
                                <td> {{product.name}} </td>
                                <td> {{product.price}} </td>
                                <td> {{product.amount_per_palete}} </td>
                                <td> {{product.pivot.pallete_count}} </td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "shippingOrderInfoModal",

    props: {
        shipping: Object,
    },

    methods: {
        onClose: function() {
            $('#shippingOrderInfoModal').modal('hide');
            this.$el.remove();
        }
    },

    mounted() {
        console.log(this.shipping);
    }

}
</script>

<style>
</style>
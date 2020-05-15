<template>
    <div class="modal fade" id="saleOrderInfoModal">
        <div class="modal-dialog modal-lg" @click.stop>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Shipping order: №{{}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"  @click="onClose">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-responsive-xl table-hover">
                        <thead>
                            <tr>
                                <th> Name </th>
                                <th> Standart price </th>
                                <th> Selling price </th>
                                <th> Count </th>
                                <th> Total </th>
                                <th> Perfomable now </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in saleProducts" :key="product.id">
                                <td> {{product.name}} </td>
                                <td> {{product.price}} </td>
                                <td> {{product.pivot.selling_price}} </td>
                                <td> {{product.pivot.product_count}} </td>
                                <td> {{product.pivot.product_count*product.pivot.selling_price}} </td>
                                <td :class="product.perfomable ? 'text-success': 'text-danger'"> {{product.perfomable ? "Yes" : "No"}} </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"  @click="onClose">Close</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "saleOrderInfoModal",

    data() {
        return {
            saleProducts: [],
        }
    },

    props: {
        sale: Object,
    },

    methods: {
        onClose: function() {
            $('#saleOrderInfoModal').modal('hide');
        },
    },

    watch: {
        sale: function() {
            if (this.sale) {
                this.$webService(`sale/getUnperfomableProducts/${this.sale.id}`).then(response => {
                    this.saleProducts = response.data;
                }).catch(response => {
                    console.error(response);
                });
            }
        },
    }
}
</script>

<style>

</style>
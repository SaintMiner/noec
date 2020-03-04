<template>
    <div class="mh-100">
        <addEnterpriseModal/>
        <div class="enterprise-table">
            <div class="d-flex justify-content-between">
                <h2>Enterprises</h2>
                <div>
                    <button class="btn btn-primary" @click="openAddEnterpriseModal">
                        <font-awesome-icon icon="plus"/>
                        <span class="ml-2">New</span>
                    </button>
                </div>
            </div>
            <div class="card enterprise-control-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Personal</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="enterprise in enterprises" :key="enterprise.id" @click="showEnterpriseStorage(enterprise.id)">
                            <td> {{enterprise.title}} </td>
                            <td> 10/10 </td>
                            <td> {{enterprise.location}} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="local-storage-table">
            <div class="d-flex justify-content-between">
                <h2>Local Storage</h2>
                <div>
                    <button class="btn btn-primary">
                        <font-awesome-icon icon="plus"/>
                        <span class="ml-2">Add product</span>
                    </button>
                </div>
            </div>

            <div class="card enterprise-control-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product name</th>
                            <th>Amount</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in enterpriseStorage" :key="product.id">
                            <td> {{product.name}} </td>
                            <td> {{product.amount}} </td>
                            <td> {{product.price}} </td>
                            <td> {{product.salePrice}} </td>
                        </tr>
                        <tr>
                            <td>Tomato</td>
                            <td>130</td>
                            <td>3.40</td>
                            <td>4.50</td>
                        </tr>
                        <tr>
                            <td>Watermelon</td>
                            <td>999</td>
                            <td>1.40</td>
                            <td>2.50</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>
import addEnterpriseModal from "./addEnterpriseModal";

export default {
    name: "enterprise-control",

    data() {
        return {
            enterprises: [],
            enterpriseStorage: [],
        }
    },

    components: {
        addEnterpriseModal,
    },

    methods: {
        openAddEnterpriseModal: function() {
            $('#addEnterpriseModal').modal('show')
        },

        showEnterpriseStorage: function(enterpriseID) {
            console.log(enterpriseID);
            this.$webService.get(`enterprise/getProducts/${enterpriseID}`).then(response => {
                this.enterpriseStorage = response.data;
            }).catch(e => {
                console.error(e);
            })
        }
    },

    mounted() {
        this.$webService.get("enterprise").then(response => {
            this.enterprises = response.data;
        }).catch(e => {
            console.error(e);
        })
    }
}
</script>

<style>
    .enterprise-table {
        height: 25%;
    }

    .local-storage-table {
        margin-top: 60px;
        height: 60%;
    }

    .enterprise-control-table {
        height: 100%;
        overflow: auto;
    }

    .mh-30 {
        max-height: 1%;
    }
</style>
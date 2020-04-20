<template>
<div ref="statusControl">
    <confirmModal id="confirmDeleteModal" 
        confirmText="Are you sure you want to delete these status?"
        @confirmAction="deleteStatus()"
    />
    <h1> Status control </h1>
    <hr>
    <div>
        <div class="d-flex justify-content-between">
            <h2>Statuses</h2>
            <div>
                <button class="btn btn-primary" @click="openAddStatusModal">
                    <font-awesome-icon icon="plus"/>
                    <span class="ml-2">Add Status</span>
                </button>
            </div>
        </div>

        <div class="card storage-control-table">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th> Name </th>
                        <th> Color </th>
                        <th> People count </th>
                        <th class="small-column"> Actions  </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="status in statuses" :key="status.id">
                        <td> {{status.name}} </td>
                        <td :class="{
                            'text-danger': status.color == 'Red', 
                            'text-warning': status.color == 'Yellow', 
                            'text-success': status.color == 'Green'
                        }">
                            {{status.color}}
                        </td>
                        <td> 1 </td>
                        <td class="d-flex ptr-button-cube text-center">
                            <button class="btn btn-primary mx-1" @click="openEditStatusModal(status)">
                                <font-awesome-icon icon="pen" class=""/>
                            </button>
                            <button class="btn btn-danger mx-1" @click="openDeleteConfirmModal(status)">
                                <font-awesome-icon icon="trash" class=""/>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>  
</div>
</template>

<script>
import Vue from "vue";
import statusControlModal from "./statusControlModal";
import confirmModal from "../../elements/confirmModal";

export default {
    name: "status-control",

    components: {
        statusControlModal,
        confirmModal,
    },

    data() {
        return {
            statuses: [],
            deletetingStatus: null,
        }
    },

    methods: {
        loadStatuses: function() {
            this.$webService.get("status").then(response => {
                this.statuses = response.data;
            }).catch(e => {
                console.error(e);
            });
        },
        
        openAddStatusModal: function() {
            let componentClass = Vue.extend(statusControlModal);
            let instance = new componentClass({
                propsData: {
                    loadStatuses: this.loadStatuses,
                    mode: "add",
                },
            });
            instance.$mount(); 
            this.$refs.statusControl.appendChild(instance.$el);
            $('#statusControlModal').modal('show');
        },

        openEditStatusModal: function(status) {
            let componentClass = Vue.extend(statusControlModal);
            let instance = new componentClass({
                propsData: {
                    loadStatuses: this.loadStatuses,
                    mode: "edit",
                    editingStatus: status,
                },
            });
            instance.$mount(); 
            this.$refs.statusControl.appendChild(instance.$el);
            $('#statusControlModal').modal('show');
        },

        openDeleteConfirmModal: function(status) {
            this.deletetingStatus = status;
            $('#confirmDeleteModal').modal('show');
        },

        deleteStatus: function() {
            this.$webService.delete(`status/${this.deletetingStatus.id}`).then(response => {
                this.deletetingStatus = null;
                this.loadStatuses();
                $('#confirmDeleteModal').modal('hide');
            }).catch(e => {
                console.error(e);
            })
        }
    },

    mounted() {
        this.loadStatuses();
    }
}
</script>

<style>

</style>

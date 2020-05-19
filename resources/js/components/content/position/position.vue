<template>
    <div ref="positionControl">
         <confirmModal id="confirmPositionRemoveModal" 
            confirmText="Are you sure you want to remove these position?"
            @confirmAction="removePosition"
        />
        <h1> Position control </h1>
        <hr>
        <div class="d-flex justify-content-between">
            <h2>Positions</h2>
            <div>
                <button class="btn btn-primary" @click="openAddPositionModal">
                    <font-awesome-icon icon="plus"/>
                    <span class="ml-2">New</span>
                </button>
            </div>
        </div>
        <div class="card department-control-table">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="small-column">#</th>
                        <th scope="col">Name</th>
                        <th scope="col" >Employee count</th>
                        <th scope="col" class="small-column">Actions</th>
                    </tr>
                </thead>

                <tbody class="">
                    <tr v-for="position in positions" :key="position.id">
                        <td> {{position.id}} </td>
                        <td> {{position.name}} </td>
                        <td> {{position.employee_count}} </td>
                        <td>
                            <div class="d-flex ptr-button-cube text-center">
                                <button class="btn btn-primary mx-1" @click="openEditPositionModal(position)">
                                    <font-awesome-icon icon="pen" class=""/>
                                </button>
                                <button class="btn btn-danger mx-1" @click="openRemovePositionConfirmModal(position)">
                                    <font-awesome-icon icon="trash" class=""/>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
                
            </table>
        </div>
    </div>
</template>

<script>
import Vue from "vue";
import confirmModal from "../../elements/confirmModal";
import positionControlModal from "./positionControlModal";
export default {
    name: "postion-control",

    components: {
        positionControlModal,
        confirmModal,
    },

    data() {
        return {
            positions: [],
            removingPosition: null,
        }
    },

    methods: {
        loadPositions: function() {
            this.$webService.get("position").then(response => {
                this.positions = response.data;
            }).catch(e => {
                console.error(e);
            });
        },

        openAddPositionModal: function() {
            let componentClass = Vue.extend(positionControlModal);
            let instance = new componentClass({
                propsData: {
                    loadPositions: this.loadPositions,
                    mode: "add",
                },
            });
            instance.$mount(); 
            this.$refs.positionControl.appendChild(instance.$el);
            $('#positionControlModal').modal('show');
        },

        openEditPositionModal: function(position) {
            let componentClass = Vue.extend(positionControlModal);
            let instance = new componentClass({
                propsData: {
                    editingPosition: position,
                    loadPositions: this.loadPositions,
                    mode: "edit",
                },
            });
            instance.$mount(); 
            this.$refs.positionControl.appendChild(instance.$el);
            $('#positionControlModal').modal('show');
        },

        openRemovePositionConfirmModal: function(position) {
            $('#confirmPositionRemoveModal').modal('show');
            this.removingPosition = position;
        },

        removePosition: function() {
            this.$webService.delete(`position/${this.removingPosition.id}`).then(response => {
                this.removePosition = null;
                this.loadPositions();
                $('#confirmPositionRemoveModal').modal('hide');
            }).catch(e => {
                console.error(e);
            });
        },
    },

    mounted() {
        this.loadPositions();
    },
    
    beforeMount() {
        let reqRoles = ["admin","director","hr_manager"];
        this.$store.commit("hasRole", reqRoles);
        if (!this.$store.state.hasPermission) {
            this.$router.push({ name: 'system' });
        }
    }
} 
</script>

<style>

</style>
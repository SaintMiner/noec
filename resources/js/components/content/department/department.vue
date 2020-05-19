<template>
    <div ref="departmentControl">
        <confirmModal id="confirmDepartmentRemoveModal" 
            confirmText="Are you sure you want to remove these department?"
            @confirmAction="removeDepartment(removingDepartment)"
        />
        <h1> Department control </h1>
        <hr>
        <div class="d-flex justify-content-between">
            <h2>Departments</h2>
            <div>
                <button class="btn btn-primary" @click="openAddNewDepartmentModal">
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
                    <tr v-for="department in departments" :key="department.id">
                        <td> {{department.id}} </td>
                        <td> {{department.name}} </td>
                        <td> {{department.employee_count}} </td>
                        <td>
                            <div class="d-flex ptr-button-cube text-center">
                                <button class="btn btn-primary mx-1" @click="openEditDepartmentModal(department)">
                                    <font-awesome-icon icon="pen" class=""/>
                                </button>
                                <button class="btn btn-danger mx-1" @click="openRemoveDeparmentModal(department)">
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
import departmentControlModal from "./departmentControlModal";
import confirmModal from "../../elements/confirmModal";

export default {
    name: "department",
    
    components: {
        departmentControlModal,
        confirmModal,
    },

    data() {
        return{ 
            departments: [],
            removingDepartment: null,
        }
    },

    methods: {
        loadDepartments: function() {
            this.$webService.get("department").then(response => {
                this.departments = response.data;
            }).catch(e => {
                console.error(e);
            });
        },

        openAddNewDepartmentModal: function() {
            let componentClass = Vue.extend(departmentControlModal);
            let instance = new componentClass({
                propsData: {
                    loadDepartments: this.loadDepartments,
                    mode: "add",
                },
            });
            instance.$mount(); 
            this.$refs.departmentControl.appendChild(instance.$el);
            $('#departmentControlModal').modal('show');
        },

        openEditDepartmentModal: function(department) {
            let componentClass = Vue.extend(departmentControlModal);
            let instance = new componentClass({
                propsData: {
                    loadDepartments: this.loadDepartments,
                    mode: "edit",
                    editingDepartment: department,
                },
            });
            instance.$mount(); 
            this.$refs.departmentControl.appendChild(instance.$el);
            $('#departmentControlModal').modal('show');
        },

        openRemoveDeparmentModal: function(department) {
            $('#confirmDepartmentRemoveModal').modal('show');
            this.removingDepartment = department;
        },

        removeDepartment: function(department) {
            this.$webService.delete(`department/${department.id}`).then(response => {
                console.log(response);
                this.loadDepartments();
            }).catch(e => {
                console.error(e);
            })
            this.removingDepartment = null;
            $('#confirmDepartmentRemoveModal').modal('hide');
        }
    },

    mounted() {
        this.loadDepartments();
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
    .table tr td {
        vertical-align: middle;
        word-break: break-word;
    }

    .department-control-table {
        max-height: 600px;
        overflow: auto;
    }
</style>
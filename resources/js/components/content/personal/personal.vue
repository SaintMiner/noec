<template>
    <div ref="personalControl">
        <personalCreateAccount id="personCreateAccountModal" :resource="actionResource" :reloadPersonal="getPersonal" :mode="'add'"/>
        <personalCreateAccount id="personEditAccountModal" :resource="actionResource" :reloadPersonal="getPersonal" :mode="'edit'"/>
        <confirmModal id="deleteResourceDataConfirm" 
            confirmText="Are you sure you want to delete this person ALL DATA?"
            @confirmAction="deleteResourceData(actionResource)"
        />
        <confirmModal id="deleteResourceAccountConfirm" 
            confirmText="Are you sure you want to delete this person account?"
            @confirmAction="deleteResourceAccount(actionResource)"
        />
        <h1> Personal control </h1>
        <hr>
        <div class="d-flex justify-content-between mb-2">
            <h2> Personal </h2>
            <div>
                <button class="btn btn-primary" @click="openAddNewResourceModal">
                    <font-awesome-icon icon="plus"/>
                    <span class="ml-2">New</span>
                </button>
            </div>
        </div>
        <div class="card">
                <div class="d-flex">
                <div class="">
                    <div class="input-group">
                        <input type="text" class="form-control personal-search" placeholder="Search by name, surname" v-model="searchFilterModel">
                    </div>
                </div>
                <div class="">
                    <select class="custom-select" v-model="departmentFilterModel">
                        <option value=0 selected>Choose Department</option>
                        <option :value="department.id" v-for="department in departments" :key="department.id">
                            {{department.name}}
                        </option>
                    </select>
                </div>
                <div class="">
                    <select class="custom-select" v-model="enterpriseFilterModel">
                        <option value=0 selected>Choose Enterprise</option>
                        <option :value="enterprise.id" v-for="enterprise in enterprises" :key="enterprise.id">
                            {{enterprise.title.length > 30 ? enterprise.title.slice(0, 30)+"..." : enterprise.title}}
                        </option>
                    </select>
                </div>
                <div class="">
                    <select class="custom-select" v-model="statusFilterModel">
                        <option value=0 selected>Choose Status</option>
                        <option :value="status.id" v-for="status in statuses" :key="status.id">
                            {{status.name}}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card mt-3 personal-table">
            <table class="table table-hover table-responsive mb-0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="vw-100">Name Surname</th>
                        <th scope="col" class="vw-100">Position</th>
                        <th scope="col" class="vw-100">Department</th>
                        <th scope="col" class="vw-100">Enterprise</th>
                        <th scope="col" class="vw-100">Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>

                <tbody class="">
                    <tr v-for="(person, index) in personal" :key="index" >
                        <th class="align-middle"> {{person.id}} </th>
                        <td> {{person.name}} {{person.surname}} </td>
                        <td> {{person.position}} </td>
                        <td> {{person.department}} </td>
                        <td> {{person.enterprise}} </td>
                        <td v-if="person.job_candidated" class="font-weight-bold">
                            Job candidate
                        </td>
                        <td v-else
                            :class="{
                                'text-danger': person.status.color == 'Red', 
                                'text-warning': person.status.color == 'Yellow', 
                                'text-success': person.status.color == 'Green'
                            }"
                        >
                            {{person.status.name}}
                        </td>
                        <td>
                            <div class="d-flex ptr-button-cube text-center">
                                <button class="btn btn-primary mx-1"  @click="openEditResourceModal(person)"><font-awesome-icon icon="pen" class=""/></button>
                                <button class="btn btn-secondary " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <font-awesome-icon icon="ellipsis-v" class=""/>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" @click="">Fire an employee</a>
                                    <a class="dropdown-item" href="#" @click="openEditAccountModal(person)" v-if="person.user">Edit account</a>
                                    <a class="dropdown-item" href="#" @click="openCreateAccountModal(person)" v-if="!person.user">Create account</a>
                                    <a class="dropdown-item text-danger" href="#" @click="openDeleteAccountConfirmModal(person)" v-else>Remove account</a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="#" @click="openDeleteDataModal(person)">Delete all data</a>
                                </div>
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
import personControlModal from "./personalControlModal";
import personalCreateAccount from "./personalCreateAccount";
import confirmModal from "../../elements/confirmModal"
export default {
    name: "personal",
    
    components: {
        personControlModal,
        personalCreateAccount,
        confirmModal,
    },

    data() {
        return {
            personal: [],
            enterprises: [],
            departments: [],
            statuses: [],
            enterpriseFilter: 0,
            departmentFilter: 0,
            statusFilter: 0,
            searchFilter: "",
            actionResource: null,
        }
    },

    computed: {
        enterpriseFilterModel: {
            set: function(value) {
                this.enterpriseFilter = value;
                this.getPersonal();
            },

            get: function() {
                return this.enterpriseFilter;
            }
        },

        departmentFilterModel: {
            set: function(value) {
                this.departmentFilter = value;
                this.getPersonal();
            },

            get: function() {
                return this.departmentFilter;
            }
        },

        searchFilterModel: {
            set: function(value) {
                this.searchFilter = value;
                this.getPersonal();
            },

            get: function() {
                return this.searchFilter;
            }
        },

        statusFilterModel: {
            set: function(value) {
                this.statusFilter= value;
                this.getPersonal();
            },

            get: function() {
                return this.statusFilter;
            }
        }
    },
    
    methods: {
        getPersonal: function() {
             this.$webService.get("resource", {
                params: {
                    enterpriseFilter: this.enterpriseFilter, 
                    departmentFilter: this.departmentFilter,
                    searchFilter: this.searchFilter,
                    statusFilter: this.statusFilter,
                }
             }).then(response => {
                console.log(response.data);
                this.personal = response.data;
            }).catch(e => {
                console.log(e);
            });
        },

        getEnterprises: function() {
            this.$webService.get("enterprise").then(response => {
                this.enterprises = response.data;
            }).catch(e => {
                console.error(e);
            });
        },

        getDepartments: function() {
            this.$webService.get("department").then(response => {
                this.departments = response.data;
            }).catch(e => {
                console.error(e);
            });
        },

        getStatuses: function() {
            this.$webService.get("status").then(response => {
                this.statuses = response.data;
            }).catch(e => {
                console.error(e);
            });
        },

        openAddNewResourceModal: function() {
            let componentClass = Vue.extend(personControlModal);
            let instance = new componentClass({
                propsData: {
                    loadResources: this.getPersonal,
                    mode: "add",
                },
            });
            instance.$mount(); 
            this.$refs.personalControl.appendChild(instance.$el);
            $('#personalControlModal').modal('show');
        },

        openEditResourceModal: function(resource) {
            let componentClass = Vue.extend(personControlModal);
            let instance = new componentClass({
                propsData: {
                    loadResources: this.getPersonal,
                    mode: "edit",
                    editingResource: resource
                },
            });
            instance.$mount(); 
            this.$refs.personalControl.appendChild(instance.$el);
            $('#personalControlModal').modal('show');
        },

        openCreateAccountModal: function(resource) {
            this.actionResource = resource;
            $('#personCreateAccountModal').modal('show');
        },

        openEditAccountModal: function(resource) {
            this.$webService.post("auth/me").then(repsonse => {
                if (repsonse.data.id != resource.user.id) {
                    this.actionResource = resource;
                    $('#personEditAccountModal').modal('show');
                } else {
                    alert("You can't edit your account!");
                }
            }).catch(e => {
                console.error(e);
            });
        },

        openDeleteDataModal: function(resource) {
            this.actionResource = resource;
            $('#deleteResourceDataConfirm').modal('show');
        },

        openDeleteAccountConfirmModal: function(resource) {
            this.actionResource = resource;
            $('#deleteResourceAccountConfirm').modal('show');
        },

        deleteResourceData: function(resource) {
            this.$webService.delete(`resource/${resource.id}`).then(repsonse => {
                this.actionResource = null;
                this.getPersonal();
                $('#deleteResourceDataConfirm').modal('hide');
            }).catch(e => {
                console.error(e);
            });
        },

        deleteResourceAccount: function(resource) {
            this.$webService.delete(`user/${resource.user.id}`).then(response => {
                this.actionResource = null;
                this.getPersonal();
                $('#deleteResourceAccountConfirm').modal('hide');
            }).catch(e => {
                console.error(e);
            });
        }

        
    },

    watch: {
        
    },

    mounted() {
        this.getPersonal();
        this.getEnterprises();
        this.getDepartments();
        this.getStatuses();
        localStorage.setItem("testObj", new Object("kek"));
        console.log(localStorage.getItem("testObj"));
    },
}
</script>

<style scoped>
    .personal-search {
        width: 400px;
    }

    .personal-table {
        height: 70vh;
    }

    .ptr-button-cube button {
        width: 40px;
        height: 40px;
    }
</style>
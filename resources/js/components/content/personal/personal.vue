<template>
    <div>
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
                            {{enterprise.title}}
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
                        <th> {{person.id}} </th>
                        <td> {{person.name}} {{person.surname}} </td>
                        <td> {{person.position}} </td>
                        <td> {{person.department}} </td>
                        <td> {{person.enterprise}} </td>
                        <td> {{person.status}} </td>
                        <td>
                            <div class="d-flex ptr-button-cube text-center">
                                <button class="btn btn-primary mx-1"><font-awesome-icon icon="pen" class=""/></button>
                                <button class="btn btn-primary mx-1"><font-awesome-icon icon="info" class=""/></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
                
            </table>
        </div>
    </div>
</template>

<script>


export default {
    name: "personal",
    
    components: {
        
    },

    data() {
        return {
            personal: [],
            enterprises: [],
            departments: [],

            enterpriseFilter: 0,
            departmentFilter: 0,
            statusFilter: 0,
            searchFilter: "",
            
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
            })
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
    },

    watch: {
        
    },

    mounted() {
        this.getPersonal();
        this.getEnterprises();
        this.getDepartments();
        this.getStatuses();
    },
}
</script>

<style scoped>
    .personal-search {
        width: 400px;
    }

    .personal-table {
        height: 96%;
    }

    .ptr-button-cube button {
        width: 40px;
        height: 40px;
    }
</style>
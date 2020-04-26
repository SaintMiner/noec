<template>
    <div class="modal fade" id="personalControlModal" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog" >
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" v-if="mode == 'add'"> Add new person </h5>
            <h5 class="modal-title" v-else-if="mode == 'edit'"> Edit person data </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label class="col-form-label">* Name</label>
                    <input type="text"  class="form-control"
                    :class="{'is-invalid': invalidName && focused.name, 'is-valid': !invalidName && focused.name}"  
                    v-model="newResource.name" 
                    @focus="focused.name = true">
                    <div class="invalid-feedback"> {{errors.name}} </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">* Surname</label>
                    <input type="text"  class="form-control"
                    :class="{'is-invalid': invalidSurname && focused.surname, 'is-valid': !invalidSurname && focused.surname}"  
                    v-model="newResource.surname" 
                    @focus="focused.surname = true">
                    <div class="invalid-feedback"> {{errors.name}} </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" v-model="newResource.job_candidated">
                    <label class="form-check-label">
                        Set as job candidate
                    </label>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-form-label"> * Enterprise </label> 
                    <select 
                        v-model="selectEnterpriseModel"
                        class="custom-select custom-select mb-3"
                        :class="{'is-invalid': focused.enterprise && !newResource.enterprise_id, 'is-valid': newResource.enterprise_id}"
                        @focus="focused.enterprise = true"
                        :disabled="newResource.job_candidated" 
                    >
                        <option :value="null" selected>Select Enterprise</option>
                        <option v-for="enterprise in enterprises" :key="enterprise.id" :value="enterprise.id"> {{enterprise.title}} </option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="col-form-label"> Department <small v-if="!newResource.enterprise_id">(select enterprise)</small> </label> 
                    <div class="spinner-border spinner-border-sm" role="status" v-if="loading.department">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <select 
                        v-model="newResource.department_id"
                        class="custom-select custom-select mb-3"
                        :disabled="newResource.job_candidated || !newResource.enterprise_id || loading.department" 
                    >
                        <option :value="null" selected>Select department</option>
                        <option v-for="department in departments" :key="department.id" :value="department.id"> {{department.name}} </option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="col-form-label" > * Position <small v-if="!newResource.enterprise_id">(select enterprise)</small> </label> 
                     <div class="spinner-border spinner-border-sm" role="status" v-if="loading.position">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <select 
                        v-model="newResource.position_id"
                        class="custom-select custom-select mb-3"
                        :class="{'is-invalid': focused.position && !newResource.position_id, 'is-valid': newResource.position_id}"
                        @focus="focused.position = true"
                        :disabled="newResource.job_candidated || !newResource.enterprise_id || loading.position" 
                    >
                        <option :value="null" selected>Select position</option>
                        <option v-for="position in positions" :key="position.id" :value="position.id"> {{position.name}} </option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="col-form-label" > * Status </label> 
                    <select 
                        v-model="newResource.status_id"
                        class="custom-select custom-select mb-3"
                        :class="{'is-invalid': focused.status && !newResource.status_id, 'is-valid': newResource.status_id}"
                        @focus="focused.status = true"
                        :disabled="newResource.job_candidated"
                     >
                        <option :value="null" selected>Select status</option>
                        <option v-for="status in statuses" 
                            :key="status.id" 
                            :value="status.id"
                            :class="{
                                'text-danger': status.color == 'Red', 
                                'text-warning': status.color == 'Yellow', 
                                'text-success': status.color == 'Green'
                            }"
                        > {{status.name}} </option>
                    </select>
                </div>
                <small id="emailHelp" class="form-text text-muted"> * - Required fields </small>

            </form>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="close">Close</button>
                <button v-if="mode == 'add'" type="button" class="btn btn-primary" :disabled="!validated" @click="onAdd">Add</button>
                <button v-else-if="mode == 'edit'" type="button" class="btn btn-primary" :disabled="!validated" @click="onEdit">Edit</button>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    name: "personalControlModal",

    props: {
        loadResources: {type: Function},
        mode: {type: String, default: "add"},
        editingResource: {type: Object, default: null},
    },

    data() {
        return {

            departments: [],
            statuses: [],
            positions: [],
            enterprises: [],

            newResource: {
                name: "",
                surname: "",
                department_id: null,
                enterprise_id: null,
                status_id: null,
                position_id: null,
                job_candidated: false,
            },

            focused: {
                name: false,
                surname: false,
                enterprise: false,
                status: false,
                position: false,
            },

            errors: {
                name: "",
                surname: "",
            },

            loading: {
                department: false,
                position: false,
            },

        }
    },

    computed: {
        
        selectEnterpriseModel: {
            set: function(value) {
                if (value != null) {
                    this.getDepartments(value);
                    this.getPositions(value);
                } else {
                    this.departments = [];
                    this.positions = [];
                }
                this.newResource.enterprise_id = value;
            },

            get: function() {
                return this.newResource.enterprise_id;
            }
        },

        invalidName: function() {
            this.errors.name = ""
            let name = this.newResource.name
            if (!(name.length >= 1 && name.length <= 50)) {
                this.errors.name = "The name must contain at least 1 and not more then 50 symbols";
                return true;
            }
            if (!name.match(/^[a-zA-Z]*$/)) {
                this.errors.name = "The name must contain only latin letters"
                return true;
            }
            return false;

        },

        invalidSurname: function() {
            this.errors.surname = ""
            let surname = this.newResource.surname
            if (!(surname.length >= 1 && surname.length <= 50)) {
                this.errors.surname = "The surname must contain at least 1 and 50 symbols";
                return true;
            }
            if (!surname.match(/^[a-zA-Z]*$/)) {
                this.errors.surname = "The surname must contain only latin letters"
                return true;
            }
            return false;
        },

        validated: function() {
            let resource = this.newResource;
            return (!this.invalidName && !this.invalidSurname && (this.newResource.job_candidated || (resource.enterprise_id && resource.status_id && resource.position_id && resource.position_id)));
        }
    },
    
    methods: {

        getEnterprises: function() {
            
            this.$webService.get("enterprise").then(response => {
                this.enterprises = response.data;
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

        getPositions: function(enterprise) {
            this.loading.position = true;
            this.$webService.get(`enterprise/getPositions/${enterprise}`).then(response => {
                this.positions = response.data;
                this.loading.position = false;
            }).catch(e => {
                console.error(e);
            });
        },

        getDepartments: function(enterprise) {
            this.loading.department = true;
            this.$webService.get(`enterprise/getDepartments/${enterprise}`).then(response => {
                this.departments = response.data;
                this.loading.department = false;
            }).catch(e => {
                console.error(e);
            });
        },

        close: function() {
            $('#personalControlModal').modal('hide');
            this.$el.remove();
        },

        onAdd: function() {
            this.$webService.post("resource", this.newResource).then(response => {
                this.loadResources();
                this.close();
            }).catch(e => {
                console.error(e);
            });
        },

        onEdit: function() {
            this.$webService.put(`resource/${this.editingResource.id}`, this.newResource).then(response => {
                this.loadResources();
                this.close();
            }).catch(e => {
                console.error(e);
            });
        },

        getEditingResource: function() {
            this.$webService.get(`resource/${this.editingResource.id}`).then(response => {
                let resource = response.data;
                this.newResource = {
                    name: resource.name,
                    surname: resource.surname,
                    enterprise_id: resource.enterprise_id,
                    position_id: resource.position_id,
                    status_id: resource.status_id,
                    department_id: resource.department_id,
                }
            }).catch(e => {
                console.error(e);
            })
        }
    },

    mounted() {
        this.getEnterprises();
        this.getStatuses();
        if (this.mode == "edit") {
            this.getEditingResource();
        }
    }
}
</script>

<style>

</style>
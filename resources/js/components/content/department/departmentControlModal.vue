<template>
    <div class="modal fade" id="departmentControlModal" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog" >
        <div class="modal-content">
        <div class="modal-header">
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label class="col-form-label">Department name</label>
                    <input type="text"  class="form-control"
                    :class="{'is-invalid': invalidName && focused.name, 'is-valid': !invalidName && focused.name}"  
                    v-model="newDepartment.name" 
                    @focus="focused.name = true">
                    <div class="invalid-feedback"> {{errors.name}} </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label mb-2 font-weight-bold"> Add departament to enterprises </label>
                    <ul>
                        <li v-for="enterprise in enterprises" :key="enterprise.id" class="d-flex justify-content-between">
                            <div>
                                <input class="form-check-input" type="checkbox" v-model="enterprise.checked" @change="onCheckedChange"> 
                                <label class="form-check-label text-break"> {{enterprise.title.length > 30 ? enterprise.title.slice(0, 30)+"..." : enterprise.title}} </label> 
                            </div> 
                            <div>
                                <select class="custom-select custom-select mb-3" :disabled="!enterprise.checked" v-model="enterprise.manager">
                                    <option :value="null" selected>Select manager</option>
                                    <option v-for="resource in enterprise.resources" :key="resource.id" :value="resource.id"> {{resource.name}} {{resource.surname}}</option>
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>
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
    name: "departmentControlModal",

    props: {
        loadDepartments: {type: Function},
        mode: {type: String, default: "add"},
        editingDepartment: {type: Object, default: null},
    },

    data() {
        return {
            newDepartment: {
                name: "",
            },

            focused: {
                name: false
            },

            errors: {
                name: "",
            },

            enterprises: [],
            invalidConnectedEnterprises: true,
        }
    },

    computed: {
        invalidName: function() {
            let depName = this.newDepartment.name;
            this.errors.name = "";
            if (!(depName.length >= 3 && depName.length <= 255)) {
                this.errors.name = "Department name must contain at least 3 and maximum 255 symbols";
                return true;
            }
        },

        validated: function() {
            return (!this.invalidName && !this.invalidConnectedEnterprises);
        }
    },

    methods: {
        getEnterprises: function() {
            this.$webService.get("enterprise/getEnterprisesWithResources").then(response => {
                response.data.forEach(enterprise => {enterprise.manager = null; enterprise.checked = false;});
                this.enterprises = response.data;
            }).catch(e => {
                console.error(e);
            });
        },

        getConnectedEnterprises: function() {
            this.$webService.get(`department/getEnterprises/${this.editingDepartment.id}`).then(response => {
                this.enterprises = response.data;
                this.onCheckedChange();
            }).catch(e => {
                console.error(e);
            });

            
        },

        onCheckedChange: function() {
            let checked = this.enterprises.filter(enterprise => enterprise.checked);
            this.invalidConnectedEnterprises = checked.length ? false : true;
        },

        onAdd: function() {
            if (this.validated) {
                let checked = this.enterprises.filter(enterprise => enterprise.checked);
                let data = {
                    name: this.newDepartment.name,
                    enterprises: checked.map(enterprise => {return {enterprise_id: enterprise.id, manager: enterprise.manager}}),
                }
                console.log(data.conEnterprise);
                this.$webService.post("department", data).then(response => {
                    console.log(response);
                    this.loadDepartments();
                    this.close();
                }).catch(e => {
                    console.error(e);
                });
            }
        },

        onEdit: function() {
            if (this.validated) {
                let checked = this.enterprises.filter(enterprise => enterprise.checked);
                let data = {
                    name: this.newDepartment.name,
                    enterprises: checked.map(enterprise => {return {enterprise_id: enterprise.id, manager: enterprise.manager}}),
                }
                console.log(data.conEnterprise);
                this.$webService.put(`department/${this.editingDepartment.id}`, data).then(response => {
                    console.log(response);
                    this.loadDepartments();
                    this.close();
                }).catch(e => {
                    console.error(e);
                });
            }
        },

        close: function() {
            $('#departmentControlModal').modal('hide');
            this.$el.remove();
        }
    },

    mounted() {
        if (this.mode == "edit") {
            this.getConnectedEnterprises();
            this.newDepartment.name = this.editingDepartment.name;
            
        } else if(mode == "add"){
            this.getEnterprises();
        }
    },
}
</script>

<style>

</style>
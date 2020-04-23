<template>
    <div class="modal fade" id="positionControlModal" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog" >
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" v-if="mode == 'add'"> Add new position </h5>
            <h5 class="modal-title" v-else-if="mode == 'edit'"> Edit position </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label class="col-form-label">Position name</label>
                    <input type="text"  class="form-control"
                    :class="{'is-invalid': invalidName && focused.name, 'is-valid': !invalidName && focused.name}"  
                    v-model="position.name" 
                    @focus="focused.name = true">
                    <div class="invalid-feedback"> {{errors.name}} </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label mb-2 font-weight-bold"> Add position to enterprises </label>
                    <ul>
                        <li v-for="enterprise in enterprises" :key="enterprise.id" class="d-flex justify-content-between">
                            <div>
                                <input class="form-check-input" type="checkbox" v-model="enterprise.checked" @change="onCheckedChange"> 
                                <label class="form-check-label text-break"> {{enterprise.title.length > 30 ? enterprise.title.slice(0, 30)+"..." : enterprise.title}} </label> 
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
    name: "positionControlModal",

    props: {
        loadPositions: {type: Function},
        mode: {type: String, default: "add"},
        editingPosition: {type: Object, default: null},
    },
    
    data() {
        return {
            position: {
                name: ""
            },

            focused: {
                name: false,
            },

            errors: {
                name: ""
            },

            enterprises: [],
            invalidConnectedEnterprises: true,
        }
    },

    computed: {
        invalidName: function() {
            this.errors.name = ""
            let name = this.position.name
            if (!(name.length >= 3 && name.length <= 255)) {
                this.errors.name = "The name must contain at least 1 and not more then 255 symbols";
                return true;
            }
            return false;
        },
        validated: function() {
            return (!this.invalidName && !this.invalidConnectedEnterprises);
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

        getConnectedEnterprises: function() {
            this.$webService.get(`position/getEnterprises/${this.editingPosition.id}`).then(response => {
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
            let checked = this.enterprises.filter(enterprise => enterprise.checked);
            let data = {name: this.position.name, enterprises: checked.map(enterprise => enterprise.id)};
            this.$webService.post("position", data).then(response => {
                this.loadPositions();
                this.close();
            }).catch(e => {
                console.error(e);
            });
        },

        onEdit: function() {
            let checked = this.enterprises.filter(enterprise => enterprise.checked);
            let data = {name: this.position.name, enterprises: checked.map(enterprise => enterprise.id)};
            this.$webService.put(`position/${this.editingPosition.id}`, data).then(response => {
                this.loadPositions();
                this.close();
            }).catch(e => {
                console.error(e);
            });
        },

        close: function() {
            $('#positionControlModal').modal('hide');
            this.$el.remove();
        },
    },

    mounted() {
        if (this.mode == "edit") {
            console.log(this.editingPosition);
            this.getConnectedEnterprises();
            this.position.name = this.editingPosition.name;
        } else if(this.mode == "add"){
            this.getEnterprises();
        }
    }
}
</script>

<style>

</style>
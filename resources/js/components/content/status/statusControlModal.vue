<template>
  <div class="modal fade" id="statusControlModal" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog" >
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" v-if="mode == 'add'"> Add new status </h5>
            <h5 class="modal-title" v-else-if="mode == 'edit'"> Edit status data </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label class="col-form-label"> Name </label>
                    <input type="text"  class="form-control"
                    :class="{'is-invalid': invalidName && focused.name, 'is-valid': !invalidName && focused.name}"  
                    v-model="status.name" 
                    @focus="focused.name = true">
                    <div class="invalid-feedback"> {{errors.name}} </div>
                </div>
                
                <div class="form-group">
                    <label class="col-form-label"> Color </label> 
                    <select 
                        v-model="status.color"
                        class="custom-select custom-select mb-3" 
                    >
                        <option :value="null" selected>Select color</option>
                        <option value="Red" selected> Red </option>
                        <option value="Yellow" selected> Yellow </option>
                        <option value="Green" selected> Green </option>
                    </select>
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
    name: "statusControlModal",

    props: {
        loadStatuses: {type: Function},
        mode: {type: String, default: "add"},
        editingStatus: {type: Object, default: null},
    },

    data() {
        return {
            status: {
                name: "",
                color: null,
            },

            focused: {
                name: false,
            },

            errors: {
                name: "",
            }
        }
    },

    computed: {
        invalidName: function() {
            let name = this.status.name;
            this.errors.name = "";
            if (name.length < 1 || name.length > 60) {
                this.errors.name = "The name must contain at least 1 and not more then 60 symbols";
                return true;
            }
        },

        validated: function() {
            return (!this.invalidName);
        }
    },

    methods: {

        onEdit: function() {
            this.$webService.put(`status/${this.editingStatus.id}`, this.status).then(response => {
                this.loadStatuses();
                this.close();
            }).catch(e => {
                console.error(e);
            });
        },

        onAdd: function() {
            this.$webService.post(`status`, this.status).then(response => {
                this.loadStatuses();
                this.close();
            }).catch(e => {
                console.error(e);
            });
        },

        close: function() {
            $('#statusControlModal').modal('hide');
            this.$el.remove();
        },
    },

    mounted() {
        if (this.mode == "edit") {
            this.status = this.editingStatus;
        }
    },
}
</script>

<style>

</style>
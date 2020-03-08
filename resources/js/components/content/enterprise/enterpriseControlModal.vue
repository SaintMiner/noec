<template>
    <div class="modal fade" id="addEnterpriseModal" tabindex="-1">
    <div class="modal-dialog" >
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" v-if="editMode">Edit enterprise</h5>
            <h5 class="modal-title" v-else>Add new enterprise</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label class="col-form-label">Enterprise title</label>
                    <input type="text"  class="form-control"
                    :class="{'is-invalid': invalidTitle && focused.title, 'is-valid': !invalidTitle && focused.title}"  
                    v-model="newEnterprise.title" 
                    @focus="focused.title = true">
                    <div class="invalid-feedback"> {{errors.invalidTitle}} </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Enterprise location</label>
                    <input type="text" class="form-control" 
                    :class="{'is-invalid': invalidLocation && focused.location, 'is-valid': !invalidLocation && focused.location}"
                    v-model="newEnterprise.location"
                    @focus="focused.location = true">
                    <div class="invalid-feedback"> {{errors.invalidLocation}} </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">
                        Enterprise registration number
                        <div v-if="isRegNumberFree == null" class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </label>
                    <input type="text" class="form-control" 
                    :class="{'is-invalid': (!isRegNumberFree || invalidRegNumber) && focused.regNumber, 'is-valid': !invalidRegNumber && focused.regNumber && isRegNumberFree}"
                    v-model="newEnterprise.regNumber"
                    @focus="focused.regNumber = true">
                    <div class="invalid-feedback"> {{errors.invalidRegNumber}} </div>
                </div>
                <div>
                    <label class="col-form-label"> Connect storages </label>
                    <ul>
                        <li v-for="storage in storages" :key="storage.id"> 
                            <input class="form-check-input" type="checkbox" v-model="storage.checked"> <label class="form-check-label"> {{storage.title}} </label> 
                        </li>
                    </ul>
                </div>
            </form>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-if="!editMode" type="button" class="btn btn-primary" :disabled="!validated" @click="addEnterprise">Add</button>
                <button v-else type="button" class="btn btn-primary" :disabled="!validated" @click="editEnterprise">Edit</button>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    name: "enterpriseControlModal",

    props: {
        editMode: {type: Boolean, default: false},
        editingEnterprise: {type: Object, default: null},
        enterprise: Object,
    },

    data() {
        return {
            storages: [],
            newEnterprise: {
                title: "",
                location: "",
                regNumber: "",
            },
            errors: {
                invalidTitle: "",
                invalidLocation: "",
                invalidRegNumber: "",
            },
            focused: {
                title: false,
                location: false,
                regNumber: false,
            },
            isRegNumberFree: true,
        }
    },

    computed: {
        invalidTitle: function() {
            if (this.newEnterprise.title.length >= 3 && this.newEnterprise.title.length <= 255) {
                return false;
            } else {
                this.errors.invalidTitle = "Title must contain more than 2 and less then 256 symbols";
                return true;
            }
        },

        invalidLocation: function() {
            if (this.newEnterprise.location.length >= 3 && this.newEnterprise.location.length <= 255) {
                
                return false;
            } else {
                this.errors.invalidLocation = "Location must contain more than 2 and less then 256 symbols";
                return true;
            }
        },

        invalidRegNumber: function() {
            if ((String(this.newEnterprise.regNumber).length == 11) && !isNaN(Number(this.newEnterprise.regNumber))) {
                if ((this.editMode && this.newEnterprise.regNumber != this.editingEnterprise.registration_number) || !this.editMode) {
                    this.isRegNumberFree = null;
                    this.$webService.get(`enterprise/isRegNumberFree/${this.newEnterprise.regNumber}`).then(response => {
                        let isFree = response.data.isFree;
                        if (!isFree) {
                            this.isRegNumberFree = true;
                        } else {
                            this.isRegNumberFree = false;
                            this.errors.invalidRegNumber = "This registration number already taken";
                        }
                    });
                }
            } else {
                this.errors.invalidRegNumber = "Registration number must contain 11 number";
                return true;
            }
        },

        validated: function() {
            return (!this.invalidLocation && !this.invalidTitle && !this.invalidRegNumber);
        }
    },

    methods: {
        addEnterprise: function() {
            let checkedStorages = this.storages.filter(storage => storage.checked);
            checkedStorages = checkedStorages.map(storage => storage.id);
            let data = {
                title: this.newEnterprise.title,
                location: this.newEnterprise.location,
                registration_number: this.newEnterprise.regNumber,
                storages: checkedStorages,
            }
            this.$webService.post("enterprise", data).then(response => {
                if(response.status == 201) {
                    this.clearModalData();
                    $('#addEnterpriseModal').modal('hide');
                    this.$emit("loadEnterPrises");
                }
            }).catch(e => {
                console.log(e);
            });
        },

        editEnterprise: function() {
            let checkedStorages = this.storages.filter(storage => storage.checked);
            checkedStorages = checkedStorages.map(storage => storage.id);
            let data = {
                title: this.newEnterprise.title,
                location: this.newEnterprise.location,
                registration_number: this.newEnterprise.regNumber,
                storages: checkedStorages,
            }
            this.$webService.put(`enterprise/${this.editingEnterprise.id}`, data).then(response => {
                if(response.status == 201) {
                    this.clearModalData();
                    $('#addEnterpriseModal').modal('hide');
                    this.$emit("loadEnterPrises");
                }
            }).catch(e => {
                console.log(e);
            });
        },

        clearModalData: function() {
            this.newEnterprise.title = "";
            this.newEnterprise.location = "";
            this.newEnterprise.regNumber = "";
            this.focused.title = false;
            this.focused.location = false;
            this.focused.regNumber = false;
            this.storages.forEach(storage => {
                storage.checked = false;
            });
        },

    },

    watch: {
        editingEnterprise: function() {
            this.clearModalData();
            if (this.editMode) {
                this.newEnterprise = {
                    title: this.editingEnterprise.title,
                    location: this.editingEnterprise.location,
                    regNumber: this.editingEnterprise.registration_number,
                }
                this.$webService.get(`enterprise/getStorages/${this.editingEnterprise.id}`).then(response => {
                    let enterpriseConnectedStorages = response.data;
                    enterpriseConnectedStorages.forEach(enterpriseStorage => {
                        let vstorage = this.storages.find(storage => {
                            if (storage.id == enterpriseStorage.storage_id) {
                                storage.checked = true;
                            }
                        });
                    });
                }).catch(e => {
                    console.error(e);
                })
            }
        }
    },

    mounted() {
        this.$webService.get("storage").then(response => {
            response.data.forEach(storage => storage.checked = false);
            this.storages = response.data;
        }).catch(e => {
            console.error(e);
        });
    }
}
</script>

<style>

</style>
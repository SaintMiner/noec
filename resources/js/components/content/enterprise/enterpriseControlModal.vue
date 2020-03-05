<template>
    <div class="modal fade" id="addEnterpriseModal" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add new enterprise</h5>
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
                    <label class="col-form-label">Enterprise registration number</label>
                    <input type="text" class="form-control" 
                    :class="{'is-invalid': invalidRegNumber && focused.regNumber, 'is-valid': !invalidRegNumber && focused.regNumber}"
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
                <button type="button" class="btn btn-primary" :disabled="!validated" @click="addEnterprise">Add</button>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    name: "enterpriseControlModal",

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
            }
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
            if (this.newEnterprise.regNumber.length == 11 && !isNaN(this.newEnterprise.regNumber)) {
                return false;
            } else {
                this.errors.invalidRegNumber = "Location must contain 11 number";
                return true;
            }
        },

        validated: function() {
            return (!this.invalidLocation && !this.invalidTitle);
        }
    },

    methods: {
        addEnterprise: function() {
            let checkedStorages = this.storages.filter(storage => storage.checked);
            checkedStorages = checkedStorages.map(storage => storage.id);
            let data = {
                title: this.newEnterprise.title,
                location: this.newEnterprise.location,
                regNumber: this.newEnterprise.regNumber,
                storages: checkedStorages,
            }
            this.$webService.post("enterprise", data).then(response => {
                console.log(response);
            })
        }
    },

    mounted() {
        this.$webService.get("storage").then(response => {
            response.data.forEach(storage => storage.checked = false);
            this.storages = response.data;
        }).catch(e => {
            console.error(e);
        })
    }
}
</script>

<style>

</style>
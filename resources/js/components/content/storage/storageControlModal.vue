<template>
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-if="!editMode">Add new storage</h5>
                    <h5 class="modal-title" v-else>Edit storage</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label class="col-form-label">Storage title</label>
                            <input type="text"  class="form-control" 
                                :class="{'is-invalid': !titleValidator && focused.title, 
                                        'is-valid': titleValidator && focused.title}"
                                v-model="storage.title"
                                @focus="focused.title = true"
                            >
                            <div class="invalid-feedback"> {{error.title}} </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Storage location</label>
                            <input type="text"  class="form-control" 
                                :class="{'is-invalid': !locationValidator && focused.location, 
                                        'is-valid': locationValidator && focused.location}"
                                v-model="storage.location"
                                @focus="focused.location = true"
                            >
                            <div class="invalid-feedback"> {{error.location}} </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Storage palete maximum capacity</label>
                            <input type="text"  class="form-control"
                                :class="{'is-invalid': !paleteCapacityValidator && focused.palete_capacity, 
                                        'is-valid': paleteCapacityValidator && focused.palete_capacity}"
                                v-model="storage.palete_capacity" 
                                @focus="focused.palete_capacity = true"
                            >
                            <div class="invalid-feedback"> {{error.palete_capacity}} </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Storage class</label>
                            <select class="custom-select" v-model="storage.class"
                                :class="{'is-invalid': !classValidator, 'is-valid': classValidator}"
                            >
                                <option value="D" selected>D</option>
                                <option value="C">C</option>
                                <option value="B">B</option>
                                <option value="A">A</option>
                            </select>
                            <div class="invalid-feedback"> {{error.class}} </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" v-if="!editMode" :disabled="!validated" @click="addStorage">Add</button>
                    <button type="button" class="btn btn-primary" v-else :disabled="!validated" @click="editStorage">Edit</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "StorageControlModal",

    props: {
        editMode: {type: Boolean, default: false},
        editingStorage: {type: Object, default: null},
    },

    data() {
        return {
            storage: {
                title: "",
                location: "",
                palete_capacity: "0",
                class: "D",
            },
            error: {
                title: "",
                location: "",
                palete_capacity: "",
                class: "",
            },
            focused: {
                title: false,
                location: false,
                palete_capacity: false,
            },
        }
    },

    computed: {
        locationValidator: function() {
            let location = this.storage.location
            if (location.length >= 3 && location.length <= 255) {
                return true;
            } else {
                this.error.location = "Storage location must contain more than 2 and less than 256 symbols"

                return false;
            }
        },

        titleValidator: function() {
            let title = this.storage.title
            if (title.length >= 3 && title.length <= 255) {
                return true;
            } else {
                this.error.title = "Storage title must contain more than 2 and less than 256 symbols"
                return false;
            }
        },

        paleteCapacityValidator: function() {
            let paleteCapacity = this.storage.palete_capacity
            if (!isNaN(paleteCapacity) && String(paleteCapacity).length > 0 && Number(paleteCapacity) > 0 && Number(paleteCapacity) % 1 == 0) {
                return true;
            } else {
                this.error.palete_capacity = "Storage palete amount must be a positive integer numbers and more than 0!"
                return false;
            }
        },

        classValidator: function() {
            let storageClass = String(this.storage.class);
            if (storageClass == "A" || storageClass == "B" || storageClass == "C" || storageClass == "D") {
                return true;
            } else {
                this.error.class = "Storage class must be only A, B, C or D class"
                return false;
            }
        },

        validated: function() {
            return (this.titleValidator && this.locationValidator && this.paleteCapacityValidator);
        }
    },

    watch: {
        editingStorage: function() {
            this.clearData();
            if (this.editMode) {
                this.storage = {
                    title: this.editingStorage.title,
                    location: this.editingStorage.location,
                    class: this.editingStorage.class,
                    palete_capacity: this.editingStorage.palete_capacity,
                }
            }
        }
    },

    methods: {
        addStorage: function() {
            this.$webService.post("storage", this.storage).then(response => {
                if (response.status == 201) {
                    this.$emit("loadStorages");
                    $('#storageControlModal').modal('hide');
                    this.clearData();
                }
            }).catch(e => {
                console.error(e);
            })
        },

        editStorage: function() {
            this.$webService.put(`storage/${this.editingStorage.id}`, this.storage).then(response => {
                if (response.status == 201) {
                    this.$emit("loadStorages");
                    $('#storageControlModal').modal('hide');
                    this.clearData();
                }
            }).catch(e => {
                console.error(e);
            })
        },

        clearData: function() {
            this.storage.title = "";
            this.storage.location = "";
            this.storage.palete_capacity = "0";
            this.storage.class = "D";
            this.focused.title = false;
            this.focused.location = false;
            this.focused.palete_capacity = false;
        },
    },
}
</script>

<style>

</style>

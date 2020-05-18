<template>
    <div class="modal fade" tabindex="-1">
    <div class="modal-dialog" >
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> {{mode == 'edit' ? 'Edit' : 'Create'}} Account for [<span class="text-info" v-if="resource">{{`${resource.name} ${resource.surname}`}}</span>] </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label class="col-form-label">Username</label>
                    <input type="text"  class="form-control" v-model="account.username"
                    :class="{'is-invalid': invalidUserName && focused.username, 'is-valid': !invalidUserName && focused.username}"  
                    @focus="focused.username = true">
                    <div class="invalid-feedback"> {{error.username}} </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Password</label>
                    <input type="password"  class="form-control" v-model="account.password"
                    :class="{'is-invalid': invalidPassword && focused.password, 'is-valid': !invalidPassword && focused.password}"  
                    @focus="focused.password = true">
                    <div class="invalid-feedback"> {{error.password}} </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Confirm Password</label>
                    <input type="password"  class="form-control" v-model="account.confirmPassword"
                    :class="{'is-invalid': invalidConfirmPassword && focused.confirmPassword, 'is-valid': !invalidConfirmPassword && focused.confirmPassword}"  
                    @focus="focused.confirmPassword = true">
                    <div class="invalid-feedback"> {{error.confirmPassword}} </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label mb-2 font-weight-bold"> Roles </label>
                    <ul>
                        <li v-for="role in roles" :key="role.id" class="d-flex justify-content-between">
                            <div>
                                <input class="form-check-input" type="checkbox" v-model="role.checked"> 
                                <label class="form-check-label text-break"> {{role.name.length > 30 ? role.name.slice(0, 30)+"..." : role.name}} </label> 
                            </div> 
                        </li>
                    </ul>
                </div>
            </form>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                <button v-if="mode == 'add'" type="button" class="btn btn-primary" :disabled="!validated" @click="createAccount">Create</button>
                <button v-else-if="mode == 'edit'" type="button" class="btn btn-primary" :disabled="!validated" @click="editAccount">Edit</button>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    name: "createAccountModal",

    data() {
        return {
            account: {
                username: "",
                password: "",
                confirmPassword: "",
            },

            focused: {
                username: false,
                password: false,
                confirmPassword: false,
            },

            error: {
                username: "",
                password: "",
                confirmPassword: "",
            },

            roles: [],
        }
    },

    props: {
        resource: Object,
        reloadPersonal: {type: Function},
        mode: String,
    },

    computed: {
        invalidUserName: function() {
            let username = this.account.username;
            this.error.username = "";
            if (!(username.length >= 4 && username.length <= 32)) {
                this.error.username = "Username must be between 4 and 32 characters"
                return true;
            }
            if (!username.match(/^[a-zA-Z0-9\-\_]+$/)) {
                this.error.username = "Username may contain letters, numbers, '-' or '_'";
                return true;
            }
        },

        invalidPassword: function() {
            let password = this.account.password;
            this.error.password = "";
            if (!password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\-\_]{8,50}$/)) {
                this.error.password = "The password must contain letters, numbers, 1 capital letter and may also contain '-' or '_'";
                return true;
            }
        },

        invalidConfirmPassword: function() {
            let password = this.account.password;
            let confirmPassword = this.account.confirmPassword;
            this.error.confirmPassword = "";
            if (confirmPassword != password) {
                this.error.confirmPassword = "Password mismatch!";
                return true;
            }
        },

        validated: function() {
            return (!this.invalidUserName && !this.invalidPassword && !this.invalidConfirmPassword);
        }
    },

    watch: {
        resource: function() {
            this.account.password = this.account.confirmPassword = "";
            if (this.resource.user) {
                this.account.username = this.resource.user.username;
                this.resource.user.roles.forEach(user_role => {
                    this.roles.find(role => role.id == user_role.id).checked = true;
                });
            } else {
                this.roles.forEach(role => {
                    role.checked = false;
                })
                this.account.username = ""
            }
            this.focused.username = this.focused.password = this.focused.confirmPassword = false;
            this.error.username = this.error.password = this.error.confirmPassword = "";
        }
    },

    methods: {
        createAccount: function() {
            if (this.validated) {
                this.account.resource_id = this.resource.id;
                this.account.roles = this.getCheckedRoles();
                this.$webService.post("user", this.account).then(response => {
                    $('#personCreateAccountModal').modal('hide');
                    this.reloadPersonal();
                }).catch(e => {
                    console.error(e);
                })
            }
        },

        editAccount: function() {
            if (this.validated) {
                this.account.roles = this.getCheckedRoles();
                this.$webService.put(`user/${this.resource.user.id}`, this.account).then(response => {
                    $('#personEditAccountModal').modal('hide');
                    this.reloadPersonal();
                }).catch(e => {
                    console.error(e);
                })
            }
        },

        loadRoles: function() {
            this.$webService.get("role").then(response => {
                this.roles = response.data;
            }).catch(e => {
                console.error(e);
            });
        },

        getCheckedRoles: function() {
            let checked = this.roles.filter(role => role.checked);
            return checked.map(role => role.id);
        }
    },

    mounted() {
        this.loadRoles();
    }

}
</script>

<style>

</style>
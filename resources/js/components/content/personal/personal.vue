<template>
    <div>
        <div class="card">
            <div class="d-flex">
                <div class="">
                    <div class="input-group">
                        <input type="text" class="form-control personal-search" placeholder="Search by name, surname">
                        <div class="input-group-append">
                            <button class="input-group-text btn"> <font-awesome-icon icon="search" class="mx-2"/> </button>
                        </div>
                    </div>
                </div>
                <div class="">
                    <personalSelect 
                        placeHolderValue="Choose Department" 
                        :values="[{name: 'First Department', value: '1'}, {name: 'Second Department', value: '2'}]"
                    />
                </div>
                <div class="">
                    <personalSelect 
                        placeHolderValue="Choose Enterprise" 
                        :values="[{name: 'First Enterprise', value: '1'}, {name: 'Second Enterprise', value: '2'}]"
                    />
                </div>
            </div>
        </div>

        <div class="card mt-3 personal-table">
            <personalTable :personal="personal"/>
        </div>
    </div>
</template>

<script>
import personalSelect from "./elements/personal-select";
import personalTable from "./personalTable/personalTable";

export default {
    name: "personal",

    data() {
        return {
            personal: [
                {id: 1, nameSurname: "Mark Surok", position: "Otto", status: "working very hard"},
                {id: 2, nameSurname: "Jacob Scronung", position: "Thornton", status: "Komandirovka"},
                {id: 3, nameSurname: "Larry NeGarry", position: "the Bird", status: "Otpusk"},
                {id: 4, nameSurname: "Andy Larkin", position: "Pilot", status: "Boleet"},
                {id: 5, nameSurname: "Jacob Scronung", position: "Thornton", status: "Candidat"},
                {id: 6, nameSurname: "Larry NeGarry", position: "the Bird", status: "Otpusk"},
                {id: 7, nameSurname: "Andy Larkin", position: "Pilot", status: "Candidat"},
                {id: 4, nameSurname: "Andy Larkin", position: "Pilot", status: "Boleet"},
                {id: 5, nameSurname: "Jacob Scronung", position: "Thornton", status: "Candidat"},
                {id: 6, nameSurname: "Larry NeGarry", position: "the Bird", status: "Otpusk"},
                {id: 7, nameSurname: "Andy Larkin", position: "Pilot", status: "Candidat"},
                {id: 4, nameSurname: "Andy Larkin", position: "Pilot", status: "Boleet"},
                {id: 5, nameSurname: "Jacob Scronung", position: "Thornton", status: "Candidat"},
                {id: 6, nameSurname: "Larry NeGarry", position: "the Bird", status: "Otpusk"},
                {id: 7, nameSurname: "Andy Larkin", position: "Pilot", status: "Candidat"},
                {id: 4, nameSurname: "Andy Larkin", position: "Pilot", status: "Boleet"},
                {id: 5, nameSurname: "Jacob Scronung", position: "Thornton", status: "Candidat"},
                {id: 6, nameSurname: "Larry NeGarry", position: "the Bird", status: "Otpusk"},
                {id: 7, nameSurname: "Andy Larkin", position: "Pilot", status: "Candidat"},
            ]
        }
    },

    components: {
        personalSelect,
        personalTable,
    },

    mounted() {
        this.$webService.get("resource").then(response => {
            console.log(response.data);
        }).catch(e => {
            console.log(e);
        })
    }
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
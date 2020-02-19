<template>
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
            <personalTableRow v-for="(person, index) in personal" :key="index" 
                :id="person.id"
                :nameSurname="person.nameSurname"
                :position="person.position.name"
                :status="person.status.name"
                :department="person.department.name"
                :enterprise="person.enterprise.name"
            />
        </tbody>
        
    </table>
</template>

<script>
import personalTableRow from "./personalTableRow";
export default {
    name: "personalTable",

    components: {
        personalTableRow,
    },

    props: {
        personal: Array,
    }
}
</script>

<style>
</style>
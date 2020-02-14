<template>
    <table class="table table-hover table-responsive mb-0">

        <thead class="">
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
                :id="index"
                :nameSurname="person.nameSurname"
                :position="person.position"
                :status="person.status"
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
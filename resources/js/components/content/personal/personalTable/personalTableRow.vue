<template>
    <tr>
        <th scope="row"> {{id}} </th>
        <td> {{nameSurname}} </td>
        <td> {{position}} </td>
        <td> {{department}} </td>
        <td> {{enterprise}} </td>
        <td> {{status}} </td>
        <td>
            <div class="d-flex ptr-button-cube text-center">
                <button class="btn btn-primary mx-1"><font-awesome-icon icon="pen" class=""/></button>
                <button class="btn btn-primary mx-1"><font-awesome-icon icon="info" class=""/></button>
            </div>
        </td>
    </tr>
</template>

<script>
export default {
    name: "personalTableRow",
    props: {
        id: [String, Number],
        nameSurname: String,
        position: String,
        status: String,
        department: String,
        enterprise: String,
    },
}
</script>

<style scoped>
    .table td, table th {
        vertical-align: middle !important;
    }

    .ptr-button-cube button {
        width: 40px;
        height: 40px;
    }
</style>
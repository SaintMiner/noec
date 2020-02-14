<template>
    <div>
        <div class="card">
            <div class="d-flex">
                <div class="mr-2">
                    <div class="input-group">
                        <input type="text" class="form-control personal-search" placeholder="Search by name, surname">
                        <div class="input-group-append">
                            <button class="input-group-text btn"> <font-awesome-icon icon="search" class="mx-2"/> </button>
                        </div>
                    </div>
                </div>
                <div class="mx-2">
                    <select class="custom-select">
                        <option selected disabled>Choose Department</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="mx-2">
                    <select class="custom-select">
                        <option selected disabled>Choose Enterprise</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <table class="table table-hover table-responsive">

                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="vw-100">Name Surname</th>
                        <th scope="col" class="vw-100">Position</th>
                        <th scope="col" class="vw-100">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark Surok</td>
                        <td>Otto</td>
                        <td>Working</td>
                        <td>
                            <div class="d-flex">
                            <button class="btn btn-success">good</button>
                            <button class="btn btn-danger">bad</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob Scronung</td>
                        <td>Thornton</td>
                        <td>Komandirovka</td>
                        <td>
                            <div class="d-flex">
                            <button class="btn btn-success">good</button>
                            <button class="btn btn-danger">bad</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry NeGarry</td>
                        <td>the Bird</td>
                        <td>Otpusk</td>
                        <td>
                            <div class="d-flex">
                            <button class="btn btn-success">good</button>
                            <button class="btn btn-danger">bad</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>Andy Larkin</td>
                        <td>Pilot</td>
                        <td>Boleet</td>
                        <td>
                            <div class="d-flex">
                            <button class="btn btn-success">good</button>
                            <button class="btn btn-danger">bad</button>
                            </div>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "personal",
}
</script>

<style>
    .personal-search {
        width: 400px;
    }

    .personal-table-actions {
        width: fit-content;
    }
</style>
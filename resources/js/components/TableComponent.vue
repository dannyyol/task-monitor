<template>
    <div class="wrapper">
        <div class="row clearfix">
            <div
                class="jumbotron jumbotron-fluid"
                style="width:100%;    background-color: rgba(21, 54, 82, 0.288);"
            >
                <div class="container">
                    <div class="col-md-12 table-responsive">
                        <div
                            class="btn-group float-right"
                            role="group"
                            aria-label="Basic example"
                        >
                            <router-link
                                class="btn btn-warning text-white"
                                :to="{ name: 'create' }"
                                ><i class="fa fa-plus" aria-hidden="true"></i>
                                Add Task</router-link
                            >
                        </div>
                        <input
                            type="text"
                            name="mail0"
                            style="border-radius:0px;border:solid 0px;width:300px;"
                            placeholder="Search here....."
                            class="form-control"
                            v-model="query"
                        />
                        <small class="text-info">
                            <i
                                >Task Name, Description, Start Date and End
                                Date</i
                            ></small
                        >
                    </div>
                </div>
            </div>
            <br />
            <table
                class="table table-bordered table-hover table-sortable"
                id="tab_logic"
            >
                <thead
                    class="text-white"
                    style="background-color: rgb(23, 63, 82);"
                >
                    <tr>
                        <th>S/N</th>
                        <th class="text-center">
                            Name
                        </th>
                        <th class="text-center">
                            Description
                        </th>
                        <th class="text-center">
                            Start Date
                        </th>
                        <th class="text-center">
                            End Date
                        </th>
                        <th class="text-center">
                            Status
                        </th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
                        <th
                            class="text-center"
                            style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;"
                        ></th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(result, index) in results['data'].slice(0, 20)"
                        :key="result.index"
                    >
                        <td>{{ index }}</td>
                        <td>{{ result.task_name }}</td>
                        <td>{{ result.description }}</td>

                        <td>{{ result.start_date  | formatDate }}</td>
                        <td>{{ result.end_date  | formatDate }}</td>
                        <td>{{ result.status }}</td>
                        <td>{{ result.created_at | formatDate }}</td>

                        <td>{{ result.updated_at  | formatDate }}</td>

                        <td data-name="del">
                            <div
                                class="btn-group btn-group"
                                role="group"
                                aria-label="Basic example"
                            >
                                <router-link
                                    :to="{
                                        name: 'edit',
                                        params: { id: result.id }
                                    }"
                                    class="btn btn-sm btn-info"
                                >
                                    <i
                                        class="fas fa-edit"
                                        aria-hidden="true"
                                    ></i>
                                </router-link>
                                <button
                                    type="button"
                                    @click="deleteTask(result.id)"
                                    class="btn btn-sm btn-danger"
                                >
                                    <i
                                        class="fa fa-trash"
                                        aria-hidden="true"
                                    ></i>
                                </button>
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
    data() {
        return {
            tasks: [],
            query: null,
            results: []
        };
    },
    watch: {
        query(after, before) {
            this.searchTasks();
            this.allTasks;
        }
    },
    methods: {
        allTasks() {
            axios
                .get("/api/admin/tasks/")
                .then(({ data }) => (this.results = data))
                .catch();
        },

        searchTasks() {
            axios
                .get("/api/admin/search", { params: { query: this.query } })
                .then(response => (this.results = response.data))
                .catch(error => {});
        },

        deleteTask(id) {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                // will send request to the server
                if (result.value) {
                    axios
                        .delete("/api/admin/tasks/" + id)
                        .then(() => {
                            swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            Fire.$emit("AfterCreated");
                        })
                        .catch(() => {
                            swal.fire(
                                "Failed",
                                "There was something wrong",
                                "warning"
                            );
                        });
                }
            });
        }
    },

    mounted() {
        this.allTasks();
    },
    created() {
        Fire.$on("AfterCreated", () => {
            this.allTasks();
        });
    }
};
</script>

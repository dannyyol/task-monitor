<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <router-link to="/admin/" class="btn btn-sm btn-success "><i class="fa fa-backward" aria-hidden="true"></i> Back</router-link>
<br><br>
                <div class="card">
                    <div class="card-header" style="text-align:center; background-color:azure;">
                        <b> Create A Task</b>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="TaskCreate">
                            <!-- <div class="row"> -->
                            <div class="form-group">
                                <label for="">Task Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="inputtext"
                                    placeholder="Name"
                                    v-model="form.task_name"
                                />
                                <small
                                    class="text-danger"
                                    v-if="errors.task_name"
                                >
                                    {{ errors.task_name[0] }}
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="">Task Description</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="inputtext"
                                    placeholder="Description"
                                    v-model="form.description"
                                />
                                <small
                                    class="text-danger"
                                    v-if="errors.description"
                                >
                                    {{ errors.description[0] }}
                                </small>
                            </div>
                            <!-- </div> -->

                            <!-- </div> -->
                            <div class="form-group">
                                <label for="">Start Date</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="inputtext"
                                    placeholder="Start Date"
                                    v-model="form.start_date"
                                />
                                <small
                                    class="text-danger"
                                    v-if="errors.start_date"
                                >
                                    {{ errors.start_date[0] }}
                                </small>
                            </div>
                            <!-- </div> -->
                            <!-- <div class="row"> -->
                            <div class="form-group">
                                <label for="">End Date</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="inputtext"
                                    placeholder="End Date"
                                    v-model="form.end_date"
                                />
                                <small
                                    class="text-danger"
                                    v-if="errors.end_date"
                                >
                                    {{ errors.end_date[0] }}
                                </small>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        name=""
                                        id=""
                                        value="1"
                                        v-model="form.status"
                                    />
                                    Status
                                </label>
                            </div>
                            <!-- </div> -->
                            <button type="submit" class="btn btn-success">
                                Create Task
                            </button>
                        </form>
                    </div>
                </div>
                <br /><br /><br />
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
export default {
    data() {
        return {
            form: {
                task_name: null,
                description: null,
                start_date: null,
                end_date: null,
                status: null
            },
            errors: {}
        };
    },

    methods: {
        TaskCreate() {
            axios
                .post("/api/admin/tasks", this.form)
                .then(() => {
                    this.$router.push({ name: "home" });
                    swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: true,
                        timer: 1500
                    });
                })
                .catch(error => (this.errors = error.response.data.errors));
        }
    }
};
</script>

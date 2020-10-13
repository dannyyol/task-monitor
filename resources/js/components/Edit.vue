<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <router-link to="/admin/" class="btn btn-sm btn-success "><i class="fa fa-backward" aria-hidden="true"></i> Back</router-link>
<br><br>
                <div class="card">
                    <div class="card-header" style="text-align:center; background-color:azure;">
                        <b> Update A Task</b>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="TaskUpdate">
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
                                Update Task
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
                task_name: "",
                description: "",
                start_date: "",
                end_date: "",
                status: ""
            },
            errors: {}
        };
    },

    methods: {
        TaskUpdate() {
            let id = this.$route.params.id;
            axios
                .patch("/api/admin/tasks/" + id, this.form)
                .then(() => {
                    swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: true,
                        timer: 1500
                    });
                    this.$router.push({ name: "home" });
                })
                .catch(error => (this.errors = error.response.data.errors));
        }
    },
    //   ,
    created() {
        let id = this.$route.params.id;
        console.log(id);
        axios
            .get("/api/admin/tasks/" + id + "/edit")
            .then(({ data }) => (this.form = data))
            .catch(console.log("error"));
    }
};
</script>

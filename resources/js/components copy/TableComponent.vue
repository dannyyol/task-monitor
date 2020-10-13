<template>

<div class="wrapper">
    <div class="row clearfix">
        <div class="jumbotron jumbotron-fluid" style="width:100%;    background-color: rgba(21, 54, 82, 0.288);">
            <div class="container">
                <div class="col-md-12 table-responsive">
                    <div class="btn-group float-right" role="group" aria-label="Basic example">

                        <router-link class="btn btn-info" to="/external-books"><i class="fa fa-external-link" aria-hidden="true"></i> External Books</router-link>
                        <router-link class="btn btn-success" to="/"><i class="fa fa-database" aria-hidden="true"></i> Load Database</router-link>
                        <router-link class="btn btn-warning text-white" :to="{name: 'create'}"><i class="fa fa-plus" aria-hidden="true"></i> Add Book</router-link>
                    </div>
                    <input type="text" name='mail0' style="border-radius:0px;border:solid 0px;width:300px;" placeholder='Search here.....' class="form-control" v-model="query"/>
                    <small class="text-info"> <i>Book Name, Country, Publisher and Released Date</i></small>
                </div>
            </div>
        </div>
        <br>
        <table class="table table-bordered table-hover table-sortable" id="tab_logic">
            <thead class="text-white"  style="background-color: rgb(23, 63, 82);">
                <tr>
                    <th>S/N</th>
                    <th class="text-center">
                        Name
                    </th>
                    <th class="text-center">
                        ISBN
                    </th>
                    <th class="text-center">
                        Authors
                    </th>
                    <th class="text-center">
                        Country
                    </th>
                    <th class="text-center">
                        No of Pages
                    </th>
                    <th>Publishers</th>
                    <th>Release Date</th>
                    <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;">
                    </th>
                </tr>
            </thead>
            <tbody>


                    <tr  v-for="(result, index) in results['data'].slice(0,20)" :key="result.index">
                        <td>{{ index }}</td>
                        <td> {{ result.name }} </td>
                        <td>{{ result.isbn }}</td>
                        <div v-for="(author,index) in result.authors" :key="author.index">
                            <td style="width:200px;" v-if="author.name==null"> {{ author}} </td>
                            <td style="width:200px;" v-else> {{ author.name}} </td>

                        </div>
                        <td>{{ result.country }}</td>
                        <td> {{ result.number_of_pages }} </td>
                        <td>{{ result.publishers }}</td>
                        <td> {{ result.release_date }} </td>
                        <td data-name="del">
                            <div class="btn-group btn-group" role="group" aria-label="Basic example">

                                <router-link :to="{name: 'edit', params:{id:result.id}}" class="btn btn-info"> <i class="fa fa-pencil" aria-hidden="true"></i> </router-link>
                                <router-link :to="{name: 'detail', params:{id:result.id}}"  class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></router-link>
                                <button type="button" @click="deleteBook(result.id)"  class="btn btn-danger"><i class="fa fa-eraser" aria-hidden="true"></i></button>

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
        data(){

            return{
                books:[],
                query: null,
                results: [],

            }
        },
        watch: {
            query(after, before) {
                this.searchBooks();
                this.allBooks
            }
        },
        methods:{
            allBooks(){
                axios.get('/api/admin/books/')
                .then(({data}) => (this.results = data))
                .catch()
            },

            searchBooks() {
                axios.get('/api/admin/search', { params: { query: this.query } })
                .then(response => this.results = response.data)
                .catch(error => {
                });
            },

            deleteBook(id){
                swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {

                // will send request to the server
                if (result.value) {
                    axios.delete('/api/admin/books/'+ id).then(()=>{
                        swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        )
                        Fire.$emit('AfterCreated');

                    }).catch(()=>{
                        swal.fire("Failed", "There was something wrong", "warning");
                    });
                }
            })
        },
    },

    mounted(){
            this.allBooks();
    },
    created(){
        Fire.$on('AfterCreated', () => {
            this.allBooks();
        });

    }
}
</script>

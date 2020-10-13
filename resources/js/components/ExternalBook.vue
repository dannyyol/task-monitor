<template>

<div class="wrapper">
    <div class="row clearfix">
        <div class="jumbotron jumbotron-fluid" style="width:100%;    background-color: rgba(21, 54, 82, 0.288);">
            <div class="container">
                <div class="col-md-12 table-responsive">
                    <div class="btn-group float-right" role="group" aria-label="Basic example">

                        <router-link class="btn btn-info" to="/external-books"><i class="fa fa-external-link" aria-hidden="true"></i> External Books</router-link>
                        <router-link class="btn btn-success" to="/"><i class="fa fa-database" aria-hidden="true"></i> Load Database</router-link>
                        <router-link class="btn btn-warning text-white" :to="{name: 'home'}"><i class="fa fa-backward" aria-hidden="true"></i> Back</router-link>
                    </div>
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

                </tr>
            </thead>
            <tbody>
                <tr id='addr0' data-id="0" class="hidden">
                        <td data-name="name">
                        </td>
                        <td data-name="mail">
                            <input type="text" name='mail0' placeholder='Search here...' class="form-control" v-model="query"/>
                        </td>
                        <td data-name="desc">
                            <!-- {{-- <input type="text" name='mail0' placeholder='Search here...' class="form-control"/> --}} -->
                        </td>
                        <td data-name="desc">
                            <input type="text" name='mail0' placeholder='Search here...' class="form-control" v-model="query2"/>
                        </td>
                        <td data-name="desc">
                            <!-- {{-- <input type="text" name='mail0' placeholder='Search here...' class="form-control"/> --}} -->
                        </td>
                        <td data-name="desc">
                            <!-- {{-- <input type="text" name='mail0' placeholder='Search here...' class="form-control"/> --}} -->
                        </td>
                        <td data-name="desc">
                            <input type="text" name='mail0' placeholder='Search here...' class="form-control" v-model="query3"/>
                        </td>
                        <td data-name="sel">
                            <input type="text" name='mail0' placeholder='Search here...' class="form-control" v-model="query4"/>

                        </td>


                </tr>


                <!-- <div> -->
                    <!-- <td  v-if="results.length > 0 && query"> -->
                    <tr  v-for="(result, index) in filtersearch" :key="result.id">
                        <td>{{  index }}</td>
                        <td> {{ result.name }} </td>
                        <td>{{ result.isbn }}</td>
                        <div v-for="(author,index) in result.authors" :key="author.index">
                            <td style="width:200px;" v-if="author.name==null"> {{ author}} </td>
                            <td style="width:200px;" v-else> {{ author.name}} </td>

                        </div>
                        <td>{{ result.country }}</td>
                        <td> {{ result.numberOfPages }} </td>
                        <td>{{ result.publisher }}</td>
                        <td> {{ result.released }} </td>

                    </tr>


                <!-- </div> -->
            </tbody>
        </table>

    </div>
</div>


</template>

<script>
    export default {
        // props:['query'],
        data(){

            return{
                // searchPost: '',
                books:[],
                query: '',
                query2:'',
                query3:'',
                query4:'',
                results: [],


                // img_src:'storage/images',
            }
        },

        methods:{
            allBooks(){
                axios.get('https://www.anapioficeandfire.com/api/books')
                .then(({data}) => (this.results = data))
                .catch()


                // axios.get("https://api.nytimes.com/svc/topstories/v2/home.json?api-key=your_api_key")
                // .then(response => {this.results = response.data.results})
                // console.log(response.data)

            },

            searchBooks() {
                axios.get('/api/v1/search', { params: { query: this.query } })
                .then(response => this.results = response.data)
                .catch(error => {
                });
            },
        },

        computed:{
            filtersearch(){

                return this.results.filter((book) =>
                book.name.toLowerCase().includes(this.query) &&
                book.country.toLowerCase() && book.publisher.toLowerCase().includes( this.query2 ) && book.publisher.toLowerCase().includes( this.query3 )  && book.released.toLowerCase().includes( this.query4 )
            );
            }


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

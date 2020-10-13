<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                        <div class="card-header">
                            Header
                        </div>
                          <div class="card-body">


                    <form @submit.prevent="BookUpdate">
                        <!-- <div class="row"> -->
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" class="form-control" id="inputtext" placeholder="Name" v-model="form.name">
                                <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small>

                            </div>
                            <div class="form-group">
                                <label for="">ISBN</label>
                                <input type="text" class="form-control" id="inputtext" placeholder="ISBN" v-model="form.isbn">
                                <small class="text-danger" v-if="errors.isbn"> {{ errors.isbn[0] }} </small>

                            </div>
                        <!-- </div> -->

                        <!-- <div class="row"> -->
                            <div class="form-group">
                                <label for="">Authors</label>
                                <div v-for="(author, index) in form.authors" :key="index" style="padding-bottom:10px;">
                                    <div class="input-group control-group increment">
                                        <input type="text" class="form-control" id="inputtext"  placeholder="Authors" v-model="form.authors[index]">
                                        <a class="btn btn-sm btn-danger" style="border-radius:0px;"  @click="deleteAuthor(index)"><i class="fa fa-remove"></i></a>
                                    </div>
                                </div>

                                <small class="text-danger" v-if="errors.authors"> {{ errors.authors[0] }} </small>
                                <br>
                                <a class="btn btn-sm btn-success text-white" style="width:100%" @click="addAuthor"><i class="fa fa-plus"></i>Add Author</a>


                            </div>

                        <!-- </div> -->
                            <div class="form-group">
                                <label for="">Country</label>
                                <input type="text" class="form-control" id="inputtext" placeholder="Country" v-model="form.country">
                                <small class="text-danger" v-if="errors.country"> {{ errors.country[0] }} </small>

                            </div>
                        <!-- </div> -->
                        <!-- <div class="row"> -->
                            <div class="form-group">
                                <label for="">No of Pages</label>
                                <input type="text" class="form-control" id="inputtext" placeholder="Number of Pages" v-model="form.number_of_pages">
                                 <small class="text-danger" v-if="errors.number_of_pages"> {{ errors.number_of_pages[0] }} </small>

                            </div>
                            <div class="form-group">
                                <label for="">Publishers</label>
                                <input type="text" class="form-control" id="inputtext" placeholder="Publishers" v-model="form.publishers">
                                <small class="text-danger" v-if="errors.publishers"> {{ errors.publishers[0] }} </small>

                            </div>
                        <!-- </div> -->
                        <div class="form-group">
                            <label for="">Release Date</label>
                            <input type="date" class="form-control" id="inputPassword" placeholder="Release Date" v-model="form.release_date">
                            <small class="text-danger" v-if="errors.release_date"> {{ errors.release_date[0] }} </small>

                        </div>

                    <button type="submit" class="btn btn-success">Update Book</button>
                </form>
                          </div>
                </div>
                <br><br><br>
            </div>
        </div>
    </div>
</template>


<script type="text/javascript">

  export default {

    data(){
        return {
        form:{
            name: '',
            isbn: '',
            authors: [],
            country: '',
            number_of_pages: '',
            publishers: '',
            release_date: '',
        },
        errors:{},
        }
    },

    methods:{
      BookUpdate(){
        let id = this.$route.params.id
        axios.patch('/api/v1/books/'+id,this.form)
        .then(() => {
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: true,
                    timer: 1500
                })
            this.$router.push({ name: 'home'})
        })
        .catch(error =>this.errors = error.response.data.errors)
     },

    addAuthor: function () {
        this.deleteAuthor
        this.form.authors.push({ name: '' });
    },

    deleteAuthor: function (index) {
        console.log(index);
        console.log(this.form.authors);
        this.form.authors.splice(index, 1);
        }
    },
//   ,
    created(){
        let id = this.$route.params.id
        console.log(id)
        axios.get('/api/v1/books/'+id+'/edit')
            .then(({data}) => (this.form = data))
            .catch(console.log('error'))

    },


  }

</script>

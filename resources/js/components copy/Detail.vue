<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card" style="height:430px;margin-bottom:50px;">
                    <div class="card-header text-center"><h3>{{book.data.name}}</h3></div>

                    <div class="card-body">
					<div class="box-part text-center">


						<div class="title" v-for="(author, index) in book.data.authors" :key="index">
							<h4 v-if="author['name']==null">{{  author }}</h4>
                            <h4 v-else>{{  author['name'] }}</h4>
						</div>
                        <p><b>Number Of Pages: </b>{{book.data.number_of_pages}}</p>
                        <p><b>Publisher: </b>{{book.data.publishers}}</p>
                        <p><b>Country: </b>{{book.data.country}}</p>
                        <p><b>Released Date: </b>{{book.data.release_date}}</p>

					 </div>
				</div>


                </div>
            </div>


        </div>
        <!-- <br><br><br> -->
        <!-- <br><br><br> -->
    </div>
</template>

<style scoped>
body{
    background: #eee;
}
span{
    font-size:15px;
}
a{
  text-decoration:none;
  color: #0062cc;
  border-bottom:2px solid #0062cc;
}
.box{
    padding:60px 0px;
}

.box-part{
    background:#FFF;
    border-radius:0;
    padding:60px 10px;
    margin:30px 0px;
}
.text{
    margin:20px 0px;
}

.fa{
     color:#4183D7;
}
</style>
<script>
    export default {
        data() {
            return {
                book:[],
            }
        },
        methods:{
            showBook(){
                let id = this.$route.params.id
                axios.get('/api/v1/books/'+id)
            },
        },
        mounted(){
            let id = this.$route.params.id
                console.log(id)
                axios.get('/api/v1/books/'+id)
                .then(({data}) => (this.book = data))
                .catch(console.log('error'))

            },
    }
</script>

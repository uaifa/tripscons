<template>
    <main>
            <div class="profilee-detail container py-5">
                <div class="row">
                    <div class="col-12 col-sm-4 col-md-4">
                        <!--profile info section-->
                        <div class="profile-left p-4">
                            <div class="row image-sction px-2">
                                <div class="">
                                    <div class="img-container">
                                        <img :src="'/assets/img/'+generalData.image" class="img-fluid">
                                        <span class="user-status"></span>
                                    </div>

                                </div>
                                <div class="ml-3">
                                    <div class="profile-bio">
                                        <h2>{{generalData.name}}</h2>
                                        <h4>{{generalData.country+','+generalData.city}}</h4>
                                         <p>Member since {{generalData.created_at | formatDate}}</p>
                                    </div>

                                </div>
                            </div>

                            <!--comments section-->
                            <div class="row comment-section mt-4 px-2">
                                <div>
                                    <span>100</span>
                                    <span>Comments</span>
                                </div>
                                <div>
                                    <span>10</span>
                                    <span>Trips</span>
                                </div>
                                <div>
                                    <span>40</span>
                                    <span>Tripfriends</span>
                                </div>
                                <div>
                                    <span>40</span>
                                    <span>Feedbacks</span>
                                </div>
                            </div>


                            <div class="row mt-5 btn-sectionn ">

                                <button class="btn btn-whitee">Contact</button>


                                <button class="btn btn-whitee">Invite</button>


                            </div>
                        </div>
                        <div class="about-info  mt-2 container p-4">
                            <div class="cus-title">
                                <h2>About me</h2>
                                <p>{{generalData.about}} </p>
                            </div>
                            <div class="cus-title mt-4">
                                <h2>Languages</h2>

                            </div>
                            <div class="languages d-flex mt-3">
                                <span>English</span>
                                <span>German</span>
                                <span>Thai</span>
                            </div>
                            <div class="cus-title mt-4">
                                <h2>Interests</h2>

                            </div>
                            <div class="interests d-flex mt-2">
                                <span v-for="(i,index) in generalData.activity" :key="index">
                                
                                <img width="25px" :src="'/assets/img/icons/'+i.image" alt="Tripscon"> {{i.name}}</span>
                                

                            </div>
                         
                        </div>
                    </div>

                   <div class="col-12 col-sm-8 col-md-8">
                <div class="profile-right p-5">
                    <div class="row custom-tabs mt-4">
                        <ul class="nav nav-pills nav-fill">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="collapse"
                                    href="#collapseExample">Upcoming trips</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Past trips</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Plans</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link talks" href="#">Talks <span class="msgs">2</span></a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="#">Invites</a>
                            </li>
                        </ul>
                    </div>

                    <!--country grid-->
                    <div class="row country-grid mt-4">
                        <div class="col-sm-12 col-md-4 my-2">
                            <div class="images-wrapper">
                                <div class="location-image">
                                    <img src="/assets/img/hotel1.jfif" alt="">
                                </div>
                                <div class="location-info mt-2">
                                    <span class="hotel-name">Lux Greek</span>
                                    <span class="country-name">Italy</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 my-2" v-for="(i,index) in generalData.trips" :key="index">
                            <div class="images-wrapper">
                                
                                <div class="location-image" v-if="i.single_image!=null">
                                    <img :src="$imagePath+i.single_image.name" alt="hotel" />
                                </div>
                                <div class="location-image" v-else>
                                    <img :src="$imagePath+'not-available.png'" alt="hotel" />
                                </div>
                                <div class="location-info mt-2">
                                    <span class="hotel-name">{{i.title}}</span>
                                    <span class="country-name">{{i.location}}</span>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
                </div>


            </div>
        </main>

</template>

<script>
import {gmapApi} from 'vue2-google-maps'
 export default {
        name: "mealDetail",
        data(){
        return{
        generalData :'',
        relatedData:'',
        Id: this.$route.params.mateId,
        };
        
        },
        created(){
        
        this.idGet();
        google: gmapApi;
        },
        methods:{
        idGet() {
      
        axios.get("/api/getMateDetail/" + this.Id).then((response) => {
        this.generalData = response.data.detail;
        this.relatedData  = response.data.relatedData;
        
       
      });
    },
        
  },
 
}
</script>
<style scoped>
#image-slider .modal-content{
  background: transparent !important;
}
.images-wrapper{
  display: flex;
  flex-wrap: wrap;
}
.images-wrapper .single-image-modal {
  flex:1 1 98%;
  margin: 4px 0px;
 
}
.images-wrapper .single-image-modal img{
  width: 100%;
  height: 97vh;
}
.slide-photos{
      box-shadow: 1px 0px 2px 2px #f1baba;
    position: absolute;
    bottom: 50px;
    right: 50px;
    background: #fff;
    border-radius: 8px;
    color: black;
    text-shadow: 2px 2px 2px #fff;
    padding: 4px 20px;
    z-index: 444;
}
.center-img-holder:hover,.larger-img-holder:hover,.single-image-modal:hover{
  filter: brightness(0.6);
}
</style>


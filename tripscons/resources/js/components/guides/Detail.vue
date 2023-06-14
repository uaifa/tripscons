<template>
   <main>
            <div class="profilee-detail container py-5">
                <div class="row mb-4 top-guide-section container" style="margin-left: 0px;">
                    <div class="col-12 col-sm-5 col-md-5">
                        <div class="row image-sction px-2">
                            <div class="">
                                <div class="img-container">
                                    <img src="/assets/img/profile-l.jpg" class="img-fluid">
                                    <span class="user-status"></span>
                                    <p class="guide-status text-center mt-3">Online</p>
                                </div>

                            </div>
                            <div class="ml-3">
                                <div class="profile-bio">
                                    <h2>{{userObj.name}}</h2>
                                    <h4>{{userObj.city+','+userObj.country}}</h4>
                                    <p>Member since {{userObj.created_at | formatDate}}</p>
                                   <p class="guide-verified" v-if="userObj.is_phone_verified!=0">Phone Number: Verified 
                                       <img src="/assets/img/icons/verified.png" width="24px" alt="" srcset="">
                                   </p>
                                   <p class="guide-verified" v-else>Phone Number:Not Verified 
                                       <img src="/assets/img/icons/verified.png" width="24px" alt="" srcset="">
                                   </p> 
                                   <p class="guide-verified">ID: Verified
                                    <img src="/assets/img/icons/verified.png" width="24px" alt="" srcset="">
                                   </p> 
                                   
                                </div>

                            </div>
                        </div>
                        <div class="d-flex  mt-5">
                            <button class="btn btn-whitee">Contact</button>
                        </div>
                    </div>
                    <div class="col-12 col-sm-7 col-md-7">
                        <div class="cus-title d-flex justify-content-between">
                            <h1 class=""> Highly Experienced in Adventure Trips</h1>
                            <div class="d-flex justify-content-end guide-prices mt-2">
                                <div class="price-wrapper">
                                    <button class="btn btn-guidr-price">Book</button>
                                    <div>
                                        <span>$20 / hr</span>
                                    
                                        <span class="ml-2">$150/ day</span>
                                    </div>

                                </div>
                                 
                            
                            </div>

                        </div>
                        <div class="certification guide-certification">
                            <h2>Certified Guide </h2>
                            <span><img src="/assets/img/icons/ranking.png" width="20px" alt=""></span>
                        </div>
                                <!--comments section-->
                                <div class="row comment-section mt-4 px-2">
                                    <div>
                                        <span>4.9 <img src="/assets/img/icons/star.png" alt="" srcset=""></span>
                                        <span>90 reviews</span>
                                    </div>
                                    <div>
                                        <span>100</span>
                                        <span>Times booked</span>
                                    </div>
                                    <div>
                                        <span>1hour</span>
                                        <span>respose time</span>
                                    </div>
                                    <div>
                                        <span>90%</span>
                                        <span> respose rate</span>
                                    </div>
    
                                </div>
                                
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12 col-sm-5 col-md-5">
                        <!--profile info section-->
                       
                       

                    
                            




                        <!--About infot-->
                        <div class="about-info about-guide  mt-2 container px-4">
                            <div class="cus-title">
                                <h2>About me</h2>
                                <p> {{generalData.about}}</p>

                            </div>
                            

                            <div class="cus-title mt-1">
                                <h2>Expert in</h2>

                            </div>
                            <div class="languages d-flex mt-2">
                                <span v-for="(i, index) in expertsArray"
                                 :key="index">{{i}}</span>
                               

                            </div>
                            <div class="cus-title mt-3 d-flex justify-content-between">
                                <h2>Activities</h2>
                                
                            </div>
                            <div class="activities-container-main mt-2">

                                <div class="activites-container-item  activities-guide" v-for="(i, index) in generalData.activities"
                                 :key="index">
                                    <span class="image mr-2">
                                    
                                     <img :src="'/assets/img/icons/'+i.image" alt="guide" />
                                    </span>
                                    <span class="title">{{i.name}}</span>

                                </div>
                                <div class="activites-container-item activities-guide">
                                    <span class="image mr-2"><img src="/assets/img/icons/tracking.png" alt=""></span>
                                    <span class="title">Tracking</span>

                                </div>
                           




                            </div>
                            <div class="cus-title mt-3">
                                <h2>Destinations</h2>

                            </div>   
                            <div class="languages d-flex mt-2">
                                <span v-for="(i, index) in generalData.destination"
                                 :key="index">{{i.title}}</span>
                                
                            </div>
                            <div class="cus-title mt-3">
                                <h2>Skills</h2>

                            </div>
                            <div class="languages d-flex mt-2">
                                <span v-for="(i, index) in skillsArray"
                                 :key="index">{{i}}</span>
                            </div>
                            <div class="cus-title mt-3">
                                <h2>Languages</h2>

                            </div> 
                            <div class="languages d-flex mt-2">
                                
                                <span v-for="(i, index) in languagesArray"
                                 :key="index">{{i}}</span>
                               
                            </div>


                        </div>
                    </div>

                    <div class="col-12 col-sm-7 col-md-7 mt-3">
                  
                      
                      
                        <div class="profile-right px-5 py-4" >
                            <div class="d-flex justify-content-center mt-3">
                                <button class="btn btn-whitee"><a>Check availability</a></button>
    
                            </div>
                            <span class="guide-charge">$150 per day</span>
                            <div class="input-parent mt-3 ">
                                <div class="input-child ">
                                    <span>Destination</span>
                                    <select id="inputState" class="form-control input_field">

                                        <option selected>Hunza</option>
                                        <option>Naran</option>
                                        <option>Gilgit</option>
                                        <option>Swat</option>
                                        <option>Kalam</option>
                                    </select>
                                </div>

                                <div class="input-child">

                                </div>

                            </div>
                            <div class="input-parent mt-3">
                                <div class="input-child">
                                    <span>From</span>
                                    <input type="text" class="form-control input_field" placeholder="Start date"
                                        onfocus="(this.type='date')"
                                        onblur="(this.type='text')">
                                </div>

                                <div class="input-child">
                                    <span>To</span>
                                    <input type="text" class="form-control input_field " placeholder="End date"
                                        onfocus="(this.type='date')"
                                        onblur="(this.type='text')">
                                </div>

                            </div>


                            <div class="input-parent mt-3">
                                <div class="input-child">
                                    <span>Trip Type</span>
                                    <select id="inputState" class="form-control input_field">

                                        <option selected>Select</option>
                                        <option>Solo</option>
                                        <option>Group</option>
                                    </select>
                                </div>

                                <div class=" input-child">
                                    <span>Number of travellers</span>
                                    <input type="text" class="form-control input_field" placeholder="5">
                                </div>

                            </div>
                            <div class="charges-section mt-4 d-flex justify-content-between">
                                <p class="service">$150 X 2days </p>
                                <p class="charges">$300</p>
                            </div>


                            <hr class="charges-line mt-3">
                            <div class="charges-section d-flex justify-content-between">
                                <p class=" services service-total">Total</p>
                                <p class="charges charges-total">$300</p>
                            </div>

                        </div>
                    </div>
                </div>
                <!--Stay in section-->
                <div class="stay-in-sec mt-4">
                    <h3 class="title-section f-30">See my past trips ({{pastTripCount}}) </h3>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3" v-for="(i,index) in tripData" :key="index">
                            <router-link  :to="{path:'/trips/detail/'+i.id}" >
                            <div class="hotel-box">
                                <div class="img-holder" v-if="i.single_image!=null">
                                    <img :src="$imagePath+'trips/'+i.single_image.name" alt="hotel" />
                                </div>
                                <div class="img-holder" v-else>
                                    <img :src="$imagePath+'not-available.png'" alt="hotel" />
                                </div>

                                <div class="content-holder">
                                    <div class="d-flex justify-content-between align-self-center mb-2">

                                        <p class="tout-destination">{{i.location}} </p>

                                        <span class="count-rating align-self-center">({{i.total}})</span>
                                    </div>
                                </div>
                            </div>
                             </router-link>
                        </div>
                        
                    </div>
                </div>
                <!--Feedback section-->
                <div class="feedback-sec">
                    <div class="feedback-title d-flex mb-20">
                        <h3 class="align-self-center">Reviews & Feedback</h3>
                        <a href="#" class="align-self-center">
                            <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                            <span class="rating-title align-self-center">4.5</span>
                            <span class="count-rating align-self-center">(14)</span>
                        </a>
                    </div>
                    <div class="d-flex feedback-container  mb-40">
                        <a href="" class="btn btn-feedback-rate">
                            <span>Itinerary </span>
                            <span>
                                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                <span class="rating-title align-self-center">4.5</span>
                            </span>
                        </a>
                        <a href="" class="btn btn-feedback-rate">
                            <span>Activities</span>
                            <span>
                                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                <span class="rating-title align-self-center">4.5</span>
                            </span>
                        </a>
                        <a href="" class="btn btn-feedback-rate">
                            <span>Accommodation</span>
                            <span>
                                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                <span class="rating-title align-self-center">4.5</span>
                            </span>
                        </a>
                        <a href="" class="btn btn-feedback-rate">
                            <span>Transpor </span>
                            <span>
                                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                <span class="rating-title align-self-center">4.5</span>
                            </span>
                        </a>
                        <a href="" class="btn btn-feedback-rate">
                            <span>Meals </span>
                            <span>
                                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                <span class="rating-title align-self-center">4.5</span>
                            </span>
                        </a>
                        <a href="" class="btn btn-feedback-rate">
                            <span>Trip Operator </span>
                            <span>
                                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                <span class="rating-title align-self-center">4.5</span>
                            </span>
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-6">
                            <div class="media">
                                <div class="review-img mr-3">
                                    <img src="/assets/img/profil.jpg" alt="Generic placeholder image">
                                    <h4>Julia S.</h4>
                                </div>
                                <div class="media-body">
                                    <ul class="star-list">
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    </ul>
                                    <div class="review-btnsec d-flex justify-content-between mb-3">
                                        <a href="" class="btn btn-feedback-rate">
                                            <span>Quality</span>
                                            <span>
                                                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                                <span class="rating-title align-self-center">5</span>
                                            </span>
                                        </a>
                                        <a href="" class="btn btn-feedback-rate">
                                            <span>Affordability</span>
                                            <span>
                                                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                                <span class="rating-title align-self-center">5</span>
                                            </span>
                                        </a>
                                        <a href="" class="btn btn-feedback-rate">
                                            <span>Taste</span>
                                            <span>
                                                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                                <span class="rating-title align-self-center">5</span>
                                            </span>
                                        </a>
                                        <a href="" class="btn btn-feedback-rate">
                                            <span>Packing</span>
                                            <span>
                                                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                                <span class="rating-title align-self-center">5</span>
                                            </span>
                                        </a>
                                    </div>
                                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots
                                        in a piece of
                                        classical Latin literature from 45 BC, making it over 2000 years old. </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6">
                            <div class="media">
                                <div class="review-img mr-3">
                                    <img src="/assets/img/profil.jpg" alt="Generic placeholder image">
                                    <h4>Julia S.</h4>
                                </div>
                                <div class="media-body">
                                    <ul class="star-list">
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    </ul>
                                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots
                                        in a piece of
                                        classical Latin literature from 45 BC, making it over 2000 years old. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btnsec mt-4">
                        <a href="#" class="btn btn-showall">Show more</a>
                    </div>
                </div>
                <!--Cancelation Policy-->
                <div class="tripmate-sec mt-5">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="rules-sec">
                                <h4 class="mb-4">Important information</h4>
                                <div class="panel-group" id="accordion">
                                    <!-- First Panel -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title" data-toggle="collapse" data-target="#collapseOne"
                                                aria-expanded="true" aria-controls="collapseOne">Terms & Rules</h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse show">
                                            <div class="panel-body">
                                              {{generalData.terms_rule}}
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Second Panel -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title" data-toggle="collapse" data-target="#collapseTwo">
                                                Cancellation policy</h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse">
                                            <div class="panel-body">
                                               {{generalData.cancellation_policy}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title" data-toggle="collapse" data-target="#collapseThree">
                                                Payment terms</h4>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse">
                                            <div class="panel-body">
                                             {{generalData.payment_terms}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title" data-toggle="collapse" data-target="#collapsefour">
                                                Things to know</h4>
                                        </div>
                                        <div id="collapsefour" class="panel-collapse collapse">
                                            <div class="panel-body">
                                               {{generalData.things_to_know}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="tripsmate-img">
                                <img src="/assets/img/trippp.jpg" alt="img" />
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="stay-in-sec">
                    <h3 class="title-section f-30">You mihght be interested in other guides  </h3>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3" v-for="(i,index) in relatedData" :key="index">
                            <router-link  :to="{path:'/guides/detail/'+i.id}">
                            <div class="hotel-box">
                                 <div class="img-holder" v-if="i.single_image!=null">
                                    <img :src="$imagePath+'guides/'+i.single_image.name" alt="hotel" />
                                </div>
                                <div class="img-holder" v-else>
                                    <img :src="$imagePath+'not-available.png'" alt="hotel" />
                                </div>
                                <div class="content-holder">
    
                                    <p class="guide-name">{{i.guide_user.name}} </p>
                                    <div class="d-flex justify-content-between mt-2">
                                        <p class="host_rating">Top rated  guide <span><img src="/assets/img/icons/badge.png"
                                                    alt=""></span>
                                        <p class="visit-profile"> <a href="#"> Visit profile</a></p>
        
                                    </div>
                                 
                                    <div class="d-flex justify-content-between align-self-center mb-2">
    
                                        
                                        <a href="#">
                                            <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                            <span class="rating-title align-self-center">{{i.rating+'.0'}}</span>
                                            <span class="count-rating align-self-center">({{i.no_of_reviews}})</span>
                                        </a>
                                        <span class="organizer"> {{i.city+','+i.country}}</span>
                                    </div>
    
                                </div>
                            </div>
                            </router-link>
                        </div>
                       
                    </div>
                </div>
            </div>
            
        </main>

</template>

<script>
import {gmapApi} from 'vue2-google-maps'
 export default {
        mode: 'history',
        name: "guideDetail",
        data(){
        return{
        generalData :'',
        relatedData:'',
        userObj :'',
        accCount:'',
        transCount:'',
        tripData:'',
        skillsArray:'',
        expertsArray:'',
        languagesArray:'',
        pastTripCount:'',
        Id: this.$route.params.guideId,
        totalTrips:'',
        };
        
        },
        created(){
        this.idGet();
        google: gmapApi;
        },
        methods:{
        idGet() {
        axios.get("/api/guideDetail/" + this.Id).then((response) => {
        this.generalData = response.data.detail;
        this.relatedData  = response.data.relatedData;
        this.userObj =      response.data.userObj;
        this.tripData =     response.data.tripData;
        this.pastTripCount =   response.data.pastTripCount;
        this.totalTrips =   response.data.totalTrips;
        this.skillsArray =  this.generalData.skills ? this.generalData.skills.split(',') : this.generalData.skills;
        this.expertsArray =  this.generalData.expert ? this.generalData.expert.split(',') : this.generalData.expert;
        this.languagesArray = this.generalData.languages ? this.generalData.languages.split(',') : this.generalData.languages;
       
      });
    },
   updateId(){
   this.Id = this.$route.params.guideId;
   this.idGet();
  
   },     
  },
  watch:{
   $route : 'updateId'
  }
 
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


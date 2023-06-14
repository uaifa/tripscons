<template>
  <main>
    <div class="container">
      <div class="country-banners-sec">
        <div class="row">
          <div class="col-12 col-sm-8 order-2 order-sm-1">
            <div class="banner-imag-parent">
                <div class="main-image" v-if="generalData.images && (generalData.images).length > 0">
                  <template v-for="(main_img, index) in generalData.images">
                    <img v-if="main_img.type == 'main'"
                    :src="$imagePath + 'transports/'+main_img.name" alt="img" />
                  </template>
                    <button
                    class="editimages"
                    data-toggle="modal"
                    data-target="#image-slider"
                  >
                    Show All Images 
                  </button>
                </div>
                <div class="main-image" v-else>
                    <img src="/assets/uploads/users/img1.jpg" alt="img" />
                   
                </div>
                <div v-if="generalData.two_images && (generalData.two_images).length > 0" class="center-images mt-2">
                    <img v-for="(imge, index) in generalData.two_images"
                  :key="index"
                    :src="$imagePath + 'transports/'+imge.name" alt="img" />
                   
                </div>
                <div v-else class="center-images row">
                  <div class="col-12 col-md-4">
                    <img src="/assets/uploads/users/img1.jpg" alt="img" />
                  </div>
                  <div class="col-12 col-md-4">
                     <img src="/assets/uploads/users/img1.jpg" alt="img" />
                  </div>
                  <div class="col-12 col-md-4">
                     <img src="/assets/uploads/users/img1.jpg" alt="img" />
                  </div>
                </div>
                <!-- Modal -->
                <div
                class="modal fade"
                id="image-slider"
                tabindex="-1"
                role="dialog"
                aria-labelledby="image-sliderLabel"
                aria-hidden="true"
              >
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="images-wrapper">
                      <div
                        class="single-image-modal"
                        v-for="(slider_img, index) in generalData.images"
                        :key="index"
                      >
                        <img
                          v-if="slider_img.module == 'transports'"
                          :src="$imagePath + 'transports/' + slider_img.name"
                          alt="img"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="home-details">
              <div class="media mb-4" v-for="(i,index) in generalData.transport_facility" :key="index">
                <img   
                  class="mr-3"
                   :src="'/assets/icons/'+i.image"
                  alt="Generic placeholder image"
                />
                <div class="media-body">
                  <h5 class="mt-0">
                    {{ i.title }}</h5>
                  <p>{{ i.description }}</p>
                </div>
              </div>
            </div>
            <div class="home-details">
              <div class="media mb-4">
                <img class="mr-3" src="/assets/img/icons/car-rent.png" alt="Generic placeholder image">
                <div class="media-body">
                  <h5 class="mt-0">Rental Mode</h5>
                  <p>This car can be booked per hour and per day basis</p>
                </div>
              </div>
              <div class="media mb-4">
                <img class="mr-3" src="/assets/img/icons/shipped.png" alt="Generic placeholder image">
                <div class="media-body">
                  <h5 class="mt-0">Pick & Drop</h5>
                  <p>You’ll get free pick and drop to your location</p>
                </div>
              </div>
              <div class="media mb-4">
                <img class="mr-3" src="/assets/img/icons/insurance.png" alt="Generic placeholder image">
                <div class="media-body">
                  <h5 class="mt-0">Safety & Security</h5>
                  <p>This car is insured and has tracker </p>
                </div>
              </div>
              <div class="media mb-4">
                <img class="mr-3" src="/assets/img/icons/steering-wheel.png" alt="Generic placeholder image">
                <div class="media-body">
                  <h5 class="mt-0">Self drive </h5>
                  <p>This car is not available for self drive  </p>
                </div>
              </div>
            </div>
            <div class="about-txt">
              <h2>About Car</h2>
              <p>
               {{generalData.description}}
              </p>
            </div>
            <div class="custom-title mb-4">
              <h2>Accessories & features</h2>
            </div>
            <div class="home-services">
              <ul>
                <li v-for="(feature,index) in generalData.transport_feature" :key="index">
                  <span class="service-icon align-self-center"
                    ><img   :src="'/assets/icons/'+feature.image"
                  /></span>
                  <span class="service-txt align-self-center">{{feature.title}}</span>
                </li>
                
              </ul>
             
            </div>
            
          </div>
         
          <div class="col-12 col-sm-4 order-1 order-sm-2">
            <div class="hotel-title-sec">
              <h1>{{ generalData.title }}</h1>
            </div>
            <div class="d-flex mt-1 justify-content-start">
              <div>
                <p class="longright">
                  <span
                    >
                  <img
                      class="starr"
                      src="/assets/img/icons/star.png"
                      width="25px"
                      height="25px"
                  />
               
                  </span>
                  <span class="ratingg">{{ generalData.rating}}<span>({{ generalData.no_of_reviews}})</span></span>
                  <span class="booking-count">Booked 150 times</span>
                </p>
              </div>
            </div>
            <div class="d-flex justify-content-between mt-0">
              <p class="vehicle-rent-day">
                Rs.{{ generalData.per_day_price }}/day
              </p>
            </div>
            <div class="d-flex justify-content-between mt-0">
              <p class="vehicle-model">{{ generalData.brand+'  '+generalData.model}}</p>
              <p class="vehicle-location">
                {{ generalData.city + ", " + generalData.country }}
              </p>
            </div>
            <div class="d-flex justify-content-between mt-0">
              <p class="engine-capacity">
                {{
                  generalData.cc + " " + "CC" + " " + generalData.transmission
                }}
                <span class="hybrid-other">{{ generalData.engine }}</span>
              </p>
              <p class="sitting-capacity">
                <span
                  ><img src="/assets/img/icons/capacity1.png" alt="" width="15px" />
                  seats:</span
                >{{ generalData.no_of_people }}
              </p>
            </div>

            <hr class="hr-cust mt-3" />
            <vehicle-booking></vehicle-booking>
           
          </div>
        </div>
      </div>
     
      <div class="location-sec mt-5">
        <h3>Parking Location on map</h3>
        <p><i class="fa fa-map-marker"></i>{{generalData.address+' ,'+' '+generalData.city + ", " + generalData.country }}</p>
        
        <GmapMap   
              :center="{lat:31.582045, lng:74.329376}"
              :zoom="7"   
              map-type-id="terrain"
              style="width: 100%; height: 350px"
            >
             
        </GmapMap>
      </div>
      <div class="about-host"  v-if="userObj.type =='2'">
        <h3>About Host</h3>
        <div class="row">
          <div class="col-12 col-sm-4 col-md-5">
            <div class="host-profilesec">
              <div class="row">
                <div class="col-12 col-sm-6 col-md-6">
                  <div class="img-holder">
                    <img
                      :src="'/assets/uploads/users/'+userObj.image"
                      alt="img"
                    />    
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6">
                  <div class="host-name">
                    <div class="top-rated">
                      <a href="#" class="btn btn-ribbon ripple">
                        <span class="icon-holder"
                          ><img src="/assets/img/icons/ribbon.png" alt="img"
                        /></span>
                        Top rated host</a
                      >
                    </div>
                    <h5 class="mt-0">{{userObj.name}}</h5>
                    <p>{{userObj.city+','+userObj.country}}</p>
                    <router-link  :to="{path:'/hosts/detail/'+userObj.id}" class="btn btn-contacthost ripple">
                  
                    Contact host
                    </router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-8 col-md-7">
            <div class="host-tab">
              <ul class="d-flex">
                <li class="justify-content-between align-self-center">
                  <a href="#">
                    <span
                      class="
                        rating-title
                        d-flex
                        align-self-center
                        justify-content-center
                      "
                      >{{userObj.rating+'.0'}}<span class="rating"><i class="fa fa-star"></i></span
                    ></span>
                    <span class="rate-review">{{userObj.no_of_reviews}} reviews</span>
                  </a>
                </li>
                <li class="justify-content-between align-self-center">
                  <span>100 <br />times hosted</span>
                </li>
                <li class="justify-content-between align-self-center">
                  <span>90% <br />respose rate</span>
                </li>
                <li class="justify-content-between align-self-center">
                  <span>1 hour <br />respose time</span>
                </li>
              </ul>
            </div>
            <div class="abouthost">
              <h4>About {{userObj.name}}</h4>
              <p>
               {{userObj.about}}
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="vehicles-sec detail-page-vehicles" v-if="userObj.type =='2'">
        <h3 class="title-section">Other host services</h3>
        <div class="row">
         
          <div class="col-12 col-sm-4">
             <router-link  :to="{path:'/accommodations/'}">
            <div class="vehicles-box">
              <a href="#">
                <img src="/assets/img/hotel-2.jpg" alt="img" />
                <div class="d-flex justify-content-between align-self-center">
                  <strong>Accomodation</strong>
                  <a href="#"><strong> {{accCount}}</strong></a>
                </div>
              </a>
            </div>
             </router-link>
          </div>
         
          <div class="col-12 col-sm-4">
            <router-link  :to="{path:'/meals/'}">
            <div class="vehicles-box">
              <a href="#">
                <img src="/assets/img/home_1.jpg" alt="img" />
                <div class="d-flex justify-content-between align-self-center">
                  <strong> Meals</strong>
                  <a href="#"><strong> {{mealCount}}</strong></a>
                </div>
              </a>
            </div>
            </router-link>
          </div>
          <div class="col-12 col-sm-4">
            <router-link  :to="{path:'/experiences/'}">
            <div class="vehicles-box">
              <a href="#">
                <img src="/assets/img/activity-1.png" alt="img" />
                <div class="d-flex justify-content-between align-self-center">
                  <strong> Activities</strong>
                  <a href="#"><strong>{{ activityCount}}</strong></a>
                </div>
              </a>
            </div>
            </router-link>
          </div>
        </div>
      </div>
      <div class="feedback-sec">
        <div class="feedback-title d-flex mb-20">
          <h3 class="align-self-center">Rating & Reviews</h3>
          <a href="#" class="align-self-center">
            <span class="rating align-self-center"
              ><i class="fa fa-star"></i
            ></span>
            <span class="rating-title align-self-center">4.5</span>
            <span class="count-rating align-self-center">(14)</span>
          </a>
        </div>
        <div class="d-flex justify-content-between mb-40">
          <a href="" class="btn btn-feedback-rate">
            <span>Comfort </span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
          <a href="" class="btn btn-feedback-rate">
            <span>Condition </span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
          <a href="" class="btn btn-feedback-rate">
            <span>Fuel average</span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
          <a href="" class="btn btn-feedback-rate">
            <span>Safety</span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-6">
            <div class="media">
              <div class="review-img mr-3">
                <img src="/assets/img/profil.jpg" alt="Generic placeholder image" />
                <h4>Julia S.</h4>
              </div>
              <div class="media-body">
                <ul class="star-list">
                  <li>
                    <a href="#"><i class="fa fa-star"></i></a>
                  </li>
                  <li>
                    <a href="#"><i class="fa fa-star"></i></a>
                  </li>
                  <li>
                    <a href="#"><i class="fa fa-star"></i></a>
                  </li>
                  <li>
                    <a href="#"><i class="fa fa-star"></i></a>
                  </li>
                  <li>
                    <a href="#"><i class="fa fa-star"></i></a>
                  </li>
                </ul>
                <div class="review-btnsec d-flex justify-content-between mb-3">
                  <a href="" class="btn btn-feedback-rate">
                    <span>Comfort</span>
                    <span>
                      <span class="rating align-self-center"
                        ><i class="fa fa-star"></i
                      ></span>
                      <span class="rating-title align-self-center">5</span>
                    </span>
                  </a>
                  <a href="" class="btn btn-feedback-rate">
                    <span>Condition</span>
                    <span>
                      <span class="rating align-self-center"
                        ><i class="fa fa-star"></i
                      ></span>
                      <span class="rating-title align-self-center">5</span>
                    </span>
                  </a>
                  <a href="" class="btn btn-feedback-rate">
                    <span>Fuel average</span>
                    <span>
                      <span class="rating align-self-center"
                        ><i class="fa fa-star"></i
                      ></span>
                      <span class="rating-title align-self-center">5</span>
                    </span>
                  </a>
                  <a href="" class="btn btn-feedback-rate">
                    <span>Safety</span>
                    <span>
                      <span class="rating align-self-center"
                        ><i class="fa fa-star"></i
                      ></span>
                      <span class="rating-title align-self-center">5</span>
                    </span>
                  </a>
                </div>
                <p>
                  Contrary to popular belief, Lorem Ipsum is not simply random
                  text. It has roots in a piece of classical Latin literature
                  from 45 BC, making it over 2000 years old.
                </p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-6">
            <div class="media">
              <div class="review-img mr-3">
                <img src="/assets/img/profil.jpg" alt="Generic placeholder image" />
                <h4>Julia S.</h4>
              </div>
              <div class="media-body">
                <ul class="star-list">
                  <li>
                    <a href="#"><i class="fa fa-star"></i></a>
                  </li>
                  <li>
                    <a href="#"><i class="fa fa-star"></i></a>
                  </li>
                  <li>
                    <a href="#"><i class="fa fa-star"></i></a>
                  </li>
                  <li>
                    <a href="#"><i class="fa fa-star"></i></a>
                  </li>
                  <li>
                    <a href="#"><i class="fa fa-star"></i></a>
                  </li>
                </ul>
                <p>
                  Contrary to popular belief, Lorem Ipsum is not simply random
                  text. It has roots in a piece of classical Latin literature
                  from 45 BC, making it over 2000 years old.
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="btnsec mt-4">
          <a href="#" class="btn btn-showall">Show more</a>
        </div>
      </div>
      <div class="tripmate-sec">
        <div class="row">
          <div class="col-12 col-sm-6">
            <div class="rules-sec">
              <h4 class="mb-4">Important information</h4>
              <div class="panel-group" id="accordion">
                <!-- First Panel -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4
                      class="panel-title"
                      data-toggle="collapse"
                      data-target="#collapseOne"
                      aria-expanded="true"
                      aria-controls="collapseOne"
                    >
                      Rules
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse show">
                    <div class="panel-body">
                       <li v-for="(i, index) in rules" :key="index">  {{ i.name}}</li>
                    </div>
                  </div>
                </div>
                <!-- Second Panel -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4
                      class="panel-title"
                      data-toggle="collapse"
                      data-target="#collapseTwo"
                    >
                      Cancellation policy
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                       {{generalData.cancellation_policy}}
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4
                      class="panel-title"
                      data-toggle="collapse"
                      data-target="#collapseThree"
                    >
                      Important info
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">
                      {{generalData.important_info}}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <div class="tripsmate-img">
              <img src="/assets/img/tripmate.png" alt="img" />
            </div>
          </div>
        </div>
      </div>
      <div class="stay-in-sec">
        <h3 class="title-section f-30">More similar cars for you</h3>
        <div class="row">
          <div class="col-12 col-sm-3" v-for="(i,index) in relatedData" :key="index">
            <router-link  :to="{path:'/vechiles/detail/'+i.id}">
            <div class="hotel-box">
              <div class="img-holder" v-if="i.single_image != null">
                <img :src="$imagePath+'transports/'+i.single_image.name" alt="vechile" />
              </div>
              <div class="img-holder" v-else>
                <img  src="/assets/img/country-1.jpg" alt="img" />
              </div>
              <div class="room-cap">
                <img src="/assets/img/person-add.png" alt="icon"/>
                <small>up to <br />4 </small>
              </div>
              <div class="content-holder">
                <p class="vehicle-model">{{ i.title+'  '+i.model }}</p>
                <div
                  class="d-flex justify-content-between align-self-center mb-2"
                >
                  <h3 class="align-self-center">{{ i.city+','+i.country }}</h3>
                  <a href="#">
                    <span class="rating align-self-center"
                      ><i class="fa fa-star"></i
                    ></span>
                    <span class="rating-title align-self-center">4.5</span>
                    <span class="count-rating align-self-center">(14)</span>
                  </a>
                </div>
                <a href="#" class="btn btn-price"> Rs  {{i.per_day_price}} / <span>Day</span></a>
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
import VueTimepicker from "vue2-timepicker/src/vue-timepicker.vue";
export default {
  mode: 'history',
  name: "vechileDetail",
  data() {
    return {
      generalData: "",
      relatedData: "",
      userObj:"",
      accCount:"",
      mealCount:"",
      activityCount:"",
      Id: this.$route.params.vechileId,
      rules:[],
      pickup_time: "09:00:00",
      dropoff_time: "12:00:00",
           
    };
  },
  components: {
    VueTimepicker,
  },
  created() {
    this.idGet();
   },
  methods: {
    idGet() {
     
        axios.get("/api/vechileDetail/" + this.Id).then((response) => {
        this.generalData = response.data.data;
        this.relatedData  = this.generalData.relatedData;
        this.userObj =      this.generalData.userObj;
        this.accCount =     this.generalData.accommodationCount;
        this.mealCount  =   this.generalData.mealCount;
        this.activityCount  =   this.generalData.activityCount;
        this.rules = response.data.data.rules;
      });
    },
   updateId(){
   this.Id = this.$route.params.vechileId;
   this.idGet();
  
   }, 
  },
  
  watch:{
   $route : 'updateId'
  }
};
</script>
<style scoped>
#image-slider .modal-content {
  background: transparent !important;
}
.images-wrapper {
  display: flex;
  flex-wrap: wrap;
}
.images-wrapper .single-image-modal {
  flex: 1 1 98%;
  margin: 4px 0px;
}
.images-wrapper .single-image-modal img {
  width: 100%;
  height: 97vh;
}
.slide-photos {
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
.center-img-holder:hover,
.larger-img-holder:hover,
.single-image-modal:hover {
  filter: brightness(0.6);
}
</style>


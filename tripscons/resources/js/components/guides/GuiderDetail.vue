<template>
  <div class="profilee-detail container py-5">
    <div class="row">
      <div class="col-12 col-sm-4 col-md-4">
        <!--profile info section-->
        <div class="profile-left p-4">
          <div class="row image-sction px-2">
            <div class="">
              
              <div v-if="userObj && userObj.service_provider.image" class="img-container">
                <img :src="$userImagePath + userObj.service_provider.image" class="img-fluid" />
                <span class="user-status"></span>
              </div>
            </div>
            <div class="ml-3">
              <div class="profile-bio">
                <h2 v-if="userObj.service_provider">{{ userObj.service_provider.name }}</h2>
                <h4 v-if="userObj.service_provider">{{ userObj.service_provider.country + "," + userObj.service_provider.city }}</h4>
                <p>Member since <span v-if="userObj.service_provider">{{ userObj.service_provider.created_at | formatDate }}</span></p>
              </div>
            </div>
          </div>

          <!--comments section-->
          <div class="row comment-section mt-4 px-2">
            <div>
              <span v-if="userObj.service_provider">{{ userObj.service_provider.comments }}</span>
              <span>Comments</span>
            </div>
            <div>
              <span v-if="userObj.service_provider">{{ userObj.service_provider.tripsCount }}</span>
              <span>Trips</span>
            </div>
            <div>
              <span v-if="userObj.service_provider">{{ userObj.service_provider.tripFriends }}</span>
              <span>Tripfriends</span>
            </div>
            <div>
              <span v-if="userObj.service_provider">{{ userObj.service_provider.feedbacks }}</span>
              <span>Feedbacks</span>
            </div>
          </div>

          <div class="row mt-4 px-3 profile-intro">
            <p v-if="userObj.service_provider">
              {{ userObj.service_provider.about }}
            </p>
          </div>
          <div class="row mt-4 px-3 profile-intro">
            <span v-if="userObj.service_provider && userObj.service_provider.type == 1" class="text-left">
              <h6>Destinations </h6>
              <p>
                <span v-if="userObj.service_provider.service_provider_rates != null">
                  <div class="specialities">
                    <ul v-if="destinations.length > 0">
                        <li v-for="dest in destinations">
                          {{ dest.location }}
                        </li>
                       
                    </ul>
                </div>
                </span>
              </p>

             
              <h6>Languages</h6>
              <p>
                <span v-if="userObj.service_provider.service_provider_rates != null">
                  {{ userObj.service_provider.service_provider_rates.languages}}
                </span>
              </p>
              <h6>Price per hour rate</h6>
              <p>
                <span v-if="userObj.service_provider.service_provider_rates != null">
                  {{ userObj.service_provider.service_provider_rates.price_per_hour_rate}}
                </span>
                <span v-else>
                  0
                </span>
              </p>
              <h6>Price per day rate</h6>
              <p>
                <span v-if="userObj.service_provider.service_provider_rates != null">
                  {{ userObj.service_provider.service_provider_rates.price_per_day_rate}}
                </span>
                <span v-else>
                  0
                </span>
              </p>
              <h6>Group discount</h6>
              <p>
                <span v-if="userObj.service_provider.service_provider_rates != null">
                  {{ userObj.service_provider.service_provider_rates.group_discount}}
                </span>
                <span v-else>
                  0
                </span>
              </p>  
            </span>
          </div>
          <div class="d-flex mt-3">
            <button class="btn btn-whitee">
              Book Now
            </button>
          </div>
         
        </div>
        <div class="discuss mt-2 px-2 py-4">
          <div class="col-7">
            <h2>have some issues?</h2>
            <p>Let our team know, we will help you!</p>
          </div>
          <div class="col-5 d-flex align-items-center">
            <button class="btn btn-whitee">Contact us</button>
          </div>
        </div>
      </div>
        
      <div class="col-12 col-sm-8 col-md-8">
          
      <span>
        <div class="profile-right p-5">
          <div class="stay-in-sec">
            <div class="d-flex justify-content-between my-2">
              <h3 class="title-section f-30"> {{ page_type || 'Guides' }} </h3>
            </div>
              
            <div class="row">
              <div v-if="userObj && (packages.data).length > 0 && userObj.service_provider.type == 1"
                class="col-12 col-sm-4"
                v-for="(guide, index) in packages.data"
                :key="index">
                <router-link
                  :to="{
                    path: '/guides/details/' + guide.id,
                  }" >
                    
                  <div class="hotel-box">
                    <div class="img-holder">
                        <template v-if="(guide.images).length > 0" v-for="images in guide.images">
                            <img v-if="images.type == 'main' " :src="`${$imagePath}guides/${images.name}`" />
                            
                        </template>
                      <img v-if="(guide.images).length < 1" src="/assets/uploads/users/img1.jpg" alt="img" />
                    </div>
                    <div class="room-cap">
                      <img src="/assets/img/person-add.png" alt="icon" />
                      <small>up to <br />12 </small>
                    </div>
                    <div class="content-holder">
                      <small v-if="guide.city != null">
                        <img src="/assets/img/map-pin.png" alt="icon"  />
                        {{ guide.city }} <span>1700 miles away</span>
                      </small>
                      <small v-else>
                        <img src="/assets/img/map-pin.png" alt="icon" />
                      </small>
                      <div
                        class="
                          d-flex
                          justify-content-between
                          align-self-center
                          mb-2
                        " >
                        <h3
                          class="align-self-center"
                          v-if="guide && guide.country != null"
                        >
                          from {{ guide.country }}
                        </h3>
                        <a href="#">
                          <span class="rating align-self-center"
                            ><i class="fa fa-star"></i
                          ></span>
                          <span
                            class="rating-title align-self-center"
                            v-if="guide.rating != null"
                            >{{ guide.rating }}(0)</span
                          >
                          <span
                            class="count-rating align-self-center"
                            v-if="guide.no_of_reviews != null"
                            >({{ guide.no_of_reviews }})</span
                          >
                        </a>
                      </div>
                      
                    </div>
                  </div>
                </router-link>
              </div>

              <div v-if="userObj && (packages.data).length < 1 " class="col-12">
                   <h4 class="text-center">
                    Record not found!
                  </h4>
              </div>
            </div>
          </div>
          <pagination
            :data="packages"
            @pagination-change-page="getResults"
          ></pagination>
        </div>
        
        <!-- <ServiceProvider :userObjects="userObj.guides" /> -->
      </span>
      
      </div>

      </div>
<!--Ui section start-->
<div class="row mt-5">
  <div class="col-12 col-sm-6 col-md-6">
     
  </div>
</div>    
    <change-password></change-password>
  </div>
</template>

<script>

import ServiceProvider from '../services/guides/Index.vue';

export default {
  name: "UserDashboard",
  components:{
    ServiceProvider
  },

  data() {
    return {
      email: "",
      password: "",
      error: "",
      userObj: "",
      Id: this.$route.params.guiderId,
      destinations: [],
      packages: [],
      page_type: '',
    };
  },
  created() {
    this.getUserProfile();
  },
  methods: {
    logout() {
      localStorage.removeItem("user-token");
      window.location.href = '/';
    },
    getUserProfile() {

      axios.post("/api/getGuidePackages/"+this.Id).then((response) => {
        this.userObj = response.data.data;
        this.packages = this.userObj.packages ? this.userObj.packages : [];
        this.destinations = this.userObj.service_provider.service_provider_rates ? this.userObj.service_provider.service_provider_rates.destinations : [];
        if(this.destinations.length > 0){
          this.destinations =  JSON.parse(this.destinations);
        }

        if(this.userObj.service_provider.user_module_type == 'guides'){
          this.page_type = 'Guides';
        }else if(this.userObj.service_provider.user_module_type == 'trip_mates'){
          this.page_type = 'Trip Mates';
        }else if(this.userObj.service_provider.user_module_type == 'trip_operators'){
          this.page_type = 'Trip Operators';
        }else if(this.userObj.service_provider.user_module_type == 'visa_consultants'){
          this.page_type = 'Visa Consultants';
        }else if(this.userObj.service_provider.user_module_type == 'movie_makers'){
          this.page_type = 'Movie Makers';
        }else if(this.userObj.service_provider.user_module_type == 'photographers'){
          this.page_type = 'Photo Graphers';
        }else if(this.userObj.service_provider.user_module_type == 'trips'){
          this.page_type = 'Trips';
        }else if(this.userObj.service_provider.user_module_type == 'restaurants'){
          this.page_type = 'Restaurants';
        }


      });
    },
    getResults(page) {
      if (typeof page === "undefined") {
        page = 1;
      }

      let bodyFormData = new FormData();
      bodyFormData.append("page", page);
      axios.post("/api/getGuidePackages/"+this.Id, bodyFormData).then((response) => {
        this.userObj = response.data.data;
        this.packages = this.userObj.packages ? this.userObj.packages : [];
        this.destinations = this.userObj.service_provider.service_provider_rates ? this.userObj.service_provider.service_provider_rates.destinations : [];
          if(this.destinations.length > 0){
            this.destinations =  JSON.parse(this.destinations);
          }
      });
    },
  },
};
</script>

<style scoped>
</style>

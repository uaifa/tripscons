<template>
    
      <div class="col-12 col-sm-4 col-md-4">
        <!--profile info section-->
        <div class="profile-left p-4">
          <div class="row image-sction px-2">
            <div class="">
              <div class="img-container">
                <img v-if="userObj.image" :src="$userImagePath + userObj.image" class="img-fluid" />
                <img v-else src="/assets/uploads/not-found.png" alt="img" />
                <span class="user-status"></span>
              </div>
            </div>
            <div class="ml-3">
              <div class="profile-bio">
                <h2>{{ userObj.name }}</h2>
                <h4>{{ userObj.country + "," + userObj.city }}</h4>
                <p>Member since {{ userObj.created_at | formatDate }}</p>
              </div>
            </div>
          </div>

          <!--comments section-->
          <div class="row comment-section mt-4 px-2">
            <div>
              <span>{{ userObj.comments }}</span>
              <span>Comments</span>
            </div>
            <div>
              <span>{{ userObj.tripsCount }}</span>
              <span>Trips</span>
            </div>
            <div>
              <span>{{ userObj.tripFriends }}</span>
              <span>Tripfriends</span>
            </div>
            <div>
              <span>{{ userObj.feedbacks }}</span>
              <span>Feedbacks</span>
            </div>
          </div>

          <div class="row mt-4 px-3 profile-intro">
            <p>
              {{ userObj.about }}
            </p>
          </div>
          <div class="row mt-4 px-3 profile-intro">
            <span v-if="userObj.type == 1" class="text-left">
              <h6>Destinations</h6>
              <span v-if="userObj.service_provider_rates">
                <div class="specialities">
                    <ul v-if="destinations.length > 0">
                        <li v-for="(dest,i) in destinations" :key="i+'_destination'" >
                          {{ dest.location }}
                        </li>
                       
                    </ul>
                </div>

              </span>
              <h6>Languages</h6>
              <p v-if="userObj.service_provider_rates">{{ userObj.service_provider_rates.languages}}</p>
              <h6>Price per hour rate</h6>
              <p v-if="userObj.service_provider_rates"> {{ userObj.service_provider_rates.price_per_hour_rate}}</p>
              <h6>Price per day rate</h6>
              <p v-if="userObj.service_provider_rates">{{ userObj.service_provider_rates.price_per_day_rate}}</p>
              <h6>Group discount</h6>
              <p v-if="userObj.service_provider_rates">{{ userObj.service_provider_rates.group_discount}}</p>  
            </span>
          </div>
          <div class="row mt-4 btn-section">
            <div class="col-md-12 col-lg-6">
              <router-link
                :to="{ path: '/account_info' }"
                class="btn btn-whitee"
              >
                Edit profile</router-link
              >
              <button
                class="btn btn-whitee mt-3"
                data-toggle="modal"
                data-target="#changepassword"
              >
                Change password
              </button>
              <button class="btn btn-whitee my-3" @click.prevent="logout">
                Log out
              </button>
            </div>
            <div class="col-md-12 col-lg-6">
              <button class="btn btn-whitee">Payment methods</button>
            </div>
          </div>
        </div>
        <contact-us></contact-us>
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
    
      password: "",
      userObj: "",
      destinations: [],
    };
  },
  // props:['userObj'],
  created() {
    this.getUserProfile();
  },
  methods: {
    logout() {
      
      localStorage.removeItem("user-token");
      localStorage.removeItem("type");
      localStorage.removeItem("coming-location");
      
      window.location.href = '/';
    },
    getUserProfile() {
      let bodyFormData = new FormData();
      axios.get("/api/getUserProfile", bodyFormData).then((response) => {
        this.userObj = response.data.data;

        this.destinations = response.data.data.service_provider_rates ? response.data.data.service_provider_rates.destinations : [];
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
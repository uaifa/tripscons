<template>
<main>
   <loader v-show="loader"></loader>
  <div class="profilee-detail container py-5">
    <div class="row">
       <user-profile> </user-profile>
     <div class="col-12 col-sm-8 col-md-8">
        <div class="profile-right p-5">
            <div class="row custom-tabs mt-4">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="collapse"
                            href="#collapseExample">Listings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">My Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Reviews</a>
                    </li>
                    <li class="nav-item " @click="loadHostBookings">

                    <a class="nav-link talks" >Bookings<span class="msgs">2</span></a>

                    </li>
                    
                </ul>
            </div>

            <!--country grid-->
            <div class="row country-grid mt-4">
                <div class="countary-item mt-2">
                  <router-link :to="{ path: '/host/accommodations' }" >
                    <div class="images-wrapper">
                        <div class="location-image">
                            <img src="/assets/img/hotel1.jfif" alt="">
                        </div>
                        <div class="location-info mt-2">
                          
                            <span class="hotel-name">Accomodation</span>
                            <span class="country-name">({{accommodationCount}})</span>
                            
                        </div>
                    </div>
                    </router-link>
                </div>
                <div class="countary-item mt-2">
                  <router-link :to="{ path: '/host/transports' }" >
                    <div class="images-wrapper">
                        <div class="location-image">
                            <img src="/assets/img/car3.jpg" alt="">
                        </div>
                        <div class="location-info mt-2">
                            
                            <span class="hotel-name">Vehicles</span>
                            <span class="country-name">({{vechileCount}})</span>
                            
                        </div>
                    </div>
                    </router-link>
                </div>
                <div class="countary-item mt-2">
                    <router-link :to="{ path: '/host/meals' }" >
                    <div class="images-wrapper">
                        <div class="location-image">
                            <img src="/assets/img/meals.jpg" alt="">
                        </div>
                        <div class="location-info mt-2">
                            
                            <span class="hotel-name">Meals</span>
                            <span class="country-name">({{mealCount}})</span>
                            
                        </div>
                    </div>
                    </router-link>
                </div>
                <div class="countary-item mt-2">
                  <router-link :to="{ path: '/host/experiences' }" >
                    <div class="images-wrapper">
                        <div class="location-image">
                            <img src="/assets/img/activities.jpg" alt="">
                        </div>
                        <div class="location-info mt-2">
                        <span class="hotel-name">Activities</span>
                         <span class="country-name">({{activityCount}})</span>
                        </div>
                    </div>
                  </router-link>
                </div>
            </div>
          </div>
      </div>
    </div>
    <change-password></change-password>
  </div>
</main>
</template>

<script>
export default {
  name: "UserDashboard",
  data() {
    return {
      email: "",
      password: "",
      error: "",
      userObj:'',
      mealCount:'',
      activityCount:'',
      accommodationCount:'',
      vechileCount:'',
      loader:true

    };
  },
  created() {
      this.getHostPDashboard();
      this.loader=false;
  },
  methods: {
    logout() {
      localStorage.removeItem("user-token");
      localStorage.removeItem("type");
      localStorage.removeItem("coming-location");
      window.location.href = '/';
    },
    getHostPDashboard() {
      let bodyFormData = new FormData();
      axios.get("/api/getHostDashboard", bodyFormData).then((response) => {
      this.userObj =  response.data.data; 
      this.mealCount = this.userObj.mealCount;
      this.activityCount = this.userObj.activityCount;
      this.accommodationCount = this.userObj.accommodationCount;
      this.vechileCount = this.userObj.vechileCount;
      });
    },
    loadHostBookings(){
       this.$router.push({ path: "/host/bookings" });
      
    }
  },
};
</script>

<style scoped>
</style>

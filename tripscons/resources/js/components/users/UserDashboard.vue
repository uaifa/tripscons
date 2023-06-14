<template>
  <div class="profilee-detail container py-5">
    <div class="row">
      <user-profile :userObj='userObj'> </user-profile>

      <div class="col-12 col-sm-8 col-md-8">
       
      <span v-if="userObj && userObj.type == 1">
        <ServiceProvider :userObjects="userObj.user_services" />
      </span>
        <div v-else class="profile-right p-5">
          <div class="row custom-tabs mt-4">
            <ul class="nav nav-pills nav-fill">
              <li class="nav-item">
                <a
                  class="nav-link active"
                  data-toggle="collapse"
                  href="#collapseExample"
                  >Upcoming trips</a
                >
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Past trips</a>
              </li>
              <li class="nav-item" @click="loadBookings">
              Bookings
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Plans</a>
              </li>
              <li class="nav-item">
                <a class="nav-link talks" href="#"
                  >Talks <span class="msgs">2</span></a
                >
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Invites</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</template>

<script>

import ServiceProvider from '../services/guides/Index';

export default {
  name: "UserDashboard",
  components: {
    ServiceProvider,
  },
   data() {
    return {
      password: "",
      userObj: "",
    };
  },
  created() {
    this.getUserProfile();
  },
  methods: {
    loadBookings(){
    this.$router.push({ path: "/user/bookings" });
    },
    getUserProfile() {
      let bodyFormData = new FormData();
      axios.get("/api/getUserProfile", bodyFormData).then((response) => {
        this.userObj = response.data.data;
      });
    },
 },
};
</script>
<style scoped>
</style>

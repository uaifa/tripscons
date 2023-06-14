<template>
  <div class="create-profile container">
    <!--profile steps-->
    <div class="profile-steps">
      <ul class="d-flex justify-content-around">
        <li class="">
          <img src="/assets/img/icons/feed.png" />
          <p>Personal info</p>
        </li>
        <li class="">
          <img src="/assets/img/icons/services.png" />
          <p>Services</p>
        </li>
        <li class="">
          <img src="/assets/img/icons/ident.png" />
          <p>Identification</p>
        </li>
      </ul>
    </div>
    <!--profile creation-->
    <div class="profile-form py-4">
      <button class="btn btn-host">Host</button>
      <div class="row custom-tabs custom-booking d-flex justify-content-center">
        <ul class="nav nav-pills nav-fill">
          <li class="nav-item">
            <a
              class="nav-link active"
              data-toggle="collapse"
              href="#collapseExample"
              >Accomodation</a
            >
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Vehicles</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Meals</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Activities</a>
          </li>
        </ul>
      </div>
      <form class="mt-4">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-6 pr-4">
            <div class="title-heading steps pl-1">
              <h1>STEP 2</h1>
              <p class="ml-4">Setup pricing</p>
            </div>
            <div class="input-wrapper-single mt-3">
              <input
                type="number"
                class="form-control input_field"
                placeholder="Base price for per night"
                v-model="price"
              />
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-6 px-4 colright">
            <div class="mt-4 facilities">
              <div class="activities-container mt-3">
                <ul class="d-flex activities-count">
                  <li>bedroom</li>
                  <li>swimming pool</li>
                </ul>
              </div>
              <div class="d-flex justify-content-end">
                <a class="btn btn-blackk" @click="updateAccommodation">
                  save & continue
                </a>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "UserDashboard",
  data() {
    return {
      email: "",
      password: "",
      error: "",
      userObj: "",
      price:'0.00',
    };
  },
  created() {
    this.getUserProfile();
  },
  methods: {
    logout() {
      localStorage.removeItem("user-token");
      this.$router.push("/user-login");
    },
    getUserProfile() {
      let bodyFormData = new FormData();
      axios.get("/api/getUserProfile", bodyFormData).then((response) => {
        this.userObj = response.data.userData;
      });
    },

    updateAccommodation() {
      let bodyFormData = new FormData();
      bodyFormData.append("accommodation_id", localStorage.getItem('accommodation_id'));
      bodyFormData.append("per_night", this.price);
      axios.post("/api/accommodationUpdate", bodyFormData).then((response) => {
        // if (response.status == 200) {
        //   this.$swal({
        //     type: "success",
        //     title: "Success!",
        //     text: response.data.message,
        //     timer: 2500,
        //   });
          this.$router.push({ path: "/host/accommodations/add/step4" });
        // } else {
        //   this.$swal({
        //     type: "error",
        //     title: "Error!",
        //     text: response.data.message,
        //     timer: 2500,
        //   });
        // }
      });
    },
  },
};
</script>

<style scoped>
</style>

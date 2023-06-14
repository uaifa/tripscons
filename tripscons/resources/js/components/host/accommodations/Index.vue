<template>
<main>
     <loader v-show="loader"></loader>

  <div class="profilee-detail container py-5">
    <div class="row">
      <div class="col-12 col-sm-4 col-md-4">
        <!--profile info section-->
        <div class="profile-left p-4">
          <div class="row image-sction px-2">
            <div class="">
              <div class="img-container" v-if="userObj.image != null">
                <img :src="$userImagePath + userObj.image" class="img-fluid" />
                <span class="user-status"></span>
              </div>
              <div class="img-container" v-else>
                <img
                  :src="$imagePath + 'not-available.png'"
                  alt="hotel"
                  class="img-fluid"
                />
                <span class="user-status"></span>
              </div>
            </div>
            <div class="ml-3">
              <div class="profile-bio">
                <h2 v-if="userObj.name != null">{{ userObj.name }}</h2>
                <h4 v-if="userObj.country != null">
                  {{ userObj.country + "," + userObj.city }}
                </h4>
                <p v-if="userObj.created_at != null">
                  Member since {{ userObj.created_at | formatDate }}
                </p>
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
        <div class="profile-right pb-5 px-5">
          <div class="d-flex justify-content-start "> 
            <a href="#" type="button" class="btn-back mt-3"> 
              <i class="fa fa-arrow-left mr-2"></i> Back</a>
          </div>
          <div class="stay-in-sec">
            <div class="d-flex justify-content-between my-2">
              <h3 class="title-section f-30">Accomodation</h3>
              <router-link :to="{ path: '/host/accommodations/add/step1' }">
                <button class="btn btn-blackk pl-4">
                  Add New Accomodation
                </button>
              </router-link>
            </div>

            <div class="row">
              <div
                class="col-12 col-sm-4"
                v-for="(accommodation, index) in accommodations.data"
                :key="index"
              >
                <router-link
                  :to="{
                    path: '/host/accommodations/detail/' + accommodation.id,
                  }"
                >
                  <div class="hotel-box">
                    <div class="img-holder">
                      <img
                        :src="
                          $imagePath +
                          'accommodations/' +
                          accommodation.single_image.name
                        "
                        alt="hotel"
                        v-if="accommodation.single_image != null"
                      />
                      <img v-else src="/assets/uploads/users/img1.jpg" alt="img" />
                    </div>
                    <div class="room-cap">
                      <img src="/assets/img/person-add.png" alt="icon" />
                      <small>up to <br />12 </small>
                    </div>
                    <div class="content-holder">
                      <small v-if="accommodation.city != null">
                        <img src="/assets/img/map-pin.png" alt="icon" />
                        {{ accommodation.city }} <span>1700 miles away</span>
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
                        "
                      >
                        <h3
                          class="align-self-center"
                          v-if="accommodation.country != null"
                        >
                          from {{ accommodation.country }}
                        </h3>
                        <a href="#">
                          <span class="rating align-self-center"
                            ><i class="fa fa-star"></i
                          ></span>
                          <span
                            class="rating-title align-self-center"
                            v-if="accommodation.rating != null"
                            >{{ accommodation.rating }}</span
                          >
                          <span
                            class="count-rating align-self-center"
                            v-if="accommodation.no_of_reviews != null"
                            >({{ accommodation.no_of_reviews }})</span
                          >
                        </a>
                      </div>
                      <a
                        href="#"
                        class="btn btn-price"
                        v-if="accommodation.per_night != null"
                        >{{ accommodation.per_night }}Rs / <span>night</span></a
                      >
                    </div>
                  </div>
                </router-link>
              </div>
            </div>
          </div>
          <pagination
            :data="accommodations"
            @pagination-change-page="getHostAccommodation"
          ></pagination>
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
      userObj: "",
      accommodations: {},
      'loader':true
    };
  },
  created() {
    this.getHostAccommodation();
    this.loader = false;
  },
  methods: {
    logout() {
      localStorage.removeItem("user-token");
      this.$router.push("/user-login");
    },
    getHostAccommodation(page) {
      if (typeof page === "undefined") {
        page = 1;
      }

      let bodyFormData = new FormData();
      bodyFormData.append("page", page);
      axios.post("/api/getHostAccommodation", bodyFormData).then((response) => {
        this.userObj = response.data.data.host;
        this.accommodations = response.data.data.accommodations;
      });
    },
  },
};
</script>

<style scoped>
</style>

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
                  <img
                    :src="$imagePath+'/users/'+ generalData.image"
                    class="img-fluid"
                  />
                  <span class="user-status"></span>
                </div>
              </div>
              <div class="ml-3">
                <div class="profile-bio">
                  <h2>{{ generalData.name }}</h2>
                  <h4>{{ generalData.country + "," + generalData.city }}</h4>
                  <p>Member since {{ generalData.created_at | formatDate }}</p>
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

            <div class="row mt-5 btn-sectionn">
              <button class="btn btn-whitee">Contact</button>

              <button class="btn btn-whitee">Invite</button>
            </div>
          </div>
          <div class="about-info mt-2 container p-4">
            <div class="cus-title">
              <h2>About me</h2>
              <p>{{ generalData.about }}</p>
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
              <span v-for="(i, index) in generalData.activity" :key="index">
                <img
                  width="25px"
                  :src="'/assets/img/icons/' + i.image"
                  alt="Tripscon"
                />
                {{ i.name }}</span
              >
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-8 col-md-8">
          <div class="profile-right p-5">
            <div
              class="
                row
                custom-tabs custom-booking
                mt-2
                d-flex
                justify-content-center
              "
            >
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
                <li class="nav-item">
                  <a class="nav-link" href="#">Plans</a>
                </li>
              </ul>
            </div>

            <!--country grid-->
            <div class="row country-grid mt-4">
              <div class="col-sm-12 col-md-4 my-2">
                <!-- <router-link  :to="{path:'/accommodations/'}" :model="model"> -->

                <div class="images-wrapper" @click="shareData('accommodation')">
                  <div class="location-image">
                    <img src="/assets/img/hotel1.jfif" alt="" />
                  </div>

                  <div class="location-info mt-2">
                    <span class="hotel-name">Accommodations</span>
                    <span class="country-name">({{ accCount }})</span>
                  </div>
                </div>
                <!-- </router-link>   -->
              </div>
              <div class="col-sm-12 col-md-4 my-2">
                <div class="images-wrapper" @click="shareData('activity')">
                  <div class="location-image">
                    <img src="/assets/img/hotel2.jpg" alt="" />
                  </div>

                  <div class="location-info mt-2">
                    <span class="hotel-name">Activity</span>
                    <span class="country-name">({{ activityCount }} )</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-4 my-2">
                <div class="images-wrapper" @click="shareData('transport')">
                  <div class="location-image">
                    <img src="/assets/img/hotel3.jfif" alt="" />
                  </div>

                  <div class="location-info mt-2">
                    <span class="hotel-name">Transport</span>
                    <span class="country-name">({{ transCount }})</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-4 my-2">
                <div class="images-wrapper" @click="shareData('meal')">
                  <div class="location-image">
                    <img src="/assets/img/hotel3.jfif" alt="" />
                  </div>

                  <div class="location-info mt-2">
                    <span class="hotel-name">Meal</span>
                    <span class="country-name">({{ mealCount }})</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="cus-title mt-5">
              <h1>Feedbacks</h1>
            </div>
            <div class="row feed-back p-3 mt-4">
              <div class="col-12 col-md-2">
                <div class="img-wrapper">
                  <img src="/assets/img/profile-l.jpg" alt="" srcset="" />
                </div>
                <div class="cus-title mt-2">
                  <p class="ml-2">Julis S.</p>
                </div>
              </div>
              <div class="col-12 col-md-10">
                <div class="rating-feedback">
                  <span class="rating-icons">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="rating-date">22/07/20</span>
                </div>
                <div class="cus-title mt-2">
                  <p>
                    Contrary to popular belief, Lorem Ipsum is not simply random
                    text. It has roots in a piece of classical Latin literature
                    from 45 BC, making it over 2000 years old.
                  </p>
                </div>
              </div>
            </div>
            <div class="row feed-back p-3 mt-3">
              <div class="col-12 col-md-2">
                <div class="img-wrapper">
                  <img src="/assets/img/profile-l.jpg" alt="" srcset="" />
                </div>
                <div class="cus-title mt-2">
                  <p class="ml-2">Julis S.</p>
                </div>
              </div>
              <div class="col-12 col-md-10">
                <div class="rating-feedback">
                  <span class="rating-icons">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                  </span>
                  <span class="rating-date">22/07/20</span>
                </div>
                <div class="cus-title mt-2">
                  <p>
                    Contrary to popular belief, Lorem Ipsum is not simply random
                    text. It has roots in a piece of classical Latin literature
                    from 45 BC, making it over 2000 years old.
                  </p>
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
import { gmapApi } from "vue2-google-maps";
export default {
  name: "mealDetail",
  data() {
    return {
      generalData: "",
      relatedData: "",
      mealCount: "",
      accCount: "",
      transCount: "",
      activityCount: "",
      Id: this.$route.params.hostId,
    };
  },
  created() {
    this.idGet();
    google: gmapApi;
  },
  methods: {
    idGet() {
      axios.get("/api/getHostDetail/" + this.Id).then((response) => {
        //alert(1);
        this.generalData = response.data.data;
       // console.log(this.generalData);
        this.relatedData = this.generalData.relatedData;
        this.accCount = this.generalData.accommodationAccount;
        this.transCount = this.generalData.transportCount;
        this.activityCount = this.generalData.activityCount;
        this.mealCount = this.generalData.mealCount;
      });
    },
    shareData(module) {
      if (module == "accommodation") {
        this.$router.push({
          name: "accommodations",
          params: { data: this.generalData.id },
        });
      }
      if (module == "activity") {
        this.$router.push({
          name: "experiences",
          params: { data: this.generalData.id },
        });
      }
      if (module == "transport") {
        this.$router.push({
          name: "vechiles",
          params: { data: this.generalData.id },
        });
      }
      if (module == "meal") {
        this.$router.push({
          name: "meals",
          params: { data: this.generalData.id },
        });
      }
    },
  },
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


<template>
  <main>
    <div class="profilee-detail container py-5">
        <div class="host-listing">
          <h2 class="title-section">Top rated Hosts</h2>
          <div class="row ">
            <div class="col-12 col-sm-3 "
                 v-for="(genData, index) in generalobjects.data"
                 :key="index"
            >
              <div class="host-listing-box">
                <div class="img-holder">
                  <img src="/assets/img/guide-1.jpg" class="pro-img" alt="img" />
                </div>
                <div class="cotent-holder">
                  <div class="d-flex justify-content-between align-self-center mb-1">
                    <a href="#">
                      <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                      <span class="rating-title align-self-center">4.5</span>
                      <span class="count-rating align-self-center">(14)</span>
                    </a>
                    <h3 class="align-self-center"><img class="mr-1" src="/assets/img/map-pin.png" alt="" srcset="">{{ genData.country }}
                    </h3>
                  </div>
                 <div class="d-flex">

                 <h3 class="mb-1">{{genData.name}}</h3>
                 </div>
                 <div class="specialities">
                  <ul>
                      <li><a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/acommodation.svg" class="mr-1"></span>
                         accommodation</a>
                          </li>
                          <li>
                              <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/vehicles.svg" class="mr-1"></span>

                              vehicles</a>
                              </li>
                              <li> <a href="">
                                  <span class="host-spec mr-1"> <img src="/assets/img/icons/Dishes.svg" class="mr-1"></span>

                                 Meals</a>
                                 </li>
                                  <li>
                                      <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/activity.svg" class="mr-1"></span>
                                      Activities</a>

                                     </li>

                  </ul>
              </div>

                <div class="d-flex justify-content-start">
                    <router-link  :to="{path:'/hosts/detail/'+genData.id}"  tag="img" :src="$imagePath+i.name">see more</router-link>
                </div>
                </div>
              </div>
            </div>

              <pagination
                  :data="generalobjects"
                  @pagination-change-page="getResults"
              ></pagination>

          </div>


        </div>

        <!--Other chefss-->

        <div class="host-listing">
          <h2 class="title-section">Other Hosts</h2>
          <div class="row ">

            <div class="col-12 col-sm-3 ">
              <div class="host-listing-box">
                <div class="img-holder">
                  <img src="/assets/img/guide-1.jpg" class="pro-img" alt="img" />
                </div>
                <div class="cotent-holder">
                  <div class="d-flex justify-content-between align-self-center mb-1">
                    <a href="#">
                      <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                      <span class="rating-title align-self-center">4.5</span>
                      <span class="count-rating align-self-center">(14)</span>
                    </a>
                    <h3 class="align-self-center"><img class="mr-1" src="/assets/img/map-pin.png" alt="" srcset=""> New York</h3>
                  </div>
                 <div class="d-flex">

                 <h3 class="mb-1">Arham Home Cheff</h3>
                 </div>
                 <div class="specialities">
                  <ul>
                      <li><a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/acommodation.svg" class="mr-1"></span>

                         accommodation</a>
                          </li>
                          <li>
                              <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/vehicles.svg" class="mr-1"></span>

                              vehicles</a>
                              </li>
                              <li> <a href="">
                                  <span class="host-spec mr-1"> <img src="/assets/img/icons/Dishes.svg" class="mr-1"></span>

                                 Meals</a>
                                 </li>
                                  <li>
                                      <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/activity.svg" class="mr-1"></span>
                                      Activities</a>

                                     </li>

                  </ul>
              </div>
                <div class="d-flex justify-content-start"> <a href="" class="btn ">See more</a> </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3 ">
              <div class="host-listing-box">
                <div class="img-holder">
                  <img src="/assets/img/guide-1.jpg" class="pro-img" alt="img" />
                </div>
                <div class="cotent-holder">
                  <div class="d-flex justify-content-between align-self-center mb-1">
                    <a href="#">
                      <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                      <span class="rating-title align-self-center">4.5</span>
                      <span class="count-rating align-self-center">(14)</span>
                    </a>
                    <h3 class="align-self-center"><img class="mr-1" src="/assets/img/map-pin.png" alt="" srcset=""> New York</h3>
                  </div>
                 <div class="d-flex">

                 <h3 class="mb-1">Arham Home Cheff</h3>
                 </div>
                 <div class="specialities">
                  <ul>
                      <li><a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/acommodation.svg" class="mr-1"></span>

                         accommodation</a>
                          </li>
                          <li>
                              <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/vehicles.svg" class="mr-1"></span>

                              vehicles</a>
                              </li>
                              <li> <a href="">
                                  <span class="host-spec mr-1"> <img src="/assets/img/icons/Dishes.svg" class="mr-1"></span>

                                 Meals</a>
                                 </li>
                                  <li>
                                      <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/activity.svg" class="mr-1"></span>
                                      Activities</a>

                                     </li>

                  </ul>
              </div>
                <div class="d-flex justify-content-start"> <a href="" class="btn ">See more</a> </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3 ">
              <div class="host-listing-box">
                <div class="img-holder">
                  <img src="/assets/img/guide-1.jpg" class="pro-img" alt="img" />
                </div>
                <div class="cotent-holder">
                  <div class="d-flex justify-content-between align-self-center mb-1">
                    <a href="#">
                      <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                      <span class="rating-title align-self-center">4.5</span>
                      <span class="count-rating align-self-center">(14)</span>
                    </a>
                    <h3 class="align-self-center"><img class="mr-1" src="/assets/img/map-pin.png" alt="" srcset=""> New York</h3>
                  </div>
                 <div class="d-flex">

                 <h3 class="mb-1">Arham Home Cheff</h3>
                 </div>
                 <div class="specialities">
                  <ul>
                      <li><a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/acommodation.svg" class="mr-1"></span>

                         accommodation</a>
                          </li>
                          <li>
                              <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/vehicles.svg" class="mr-1"></span>

                              vehicles</a>
                              </li>
                              <li> <a href="">
                                  <span class="host-spec mr-1"> <img src="/assets/img/icons/Dishes.svg" class="mr-1"></span>

                                 Meals</a>
                                 </li>
                                  <li>
                                      <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/activity.svg" class="mr-1"></span>
                                      Activities</a>

                                     </li>

                  </ul>
              </div>
                <div class="d-flex justify-content-start"> <a href="" class="btn ">See more</a> </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3 ">
              <div class="host-listing-box">
                <div class="img-holder">
                  <img src="/assets/img/guide-1.jpg" class="pro-img" alt="img" />
                </div>
                <div class="cotent-holder">
                  <div class="d-flex justify-content-between align-self-center mb-1">
                    <a href="#">
                      <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                      <span class="rating-title align-self-center">4.5</span>
                      <span class="count-rating align-self-center">(14)</span>
                    </a>
                    <h3 class="align-self-center"><img class="mr-1" src="/assets/img/map-pin.png" alt="" srcset=""> New York</h3>
                  </div>
                 <div class="d-flex">

                 <h3 class="mb-1">Arham Home Cheff</h3>
                 </div>
                 <div class="specialities">
                  <ul>
                      <li><a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/acommodation.svg" class="mr-1"></span>

                         accommodation</a>
                          </li>
                          <li>
                              <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/vehicles.svg" class="mr-1"></span>

                              vehicles</a>
                              </li>
                              <li> <a href="">
                                  <span class="host-spec mr-1"> <img src="/assets/img/icons/Dishes.svg" class="mr-1"></span>

                                 Meals</a>
                                 </li>
                                  <li>
                                      <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/activity.svg" class="mr-1"></span>
                                      Activities</a>

                                     </li>

                  </ul>
              </div>
                <div class="d-flex justify-content-start"> <a href="" class="btn ">See more</a> </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3 ">
              <div class="host-listing-box">
                <div class="img-holder">
                  <img src="/assets/img/guide-1.jpg" class="pro-img" alt="img" />
                </div>
                <div class="cotent-holder">
                  <div class="d-flex justify-content-between align-self-center mb-1">
                    <a href="#">
                      <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                      <span class="rating-title align-self-center">4.5</span>
                      <span class="count-rating align-self-center">(14)</span>
                    </a>
                    <h3 class="align-self-center"><img class="mr-1" src="/assets/img/map-pin.png" alt="" srcset=""> New York</h3>
                  </div>
                 <div class="d-flex">

                 <h3 class="mb-1">Arham Home Cheff</h3>
                 </div>
                 <div class="specialities">
                  <ul>
                      <li><a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/acommodation.svg" class="mr-1"></span>

                         accommodation</a>
                          </li>
                          <li>
                              <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/vehicles.svg" class="mr-1"></span>

                              vehicles</a>
                              </li>
                              <li> <a href="">
                                  <span class="host-spec mr-1"> <img src="/assets/img/icons/Dishes.svg" class="mr-1"></span>

                                 Meals</a>
                                 </li>
                                  <li>
                                      <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/activity.svg" class="mr-1"></span>
                                      Activities</a>

                                     </li>

                  </ul>
              </div>
                <div class="d-flex justify-content-start"> <a href="" class="btn ">See more</a> </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3 ">
              <div class="host-listing-box">
                <div class="img-holder">
                  <img src="/assets/img/guide-1.jpg" class="pro-img" alt="img" />
                </div>
                <div class="cotent-holder">
                  <div class="d-flex justify-content-between align-self-center mb-1">
                    <a href="#">
                      <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                      <span class="rating-title align-self-center">4.5</span>
                      <span class="count-rating align-self-center">(14)</span>
                    </a>
                    <h3 class="align-self-center"><img class="mr-1" src="/assets/img/map-pin.png" alt="" srcset=""> New York</h3>
                  </div>
                 <div class="d-flex">

                 <h3 class="mb-1">Arham Home Cheff</h3>
                 </div>
                 <div class="specialities">
                  <ul>
                      <li><a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/acommodation.svg" class="mr-1"></span>

                         accommodation</a>
                          </li>
                          <li>
                              <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/vehicles.svg" class="mr-1"></span>

                              vehicles</a>
                              </li>
                              <li> <a href="">
                                  <span class="host-spec mr-1"> <img src="/assets/img/icons/Dishes.svg" class="mr-1"></span>

                                 Meals</a>
                                 </li>
                                  <li>
                                      <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/activity.svg" class="mr-1"></span>
                                      Activities</a>

                                     </li>

                  </ul>
              </div>
                <div class="d-flex justify-content-start"> <a href="" class="btn ">See more</a> </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3 ">
              <div class="host-listing-box">
                <div class="img-holder">
                  <img src="/assets/img/guide-1.jpg" class="pro-img" alt="img" />
                </div>
                <div class="cotent-holder">
                  <div class="d-flex justify-content-between align-self-center mb-1">
                    <a href="#">
                      <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                      <span class="rating-title align-self-center">4.5</span>
                      <span class="count-rating align-self-center">(14)</span>
                    </a>
                    <h3 class="align-self-center"><img class="mr-1" src="/assets/img/map-pin.png" alt="" srcset=""> New York</h3>
                  </div>
                 <div class="d-flex">

                 <h3 class="mb-1">Arham Home Cheff</h3>
                 </div>
                 <div class="specialities">
                  <ul>
                      <li><a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/acommodation.svg" class="mr-1"></span>

                         accommodation</a>
                          </li>
                          <li>
                              <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/vehicles.svg" class="mr-1"></span>

                              vehicles</a>
                              </li>
                              <li> <a href="">
                                  <span class="host-spec mr-1"> <img src="/assets/img/icons/Dishes.svg" class="mr-1"></span>

                                 Meals</a>
                                 </li>
                                  <li>
                                      <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/activity.svg" class="mr-1"></span>
                                      Activities</a>

                                     </li>

                  </ul>
              </div>
                <div class="d-flex justify-content-start"> <a href="" class="btn ">See more</a> </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3 ">
              <div class="host-listing-box">
                <div class="img-holder">
                  <img src="/assets/img/guide-1.jpg" class="pro-img" alt="img" />
                </div>
                <div class="cotent-holder">
                  <div class="d-flex justify-content-between align-self-center mb-1">
                    <a href="#">
                      <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                      <span class="rating-title align-self-center">4.5</span>
                      <span class="count-rating align-self-center">(14)</span>
                    </a>
                    <h3 class="align-self-center"><img class="mr-1" src="/assets/img/map-pin.png" alt="" srcset=""> New York</h3>
                  </div>
                 <div class="d-flex">

                 <h3 class="mb-1">Arham Home Cheff</h3>
                 </div>
                 <div class="specialities">
                  <ul>
                      <li><a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/acommodation.svg" class="mr-1"></span>

                         accommodation</a>
                          </li>
                          <li>
                              <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/vehicles.svg" class="mr-1"></span>

                              vehicles</a>
                              </li>
                              <li> <a href="">
                                  <span class="host-spec mr-1"> <img src="/assets/img/icons/Dishes.svg" class="mr-1"></span>

                                 Meals</a>
                                 </li>
                                  <li>
                                      <a href=""><span class="host-spec mr-1"> <img src="/assets/img/icons/activity.svg" class="mr-1"></span>
                                      Activities</a>

                                     </li>

                  </ul>
              </div>
                <div class="d-flex justify-content-start"> <a href="" class="btn ">See more</a> </div>
                </div>
              </div>
            </div>

          </div>
        </div>
    </div>
    </main>

    <!-- Modal for profile start -->

</template>
<script>
import { Slider, SliderItem } from "vue-easy-slider";
export default {
  mode: 'history',
  name: "host",
  components: {
    Slider,
    SliderItem
  },
  data() {
    return {
      generalobjects: {},

      rating: "",
      ratingCustom:"",
      ratingToggle: false,
      isActiverating: false,
      addressCountry:'',
      addressCity:'',
      pos: {
        curTrack: null,
      },
      list: [],
      sliderValue: 2
    };
  },
  created() {
      if(this.$route.query.country || this.$route.query.city) {
          this.addressCountry = this.$route.query.country;
          this.addressCity = this.$route.query.city;
      }
    this.getResults();
    $(".map-view-thumb").clcik(function () {
    });
  },
  methods: {
    getAddressData: function (addressData, placeResultData, id) {
      this.addressCountry = addressData.country;
      this.addressCity = addressData.locality;
      this.getResults();
    },

    accRating(event) {
      this.rating = event.target.value;
    },
    changeIndex(index) {
      this.sliderValue = index;
    },
    getResults(page) {
      if (typeof page === "undefined") {
        page = 1;
      }

      let bodyFormData = new FormData();
      bodyFormData.append("page", page);
      bodyFormData.append("rating", this.rating);
      bodyFormData.append("country", this.addressCountry);
      bodyFormData.append("city", this.addressCity);
      axios.post("/api/host", bodyFormData).then((response) => {
        this.generalobjects = response.data.data;
          console.log(this.generalobjects)
      });
    },


    proRatingToggle: function () {
      this.ratingToggle = !this.ratingToggle;
    },
    ratingTrue() {
      this.ratingToggle = true;
    },
    ratingFalse() {
      this.ratingToggle = false;
    },
    ratingfilter() {
      if(this.rating !=''){
      this.isActiverating = true;
      }

    },

    proRatingClear(){
      this.rating='';
      this.ratingCustom='';
      this.isActiverating = false;
      this.getResults();
    },
  }
  }
</script>
<style scoped>

#custom-slider {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.slider {
    border-radius: 20px;
    border: none;
    box-shadow: -1px 1px 8px #ddd;
}
.slider:before{
  height: 0px;
  width: 0px;
}
div#custom-slider{
  margin-top: 0px;
}

p {
  margin: 0;
}
</style>

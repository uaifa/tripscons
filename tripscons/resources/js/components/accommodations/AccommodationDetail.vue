<template>
  <main>
    <div class="container">
      <div class="country-banners-sec">
        <div class="row">
          <div class="col-12 col-sm-8 order-2 order-sm-1">
           
            <div class="banner-imag-parent">
              <div class="main-image">
                <img
                v-if="mainImageShow"
                :src="$imagePath + 'accommodations/' + main_image"
                alt="img"
              />
                <img v-else src="/assets/uploads/users/img1.jpg" alt="img" />
                <button
                  class="editimages"
                  data-toggle="modal"
                  data-target="#image-slider"
                >
                  Show All Images
                </button>
              </div>
             
              <div class="center-imagess row mt-2" v-if="dataAcc.two_images && (dataAcc.two_images).length > 0">
                <div class="col-12 col-md-4"
                v-for="(imge, index) in dataAcc.two_images"
                :key="index"
                data-toggle="modal"
                data-target="#image-slider"
                >
                <img
                :src="$imagePath + 'accommodations/' + imge.name"
                alt="img"
              />
                </div>
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
            </div>
            
          </div>
          <div class="col-12 col-sm-4 order-1 order-sm-2">
            <div class="hotel-title-sec">
              <h1>{{ dataAcc.title }}</h1>
            </div>
            <div class="d-flex mt-1 justify-content-start">
              <div>
                <p class="longright">
                  <span
                    ><img
                      class="starr"
                      src="/assets/img/icons/star.png"
                      width="25px"
                      height="25px"
                  /></span>
                  <span class="ratingg"
                    >{{ dataAcc.rating }}
                    <span>({{ dataAcc.no_of_reviews }})</span></span
                  >
                </p>
              </div>
            </div>
            <div class="d-flex justify-content-between mt-0">
              <p class="vila-title">{{ dataAcc.type_name }}</p>
              <p class="vila-title">
                {{ dataAcc.city }} , {{ dataAcc.country }}
              </p>
            </div>
            <div class="d-flex cbrudcrums mt-2">
              <ul>
                <li>{{ dataAcc.no_of_people }}guests/</li>
                <li>3 beds/</li>
                <li>3 bedrooms/</li>
                <li>2 baths</li>
              </ul>
            </div>
        

          <accommodation-booking :accommodation="dataAcc"></accommodation-booking>
          </div>
        </div>
      </div>
     <!--Map section-->
     <div class="location-sec mt-3">
      <h3>Location on map</h3>
      <p><i class="fa fa-map-marker"></i> {{ dataAcc.location }}</p>
      <GmapMap
        :center="{ lat: dataAcc.lat, lng: dataAcc.lng }"
        :zoom="7"
        map-type-id="terrain"
        style="width: 100%; height: 350px"
      >
      </GmapMap>
    </div>
      <div class="row hotel-suroundings mt-3">
        <div class="col-12 col-md-4">
          <div class="surrounding-title d-flex">
            <img src="/assets/img/icons/manwalk.png" class="mt-1" />
            <h4 class="ml-3">What's nearby</h4>
          </div>
          <div class="surrounding-list">
            <ul>
              <div v-for="(i, index) in places" :key="index">
                <li v-if="i.type == 'Hotel'">
                  <span class="list-title">{{ i.title }}</span>
                  <span class="list-distance">{{ i.distance }}km</span>
                </li>
              </div>
            </ul>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="surrounding-title d-flex">
            <img src="/assets/img/icons/fork.png" class="mt-1" />
            <h4 class="ml-3">Restaurants & cafes</h4>
          </div>
          <div class="surrounding-list">
            <ul>
              <div v-for="(i, index) in places" :key="index">
                <li v-if="i.type == 'Restaurants'">
                  <span class="list-title">{{ i.title }}</span>
                  <span class="list-distance">{{ i.distance }}km</span>
                </li>
              </div>
            </ul>
          </div>

          <div class="surrounding-title d-flex mt-4">
            <!-- Modal -->

            <img src="/assets/img/icons/sway.png" class="mt-1" />
            <h4 class="ml-3">Top attractions</h4>
          </div>
          <div class="surrounding-list">
            <ul>
              <div v-for="(i, index) in places" :key="index">
                <li v-if="i.type == 'attractions'">
                  <span class="list-title">{{ i.title }}</span>
                  <span class="list-distance">{{ i.distance }}km</span>
                </li>
              </div>
            </ul>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="surrounding-title d-flex">
            <img src="/assets/img/icons/airplane.png" class="mt-1" />
            <h4 class="ml-3">Closest Airports</h4>
          </div>
          <div class="surrounding-list">
            <ul>
              <div v-for="(i, index) in places" :key="index">
                <li v-if="i.type == 'Airports'">
                  <span class="list-title">{{ i.title }}</span>
                  <span class="list-distance">{{ i.distance }}km</span>
                </li>
              </div>
            </ul>
          </div>
        </div>
      </div>
      <div class="about-host">
        <h3>About Host</h3>
        <div class="row">
          <div class="col-12 col-sm-4 col-md-5">
            <div class="host-profilesec">
              <div class="row">
                <div class="col-12 col-sm-6 col-md-6">
                  <div class="img-holder" v-if="userObj.image != null">
                    <img
                      :src="'/assets/uploads/users/' + userObj.image"
                      alt="Host"
                    />
                  </div>
                  <div class="img-holder" v-else>
                    <img :src="$imagePath + 'not-available.png'" alt="Host" />
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6">
                  <div class="host-name">
                    <div class="top-rated">
                      <a href="#" class="btn btn-ribbon ripple">
                        <span class="icon-holder">
                          <img src="/assets/img/icons/ribbon.png" alt="img" />
                        </span>
                        Top rated host</a
                      >
                    </div>
                    <h5 class="mt-0">{{ userObj.name }}</h5>
                    <p>{{ userObj.country + "," + userObj.city }}</p>
                    <router-link
                      :to="{ path: '/hosts/detail/' + userObj.id }"
                      class="btn btn-contacthost ripple"
                      >Contact host</router-link
                    >
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
                      >{{ userObj.rating
                      }}<span class="rating"><i class="fa fa-star"></i></span
                    ></span>
                    <span class="rate-review"
                      >{{ userObj.no_of_reviews }} reviews</span
                    >
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
              <h4>About John</h4>
              <p>{{ userObj.about }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="vehicles-sec detail-page-vehicles">
        <h3 class="title-section">Other host services</h3>
        <div class="row">
          <div class="col-12 col-sm-3">
            <router-link :to="{ path: '/accommodations/' }">
              <div class="vehicles-box">
                <a href="#">
                  <img src="/assets/img/hotel-2.jpg" alt="img" />
                  <div class="d-flex justify-content-between align-self-center">
                    <strong>Accomodation</strong>
                    <a href="#"
                      ><strong> {{ accCount }}</strong></a
                    >
                  </div>
                </a>
              </div>
            </router-link>
          </div>
          <div class="col-12 col-sm-3">
            <router-link :to="{ path: '/vechiles/' }">
              <div class="vehicles-box">
                <a href="#">
                  <img src="/assets/img/car.jpg" alt="img" />
                  <div class="d-flex justify-content-between align-self-center">
                    <strong>Vehicles</strong>
                    <a href="#"
                      ><strong> {{ trans }}</strong></a
                    >
                  </div>
                </a>
              </div>
            </router-link>
          </div>
          <div class="col-12 col-sm-3">
            <router-link :to="{ path: '/meals/' }">
              <div class="vehicles-box">
                <a href="#">
                  <img src="/assets/img/home_1.jpg" alt="img" />
                  <div class="d-flex justify-content-between align-self-center">
                    <strong> Meals</strong>
                    <a href="#"
                      ><strong> {{ mealCount }}</strong></a
                    >
                  </div>
                </a>
              </div>
            </router-link>
          </div>
          <div class="col-12 col-sm-3">
            <router-link :to="{ path: '/experiences/' }">
              <div class="vehicles-box">
                <a href="#">
                  <img src="/assets/img/activity-1.png" alt="img" />
                  <div class="d-flex justify-content-between align-self-center">
                    <strong> Activities</strong>
                    <a href="#"
                      ><strong> {{ actCount }}</strong></a
                    >
                  </div>
                </a>
              </div>
            </router-link>
          </div>
        </div>
      </div>
      <div class="feedback-sec">
        <div class="feedback-title d-flex mb-20">
          <h3 class="align-self-center">Feedback</h3>
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
            <span>Location</span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
          <a href="" class="btn btn-feedback-rate">
            <span>Cleanliness</span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
          <a href="" class="btn btn-feedback-rate">
            <span>Room comfort</span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
          <a href="" class="btn btn-feedback-rate">
            <span>Service quality</span>
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
                <img
                  src="/assets/img/profil.jpg"
                  alt="Generic placeholder image"
                />
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
                    <span>Location</span>
                    <span>
                      <span class="rating align-self-center"
                        ><i class="fa fa-star"></i
                      ></span>
                      <span class="rating-title align-self-center">5</span>
                    </span>
                  </a>
                  <a href="" class="btn btn-feedback-rate">
                    <span>Cleanliness</span>
                    <span>
                      <span class="rating align-self-center"
                        ><i class="fa fa-star"></i
                      ></span>
                      <span class="rating-title align-self-center">5</span>
                    </span>
                  </a>
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
                    <span>Quality</span>
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
                <img
                  src="/assets/img/profil.jpg"
                  alt="Generic placeholder image"
                />
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
                      <li v-for="(i, index) in rules" :key="index">
                        {{ i.name }}
                      </li>
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
                      {{ dataAcc.cancellation_policy }}
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
                      {{ dataAcc.important_info }}
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
        <h3 class="title-section f-30">Near by</h3>
        <div class="row">
          <div
            class="col-12 col-sm-3"
            v-for="(a, index) in nearByAcc"
            :key="index"
          >
            <router-link :to="{ path: '/accommodations/detail/' + a.id }">
              <div class="hotel-box">
                <div class="img-holder">
                  <img
                    v-if="a.single_image != null"
                    :src="$imagePath + 'accommodations/' + a.single_image.name"
                    alt="hotel"
                  />

                  <img
                    v-else
                    :src="$imagePath + 'not-available.png'"
                    alt="Host"
                  />
                </div>
                <div class="room-cap">
                  <img src="/assets/img/person-add.png" alt="icon" />
                  <small>up to <br />12 </small>
                </div>
                <div class="content-holder">
                  <small>
                    <img src="/assets/img/map-pin.png" alt="icon" />
                    {{ a.title }} <span>1700 miles away</span>
                  </small>
                  <div
                    class="
                      d-flex
                      justify-content-between
                      align-self-center
                      mb-2
                    "
                  >
                    <h3 class="align-self-center">{{ a.country }}</h3>
                    <a href="#">
                      <span class="rating align-self-center"
                        ><i class="fa fa-star"></i
                      ></span>
                      <span class="rating-title align-self-center">{{
                        a.rating
                      }}</span>
                      <span class="count-rating align-self-center"
                        >({{ a.no_of_reviews }})</span
                      >
                    </a>
                  </div>
                  <a href="#" class="btn btn-price">
                    {{ a.per_night }}Rs / <span>night</span></a
                  >
                </div>
              </div>
            </router-link>
          </div>
        </div>
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
              v-for="(slider_img, index) in dataAcc.images"
              :key="index"
            >
              <img
                v-if="slider_img.module == 'accommodations'"
                :src="$imagePath + 'accommodations/' + slider_img.name"
                alt="img"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import $ from "jquery";
export default {
  name: "AccommodationDetail",
  data() {
    return {
      dataAcc: "",
      nearByAcc: "",
      userObj: "",
      accCount: "",
      mealCount: "",
      actCount: "",
      trans: "",
      mainImageShow: false,
      otherImageShow: false,
      main_image: "",
      accommodationId: this.$route.params.accommodationId,
      rules: [],
      places: [],
      
    };
  },
  created() {
    
    this.accommodationGet();
    
  },
  
  methods: {
    accommodationGet() {
      axios
        .get("/api/getAccommodationDetail/" + this.accommodationId)
        .then((response) => {
          this.dataAcc = response.data.data;
          if (this.dataAcc.main_image != null || this.dataAcc.images != "") {
            this.mainImageShow = true;
            this.main_image = this.dataAcc.main_image.name;
          }

          if (this.dataAcc.two_images != null || this.dataAcc.images != "") {
            this.otherImageShow = true;
          }

          this.nearByAcc = this.dataAcc.relatedData;
          this.userObj = this.dataAcc.user;
          this.accCount = this.dataAcc.accommodationCount;
          this.mealCount = this.dataAcc.mealCount;
          this.actCount = this.dataAcc.activityCount;
          this.trans = this.dataAcc.transportCount;
          this.rules = this.dataAcc.rules;
          this.places = this.dataAcc.places;
        });
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


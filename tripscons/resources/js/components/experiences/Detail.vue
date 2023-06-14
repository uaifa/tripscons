<template>
  <main>
    <div class="container">
      <div class="country-banners-sec">
        <div class="row">
          <div class="col-12 col-sm-8 order-2 order-sm-1">
            <div class="banner-imag-parent">
           

              <div class="main-image"  v-if="generalData.images && (generalData.images).length > 0">
                  <template v-for="(main_img, index) in generalData.images">
                    <img v-if="main_img.type == 'main'"
                    :src="$imagePath + 'experiences/'+main_img.name" alt="img" />
                  
                  </template>
                    <button
                    class="editimages"
                    data-toggle="modal"
                    data-target="#image-slider"
                  >
                    Show All Images 
                  </button>
                </div>
                <div class="main-image"  v-else>
                    <img src="/assets/uploads/users/img1.jpg" alt="img" />
                   
                </div>

              <div v-if="generalData.two_images && (generalData.two_images).length > 0" class="center-images mt-2">
                <div v-for="(i, index) in generalData.two_images" :key="index">
                  <img
                    v-if="i.name != null"
                    :src="$imagePath + 'experiences/' + i.name"
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
                        v-if="slider_img.module == 'experiences'"
                        :src="$imagePath + 'experiences/' + slider_img.name"
                        alt="img"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
            <div class="about-txt mt-3">
              <h2>About this Activity</h2>
              <p>{{ generalData.about }}</p>
            </div>
          </div>
          <div class="col-12 col-sm-4 order-1 order-sm-2">
            <div class="hotel-title-sec">
              <h2>{{ generalData.title }}</h2>
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
                    >{{ generalData.rating + ".0" }}
                    <span>({{ generalData.no_of_reviews }})</span></span
                  >
                  <span class="booking-count">Booked 250 times</span>
                </p>
              </div>
            </div>
            <div class="d-flex justify-content-between mt-3">
              <p class="activity-category">Activity category</p>
              <p class="activity-value">{{ generalData.category }}</p>
            </div>
            <div class="d-flex justify-content-between mt-3">
              <p class="activity-category">Type</p>
              <p class="activity-value">{{ generalData.type }}</p>
            </div>
            
            <div class="d-flex justify-content-between mt-3">
              <p class="activity-category">Language</p>
              <p class="activity-value">{{ generalData.language }}</p>
            </div>

            <div class="d-flex justify-content-between mt-3">
              <p class="activity-host">Hosted by {{ userObj.name }}</p>
              <p class="activity-value">
                {{ userObj.city }}, {{ userObj.country }}
              </p>
            </div>

            <div class="d-flex justify-content-between mt-2">
              <p class="host_rating">
                Top rated plus host
                <span><img src="/assets/img/icons/badge.png" alt="" /></span>
              </p>

              <p class="visit-profile"><a href="#"> Visit profile</a></p>
            </div>
           
           
            <div class="d-flex justify-content-between mt-3">
              <p class="activity-category">Suitable age</p>
              <p class="activity-value">{{ generalData.suitable_age }}</p>
            </div>

            
          <div class="invoice-box">
            <span v-if="message"  class="booking-error text-warning">{{message}}</span>
              <div class="check-container mt-4">
                <p class="price-perperson">PKR {{price}} per person</p>
                <div class="form-group mt-2">
                  <input
                    class="form-control input_field"
                    type="text"
                    :placeholder=date
                    disabled
                  />
                </div>
                <div class="form-group mt-2">
                  <input
                    class="form-control input_field"
                    type="number"
                    placeholder="Number of adults"
                    v-model="no_of_adults" @keyup="onChangeGuest"/>
                  <input
                    class="form-control input_field mt-3"
                    type="number"
                    placeholder="Number of childs" 
                    v-model="no_of_childs"
                    @keyup="onChangeGuest" />
                </div>
                
                <!-- <div class="d-flex justify-content-center mt-3">
                  <button
                    type="button"
                    class="btn btn-whitee"
                    data-toggle="modal"
                    data-target="#recipies"
                  >
                    Plesae provide other members details
                  </button>
                  <div
                    class="modal fade"
                    id="recipies"
                    role="dialog"
                    aria-labelledby="recipieslLabel"
                    aria-hidden="true"
                  >
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content pb-5">
                        <div class="modal-body">
                          <div class="member-wrapper">
                            <div class="member-item mt-4">
                              <div class="member-name">
                                <input
                                  type="text"
                                  class="form-control input_field"
                                  placeholder="Name"
                                />
                              </div>
                              <div class="member-gender">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option selected>Gender</option>
                                  <option value="male">Male</option>
                                  <option value="female">Feale</option>
                                </select>
                              </div>
                              <div class="member-email">
                                <input
                                  type="email"
                                  class="form-control input_field"
                                  placeholder="email"
                                />
                              </div>
                              <div class="member-status">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option value="adult" selected>Adult</option>
                                  <option value="child">Child</option>
                                </select>
                              </div>
                            </div>
                            <div class="member-item mt-4">
                              <div class="member-name">
                                <input
                                  type="text"
                                  class="form-control input_field"
                                  placeholder="Name"
                                />
                              </div>
                              <div class="member-gender">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option selected>Gender</option>
                                  <option value="male">Male</option>
                                  <option value="female">Feale</option>
                                </select>
                              </div>
                              <div class="member-email">
                                <input
                                  type="email"
                                  class="form-control input_field"
                                  placeholder="email"
                                />
                              </div>
                              <div class="member-status">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option value="adult" selected>Adult</option>
                                  <option value="child">Child</option>
                                </select>
                              </div>
                            </div>
                            <div class="member-item mt-4">
                              <div class="member-name">
                                <input
                                  type="text"
                                  class="form-control input_field"
                                  placeholder="Name"
                                />
                              </div>
                              <div class="member-gender">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option selected>Gender</option>
                                  <option value="male">Male</option>
                                  <option value="female">Feale</option>
                                </select>
                              </div>
                              <div class="member-email">
                                <input
                                  type="email"
                                  class="form-control input_field"
                                  placeholder="email"
                                />
                              </div>
                              <div class="member-status">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option value="adult" selected>Adult</option>
                                  <option value="child">Child</option>
                                </select>
                              </div>
                            </div>
                            <div class="member-item mt-4">
                              <div class="member-name">
                                <input
                                  type="text"
                                  class="form-control input_field"
                                  placeholder="Name"
                                />
                              </div>
                              <div class="member-gender">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option selected>Gender</option>
                                  <option value="male">Male</option>
                                  <option value="female">Feale</option>
                                </select>
                              </div>
                              <div class="member-email">
                                <input
                                  type="email"
                                  class="form-control input_field"
                                  placeholder="email"
                                />
                              </div>
                              <div class="member-status">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option value="adult" selected>Adult</option>
                                  <option value="child">Child</option>
                                </select>
                              </div>
                            </div>
                            <div class="member-item mt-4">
                              <div class="member-name">
                                <input
                                  type="text"
                                  class="form-control input_field"
                                  placeholder="Name"
                                />
                              </div>
                              <div class="member-gender">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option selected>Gender</option>
                                  <option value="male">Male</option>
                                  <option value="female">Feale</option>
                                </select>
                              </div>
                              <div class="member-email">
                                <input
                                  type="email"
                                  class="form-control input_field"
                                  placeholder="email"
                                />
                              </div>
                              <div class="member-status">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option value="adult" selected>Adult</option>
                                  <option value="child">Child</option>
                                </select>
                              </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                              <button class="btn btn-whitee">Proceed</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
   
                <div class="total-invoice">
                  
                  <div
                    class="charges-section mt-3 d-flex justify-content-between"
                  >
                    <p class="service">PKR {{price}} X {{no_of_guest}}</p>
                    <p class="charges">PKR {{sub_total}}</p>
                  </div>
                 

                  <hr class="charges-line" />
                  <div class="charges-section d-flex justify-content-between">
                    <p class="services service-total">Total</p>
                    <p class="charges charges-total">PKR {{total}}</p>
                  </div>
                  <div class="charges-section d-flex justify-content-between">
                    <p class="services service-total">Grand Total</p>
                    <p class="charges charges-total">PKR {{grand_total}}</p>
                  </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                  <button type="button" class="btn btn-reserve" :disabled="isDisabled"
                  @click="bookNow">
                    Book now!
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
   <h2>Slots</h2>

      <table>
        <tr>
          <th>Class Size</th>
          <th>Price</th>
          <th>Date</th>
          <th>Start Time</th>
          <th>Duration</th>
          <th>Location</th>          
          <th>Action</th> 
          
        </tr>
        <tr v-for="(i, index) in slots" :key="index">
          <td>{{ i.class_size }}</td>
          <td>{{ i.price }}</td>
          <td>{{ i.date }}</td>
          <td>{{ i.start_time }}</td>
          <td>{{ i.duration }}</td>
          <td>{{ i.location }}</td>
          <td><button @click="chnageSlot(i.price,i.date,i.id)"></button></td>
          
        </tr>
      </table>
      <!-- <h3 class="mt-3">Trip Facilities</h3> -->
      <div class="trips-facilities-wrapper">
        <div class="facilities-included">
          <div class="rules-sec mt-3">
            <h6 class="mb-4">What’s included?</h6>
            <div class="panel-group" id="accordion">
              <!-- Accomodation -->
              <div
                class="panel panel-default"
                v-for="(i, index) in generalData.experience_facility_included"
                :key="index"
              >
                <div class="panel-heading">
                  <h4
                    class="panel-title"
                    data-toggle="collapse"
                    v-bind:data-target="'#' + index"
                    aria-expanded="true"
                    aria-controls="accomodation"
                  >
                    {{ i.title }}
                  </h4>
                </div>
                <div v-bind:id="index" class="panel-collapse collapse">
                  <div class="panel-body">
                    {{ i.description }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="facilities-excluded">
          <div class="rules-sec mt-3">
            <h6 class="mb-4">What’s excluded?</h6>
            <div class="panel-group" id="accordion">
              <!-- Dinner -->
              <div
                class="panel panel-default"
                v-for="(i, index) in generalData.experience_facility_excluded"
                :key="index"
              >
                <div class="panel-heading">
                  <h4
                    class="panel-title"
                    data-toggle="collapse"
                    v-bind:data-target="'#' + index + 'e'"
                    aria-expanded="true"
                    aria-controls="dinner"
                  >
                    {{ i.title }}
                  </h4>
                </div>
                <div v-bind:id="index + 'e'" class="panel-collapse collapse">
                  <div class="panel-body">
                    {{ i.description }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tripmate-sec mt-5">
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
                      Terms & Rules
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
                      {{ generalData.cancellation_policy }}
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
                      Payment terms
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">
                      {{ generalData.payment_term }}
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4
                      class="panel-title"
                      data-toggle="collapse"
                      data-target="#collapsefour"
                    >
                      Things to know
                    </h4>
                  </div>
                  <div id="collapsefour" class="panel-collapse collapse">
                    <div class="panel-body">
                      {{ generalData.things_to_know }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <div class="tripsmate-img">
              <img src="/assets/img/trippp.jpg" alt="img" />
            </div>
          </div>
        </div>
      </div>
      <div class="cust-title">
        <h2>{{generalData.location}}</h2>
        <GmapMap
          :center="{ lat: 31.582045, lng: 74.329376 }"
          :zoom="7"
          map-type-id="terrain"
          style="width: 100%; height: 350px"
        >
        </GmapMap>
      </div>
      <div class="flex map-wrapper mt-4">
        <p>
          
        </p>
      </div>

      <div class="about-host mt-5"></div>

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
        <div class="d-flex feedback-container mb-40">
          <a href="" class="btn btn-feedback-rate">
            <span>Host</span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
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
            <span>Learning</span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
          <a href="" class="btn btn-feedback-rate">
            <span>Fun </span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
          <a href="" class="btn btn-feedback-rate">
            <span>Value of money </span>
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
                    <span>Quality</span>
                    <span>
                      <span class="rating align-self-center"
                        ><i class="fa fa-star"></i
                      ></span>
                      <span class="rating-title align-self-center">5</span>
                    </span>
                  </a>
                  <a href="" class="btn btn-feedback-rate">
                    <span>Affordability</span>
                    <span>
                      <span class="rating align-self-center"
                        ><i class="fa fa-star"></i
                      ></span>
                      <span class="rating-title align-self-center">5</span>
                    </span>
                  </a>
                  <a href="" class="btn btn-feedback-rate">
                    <span>Learning</span>
                    <span>
                      <span class="rating align-self-center"
                        ><i class="fa fa-star"></i
                      ></span>
                      <span class="rating-title align-self-center">5</span>
                    </span>
                  </a>
                  <a href="" class="btn btn-feedback-rate">
                    <span>Fun</span>
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

      <div class="stay-in-sec">
        <h3 class="title-section f-30">
          You mihght be interested in other indoor activities
        </h3>
        <div class="row">
          <div
            class="col-12 col-sm-6 col-md-3"
            v-for="(i, index) in relatedData"
            :key="index"
          >
            <router-link :to="{ path: '/experiences/detail/' + i.id }">
              <div class="hotel-box">
                <div class="img-holder" v-if="i.single_image != null">
                  <img
                    :src="$imagePath + 'experiences/' + i.single_image.name"
                    alt="hotel"
                  />
                </div>
                <div class="img-holder" v-else>
                  <img :src="$imagePath + 'not-available.png'" alt="hotel" />
                </div>

                <div class="content-holder">
                  <p class="activity_type">{{ i.title }}</p>
                  <div class="d-flex justify-content-between">
                    <span class="organizer"
                      >by {{ userObj.name }} {{ userObj.city }},
                      {{ userObj.country }}
                    </span>
                    <span class="locationn">(Onsite)</span>
                  </div>
                  <p class="activity-category">{{ i.category }}</p>
                  <div
                    class="
                      d-flex
                      justify-content-between
                      align-self-center
                      mb-2
                    "
                  >
                    <a href="#">
                      <span class="rating align-self-center"
                        ><i class="fa fa-star"></i
                      ></span>
                      <span class="rating-title align-self-center">{{
                        i.rating + ".0"
                      }}</span>
                      <span class="count-rating align-self-center"
                        >({{ i.no_of_reviews }})</span
                      >
                    </a>
                    
                  </div>
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

export default {
  mode: "history",
  name: "experienceDetail",
  data() {
    return {
      generalData: "",
      relatedData: "",
      userObj: "",
      accCount: "",
      transCount: "",
      Id: this.$route.params.experienceId,
      slots:[],
      rules:[],
      price:'',   
      date:'',
      experienceSlotId:'',
      per_head: "",
      total: "",
      sub_total: "",
      discount: "",
      grand_total: "",
      isDisabled: true,
      message:'',
      no_of_guest:'',
      no_of_adults:1,
      no_of_childs:0,
    };
  },
  created() {
    this.idGet();
    this.getSlots();
  },
  methods: {
    idGet() {
      axios.get("/api/experienceDetail/" + this.Id).then((response) => {
        this.generalData = response.data.data;
        this.relatedData = response.data.data.relatedData;
        this.userObj = response.data.data.user;
        this.rules = response.data.data.rules;
      });
    },
     getSlots(){
     axios
        .get("/api/getSlots?experience_id=" + this.Id)
        .then((response) => {
          this.slots = response.data.data;
        });  
    },
    updateId() {
      this.Id = this.$route.params.experienceId;
      this.idGet();
    },
    chnageSlot(price,date,experienceSlotId) {
      this.price = price;
      this.date = date;
      this.experienceSlotId = experienceSlotId;

      this.onChangeGuest();
      //alert(this.price+' '+this.date);return
    },
    onChangeGuest() {
      
       if(this.no_of_adults == ""){
        this.message = "Please input guest";
        this.isDisabled = true;
        return;
       }
       if(this.no_of_childs === ""){
        this.message = "Please input childs";
        this.isDisabled = true;
        return;
       }
       if(this.no_of_adults <= 0){
        this.message = "Please input valid guest";
        this.isDisabled = true;
        return;
       }
       if(this.no_of_childs < 0){
        this.message = "Please input valid Childs";
        this.isDisabled = true;
        return;
       }
       if(this.no_of_childs === 'NaN'){
         this.no_of_childs =0;
        this.message = "Please input valid Childs";
        this.isDisabled = true;
        return;
       }
       //this.isDisabled = false;
       
      this.no_of_guest = parseInt(this.no_of_childs) + parseInt(this.no_of_adults);
      this.message = '';
      let bodyFormData = new FormData();
      bodyFormData.append("module_id", this.Id);
      bodyFormData.append("module_name", 'experiences');
      bodyFormData.append("no_of_childs", this.no_of_childs);
      bodyFormData.append("no_of_adults", this.no_of_adults);
      bodyFormData.append("slot_id", this.experienceSlotId);
      axios.post("/api/checkExperienceAvailability", bodyFormData).then((response) => {
          if (response.status == 200) {
            if (response.data.data.availability == true) {
             this.isDisabled = false;
             if(localStorage.getItem('type') == '2' || localStorage.getItem('type') == '1'){
               this.isDisabled = true;
              }
              this.per_head = response.data.data.per_head;
              this.no_of_guest = response.data.data.no_of_guest;
              
              this.total = response.data.data.total;
              this.sub_total = response.data.data.sub_total;
              this.discount = response.data.data.discount;
              this.grand_total = response.data.data.grand_total;
              localStorage.setItem("serviceid", this.Id);
              
            } else {
              this.message = response.data.message;
              this.isDisabled = true;
              return;
            }
        }
        }).catch((err) => {
        this.message = err.response.data.message;
        this.isDisabled = true;
        return;
        });
     
    },
    bookNow() {  
      let bodyFormData = new FormData();
      this.isDisabled = true;
      bodyFormData.append("module_id", this.Id);
      bodyFormData.append("module_name", 'experiences');
      bodyFormData.append("no_of_childs", this.no_of_childs);
      bodyFormData.append("no_of_adults", this.no_of_adults);
      bodyFormData.append("slot_id", this.experienceSlotId);
      axios.post("/api/createExperienceBooking", bodyFormData,this.$helpers.userAuth()).then((response) => {
      if(response.status == 200) {
       localStorage.setItem("booking_id", response.data.data.booking_id);
       this.$router.push({ path: "/bookings/experience-summary" });
      }
      }).catch((err) => {
        this.message = err.response.data.message;   
        this.isDisabled = true;
        return;
        });
   
    },
  },
  watch: {
    $route: "updateId",
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
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td,
th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>


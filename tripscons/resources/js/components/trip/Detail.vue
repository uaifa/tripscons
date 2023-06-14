<template>
  <main>
    <div class="container">
      <div class="country-banners-sec">
        <div class="row">
          <div class="col-12 col-sm-8">
            <div class="banner-imag-parent">
                <div class="main-image" v-for="(main_img, index) in generalData.images"
                  :key="index">
                    <img v-if="main_img.type == 'main'"
                    :src="$imagePath +'trips/' +main_img.name" alt="img" />
                </div>
                <div class="center-images mt-2">
                    <img v-for="(imge, index) in generalData.images"
                  :key="index" v-if="imge.type == 'normal'"
                    :src="$imagePath +'trips/' + imge.name" alt="img" />
                </div>
            </div>

            
          </div>
          <div class="col-12 col-sm-4">
            <div class="hotel-title-sec">
              <h1>{{ generalData.title }}</h1>
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
                    >{{ generalData.rating
                    }}<span>({{ generalData.no_of_reviews }})</span></span
                  >
                  <span class="booking-count">Booked 250 times</span>
                </p>
              </div>
            </div>
            <div class="d-flex justify-content-between mt-2">
              <p class="tout-destination">{{ generalData.title }}</p>
              <p class="tour-rent">Rs.{{ generalData.price }} per person</p>
            </div>
            <div class="d-flex justify-content-between mt-2">
              <p class="persons-rquired">
                Minimum members required for this trip
              </p>
              <p class="person-quantity">{{ generalData.min_members }}</p>
            </div>
            <div class="d-flex justify-content-between mt-2">
              <button class="btn btn-whitee">
                {{ generalData.trip_start_date | formatDate }}–{{
                  generalData.trip_end_date | formatDate
                }}
              </button>
              <button class="btn btn-whitee">10 Days</button>
            </div>
            <div class="d-flex justify-content-between mt-3">
              <p class="tour-host">{{ generalData.brand }}</p>
              <p class="host_rating">
                Top Rated
                <span><img src="/assets/img/icons/ranking.png" alt="" /></span>
              </p>
            </div>

            <div class="d-flex justify-content-between mt-2">
              <p class="visit-profile"><a href="#"> Visit profile</a></p>
              <p class="slots-availbe">Slots left 8</p>
            </div>

            <hr class="hr-cust mt-3" />

            <div class="invoice-box">
              <div class="check-container mt-4">
                <div class="input-wrapperr mt-3">
                  <div class="input-child">
                    <span>Trip Type</span>
                    <select id="inputState" class="form-control input_field">
                      <option selected>Select</option>
                      <option>Solo</option>
                      <option>group</option>
                    </select>
                  </div>

                  <div class="form-group input-child">
                    <span>No. of travellers</span>
                    <input
                      type="text"
                      class="form-control input_field"
                      placeholder="5"
                    />
                  </div>
                </div>

                <div class="d-flex justify-content-center mt-3">
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
                </div>

                <div class="total-invoice">
                  <div
                    class="charges-section mt-3 d-flex justify-content-between"
                  >
                    <p class="service">Rs.15000 x 4</p>
                    <p class="charges">Rs.60000</p>
                  </div>
                  <div
                    class="charges-section mt-3 d-flex justify-content-between"
                  >
                    <p class="service">20% Group discount</p>
                    <p class="charges">Rs.12,000</p>
                  </div>

                  <hr class="charges-line" />
                  <div class="charges-section d-flex justify-content-between">
                    <p class="services service-total">Total</p>
                    <p class="charges charges-total">Rs.4800</p>
                  </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                  <button type="button" class="btn btn-reserve">
                    Book now!
                  </button>
                </div>
              </div>

              <div class="d-flex justify-content-center mt-3">
                <button class="btn btn-whitee">Make custom trip enquiry</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-sm-8">
          <div class="flex map-wrapper mt-4">
            <p>View Destinations on map</p>
          </div>
          <div class="trip-detail-wrapper mt-4">
            <div class="trip-detail-item">
              <span class="trip-detail-heading">Trip type</span>
              <span class="trip-detail-value">Cultural</span>
            </div>
            <div class="trip-detail-item">
              <span class="trip-detail-heading">Group size</span>
              <span class="trip-detail-value">20 people</span>
            </div>
            <div class="trip-detail-item">
              <span class="trip-detail-heading">Activity level</span>
              <span class="trip-detail-value">Moderate</span>
            </div>
            <div class="trip-detail-item">
              <span class="trip-detail-heading">Suitable age </span>
              <span class="trip-detail-value">10 + years old</span>
            </div>
          </div>
          <h3 class="mb-3 discountss mt-4">Discounts</h3>
          <div class="home-details mt-4">
            <div class="media mb-4">
              <img
                class="mr-3"
                src="/assets/img/icons/team.png"
                alt="Generic placeholder image"
              />
              <div class="media-body">
                <p class="mt-2">20 % Group discount for minim 5 people</p>
              </div>
            </div>

            <div class="media mb-4">
              <img
                class="mr-3"
                src="/assets/img/icons/in-love.png"
                alt="Generic placeholder image"
              />
              <div class="media-body">
                <p class="mt-2">10 % Couple discount</p>
              </div>
            </div>
            <div class="media mb-1">
              <img
                class="mr-3"
                src="/assets/img/icons/children.png"
                alt="Generic placeholder image"
              />
              <div class="media-body">
                <p class="mt-2">50 % Child discount less than 10 years</p>
              </div>
            </div>
          </div>
          <h3>Trip activities</h3>
          <div class="activities-container-main mt-4">
            <div
              class="activites-container-item"
              v-for="(i, index) in generalData.trip_activity"
              :key="index"
            >
              <span class="image mr-3"
                ><img :src="'/assets/img/icons/' + i.image" alt=""
              /></span>
              <span class="title">{{ i.name }}</span>
            </div>
          </div>
        </div>
      </div>
      <h3 class="mt-3">Previous trip videos</h3>
      <div class="row trip-videos my-4">
        <div
          class="col-sm-12 col-md-4"
          v-for="(i, index) in relatedData"
          :key="index"
        >
          <router-link :to="{ path: '/trips/detail/' + i.id }">
            <div class="embed-responsive embed-responsive-16by9">
              <iframe
                class="embed-responsive-item"
                :src="i.video"
                allowfullscreen
              ></iframe>
            </div>
          </router-link>
        </div>
      </div>

      <h3 class="mt-3">Trip Facilities</h3>
      <div class="trips-facilities-wrapper">
        <div class="facilities-included">
          <div class="rules-sec mt-3">
            <h6 class="mb-4">What’s included?</h6>
            <div class="panel-group" id="accordion">
              <!-- Accomodation -->
              <div
                class="panel panel-default"
                v-for="(i, index) in generalData.trip_facility_included"
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
                v-for="(i, index) in generalData.trip_facility_excluded"
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
      <div class="about-txt mt-3">
        <h2>About this Trip</h2>
        <p>
          {{ generalData.about_trip }}
        </p>
      </div>

      <div class="itinerary col-8">
        <div class="rules-sec">
          <h4 class="mb-3">Itinerary</h4>
          <div class="panel-group" id="accordion">
            <!-- Second Panel -->
            <div
              class="panel panel-default"
              v-for="(i, index) in generalData.trip_itinerary"
              :key="index"
            >
              <div class="panel-heading">
                <h4
                  class="panel-title collapsed"
                  data-toggle="collapse"
                  v-bind:data-target="'#' + index + 't'"
                >
                  Day {{ index }}: {{ i.title }}
                </h4>
              </div>
              <div v-bind:id="index + 't'" class="panel-collapse collapse">
                <div class="panel-body">
                  {{ i.description }}
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
                  <div id="collapseOne" class="panel-collapse collapse">
                    <div class="panel-body">
                      {{ generalData.terms_rule }}
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
            <span>Itinerary </span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
          <a href="" class="btn btn-feedback-rate">
            <span>Activities</span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
          <a href="" class="btn btn-feedback-rate">
            <span>Accommodation</span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
          <a href="" class="btn btn-feedback-rate">
            <span>Transpor </span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
          <a href="" class="btn btn-feedback-rate">
            <span>Meals </span>
            <span>
              <span class="rating align-self-center"
                ><i class="fa fa-star"></i
              ></span>
              <span class="rating-title align-self-center">4.5</span>
            </span>
          </a>
          <a href="" class="btn btn-feedback-rate">
            <span>Trip Operator </span>
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
                    <span>Taste</span>
                    <span>
                      <span class="rating align-self-center"
                        ><i class="fa fa-star"></i
                      ></span>
                      <span class="rating-title align-self-center">5</span>
                    </span>
                  </a>
                  <a href="" class="btn btn-feedback-rate">
                    <span>Packing</span>
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
          You might be interested in other trips of this operator
        </h3>
        <div class="row">
          <div
            class="col-12 col-sm-6 col-md-3"
            v-for="(i, index) in relatedData"
            :key="index"
          >
            <router-link :to="{ path: '/trips/detail/' + i.id }">
              <div class="hotel-box">
                <div class="img-holder" v-if="i.single_image != null">
                  <img :src="$imagePath +'trips/'+ i.single_image.name" alt="hotel" />
                </div>
                <div class="img-holder" v-else>
                  <img :src="$imagePath + 'not-available.png'" alt="hotel" />
                </div>
                <div class="content-holder">
                  <p class="tout-destination">{{ i.title }}</p>
                  <div
                    class="
                      d-flex
                      justify-content-between
                      align-self-center
                      mb-2
                    "
                  >
                    <h3 class="align-self-center tour-rent">
                      3 Days Rs.{{ i.price }}
                    </h3>
                    <a href="#">
                      <span class="rating align-self-center"
                        ><i class="fa fa-star"></i
                      ></span>
                      <span class="rating-title align-self-center">{{
                        i.rating
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
                v-if="slider_img.module == 'trip'"
                :src="$imagePath +'trips/'+ slider_img.name"
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
export default {
  name: "tripDetail",
  data() {
    return {
      generalData: "",
      relatedData: "",
      userObj: "",
      accCount: "",
      transCount: "",
      Id: this.$route.params.tripId,
    };
  },
  created() {
    this.idGet();
  },
  methods: {
    idGet() {
      axios.get("/api/tripDetail/" + this.Id).then((response) => {
        this.generalData = response.data.data;
        this.relatedData = this.generalData.relatedData;
        this.userObj = this.generalData.user;
        this.accCount = this.generalData.accommodationAccount;
        this.transCount = this.generalData.transportCount;
        this.activityCount = this.generalData.activityCount;
      });
    },
    updateId() {
      this.Id = this.$route.params.tripId;
      this.idGet();
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
</style>


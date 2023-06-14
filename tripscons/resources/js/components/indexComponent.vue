<template>
    <main>
      <!-- <loader v-show="loader"></loader> -->
        <div class="banner">

          <div class="container">
            <div class="banner-centent">
              <div class="search-form-sec">
                <ul>
                  <li>
                    <a href="javascript:void(0);" type="submit" class="btn btn-md btn-search btn-white ripple" data-toggle="modal" data-target="#where-to-go">
                      <span class="icon-input"><i class="fa fa-search"></i></span> Going to?
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" type="submit" data-toggle="modal" data-target="#custom-trip" class="btn btn-md btn-search ripple"> Get a quote!</a>
                  </li>
                </ul>
              </div>


              <div class="action-log-sec">
                <div class="row">
                  <div class="col-12 col-sm-3">
                    <router-link  :to="{path:'/accommodations/'}">

                    <div class="action-box">
                      <a href="#">
                        <div class="icon-holder">
                          <img src="/assets/img/icons/home.png" alt="img" />
                        </div>

                        <strong>Villa or tent? <br />You decide</strong>
                        <p>We offer more than 5000 places all around the world</p>


                      </a>
                    </div>
                     </router-link>
                  </div>

                  <div class="col-12 col-sm-3">
                    <router-link  to="/vechiles">
                    <div class="action-box">
                      <a href="#">
                        <div class="icon-holder">
                          <img src="/assets/img/icons/vehicle.png" alt="img" />
                        </div>

                          <strong>Bike or SUV?<br />You find it here </strong>
                          <p>Vehicles for all kind of trip</p>


                      </a>
                    </div>
                    </router-link>
                  </div>

                  <div class="col-12 col-sm-3">
                        <router-link  to="/meals">
                    <div class="action-box">
                      <a href="#">
                        <div class="icon-holder">
                          <img src="/assets/img/icons/pizza.png" alt="img" />
                        </div>

                     <strong>Take a lunch <br />break</strong>
                      <p>Traditional kitchen, in small cafes or big restaurants</p>


                      </a>
                    </div>
                     </router-link>
                  </div>
                  <div class="col-12 col-sm-3">
                     <router-link  to="/experiences">
                    <div class="action-box">
                      <a href="#">
                        <div class="icon-holder">
                          <img src="/assets/img/icons/activity.png" alt="img" />
                        </div>

                        <strong>Excursion, hiking <br />or party time? </strong>
                        <p>Museums, night clubs and other great activities</p>


                      </a>
                    </div>
                      </router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="our-services">
          <div class="container">
            <h1 class="title-section">Explore Our Services</h1>
            <div class="row">

              <div class="col">
                 <router-link  to="/hosts">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/hosts.png" alt="icons" />
                  </span>

                      Hosts

                </div>
                 </router-link>
              </div>


              <div class="col">
                 <router-link  to="/tripmates">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/tripmates.png" alt="icons" />
                  </span>

                     Trip Mates

                </div>
                </router-link>
              </div>


              <div class="col">
                <router-link  to="/visaConsultants">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/visa.png" alt="icons" />
                  </span>

                     Visa Consultants


                </div>
                </router-link>
              </div>


              <div class="col">
                <router-link  to="/guides">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/guides.png" alt="icons" />
                  </span>

                     Guides

                </div>
                   </router-link>
              </div>


              <div class="col">
                <router-link  to="/tripoperators">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/tripoperator.png" alt="icons" />
                  </span>

                     Trip Operators


                </div>
                 </router-link>
              </div>


              <div class="col">
                <router-link  to="/movieMakers">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/moviemakers.png" alt="icons" />
                  </span>

                    Movie Makers

                </div>
                 </router-link>
              </div>


              <div class="col">
                <router-link  to="/movieMakers">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/photo.png" alt="icons" />
                  </span>

                      Photographers

                </div>
                 </router-link>
              </div>

            </div>
            <div class="row">

              <div class="col">
                <router-link  to="/trips">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/trips.png" alt="icons" />
                  </span>

                     Trips

                </div>
                  </router-link>
              </div>


              <div class="col">
                 <router-link  to="/vechiles">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/vehicles.png" alt="icons" />
                  </span>

                      Vechile

                </div>
                 </router-link>
              </div>


              <div class="col">
                 <router-link  to="/accommodations">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/acommodation.png" alt="icons" />
                  </span>

                      Accomodations

                </div>
                </router-link>
              </div>

              <div class="col">
                 <router-link  to="/meals">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/dishes.svg" alt="img" />
                  </span>
                  Meals
                </div>
                 </router-link>
              </div>

              <div class="col">
                  <router-link  to="/experiences">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/activities.png" alt="icons" />
                  </span>

                      Activity

                </div>
                 </router-link>
              </div>


              <div class="col">
                 <router-link  to="/restaurants">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/restaurant.png" alt="icons" />
                  </span>

                  Restaurants


                </div>
                   </router-link>
              </div>

              <div class="col">
              <router-link  to="/cruise">
                <div class="service-icon-item">
                  <span class="service-icon">
                    <img src="/assets/img/icons/cruise.png" alt="icons" />
                  </span>
                  Cruise
                </div>
                </router-link>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <div class="plan-your-trips">
            <div class="row">
              <div class="col-12 col-sm-5">
                <h3>Plan <br />a trip by yourself</h3>
                <a href="#" class="btn btn-see-features ripple">See all features</a>
              </div>
              <div class="col-12 col-sm-1"></div>
              <div class="col-12 col-sm-6">
                <div class="img-holder">
                  <img src="/assets/img/plan-trip.png" alt="img" />
                </div>
              </div>
            </div>
          </div>
          <div class="meet-guide">
            <h2 class="title-section">Meet your guides</h2>

            <!-- <div class="row" v-if="guides_array">
              <div class="col-12 col-sm-3" v-for="(guide,index) in guides_array" :key="index">
                <router-link  :to="{path:'/guides/detail/'+guide.id}">
                <div class="guide-box">
                  <div class="img-holder" v-if="guide.single_image!=null">
                              <img :src="$imagePath+'guides/'+guide.single_image.name" alt="hotel" />
                                </div>
                                <div class="img-holder" v-else>
                                    <img :src="$imagePath+'not-available.png'" alt="hotel" />
                                </div>
                  <div class="cotent-holder">
                    <div class="d-flex justify-content-between align-self-center mb-1">
                      <a href="#">
                        <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                        <span class="rating-title align-self-center">{{guide.rating+'.0'}}</span>
                        <span class="count-rating align-self-center">({{guide.no_of_reviews}})</span>
                      </a>
                      <h3 class="align-self-center"> {{guide.country}}</h3>
                    </div>
                    <p>{{ guide.title}}</p>
                    <strong>From {{ guide.price}}Rs <span>/ person</span></strong>
                  </div>
                </div>
                </router-link>
              </div>
            </div> -->

            <div class="row" v-if="service_providers">
              <div class="col-12 col-sm-3" v-for="(guide,index) in service_providers" :key="index">
                <router-link  :to="{path:'/services/provider/detail/'+guide.id}">
                <div class="guide-box">
                  <div class="img-holder" v-if="guide.image!=null">
                              <img :src="'/assets/uploads/users/'+guide.image" alt="hotel" />
                                </div>
                                <div class="img-holder" v-else>
                                    <img :src="$imagePath+'not-available.png'" alt="hotel" />
                                </div>
                  <div class="cotent-holder">
                    <div class="d-flex justify-content-between align-self-center mb-1">
                      <a href="#">
                        <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                        <span class="rating-title align-self-center">{{guide.rating+'.0'}}</span>
                        <span class="count-rating align-self-center">({{guide.no_of_reviews}})</span>
                      </a>
                      <h3 class="align-self-center"> {{guide.country}}</h3>
                    </div>
                    <p>{{ guide.name}}</p>
                    <strong>From
                        <span v-if="guide.service_provider_rates != null"> {{ guide.service_provider_rates.price_per_day_rate}} </span>
                        <span v-else>0</span>
                        Rs <span>/ day</span></strong>
                  </div>
                </div>
                </router-link>
              </div>
            </div>


            <div class="btn-sec text-center">
              <router-link  to="/guides" class="btn btn-more"> See more </router-link>
              <!-- <a href="#" class="btn btn-more"></a> -->
            </div>
          </div>
          <div class="host-sec">
            <div class="row">
              <div class="col-12 col-sm-5">
                <div class="host-tags-sec">
                  <h3>Local hosts from all over the world</h3>
                  <p>What services host can provide?</p>
                  <ul class="tags-btn">
                    <li><router-link  to="/accommodations" class="btn btn-tags">accomodation</router-link></li>
                    <li><router-link  to="/vechiles" class="btn btn-tags">vehicles</router-link></li>
                    <li><router-link  to="/meals" class="btn btn-tags">meals</router-link></li>
                    <li><router-link  to="/experiences" class="btn btn-tags">activities</router-link></li>

                  </ul>
                  <ul class="action-btn">
                    <li><router-link  to="/hosts" class="btn  btn-hosts">Become a host</router-link></li>
                    <li> <router-link  to="/hosts" class="btn btn-seemore">see more</router-link></li>

                  </ul>
                </div>
              </div>
              <div class="col-12 col-sm-7">
                <div class="row">
                  <div class="col-12 col-sm-4" v-for="(host ,index) in hosts_array" :key="index">
                    <div class="host-profile-thumbnail">

                      <router-link  :to="host.type == 2 ? {path:'/hosts/detail/'+host.id} : (host.type == 1 ? {path:'/services/provider/detail/'+host.id} : '')">
                      <div class="profile-holder" v-if="host.image!=null">
                      <img :src="'/assets/uploads/users/'+host.image" alt="hotel" />
                      </div>
                      <div class="profile-holder" v-else>
                      <img :src="$imagePath+'not-available.png'" alt="hotel" />
                      </div>

                        <div class="rating-rounded"><i class="fa fa-star"></i> {{host.rating+'.0'}}
                        </div>
                      </router-link>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
          <div class="activities-sec">
            <h3 class="title-section">Some of activities</h3>
            <div class="row" v-if="activities_array">


              <div class="col-12 col-sm-3" v-for="(activity ,index) in activities_array" :key="index">
                 <router-link  :to="{path:'/experiences/detail/'+activity.id}">
                <div class="activity-box">

                  <div class="img-holder" v-if="activity.single_image!=null">
                  <img :src="$imagePath+'experiences/'+activity.single_image.name" alt="hotel" />
                  </div>
                  <div class="img-holder" v-else>
                      <img :src="$imagePath+'not-available.png'" alt="hotel" />
                  </div>
                   <a href="#">
                        <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                        <span class="rating-title align-self-center">{{activity.rating}}</span>
                        <span class="count-rating align-self-center">({{activity.no_of_reviews}})</span>
                      </a>
                    <strong>{{ activity.title}}</strong>

                </div>
                </router-link>
              </div>
            </div>

          </div>
          <div class="tripmate-sec">
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="tripmate-cta">
                  <h4>Find your <br />Tripmates</h4>
                  <p>Open TRIPSCON Community <br />and get in touch with like-minded people</p>
                  <a href="http://tripscon-community.wanologicalsolutions.com" target="_blank" class="btn btn-community">Go to community</a>
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <div class="tripmae-image">
                  <img src="assets/img/tripmate.png" alt="img" />
                </div>
              </div>
            </div>
          </div>
          <div class="stay-in-sec">
            <h3 class="title-section">We recommend to stay here!</h3>
            <div class="row" v-if="accomudations_array">
              <div class="col-12 col-sm-3" v-for="(accomudation ,index) in accomudations_array" :key="index">
              <router-link  :to="{path:'/accommodations/detail/'+accomudation.id}" >
                <div class="hotel-box">
                  <div class="img-holder" v-if="accomudation.single_image!=null">
                  <img :src="$imagePath+'accommodations/'+accomudation.single_image.name" alt="hotel" />
                  </div>
                  <div class="img-holder" v-else>
                      <img :src="$imagePath+'not-available.png'" alt="hotel" />
                  </div>
                  <div class="content-holder">
                    <small> <img src="assets/img/map-pin.png" alt="icon" />

                     {{ accomudation.title.substr(0,20)}}

                      <span>1700 miles away</span> </small>
                    <div class="d-flex justify-content-between align-self-center mb-2">
                      <h3 class="align-self-center"> from {{ accomudation.city}}</h3>
                      <a href="#">
                        <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                        <span class="rating-title align-self-center">{{ accomudation.rating}}</span>
                        <span class="count-rating align-self-center">({{ accomudation.no_of_reviews}})</span>
                      </a>
                    </div>
                     {{ accomudation.per_night}}Rs / <span>night</span>
                  </div>
                </div>
                </router-link>
              </div>
            </div>
          </div>
          <div class="featured-trips-sec">
            <h3 class="title-section">Featured trips</h3>
            <div class="row" v-if="trips_array">

              <div class="col-12 col-sm-4" v-for="(trip ,index) in trips_array" :key="index">
                <div class="trip-box">
                <router-link  :to="{path:'/trips/detail/'+trip.id}" >
                 <div class="img-holder" v-if="trip.single_image!=null">
                  <img :src="$imagePath+'trips/'+trip.single_image.name" alt="hotel" />
                  </div>
                  <div class="img-holder" v-else>
                      <img :src="$imagePath+'not-available.png'" alt="hotel" />
                  </div>
                  <div class="content-holder">
                    <small> <img src="/assets/img/map-pin.png" alt="icon" /> {{ trip.location}}</small>
                    <div class="d-flex justify-content-between align-self-center mb-2">
                      <h3 class="align-self-center">{{ trip.title}}</h3>
                      <a href="#">
                        <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                        <span class="rating-title align-self-center">{{ trip.stars+'.0'}}</span>
                        <span class="count-rating align-self-center">({{ trip.no_of_reviews}})</span>
                      </a>
                    </div>
                    <div class="row">
                      <div class="col-6 d-flex align-self-center">
                        <span class="days-ago"><i class="fa fa-clock-o"></i> {{trip.trip_type}} days</span>
                      </div>
                      <div class="col-6">

                        <span class="icon-holder"><img src="/assets/img/deal.png" alt="icon" /></span>
                        <a href="#" class="btn btn-price"> <span>From</span> {{trip.price}}$</a>
                      </div>
                    </div>
                  </div>
                   </router-link>
                </div>
              </div>
            </div>
            <div class="btn-sec text-center">
                <router-link class="btn btn-more" to="/trips">
                See more
                </router-link>

            </div>
          </div>
          <div class="vehicles-sec">
            <h3 class="title-section">Vehicles</h3>
            <div class="row"  v-if="transposrts_array">

              <div class="col-12 col-sm-3" v-for="(transport,index) in transposrts_array" :key="index">
                 <router-link  :to="{path:'/vechiles/detail/'+transport.id}" >
                <div class="vehicles-box">
                  <a href="#">
                  <div class="img-holder" v-if="transport.single_image!=null">
                  <img :src="$imagePath+'transports/'+transport.single_image.name" alt="hotel" />
                  </div>
                  <div class="img-holder" v-else>
                      <img :src="$imagePath+'not-available.png'" alt="hotel" />
                  </div>
                   <a href="#">
                        <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                        <span class="rating-title align-self-center">{{transport.rating}}</span>
                        <span class="count-rating align-self-center">({{transport.no_of_reviews}})</span>
                   </a>
                    <div class="d-flex justify-content-between align-self-center ">
                      <strong> {{ transport.title }}</strong>
                      <a href="#" class="btn btn-price"> <span>From</span> {{ transport.per_day_price}}    Rs</a>
                    </div>
                  </a>
                </div>
                 </router-link>
              </div>
            </div>
            <div class="btn-sec text-center">
               <router-link  to="/vechiles" class="btn btn-more">
               See more
               </router-link>

            </div>
          </div>
          <div class="community-sec">
            <h3 class="title-section">Explore Community</h3>
            <div class="banner_holder">
              <img src="assets/img/community.png" alt="icon" />
            </div>
            <div class="row">
              <div class="col">
                <div class="count-box">
                  <div class="icon-holder">
                    <img src="assets/img/smile.svg" alt="icon" />
                  </div>
                  <strong>1000+ <br />members</strong>
                </div>
              </div>
              <div class="col">
                <div class="count-box">
                  <div class="icon-holder">
                    <img src="assets/img/thumbs-up.svg" alt="icon" />
                  </div>
                  <strong>1000+ <br /> Likes</strong>
                </div>
              </div>
              <div class="col">
                <div class="count-box">
                  <div class="icon-holder">
                    <img src="assets/img/message-square.svg" alt="icon" />
                  </div>
                  <strong>300+ <br /> Comments</strong>
                </div>
              </div>
              <div class="col">
                <div class="count-box">
                  <div class="icon-holder">
                    <img src="assets/img/share-android.svg" alt="icon" />
                  </div>
                  <strong>300+ <br /> Shares</strong>
                </div>
              </div>
              <div class="col">
                <div class="count-box">
                  <div class="icon-holder">
                    <img src="assets/img/Vector.svg" alt="icon" />
                  </div>
                  <strong>300+ <br /> Favourites</strong>
                </div>
              </div>
            </div>
            <div class="btn-sec text-center">
              <a href="#" class="btn btn-more">Join Community</a>
            </div>
          </div>
          <div class="mobile-sec">
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="ar-mobile-centent">
                  <strong class="title-section p-0 mt-70">AR Maps</strong>
                  <p>Lorem ipsum dolor sit amet, consec tetur adipiscing elit. Nam condimentum tempus diam, ultricies sollicitudin erat facilisis eget. Vestibulum rhoncus dui vel eros laoreet consectetur. Vivamus eget elementum ligula, vitae pharetra quam. </p>
                  <ul class="action-btn">
                    <li><a href="#" class="btn btn-seemore">Available on App Store</a></li>
                    <li><a href="#" class="btn btn-host">Available on Google Play</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <div class="img-holder">
                  <img src="assets/img/ar-img.png" alt="img" />
                </div>
              </div>

            </div>
          </div>
        </div>

        <where-to-go-modal></where-to-go-modal>
        <custom-trip
            :user="'0'"
            :is_index="true"
        ></custom-trip>

    </main>
</template>
<script>

    export default {
        name: "indexComponent",
        data() {
            return {
              guides_array : [],
              activities_array:[],
              accomudations_array:[],
              trips_array:[],
              transposrts_array:[],
              hosts_array:[],
              service_providers: [],
              loader:true

            }
        },
        created() {
            axios.post("/api/getDashboard").then((response) => {
              this.guides_array = response.data.guides;
              this.activities_array = response.data.activities;
              this.accomudations_array = response.data.accomudations;
              this.trips_array = response.data.trips;
              this.transposrts_array = response.data.transposrts;
              this.hosts_array = response.data.host;
              this.service_providers = response.data.service_providers;
               this.loader = false;
            });

        },
 }

</script>

<style scoped>
  .col-xs-12.col {
        cursor: pointer;
    }

</style>

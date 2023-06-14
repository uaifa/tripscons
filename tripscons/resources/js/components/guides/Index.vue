<template>
  <main>
    <div class="container">
      <div class="host-listing">
          <h2 class="title-section"> {{ page_type || 'Guides' }} </h2>
          <div class="row ">
            
            <div class="col-12 col-sm-3 " v-if="(serviceProviders.data).length > 0" v-for="(genData, index) in serviceProviders.data" :key="'service_providers_div_'+index">
              
              <div class="host-listing-box">
                <div class="img-holder c-img-holder">
                  <router-link style="width: 100%; height: 250px; border-radius: 10px;"  :to="{path:'/guides/'+genData.id}"  tag="img" :src="$imagePath+'users/'+genData.image"></router-link>

                  <!-- <img src="/assets/img/guide-1.jpg" class="pro-img" alt="img" /> -->
                </div>
                <div class="cotent-holder">
                  <div class="d-flex justify-content-between align-self-center mb-1">
                    <router-link :to="{path:'/guides/'+genData.id}">
                      <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                      <span class="rating-title align-self-center">{{ genData.rating+'.0'}}</span>
                      <span class="count-rating align-self-center">(14)</span>
                    </router-link>
                    <h3 class="align-self-center"><img class="mr-1" src="/assets/img/map-pin.png" alt="" srcset=""> {{ genData.city +', '+genData.country }}
                    </h3>
                  </div>
                 <div class="d-flex">

                 <h3 class="mb-1"> <router-link :to="{path:'/guides/'+genData.id}"> {{ genData.name}} </router-link> </h3>
                 </div>
                 <div class="specialities">
                  <ul>
                      <li>
                        Rs.<span v-if="genData.service_provider_rates != null">
                          {{ genData.service_provider_rates.price_per_day_rate }}/day
                        </span>
                        <span v-else>
                          0/day
                        </span>
                      </li>
                      <li>
                        Rs.<span v-if="genData.service_provider_rates != null">
                          {{ genData.service_provider_rates.price_per_hour_rate }}/hour
                        </span>
                        <span v-else>
                          0/hour
                        </span>
                        </li>
                      
                  </ul>
              </div>
                <div class="d-flex justify-content-start mb-4"> <router-link :to="{path:'/guides/'+genData.id}">See more</router-link> </div>
                </div>
              </div>
            </div>
            <div v-if="(serviceProviders.data).length < 1" class="">
              <h4>
                Record Not Found!
              </h4>
            </div>
            
          </div>
        </div>

    </div>
  </main>
</template>

<script>

import VueGoogleAutocomplete from "vue-google-autocomplete";
import { Slider, SliderItem } from "vue-easy-slider";
 export default {
  mode: 'history',
  name: "guides",
  components: {
    Slider,
    SliderItem,
    VueGoogleAutocomplete,
  },
  data() {
    return {
      generalobjects: {},
      rating: "",
      ratingCustom:"",
      priceToggle: false,
      ratingToggle: false,
      isActiveprice: false,
      isActiverating: false,
      addressCountry:'',
      addressCity:'',
      //price gab code start here ....
      priceGap: "",
      min: 0,
      max: 2000,
      minValue: 0,
      maxValue: 2000,
      step: 5,
      totalSteps: 0,
      percentPerStep: 1,
      trackWidth: null,
      isDragging: false,
      pos: {
        curTrack: null,
      },
      list: [],
      sliderValue: 2,
      serviceProviders: [],
      page_type: '',
      user_module_type: '',
    };
  },
  created() {
      if(this.$route.query.country || this.$route.query.city) {
          this.addressCountry = this.$route.query.country;
          this.addressCity = this.$route.query.city;
      }
      // console.log(window.location.pathname, this.$route.path);
      // 'accommodations','experiences','guides','meals','movie_makers','transports','trips','visa_consultants','events','photographers','restaurants','trip_mates','trip_operators','hosts','vehicles'

      let path_name = window.location.pathname;
      if(path_name == '/guides'){
        this.user_module_type = 'guides';
        this.page_type = 'Guides';
      }else if(path_name == '/tripmates'){
        this.user_module_type = 'trip_mates';
        this.page_type = 'Trip Mates';
      }else if(path_name == '/tripoperators'){
        this.user_module_type = 'trip_operators';
        this.page_type = 'Trip Operators';
      }else if(path_name == '/visaconsultants'){
        this.user_module_type = 'visa_consultants';
        this.page_type = 'Visa Consultants';
      }else if(path_name == '/moviemakers'){
        this.user_module_type = 'movie_makers';
        this.page_type = 'Movie Makers';
      }else if(path_name == '/photographers'){
        this.user_module_type = 'photographers';
        this.page_type = 'Photo Graphers';
      }else if(path_name == '/trips'){
        this.user_module_type = 'trips';
        this.page_type = 'Trips';
      }else if(path_name == '/restaurants'){
        this.user_module_type = 'restaurants';
        this.page_type = 'Restaurants';
      }

      this.getResults();

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
      bodyFormData.append("minValue", this.minValue);
      bodyFormData.append("maxValue", this.maxValue);
      bodyFormData.append("user_module_type", this.user_module_type);
      axios.post("/api/getAllServiceProviderForGuide", bodyFormData).then((response) => {
      // this.generalobjects = response.data.guides;
      this.serviceProviders = response.data.data;

       });
    },

    proPriceToggle: function () {
      this.priceToggle = !this.priceToggle;
    },
    priceTrue() {
      this.priceToggle = true;
    },
    priceFalse() {
      this.priceToggle = false;
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

    pricefilter() {

      this.isActiveprice = true;
    },
    ratingfilter() {
      if(this.rating !=''){
      this.isActiverating = true;
      }

    },

    //reset data ....
    proPriceClear(){
      this.min =  0;
      this.max = 2000;
      this.minValue = 0;
      this.maxValue= 2000;
      this.isActiveprice = false;
      this.getResults();
      this.priceslider();
    },
    proRatingClear(){
      this.rating='';
      this.ratingCustom='';
      this.isActiverating = false;
      this.getResults();
    },

    //reset data ended here
    //price gab methodes are here started ....
    moveTrack(track, ev) {
      let percentInPx = this.getPercentInPx();

      let trackX = Math.round(
        this.$refs._vpcTrack.getBoundingClientRect().left
      );
      let clientX = ev.clientX;
      let moveDiff = clientX - trackX;

      let moveInPct = moveDiff / percentInPx;
      // console.log(moveInPct)

      if (moveInPct < 1 || moveInPct > 100) return;
      let value =
        Math.round(moveInPct / this.percentPerStep) * this.step + this.min;
      if (track === "track1") {
        if (value >= this.maxValue - this.step) return;
        this.minValue = value;
      }

      if (track === "track2") {
        if (value <= this.minValue + this.step) return;
        this.maxValue = value;
      }

      this.$refs[track].style.left = moveInPct + "%";
      this.setTrackHightlight();
    },
    mousedown(ev, track) {
      if (this.isDragging) return;
      this.isDragging = true;
      this.pos.curTrack = track;
    },

    touchstart(ev, track) {
      this.mousedown(ev, track);
    },

    mouseup(ev, track) {
      if (!this.isDragging) return;
      this.isDragging = false;
    },

    touchend(ev, track) {
      this.mouseup(ev, track);
    },

    mousemove(ev, track) {
      if (!this.isDragging) return;
      this.moveTrack(track, ev);
    },

    touchmove(ev, track) {
      this.mousemove(ev.changedTouches[0], track);
    },

    valueToPercent(value) {
      return ((value - this.min) / this.step) * this.percentPerStep;
    },

    setTrackHightlight() {
      this.$refs.trackHighlight.style.left =
        this.valueToPercent(this.minValue) + "%";
      this.$refs.trackHighlight.style.width =
        this.valueToPercent(this.maxValue) -
        this.valueToPercent(this.minValue) +
        "%";
    },

    getPercentInPx() {
      let trackWidth = this.$refs._vpcTrack.offsetWidth;
      let oneStepInPx = trackWidth / this.totalSteps;
      // 1 percent in px
      let percentInPx = oneStepInPx / this.percentPerStep;

      return percentInPx;
    },

    setClickMove(ev) {
      let track1Left = this.$refs.track1.getBoundingClientRect().left;
      let track2Left = this.$refs.track2.getBoundingClientRect().left;
      // console.log('track1Left', track1Left)
      if (ev.clientX < track1Left) {
        this.moveTrack("track1", ev);
      } else if (ev.clientX - track1Left < track2Left - ev.clientX) {
        this.moveTrack("track1", ev);
      } else {
        this.moveTrack("track2", ev);
      }
    },
   priceslider(){
      // calc per step value
    this.totalSteps = (this.max - this.min) / this.step;

    // percent the track button to be moved on each step
    this.percentPerStep = 100 / this.totalSteps;
    // console.log('percentPerStep', this.percentPerStep)

    // set track1 initilal
    document.querySelector(".track1").style.left =
      this.valueToPercent(this.minValue) + "%";
    // track2 initial position
    document.querySelector(".track2").style.left =
      this.valueToPercent(this.maxValue) + "%";
    // set initila track highlight
    this.setTrackHightlight();

    var self = this;

    ["mouseup", "mousemove"].forEach((type) => {
      document.body.addEventListener(type, (ev) => {
        // ev.preventDefault();
        if (self.isDragging && self.pos.curTrack) {
          self[type](ev, self.pos.curTrack);
        }
      });
    });

    [
      "mousedown",
      "mouseup",
      "mousemove",
      "touchstart",
      "touchmove",
      "touchend",
    ].forEach((type) => {
      document.querySelector(".track1").addEventListener(type, (ev) => {
        ev.stopPropagation();
        self[type](ev, "track1");
      });

      document.querySelector(".track2").addEventListener(type, (ev) => {
        ev.stopPropagation();
        self[type](ev, "track2");
      });
    });

    // on track clik
    // determine direction based on click proximity
    // determine percent to move based on track.clientX - click.clientX
    document.querySelector(".track").addEventListener("click", function (ev) {
      ev.stopPropagation();
      self.setClickMove(ev);
    });

    document
      .querySelector(".track-highlight")
      .addEventListener("click", function (ev) {
        ev.stopPropagation();
        self.setClickMove(ev);
      });
   }

  },
  mounted() {

    // calc per step value
    this.totalSteps = (this.max - this.min) / this.step;

    // percent the track button to be moved on each step
    this.percentPerStep = 100 / this.totalSteps;
    // console.log('percentPerStep', this.percentPerStep)

    // set track1 initilal
    document.querySelector(".track1").style.left =
      this.valueToPercent(this.minValue) + "%";
    // track2 initial position
    document.querySelector(".track2").style.left =
      this.valueToPercent(this.maxValue) + "%";
    // set initila track highlight
    this.setTrackHightlight();

    var self = this;

    ["mouseup", "mousemove"].forEach((type) => {
      document.body.addEventListener(type, (ev) => {
        // ev.preventDefault();
        if (self.isDragging && self.pos.curTrack) {
          self[type](ev, self.pos.curTrack);
        }
      });
    });

    [
      "mousedown",
      "mouseup",
      "mousemove",
      "touchstart",
      "touchmove",
      "touchend",
    ].forEach((type) => {
      document.querySelector(".track1").addEventListener(type, (ev) => {
        ev.stopPropagation();
        self[type](ev, "track1");
      });

      document.querySelector(".track2").addEventListener(type, (ev) => {
        ev.stopPropagation();
        self[type](ev, "track2");
      });
    });

    // on track clik
    // determine direction based on click proximity
    // determine percent to move based on track.clientX - click.clientX
    document.querySelector(".track").addEventListener("click", function (ev) {
      ev.stopPropagation();
      self.setClickMove(ev);
    });

    document
      .querySelector(".track-highlight")
      .addEventListener("click", function (ev) {
        ev.stopPropagation();
        self.setClickMove(ev);
      });
  },

  //price gap methods are ended here ...
};

function wcqib_refresh_quantity_increments() {
  jQuery(
    "div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)"
  ).each(function (a, b) {
    var c = jQuery(b);
    c.addClass("buttons_added"),
      c
        .children()
        .first()
        .before('<input type="button" value="-" class="minus" />'),
      c
        .children()
        .last()
        .after('<input type="button" value="+" class="plus" />');
  });
}
String.prototype.getDecimals ||
  (String.prototype.getDecimals = function () {
    var a = this,
      b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
    return b ? Math.max(0, (b[1] ? b[1].length : 0) - (b[2] ? +b[2] : 0)) : 0;
  }),
  jQuery(document).ready(function () {
    wcqib_refresh_quantity_increments();
  }),
  jQuery(document).on("updated_wc_div", function () {
    wcqib_refresh_quantity_increments();
  });
</script>

<style scoped>
.range-value {
  position: absolute;
  top: -2rem;
}
.range-value.min {
  left: 0;
}

.range-value.max {
  right: 0;
}
.track-container {
  width: 100%;
  position: relative;
  cursor: pointer;
  height: 0.5rem;
}

.track,
.track-highlight {
  display: block;
  position: absolute;
  width: 100%;
  height: 0.5rem;
}

.track {
  background-color: #ddd;
}

.track-highlight {
  background-color: black;
  z-index: 2;
}

.track-btn {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  outline: none;
  cursor: pointer;
  display: block;
  position: absolute;
  z-index: 2;
  border-radius: 50%;
  width: 1.5rem;
  height: 1.5rem;
  top: calc(-50% - 0.25rem);
  margin-left: -1rem;
  border: none;
  background-color: black;
  -ms-touch-action: pan-x;
  touch-action: pan-x;
  transition: box-shadow 0.3s ease-out, background-color 0.3s ease,
    -webkit-transform 0.3s ease-out;
  transition: transform 0.3s ease-out, box-shadow 0.3s ease-out,
    background-color 0.3s ease;
  transition: transform 0.3s ease-out, box-shadow 0.3s ease-out,
    background-color 0.3s ease, -webkit-transform 0.3s ease-out;
}

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

<template>
  <main>
    <div class="container">
      <div class="d-flex select-country-sec">
        <h1 class="title-section p-0">
          Find your Destination vehicle's
          <div class="input-field">
            <vue-google-autocomplete
              style="z-index: 99999999 !important; padding-left: 35px"
              ref="address"
              id="map"
              classname="form-control"
              placeholder="Please type your address"
              types="(regions)"
              v-on:placechanged="getAddressData"
            >
            </vue-google-autocomplete>
          </div>
        </h1>
      </div>
      <div class="search-filter-sec">
        <strong>Search by {{ modeldasd }}</strong>
        <ul>
          <li class="dropdown">
            <a
              href="#"
              class="btn btn-filter"
              @click="
                proPriceToggle();
                propertyFacilityFalse();
                vechileBrandFalse();
                ratingFalse();
                vechileModelFalse();
              "
              :class="{ pricefiltered: isActiveprice }"
              >Price</a
            >
            <div v-show="priceToggle" class="property-parent-div price">
              <strong>Choose price gap</strong>
              <!-- <div class="range-class w-100">
                    <input type="range" class="form-range" id="customRange1" v-model="priceGap">
                  </div> -->
              <div class="track-container">
                <!-- <span class="range-value min">{{ minValue}} </span> <span class="range-value max">{{ maxValue }}</span> -->
                <div class="track" ref="_vpcTrack"></div>
                <div class="track-highlight" ref="trackHighlight"></div>
                <button class="track-btn track1" ref="track1"></button>
                <button class="track-btn track2" ref="track2"></button>
              </div>

              <div class="row">
                <div class="col">
                  <div class="input-field">
                    <label>Min price</label>
                    <input
                      type="number"
                      placeholder="$1000"
                      class="form-control"
                      v-model="minValue"
                    />
                  </div>
                </div>
                <div class="col">
                  <div class="input-field">
                    <label>Max price</label>
                    <input
                      type="number"
                      placeholder="$1000"
                      class="form-control"
                      v-model="maxValue"
                    />
                  </div>
                </div>
              </div>
              <div class="btn-sec text-center d-flex">
                <a href="#" class="btn btn-apply mr-1" @click="proPriceClear()"
                  >Clear</a
                >
                <a
                  href="#"
                  class="btn btn-apply"
                  @click="
                    getResults();
                    proPriceToggle();
                    pricefilter();
                  "
                  >Apply</a
                >

              </div>
            </div>
          </li>
          <li>
            <a

              class="btn btn-filter"
              @click="
                propertyFacilityFalse();
                vechileBrandFalse();
                priceFalse();
                proRatingToggle();
                vechileModelFalse();
              "
              :class="{ ratingfiltered: isActiverating }"
              >Rating</a
            >
            <div v-show="ratingToggle" class="property-parent-div pro-rating">
              <strong>Rating</strong>
              <div class="custom-control custom-radio">
                <input
                  type="radio"
                  class="custom-control-input"
                  id="customRadio"
                  name="rating"
                  value="5"
                  @change="accRating($event)" v-model="ratingCustom"
                />
                <label class="custom-control-label" for="customRadio"
                  >5 star</label
                >
              </div>
              <div class="custom-control custom-radio">
                <input
                  type="radio"
                  class="custom-control-input"
                  id="customRadio2"
                  name="rating"
                  value="3"
                  @change="accRating($event)" v-model="ratingCustom"
                />
                <label class="custom-control-label" for="customRadio2"
                  >3 star
                </label>
              </div>
              <div class="custom-control custom-radio">
                <input
                  type="radio"
                  class="custom-control-input"
                  id="customRadio3"
                  name="rating"
                  value="2"
                  @change="accRating($event)" v-model="ratingCustom"
                />
                <label class="custom-control-label" for="customRadio3"
                  >2 star</label
                >
              </div>
              <div class="btn-sec text-center d-flex">
                <a
                  href="#"
                  class="btn btn-apply mr-1"
                  @click="proRatingClear();"
                  >Clear</a
                >
                <a
                  href="#"
                  @click="
                    getResults();
                    proRatingToggle(); ratingfilter();
                  "
                  class="btn btn-apply"
                  >Apply</a
                >

              </div>
            </div>
          </li>


          <li>
            <a
              class="btn btn-filter"
              @click="
                proTypeToggle();
                propertyFacilityFalse();
                priceFalse();
                ratingFalse();
                vechileModelFalse();
              "
              :class="{ protypefiltered: isActiveprotype }"
              >Brands</a
            >
            <div
              v-show="vechileBrandToggle"
              class="property-parent-div pro-type"
            >
              <strong>Brands</strong>
              <div class="row">
                <div class="col-12">
                  <div class="input-field">
                    <select
                      name="cars"
                      class="custom-select form-control"
                      v-model="vechileBrand"
                    >
                      <option value="">Choose Brands</option>
                      <option value="Tesla">Tesla</option>
                      <option value="BMW">BMW</option>
                      <option value="Honda">Honda</option>

                    </select>
                  </div>
                </div>

              </div>
              <div class="btn-sec text-center d-flex">
                <a href="#" class="btn btn-apply mr-1" @click="proTypeClear()"
                  >Clear</a
                >
                <a
                  href="#"
                  class="btn btn-apply"
                  @click="
                    getResults();
                    proTypeToggle();
                    protypefilter();
                  "
                  >Apply</a
                >

              </div>
            </div>
          </li>
           <li>
            <a
              class="btn btn-filter"
              @click="

                proModelToggle();
                propertyFacilityFalse();
                priceFalse();
                ratingFalse();
                proTypeFalse();



              "
              :class="{ modelfiltered: isActiveModel }"
              >Models</a>
            <div
              v-show="vechileModelToggle"
              class="property-parent-div pro-type"
            >
              <strong>Models</strong>
              <div class="row">
                <div class="col-12">
                  <div class="input-field">
                    <select
                      name="cars"
                      class="custom-select form-control"
                      v-model="vechileModel"
                    >
                      <option value="">Choose Models</option>
                    <option v-for="(i,index) in years" :key="index">{{ i }}</option>

                    </select>
                  </div>
                </div>

              </div>
              <div class="btn-sec text-center d-flex">
                <a href="#" class="btn btn-apply mr-1" @click="proBrandClear()"
                  >Clear</a
                >
                <a
                  href="#"
                  class="btn btn-apply"
                  @click="
                    getResults();
                    proModelToggle();

                    TransmodelFilter();
                  "
                  >Apply</a
                >

              </div>
            </div>
          </li>
          <li>
            <a
              class="btn btn-filter"
              @click="
                proFacilityToggle();

                priceFalse();
                ratingFalse();
                vechileModelFalse();

              "
              :class="{ facilityfiltered: isActivefacility }"
            >
              TransPort Facilities</a
            >
            <div
              v-show="propertFacilityToggle"
              class="property-parent-div pro-facility"
            >
              <strong> Property Facilities</strong>
              <div class="row">
                <div class="col-12">
                  <div class="input-field">
                    <select
                      class="custom-select form-control"
                      v-model="propertyFacility"
                    >
                      <option value="">Choose Facility</option>
                      <option v-for="(fac, index) in facility" :key="index" :value="fac.name">
                        {{ fac.name }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="btn-sec text-center d-flex">
                 <a
                  href="#"
                  class="btn btn-apply mr-1"
                  @click="proFacilityClear()"
                  >Clear</a
                >
                <a
                  href="#"
                  class="btn btn-apply"
                  @click="
                    getResults();
                    proFacilityToggle();
                    faciltyfilter();
                  "
                  >Apply</a
                >

              </div>
            </div>
          </li>
        </ul>
      </div>
      <div v-if="generalobjects.data != ''">
      <div
        class="hotel-list-box"
        v-for="(genData, index) in generalobjects.data"
        :key="index"
      >
        <div class="row">
          <div class="col-12 col-sm-3">

            <div class="hotel-images">
                <div id="custom-slider">
                  <Slider
                    animation="slide"
                    v-model="sliderValue"
                    :duration="5000"
                    :speed="1000"
                  >
                  <SliderItem
                     v-for="(i, index) in genData.images"
                    :key="index"
                    @click="changeIndex(1);"

                  >
                  <router-link  :to="{path:'/vechiles/detail/'+genData.id}" class="slider-itemsssss" tag="img" :src="$imagePath+'transports/'+i.name"></router-link>

                  </SliderItem>
                  </Slider>

                  </div>
            </div>

          </div>
          <div class="col-12 col-sm-5">
            <div class="hotel-contentholder">
              <div class="d-flex justify-content-between align-self-center">
                <div class="top-rated">
                  <a href="#" class="btn btn-ribbon">
                    <span class="icon-holder"
                      ><img src="/assets/img/icons/ribbon.png" alt="img"
                    /></span>
                    Top rated host</a
                  >
                  <small>{{ genData.title }}</small>
                </div>
                <strong>{{ genData.city +', '+genData.country }}</strong>
              </div>
              <div
                class="d-flex align-items-center justify-content-between mb-3"
              >
                <router-link  :to="{path:'/vechiles/detail/'+genData.id}">
                <h3>{{ genData.vechile_type.substr(0, 20) }}</h3>
                </router-link>
                <a href="#" class="rating-button">
                  <span class="rating align-self-center"
                    ><i class="fa fa-star"></i
                  ></span>
                  <span class="rating-title align-self-center">{{ genData.rating}}</span>
                  <span class="count-rating align-self-center">({{ genData.no_of_reviews}})</span>
                </a>
              </div>
              <div class="room-capi">
               {{ genData.cc }}<span aria-hidden="true"> - </span> {{ genData.model }}<span
                  aria-hidden="true"
                >
                  -
                </span>
                {{ genData.transmission }}<span aria-hidden="true"> - </span>
                {{ genData.engine }}
              </div>
              <ul class="hotel_icon">
                <li v-for="(f,index) in genData.transport_facility" :key="index">
                  <span class="icon"
                    ><img :src="'/assets/icons/'+f.image" alt="wifi"
                  /></span>
                  <span class="text">{{f.title}}</span>
                </li>

              </ul>
              <div class="price-div d-flex align-self-center">
                <!-- <del class="align-self-center"
                  >From US {{ genData.per_day_price }}$
                </del> -->
                <a href="#" class="btn btn-price">
                 Rs.{{ genData.per_day_price }}/day</a
                >
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="hotel-images">
              <div
                class="map-view-thumb"
                style="background-image: url(/assets/img/map-thumb.png)"
              >

                <a :href="'/vechiles/detail/'+genData.id" class="btn btn-viewmap">View on map!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      <div class="row" v-else>
          <span>Record Not Found</span>
      </div>
      <pagination
        :data="generalobjects"
        @pagination-change-page="getResults"
      ></pagination>

    </div>
  </main>
</template>

<script>
import { Slider, SliderItem } from "vue-easy-slider";
import VueGoogleAutocomplete from "vue-google-autocomplete";
 export default {
  mode: 'history',
  name: "Accommodation",
  props: ['modeldasd'],
  components: {
    Slider,
    SliderItem,
    VueGoogleAutocomplete,
  },
  data() {
    return {
      generalobjects: {},
      facility: [],

      accProType:[],
      rating: "",
      ratingCustom:"",

      vechileBrandToggle: false,
      vechileModelToggle:false,
      propertFacilityToggle: false,
      priceToggle: false,
      ratingToggle: false,
      vechileBrand: "",
      vechileModel:"",
      propertySubType: 0,
      propertySubTypeShow:false,
      propertyThirdTypeShow:false,
      propertyThirdType:"0",
      propertyFacility: "",
      isActiveprice: false,
      isActivedate: false,
      isActiverating: false,
      isActiveguests: false,
      isActiveprotype: false,
      isActiveModel:false,
      isActivefacility:false,
      addressCountry:'',
      addressCity:'',
      userId:'',

      //price gab code start here ....
      priceGap: "",
      min: 0,
      max: 50000,
      minValue: 0,
      maxValue: 50000,
      step: 5,
      totalSteps: 0,
      percentPerStep: 1,
      trackWidth: null,
      isDragging: false,
      pos: {
        curTrack: null,
      },
      list: [],
      sliderValue: 2
    };
  },
  created() {
    this.userId = this.$route.params.data;
    if(this.userId ==undefined){
      this.userId ='';
    }
      if(this.$route.query.country || this.$route.query.city) {
          this.addressCountry = this.$route.query.country;
          this.addressCity = this.$route.query.city;
      }
    this.getResults();
    this.facilities();

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
      bodyFormData.append("vechileBrand", this.vechileBrand);
      bodyFormData.append("vechileModel", this.vechileModel);

      bodyFormData.append("propertySubType", this.propertySubType);

      bodyFormData.append("country", this.addressCountry);
      bodyFormData.append("city", this.addressCity);
      bodyFormData.append("userId", this.userId);

      bodyFormData.append("propertyFacility", this.propertyFacility);
      bodyFormData.append("minValue", this.minValue);
      bodyFormData.append("maxValue", this.maxValue);
      axios.post("/api/vechile", bodyFormData).then((response) => {
      this.generalobjects = response.data.data;


       });
    },

    vechileBrandTrue() {
      this.vechileBrandToggle = true;
    },

    vechileBrandFalse() {
      this.vechileBrandToggle = false;
    },

    vechileModelTrue() {
      this.vechileModelToggle = true;
    },
    vechileModelFalse() {
      this.vechileModelToggle = false;
    },
    propertyFacilityTrue() {
      this.propertFacilityToggle = true;
    },
    propertyFacilityFalse() {
      this.propertFacilityToggle = false;
    },
    proTypeToggle: function () {
      this.vechileBrandToggle = !this.vechileBrandToggle;
    },
    proModelToggle: function () {
      this.vechileModelToggle = !this.vechileModelToggle;
    },
    proFacilityToggle: function () {
      this.propertFacilityToggle = !this.propertFacilityToggle;
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
    proTypeTrue() {
      this.vechileBrandToggle = true;
    },
    proTypeFalse(){
      this.vechileBrandToggle = false;
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
    facilities() {
      axios.get("/api/transportFacilities").then((response) => {
      this.facility = response.data.facilities;
      });
    },
    pricefilter() {

      this.isActiveprice = true;
    },
    datefilter() {
      if(!empty(this.checkInDate)){
      this.isActivedate = true;
      }

    },
    ratingfilter() {
      if(this.rating !=''){
      this.isActiverating = true;
      }


    },
    TransmodelFilter() {

      if(this.vechileModel !=''){
      this.isActiveModel = true;
      }
     },
    guestsfilter() {
       if(this.adultGuest > 0 || this.childGuest > 0){
       this.isActiveguests = true;
      }
    },
    protypefilter() {
    if(this.vechileBrand!=''){
      this.isActiveprotype = true;
      }
    },


    faciltyfilter() {

      if(this.propertyFacility !=''){
      this.isActivefacility = true;
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
    guestClear(){
      this.adultGuest =  0;
      this.childGuest =  0;
      this.isActiveguests = false;
      this.getResults();
    },
    proTypeClear(){
      this.vechileBrand='';
      this.propertySubType=0;
      this.accProType='';
      this.isActiveprotype = false;
      this.propertySubTypeShow=false;
      this.propertyThirdTypeShow=false;
      this.getResults();
    },
    proFacilityClear(){
    this.propertyFacility='';
    this.isActivefacility = false;
    this.getResults();

    },
   proBrandClear(){

    this.isActiveModel = false;
    this.vechileModel='';
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
  computed : {
    years () {
      const year = new Date().getFullYear()
      return Array.from({length: year - 1900}, (value, index) => 1901 + index)
    }
  }
  ,
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
  .slider-itemsssss{
 width: 100% !important;
 height: 100% !important;
  }
</style>

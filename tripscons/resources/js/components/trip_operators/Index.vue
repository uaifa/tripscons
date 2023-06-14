<template>
  <main>
    <div class="container">
      <div class="d-flex select-country-sec">
        <h1 class="title-section p-0">
          Find your accomodation in
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
                propertyTypeFalse();
                ratingFalse();
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
                propertyTypeFalse();
                priceFalse();
                proRatingToggle();
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
              id="dropdownMenuLink"
              data-toggle="dropdown"
              @click="
                propertyFacilityFalse();
                propertyTypeFalse();
                priceFalse();
                ratingFalse();
              "
              :class="{ guestsfiltered: isActiveguests }"
              >Guests</a
            >
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <strong>Guests</strong>
              <div class="row mb-4">
                <div class="col">
                  <div class="input-field">
                    <label class="guest-lable">Adults</label>
                    <small>Ages 13 or above</small>
                  </div>
                </div>
                <div class="col">
                  <div class="quantity buttons_added">
                    <input
                      type="button"
                      value="-"
                      class="minus"
                      @click="adultDecrement"
                    />
                    <input
                      type="number"
                      v-model="adultGuest"
                      step="1"
                      min="1"
                      title="Qty"
                      size="4"
                      pattern=""
                      inputmode=""
                      class="input-text qty text"
                    />
                    <input
                      type="button"
                      value="+"
                      class="plus"
                      @click="adultIncrement"
                    />
                  </div>
                </div>
              </div>
              <div class="row mb-4">
                <div class="col">
                  <div class="input-field">
                    <label class="guest-lable">Childs</label>
                    <small>Ages Below 13</small>
                  </div>
                </div>
                <div class="col">
                  <div class="quantity buttons_added">
                    <input
                      type="button"
                      value="-"
                      class="minus"
                      @click="childDecrement"
                    />
                    <input
                      type="number"
                      step="1"
                      min="1"
                      max=""
                      name="quantity"
                      title="Qty"
                      class="input-text qty text"
                      size="4"
                      pattern=""
                      inputmode=""
                      v-model="childGuest"
                    />
                    <input
                      type="button"
                      value="+"
                      class="plus"
                      @click="childIncrement"
                    />
                  </div>
                </div>
              </div>
              <div class="btn-sec text-center d-flex">
                <a
                  href="#"
                  class="btn btn-apply mr-1"
                  @click="guestClear();"
                  >Clear</a
                >
                <a
                  href="#"
                  @click="
                    getResults();
                    guestsfilter();
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
              id="dropdownMenuLink"
              data-toggle="dropdown"
              @click="
                propertyFacilityFalse();
                propertyTypeFalse();
                priceFalse();
                ratingFalse();
              "
              :class="{ datefiltered: isActivedate }"
              >Dates</a
            >
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <strong>Dates</strong>
              <div class="row">
                <div class="col-12">
                  <div class="input-field">
                    <label>Check In</label>
                    <input
                      type="date"
                      placeholder="Select Date"
                      class="form-control"
                      v-model="checkInDate"
                    />
                  </div>
                </div>
                <div class="col-12">
                  <div class="input-field">
                    <label>Check Out</label>
                    <input
                      type="date"
                      placeholder="Select Date"
                      class="form-control"
                      v-model="checkOutDate"
                    />
                  </div>
                </div>
              </div>
              <div class="btn-sec text-center">
                <a
                  href="#"
                  class="btn btn-apply"
                  @click="
                    getResults();
                    datefilter();
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
                proTypeToggle();
                propertyFacilityFalse();
                priceFalse();
                ratingFalse();
              "
              :class="{ protypefiltered: isActiveprotype }"
              >Property type</a
            >
            <div
              v-show="propertyTypeToggle"
              class="property-parent-div pro-type"
            >
              <strong>Property type</strong>
              <div class="row">
                <div class="col-12">
                  <div class="input-field">
                    <select
                      name="cars"
                      class="custom-select form-control"
                      v-model="propertyType" @change="changePropertyType($event)"
                    >
                      <option value="">Choose Property</option>
                      <option value="1">Home</option>
                      <option value="2">Hotel</option>
                      <option value="3">Adventure Stay</option>

                    </select>
                  </div>
                </div>
                <div class="col-12" v-show="propertySubTypeShow">
                  <div class="input-field" >
                    <select
                      class="custom-select form-control"
                      v-model="propertySubType"
                    >
                      <option value="0">Choose SubType</option>
                       <option v-for="(p,index) in accProType" :key="index" :value="p.id">{{p.name}}</option>
                    </select>
                  </div>
                </div>
                <div class="col-12" v-show="propertyThirdTypeShow">
                  <div class="input-field">

                    <select class="custom-select form-control" v-model="propertyThirdType">
                      <option   value="0">Choose Type</option>
                      <option   value="Private">Private</option>
                      <option   value="Entire">Entire</option>
                      <option   value="Share">Share</option>
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
                proFacilityToggle();
                propertyTypeFalse();
                priceFalse();
                ratingFalse();
              "
              :class="{ facilityfiltered: isActivefacility }"
            >
              Property Facilities</a
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

      <div
        class="hotel-list-box"
        v-for="(accommodation, index) in accommodations.data"
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
                     v-for="(i, index) in accommodation.images"
                    :key="index"
                    @click="changeIndex(1);"

                  >
                  <router-link  :to="{path:'/tripoperators/detail/'+accommodation.id}"  tag="img" :src="$imagePath+i.name"></router-link>

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
                  <small>{{ accommodation.title }}</small>
                </div>
                <strong>{{ accommodation.title +', '+accommodation.title }}</strong>
              </div>
              <div
                class="d-flex align-items-center justify-content-between mb-3"
              >
                <router-link  :to="{path:'/tripoperators/detail/'+accommodation.id}">
                <h3>{{ accommodation.title.substr(0, 20) }}</h3>
                </router-link>
                <a href="#" class="rating-button">
                  <span class="rating align-self-center"
                    ><i class="fa fa-star"></i
                  ></span>
                  <span class="rating-title align-self-center">{{ accommodation.id.toFixed(1)}}</span>
                  <span class="count-rating align-self-center">(14)</span>
                </a>
              </div>
              <div class="room-capi">
                3 guests<span aria-hidden="true"> · </span> 1 bedroom<span
                  aria-hidden="true"
                >
                  ·
                </span>
                1 bed<span aria-hidden="true"> · </span>
                1.5 baths
              </div>
              <ul class="hotel_icon">
                <li v-for="(f,index) in accFacility" :key="index">
                  <span class="icon"
                    ><img :src="'/assets/icons/'+f.image" alt="wifi"
                  /></span>
                  <span class="text">{{f.name}}</span>
                </li>

              </ul>
              <div class="price-div d-flex align-self-center">
                <del class="align-self-center"
                  >From US {{ accommodation.price }}$
                </del>
                <a href="#" class="btn btn-price">
                  <span>From</span> {{ accommodation.price }} $</a
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

                <a :href="'/trips/detail/'+accommodation.id" class="btn btn-viewmap">View on map!</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <pagination
        :data="accommodations"
        @pagination-change-page="getResults"
      ></pagination>

      <!-- <nav aria-label="Page navigation example" class="pagination-links">
            <ul class="pagination justify-content-center">
              <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
              </li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link " href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item">
              <a class="page-link" href="#">Next</a>
              </li>
            </ul>
          </nav> -->
    </div>
  </main>
</template>

<script>
import { Slider, SliderItem } from "vue-easy-slider";
 export default {
  mode: 'history',
  name: "Accommodation",
  props: ['modeldasd'],
  components: {
    Slider,
    SliderItem
  },
  data() {
    return {
      accommodations: {},
      facility: [],
      accFacility:[],
      accProType:[],
      rating: "",
      ratingCustom:"",
      checkInDate: "",
      checkOutDate: "",
      adultGuest: 0,
      childGuest: 0,
      propertyTypeToggle: false,
      propertFacilityToggle: false,
      priceToggle: false,
      ratingToggle: false,
      propertyType: "",
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
      isActivefacility:false,
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
      sliderValue: 2
    };
  },
  created() {

    //console.log(this.$router.getRoutes());
    this.getResults();
    this.facilities();
      if(this.$route.query.country || this.$route.query.city) {
          this.addressCountry = this.$route.query.country;
          this.addressCity = this.$route.query.city;
      }
    $(".map-view-thumb").clcik(function () {
    });
  },
  methods: {
    getAddressData: function (addressData, placeResultData, id) {

      this.addressCountry = addressData.country;
      this.addressCity = addressData.locality;
      this.getResults();
      // this.findForm.location = addressData;
      // this.findForm.country = addressData.country;
      // this.findForm.state = addressData.administrative_area_level_1;
      // this.findForm.city = addressData.locality;
      // this.findForm.lat = addressData.latitude;
      // this.findForm.long = addressData.longitude;
    },
    changePropertyType:function(event){
      this.propertyType = event.target.value;
      if(this.propertyType==''){
        this.propertySubType=0;
        this.accProType="";
        this.propertySubTypeShow=false;
        this.propertyThirdTypeShow=false;

      }else{

      axios.get("/api/getAccommodationSubType/"+this.propertyType).then((response) => {
      this.propertySubType = response.data[0].id;
      this.accProType = response.data;

       });
      if(this.propertyType==2){
        this.propertyThirdTypeShow=false;
        this.propertySubTypeShow=true;
      }else{
      this.propertySubTypeShow=true;
      this.propertyThirdTypeShow=true;
      }

      }

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
      bodyFormData.append("adultGuest", this.adultGuest);
      bodyFormData.append("childGuest", this.childGuest);
      bodyFormData.append("checkInDate", this.checkInDate);
      bodyFormData.append("checkOutDate", this.checkOutDate);
      bodyFormData.append("propertyType", this.propertyType);
      bodyFormData.append("propertySubType", this.propertySubType);
      bodyFormData.append("propertyThirdType", this.propertyThirdType);

      bodyFormData.append("country", this.addressCountry);
      bodyFormData.append("city", this.addressCity);

      bodyFormData.append("propertyFacility", this.propertyFacility);
      bodyFormData.append("minValue", this.minValue);
      bodyFormData.append("maxValue", this.maxValue);
      axios.post("/api/tripOperator", bodyFormData).then((response) => {
        this.accommodations = response.data.acc;

        this.accFacility = response.data.fac;

       });
    },
    adultIncrement() {
      this.adultGuest++;
    },
    adultDecrement() {
      if (this.adultGuest > 1) {
        this.adultGuest--;
      }
    },
    childIncrement() {
      this.childGuest++;
    },
    childDecrement() {
      if (this.childGuest > 1) {
        this.childGuest--;
      }
    },
    propertyTypeTrue() {
      this.propertyTypeToggle = true;
    },
    propertyTypeFalse() {
      this.propertyTypeToggle = false;
    },
    propertyFacilityTrue() {
      this.propertFacilityToggle = true;
    },
    propertyFacilityFalse() {
      this.propertFacilityToggle = false;
    },
    proTypeToggle: function () {
      this.propertyTypeToggle = !this.propertyTypeToggle;
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
      axios.get("/api/getAllFacilities").then((response) => {
        this.facility = response.data.data.facilities;
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
    guestsfilter() {
       if(this.adultGuest > 0 || this.childGuest > 0){
       this.isActiveguests = true;
      }
    },
    protypefilter() {
      this.isActiveprotype = true;
    },
    faciltyfilter() {
      this.isActivefacility = true;
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
      this.propertyType='';
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

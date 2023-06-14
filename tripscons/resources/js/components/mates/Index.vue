<template>
  <main>
    <div class="container">
      <div class="d-flex select-country-sec">
        <h1 class="title-section p-0">
          Find your Host's in
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
   
        <ul>
         
          <li>
            <a
             
              class="btn btn-filter"
              @click="
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
          
        </ul>
      </div>

      <div
        class="hotel-list-box"
        v-for="(genData, index) in generalobjects
.data"
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
                  <router-link  :to="{path:'/mates/detail/'+genData.id}"  tag="img" :src="$imagePath+i.name"></router-link>

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
                  <small>{{ genData.skip_for_now }}</small>
                </div>
                <strong>{{ genData.country +', '+genData.city }}</strong>
              </div>
              <div
                class="d-flex align-items-center justify-content-between mb-3"
              >
                <router-link  :to="{path:'/mates/detail/'+genData.id}">
                <h3>{{ genData.name.substr(0, 20) }}</h3>
                </router-link>
                <a href="#" class="rating-button">
                  <span class="rating align-self-center"
                    ><i class="fa fa-star"></i
                  ></span>
                  <span class="rating-title align-self-center">{{ genData.rating+'.0'}}</span>
                  <span class="count-rating align-self-center">({{genData.no_of_reviews}})</span>
                </a>
              </div>
              
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="hotel-images">
              <div
                class="map-view-thumb"
                style="background-image: url(/assets/img/map-thumb.png)"
              >
                
                <a :href="'/mates/detail/'+genData.id" class="btn btn-viewmap">View on map!</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <pagination
        :data="generalobjects
"
        @pagination-change-page="getResults"
      ></pagination>

    </div>
  </main>
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
      axios.post("/api/mates", bodyFormData).then((response) => {
      this.generalobjects = response.data.mates;
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

<template>
  <div class="create-profile container">
    <!--profile steps-->
    <div class="profile-steps">
      <ul class="d-flex justify-content-around">
        <li class="">
          <img src="/assets/img/icons/feed.png" />
          <p>Personal info</p>
        </li>
        <li class="">
          <img src="/assets/img/icons/services.png" />
          <p>Add Service Listing</p>
        </li>
        <!-- <li class="">
          <img src="/assets/img/icons/ident.png" />
          <p>Identification</p>
        </li> -->
      </ul>
    </div>
    <!--profile creation-->
    <div class="profile-form py-4">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 pr-4">
          <div class="title-heading steps">
            <h1>I`d like to list my:</h1>
          </div>
          <div class="row">
        <div class="col-6 col-sm-6 col-md-6 pr-4">
          <div class="input-wrapper mt-3">
            <input
              type="text"
              name="title"
              class="form-control input_field"
              placeholder="Enter Package Name"
              v-model="title"
            />
          </div>
        </div>
        <div class="col-6 col-sm-6 col-md-6 pr-4">
          <div class="input-wrapper mt-3" style="top: 0; position: relative;">
              <div class="check-guest">
                <label class="switch">
                  <input type="checkbox" v-model="is_free_guide" value="1" />
                  <span class="slider round"></span>
                </label>
                <span class="ml-2">Do you offer free package services?
                </span>
              </div>
          </div>
        </div>
        <template v-if="is_free_guide == 0">
          <div class="col-6 col-sm-6 col-md-6 pr-4">
            <div class="input-wrapper mt-3">
              <input type="number" name="price_per_hour_rate" placeholder="Per hour rate" v-model="price_per_hour_rate" class="form-control input_field" required>
            </div>
          </div>
          <div class="col-6 col-sm-6 col-md-6 pr-4">
            <div class="input-wrapper mt-3">
              <input type="number" name="price_per_day_rate" placeholder="Per day rate" v-model="price_per_day_rate" class="form-control input_field" required>
            </div>
          </div>
        </template>
        <div class="col-6 col-sm-6 col-md-6 pr-4">
        <div class="row" style="margin-top: 15px">
            <div class="input-field" style="width: 97%;">
              <vue-google-autocomplete
                style="z-index: 99999999 !important"
                ref="address"
                id="map"
                classname="form-control"
                placeholder="Please Enter location"
                types="(regions)"
                v-on:placechanged="getAddressData"
              >
              </vue-google-autocomplete>
            </div>
          </div>
        </div> 
      </div>

      <div class="d-flex justify-content-end mt-3">
          <a class="btn btn-blackk" @click="addTransport">
            save & continue
          </a>
        </div>

    </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueGoogleAutocomplete from "vue-google-autocomplete";
import VueTimepicker from "vue2-timepicker/src/vue-timepicker.vue";
export default {
  name: "UserDashboard",
  components: {
    VueGoogleAutocomplete,
    VueTimepicker,
  },
  data() {
    return {
      abpout:"",
      title: "",
      vechile_type: "Select Vechile Type",
      per_day_price: 0,
      cc: "",
      no_of_people: "",
      transmission: "Select Transmission",
      assembly: "Select Assembling",
      country: "",
      city: "",
      latitude: "",
      longitude: "",
      location: "",
      error: "",
      userObj: "",
      is_free_guide: 0, 
      price_per_hour_rate: '',
      price_per_day_rate: '',
    };
  },
  created() {
    //this.getUserProfile();
  },
  methods: {
    getAddressData: function (addressData, placeResultData, id) {
      this.country = addressData.country;
      this.city = addressData.locality;
      this.latitude = addressData.latitude;
      this.longitude = addressData.longitude;
      this.location = placeResultData.formatted_address;
    },
    addTransport() {
      if (this.title == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter package name.",
          timer: 2500,
        });
        return;
      }
      if (this.about == "please enter about") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "please enter about.",
          timer: 2500,
        });
        return;
      }

      if(this.is_free_guide == 0){
          if (this.price_per_hour_rate == "") {
              this.$swal({
                  type: "error",
                  title: "Error!",
                  text: "Price per hour rate field is required",
                  timer: 2500,
              });
            this.error = true;
            return false;
        }
        if (this.price_per_day_rate == "") {
            this.$swal({
                type: "error",
                title: "Error!",
                text: "Price per day rate field is required",
                timer: 2500,
            });
          this.error = true;
          return false;
        }
      }
     
    
      if (this.location == "" ) {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "please enter location",
          timer: 2500,
        });
        return;
      }
      
      this.is_free_guide = this.is_free_guide ? 1 : 0;
      let bodyFormData = new FormData();
      bodyFormData.append("title", this.title);
      bodyFormData.append("is_free_guide", this.is_free_guide);
      bodyFormData.append("price_per_hour_rate", this.price_per_hour_rate);
      bodyFormData.append("price_per_day_rate", this.price_per_day_rate);
      bodyFormData.append("lat", this.latitude);
      bodyFormData.append("lng", this.longitude);
      bodyFormData.append("city", this.city);
      bodyFormData.append("country", this.country);
      bodyFormData.append("location", this.location);
      axios.post("/api/addGuidePackage", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.$router.push({
          path: "/guides/edit/" + response.data.data.id,
          });
        } 
      }).catch((err) => {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Something went wrong",
          timer: 2500,
        });
        return; 
     });;
    },
  },
};
</script>

<style scoped>
</style>

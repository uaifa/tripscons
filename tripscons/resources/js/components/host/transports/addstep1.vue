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
          <p>Add Transport Listing</p>
        </li>
        <li class="">
          <img src="/assets/img/icons/ident.png" />
          <p>Identification</p>
        </li>
      </ul>
    </div>
    <!--profile creation-->
    <div class="profile-form pb-4">
      <div class="d-flex justify-content-start "> 
        <a href="#" type="button" class="btn-back mb-3"> 
          <i class="fa fa-arrow-left mr-2"></i> Back</a>
      </div>
      <div class="row">
        <div class="col-12 col-sm-6 col-md-6 pr-4">
          <div class="title-heading steps">
            <h1>I`d like to list my:</h1>
          </div>

          <div class="input-wrapper mt-3">
            <input
              type="text"
              name="title"
              class="form-control input_field"
              placeholder="Enter Vechile Name"
              v-model="title"
            />
          </div>
          <div class="input-wrapper mt-3">
            <select class="form-select form-control" v-model="vechile_type">
              <option value="Select Vechile Type">Select Vechile Type</option>
              <option value="Car">Car</option>
              <option value="Jeap">Jeap</option>
              <option value="Bus">Bus</option>
            </select>
          </div>

          <div class="input-wrapper mt-3">
            <input
              type="number"
              name="per_day_price"
              class="form-control input_field"
              placeholder="price per day"
              v-model="per_day_price"
            />
          </div>

          <div class="row" style="margin-top: 15px">
            <div class="col-12 pr-3">
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
        <div class="col-12 col-sm-6 col-md-6 pr-4 colright">
          <div class="input-wrapper ml-4">
            <input
              type="number"
              class="form-control input_field"
              placeholder="Seats"
              v-model="no_of_people"
            />
          </div>

          <div class="input-wrapper ml-4 mt-3">
            <input
              type="text"
              class="form-control input_field"
              placeholder="CC"
              v-model="cc"
            />
          </div>

          <div class="input-wrapper ml-4 mt-3">
            <select class="form-select form-control" v-model="transmission">
              <option value="Select Transmission">Select Transmission</option>
              <option value="Auto">Auto</option>
              <option value="Manual">Manual</option>
            </select>
          </div>

          <div class="input-wrapper ml-4 mt-3">
            <select class="form-select form-control" v-model="assembly" aria-placeholder="Select Assembling">
              <option selected>Select Assembling</option>
              <option value="Local">Local</option>
              <option value="Imported">Imported</option>
            </select>
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
      title: "",
      vechile_type: "Select Vechile Type",
      per_day_price: "",
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
          text: "Please enter transport name.",
          timer: 2500,
        });
        return;
      }
      if (this.vechile_type == "Select Vechile Type") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select transport type.",
          timer: 2500,
        });
        return;
      }
     
      if (this.per_day_price == "" || this.per_day_price == 0) {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter per day price",
          timer: 2500,
        });
        return;
      }
      if (this.per_day_price < 0) {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter valid price,price can't be negative",
          timer: 2500,
        });
        return;
      }
      if (this.location == "" ) {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter location",
          timer: 2500,
        });
        return;
      }
      
      if (this.no_of_people == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter seats",
          timer: 2500,
        });
        return;
      }
      if (this.cc == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter cc",
          timer: 2500,
        });
        return;
      }
      if (this.transmission == "Select Transmission") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select transmission",
          timer: 2500,
        });
        return;
      }
      if (this.assembly == "Select Assembling") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select assembling",
          timer: 2500,
        });
        return;
      }
      let bodyFormData = new FormData();
      bodyFormData.append("title", this.title);
      bodyFormData.append("vechile_type", this.vechile_type);
      bodyFormData.append("per_day_price", this.per_day_price);
      bodyFormData.append("no_of_people", this.no_of_people);
      bodyFormData.append("cc", this.cc);
      bodyFormData.append("transmission", this.transmission);
      bodyFormData.append("assembly", this.assembly);
      bodyFormData.append("lat", this.latitude);
      bodyFormData.append("lng", this.longitude);
      bodyFormData.append("city", this.city);
      bodyFormData.append("country", this.country);
      bodyFormData.append("location", this.location);
      axios.post("/api/addTransport", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.$router.push({
          path: "/host/transports/detail/" + response.data.data.id,
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

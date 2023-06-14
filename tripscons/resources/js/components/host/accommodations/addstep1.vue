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
          <p>Add Accommodation Listing</p>
        </li>
        <li class="">
          <img src="/assets/img/icons/ident.png" />
          <p>Identification</p>
        </li>
      </ul>
    </div>
    <!--profile creation-->
    <div class="profile-form pb-4">
      <div class="d-flex justify-content-start"> 
        <a href="#" type="button" class="btn-back ml-2"> 
          <i class="fa fa-arrow-left mr-2"></i> Back</a>
      </div>
      <form class="mt-3">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-6 pr-4">
            <div class="title-heading steps pl-1">
              <h1>I`d like to list my:</h1>
            </div>
           
            <div class="input-wrapper mt-3">
              <input
                type="text"
                name="title"
                class="form-control input_field"
                placeholder="Enter Accommodation Name"
                v-model="title"
              />
            </div>
            <div class="input-wrapper mt-4">
              <select
                id="inputState"
                class="form-control input_field"
                v-model="propertyType"
                @change="changePropertyType($event)"
              >
                <option value="">Choose Property</option>
                <option value="1">Home</option>
                <option value="2">Hotel</option>
                <option value="3">Adventure stay</option>
              </select>

              <select
                id="inputState"
                class="form-control input_field"
                v-model="subType"
              >
                <option value="0">Choose SubType</option>
                <option
                  v-for="(p, index) in subTypeArray"
                  :key="index"
                  :value="p.name"
                >
                  {{ p.name }}
                </option>
              </select>
            </div>

            <div class="property-type-check mt-4">
              <span class="mr-4">My property is:</span>
              <form>
                <input
                  type="radio"
                  id="Entire"
                  name="Entire"
                  value="Entire"
                  v-model="isProperty"
                />
                <label for="vehicle1" class="ml-2"> Entire</label>
                <input
                  type="radio"
                  id="Joint"
                  class="ml-4"
                  name="Joint"
                  value="Joint"
                  v-model="isProperty"
                />
                <label for="vehicle2" class="ml-2">Joint</label>
                <input
                  type="radio"
                  id="Private"
                  class="ml-4"
                  name="Private"
                  value="Private"
                  v-model="isProperty"
                />
                <label for="vehicle3" class="ml-2">Private</label><br /><br />
              </form>
            </div>
            <div class="row">
              <div class=" col-12 pr-3">
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
                placeholder="Staying capacity"
                v-model="noOfGuest"
              />
            </div>
            <div class="input-wrapper ml-4 mt-4">
              <vue-timepicker
                v-model="checkInTime"
                class="form-control input_field"
              ></vue-timepicker>
              <vue-timepicker
                v-model="checkOutTime"
                class="form-control input_field"
              ></vue-timepicker>
            </div>
            <div class="row mt-4 ml-4">
              <div class="check-guest mt-3">
                <label class="switch">
                  <input type="checkbox" v-model="isFlexiableCheckIn" />
                  <span class="slider round"></span>
                </label>
                <span class="ml-2"
                  >Flexible checkin/checkout time upon special requests
                </span>
              </div>
            </div>
            <div class="input-wrapper ml-4 mt-2">
              <input
                type="number"
                class="form-control input_field"
                placeholder="Flexibility Hours"
                v-model="isFlexiableCheckInValue"
                v-show="isFlexiableCheckIn"
              />
            </div>
            <div class="row mt-4 ml-4">
              <div class="check-guest mt-3">
                <label class="switch">
                  <input type="checkbox" v-model="isEnquiry" />
                  <span class="slider round"></span>
                </label>
                <span class="ml-2"
                  >I'll you allow enquiry before reservation
                </span>
              </div>
            </div>
            <div class="input-wrapper ml-4 mt-2">
              <input
                type="number"
                class="form-control input_field"
                placeholder="Enquiry Response Hours"
                v-model="isEnquiryValue"
                v-show="isEnquiry"
              />
            </div>
            <div class="d-flex justify-content-end mt-3">
              <a class="btn btn-blackk" @click="addAccommodation">
                save & continue
              </a>
            </div>
          </div>
        </div>
      </form>
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
      email: "",
      title: "",
      password: "",
      error: "",
      userObj: "",
      propertyType: "",
      subType: 0,
      isProperty: "Entire",
      noOfGuest: "",
      checkInTime: "09:00:00",
      checkOutTime: "12:00:00",
      isFlexiableCheckIn: false,
      isFlexiableCheckInValue: "",
      isEnquiry: false,
      isEnquiryValue: "",
      subTypeArray: [],
      country: "",
      city: "",
      latitude: "",
      longitude: "",
      location: "",
      propertyName: "",
      sub_type_id: "",
    };
  },
  created() {
    //this.getUserProfile();
  },
  methods: {
    changePropertyType: function (event) {
      this.propertyType = event.target.value;
      this.propertyName =
        event.target.options[event.target.options.selectedIndex].text;
      axios
        .get("/api/getAccommodationSubType/" + this.propertyType)
        .then((response) => {
          this.subType = response.data[0].name;
          this.subTypeArray = response.data;
        });
    },
    getAddressData: function (addressData, placeResultData, id) {
      this.country = addressData.country;
      this.city = addressData.locality;
      this.latitude = addressData.latitude;
      this.longitude = addressData.longitude;
      this.location = placeResultData.formatted_address;
    },
    addAccommodation() {
      if (this.title == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter accommodation name.",
          timer: 2500,
        });
        return;
      }

      if (this.propertyType == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select property type",
          timer: 2500,
        });
        return;
      }
      if (this.location == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select location",
          timer: 2500,
        });
        return;
      }
      if (this.noOfGuest == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select staying capacity",
          timer: 2500,
        });
        return;
      }
      if (this.checkInTime == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select check in time",
          timer: 2500,
        });
        return;
      }
      if (this.checkOutTime == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select check out time",
          timer: 2500,
        });
        return;
      }
    
      var timeStart = new Date("01/01/2007 " + this.checkInTime).getHours();
      var timeEnd = new Date("01/01/2007 " + this.checkOutTime).getHours();
  
     if(timeEnd <= timeStart){
         this.$swal({
          type: "error",
          title: "Error!",
          text: "Check out time should be greater than check in time ",
          timer: 2500,
        });
        return;
     }
      if (
        this.isFlexiableCheckIn == true &&
        this.isFlexiableCheckInValue == ""
      ) {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select flexiable checkIn value",
          timer: 2500,
        });
        return;
      }
      if (this.isEnquiry == true && this.isEnquiryValue == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select flexiable enquiry value",
          timer: 2500,
        });
        return;
      }

      let bodyFormData = new FormData();
      bodyFormData.append("title", this.title);
      bodyFormData.append("type_id", this.propertyType);
      bodyFormData.append("sub_type_id", this.sub_type_id);
      bodyFormData.append("propertyType", this.propertyName);
      bodyFormData.append("subType", this.subType);
      bodyFormData.append("isProperty", this.isProperty);
      bodyFormData.append("noOfGuest", this.noOfGuest);
      bodyFormData.append("checkInTime", this.checkInTime);
      bodyFormData.append("checkOutTime", this.checkOutTime);
      bodyFormData.append("isFlexiableCheckIn", this.isFlexiableCheckIn);
      bodyFormData.append(
        "isFlexiableCheckInValue",
        this.isFlexiableCheckInValue
      );
      bodyFormData.append("isEnquiry", this.isEnquiry);
      bodyFormData.append("isEnquiryValue", this.isEnquiryValue);
      bodyFormData.append("latitude", this.latitude);
      bodyFormData.append("longitude", this.longitude);
      bodyFormData.append("city", this.city);
      bodyFormData.append("country", this.country);
      bodyFormData.append("location", this.location);
      axios.post("/api/accommodationAdd", bodyFormData).then((response) => {
        if (response.status == 200) {
          //localStorage.setItem("accommodation_id", response.data.accommodation.id);
          
          if (this.propertyName === "Hotel") {
            this.$router.push({ path: "/host/accommodations/detail/"+response.data.data.id });
          } else {
            this.$router.push({ path: "/host/accommodations/detail/"+response.data.data.id });
            // this.$router.push({ name: "/host/accommodations/add/step2", params: { userId: '123' } })
          }
        } else {
          // this.$swal({
          //   type: "error",
          //   title: "Error!",
          //   text: response.data.message,
          //   timer: 2500,
          // });
        }
      }).catch((err) => {
          this.$swal({
            type: "error",
            title: "Error!",
            text: err.response.data.message,
            timer: 2500,
          });
        });
    },
  },
};
</script>

<style scoped>
</style>

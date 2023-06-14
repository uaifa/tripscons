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
          <p>Add Meals Listing</p>
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
                placeholder="Enter Meal Name"
                v-model="title"
              />
            </div>
            <div class="input-wrapper mt-3">
              <input
                type="text"
                name="meal_type"
                class="form-control input_field"
                placeholder="Lunch"
                v-model="meal_type"
              />
            </div>

            <div class="input-wrapper mt-3">
              <input
                type="number"
                name="title"
                class="form-control input_field"
                placeholder="Price"
                v-model="price"
              />
            </div>
            
            <div class="input-wrapper" style="margin-top:15px;">
              <div class="input-field col-12" >
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
                placeholder="Serving"
                v-model="persons"
              />
            </div>
            <div class="input-wrapper ml-4 mt-3">
              <vue-timepicker
                v-model="opening_time"
                class="form-control input_field"
              ></vue-timepicker>
              <vue-timepicker
                v-model="closing_time"
                class="form-control input_field"
              ></vue-timepicker>
            </div>
            
            <div class="input-wrapper ml-4 mt-3">
              <input
                type="text"
                class="form-control input_field"
                placeholder="Brand Name"
                v-model="brand"
              />
            </div>
            
            
            <div class="d-flex justify-content-end mt-3">
              <a class="btn btn-blackk" @click="addMeal">
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
      mealType: "",
      price: "",
      brand: "",
      persons: "",
      opening_time: "09:00:00",
      closing_time: "12:00:00",
      meal_type:'',
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
    addMeal() {
      if (this.title == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter meal name.",
          timer: 2500,
        });
        return;
      }

      if (this.price === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter valid price",
          timer: 2500,
        });
        return;
      }
      if (this.price == 0) {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter valid price,which greater than zero",
          timer: 2500,
        });
        return;
      }
      if (this.price < 0) {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter valid price",
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
      if (this.persons == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter serving",
          timer: 2500,
        });
        return;
      }
      if (this.opening_time == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select opening Time",
          timer: 2500,
        });
        return;
      }
      if (this.closing_time == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select closing Time",
          timer: 2500,
        });
        return;
      }
     var timeStart = new Date("01/01/2007 " + this.opening_time).getHours();
      var timeEnd = new Date("01/01/2007 " + this.closing_time).getHours();
  
     if(timeEnd <= timeStart){
      this.$swal({
          type: "error",
          title: "Error!",
          text: "Closing time should be greater than opening time ",
          timer: 2500,
        });
        return;
     }
     if (this.brand == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please brand name",
          timer: 2500,
        });
        return;
      }
      

      let bodyFormData = new FormData();
      bodyFormData.append("title", this.title);
      bodyFormData.append("meal_type", this.meal_type);
      bodyFormData.append("price", this.price);
      bodyFormData.append("persons", this.persons);
      bodyFormData.append("brand", this.brand);
      bodyFormData.append("opening_time", this.opening_time);
      bodyFormData.append("closing_time", this.closing_time);
      bodyFormData.append("lat", this.latitude);
      bodyFormData.append("lng", this.longitude);
      bodyFormData.append("city", this.city);
      bodyFormData.append("country", this.country);
      bodyFormData.append("location", this.location);
      axios.post("/api/addMeal", bodyFormData).then((response) => {
        if (response.status == 200) {
          //localStorage.setItem("accommodation_id", response.data.accommodation.id);
          this.$router.push({ path: "/host/meals/detail/"+response.data.data.id });
          
        } else {
          // this.$swal({
          //   type: "error",
          //   title: "Error!",
          //   text: response.data.message,
          //   timer: 2500,
          // });
        }
      });
    },
  },
};
</script>

<style scoped>
</style>

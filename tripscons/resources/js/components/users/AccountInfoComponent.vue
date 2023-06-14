<template>
  <div class="create-profile container">
    <!--profile steps-->
    <ProfileNavBar />
    <!-- <div class="profile-steps">
      <ul class="d-flex justify-content-around">
        <li class="">
          <img src="/assets/img/icons/feed.png" />
          <p>
            <router-link :to="{ path: '/account_info' }"
              >Personal info
            </router-link>
          </p>
        </li>
        <li class="" v-if="type!=2 && type!=1">
          <img src="/assets/img/icons/intrests.png" />
          <p>
            <router-link :to="{ path: '/user/interests' }"
              >Interests</router-link
            >
          </p>
        </li>
        <li class="" v-if="type==1">
          <img src="/assets/img/icons/intrests.png" />
          <p>
            <router-link :to="{ path: '/user/about' }"
              >About</router-link
            >
          </p>
        </li>

        <li class="">
          <img src="/assets/img/icons/ident.png" />
          <p>
            <router-link :to="{ path: '/user/identification' }"
              >Identification</router-link
            >
          </p>
        </li>
      </ul>
    </div> -->
    <!--profile creation-->
    <div class="profile-form pb-5">
      <div class="d-flex justify-content-start mb-3"> 
        <a href="#" type="button" class="btn-back">
          <i class="fa fa-arrow-left mr-2"></i>
          Back</a>
      </div>
      <div class="title-heading">
       
        <h1>please tell us about you!</h1>
      </div>
     
        <div class="row">
          <div class="col-12 col-sm-4 col-md-4">
            <div class="row mt-4">
              <div class="col-12 col-sm-12">
                <input
                  type="text"
                  class="form-control input_field"
                  placeholder="Full name"
                  required
                  v-model="fullName"
                />
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-12 col-sm-6">
                <div class="form-group ">
                  
                  <vue-country-code class="input_field" :enabledCountryCode="true" enableSearchField :disabledFetchingCountry="false" 
                  @onSelect="onSelect"
                  :preferredCountries="['vn', 'us', 'gb']">
                  </vue-country-code>
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <input
                  type="number"
                  class="form-control input_field"
                  placeholder="Phone number"
                  v-model="phoneNumber"
                />
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-12 col-sm-6">
                <input
                  type="text"
                  class="form-control input_field"
                  placeholder="Date of birth"
                  onfocus="(this.type='date')"
                  onblur="(this.type='text')"
                  v-model="birthDate"
                  :max="futureDateDisabled"
                />
              </div>
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <select
                    id="inputState"
                    class="form-control input_field"
                    v-model="gender"
                  >
                    <option value="Gender">Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="check-guest mt-5">
                <label class="switch">
                  <input type="checkbox" checked v-model="isMate" />
                  <span class="slider round"></span>
                </label>
                <span class="ml-2"
                  >I'd like to receive trip invites as tripmate
                </span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-4 col-md-4 pl-3">
            <div class="form-group mt-4 ">
              <div class="input-field">
                <vue-google-autocomplete
                  v-model="streetAddress"
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
            </div>

            <div class="row  mt-4">
              <div class="col-12 col-sm-6">
                <input
                  type="text"
                  class="form-control input_field"
                  placeholder="Country"
                  v-model="country"
                  readonly
                />
              </div>
              <div class="col-12 col-sm-6">
                <input
                  type="text"
                  class="form-control input_field"
                  placeholder="State"
                  required
                  v-model="state"
                  readonly
                />
              </div>
            </div>
            <div class="row mt-4 ">
              <div class="col-12 col-sm-6">
                <input
                  type="text"
                  class="form-control input_field"
                  placeholder="City"
                  required
                  v-model="city"
                  readonly
                />
              </div>
              <div class="col-12 col-sm-6">
                <input
                  type="text"
                  class="form-control input_field"
                  placeholder="Zip"
                  v-model="zipCode"
                />
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-4 col-md-4">
            <div class="image-holder ml-5 d-flex mr-5">
              <div class="image-wraper image-upload-wrapper">
                <img
                  v-bind:src="imagePreview"
                  width="250px"
                  v-if="showPreview"
                  
                />
                <img
                  :src="'/assets/uploads/users/' + picture"
                  width="250px"
                  v-else
                  
                />
              </div>
              <div class="image-upload mt-4">
                <a
                  class="btn btn-whitee"
                  data-toggle="modal"
                  data-target="#imageupload"
                  >Upload photo</a
                >

                <div
                  class="modal fade"
                  id="imageupload"
                  role="dialog"
                  aria-labelledby="imageuploadLabel"
                  aria-hidden="true"
                >
                  <div class="modal-dialog" role="document">
                    <button
                      type="button"
                      class="close closee"
                      data-dismiss="modal"
                      aria-label="Close"
                    >
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-content pb-5">
                      <div class="modal-body">
                        <div class="container p-3">
                          
                          <div class="d-flex text-center select-wrapper">
                            <!-- <img src="/assets/img/icons/sele.png" class="img-fluid mt-4" width="60px"> -->
                            <img
                              v-bind:src="imagePreview"
                              width="220px"
                              v-if="showPreview"
                              class="img-fluid mt-4"
                            />
                            <img
                              :src="'/assets/uploads/users/' + picture"
                              width="220px"
                              v-else
                              class="img-fluid mt-4"
                            />
                            <button class="btn btn-blackk-upload mt-3">
                              <input
                              type="file"
                              name="picture"
                              class="form-control button-input"
                              id="picture"
                              @change="onFileChange"
                            />
                            <span class="button-span">
                            Select Picture</span>
                            </button>
                          

                            <!-- <input type="file" placeholder="Select image" class="btn-blackk mt-4"> -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="image-inst mt-3">
                <p>Please upload following size 500x500</p>
              </div>
            </div>
            <div class="mt-3 d-flex justify-content-center">
              <a class="btn btn-blackk" @click="submitForm">
                Save & Continue
              </a>
            </div>
          </div>
        </div>
        
    </div>
  </div>
</template>

<script>
import VueGoogleAutocomplete from "vue-google-autocomplete";
import ProfileNavBar from './ProfileNavBar.vue';
export default {
  name: "AccountInfoComponent",
  components: {
    VueGoogleAutocomplete,
    ProfileNavBar,
  },
  data() {
    return {
      fullName: "",
      countryCode: "Please Select",

      phoneNumber: "",
      birthDate: "",
      gender: "Gender",
      isMate: "true",
      streetAddress: "",
      country: "",
      state: "",
      city: "",
      zipCode: "",
      picture: null,
      imagePreview: null,
      showPreview: false,
      userObj: "",
      countries: {},
      location: "",
      type:0,
      phoneLength:'',
    };
  },
  computed:{
    
   futureDateDisabled(){
     return this.$helpers.futureDateDisabled();
    }
  },
  created() {
    this.getUserProfile();
    this.getAllCountries();
    this.type = localStorage.getItem("type");
  },
  methods: {
    submitForm() {
      let formData = new FormData();
      if (this.fullName == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter full name",
          timer: 2500,
        });
        return;
      }  
       if (this.phoneNumber == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter valid mobile number",
          timer: 2500,
        });
        return;
      } 
      this.phoneLength = this.phoneNumber.length;
      if (this.phoneLength > 10 || this.phoneLength < 10)  {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter valid mobile number",
          timer: 2500,
        });
        return;
      } 
     if (this.birthDate == "" || this.birthDate == 'null') {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select birth date",
          timer: 2500,
        });
        return;
      } 
      if (this.gender == "Gender") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select gender",
          timer: 2500,
        });
        return;
      }  
      if (this.streetAddress == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select location",
          timer: 2500,
        });
        return;
      }
        
      
      formData.append("name", this.fullName);
      formData.append("country_code", this.countryCode);
      formData.append("phone", this.phoneNumber);
      formData.append("date_of_birth", this.birthDate);
 
      formData.append("gender", this.gender);
      formData.append("is_mate", this.isMate);
      formData.append("address", this.streetAddress);
      formData.append("country", this.country);
      formData.append("state", this.state);
      formData.append("city", this.city);
      formData.append("postal_code", this.zipCode);
      if (this.showPreview == true) {
        formData.append("image", this.picture);
      }
      axios.post("/api/updateUser", formData).then((response) => {
        if (response.status == 200) {
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
          
          if(this.type==2){ //if host then no need add interest
            this.$router.push({ path: "/user/identification" });
          }else{
            if(this.type == 1){
              this.$router.push({ path: "/user/about" });
            }else{
              this.$router.push({ path: "/user/interests" });
            }
          }
        } else {
          this.$swal({
            type: "error",
            title: "Error!",
            text: response.data.message,
            timer: 2500,
          });
        }
      }).catch((err) => {
          this.$swal({
            type: "error",
            title: "Error!",
            text: err.response.data.message,
            timer: 2500,
          });
        });;
    },
    onSelect({name, iso2, dialCode}) {
      // console.log(name, iso2, dialCode);
      // alert(name, iso2, dialCode);
      this.countryCode = dialCode;
     },
    getUserProfile() {
  
      let bodyFormData = new FormData();
      axios.get("/api/getUserProfile", bodyFormData).then((response) => {
        this.userObj = response.data.data;
        this.country = this.userObj.country;
        this.state = this.userObj.state;
        this.city = this.userObj.city;
        this.zipCode = this.userObj.postal_code;
        this.streetAddress = this.userObj.address;
        this.picture = this.userObj.image;
        this.isMate = this.userObj.is_mate;
        this.gender = this.userObj.gender;
        this.fullName = this.userObj.name;
        this.phoneNumber = this.userObj.phone;
        this.countryCode = this.userObj.country_code;
        this.onSelect('','',this.countryCode);
       
        if(this.gender === ""){
          this.gender = "Gender";
        }
        if(this.userObj.type == 1 && (this.userObj.user_services).length < 1){
          this.showModal('add-services');
        }

        this.birthDate = this.userObj.date_of_birth;
        if(this.birthDate == null){
          this.birthDate = "";
        }
        
        
        
        
        
      });
    },

    onFileChange(event) {
      this.picture = event.target.files[0];
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.showPreview = true;
          this.imagePreview = reader.result;
        }.bind(this),
        false
      );

      if (this.picture) {
        if (/\.(jpe?g|png|gif)$/i.test(this.picture.name)) {
          reader.readAsDataURL(this.picture);
        }
      }
    },

    getAllCountries() {
      axios.get("/api/getAllCountries").then((response) => {
        this.countries = response.data.countries;
      });
    },
    getAddressData: function (addressData, placeResultData, id) {
      this.country = addressData.country;
      this.state = addressData.administrative_area_level_1;
      this.city = addressData.locality;
      this.streetAddress = placeResultData.formatted_address;
    },
    showModal(id){
      $("#"+id).modal('show');
    }
  },
};
</script>

<style scoped>
a.btn.btn-ugrade {
  border: 1px solid greenyellow;
  margin: 25px 0 0 25px;
  border-color: #85b59e;
  background-image: linear-gradient(135deg, #85b59e 0%, #03996f 100%);
  padding: 10px;
  border-radius: 30px;
  color: white;
}

.bmd-label-floating {
  margin-top: 12px;
}

.form-check {
  position: relative;
  display: contents;
  padding-left: 1.25rem;
}
</style>

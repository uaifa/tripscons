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
          <p>Add Activity Listing</p>
        </li>
        <li class="">
          <img src="/assets/img/icons/ident.png" />
          <p>Identification</p>
        </li>
      </ul>
    </div>
    <!--profile creation-->
    <div class="profile-form py-4">
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
              placeholder="Enter Activity Name"
              v-model="title"
            />
          </div>
          <div class="input-wrapper mt-3">
            <input
                type="text"
                placeholder="Activity Type"
                v-model="type"
                class="form-control input_field"
                ari
              />
            
          </div>

          <div class="input-wrapper mt-3">
            <input
              type="number"
              name="suitable_age"
              class="form-control input_field"
             placeholder="Suitable Age"
              v-model="suitable_age"
            />
          </div>

          
        </div>
        <div class="col-12 col-sm-6 col-md-6 pr-4 colright">
          <div class="input-wrapper ml-4">
             <h4>About</h4>
                      <textarea
                        class="form-control"
                        rows="4"
                        v-model="about"
                      ></textarea>
          </div>
<div class="d-flex justify-content-end mt-3">
            <a class="btn btn-blackk" @click="addExperience">
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
export default {
  name: "UserDashboard",
  components: {
    VueGoogleAutocomplete,
  },
  data() {
    return {
      title: "",
      type: "",
      about: '',
      suitable_age: "",
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
    addExperience() {
      if (this.title == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter activity name.",
          timer: 2500,
        });
        return;
      }

      if (this.type == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter type",
          timer: 2500,
        });
        return;
      }
     
      if (this.suitable_age == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter suitable age",
          timer: 2500,
        });
        return;
      }

      let bodyFormData = new FormData();
      bodyFormData.append("title", this.title);
      bodyFormData.append("type", this.type);
      bodyFormData.append("about", this.about);
      bodyFormData.append("suitable_age", this.suitable_age);
      axios.post("/api/addExperience", bodyFormData).then((response) => {
        if (response.status == 200) {
            this.$router.push({
            path: "/host/experiences/detail/" + response.data.data.id,
          });
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

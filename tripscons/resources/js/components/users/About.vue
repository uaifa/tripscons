<template>
  <main>
    <div class="create-profile container">
      <!--profile steps-->
      <ProfileNavBar />
      <!--profile creation-->
      <div class="profile-form pl-5">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-6 py-4 pr-4">
            <div class="title-heading">
              <h1>About</h1>
            </div>
            <form>
              <div class="form-group mt-4">
                <textarea
                  class="form-control input_textarea"
                  maxlength="250"
                  placeholder="Tell us about you"
                  rows="4"
                  v-model="about"
                ></textarea>
              </div>
              <div class="select-lang my-3">
                <label>Destinations</label>
                <multiselect v-model="destinations" :options="destionationOptions" multiple placeholder="Select Destinations"></multiselect>
              </div>
            
              <div class="select-lang my-3">
                <label>Languages</label>
                <multiselect v-model="languages" :options="languageOptions" multiple placeholder="Select Languages"></multiselect>
              </div>
              <div class="select-lang my-3 row">
                <div class="col-6 p-0 pr-2">
                  <label>Price per hour rate</label>
                <input type="number" class="form-control" v-model="price_per_hour_rate" name="price_per_hour_rate" id="price_per_hour_rate" min="0" value="" placeholder="Price per hour rate" />
                </div>
                <div class="col-6 p-0 pr-2">
                  <label>Price per day rate</label>
                <input type="number" class="form-control" min="0" v-model="price_per_day_rate" name="price_per_day_rate" id="price_per_day_rate" value="" placeholder="Price per day rate" />
                </div>
              </div>
              <div class="select-lang my-3">
                <label>Group discount</label>
                <input type="number" class="form-control" min="0" v-model="group_discount" name="group_discount" id="group_discount" value="" placeholder="Group discount" />
                
              </div>
              <div class="languages-container mt-2">
                <ul class="d-flex languages-count">
                  <li>english</li>
                  <li>german</li>
                </ul>
              </div>
              <div class="mt-5 d-flex justify-content-center">
                <a class="btn btn-blackk" @click="userAboutSave">
                  Save & Continue
                </a>
              </div>
            </form>
          </div>
          <div class="col-12 col-sm-6 col-md-6 bg-image">
            <div class="right-image pl-4 d-flex">
              <img src="/assets/img/img5.png" class="img-fluid pl-2" />
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>
</template>

<script>

import ProfileNavBar from './ProfileNavBar.vue';

export default {
  name: "Interests",
    components: {
        ProfileNavBar,
    },
  data() {
    return {
      generalobjects: {},
      checkedActivities: [],
      about: "",
      language: "Select languages",
      userObj: "",
      limit: 100,
      destinations: null,
      destionationOptions: ["Skardu Valley","Hunza Valley","Naran Valley","Shogran valley","Neelum Valley","Kalam Swat Valley","Chitral Valley","Shigar Valley"],
      languages: null,
      languageOptions: ['English', 'German', 'Chinese'],
      price_per_hour_rate: '',
      price_per_day_rate: '',
      group_discount: '',

    };
  },
  created() {
    this.activities();
    this.getUserProfile();
    this.getLanguagesAndDestinations();
  },
 computed: {
    splitedList() {
      let arraydata = [];
      this.checkedActivities.map((el) => {
        let namedata = el.split("|");
        let facilityName = namedata[0];
        let facilityImage = namedata[1];
        arraydata.push({ name: facilityName, image: facilityImage });
      });
      return arraydata;
    },
  },
  methods: {
    activities() {
      axios.get("/api/getUserActivities").then((response) => {
        this.generalobjects = response.data.activities;
        this.generalobjects.forEach((item) => {
          if (item.ischeck == 1) {
            this.checkedActivities.push(item.name + "|" + item.image);
          }
        });
      }).catch((err) => {
          this.$swal({
            type: "error",
            title: "Error!",
            text: err.response.data.message,
            timer: 2500,
          });
        });
    },
    userActivitySave() {
      
      let bodyFormData = new FormData();
      if (this.checkedActivities == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select activities",
          timer: 2500,
        });
        return;
      }
      bodyFormData.append("activity", this.checkedActivities);
      axios.post("/api/userActivityAdd", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
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
        });
    },
    userAboutSave() {
      let bodyFormData = new FormData();
      if (this.about === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input description",
          timer: 2500,
        });
        return;
      }
      
      bodyFormData.append("about", this.about);
      bodyFormData.append("languages", this.languages);
      bodyFormData.append("destinations", this.destinations);
      bodyFormData.append("price_per_hour_rate", this.price_per_hour_rate);
      bodyFormData.append("price_per_day_rate", this.price_per_day_rate);
      bodyFormData.append("group_discount", this.group_discount);
  

      axios.post("/api/updateUser", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
          this.$router.push({ path: "/user/identification" });
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
        });
    }, //href="profile-identity.html"
    getUserProfile() {
      let bodyFormData = new FormData();
      axios.get("/api/getUserProfile", bodyFormData).then((response) => {
        this.userObj = response.data.data;
        this.language = this.userObj.languages;
        if(this.language == ""){
          this.language ="Select languages";
        }
        this.about = this.userObj.about;
        if(this.userObj && this.userObj.service_provider_rates){
          this.price_per_hour_rate = this.userObj.service_provider_rates ? this.userObj.service_provider_rates.price_per_hour_rate : 0;
          this.price_per_day_rate = this.userObj.service_provider_rates ? this.userObj.service_provider_rates.price_per_day_rate : 0;
          this.group_discount = this.userObj.service_provider_rates ? this.userObj.service_provider_rates.group_discount : 0;
          this.languages = this.userObj.service_provider_rates ? (this.userObj.service_provider_rates.languages.split(',') ?  this.userObj.service_provider_rates.languages.split(',') : this.userObj.service_provider_rates.languages) : '';
          this.destinations = this.userObj.service_provider_rates ? (this.userObj.service_provider_rates.destinations.split(',') ? this.userObj.service_provider_rates.destinations.split(',') : this.userObj.service_provider_rates.destinations) : '';
          
        }
        
        if(this.about == 'null'){
          this.about ="";
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
    getLanguagesAndDestinations(){
      axios.get("/api/languages/destinations").then((response) => {
        if(response.data.data.languages){
          this.languageOptions = response.data.data.languages;
        }
        if(response.data.data.destinations){
          this.destionationOptions = response.data.data.destinations;
        }
      }).catch((err) => {
          this.$swal({
            type: "error",
            title: "Error!",
            text: err.response.data.message,
            timer: 2500,
          });
        });
      
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

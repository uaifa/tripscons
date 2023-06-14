<template>
  <main>
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
          <li class="">
            <img src="/assets/img/icons/intrests.png" />
            <p>
              <router-link :to="{ path: '/user/interests' }"
                >Interests</router-link
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
      <div class="profile-form pl-5">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-6 py-4 pr-4">
            <div class="title-heading">
              <h1>What are your interests?</h1>
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
              <p>Let's add activities you like the most</p>
              <a
                href="#"
                class="btn-activities btn-whitee my-4"
                data-toggle="modal"
                data-target="#activities"
                >Explore Activities</a
              >
              <div
                class="modal fade"
                id="activities"
                role="dialog"
                aria-labelledby="loginmodalLabel"
                aria-hidden="true"
              >
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content pb-5">
                    <div class="modal-body">
                      <div class="loginbody container p-3">
                        <div class="facilities-container">
                          <div
                            
                            v-for="(genData, index) in generalobjects"
                            :key="index"
                          >
                          <label :for="genData.name" class="facility-item">
                            <input
                              type="checkbox"
                              :id="genData.name"
                              :value="genData.name + '|' + genData.image"
                              class="mr-2"
                              v-model="checkedActivities"
                              checked
                            />

                            <img
                              :src="'/assets/img/icons/' + genData.image"
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                            />
                            <p class="activity-name">{{ genData.name }}</p>
                              </label>
                          </div>
                        </div>

                        <button
                          class="btn btn-whitee mt-3 ml-4"
                          @click="userActivitySave"
                        >
                          Add Activities
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="activities-container mt-2">
                <ul class="d-flex activities-count">
                  <li>rafting</li>
                  <li>surfing</li>
                  <li>rafting</li>
                  <li>surfing</li>
                  <li>rafting</li>
                  <li>surfing</li>
                  <li>rafting</li>
                  <li>surfing</li>
                  <li>rafting</li>
                  <li>surfing</li>
                </ul>
              </div>

              <div class="select-lang my-3">
                <select
                  id="languages"
                  class="form-control input_field"
                  v-model="language"
                  >
                >
                  <option value="Select languages">Select languages</option>
                  <option value="English">English</option>
                  <option value="German">German</option>
                  <option value="Chinese">Chinese</option>
                </select>
              </div>
              <div class="languages-container mt-2">
                <ul class="d-flex languages-count">
                  <li>english</li>
                  <li>german</li>
                </ul>
              </div>
              <div class="mt-5 d-flex justify-content-center">
                <a class="btn btn-blackk" @click="userIntrestSave">
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
      <label>Activities  Selected</label>
      <div class="facilities-parent-div">
                    <ul >
                      <li v-for="(i, index) in splitedList" :key="index">
                        {{ i.name }}
                        <img
                          :src="'/assets/img/icons/' + i.image"
                          data-bs-toggle="tooltip"
                          data-bs-placement="top"
                        />
                      </li>
                    </ul>
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
    };
  },
  created() {
    this.activities();
    this.getUserProfile();
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
    userIntrestSave() {
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
      bodyFormData.append("languages", this.language);
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

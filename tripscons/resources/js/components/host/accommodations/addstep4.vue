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
          <p>Services</p>
        </li>
        <li class="">
          <img src="/assets/img/icons/ident.png" />
          <p>Identification</p>
        </li>
      </ul>
    </div>
    <!--profile creation-->
    <div class="profile-form py-4">
      
      <form class="mt-5">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-6 pr-4">
            <p>Let's add facilities you like the most</p>
            <a
              href="#"
              class="btn-facilities btn-whitee"
              data-toggle="modal"
              data-target="#activities"
              >Explore facilities</a
            >
            <div
              class="modal fade"
              id="activities"
              role="dialog"
              aria-labelledby="loginmodalLabel"
              aria-hidden="true"
            >
              <div class="modal-dialog" role="document">
                <div class="modal-content pb-5">
                  <div class="modal-body">
                    <div class="loginbody container p-3">
                      <div class="facilities-container">
                        <div
                          class="facility-item"
                          v-for="(genData, index) in generalobjects"
                          :key="index"
                        >
                          <input
                            type="checkbox"
                            :id="genData.name"
                            :value="genData.name + '|' + genData.image"
                            class="mr-2"
                            v-model="checkedFacilities"
                            checked
                          />

                          <img
                            :src="'/assets/icons/' + genData.image"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                          />
                          <p class="activity-name">{{ genData.name }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <label>Facilities Selected</label>
                    <ul v-for="(i, index) in splitedList" :key="index">
                      <li>
                        {{ i.name }}
                        <img
                          :src="'/assets/icons/' + i.image"
                          data-bs-toggle="tooltip"
                          data-bs-placement="top"
                        />
                      </li>
                    </ul>
                </div>
                
              </div>
              
            </div>
          
            <div class="title-heading mt-4 ml-1">
              <p class="">Pre-Arrival Notice?</p>
             
                <label class="switch">
                  <input type="checkbox" v-model="isPreArrival" />
                  <span class="slider round"></span>
                </label>
              </div>
            <div class="pre-arival mt-3">
              <div class="cust-radio">
                <div class="radio-item1" v-show="isPreArrival">
                  <label>
                  </label>
                  <input
                  type="number"
                  step="2"
                  class=" input_field"
                  placeholder=""
                  v-model="is_pre_arrival_notice_value"
                />
                </div>
              </div>
              <div>
                
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-6 px-4 colright">
            <div class="input-wrapper">
              <input
                type="number"
                class="form-control input_field"
                placeholder="Minimum stay in days"
                v-model="min_stay"
              />

              <input
                type="number"
                class="form-control input_field"
                placeholder="Maximum stay in days "
                v-model="max_stay"
              />
            </div>
            <div class="input-wrapper mt-4">
              <input
                type="number"
                step="0.01"
                class="form-control input_field"
                placeholder="Cleaning fee"
                v-model="cleaning_fee"
              />

              <input
              type="number"
                step="0.01"
                class="form-control input_field"
                placeholder="Service fee "
                v-model="service_fee"
              />
            </div>
            <div class="input-wrapper mt-4">
              <input
                type="number"
                class="form-control input_field"
                placeholder="No Of Attached Bath"
                v-model="no_of_attach_bath"
              />

              <input
                type="number"
               
                class="form-control input_field"
                placeholder="No Of Share Bath "
                v-model="no_of_share_bath"
              />
            </div>

         <div class="d-flex justify-content-end mt-3">
            <a class="btn btn-blackk" @click="updateAccommodation">
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
export default {
  name: "UserDashboard",
  data() {
    return {
      error: "",
      is_pre_arrival_notice_value: "",
      no_of_attach_bath: "",
      no_of_share_bath: "",
      cleaning_fee: "",
      service_fee: "",
      min_stay: "",
      max_stay: "",
      generalobjects: {},
      checkedFacilities: [],
      isPreArrival:false,
    };
  },
  created() {
   
    this.facilities();
  },
  computed: {
    splitedList() {
      let arraydata = [];
      this.checkedFacilities.map((el) => {
        let namedata = el.split("|");
        let facilityName = namedata[0];
        let facilityImage = namedata[1];
        arraydata.push({ name: facilityName, image: facilityImage });
      });
      return arraydata;
    },
  },
  methods: {
   
    facilities() {
      axios.get("/api/getAllFacilities").then((response) => {
        this.generalobjects = response.data.data.facilities;
      });
    },
    updateAccommodation() {
      let bodyFormData = new FormData();
       if (this.isPreArrival == true && this.is_pre_arrival_notice_value == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please Select Flexiable Enquiry Value",
          timer: 2500,
        });
        return;
      }
      bodyFormData.append(
        "is_pre_arrival_notice_value",
        this.is_pre_arrival_notice_value
      );
      bodyFormData.append("accommodation_id", localStorage.getItem('accommodation_id'));
      bodyFormData.append("no_of_attach_bath", this.no_of_attach_bath);
      bodyFormData.append("no_of_share_bath", this.no_of_share_bath);
      bodyFormData.append("cleaning_fee", this.cleaning_fee);
      bodyFormData.append("service_fee", this.service_fee);
      bodyFormData.append("min_stay", this.min_stay);
      bodyFormData.append("max_stay", this.max_stay);
      bodyFormData.append("checkedFacilities", this.checkedFacilities);
      axios.post("/api/accommodationUpdate", bodyFormData).then((response) => {
        // if (response.status == 200) {
        //   this.$swal({
        //     type: "success",
        //     title: "Success!",
        //     text: response.data.message,
        //     timer: 2500,
        //   });
          this.$router.push({ path: "/host/accommodations/add/step5" });
        // } else {
        //   this.$swal({
        //     type: "error",
        //     title: "Error!",
        //     text: response.data.message,
        //     timer: 2500,
        //   });
        // }
      });
    },
  },
};
</script>

<style scoped>
</style>

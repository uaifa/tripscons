<template>
  <main>
    <div class="container">
      <div class="d-flex justify-content-start "> 
        <a href="#" type="button" class="btn-back my-3"> 
          <i class="fa fa-arrow-left mr-2"></i> Back</a>
      </div>
      <div class="country-banners-sec">
        <div class="row">
          <div class="col-12 col-sm-8">
            <div class="banner-imag-parent">
              <div class="main-image">
                <img
                  v-if="mainImageShow"
                  :src="
                    $imagePath +
                    'experiences/' +
                    experienceDetail.main_image.name
                  "
                  alt="img"
                />
               <img v-else src="/assets/uploads/users/img1.jpg" alt="img" />
              
                <button
                  class="editimages"
                  data-toggle="modal"
                  data-target="#editdimages"
                >
                  Edit images
                </button>
              </div>
              <!-- Modal -->
              <div
                class="modal fade editdetailss"
                id="editdimages"
                tabindex="-1"
                role="dialog"
                aria-labelledby="editdimages"
                aria-hidden="true"
              >
                <div
                  class="
                    modal-dialog
                    modal-lg
                    modal-dialog-centered
                    modal-dialog-zoom
                  "
                  role="document"
                >
                  <div class="modal-content">
                    <button
                      type="button"
                      class="close"
                      data-dismiss="modal"
                      aria-label="Close"
                    >
                      <span aria-hidden="true">×</span>
                    </button>
                    <div class="modal-body p-4">
                      <div class="row">
                        <div
                          class="col-12 col-sm-4"
                          v-for="(image, index) in experienceDetail.images"
                          :key="index"
                        >
                          <div class="image-edit-wrapper">
                            <img
                              :src="$imagePath + 'experiences/' + image.name"
                            />
                            <div
                              class="d-flex justify-content-center editbuttons"
                            >
                              <button class="edit-parent" @click="deleteImage(image.id)">
                                Delete
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="d-flex justify-content-center mt-3">
                        <button class="btn btn-blackk mt-3">
                          <input
                            class="button-input"
                            type="file"
                            name="normalImage"
                            id="normalImage"
                            @change="normalOnFileChange"
                          />
                          <span class="button-span">
                          Add More Images</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="center-imagess row mt-2" v-if="twoImageShow">
                <div class="col-12 col-md-4"
                  v-for="(i, index) in experienceDetail.two_images"
                  :key="index"
                >
                  <img :src="$imagePath + 'experiences/' + i.name" alt="img" />
                </div>
              </div>
              
              <div v-else class="center-images row">
                <div class="col-12 col-md-4">
                  <img src="/assets/uploads/users/img1.jpg" alt="img" />
                </div>
                <div class="col-12 col-md-4">
                   <img src="/assets/uploads/users/img1.jpg" alt="img" />
                </div>
                <div class="col-12 col-md-4">
                   <img src="/assets/uploads/users/img1.jpg" alt="img" />
                </div>
                
                  
                     

              </div>
            </div>
          </div>
          <div class="col-12 edit-parent col-sm-4">
            <div class="home-details-edits">
              <i
                class="fa fa-pencil"
                data-toggle="modal"
                data-target="#editdetails"
              ></i>

              <!-- Modal -->
              <div
                class="modal fade"
                id="editdetails"
                tabindex="-1"
                role="dialog"
                aria-labelledby="editdetails"
                aria-hidden="true"
              >
                <div
                  class="
                    modal-dialog
                    modal-lg
                    modal-dialog-centered
                    modal-dialog-zoom
                  "
                  role="document"
                >
                  <div class="modal-content">
                    <button
                      type="button"
                      class="close"
                      data-dismiss="modal"
                      aria-label="Close"
                    >
                      <span aria-hidden="true">×</span>
                    </button>
                    <div class="modal-body p-4">
                      <div class="form-group">
                        <label for="">Class Title</label>
                        <input
                          type="text"
                          placeholder=" "
                          value=""
                          class="form-control input_field"
                          v-model="title"
                        />
                      </div>
                      
                      <div class="form-group">
                        <label for="">Language Spoken</label>
                        <input
                          type="text"
                          class="form-control input_field"
                          v-model="language"
                        />
                      </div>

                      <div class="d-flex justify-content-center">
                        <button
                          @click="updateTitleSection"
                          class="btn btn-blackk"
                        >
                          Update
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="hotel-title-sec">
                <h1>{{ title }}</h1>
              </div>
            
              <div
                class="
                  d-flex
                  justify-content-between
                  align-self-center
                  mb-1
                  rate-propertysec
                "
              >
                <h3>{{ language }}</h3>
              </div>
              
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-sm-8">
          <div class="home-details home-details-edit">
            <i
              class="fa fa-pencil"
              data-toggle="modal"
              data-target="#editFeatures"
            ></i>
            <!-- Modal -->
            <div
              class="modal fade"
              id="editFeatures"
              tabindex="-1"
              role="dialog"
              aria-labelledby="editFeatures"
              aria-hidden="true"
            >
              <div
                class="
                  modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom
                "
                role="document"
              >
                <div class="modal-content">
                  <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                  >
                    <span aria-hidden="true">×</span>
                  </button>
                  <div class="modal-body p-4">
                    <div class="form-group">
                      <label>Activity Type</label>
                      <input
                        type="text"
                        placeholder=" "
                        v-model="type"
                        class="form-control input_field"
                      />
                    </div>

                    <div class="form-group">
                      <label>About</label>
                      <textarea
                        class="form-control"
                        rows="5"
                        v-model="about"
                      ></textarea>
                    </div>
                    <div class="d-flex justify-content-center">
                      <button class="btn btn-blackk" @click="updateAbout">
                        Update
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="media mb-4 mt-3">
              <img
                class="mr-3"
                src="/assets/img/icons/activity.png"
                alt="Generic placeholder image"
              />
              <div class="media-body edit-parent">
                <h5 class="mt-0">Activity Type/Category</h5>
                <p>{{ type }}</p>
              </div>
            </div>
            <div class="media mb-4 mt-3">
              <img
                class="mr-3"
                src="/assets/img/icons/grp.png"
                alt="Generic placeholder image"
              />
              <div class="media-body edit-parent">
                <h5 class="mt-0">Group size</h5>
                <p>{{ class_size }}</p>
              </div>
            </div>

            <div class="about-txt edit-parent">
              <h2>About</h2>
              <p>
                {{ about }}
              </p>
            </div>
          </div>
          <div class="media mb-4 mt-4">
            <img style="width:25px;"
              class="mr-3 mt-3"
              src="/assets/icons/clock.png"
              alt="Generic placeholder image"
            />
            <div class="media-body edit-parent">
              <i
                class="fa fa-pencil"
                data-toggle="modal"
                data-target="#edittiming"
              ></i>

              <!-- Modal -->
              <div
                class="modal fade"
                id="edittiming"
                tabindex="-1"
                role="dialog"
                aria-labelledby="editdetails"
                aria-hidden="true"
              >
                <div
                  class="
                    modal-dialog
                    modal-lg
                    modal-dialog-centered
                    modal-dialog-zoom
                  "
                  role="document"
                >
                  <div class="modal-content">
                    <button
                      type="button"
                      class="close"
                      data-dismiss="modal"
                      aria-label="Close"
                    >
                      <span aria-hidden="true">×</span>
                    </button>
                    <div class="modal-body p-4">
                    
                        <div class="row">
                          <div class="col-12 col-md-6">
                            <div class="form-group">
                              <label for="">Start Date</label>
                              <input
                                type="Date"
                                placeholder=" "
                                value=""
                                class="form-control input_field"
                                v-model="date"
                              />
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <div class="form-group">
                              <label for="">Time</label>
                              <vue-timepicker
                               v-model="startTime"
                               class=""
                              ></vue-timepicker>
                            </div>
                          </div>
                          </div>
                        <div class="form-group">
                        <label for="">Location</label>
                        <vue-google-autocomplete
                          style="z-index: 99999999 !important"
                          ref="address"
                          id="map"
                          classname="form-control"
                          placeholder="Please Enter location"
                          types="(regions)"
                          v-on:placechanged="getAddressData"
                          v-model="location"
                        >
                        </vue-google-autocomplete>
                      </div>
                      <div class="form-group">
                        <label for="">Per Person Rate</label>
                        <input
                          type="number"
                          class="form-control input_field"
                          v-model="price"
                        />
                      </div>
                      <div class="form-group">
                        <label for="">Class Duration</label>
                        <input
                          type="number"
                          class="form-control input_field"
                          v-model="duration"
                        />
                      </div>

                      <div class="form-group">
                      <label>Group size</label>
                      <input
                        type="number"
                        placeholder=" "
                        value=""
                        class="form-control input_field"
                        v-model="class_size"
                      />
                    </div>
                       
                        
                       
                    
                          <div class="d-flex justify-content-center">
                          <button @click="addSlot" class="btn btn-blackk">
                            Add
                          </button>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tables">
      <h2>Slots</h2>

      <table>
        <tr>
          <th>Class Size</th>
          <th>Price</th>
          <th>Date</th>
          <th>Start Time</th>
          <th>Duration</th>
          <th>Location</th>
          
          <th>Action</th>
        </tr>
        <tr v-for="(i, index) in slots" :key="index">
          <td>{{ i.class_size }}</td>
          <td>{{ i.price }}</td>
          <td>{{ i.date }}</td>
          <td>{{ i.start_time }}</td>
          <td>{{ i.duration }}</td>
          <td>{{ i.location }}</td>
          
          <td class="edit-parent">
          <button class="btn btn-whitee"  @click="deleteData(i.id)">
          Remove
          </button>
             
          
          </td>
        </tr>
      </table>
    </div>
            </div>
          </div>
        </div>
<vue-confirm-dialog></vue-confirm-dialog>
          <div class="col-12 col-sm-4">
            <div class="rules-sec">
              <div class="panel-group" id="accordion">
                <!-- First Panel -->
                <div class="panel panel-default">
                  <div class="panel-heading edit-parent">
                    <h4
                      class="panel-title edit-parentt"
                      data-toggle="collapse"
                      data-target="#collapseOne"
                      aria-expanded="true"
                      aria-controls="collapseOne"
                    >
                      Rules
                    </h4>
                    <!-- Modal -->
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse">
                    <div class="panel-body edit-parent">
                      <div class="rules-parent">
                        <ul>
                          <li v-for="(rule, index) in rules" :key="index">
                            {{ rule.name }}
                            <i
                              class="fa fa-times"
                              @click="deleteRule(rule.id)"
                            ></i>
                          </li>
                        </ul>
                        <div class="d-flex justify-content-end">
                          
                          <input
                            type="text" class="form-control"
                            v-model="rule_value"
                            @keyup.enter="addRule"
                          />
                          <button class="btn btn-whitee" @click="addRule">
                           +
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Second Panel -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4
                      class="panel-title edit-parentt"
                      data-toggle="collapse"
                      data-target="#collapseTwo"
                    >
                      Cancellation policy
                      <i
                        class="fa fa-pencil"
                        data-toggle="modal"
                        data-target="#cancelhead"
                      ></i>
                    </h4>
                  </div>

                  <!-- Modal -->
                  <div
                    class="modal fade"
                    id="cancelhead"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="cancelhead"
                    aria-hidden="true"
                  >
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <button
                          type="button"
                          class="close"
                          data-dismiss="modal"
                          aria-label="Close"
                        >
                          <span aria-hidden="true">×</span>
                        </button>
                        <div class="modal-body p-4">
                          <form>
                            <div class="form-group">
                              <label for=""> Cancellation policy</label>
                              <textarea
                                rows="3"
                                class="form-control"
                                v-model="cancellationPolicy"
                              ></textarea>
                            </div>
                            <div class="d-flex justify-content-center">
                              <button
                                @click="updateCancPolicy"
                                class="btn btn-blackk"
                              >
                                Update
                              </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body edit-parent">
                      {{ cancellationPolicy }}
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading edit-parent">
                    <h4
                      class="panel-title edit-parentt"
                      data-toggle="collapse"
                      data-target="#collapseThree"
                    >
                      Info

                      <i
                        class="fa fa-pencil"
                        data-toggle="modal"
                        data-target="#infohead"
                      ></i>
                    </h4>
                    <!-- Modal -->
                    <div
                      class="modal fade"
                      id="infohead"
                      tabindex="-1"
                      role="dialog"
                      aria-labelledby="infohead"
                      aria-hidden="true"
                    >
                      <div
                        class="modal-dialog modal-lg"
                        role="document"
                        id="info"
                      >
                        <div class="modal-content">
                          <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                          >
                            <span aria-hidden="true">×</span>
                          </button>
                          <div class="modal-body p-4">
                            <form>
                              <div class="form-group">
                                <label for="">Important Information</label>
                                <textarea
                                  class="form-control"
                                  v-model="importanInformation"
                                ></textarea>
                              </div>
                              <div class="d-flex justify-content-center">
                                <button
                                  @click="updateimpInfo"
                                  class="btn btn-blackk"
                                >
                                  Update
                                </button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body edit-parent">
                      {{ importanInformation }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
      </div>
    </div>
  </main>
</template>
<script>
//import jQuery from 'jQuery';
import VueTimepicker from "vue2-timepicker/src/vue-timepicker.vue";
import VueGoogleAutocomplete from "vue-google-autocomplete";
export default {
  name: "experienceDetail",

  data() {
    return {
      experienceId: this.$route.params.experienceId,
      experienceDetail: "",
      normalImage: null,
      normalImagePreview: null,
      normalShowPreview: false,
      mainImageShow: false,
      twoImageShow: false,
      rules: [],
      slots:[],
      rule_value: "",
      date:"",
      startTime:"12:00:00",
      title: "",
      about: "",
      location: "",
      duration: "",
      seats:"",
      language: "",
      type: "",
      price: "",
      class_size: "",
      importanInformation: "",
      cancellationPolicy: "",
      importanInformation: "",
      cancellationPolicy: "",
      country: "",
      city: "",
      lat: "",
      lng: "",
      loaded: false,
    };
  },
  created() {
    this.getRules();
    this.getSlots();
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
  async beforeMount() {
    this.getExperience();
  },

  components: {
    VueTimepicker,
    VueGoogleAutocomplete,
  },
  methods: {
    getExperience() {
      axios
        .get("/api/experienceDetail/" + this.experienceId)
        .then((response) => {
          this.experienceDetail = response.data.data;
          if (this.experienceDetail.two_images != null && this.experienceDetail.two_images != "") {
            this.twoImageShow = true;
          } else {
            this.experienceDetail.two_images = "";
            this.twoImageShow = false;
          }
          if (this.experienceDetail.main_image != null) {
            this.mainImageShow = true;
          } else {
            this.experienceDetail.main_image = "";
            this.mainImageShow = false;
          }

          this.title = this.experienceDetail.title;
          this.about = this.experienceDetail.about;
          
          this.type = this.experienceDetail.type;
          
          this.language = this.experienceDetail.language;
          
          this.loaded = true;
        }).catch((err) => {
           this.$router.push({ path: "/notfound" });
        });
    },

    normalOnFileChange(event) {
      this.normalImage = event.target.files[0];
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.normalShowPreview = true;
          this.normalImagePreview = reader.result;
        }.bind(this),
        false
      );

      if (this.normalImage) {
        if (/\.(jpe?g|png|gif)$/i.test(this.normalImage.name)) {
          reader.readAsDataURL(this.normalImage);
        }
      }
      let bodyFormData = new FormData();
      bodyFormData.append("image", this.normalImage);
      bodyFormData.append("module", "experiences");
      bodyFormData.append("module_id", this.experienceId);
      axios.post("/api/uploadImages", bodyFormData).then((response) => {
        if (response.status == 200) {
          $('#normalImage').val('');
          this.getExperience();
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
      deleteImage(image_id) {
        Vue.$confirm({
        title: 'Are you sure?',
        message: 'Are you sure you want to remove?',
        button: {
          yes: 'Yes',
          no: 'Cancel'
        },
        callback: confirm => {
        if (confirm) {
        axios
        .delete("/api/deleteImage/" + image_id)
        .then((response) => {
         if (response.status == 200) {
            this.getExperience();
          } 
         }).catch((err) => {
          this.$swal({
            type: "error",
            title: "Error!",
            text: err.response.message,
            timer: 2500,
          });
        });
            }
       
        }
      })
    },

    getAddressData: function (addressData, placeResultData, id) {
      this.country = addressData.country;
      this.city = addressData.locality;
      this.latitude = addressData.latitude;
      this.longitude = addressData.longitude;
      this.location = placeResultData.formatted_address;
    },
    getRules() {
      const params = "module_id=" + this.experienceId;
      axios
        .get("/api/getRules?module_name=experiences&" + params)
        .then((response) => {
          this.rules = response.data.data;
        });
    },
    deleteRule(rule_id) {
     Vue.$confirm({
        title: 'Are you sure?',
        message: 'Are you sure you want to remove?',
        button: {
          yes: 'Yes',
          no: 'Cancel'
        },
        callback: confirm => {
          if (confirm) {
        axios
        .delete("/api/deleteRule/" + rule_id)
        .then((response) => {
         if (response.status == 200) {
            this.getRules();
          } 
         }).catch((err) => {
          this.$swal({
            type: "error",
            title: "Error!",
            text: err.response.message,
            timer: 2500,
          });
        });
            }
       
        }
      })
    },
    addRule() {
      let bodyFormData = new FormData();

      if (this.rule_value == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input rule",
          timer: 2500,
        });
        return;
      }

      bodyFormData.append("module_id", this.experienceId);
      bodyFormData.append("rule", this.rule_value);
      bodyFormData.append("module_name", "experiences");
      axios
        .post("/api/addRule", bodyFormData)
        .then((response) => {
          if (response.status == 200) {
            this.rule_value = "";
            this.getRules();
            this.$swal({
              type: "success",
              title: "Success!",
              text: response.data.message,
              timer: 2500,
            });
          }
        })
        .catch((err) => {
          this.$swal({
            type: "error",
            title: "Error!",
            text: err.response.data.message,
            timer: 2500,
          });
        });
    },
    updateCancPolicy(e) {
      e.preventDefault();
      if (this.cancellationPolicy === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input cancellation policy",
          timer: 2500,
        });
        return;
      } 
      let bodyFormData = new FormData();
      bodyFormData.append("experience_id", +this.experienceId);
      bodyFormData.append("cancellation_policy", this.cancellationPolicy);
      axios.post("/api/updateExperience", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.getExperience();
          $("#cancelhead").modal("hide");
          this.$swal({
            type: "success",
            title: "Success!",
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

    updateimpInfo(e) {
      e.preventDefault();
      if (this.importanInformation === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input important info",
          timer: 2500,
        });
        return;
      } 
      let bodyFormData = new FormData();
      bodyFormData.append("experience_id", +this.experienceId);
      bodyFormData.append("important_info", this.importanInformation);
      axios.post("/api/updateExperience", bodyFormData).then((response) => {
        if (response.status == 200) {
          $("#infohead").modal("hide");

          this.getExperience();
          this.$swal({
            type: "success",
            title: "Success!",
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
    updateTitleSection(e) {
      e.preventDefault();
      if (this.title == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter activity name.",
          timer: 2500,
        });
        return;
      }
      let bodyFormData = new FormData();
      bodyFormData.append("experience_id", +this.experienceId);
      bodyFormData.append("title", this.title);
     
      bodyFormData.append("language", this.language);

      axios.post("/api/updateExperience", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.getExperience();
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });

          $("#editdetails").modal("hide");
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

    updateAbout(e) {
      e.preventDefault();
      if (this.type == "") {
          this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter type name.",
          timer: 2500,
        });
        return;
      }
      let bodyFormData = new FormData();
      bodyFormData.append("experience_id", this.experienceId);
      bodyFormData.append("type", this.type);
      bodyFormData.append("about", this.about);
      axios.post("/api/updateExperience", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.getExperience();
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });

          $("#editFeatures").modal("hide");
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
    addSlot(e){
      
      e.preventDefault();
      if (this.date == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "please enter date",
          timer: 2500,
        });
        return;
      }
      if (this.start_time == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "please enter start time",
          timer: 2500,
        });
        return;
      }
      if (this.location == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select location.",
          timer: 2500,
        });
        return;
      }

     
      if (this.price == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "please enter price",
          timer: 2500,
        });
        return;
      }
     
      if (this.duration == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "please enter duration",
          timer: 2500,
        });
        return;
      }
       if (this.class_size == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "please enter class size",
          timer: 2500,
        });
        return;
      }
      let bodyFormData = new FormData();
      bodyFormData.append("experience_id", +this.experienceId);
      bodyFormData.append("location", this.location);
      bodyFormData.append("country", this.country);
      bodyFormData.append("city", this.city);
      bodyFormData.append("lat", this.lat);
      bodyFormData.append("lng", this.lng);
      bodyFormData.append("class_size", this.class_size);
      bodyFormData.append("price", this.price);
      bodyFormData.append("duration", this.duration);
      bodyFormData.append("date", this.date);
      bodyFormData.append("start_time", this.startTime);  
      axios.post("/api/addSlot", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.getSlots();
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });

          $("#editdetails").modal("hide");
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
    getSlots(){
     axios
        .get("/api/getSlots?experience_id=" + this.experienceId)
        .then((response) => {
          this.slots = response.data.data;
        }).catch((err) => {
            this.$swal({
            type: "error",
            title: "Error!",
            text: err.response.data.message,
            timer: 2500,
          });
        }); 
    },
     deleteData(slot_id) {

       Vue.$confirm({
        title: 'Are you sure?',
        message: 'Are you sure you want to remove?',
        button: {
          yes: 'Yes',
          no: 'Cancel'
        },
        callback: confirm => {
        if (confirm) {
        axios.delete("/api/deleteSlot/" + slot_id).then((response) => {
        if (response.status == 200) {
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });

          this.getSlots();
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
            }
       
        }
      })
    
},
  },
};
</script>

<style scoped>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td,
th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

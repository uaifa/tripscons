<template>
  <main>
    <div class="container">
      <div class="country-banners-sec">
        <div class="d-flex justify-content-start "> 
          <a href="#" type="button" class="btn-back my-3"> 
            <i class="fa fa-arrow-left mr-2"></i> Back</a>
        </div>
        <div class="row">
          <div class="col-12 col-sm-8">
            <div class="banner-imag-parent">
              <div class="main-image">
                <img    
                    v-if="mainImageShow"
                    :src="
                      $imagePath +
                      'transports/' +
                      transportDetail.main_image.name
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
                        <div class="col-12 col-sm-4" v-for="(image, index) in transportDetail.images"
                        :key="index">
                          <div class="image-edit-wrapper">
                            <img
                             :src="$imagePath + 'transports/' + image.name"
                             />
                            <div
                              class="d-flex justify-content-center editbuttons"
                            >
                              <button @click="deleteImage(image.id)"> Delete</button>
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
                        /><span class="button-span">Add More Images</span>
                      </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="center-imagess row mt-2" v-if="twoImageShow">
                <div class="col-12 col-md-4" v-for="(i, index) in transportDetail.two_images"
                  :key="index">
                  <img
                    :src="$imagePath + 'transports/' + i.name"
                    alt="img"
                  />
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
                          <label for="">Vehicle Title</label>
                          <input
                            type="text"
                            placeholder=" "
                            value=""
                            class="form-control input_field"
                            v-model="title"
                          />
                        </div>
                        <div class="form-group">
                          <label for="">Registration #</label>
                          <input
                            type="text"
                            placeholder=" "
                            value=""
                            class="form-control input_field"
                            v-model="registration_no"
                          />
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
                          <label for="">Vehicle Brand</label>
                          <input type="text" class="form-control input_field" v-model="brand"/>
                        </div>
                        <div class="form-group">
                          <label for="">Vehicle Model</label>
                          <select class="form-select form-control" v-model="model">
                            <option value="0">Select</option>
                           
                            <option v-for="(i,index) in years" :key="index">{{ i }}</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Engine Capacity</label>
                          <input type="number" class="form-control input_field" v-model="cc"/>
                        </div>

                        <div class="form-group">
                          <label for="">Rent/hour</label>
                          <input type="text" class="form-control input_field" v-model="hourly_price"/>
                        </div>
                        <div class="form-group">
                          <label for="">Rent/day</label>
                          <input type="text" class="form-control input_field" v-model="per_day_price"/>
                        </div>
                        <div class="form-group">
                          <label for="">Type</label>
                          <select class="form-select form-control" v-model="vechile_type">
                            <option selected>Select</option>
                            <option value="Car">Car</option>
                            <option value="Jeap">Jeap</option>
                            <option value="Bus">Bus</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Transmission</label>
                          <select class="form-select form-control" v-model="transmission">
                            <option selected>Select</option>
                            <option value="Auto">Auto</option>
                            <option value="Manual">Manual</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Assembling</label>
                          <select class="form-select form-control" v-model="assembly">
                            <option selected>Select</option>
                            <option value="Local">Local</option>
                            <option value="Imported">Imported</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Engine</label>
                          <select class="form-select form-control" v-model="engine">
                            <option >Select</option>
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="CNG">CNG</option>
                            <option value="LPG">LPG</option>
                            <option value="Hybrid">Hybrid</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Sitting Capacity</label>
                          <input
                            type="number"
                            class="form-control input_field"
                            v-model="no_of_people"
                          />
                        </div>

                        <div class="d-flex justify-content-center">
                          <button @click="updateTitleSection" class="btn btn-blackk">
                            Update
                          </button>
                        </div>
                    
                    </div>
                  </div>
                </div>
              </div>
              <div class="hotel-title-sec">
                <h1>{{title}}</h1>
              </div>
              <div class="mt-1 location hotel-location">
                <img src="/assets/img/Subtract.png" alt="" srcset="" />
                <span class="ml-2">{{location}} </span>
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
                
                <h3 class="align-self-center">
                  {{brand}} <span class="">{{model}}</span>
                </h3>
              </div>
              <div class="d-flex justify-content-between mt-0">
                <p class="vehicle-rent-hour dish-price">Rs.{{hourly_price}}/hr</p>
                <p class="vehicle-rent-day dish-price">Rs.{{per_day_price}}/day</p>
              </div>
              <div class="d-flex justify-content-between mt-0">
                <p class="engine-capacity">{{cc}} CC</p>
              </div>

              <div class="d-flex cbrudcrums mt-2">
                <ul>
                  <li>{{transmission}} |</li>
                  <li>{{assembly}} |</li>
                  <li>{{engine}}|</li>
                  <li><span> sitting capacity:</span> {{no_of_people}}</li>
                </ul>
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
                 
                      <div class="row mt-3">
                        <div class="col-12 col-md-4">
                          <label> airport pick and drop? </label>
                          <div class="d-flex">
                            <div class="form-check ml-4">
                              <input
                                class="form-check-input"
                                type="radio"
                                name="airport"
                                id="yess"
                                v-model="airport_pick_drop"
                                :value=1
                                @change="onChangeairport($event)" 
                              />
                              <label class="form-check-label"> Yes </label>
                            </div>
                            <div class="form-check ml-5">
                              <input
                                class="form-check-input"
                                type="radio"
                                name="airport"
                                id="noo"
                                v-model="airport_pick_drop"
                                :value=0
                                @change="onChangeairport($event)" 
                              />
                              <label class="form-check-label"> No </label>
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-12 col-md-8" v-show="airport_pick_drop">
                          <div class="form-group">
                            <label for="">Per Kilometer Charges</label>
                            <input
                              type="number"
                              class="form-control input_field" v-model="airport_pick_and_drop_charges"
                            />
                          </div>
                        </div>
                      </div>
                      <label
                        >Are you interested to offer your vehicle on self-drive?
                      </label>
                      <div class="d-flex">
                        <div class="form-check ml-4">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="selfdrive"
                            id="yess"
                            v-model="provide_self_drive"
                            :value=1
                          />
                          <label class="form-check-label"> Yes </label>
                        </div>
                        <div class="form-check ml-5">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="selfdrive"
                            id="noo"
                            v-model="provide_self_drive"
                            :value=0
                          />
                          <label class="form-check-label"> No </label>
                        </div>
                      </div>

                      <label>Vehicle insured? </label>
                      <div class="d-flex">
                        <div class="form-check ml-4">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="insured"
                            id="yess"
                            v-model="insured"
                            :value=1
                          />
                          <label class="form-check-label"> Yes </label>
                        </div>
                        <div class="form-check ml-5">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="insured"
                            id="noo"
                            v-model="insured"
                            :value=0
                          />
                          <label class="form-check-label"> No </label>
                        </div>
                      </div>
                      <div class="col-12 col-md-12 custom-colom" v-show="insured">
                          <div class="form-group">
                            <label for="">Expiry Date</label>
                            <input
                             type="date"
                              class="form-control input_field" v-model="insurance_expire_date"
                            />
                          </div>
                        </div>
                      <label class="form-check-label mb-2 pl-2"> Video URL</label>
                       <div class="col-12 custom-colom">
                          <div class="form-group">
                            
                            <input
                              type="text"
                              class="form-control input_field" v-model="video_url"
                            />
                          </div>
                        </div>
                      <h6>Tracker</h6>
                      <div class="d-flex">
                        <div class="form-check ml-4">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="tracker"
                            id="yes"
                            v-model="tracker"
                            :value=1
                          />
                          <label class="form-check-label"> Yes </label>
                        </div>
                        <div class="form-check ml-5">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="tracker"
                            id="no"
                             v-model="tracker"
                            :value=0
                          />
                          <label class="form-check-label"> No </label>
                        </div>
                      </div>

                      <div class="form-group">
                        <label>About Vehicle </label>
                        <textarea class="form-control" rows="5" v-model="description"></textarea>
                      </div>

                      <div class="d-flex justify-content-center">
                        <button @click="updatePickDrop" class="btn btn-blackk">
                          Update
                        </button>
                      </div>
                  
                  </div>
                </div>
              </div>
            </div>
           <vue-confirm-dialog></vue-confirm-dialog>
            <div class="media mb-4 mt-3">
              <img
                class="mr-3"
                src="/assets/img/icons/airplane.png"
                alt="Generic placeholder image"
              />
              <div class="media-body edit-parent">
                <h5 class="mt-0">pick & drop</h5>
                <div class="d-flex">
                  <p>
      
     
                    <strong>Airport pick & drop:</strong>
                    <span class="ml-1">{{ariport_pickDrop_title}}</span>
                  </p>
                  <p class="ml-2">
                    <strong>Charges:</strong> <span class="ml-1" v-show="airport_pick_drop">Rs{{airport_pick_and_drop_charges}}/km</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="media mb-4">
              <img
                class="mr-3"
                src="/assets/img/icons/steering-wheel.png"
                alt="Generic placeholder image"
              />
              <div class="media-body edit-parent">
                <h5 class="mt-0">Self Drive</h5>
                <div class="d-flex">
                  <p>{{provide_self_drive_title}}</p>
                </div>
              </div>
            </div>

            <div class="media mb-4">
              <img
                class="mr-3"
                src="/assets/img/icons/insurance.png"
                alt="Generic placeholder image"
              />
              <div class="media-body">
                <h5 class="mt-0">Safety & Security</h5>
                <div class="d-flex">
                  <p>
                    <strong> vehicle insured?:</strong>
                    <span class="ml-1">{{insured_title}}</span>
                  </p>
                </div>
                <label v-show="insured">{{insurance_expire_date}}</label>
              </div>
            </div>

            <div class="media mb-4">
              <img
                class="mr-3"
                src="/assets/img/icons/tracking.png"
                alt="Generic placeholder image"
              />
              <div class="media-body">
                <h5 class="mt-0">Tracker</h5>
                <p>{{tracker_title}}</p>
              </div>
            </div>
            <div class="about-txt edit-parent">
              <h2>About Vehicle</h2>
              <p>
               {{description}}
              </p>
            </div>
             <!-- <div class="embed-responsive embed-responsive-16by9">
            <iframe
              class="embed-responsive-item"
              :src="video_url"
              
              allowfullscreen
            ></iframe>
          </div> -->
          
          </div>
          <div class="home-services mt-4">
            <h2>Accessories & features</h2>
             <ul>
              <li  v-for="(i, index) in splitedList" :key="index">
                <img
                  :src="'/assets/icons/' + i.image"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  class="mr-2"
                />
                {{ i.name }}
                
              </li>
            </ul>
            <!--Modal-->
            <div
              class="modal fade"
              id="business-modal"
              data-bs-backdrop="static"
              data-bs-keyboard="false"
              tabindex="-1"
              aria-labelledby="business-modalLabel"
              aria-hidden="true"
            >
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <button
                      type="button"
                      class="close"
                      data-dismiss="modal"
                      aria-label="Close"
                    >
                      <span aria-hidden="true">×</span>
                    </button>
                  <div class="py-3 mt-4 mb-5 facilities-container">
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
                        v-model="checkedFacilities"
                        />
                    
                      <img
                        :src="'/assets/icons/' + genData.image"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                      />
                      <p class="activity-name">
                        {{ genData.name }}
                      </p>
                    </label>
                 </div>

                    
                  </div>
                  <div class="d-flex justify-content-center my-3">
                      <button class="btn btn-whitee"  @click="addTransportAccessories">Add features</button>
                    </div>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-start mt-2">
              <button
                class="btn btn-whitee"
                data-toggle="modal"
                data-target="#business-modal"
              >
                Add more
              </button>
            </div>
            <video-embed :params="{autoplay: 1}" :src="video_url"></video-embed>
          </div>
        </div>
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
                        
                        <input type="text" class="form-control" v-model="rule_value" @keyup.enter="addRule"/>
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
import $ from "jquery";
export default {
  name: "transportDetail",

  data() {
    return {
      transportId: this.$route.params.transportId,
      transportDetail: "",
      normalImage: null,
      normalImagePreview: null,
      normalShowPreview: false,
      mainImageShow:false,
      twoImageShow:false,
      rules: [],
      rule_value: "",
      title: "",
      description:"",
      location: "",
      vechile_type:"Car",
      no_of_people:"",
      per_day_price:"",
      hourly_price:"",
      transmission: "",
      assembly: "",
      engine: "Petrol",
      provide_self_drive: 0,
      insured: 0,
      tracker: 0,
      registration_no:"",
      cc: "",
      video_url: "",
      insurance_expire_date: "",
      model: "",
      importanInformation: "",
      cancellationPolicy: "",
      country: "",
      city: "",
      lat: "",
      lng: "",
      brand:"",
      loaded:false,
      airport_pick_and_drop_charges:'',
      airport_pick_drop:0,
      checkedFacilities: [],
      generalobjects: {},
      ariport_pickDrop_title:"",
      insured_title:"",
      tracker_title:"",
      provide_self_drive_title:"",
      
    };
  },
  created() {
    this.getRules();
    this.facilities();
    
   },
   computed:{
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
    years () {
      const year = new Date().getFullYear()
      return Array.from({length: year - 1900}, (value, index) => 1901 + index)
    }
   },
   async beforeMount(){
   
    this.transportGet();
 
   },
 
  components: {
    VueTimepicker,
    VueGoogleAutocomplete,
  },
  methods: {
  
   transportGet() {
    
      axios
        .get("/api/vechileDetail/" + this.transportId)
        .then((response) => {
          if (response.status == 200) {
          
          this.transportDetail = response.data.data;
          if(this.transportDetail.two_images !=null && this.transportDetail.two_images != ""){
            this.twoImageShow = true;
           
          }else{
            this.transportDetail.two_images='';
            this.twoImageShow = false;
          }
          if(this.transportDetail.main_image !=null){
             this.mainImageShow = true;
            
          }else{
            this.transportDetail.main_image='';
            this.mainImageShow = false;
          }
          
          this.title = this.transportDetail.title;
          this.description = this.transportDetail.description;
          
          if(this.description == 'null'){
           this.description = '';
          }
          
          this.location = this.transportDetail.location;
          this.per_day_price =this.transportDetail.per_day_price;
          this.hourly_price = this.transportDetail.hourly_price;
          
          this.transmission = this.transportDetail.transmission;
          this.assembly = this.transportDetail.assembly;
        
          this.engine = this.transportDetail.engine;
          this.provide_self_drive =this.transportDetail.provide_self_drive;
          if(this.provide_self_drive == 0){
            this.provide_self_drive_title = 'No';
          }else{
            this.provide_self_drive_title = 'Yes';
          }
         
          
          this.registration_no = this.transportDetail.registration_no;
          this.cc = this.transportDetail.cc;
          
          this.video_url = this.transportDetail.video_url;
          this.brand = this.transportDetail.brand;
          this.airport_pick_drop = this.transportDetail.airport_pick_drop;
          if(this.airport_pick_drop == 0){
          this.ariport_pickDrop_title = 'No';
          }else{
             this.ariport_pickDrop_title = 'Yes';
             this.airport_pick_and_drop_charges = this.transportDetail.airport_pick_and_drop_charges;
          }
         
          this.insured = this.transportDetail.insured;
          if(this.insured == 0){
            this.insured_title = 'No';
          }else{
              this.insured_title = 'Yes';
             // alert(this.transportDetail.insurance_expire_date);
              this.insurance_expire_date = this.transportDetail.insurance_expire_date;
          }
          this.tracker = this.transportDetail.tracker;
          if(this.tracker == 0){
            this.tracker_title = 'No';
          }else{
              this.tracker_title = 'Yes';
          }
         
          
          this.no_of_people = this.transportDetail.no_of_people;
          
          this.model = this.transportDetail.model;
        
          this.cancellationPolicy =
            this.transportDetail.cancellation_policy;
          if (
            this.cancellationPolicy == null ||
            this.cancellationPolicy == ""
          ) {
            this.cancellationPolicy = "";
          }
          this.importanInformation =
            this.transportDetail.important_info;
          if (
            this.importanInformation == null ||
            this.importanInformation == ""
          ) {
            this.importanInformation = "";
          }
           this.loaded= true;
           }
        }).catch((err) => {
           this.$router.push({ path: "/notfound" });
        });
    },
     custom_tags (obj) {
    if(obj.fieldName =="Ingrediants") {
    this.ingrediants = obj.x; 
    }else{
     this.Specialities = obj.x;
    }   
   
    },   
     onChangeairport(event) {
      
        if (event.target.value == 1) {
        this.airport_pick_drop = 1;
        
      } else {
        
     this.airport_pick_drop = 0;
      }
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
      bodyFormData.append("module", "transports");
      bodyFormData.append("module_id", this.transportId);
      axios.post("/api/uploadImages", bodyFormData).then((response) => {
        if (response.status == 200) {
          $('#normalImage').val('');
          this.transportGet();
         
        } else {
          this.$swal({
            type: "error",
            title: "Error!",
            text: response.data.message,
            timer: 2500,
          });
        }
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
            this.transportGet();
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
    
    getAddressData: function (addressData, placeResultData, id) {
      this.country = addressData.country;
      this.city = addressData.locality;
      this.latitude = addressData.latitude;
      this.longitude = addressData.longitude;
      this.location = placeResultData.formatted_address;
    },
   getRules() {
      
      const params = "module_id="+this.transportId;
      axios.get("/api/getRules?module_name=transports&"+params).then((response) => {
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
            text: err.response.data.message,
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

      bodyFormData.append("module_id", this.transportId);
      bodyFormData.append("rule", this.rule_value);
      bodyFormData.append("module_name", "transports");
      axios
        .post("/api/addRule", bodyFormData)
        .then((response) => {
          if (response.status == 200) {
            this.rule_value = "";
            this.getRules();
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
          text: "Please input Cancellation Policy",
          timer: 2500,
        });
        return;
      } 
      let bodyFormData = new FormData();
      bodyFormData.append("transport_id", +this.transportId);
      bodyFormData.append("cancellation_policy", this.cancellationPolicy);
      axios.post("/api/updateTransport", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.transportGet();
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
    facilities() {
    
      axios
        .get("/api/getTransportFeature/"+this.transportId)
        .then((response) => {
          this.generalobjects = response.data.data;
          this.generalobjects.forEach((item) => {
            if (item.ischeck == 1) {
              this.checkedFacilities.push(item.name + "|" + item.image);
            }
          });
        });
    },
     addTransportAccessories() {
      
      let bodyFormData = new FormData();
      bodyFormData.append("checkedAccessories", this.checkedFacilities);
      bodyFormData.append("transport_id", this.transportId);

      axios
        .post("/api/addTransportAccessories", bodyFormData)
        .then((response) => {
          if (response.status == 200) {
            this.$swal({
              type: "success",
              title: "Success!",
              text: response.data.message,
              timer: 2500,
            });
           // this.facilities();
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
      bodyFormData.append("transport_id", +this.transportId);
      bodyFormData.append("important_info", this.importanInformation);
      axios.post("/api/updateTransport", bodyFormData).then((response) => {
        if (response.status == 200) {
          $("#infohead").modal("hide");

          this.mealGet();
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
          text: "Please input rule",
          timer: 2500,
        });
        return;
      }
      if (this.registration_no == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input valid registration number",
          timer: 2500,
        });
        return;
      }
      if (this.location == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input location",
          timer: 2500,
        });
        return;
      }
       if (this.brand == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input brand",
          timer: 2500,
        });
        return;
      }
    
       if (this.model == 0) {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select model",
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
      if (this.per_day_price === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please  enter per day price",
          timer: 2500,
        });
        return;
      }
       if (this.hourly_price === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter per hour price",
          timer: 2500,
        });
        return;
      }
      if (this.transmission == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter transmission",
          timer: 2500,
        });
        return;
      }
      if (this.assembly == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter assembly",
          timer: 2500,
        });
        return;
      }
       if (this.no_of_people == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter no of guest",
          timer: 2500,
        });
        return;
      }
      if (this.engine == "Select") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select engine",
          timer: 2500,
        });
        return;
      }
      
      let bodyFormData = new FormData();
      bodyFormData.append("transport_id", +this.transportId);
      bodyFormData.append("title", this.title);
      bodyFormData.append("vechile_type", this.vechile_type);
      bodyFormData.append("location", this.location);
      bodyFormData.append("registration_no", this.registration_no);
      bodyFormData.append("brand", this.brand);
      bodyFormData.append("country", this.country);
      bodyFormData.append("city", this.city);
      bodyFormData.append("lat", this.lat);
      bodyFormData.append("lng", this.lng);
      bodyFormData.append("model", this.model);
      bodyFormData.append("cc", this.cc);
      bodyFormData.append("per_day_price", this.per_day_price);
      bodyFormData.append("hourly_price", this.hourly_price);
      bodyFormData.append("transmission", this.transmission);
      bodyFormData.append("assembly", this.assembly);
      
      bodyFormData.append("engine", this.engine);
      bodyFormData.append("no_of_people", this.no_of_people);
      axios.post("/api/updateTransport", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.transportGet();
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
      
          $("#editdetails").modal("hide");
        }
      });
    },
    updatePickDrop(e) {
    
      e.preventDefault();
      let bodyFormData = new FormData();
      bodyFormData.append("transport_id", this.transportId);
      bodyFormData.append("airport_pick_drop", this.airport_pick_drop);
      bodyFormData.append("airport_pick_and_drop_charges", this.airport_pick_and_drop_charges);
      bodyFormData.append("provide_self_drive", this.provide_self_drive);
      bodyFormData.append("insured", this.insured);
     
      if(this.insured != 0){
      //  alert(this.insurance_expire_date);
      if(this.insurance_expire_date == null || this.insurance_expire_date == ''){
      this.$swal({
              type: "error",
              title: "Error!",
              text: "Please Add Valid Expiry Date",
              timer: 2500,
            }); 
            return 
      }else{
         bodyFormData.append("insurance_expire_date", this.insurance_expire_date); 
      }
     }
      bodyFormData.append("video_url", this.video_url);
      bodyFormData.append("tracker", this.tracker);
      bodyFormData.append("description", this.description);
      axios.post("/api/updateTransport", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.transportGet();
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
         
          $("#editFeatures").modal("hide");
        }
      });
    },
  },
};
</script>

<style scoped>
</style>

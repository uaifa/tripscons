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
                      'meals/' +
                      mealDetail.main_image.name
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
                        <div class="col-12 col-sm-4" v-for="(image, index) in mealDetail.images"
                        :key="index">
                          <div class="image-edit-wrapper">
                            <img
                             :src="$imagePath + 'meals/' + image.name"
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
                        /><span class="button-span">
                        Add More Images
                        </span>
                      </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="center-imagess row mt-2" v-if="twoImageShow">
                <div class="col-12 col-md-4" v-for="(i, index) in mealDetail.two_images"
                  :key="index">
                  <img
                    :src="$imagePath + 'meals/' + i.name"
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
                          <label for="">Dish Title</label>
                          <input
                            type="text"
                            placeholder=" "
                            value=""
                            class="form-control input_field"
                            v-model="title"
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
                          <label for="">Price</label>
                          <input type="number" class="form-control input_field" v-model="price"/>
                        </div>
                        <div class="form-group">
                          <label for="">Dish Quantity</label>
                          <select class="form-select form-control" v-model="dishQuantity">
                            <option selected>Select</option>
                            <option value="per Kg">per Kg</option>
                            <option value="Whole">Whole Item</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Serving</label>
                          <input
                            type="number"
                            class="form-control input_field"
                            v-model="serving"
                          />
                        </div>

                        <div class="form-group"  >
                          <label for="">Specialities</label>
                          <div v-if="loaded">
                            <asset-tags :fieldName="'Specialities'" :selectedTags="Specialities" @custom_tags="custom_tags($event)" ></asset-tags></div>
                        </div>
                        <div class="d-flex justify-content-center">
                           <button
                          class="btn btn-blackk"
                          @click="updateTitleSection"
                        >
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
<!--                
                <h3 class="align-self-center">{{brand}}</h3> -->
              </div>
              <div class="d-flex justify-content-between mt-0">
                <p class="dish-price">Rs.{{price}}({{dishQuantity}})</p>
                <p class="serving-title">{{serving}} Persons serving</p>
              </div>

              <div class="d-flex cbrudcrums mt-2">
                <ul v-if="Specialities !=''">
                  <li v-for="(i,index) in Specialities" :key="index">{{i}}</li>
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
                    <form>
                      <div class="form-group">
                        <label>Opening time</label>
                         <vue-timepicker
                          v-model="openingTime"
                          class=""
                        ></vue-timepicker>
                      </div>
                      <div class="form-group">
                        <label>Closing Time</label>
                        <vue-timepicker
                          v-model="closingTime"
                          class="custom-date"
                        ></vue-timepicker>
                       
                      </div>

                      <div class="form-group">
                        <label for="">Delivery Time (Minutes)</label>
                        <input placeholder="Time In Minutes" type="number" class="form-control input_field" v-model="deliveryTime"/>
                      </div>

                      <h4>Discounts</h4>
                      <div class="d-flex">
                        <div class="form-check ml-4">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="discount"
                            id="yess"
                            :value=true
                            v-model="isDiscount"
                          />
                          <label class="form-check-label"> Yes </label>
                        </div>
                        <div class="form-check ml-5">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="discount"
                            id="noo"
                            :value=false
                             v-model="isDiscount"
                          />
                          <label class="form-check-label"> No </label>
                        </div>
                      </div>
                      <div class="form-group" v-show="isDiscount">
                        <label>Discoun(%)</label>
                        <input
                          type="number" v-model="Discount"
                          placeholder=" "
                          class="form-control input_field"
                        />
                      </div>

                      <h4>Delivery Charges</h4>
                      <div class="d-flex">
                        <div class="form-check ml-4">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="breakfat"
                            id="yes"
                            
                            :value=1
                              v-model="isDeliveryCharges"
                              @change="onChangeDeliveryCharges($event)" 
                          />
                          <label class="form-check-label"> Yes </label>
                        </div>
                        <div class="form-check ml-5">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="breakfat"
                            id="no"
                             :value=0
                             v-model="isDeliveryCharges"
                             @change="onChangeDeliveryCharges($event)" 
                          />
                          <label class="form-check-label"> No </label>
                        </div>
                      </div>
                      <div class="row" v-show="isDeliveryCharges">
                        <div class="col-12 col-sm-6">
                          <div class="form-group">
                            <label for="">Free Delivery under Km</label>
                            <input
                              type="number" v-model="deliveryUnderKm"
                              class="form-control input_field"
                            />
                          </div>
                        </div>
                        <div class="col-12 col-sm-6">
                          <div class="form-group">
                            <label for="">Delivery Charges</label>
                            <input
                              type="number" v-model="deliveryCharges"
                              class="form-control input_field"
                            />
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Food preparation</label>
                        <input v-model="foodPreparation"
                          type="text"
                          placeholder=" "
                          class="form-control input_field"
                        />
                      </div>
                      <div class="form-group">
                        <label>About Meal </label>
                        <textarea v-model="about"
                          name=""
                          class="form-control"
                          rows="5"
                        ></textarea>
                      </div>

                      <div class="d-flex justify-content-center">
                        <button
                          class="btn btn-blackk"
                          @click="updatePriceSection"
                        >
                          Update
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="media mb-4 mt-3">
              <img
                class="mr-3"
                src="/assets/img/icons/time.png"
                alt="Generic placeholder image"
              />
              <div class="media-body edit-parent">
                <h5 class="mt-0">Hours</h5>
                <div class="d-flex">
                  <p>
                    <strong>Opening time:</strong>
                    <span class="ml-1">{{openingTime}}</span>
                  </p>
                  <p class="ml-2">
                    <strong>Closing time:</strong>
                    <span class="ml-1">{{closingTime}}</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="media mb-4 mt-3">
              <img
                class="mr-3"
                src="/assets/img/icons/shipped.png"
                alt="Generic placeholder image"
              />
              <div class="media-body edit-parent">
                <h5 class="mt-0">Delivery Time</h5>
                <div class="d-flex">
                  <p>
                    <strong>delivery:</strong>
                    <span class="ml-1">{{deliveryTime}} minutes </span>
                  </p>
                </div>
              </div>
            </div>
            <div class="media mb-4">
              <img
                class="mr-3"
                src="/assets/img/icons/feat.png"
                alt="Generic placeholder image"
              />
              <div class="media-body edit-parent">
                <h5 class="mt-0">Discounts</h5>
                <div class="d-flex">
                  <p><strong>discount:</strong> <span class="ml-1">{{Discount}}%</span></p>
                </div>
              </div>
            </div>

            <div class="media mb-4">
              <img
                class="mr-3"
                src="/assets/img/icons/fast-delivery.png"
                alt="Generic placeholder image"
              />
              <div class="media-body" v-if="isDeliveryCharges == 0">
               <p>Free delivery  </p>
              </div>
               <div class="media-body" v-show="isDeliveryCharges">
                <h5 class="mt-0">Delivery charges ({{deliveryCharges}})</h5>
                <p>Free delivery within {{deliveryUnderKm}} km</p>
              </div>
            </div>

            <div class="media mb-4">
              <img
                class="mr-3"
                src="/assets/img/icons/cooking.png"
                alt="Generic placeholder image"
              />
              <div class="media-body">
                <h5 class="mt-0">Food preparation</h5>
                <p> {{foodPreparation}}</p>
              </div>
            </div>
            <div class="about-txt edit-parent">
              <h2>About Meal</h2>
              <p>
               {{about}}
              </p>
            </div>

            <!--Ingredients-->
            <div class="ingrediens">
              <i
                class="fa fa-pencil"
                data-toggle="modal"
                data-target="#ingredients"
              ></i>
              <!-- Modal -->
              <div
                class="modal fade"
                id="ingredients"
                tabindex="-1"
                role="dialog"
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
                          <label for="">Ingredients</label>
                         <div v-if="loaded">
                        <asset-tags :fieldName="'Ingrediants'" :selectedTags="ingrediants" @custom_tags="custom_tags($event)"></asset-tags>
                        </div>
                        </div>
                        <div class="d-flex justify-content-center">
                         <button
                          class="btn btn-blackk"
                          @click="updateIngrediants"
                        >
                          Update
                        </button>
                        </div>
                     
                    </div>
                  </div>
                </div>
              </div>
              <h5>Ingredients</h5>
              <ul v-if="ingrediants !=''">
                <li v-for="(i,index) in ingrediants" :key="index">{{i}}</li>
                
              </ul>
            </div>
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
                <vue-confirm-dialog></vue-confirm-dialog>
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
  name: "MealDetail",

  data() {
    return {
      mealId: this.$route.params.mealId,
      mealDetail: "",
      normalImage: null,
      normalImagePreview: null,
      normalShowPreview: false,
      rules: [],
      rule_value: "",
      title: "",
      mealType:"",
      location: "",
      price:"",
      dishQuantity:"per Kg",
      serving:"",
      Specialities:"",
      openingTime: "09:00:00",
      closingTime: "6:00:00",
      deliveryTime: "",
      isDiscount: false,
      Discount: "",
      isDeliveryCharges: 0,
      isDeliveryShow:false,
      deliveryUnderKm: "",
      deliveryCharges: "",
      foodPreparation: "",
      about: "",
      ingrediants:"",
      importanInformation: "",
      cancellationPolicy: "",
      loaded:false,
      country: "",
      city: "",
      lat: "",
      lng: "",
      mainImageShow:false,
      twoImageShow:false,
      
    };
  },
  created() {
    this.getRules();
    
   },
   async beforeMount(){
   
    this.mealGet();
 
   },
 
  components: {
    VueTimepicker,
    VueGoogleAutocomplete,
  },
  methods: {
   mealGet() {
     
      axios
        .get("/api/mealDetail/" + this.mealId)
        .then((response) => {
          this.mealDetail = response.data.data;
          this.title = this.mealDetail.title;
          if(this.mealDetail.two_images !=null && this.mealDetail.two_images != ""){
            this.twoImageShow = true;
           
          }else{
            this.mealDetail.two_images='';
            this.twoImageShow = false;
          }
          if(this.mealDetail.main_image !=null){
             this.mainImageShow = true;
            
          }else{
            this.mealDetail.main_image='';
            this.mainImageShow = false;
          }
          
          this.mealType =
            this.mealDetail.meal_type;
          this.location =
            this.mealDetail.location;
          this.price =
            this.mealDetail.price;
         
          this.dishQuantity = this.mealDetail.unit;
          
          this.serving = this.mealDetail.persons;
          
         this.Specialities =  this.mealDetail.specialities;
          if (
            this.Specialities == null ||
            this.Specialities == ""
          ) {
            this.Specialities = '';
          }else{
            this.Specialities =  JSON.parse(this.mealDetail.specialities); 
          }
          this.openingTime = this.mealDetail.opening_time;
          this.closingTime = this.mealDetail.closing_time;
          this.deliveryTime =
            this.mealDetail.delivery_time;
          this.Discount = this.mealDetail.discount;
        
          if (this.Discount == 0) {
            this.isDiscount = false;
          }else{
            this.isDiscount = true;
          }
          this.isDeliveryCharges = this.mealDetail.free_delivery;
          if (this.isDeliveryCharges == 0) {
            this.isDeliveryCharges = 0;
            this.isDeliveryShow =false;
          }else{
            this.isDeliveryShow =true;
          }
          this.deliveryUnderKm =
            this.mealDetail.free_delivery_value;
          this.deliveryCharges =
              this.mealDetail.delivery_charges;
          
          this.foodPreparation = this.mealDetail.food_preparation;
          this.about = this.mealDetail.description;
          if(this.about == 'null'){
          this.about ='';
         }
          
           this.per_night = this.mealDetail.per_night;
          this.isBreakFast = this.mealDetail.breakfast_included;
       
          this.ingrediants =  this.mealDetail.ingredients;
          if (
            this.ingrediants == null ||
            this.ingrediants == ""
          ) {
            
            this.ingrediants = '';
          }else{
            this.ingrediants = JSON.parse(this.mealDetail.ingredients);
          }
          
          this.cancellationPolicy =
            this.mealDetail.cancellation_policy;
          if (
            this.cancellationPolicy == null ||
            this.cancellationPolicy == ""
          ) {
            this.cancellationPolicy = "";
          }
          this.importanInformation =
            this.mealDetail.important_info;
          if (
            this.importanInformation == null ||
            this.importanInformation == ""
          ) {
            this.importanInformation = "";
          }
           this.loaded= true;
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
     onChangeDeliveryCharges(event) {
      
        if (event.target.value == 1) {
        this.isDeliveryShow = true;
        
      } else {
        
     this.isDeliveryShow = false;
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
      bodyFormData.append("module", "meals");
      bodyFormData.append("module_id", this.mealId);
      axios.post("/api/uploadImages", bodyFormData).then((response) => {
        if (response.status == 200) {
          $('#normalImage').val('');
          this.mealGet();
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
            this.mealGet();
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
      this.lat = addressData.latitude;
      this.lng = addressData.longitude;
      this.location = placeResultData.formatted_address;
    },
    getRules() {
      
      const params = "module_id="+this.mealId;
      axios.get("/api/getRules?module_name=meals&"+params).then((response) => {
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

      bodyFormData.append("module_id", this.mealId);
      bodyFormData.append("rule", this.rule_value);
      bodyFormData.append("module_name", "meals");
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
          text: "Please input cancellation policy",
          timer: 2500,
        });
        return;
      } 
      let bodyFormData = new FormData();
      bodyFormData.append("meal_id", +this.mealId);
      bodyFormData.append("cancellation_policy", this.cancellationPolicy);
      axios.post("/api/updateMeal", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.mealGet();
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
     updateIngrediants(e) {
      e.preventDefault();
      if (this.ingrediants == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter ingrediants",
          timer: 2500,
        });
        return;
      }
      
      let bodyFormData = new FormData();
      bodyFormData.append("meal_id", +this.mealId);
      bodyFormData.append("ingredients", JSON.stringify(this.ingrediants));
      axios.post("/api/updateMeal", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.mealGet();
          $("#ingredients").modal("hide");
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
      bodyFormData.append("meal_id", +this.mealId);
      bodyFormData.append("important_info", this.importanInformation);
      axios.post("/api/updateMeal", bodyFormData).then((response) => {
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
      if (this.title === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter title",
          timer: 2500,
        });
        return;
      }
       if (this.location == "" || this.location == 'null') {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter location",
          timer: 2500,
        });
        return;
      }
      if (this.price < 0) {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter valid price,price can't be negative",
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
          text: "Please enter valid price,price should be greater than zero",
          timer: 2500,
        });
        return;
      }
     
  
     if (this.dishQuantity == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select unit",
          timer: 2500,
        });
        return;
      } 
       if (this.serving == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter serving",
          timer: 2500,
        });
        return;
      } 
      
      let bodyFormData = new FormData();
      bodyFormData.append("meal_id", +this.mealId);
      bodyFormData.append("title", this.title);
      bodyFormData.append("price", this.price);
      bodyFormData.append("meal_type", this.mealType);
      bodyFormData.append("location", this.location);
      bodyFormData.append("unit", this.dishQuantity);
      bodyFormData.append("persons", this.serving);
      bodyFormData.append("country", this.country);
      bodyFormData.append("city", this.city);
      bodyFormData.append("lat", this.lat);
      bodyFormData.append("lng", this.lng);
      bodyFormData.append("specialities", JSON.stringify(this.Specialities));
      axios.post("/api/updateMeal", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.mealGet();
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
          this.mealGet();
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
    updatePriceSection(e) {

      e.preventDefault();
     if (this.openingTime == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select opening Time",
          timer: 2500,
        });
        return;
      } 
      if (this.closingTime == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select closing time",
          timer: 2500,
        });
        return;
      }
    
      var timeStart = new Date("01/01/2007 " + this.openingTime).getHours();
      var timeEnd = new Date("01/01/2007 " + this.closingTime).getHours();
  
     if(timeEnd <= timeStart){
      this.$swal({
          type: "error",
          title: "Error!",
          text: "Closing time should be greater than opening time ",
          timer: 2500,
        });
        return;
     }
      if (this.deliveryTime === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter delivery time",
          timer: 2500,
        });
        return;
      }
      if (this.foodPreparation == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter food preparation time",
          timer: 2500,
        });    
        return;
      }
      let bodyFormData = new FormData();
      bodyFormData.append("meal_id", this.mealId);
      
      bodyFormData.append("opening_time", this.openingTime);
      bodyFormData.append("closing_time", this.closingTime);
      bodyFormData.append("delivery_time", this.deliveryTime);
      bodyFormData.append("discount", this.Discount);
      bodyFormData.append("free_delivery", this.isDeliveryCharges);
      bodyFormData.append("free_delivery_value", this.deliveryUnderKm);
      bodyFormData.append("delivery_charges", this.deliveryCharges);
      bodyFormData.append("food_preparation",this.foodPreparation);
      bodyFormData.append("description", this.about);
      axios.post("/api/updateMeal", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.mealGet();
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
        });;
    },
  },
};
</script>

<style scoped>
</style>

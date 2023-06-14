<template>
    <main>
      <div class="container">
        <div class="country-banners-sec">
          <div class="row">
            <div class="col-12 col-sm-8">
                
              <div class="banner-imag-parent">
                <div class="main-image">
                  
                    <template v-if="generalData && generalData.images && (generalData.images).length > 0" v-for="images in generalData.images">
                        <img v-if="images.type == 'main' " :src="`${$imagePath}guides/${images.name}`" />
                    </template>
                  <template v-if="generalData || generalData.length < 1 ">
                    
                  <img v-if="!(generalData.images) || (generalData.images).length < 1" src="/assets/uploads/users/img1.jpg" alt="img" />
                  </template>
                  <button v-if="((generalData.images) && (generalData.images).length > 0) || generalData.user_id == user_id" class="editimages" data-toggle="modal" data-target="#editdimages">
                    <span v-if="generalData.user_id == user_id">
                      Edit images
                    </span>
                    <span v-else>
                      View Images
                    </span>
                  </button>
                </div>
                <!-- Modal -->
                <div class="modal fade editdetailss" id="editdimages" tabindex="-1" role="dialog"
                  aria-labelledby="editdimages" aria-hidden="true">
                  <div class="modal-dialog  modal-lg modal-dialog-centered modal-dialog-zoom" role="document">
                    <div class="modal-content">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                      <div class="modal-body p-4">
                        <div class="row">
                            
                          <div v-if="generalData && generalData.images" v-for="(image, index) in generalData.images" :key="index"  class="col-12 col-sm-4">
                            <div class="image-edit-wrapper">
                              <img :src="`${$imagePath}guides/${image.name}`">
                              <div  v-if="generalData.user_id == user_id" class="d-flex justify-content-center editbuttons">
                                <button @click="deleteImage(image.id)">
                                Delete
                              </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                          <button v-if="generalData.user_id == user_id" class=" mt-3 btn btn-blackk">
                          <input
                            class="button-input"
                            type="file"
                            name="normalImage"
                            id="normalImage"
                            @change="normalOnFileChange"
                          />
                            <span class="button-span">
                              Add More Images
                            </span>
                        </button>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
                <div class="center-images mt-2">
                    <template v-if="generalData && generalData.images && (generalData.images).length > 0" v-for="(images, image_index) in generalData.images">
                        <img v-if="images.type !== 'main' && image_index <= 3" :src="`${$imagePath}/guides/${images.name}`" />
                    </template>
                      <!-- asdfasdfasdf asdfasd f {{ generalData.images }} -->
                  <template v-if="generalData && (generalData.images).length < 1"> 
                    <img src="/assets/uploads/users/img1.jpg" alt="img" />
                    <img src="/assets/uploads/users/img1.jpg" alt="img" />
                    <img src="/assets/uploads/users/img1.jpg" alt="img" />
                  </template>
                </div>
              </div>
              <div class="home-details home-details-edit">
                <i v-if="generalData.user_id == user_id" class="fa fa-pencil" data-toggle="modal" data-target="#editFeatures"></i>
                <!-- Modal -->
                <div v-if="generalData.user_id == user_id" class="modal fade" id="editFeatures" tabindex="-1" role="dialog" aria-labelledby="editFeatures"
                  aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom" role="document">
                    <div class="modal-content">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                      <div class="modal-body  p-4">
                        <!-- <form> -->
                          <div class="form-group">
                            <label>Languages</label>
                            <input type="text" placeholder=" " v-model="formDatas.languages" value="" class="form-control input_field">
                          </div>
                          <div class="form-group">
                            <label>Skills</label>
                            <input type="text" placeholder=" " v-model="formDatas.skills" value="" class="form-control input_field">
                          </div>
                       
                          <div class="form-group">
                            <label>About</label>
                            <textarea class="form-control" v-model="formDatas.about" rows="5"></textarea>
                          </div>
                          <div class="d-flex justify-content-center">
                            <button  class="btn btn-blackk" @click="updateLanguageSection">Update</button>
                          </div>
  
  
                        <!-- </form> -->
                      </div>
  
                    </div>
                  </div>
                </div>
                <div class="media mb-4 mt-3">
                  <img class="mr-3" src="/assets/img/icons/language.png" alt="Generic placeholder image">
                  <div class="media-body edit-parent">
                    <h5 class="mt-0">Languages</h5>
                    <p>{{ generalData.languages || 'English,Urdu,Chinese' }}</p>
                    <p> </p>
                  </div>
                </div>
                <div class="media mb-4 mt-3">
                  <img class="mr-3" src="/assets/img/icons/skills.png" alt="Generic placeholder image">
                  <div class="media-body edit-parent">
                    <h5 class="mt-0">Skills</h5>
                    <p>{{ generalData.skills || 'Energetic,Resourcefull,Planner,Passionate,Story Teller' }}</p>
                  </div>
                </div>
                
              
               
  
  
                <div class="about-txt edit-parent">
                  <h2>About</h2>
                  <p>{{ generalData.about || 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.' }}</p>
                </div>
              </div>
           
            </div>
            <div  class="col-12 edit-parent col-sm-4">
              <div class="home-details-edits">
                <i v-if="generalData.user_id == user_id" class="fa fa-pencil" data-toggle="modal" data-target="#editdetails"></i>

                <!-- Modal -->
                <div v-if="generalData.user_id == user_id" class="modal fade" id="editdetails" tabindex="-1" role="dialog" aria-labelledby="editdetails"
                  aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom" role="document">
                    <div class="modal-content">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                      <div class="modal-body p-4">
                        <!-- <form  id="updateTitle"> -->
                          <input type="hidden" name="guide_id" id="guide_id" :value="Id">
                          <div class="form-group">
                            <label for="">Tag line</label>
                            <input type="text" placeholder=" " name="title" ref="title"  v-model="formDatas.title" class="form-control input_field" required>

                          </div>
                          <div class="form-group">
                            <label for="">Location  </label> 
                            <div class="row" style="margin-top: 15px">
                              <div class="input-field" style="width: 96%; margin: 0 auto;">
                                <vue-google-autocomplete
                                v-model="generalData.location"
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

                            <!-- <input type="text" placeholder=" " name="location" v-model="formDatas.location" class="form-control input_field" required> -->
                          </div>
                          <h5 class="mt-2">Do you offer free package services?  </h5>
                        <div class="d-flex  ">
                          <div class="form-check ml-4">
                            <input :checked="generalData.is_free_guide == 1 ? 'true' : 'false'" class="form-check-input" v-model="formDatas.is_free_guide" type="radio" name="discount" id="yess" value="1">
                            <label class="form-check-label " required>
                              Yes
                            </label>
                          </div>
                          <div class="form-check  ml-5">
                            <input :checked="generalData.is_free_guide == 0 ? 'true' : 'false'" class="form-check-input" v-model="formDatas.is_free_guide" type="radio" name="discount" id="noo" required value="0">
                            <label class="form-check-label">
                              No
                            </label>
                          </div>

                        </div>
                        <span v-if="formDatas.is_free_guide == 0">
                          <div class="form-group">
                            <label for="">Per hour rate</label>
                            <input type="number" name="price_per_hour_rate" v-model="formDatas.price_per_hour_rate" class="form-control input_field" required>
                          </div>
                          <div class="form-group">
                            <label for="">Per day rate</label>
                            <input type="number" name="price_per_day_rate" v-model="formDatas.price_per_day_rate" class="form-control input_field" required>
                          </div>
                         </span>
                          
                          <div class="d-flex justify-content-center">
                            <button class="btn btn-blackk" @click="updateGuide">Update</button>
                          </div>

                        <!-- </form> -->
                      </div>

                    </div>
                  </div>
                </div>
                <div class="hotel-title-sec">
                  <h1> {{ generalData.title }} </h1>
                </div>
                <div class="mt-1 location hotel-location">
                  <img src="/assets/img/Subtract.png" alt="" srcset="">
                  <span class="ml-2">{{ generalData.location }}</span>
                </div>

                
                <div  v-if="generalData.is_free_guide == 0" class="d-flex justify-content-between mt-4">
                  <p class="vehicle-rent-hour dish-price">${{ generalData.price_per_hour_rate }}/hour</p>
                  <p class="vehicle-rent-hour dish-price">${{ generalData.price_per_day_rate }}/day</p>
                  
                </div>
                

                <div class="profile-right px-5 py-4" >
                            <div class="d-flex justify-content-center mt-3">
                                <button class="btn btn-whitee"><a>Check availability</a></button>
    
                            </div>
                            <span class="guide-charge mb-2">$150 per day</span>
                            <div class=" mt-3">
                                <div class="input-child">
                                    <span>Destination</span>
                                    <select id="inputState" class="form-control input_field">

                                        <option selected>Hunza</option>
                                        <option>Naran</option>
                                        <option>Gilgit</option>
                                        <option>Swat</option>
                                        <option>Kalam</option>
                                    </select>
                                </div>

                                <div class="input-child">

                                </div>

                            </div>
                            <div class=" mt-1">
                                <div class="input-child">
                                    <span>From</span>
                                    <input type="text" class="form-control input_field" placeholder="Start date"
                                        onfocus="(this.type='date')">
                                </div>

                                <div class="input-child">
                                    <span>To</span>
                                    <input type="text" class="form-control input_field " placeholder="End date"
                                        onfocus="(this.type='date')">
                                </div>

                            </div>


                            <div class=" mt-1">
                                <div class="input-child">
                                    <span>Trip Type</span>
                                    <select id="inputState" class="form-control input_field">

                                        <option selected>Select</option>
                                        <option>Solo</option>
                                        <option>Group</option>
                                    </select>
                                </div>

                                <div class=" input-child">
                                    <span>Travellers</span>
                                    <input type="text" class="form-control input_field" placeholder="5">
                                </div>

                            </div>
                            <div class="charges-section mt-4 d-flex justify-content-between">
                                <p class="service">$150 X 2days </p>
                                <p class="charges">$300</p>
                            </div>


                            <hr class="charges-line mt-3">
                            <div class="charges-section d-flex justify-content-between">
                                <p class=" services service-total">Total</p>
                                <p class="charges charges-total">$300</p>
                            </div>

                        </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-8">
           
<!--Services-->
 <!--Modal-->
 <div class="modal fade" id="serivices" data-bs-backdrop="static" data-bs-keyboard="false"
 tabindex="-1" aria-labelledby="serivicesLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
   <div class="modal-content">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
     <div class=" py-3 mt-4 mb-5">
        <h2 class="ml-5">Services</h2>
       <div class=" services-container-main custom-services-container  row">

        

        <div v-if="guideServices" v-for="(service, index) in guideServices" class="col-12 col-sm-4">
          <label :for="'guide_services_'+index" class="services-container services-containere">
             <input type="checkbox" v-model="checkedServices" :id="'guide_services_'+index" :value="service.name + '|' + service.image" name="accommodation"
               class="mr-2">

             <div class="row">
               <div class="col-4 service-image">
                 <img :src="`/assets/img/icons/${service.image}`" alt="">
               </div>
               <div class="col-8 d-flex align-self-center">
                 <h2 class="services-title">{{ service.name }}</h2>


               </div>
             </div>
           </label>
         </div>
       </div>

       <div class="d-flex justify-content-center mt-3">
         <button class="btn btn-whitee" @click="addUpdateActivity('services')">Add services</button>
       </div>

     </div>


   </div>
 </div>
</div>

<h4>Services</h4>
 <div class="home-services mt-4">
            <ul v-if="servicesList && servicesList.length > 0">  
              <li v-if="servicesList" v-for="(service, index) in servicesList">
                <span class="service-icon align-self-center ">
                  <img :src="`/assets/img/icons/${service.image}`">
                </span>
                <span class="service-txt align-self-center"> {{ service.name }} </span>

              </li>
            </ul>
            <ul v-else>
              <li>
                <span class="service-icon align-self-center ">
                  <img src="/assets/img/icons/nature.png">
                </span>
                <span class="service-txt align-self-center"> Nature guide </span>

              </li>
              <li>
                <span class="service-icon align-self-center ">
                  <img src="/assets/img/icons/nature.png">
                </span>
                <span class="service-txt align-self-center"> Historical guide </span>

              </li>
              <li>
                <span class="service-icon align-self-center ">
                    <img src="/assets/img/icons/adventure.png">
                </span>
                <span class="service-txt align-self-center"> Adventure guide </span>

              </li>
              <li>
                <span class="service-icon align-self-center ">
                  <img src="/assets/img/icons/mosque.png">
                </span>
                <span class="service-txt align-self-center"> Religious guide </span>

              </li>
              <li>
                <span class="service-icon align-self-center ">
                  <img src="/assets/img/icons/jungle.png">
                </span>
                <span class="service-txt align-self-center"> Safari guid </span>

              </li>
              <li>
                <span class="service-icon align-self-center ">
                  <img src="/assets/img/icons/nature.png">
                </span>
                <span class="service-txt align-self-center"> Nature guide </span>

              </li>
              <li>
                <span class="service-icon align-self-center ">
                  <img src="/assets/img/icons/nature.png">
                </span>
                <span class="service-txt align-self-center"> Historical guide </span>

              </li>
              <li>
                <span class="service-icon align-self-center "><img src="/assets/img/icons/adventure.png"></span>
                <span class="service-txt align-self-center"> Adventure guide </span>

              </li>
              <li>
                <span class="service-icon align-self-center "><img src="/assets/img/icons/mosque.png"></span>
                <span class="service-txt align-self-center"> Religious guide </span>

              </li>
              <li>
                <span class="service-icon align-self-center "><img src="/assets/img/icons/jungle.png"></span>
                <span class="service-txt align-self-center"> Safari guid </span>

              </li>
          </ul>

            
            <div v-if="generalData.user_id == user_id" class="d-flex justify-content-start mt-2">
              <button class="btn btn-whitee" data-toggle="modal" data-target="#serivices">
                Add more
              </button>
            </div>
          </div>
<!--Services ENd-->

<!--Activitie Start-->
<div class="modal fade" id="activitiess" data-bs-backdrop="static" data-bs-keyboard="false"
 tabindex="-1" aria-labelledby="serivicesLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
   <div class="modal-content">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
     <div class=" py-3 mt-4 mb-5">
       <h2 class="ml-5">Activities</h2>
       <div class=" services-container-main custom-services-container  row">
        
        <div v-if="optionsActivities" v-for="(activity, index) in optionsActivities" class="col-12 col-sm-4">
          <label :for="activity.name" class="services-container services-containere">
             <input type="checkbox" v-model="checkedActivities" :id="activity.name" name="accommodation" :value="activity.name + '|' + activity.image" class="mr-2">

             <div class="row">
               <div class="col-4 service-image">
                 <img :src="`/assets/img/icons/${activity.image}`" alt="">
               </div>
               <div class="col-8 d-flex align-items-center">
                 <h2 class="services-title"> {{ activity.name }} </h2>
               </div>
             </div>
          </label>
         </div>
       </div>

       <div class="d-flex justify-content-center mt-3">
         <button class="btn btn-whitee" @click="addUpdateActivity('activities')">Add</button>
       </div>

     </div>


   </div>
 </div>
</div>

<h4 class="mt-3">Activities </h4>
 <div class="home-services mt-4">
            <ul v-if="activitiesList && activitiesList.length > 0">
              <li v-if="activitiesList" v-for="(activity, index) in activitiesList">
                <span class="service-icon align-self-center ">
                  <img :src="'/assets/icons/'+activity.image"></span>
                <span class="service-txt align-self-center"> {{ activity.name }} </span>
              </li>
            </ul>

            <ul v-else>
              <li>
                <span class="service-icon align-self-center "><img src="/assets/img/icons/tracking.png"></span>
                <span class="service-txt align-self-center"> Tracking </span>

              </li>
              <li>
                <span class="service-icon align-self-center "><img src="/assets/img/icons/scuba.png"></span>
                <span class="service-txt align-self-center"> Scuba Diving</span>

              </li>
              <li>
                <span class="service-icon align-self-center "><img src="/assets/img/icons/climbing.png"></span>
                <span class="service-txt align-self-center"> Rock Climbing</span>

              </li>
              <li>
                <span class="service-icon align-self-center "><img src="/assets/img/icons/raft.png"></span>
                <span class="service-txt align-self-center"> Rafting </span>

              </li>
              <li>
                <span class="service-icon align-self-center "><img src="/assets/img/icons/jet-ski.png"></span>
                <span class="service-txt align-self-center"> Jet Ski </span>

              </li>
              <li>
                <span class="service-icon align-self-center "><img src="/assets/img/icons/hiking.png"></span>
                <span class="service-txt align-self-center"> Hiking </span>

              </li>
              <li>
                <span class="service-icon align-self-center "><img src="/assets/img/icons/elephant-ride.png"></span>
                <span class="service-txt align-self-center"> Elephent Ride </span>

              </li>
              <li>
                <span class="service-icon align-self-center "><img src="/assets/img/icons/camels-race.png"></span>
                <span class="service-txt align-self-center"> Camel Riding </span>

              </li>
              <li>
                <span class="service-icon align-self-center "><img src="/assets/img/icons/camping.png"></span>
                <span class="service-txt align-self-center"> Camping </span>

              </li>
              <li>
                <span class="service-icon align-self-center "><img src="/assets/img/icons/bicycle (1).png"></span>
                <span class="service-txt align-self-center"> Cycling </span>

              </li>
             
            </ul>
            
            <div v-if="generalData.user_id == user_id" class="d-flex justify-content-start mt-2">
              <button class="btn btn-whitee" data-toggle="modal" data-target="#activitiess">
                Add more
              </button>
            </div>
          </div>
          <!--Activities End-->

          </div>
        
          <div class="col-12 col-sm-4">
            <div class="rules-sec">

              <div class="panel-group" id="accordion">
                <!-- First Panel -->
                <div class="panel panel-default">
                  <div class="panel-heading edit-parent">
                    <h4 class="panel-title edit-parentt" data-toggle="collapse" data-target="#collapseOne"
                      aria-expanded="true" aria-controls="collapseOne">Rules

                    </h4>

                  </div>
                  <div id="collapseOne" class="panel-collapse collapse show">
                    <div class="panel-body edit-parent">

                      <div class="rules-body">
                        <ul v-if="rules && rules.length > 0">
                          <li v-for="(rule, index) in rules" :key="index">
                          {{ rule.name }}
                          <i v-if="generalData.user_id == user_id"
                            class="fa fa-times"
                            @click="deleteRule(rule.id)"
                          ></i>
                        </li>
                        </ul>
                        <ul v-else>
                          <li>
                            1. lorem ispum lorem ispum lorem ispum
                            <i v-if="generalData.user_id == user_id" class="fa fa-times"></i>
                          </li>
                          <li>
                            2. lorem ispum lorem ispum lorem ispum
                            <i v-if="generalData.user_id == user_id" class="fa fa-times"></i>
                          </li>
                          <li>
                            3. lorem ispum lorem ispum lorem ispum
                            <i v-if="generalData.user_id == user_id" class="fa fa-times"></i>
                          </li>
                          <li>
                            4. lorem ispum lorem ispum lorem ispum
                            <i v-if="generalData.user_id == user_id" class="fa fa-times"></i>
                          </li>

                        </ul>
                        <div v-if="generalData.user_id == user_id" class="d-flex justify-content-end">
                          <input type="text" class=" input_field" v-model="rule_value" />
                          <button class="btn btn-whitee" @click="addRule">
                           Add
                          </button>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                
                
                <!-- terms_rule -->
                <div class="panel panel-default">
                  <div class="panel-heading ">

                    <h4 class="panel-title edit-parentt" data-toggle="collapse" data-target="#collapseTermsRule">
                      Terms & Rule
                      <i v-if="generalData.user_id == user_id" class="fa fa-pencil" data-toggle="modal" data-target="#terms_rule"></i>
                    </h4>
                  </div>
                  <!-- Modal -->
                  <div v-if="generalData.user_id == user_id" class="modal fade" id="terms_rule" tabindex="-1" role="dialog" aria-labelledby="terms_rule"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom" role="document">
                      <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                        <div class="modal-body  p-4">
                          <!-- <form> -->
                            <div class="form-group">
                              <label for="">Terms & Rule</label>
                              <textarea name="cancellation_policy" id="" rows="3" v-model="formDatas.terms_rule" class="form-control">{{ generalData.terms_rule }}</textarea>
                            </div>
                            <div class="d-flex justify-content-center">
                               <button
                              @click="updateCancPolicy('Cancellation Policy', 'terms_rule', 'terms_rule')"
                              class="btn btn-blackk"
                            >
                              Update
                            </button>
                            </div>
                          <!-- </form> -->
                        </div>

                      </div>
                    </div>
                  </div>
                  <div id="collapseTermsRule" class="panel-collapse collapse">
                    <div class="panel-body edit-parent">
                      {{ generalData.terms_rule || 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus' }}
                    </div>

                  </div>

                </div>
                
                
                <!-- Second Panel -->
                <div class="panel panel-default">
                  <div class="panel-heading ">

                    <h4 class="panel-title edit-parentt" data-toggle="collapse" data-target="#collapseTwo">
                      Cancellation policy
                      <i v-if="generalData.user_id == user_id" class="fa fa-pencil" data-toggle="modal" data-target="#cancelhead"></i>

                    </h4>
                  </div>

                  <!-- Modal -->
                  <div v-if="generalData.user_id == user_id" class="modal fade" id="cancelhead" tabindex="-1" role="dialog" aria-labelledby="cancelhead"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom" role="document">
                      <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                        <div class="modal-body  p-4">
                          <!-- <form> -->

                            <div class="form-group">
                              <label for="">Policy</label>
                              <textarea name="cancellation_policy" id="" rows="3" v-model="formDatas.cancellation_policy" class="form-control">{{ generalData.cancellation_policy }}</textarea>

                            </div>
                            <div class="d-flex justify-content-center">
                               <button
                              @click="updateCancPolicy('Cancellation Policy', 'cancellation_policy', 'cancelhead')"
                              class="btn btn-blackk"
                            >
                              Update
                            </button>

                            </div>
                          <!-- </form> -->
                        </div>

                      </div>
                    </div>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body edit-parent">
                      {{ generalData.cancellation_policy || 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.' }}
                    </div>

                  </div>

                </div>

                <!-- payment_terms -->
                <div class="panel panel-default">
                  <div class="panel-heading ">

                    <h4 class="panel-title edit-parentt" data-toggle="collapse" data-target="#collapsePaymentTerms">
                      Payment Terms
                      <i v-if="generalData.user_id == user_id" class="fa fa-pencil" data-toggle="modal" data-target="#payment_terms"></i>

                    </h4>
                  </div>

                  <!-- Modal -->
                  <div v-if="generalData.user_id == user_id" class="modal fade" id="payment_terms" tabindex="-1" role="dialog" aria-labelledby="payment_terms"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom" role="document">
                      <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                        <div class="modal-body  p-4">
                          <!-- <form> -->

                            <div class="form-group">
                              <label for="">Payment Terms</label>
                              <textarea name="payment_terms" id="" rows="3" v-model="formDatas.payment_terms" class="form-control">{{ generalData.payment_terms }}</textarea>

                            </div>
                            <div class="d-flex justify-content-center">
                               <button
                              @click="updateCancPolicy('Payment Terms', 'payment_terms', 'payment_terms')"
                              class="btn btn-blackk"
                            >
                              Update
                            </button>

                            </div>
                          <!-- </form> -->
                        </div>

                      </div>
                    </div>
                  </div>
                  <div id="collapsePaymentTerms" class="panel-collapse collapse">
                    <div class="panel-body edit-parent">
                      {{ generalData.payment_terms || 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus' }}
                    </div>

                  </div>

                </div>

                <!-- Things to know -->
                <div class="panel panel-default">
                  <div class="panel-heading ">

                    <h4 class="panel-title edit-parentt" data-toggle="collapse" data-target="#collapseThingsToKnow">
                      Things to know
                      <i v-if="generalData.user_id == user_id" class="fa fa-pencil" data-toggle="modal" data-target="#things_to_know"></i>

                    </h4>
                  </div>

                  <!-- Modal -->
                  <div v-if="generalData.user_id == user_id" class="modal fade" id="things_to_know" tabindex="-1" role="dialog" aria-labelledby="things_to_know"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom" role="document">
                      <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                        <div class="modal-body  p-4">
                          <!-- <form> -->

                            <div class="form-group">
                              <label for="">Things to know</label>
                              <textarea name="things_to_know" id="" rows="3" v-model="formDatas.things_to_know" class="form-control">{{ generalData.things_to_know }}</textarea>

                            </div>
                            <div class="d-flex justify-content-center">
                               <button
                              @click="updateCancPolicy('Things to know', 'things_to_know', 'things_to_know')"
                              class="btn btn-blackk"
                            >
                              Update
                            </button>

                            </div>
                          <!-- </form> -->
                        </div>

                      </div>
                    </div>
                  </div>
                  <div id="collapseThingsToKnow" class="panel-collapse collapse">
                    <div class="panel-body edit-parent">
                      {{ generalData.things_to_know || 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus' }}
                    </div>

                  </div>

                </div>

              </div>
            </div>



          </div>
        </div>

      </div>
      <vue-confirm-dialog></vue-confirm-dialog>
    </main>
</template>


<script>

//import jQuery from 'jQuery';
import VueTimepicker from "vue2-timepicker/src/vue-timepicker.vue";
import VueGoogleAutocomplete from "vue-google-autocomplete";


import {gmapApi} from 'vue2-google-maps'

export default {
  components: {
    VueGoogleAutocomplete,
    VueTimepicker,
  },
    
    data(){
        return{
            user_id: 0,
            formDatas:{
                title : '',
                about : '',
                price : 0,
                status : '',
                country : '',
                city : '',
                rating : '',
                no_of_reviews : '',
                terms_rule : '',
                cancellation_policy : '',
                payment_terms : '',
                things_to_know : '',
                skills : '',
                languages : '',
                expert : '',
                location : '',
                is_free_guide : 0,
                price_per_hour_rate : 0,
                price_per_day_rate : 0,
                latitude: '',
                longitude: '',
                things_to_know: '',

            },
            generalData :'',
            relatedData:'',
            userObj :'',
            accCount:'',
            transCount:'',
            tripData:'',
            skillsArray:'',
            expertsArray:'',
            languagesArray:'',
            pastTripCount:'',
            Id: this.$route.params.guideId,
            totalTrips:'',
            is_free_guide: 0,
            rules: [],
            rule_value: "",
            cancellationPolicy: "",
            error: false,
            optionsActivities: [],
            checkedActivities: [],
            checkedServices: [],
            guideServices: [
              {
                name: 'Nature guide',
                image: 'nature.png'
              },
              {
                name: 'Historical guide',
                image: 'nature.png'
              },
              {
                name: 'Nature guide',
                image: 'nature.png'
              },
              {
                name: 'Adventure guide',
                image: 'adventure.png'
              },
              {
                name: 'Religious guide',
                image: 'mosque.png'
              },
              {
                name: 'Safari guide',
                image: 'jungle.png'
              },
              {
                name: 'Nature guidee',
                image: 'nature.png'
              },
              {
                name: 'Historical guidee',
                image: 'nature.png'
              },
              {
                name: 'Adventure guidee',
                image: 'nature.png'
              },
              {
                name: 'Religious guidee',
                image: 'mosque.png'
              }

            ],
        }
    },
  
    created(){
        this.getRules();
        // this.facilities();
        this.getGuideDetail();
        this.getAllActivities();
        this.getAllServices();
        
        google: gmapApi;

        this.user_id = localStorage.getItem('user_id');
    },
    computed: {
        activitiesList() {
          let arraydata = [];
          this.checkedActivities.map((el) => {
            let namedata = el.split("|");
            let facilityName = namedata[0];
            let facilityImage = namedata[1];
            arraydata.push({ name: facilityName, image: facilityImage });
          });
          return arraydata;
        },
        servicesList() {
          let arraydata = [];
          this.checkedServices.map((el) => {
            let namedata = el.split("|");
            let facilityName = namedata[0];
            let facilityImage = namedata[1];
            arraydata.push({ name: facilityName, image: facilityImage });
          });
          return arraydata;
        },
        
    },
    methods:{
      getAddressData: function (addressData, placeResultData, id) {
        this.formDatas.country = addressData.country;
        this.formDatas.city = addressData.locality;
        this.formDatas.latitude = addressData.latitude;
        this.formDatas.longitude = addressData.longitude;
        this.formDatas.location = placeResultData.formatted_address;
      },

      addUpdateActivity(type){
        
        let activities = [];
        if(type == 'activities'){
            activities = JSON.stringify(this.activitiesList);
        }else if(type == 'services'){
          activities = JSON.stringify(this.servicesList);
        }

        let bodyFormData = new FormData();
        bodyFormData.append("guide_id", this.Id);
        bodyFormData.append("activities", activities);
        bodyFormData.append("type", type);
        axios.post("/api/addUpdate/activities/" + this.Id, bodyFormData).then((response) => {
          if (response.status == 200) {
                if(type == 'activities'){
                  this.closeModal('activitiess');
                }else if(type == 'services'){
                  this.closeModal('serivices');
                }
                  
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

      getAllActivities(){
        axios.get('/api/getPackageAllActivities').then((response) => {
          this.optionsActivities = response.data.data.activities;
        });  
      },
      getAllServices(){
        axios.get('/api/getPackageAllServices').then((response) => {
          this.guideServices = response.data.data.services;
        });  
      },

      
        
        activityList() {
          let arraydata = [];
          this.checkedActivities.map((el) => {
            let namedata = el.split("|");
            let facilityName = namedata[0];
            let facilityImage = namedata[1];
            arraydata.push({ name: facilityName, image: facilityImage });
          });

          return arraydata;
        },

         getGuideDetail() {

                axios.get("/api/guideEdit/" + this.Id).then((response) => {
                  
                this.generalData = response.data.data.detail;
                this.relatedData  = response.data.data.relatedData;
                this.userObj =      response.data.data.userObj;
                this.tripData =     response.data.data.tripData;
                this.pastTripCount =   response.data.data.pastTripCount;
                this.totalTrips =   response.data.data.totalTrips;
                this.formDatas.title = this.generalData.title;
                this.formDatas.about = this.generalData.about;
                this.formDatas.status = this.generalData.status;
                this.formDatas.country = this.generalData.country;
                this.formDatas.city = this.generalData.city;
                this.formDatas.rating = this.generalData.rating;
                this.formDatas.no_of_reviews = this.generalData.no_of_reviews;
                this.formDatas.terms_rule = this.generalData.terms_rule;
                this.formDatas.cancellation_policy = this.generalData.cancellation_policy;
                this.formDatas.payment_terms = this.generalData.payment_terms;
                this.formDatas.things_to_know = this.generalData.things_to_know;
                this.formDatas.skills = this.generalData.skills;
                this.formDatas.languages = this.generalData.languages;
                this.formDatas.expert = this.generalData.expert;
                this.formDatas.location = this.generalData.location;
                this.formDatas.is_free_guide = this.generalData.is_free_guide;
                this.formDatas.price_per_hour_rate = this.generalData.price_per_hour_rate;
                this.formDatas.price_per_day_rate = this.generalData.price_per_day_rate;
                this.formDatas.things_to_know = this.generalData.things_to_know;
                this.generalData.activities.forEach((item) => {
                  
                  if(item.type == 'activities'){
                    this.checkedActivities.push(item.name + "|" + item.image);
                  }else if(item.type == 'services'){
                    this.checkedServices.push(item.name + "|" + item.image);
                  }
                });
                
                this.skillsArray = (this.generalData.skills) ? this.generalData.skills.split(',') : this.generalData.skills;
                this.expertsArray = (this.generalData.expert) ? this.generalData.expert.split(',') : this.generalData.expert;
                this.languagesArray = (this.generalData.languages) ? this.generalData.languages.split(',') : this.generalData.languages;

            });
        },
        

        updateId(){
            this.Id = this.$route.params.guideId;
            this.getGuideDetail();
        },
        updateLanguageSection(){
          if (this.formDatas.languages == "") {
                this.$swal({
                    type: "error",
                    title: "Error!",
                    text: "Language field is required",
                    timer: 2500,
                });
              this.error = true;
              return false;
          }
          if (this.formDatas.skills == "") {
                this.$swal({
                    type: "error",
                    title: "Error!",
                    text: "Skill field is required",
                    timer: 2500,
                });
              this.error = true;
              return false;
          }
          if (this.formDatas.about == "") {
                this.$swal({
                    type: "error",
                    title: "Error!",
                    text: "About field is required",
                    timer: 2500,
                });
              this.error = true;
              return false;
          }

          // if(!this.error){  
                let bodyFormData = new FormData();
                bodyFormData.append("guide_id", this.Id);
                bodyFormData.append("languages", this.formDatas.languages);
                bodyFormData.append("skills", this.formDatas.skills);
                bodyFormData.append("about", this.formDatas.about);
                
                
                axios.post("/api/updateGuidePackage/" + this.Id, bodyFormData).then((response) => {
                    if (response.status == 200) {
                      this.getGuideDetail();
                        this.closeModal('editFeatures');
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
                        text: err,
                        timer: 2500,
                    });
                });
            // }

        },
        updateGuide(){
            
            if (this.formDatas.title == "") {
                  this.$swal({
                      type: "error",
                      title: "Error!",
                      text: "Title field is required",
                      timer: 2500,
                  });
                this.error = true;
                return false;
            }
            if (this.formDatas.location == "") {
                  this.$swal({
                      type: "error",
                      title: "Error!",
                      text: "Location field is required",
                      timer: 2500,
                  });
                this.error = true;
                return false;
            }
            
            if(this.formDatas.is_free_guide == 0){
               if (this.formDatas.price_per_hour_rate == "") {
                    this.$swal({
                        type: "error",
                        title: "Error!",
                        text: "Price per hour rate field is required",
                        timer: 2500,
                    });
                  this.error = true;
                  return false;
              }
              if (this.formDatas.price_per_day_rate == "") {
                  this.$swal({
                      type: "error",
                      title: "Error!",
                      text: "Price per day rate field is required",
                      timer: 2500,
                  });
                this.error = true;
                return false;
              }
            }
            

        
                
            // }else{
              
                let bodyFormData = new FormData();
                bodyFormData.append("guide_id", this.Id);
                bodyFormData.append("title", this.formDatas.title);
                bodyFormData.append("location", this.formDatas.location);
                bodyFormData.append("city", this.formDatas.city);
                bodyFormData.append("country", this.formDatas.country);
                bodyFormData.append("is_free_guide", this.formDatas.is_free_guide);
                bodyFormData.append("price_per_hour_rate", this.formDatas.price_per_hour_rate);
                bodyFormData.append("price_per_day_rate", this.formDatas.price_per_day_rate);
                

                axios.post("/api/updateGuidePackage/" + this.Id, bodyFormData).then((response) => {
                    if (response.status == 200) {
                        this.getGuideDetail();
                        this.closeModal('editdetails');
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
            // }

            // axios.post().then((response) => {
            
        },
        updateCancPolicy(messages, input_field, modal_id) {
          
          if (this.formDatas.input_field == "") {
            this.$swal({
              type: "error",
              title: "Error!",
              text: "Please Input "+messages,
              timer: 2500,
            });
            return;
          } 
          let bodyFormData = new FormData();
          bodyFormData.append("guide_id", this.Id);
          bodyFormData.append(input_field, this.formDatas[input_field]);
          axios.post("/api/updateGuidePackage/" + this.Id, bodyFormData).then((response) => {
            if (response.status == 200) {
                this.getGuideDetail();
                this.closeModal(modal_id);
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
                text: err.response.message,
                timer: 2500,
              });
            });
        },

        updateThingsToKnow() {
          if (this.formDatas.things_to_know == "") {
            this.$swal({
              type: "error",
              title: "Error!",
              text: "Please Input Things to Know",
              timer: 2500,
            });
            return;
          } 
          let bodyFormData = new FormData();
          bodyFormData.append("guide_id", this.Id);
          bodyFormData.append("things_to_know", this.formDatas.things_to_know);
          axios.post("/api/updateGuidePackage/" + this.Id, bodyFormData).then((response) => {
             this.getGuideDetail();
            $("#cancelhead").modal("hide");
          }).catch((err) => {
              this.$swal({
                type: "error",
                title: "Error!",
                text: err.response.message,
                timer: 2500,
              });
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
          bodyFormData.append("module", "guides");
          bodyFormData.append("module_id", this.Id);
          axios.post("/api/uploadImages", bodyFormData).then((response) => {
            if (response.status == 200) {
              this.getGuideDetail();
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
          });
        },
        deleteImage(image_id) {
          Vue.$confirm({
            title: 'Are you sure?',
            message: 'Are you sure you want to Remove?',
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
                this.getGuideDetail();
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
      getRules() {
      const params = "module_id="+this.Id;
      axios
        .get("/api/getRules?module_name=guides&"+params)
        .then((response) => {
          this.rules = response.data.data;
        });
    },
    deleteRule(rule_id) {
    Vue.$confirm({
        title: 'Are you sure?',
        message: 'Are you sure you want to Remove?',
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
          text: "Please Input Rule",
          timer: 2500,
        });
        return;
      }

      bodyFormData.append("module_id", this.Id);
      bodyFormData.append("rule", this.rule_value);
      bodyFormData.append("module_name", 'guides');
      axios
        .post("/api/addRule", bodyFormData)
        .then((response) => {
           if (response.status == 200) {
             this.rule_value = "";
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
    },
    // updateCancPolicy(e) {

    //   if (this.formDatas.cancellation_policy === "") {
    //     this.$swal({
    //       type: "error",
    //       title: "Error!",
    //       text: "Please Input Cancellation Policy",
    //       timer: 2500,
    //     });
    //     return;
    //   } 
    //   let bodyFormData = new FormData();
    //   bodyFormData.append("guide_id", this.Id);
    //   bodyFormData.append("cancellation_policy", this.formDatas.cancellation_policy);
    //   axios.post("/api/updateGuidePackage/" + this.Id, bodyFormData).then((response) => {
    //      this.getGuideDetail();
    //     $("#cancelhead").modal("hide");
    //   }).catch((err) => {
    //       this.$swal({
    //         type: "error",
    //         title: "Error!",
    //         text: err.response.message,
    //         timer: 2500,
    //       });
    //     });
    // },
      closeModal(id) {
        $("#"+id).modal('hide');
      },
    },
    watch:{
        $route : 'updateId'
    }
}
</script>

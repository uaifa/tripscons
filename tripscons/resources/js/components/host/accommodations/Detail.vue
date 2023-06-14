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
                    'accommodations/' +
                    accommodationDetail.main_image.name
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
                          v-for="(image, index) in accommodationDetail.images"
                          :key="index"
                        >
                          <div class="image-edit-wrapper">
                            <img
                              :src="$imagePath + 'accommodations/' + image.name"
                            />
                            <div
                              class="d-flex justify-content-center editbuttons"
                            >
                              <button @click="deleteImage(image.id)">
                                Delete
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="d-flex justify-content-center mt-3">
                        <button class=" mt-3 btn btn-blackk">
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
                <div class="col-12 col-md-4"
                  v-for="(i, index) in accommodationDetail.two_images"
                  :key="index"
                >
                  <img :src="$imagePath + 'accommodations/' + i.name" alt="img" />
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
                          <label for="">Property Title</label>
                          <input
                            type="text"
                            placeholder=" "
                            class="form-control input_field"
                            v-model="title"
                          />
                        </div>
                        <label>Location</label>
                         <div class="row">
                          <div class="form-group col-12 cus-input">
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
                        </div>
                         <div class="property-type-check mt-4 container">
                          <span class="mr-4">My property is:</span>
                          <form>
                            <input
                              type="radio"
                              id="entire"
                              name="entire"
                              value="Entire"
                              v-model="is_property"
                            />
                            <label for="vehicle1" class="ml-2"> Entire</label>
                            <input
                              type="radio"
                              id="joint"
                              class="ml-4"
                              name="joint"
                              value="Joint"
                              v-model="is_property"
                            />
                            <label for="vehicle2" class="ml-2">Joint</label>
                            <input
                              type="radio"
                              id="private"
                              class="ml-4"
                              name="private"
                              value="Private"
                              v-model="is_property"
                            />
                            <label for="vehicle3" class="ml-2">Private</label><br /><br />
                          </form>
                        </div>
                        <div class="form-group">
                          <label for="">No of guests</label>
                          <input
                            type="number"
                            placeholder="5 guests "
                            class="form-control input_field"
                            v-model="no_of_people"
                          />
                        </div>

                        <div class="form-group">
                          <label for="">No of attach baths</label>
                          <input
                            type="number"
                            placeholder="3 Attach Bath "
                            class="form-control input_field"
                            v-model="no_of_attach_bath"
                          />
                        </div>
                        <div class="form-group">
                          <label for="">No of shared baths</label>
                          <input
                            type="number"
                            placeholder="3 Shared Bath "
                            class="form-control input_field"
                            v-model="no_of_share_bath"
                          />
                        </div>
                        <div class="d-flex justify-content-center">
                          <button
                            class="btn btn-blackk"
                            @click="updateTitleSection"
                          >
                            Update
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <div class="hotel-title-sec">
                <h1>{{ title }}</h1>
              </div>
              <div class="mt-1 location hotel-location">
                <img src="/assets/img/Subtract.png" alt="" srcset="" />
                <span class="ml-2">{{ location }} </span>
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
                  {{ is_property }}
                </h3>
              </div>
              <div class="d-flex cbrudcrums mt-2">
                <ul>
                  <li>{{ no_of_people }} guests</li>

                  <li>{{ no_of_attach_bath }} attach bath</li>
                  <li>{{ no_of_share_bath }} shared bath</li>
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
                        <label>Price per night</label>
                        <input
                          type="number"
                          placeholder=" "
                          class="form-control input_field"
                          v-model="per_night"
                        />
                      </div>
                      <div class="form-group">
                        <label>Weekly discount</label>
                        <input
                          type="number"
                          placeholder=" "
                          class="form-control input_field"
                          v-model="weeklyDiscount"
                          maxlength="2"
                        />
                      </div>
                      <div class="form-group">
                        <label>15 days discount</label>
                        <input
                          type="number"
                          placeholder=" "
                          class="form-control input_field"
                          v-model="fifteenDayDiscount"
                        />
                      </div>
                      <div class="form-group">
                        <label>Monthly Discount</label>
                        <input
                          type="number"
                          placeholder=" "
                          class="form-control input_field"
                          v-model="monthlyDiscount"
                        />
                      </div>
                      <p>Payment Mode</p>
                      <div class="d-flex">
                        <div class="form-check ml-4">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="payment"
                            id="later"
                            value="0"
                            v-model="paymentMode"
                            @change="onChangePaymentMode($event)" 
                            
                            
                          />
                          <label class="form-check-label">
                            Pay later at checkin
                          </label>
                        </div>
                        <div class="form-check ml-5">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="payment"
                            id="partial"
                            value="1"
                            v-model="paymentMode"
                            @change="onChangePaymentMode($event)"
                          />
                          <label class="form-check-label">
                            Pay partial advance
                          </label>
                        </div>
                        <div class="form-check ml-5">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="payment"
                            id="advance"
                            value="2"
                            v-model="paymentMode"
                            @change="onChangePaymentMode($event)"
                          />
                          <label class="form-check-label">
                            Pay full amount in advance
                          </label>
                        </div>
                      </div>
                      <div v-show="partialAmountShow">
                        <input
                          type="number"
                          v-model="partialAmountVal"
                          placeholder="Partial Advance Amount"
                          class="form-control"
                        />
                      </div>
                      <p>Breakfast</p>
                      <div class="d-flex">
                        <div class="form-check ml-4">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="breakfast"
                            id="Yes"
                            value="Yes"
                            v-model="breakfast_included"
                            @change="onChangebreakfast($event)" 
                          />
                          <label class="form-check-label"> Yes </label>
                        </div>
                        <div class="form-check ml-5">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="breakfast"
                            id="no"
                            value="No"
                            v-model="breakfast_included"
                            @change="onChangebreakfast($event)" 
                          />
                          <label class="form-check-label"> No </label>
                        </div>
                      </div>
                      <div class="breakfast_details" v-show="breakfast_details">
                        <div class="row mt-3">
                          <div class="col-12 col-md-6">
                          <input
                          class="form-control input_field"
                          type="number"
                          v-model="breakfast_price"
                          placeholder="Breakfast Price"
                        />
                          </div>
                          <div class="col-12 col-md-6">
                             <input
                          type="text"
                            class="form-control input_field"
                          v-model="breakfast_description"
                          placeholder="Breakfast Description"
                        />
                          </div>
                        </div>
                    
                      </div>
                      <p>Lunch</p>
                      <div class="d-flex">
                        <div class="form-check ml-4">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="lunch"
                            id="Yes"
                            value="Yes"
                            v-model="lunch_included"
                            @change="onChangelunch($event)" 
                          />
                          <label class="form-check-label"> Yes </label>
                        </div>
                        <div class="form-check ml-5">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="lunch"
                            id="no"
                            value="No"
                            v-model="lunch_included"
                            @change="onChangelunch($event)" 
                          />
                          <label class="form-check-label"> No </label>
                        </div>
                      </div>
                      <div class="lunch_details" v-show="lunch_details">
                        <div class="row mt-3">
                          <div class="col-12 col-md-6">
                          <input
                          class="form-control input_field"
                          type="number"
                          v-model="lunch_price"
                          placeholder="Lunch Price"
                        />
                          </div>
                          <div class="col-12 col-md-6">
                             <input
                          type="text"
                            class="form-control input_field"
                          v-model="lunch_description"
                          placeholder="Lunch Description"
                        />
                          </div>
                        </div>
                    
                      </div>
                      <p>Dinner</p>
                      <div class="d-flex">
                        <div class="form-check ml-4">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="dinner"
                            id="Yes"
                            value="Yes"
                            v-model="dinner_included"
                            @change="onChangedinner($event)" 
                          />
                          <label class="form-check-label"> Yes </label>
                        </div>
                        <div class="form-check ml-5">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="dinner"
                            id="no"
                            value="No"
                            v-model="dinner_included"
                            @change="onChangedinner($event)" 
                          />
                          <label class="form-check-label"> No </label>
                        </div>
                      </div>
                      <div class="dinner_details" v-show="dinner_details">
                        <div class="row mt-3">
                          <div class="col-12 col-md-6">
                          <input
                          class="form-control input_field"
                          type="number"
                          v-model="dinner_price"
                          placeholder="Dinner Price"
                        />
                          </div>
                          <div class="col-12 col-md-6">
                             <input
                          type="text"
                            class="form-control input_field"
                          v-model="dinner_description"
                          placeholder="Dinner Description"
                        />
                          </div>
                        </div>
                    
                      </div>
                      
                      <div class="row mt-3">
                        <div class="col-12 col-md-6">
                         <vue-timepicker
                          v-model="checkInTime"
                          class="form-control input_field"
                        ></vue-timepicker>
                        </div>
                        <div class="col-12 col-md-6">
                          <vue-timepicker
                          v-model="checkOutTime"
                          class="form-control input_field"
                        ></vue-timepicker>
                        </div>
                       
                      </div>
                      <div class="row mt-4 ml-2">
                        <div class="check-guest mt-3">
                          <label class="switch">
                            <input
                              type="checkbox"
                              v-model="isFlexiableCheckIn"
                            />
                            <span class="slider round"></span>
                          </label>
                          <span class="ml-2"
                            >Flexible checkin/checkout time upon special
                            requests
                          </span>
                        </div>
                      </div>
                      <div class="input-wrapper  mt-2">
                        <input
                          type="number"
                          class="form-control input_field"
                          placeholder="Flexibility Hours"
                          v-model="isFlexiableCheckInValue"
                          v-show="isFlexiableCheckIn"
                        />
                      </div>
                      <div class="row mt-4 ml-2">
                        <div class="check-guest mt-3">
                          <label class="switch">
                            <input type="checkbox" v-model="isEnquiry" />
                            <span class="slider round"></span>
                          </label>
                          <span class="ml-2"
                            >I'll you allow enquiry before reservation
                          </span>
                        </div>
                      </div>
                      <div class="input-wrapper mt-2">
                        <input
                          type="number"
                          class="form-control input_field"
                          placeholder="Enquiry Response Hours"
                          v-model="isEnquiryValue"
                          v-show="isEnquiry"
                        />
                      </div>
                      <div class="form-group">
                        <label>Age limit for free child</label>
                        <input
                          type="number"
                          placeholder=" "
                          class="form-control input_field"
                          v-model="ageLimitFreeChild"
                        />
                      </div>
                      <div class="form-group">
                        <label>Age limit for child discount</label>
                        <input
                          type="number"
                          placeholder=" "
                          class="form-control input_field"
                          v-model="ageLimitForChild"
                        />
                      </div>
                      <div class="form-group">
                        <label>Discount(%)</label>
                        <input
                          type="number"
                          placeholder=" "
                          class="form-control input_field"
                          v-model="childDiscount"
                        />
                      </div>
                      <div class="form-group">
                        <label>About</label>
                        <textarea
                          rows="7"
                          type="text"
                          placeholder=""
                          class="form-control"
                          v-model="description"
                        >
                        </textarea>
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

            <div class="media mb-4">
              <img
                class="mr-3"
                src="/assets/img/icons/feat.png"
                alt="Generic placeholder image"
              />
              <div class="media-body edit-parent">
                <h5 class="mt-0">Price Per Night</h5>
                <p>PKR{{ per_night }}</p>
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
                  <p>
                    <strong>Weekly:</strong>
                    <span class="ml-1">{{ weeklyDiscount }}%</span>
                  </p>
                  <p class="ml-3">
                    <strong>15 days:</strong>
                    <span class="ml-1">{{ fifteenDayDiscount }}%</span>
                  </p>
                  <p class="ml-3">
                    <strong>Monthly:</strong>
                    <span class="ml-1">{{ monthlyDiscount }}%</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="media mb-4">
              <img
                class="mr-3"
                src="/assets/img/icons/stayy.png"
                alt="Generic placeholder image"
              />
              <div class="media-body edit-parent">
                <h5 class="mt-0">Payment Mode</h5>
                <p>{{ paymentModeValue }}</p><p v-show="partialAmountShow">
                  ({{ partialAmountVal }}%)</p>
              </div>
            </div>
            <div class="media mb-4">
              <img
                class="mr-3"
                src="/assets/img/icons/cofeei.png"
                alt="Generic placeholder image"
              />
              <div class="media-body edit-parent">
                <h5 class="mt-0">Breakfast</h5>
                <p>{{ breakfast_included }}</p>
                <p v-show="breakfast_details"><span class="b-price">Breakfast Price: {{ breakfast_price }}</span>
                <span class="b-value ml-3">Breakfast Description: {{ breakfast_description }}</span>
                </p>
                
              </div>
         
            </div>
             <div class="media mb-4">
             <img
                class="mr-3"
                src="/assets/img/icons/lunchi.png"
                alt="Generic placeholder image"
              />
                 <div class="media-body edit-parent">
                <h5 class="mt-0">Lunch</h5>
                <p>{{ lunch_included }}</p>
                <p v-show="lunch_details">
                <span class="b-price">Lunch Price: {{ lunch_price }}</span>
                <span class="b-value ml-3">Lunch Description:  {{ lunch_description }}</span>
                </p>
                
              </div>
              </div>
            <div class="media mb-4">
             <img
                class="mr-3"
                src="/assets/img/icons/dinneri.png"
                alt="Generic placeholder image"
              />
              <div class="media-body edit-parent">
                <h5 class="mt-0">Dinner</h5>
                <p>{{ dinner_included }}</p>
                <p v-show="dinner_details">
                <span class="b-price">Dinner Price: {{ dinner_price }}</span>
                <span class="b-value ml-3">Dinner Description:   {{ dinner_description }}</span>
                </p>
                
              </div>
              </div>
            <div class="media mb-4">
              <img
                class="mr-3"
                src="/assets/img/icons/time.png"
                alt="Generic placeholder image"
              />
              <div class="media-body edit-parent">
                <h5 class="mt-0">Flexible check in</h5>
                <div class="d-flex">
                  <p>{{isFlexiableCheckInDisplay}}
                    {{isFlexiableCheckInValue}}  Hour</p>
                </div>
              </div>
                <div class="media-body edit-parent">
                <h5 class="mt-0">Flexible check in</h5>
                <div class="d-flex">
                  <p>{{isEnquiryDisplay}}
                    {{isEnquiryValue}}  Hour</p>
                </div>
              </div>

            </div>
            <div class="media mb-4">
              <img
                class="mr-3"
                src="/assets/img/icons/time.png"
                alt="Generic placeholder image"
              />
              <div class="media-body edit-parent">
                <h5 class="mt-0">check in</h5>
                <div class="d-flex">
                  <p>
                    <strong>Time in:</strong>
                    <span class="ml-1">{{ checkInTime }}</span>
                  </p>
                  <p class="ml-2">
                    <strong>Time out:</strong>
                    <span class="ml-1">{{ checkOutTime }}</span>
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
                <h5 class="mt-0">Only for booking process</h5>
                <div class="d-flex">
                  <p>
                    <strong>Age limit for free child:</strong>
                    <span class="ml-1">{{ ageLimitFreeChild }} years</span>
                  </p>
                  <p class="ml-2">
                    <strong>Age limit for child discount:</strong>
                    <span class="ml-1">{{ ageLimitForChild }} years</span>
                  </p>
                  <p class="ml-2">
                    <strong>Discount({{ childDiscount }}%)</strong>
                    <span class="ml-1"></span>
                  </p>
                </div>
              </div>
            </div>
            <div class="about-txt edit-parent">
              <h2>About</h2>
              <p>{{ description }}</p>
            </div>
          </div>
          <div class="home-services home_service mt-4">
            <label>Facilities Selected</label>
            <ul >
              <li v-for="(i, index) in splitedList" :key="index">
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
                        v-model="checkedFacilities"
                        checked
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
                  <div class="d-flex my-2 justify-content-center">
                    <button
                    class="btn btn-whitee"
                    @click="accommodationFacilityAdd"
                  >
                    Add Facilities
                  </button>
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
                      <div class="d-flex ">
                        
                        <input type="text" class=" input_field" v-model="rule_value" />
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
<vue-confirm-dialog></vue-confirm-dialog>
          <!--Places section start :belongings=belongingtags-->
          <div class="title-heading home-details-edits edit-places mt-3">
            <i
              class="fa fa-pencil"
              data-toggle="modal"
              data-target="#editplaces"
            ></i>
            <h6 class="">Which places your guests will be allowed to use?</h6>
            <div class="d-flex places-allowed mt-2" v-if="tags!=''">
              <ul>
                 <li v-for="(i,index) in splitedAllowPlacesList" :key="index">
                  {{i}}
                </li>
              </ul>
            </div>
            <div class="personal-belongings">
              <div class="title-heading mt-4">
                <p>
                  Do you’ve any of your personal belongings at your
                  property/room?
                </p>
              </div>
             <div class="d-flex places-allowed mt-2" v-if="belongingtags!=''">
               <ul>
              <li v-for="(i,index) in splitedBelongingList" :key="index">
                  {{i}}
                </li>
                 </ul>
             </div>
             
            </div>

            <!-- Modal -->
            <div
              class="modal fade"
              id="editplaces"
              tabindex="-1"
              role="dialog"
              aria-labelledby="editFeatures"
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
                   
                      <div class="personal-belongings">
                        <div class="title-heading mt-4">
                          <p>
                            Do you’ve any of your personal belongings at your
                            property/room?
                            <!-- @custom_tags="custom_tags($event)" -->
                          </p>
                        <div v-if="loaded">
                        <asset-tags :fieldName="'Belongings'" :selectedTags="belongingtags" @custom_tags="custom_tags($event)"></asset-tags></div>
                        </div>
                        <div class="cust-radio mt-2">
                          
                        <div>
                          <div class="form-group">
                          </div>
                          <h4>Custom tags </h4>
                          
                         </div>
                         
                        </div>
                       
                     
                      </div>

                      Which places your guests will be allowed to use?
                      <div v-if="loaded">
                       <asset-tags :fieldName="'placesAllowed'" :selectedTags="tags" @custom_tags="custom_tags($event)"></asset-tags></div>
                       <div v-else>This is Before Api Response</div>
                      <div class="form-group">
                      </div>

                      <div class="d-flex justify-content-center">
                        <button @click="updatePersonelBelongings" class="btn btn-blackk">
                          Update
                        </button>
                      </div>
                 
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--Places section end-->
        </div>
      </div>
      <h2>Hotel surroundings *</h2>
      <add-places></add-places>
    </div>
  </main>
</template>
<script>
//import jQuery from 'jQuery';
import VueTimepicker from "vue2-timepicker/src/vue-timepicker.vue";
import VueGoogleAutocomplete from "vue-google-autocomplete";


export default {
  name: "AccommodationDetail",

  data() {
    return {
      accommodationId: this.$route.params.accommodationId,
      accommodationDetail: "",
      normalImage: null,
      normalImagePreview: null,
      normalShowPreview: false,
      rules: [],
      rule_value: "",
      weeklyDiscount: "",
      fifteenDayDiscount: "",
      monthlyDiscount: "",
      title: "",
      location: "",
      is_property: "entire",
      no_of_attach_bath: "",
      no_of_share_bath: "",
      no_of_people: "",
      checkInTime: "09:00:00",
      checkOutTime: "12:00:00",
      isFlexiableCheckIn: false,
      isFlexiableCheckInDisplay:'No', 
      isFlexiableCheckInValue: "",
      isEnquiryDisplay:false,
      isEnquiry: false,
      isEnquiryValue: "",
      paymentMode: 0,
      paymentModeValue: "",
      ageLimitForChild: "",
      ageLimitFreeChild: "",
      childDiscount: "",
      description: "",
      breakfast_included: "No",
      per_night: "",
      checkedFacilities: [],
      generalobjects: {},
      importanInformation: "",
      cancellationPolicy: "",
      partialAmountShow: false,
      partialAmountVal: "",
      country: "",
      city: "",
      latitude: "",
      longitude: "",
      personelBelonging:"",
      tags: [],
      belongingtags: [],
      loaded:false,
      mainImageShow: false,
      twoImageShow: false,
      breakfast_details:false,
      breakfast_price:0,
      breakfast_description:'',
      lunch_included :"No",
      lunch_details:false,
      lunch_price:0,
      lunch_description:'',
      dinner_included :"No",
      dinner_details:false,
      dinner_price:0,
      dinner_description:'',
      max:2,
      min:0,
     };
  },
  created() {
    this.getRules();
    this.facilities();
  },
  async beforeMount(){
   
    this.accommodationGet();
 
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
    splitedBelongingList() {
      let arraydata = [];
      this.belongingtags.map((el) => {
      arraydata.push(el);
      });
     return arraydata;
    },
    splitedAllowPlacesList() {
      let arraydata = [];
      this.tags.map((el) => {
      arraydata.push(el);
      });
     return arraydata;
    },
},
  components: {
    VueTimepicker,
    VueGoogleAutocomplete,
   },
  methods: {
    
accommodationGet() {
      axios
        .get("/api/getAccommodationDetail/" + this.accommodationId)
        .then((response) => {
          if (response.status == 200) {
          
          
          this.accommodationDetail = response.data.data;
          this.discount_for_one_week =
            this.accommodationDetail.discount_for_one_week;
          this.discount_for_two_week =
            this.accommodationDetail.discount_for_two_week;
          this.discount_for_three_week =
            this.accommodationDetail.discount_for_three_week;
          this.discount_for_four_week =
            this.accommodationDetail.discount_for_four_week;
          this.title = this.accommodationDetail.title;
         
          this.is_property = this.accommodationDetail.is_property;
          if (this.is_property == null || this.is_property == "") {
            this.is_property = "Entire";
          }
         
        if (this.accommodationDetail.two_images != null && this.accommodationDetail.two_images != "") {
           this.twoImageShow = true;
          } else {
            this.accommodationDetail.two_images = "";
            this.twoImageShow = false;
          }
 
          if (this.accommodationDetail.main_image != null) {
            this.mainImageShow = true;
          } else {
            this.accommodationDetail.main_image = "";
            this.mainImageShow = false;
          }
          this.no_of_attach_bath = this.accommodationDetail.no_of_attach_bath;
          this.no_of_share_bath = this.accommodationDetail.no_of_share_bath;
          if(this.no_of_share_bath == 0){
          
            this.no_of_share_bath = 0;
          }
         
          
          this.no_of_people = this.accommodationDetail.no_of_people;
         
          this.weeklyDiscount = this.accommodationDetail.discount_for_one_week;
          this.fifteenDayDiscount =
            this.accommodationDetail.discount_for_two_week;
          this.monthlyDiscount = this.accommodationDetail.discount_for_monthly;

          this.breakfast_included = this.accommodationDetail.breakfast_included;
          if(this.breakfast_included == "Yes"){
            
           this.breakfast_details =true;
          }
          this.breakfast_price = this.accommodationDetail.breakfast_price;
          this.breakfast_description = this.accommodationDetail.breakfast_description;
          this.lunch_included = this.accommodationDetail.lunch_included;
         
          if(this.lunch_included == "Yes"){
           this.lunch_details =true;
          }
          this.lunch_price = this.accommodationDetail.lunch_price;
          
          this.lunch_description = this.accommodationDetail.lunch_description;
          this.dinner_included = this.accommodationDetail.dinner_included;
         
          if(this.dinner_included == "Yes"){
           this.dinner_details =true;
          }
        
          this.dinner_price = this.accommodationDetail.dinner_price;
          this.dinner_description = this.accommodationDetail.dinner_description;
          this.checkInTime = this.accommodationDetail.check_in_time;
          if (this.checkInTime == null || this.checkInTime == "") {
            this.checkInTime = "";
          }
          this.checkOutTime = this.accommodationDetail.check_out_time;
          if (this.checkOutTime == null || this.checkOutTime == "") {
            this.checkOutTime = "";
          }
          this.isFlexiableCheckIn =
            this.accommodationDetail.is_flexiable_check_in;
           
          if(
            this.isFlexiableCheckIn == null ||
            this.isFlexiableCheckIn == ''
          ) {
            this.isFlexiableCheckIn = false;
            this.isFlexiableCheckInDisplay ='No';
          }
        
          if (this.isFlexiableCheckIn === 'true') {
            
              this.isFlexiableCheckInValue =
              this.accommodationDetail.is_flexiable_check_in_value;
              this.isFlexiableCheckInDisplay ='Yes';
           }else{
             this.isFlexiableCheckIn   = false;
             this.isFlexiableCheckInDisplay ='No';
             this.isFlexiableCheckInValue ='';
          }

          this.isEnquiry =
            this.accommodationDetail.is_enquiry_before_reservation;
          
          if (this.isEnquiry == null || this.isEnquiry == "") {
            this.isEnquiry = false;
          }

          if (this.isEnquiry === 'true') {
              this.isEnquiryValue =
              this.accommodationDetail.is_enquiry_before_reservation_value;
              this.isEnquiryDisplay ='Yes';
          }else{
             this.isEnquiry   = false;
             this.isEnquiryDisplay ='No';
             this.isEnquiryValue ='';
          }
          this.paymentMode = this.accommodationDetail.payment_mode;
          if (this.paymentMode == 0) {
            this.paymentModeValue = "Pay later at checkin";
           
          } else {
            if (this.paymentMode == 1) {
              this.paymentModeValue = "Pay partial advance";
              this.partialAmountVal =
                this.accommodationDetail.payment_partial_value;
              this.partialAmountShow = true;
            } else {
              this.paymentModeValue = "Pay full amount in advance";
              this.partialAmountVal ='';
            }
          }

          this.ageLimitForChild = this.accommodationDetail.age_limit_for_child;
          this.ageLimitFreeChild =
            this.accommodationDetail.age_limit_for_child_free;
          
          this.childDiscount = this.accommodationDetail.child_discount;
          this.description = this.accommodationDetail.description;
          if (this.description == null || this.description == "") {
            this.description = "";
          }
          this.per_night = this.accommodationDetail.per_night;
          
          this.importanInformation = this.accommodationDetail.important_info;
          if (
            this.importanInformation == null ||
            this.importanInformation == ""
          ) {
            this.importanInformation = "";
          }
          this.cancellationPolicy =
            this.accommodationDetail.cancellation_policy;
          if (
            this.cancellationPolicy == null ||
            this.cancellationPolicy == ""
          ) {
            this.cancellationPolicy = "";
          }
          this.tags =  this.accommodationDetail.places_allow_for_use_guest;
          try {
             JSON.parse(this.tags);
             } catch (e) {
              this.tags = '';
           }
          if (
            this.tags == null ||
            this.tags == ""
          ) {
            this.tags = '';
          }else{
            this.tags = JSON.parse(this.accommodationDetail.places_allow_for_use_guest);
          }
         
          this.belongingtags =  this.accommodationDetail.personal_belongings_assets;
           try {
             JSON.parse(this.belongingtags);
             } catch (e) {
           this.belongingtags = '';
           }
          if (
            this.belongingtags == null ||
            this.belongingtags == ""
          ) {
            
            this.belongingtags = '';
          }else{
            this.belongingtags = JSON.parse(this.accommodationDetail.personal_belongings_assets);
          }
          this.location =  this.accommodationDetail.location;
          this.loaded= true;
          }
          }).catch((err) => {
           this.$router.push({ path: "/notfound" });
        });
    },
    getAddressData: function (addressData, placeResultData, id) {
      this.country = addressData.country;
      this.city = addressData.locality;
      this.latitude = addressData.latitude;
      this.longitude = addressData.longitude;
      this.location = placeResultData.formatted_address;
    },
    onChangePaymentMode(event) {
        if (event.target.value == 1) {
        this.partialAmountShow = true;
         this.paymentModeValue = "Pay partial advance";
      } else {
        if (event.target.value == 0) {
            this.paymentModeValue = "Pay later at checkin";
            this.partialAmountShow = false;
        }else{
            this.paymentModeValue = "Pay full amount in advance";
            this.partialAmountShow = false;
        }
        
    
      }
    },
    
    facilities() {
      axios
        .get("/api/getAccommodationFacilities/" + this.accommodationId)
        .then((response) => {
          this.generalobjects = response.data.data;
          this.generalobjects.forEach((item) => {
            if (item.ischeck == 1) {
              this.checkedFacilities.push(item.name + "|" + item.image);
            }
          });
        });
    },

    accommodationFacilityAdd() {
      let bodyFormData = new FormData();
      bodyFormData.append("checkedFacilities", this.checkedFacilities);
      bodyFormData.append("accommodation_id", this.accommodationId);

      axios
        .post("/api/accommodationFacilityAdd", bodyFormData)
        .then((response) => {
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
      bodyFormData.append("module", "accommodations");
      bodyFormData.append("module_id", this.accommodationId);
      axios.post("/api/uploadImages", bodyFormData).then((response) => {
        if (response.status == 200) {
          
          $('#normalImage').val('');
          this.accommodationGet();
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
        });;
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
            this.accommodationGet();
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
    getRules() {
      const params = "module_id="+this.accommodationId;
      axios
        .get("/api/getRules?module_name=accommodations&"+params)
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
          text: "Please Input Rule",
          timer: 2500,
        });
        return;
      }

      bodyFormData.append("module_id", this.accommodationId);
      bodyFormData.append("rule", this.rule_value);
      bodyFormData.append("module_name", 'accommodations');
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
    updateCancPolicy(e) {
      e.preventDefault();
      if (this.cancellationPolicy === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please Input Cancellation Policy",
          timer: 2500,
        });
        return;
      } 
      let bodyFormData = new FormData();
      bodyFormData.append("accommodation_id", this.accommodationId);
      bodyFormData.append("cancellation_policy", this.cancellationPolicy);
      axios.post("/api/accommodationUpdate", bodyFormData).then((response) => {
         this.accommodationGet();
        $("#cancelhead").modal("hide");
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
          text: "Please Input Important Info",
          timer: 2500,
        });
        return;
      } 
      let bodyFormData = new FormData();
      bodyFormData.append("accommodation_id", this.accommodationId);
      bodyFormData.append("important_info", this.importanInformation);
      axios.post("/api/accommodationUpdate", bodyFormData).then((response) => {
        $("#infohead").modal("hide");
        this.accommodationGet();
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
          text: "Please Input Title",
          timer: 2500,
        });
        return;
      }
      if (this.location == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please Input Location",
          timer: 2500,
        });
        return;
      }
      if (this.no_of_people === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please Input No Of Guest",
          timer: 2500,
        });
        return;
      }
      
      if (this.no_of_attach_bath === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please Input No Of Attach Bath",
          timer: 2500,
        });
        return;
      }
      if (this.no_of_share_bath ==="") {
        
          this.$swal({
          type: "error",
          title: "Error!",
          text: "Please Input No Of Share Bath",
          timer: 2500,
        });
        return;
      }
    
      let bodyFormData = new FormData();
      bodyFormData.append("accommodation_id", this.accommodationId);
      bodyFormData.append("title", this.title);
      bodyFormData.append("location", this.location);
      bodyFormData.append("isProperty", this.is_property);
      bodyFormData.append("no_of_attach_bath", this.no_of_attach_bath);
      bodyFormData.append("no_of_share_bath", this.no_of_share_bath);
      bodyFormData.append("noOfGuest", this.no_of_people);

      bodyFormData.append("country", this.country);
      bodyFormData.append("city", this.city);
      bodyFormData.append("latitude", this.latitude);
      bodyFormData.append("longitude", this.longitude);
      axios.post("/api/accommodationUpdate", bodyFormData).then((response) => {
      if (response.status == 200) {
          this.accommodationGet();
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
          this.accommodationGet();
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
      if (this.per_night === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input per night price",
          timer: 2500,
        });
        return;
      }  
      if (this.weeklyDiscount === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input weekly discount",
          timer: 2500,
        });
        return;
      }
      if (this.fifteenDayDiscount === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input fifteen days discount",
          timer: 2500,
        });
        return;
      }
      if (this.monthlyDiscount === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input monthly discount",
          timer: 2500,
        });
        return; 
      }
      if (this.partialAmountShow == true) {
       if (this.partialAmountVal == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input partial amount",
          timer: 2500,
        });
        return;
      }
      }
      if (this.breakfast_details == true) {
       if (this.breakfast_price === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input breakfast price",
          timer: 2500,
        });
        return;
      }
      if (this.breakfast_description == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input breakfast description",
          timer: 2500,
        });
        return;
      }
      }
      if (this.lunch_details == true) {
       if (this.lunch_price === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input lunch price",
          timer: 2500,
        });
        return;
      }
      if (this.lunch_description == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input lunch description",
          timer: 2500,
        });
        return;
      }
      }

      if (this.dinner_details == true) {
       if (this.dinner_price === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input dinner price",
          timer: 2500,
        });
        return;
      }
      if (this.dinner_description == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input dinner description",
          timer: 2500,
        });
        return;
      }
      }
      if (this.ageLimitForChild === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input age limit for child",
          timer: 2500,
        });
        return;
      }
      if (this.ageLimitFreeChild === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please input free child age",
          timer: 2500,
        });
        return;
      }
      if (this.checkInTime == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select check in time",
          timer: 2500,
        });
        return;
      }
      if (this.checkOutTime == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select check out time",
          timer: 2500,
        });   
        return;
      }
    
      var timeStart = new Date("01/01/2007 " + this.checkInTime).getHours();
      var timeEnd = new Date("01/01/2007 " + this.checkOutTime).getHours();
  
     if(timeEnd <= timeStart){
      this.$swal({
          type: "error",
          title: "Error!",
          text: "Check out time should be greater than check in time ",
          timer: 2500,
        });
        return;
     }
      
      let bodyFormData = new FormData();
      bodyFormData.append("accommodation_id", this.accommodationId);
      bodyFormData.append("per_night", this.per_night);
      bodyFormData.append("breakfast_included", this.breakfast_included);
      bodyFormData.append("lunch_included", this.lunch_included);
      bodyFormData.append("dinner_included", this.dinner_included);
      bodyFormData.append("weeklyDiscount", this.weeklyDiscount);
      bodyFormData.append("fifteenDayDiscount", this.fifteenDayDiscount);
      bodyFormData.append("monthlyDiscount", this.monthlyDiscount);
      bodyFormData.append("checkInTime", this.checkInTime);
      bodyFormData.append("checkOutTime", this.checkOutTime);
      bodyFormData.append("isFlexiableCheckIn", this.isFlexiableCheckIn);
      if (this.partialAmountShow == true) {
        bodyFormData.append("partialAmountVal", this.partialAmountVal);
      }
      if (this.breakfast_details == true) {
       bodyFormData.append("breakfast_price", this.breakfast_price);
       bodyFormData.append("breakfast_description", this.breakfast_description); 
       }
      
       if (this.lunch_details == true) {
       bodyFormData.append("lunch_price", this.lunch_price);
       bodyFormData.append("lunch_description", this.lunch_description); 
       }
       
       if (this.dinner_details == true) {
       bodyFormData.append("dinner_price", this.dinner_price);
       bodyFormData.append("dinner_description", this.dinner_description); 
       }
      bodyFormData.append(
        "isFlexiableCheckInValue",
        this.isFlexiableCheckInValue
      );
      bodyFormData.append("isEnquiry", this.isEnquiry);

      bodyFormData.append("isEnquiryValue", this.isEnquiryValue);
      bodyFormData.append("paymentMode", this.paymentMode);
      bodyFormData.append("ageLimitForChild", this.ageLimitForChild);
      bodyFormData.append("ageLimitFreeChild", this.ageLimitFreeChild);
      bodyFormData.append("childDiscount", this.childDiscount);
      bodyFormData.append("description", this.description);
      axios.post("/api/accommodationUpdate", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.accommodationGet();
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
          this.accommodationGet();
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
    
    custom_tags (obj) {
    if(obj.fieldName =="Belongings") {
    this.tags = obj.x; 
    }else{
     this.belongingtags = obj.x;
    }   
   
    },
     updatePersonelBelongings(e) {
      e.preventDefault();
  
      let bodyFormData = new FormData();
      bodyFormData.append("accommodation_id", this.accommodationId);
      bodyFormData.append("places_allow_for_use_guest",JSON.stringify(this.tags));
      bodyFormData.append("personal_belongings_assets", JSON.stringify(this.belongingtags));
      axios.post("/api/accommodationUpdate", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.accommodationGet();
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
          this.accommodationGet();
          //$("#editFeatures").modal("hide");
        }
      });
    },
  onChangebreakfast(event) {
      if (event.target.value == 'Yes') {
        this.breakfast_details = true;
      } else {
        this.breakfast_details = false;
      }
    }, 
  onChangelunch(event) {
      if (event.target.value == 'Yes') {
        this.lunch_details = true;
      } else {
        this.lunch_details = false;
      
      }
    },
onChangedinner(event) {
      if (event.target.value == 'Yes') {
        this.dinner_details = true;
      } else {
        this.dinner_details = false;
      }
    },
    
  },
};
</script>

<style scoped></style>

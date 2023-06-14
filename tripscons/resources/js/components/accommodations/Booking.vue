<template>

      <div class="invoice-box">
          <span v-if="message" class="booking-error text-warning">{{message}}</span>
              <div class="check-container mt-4">
                <div class="d-flex mt-3 justify-content-between">
                  <p class="pricepernight">
                    PKR {{ per_night }} <span>/ night</span>
                  </p>
                  <p class="check-container-right">
                    <span
                      ><img
                        src="/assets/img/icons/tgg.png"
                        width="30px"
                        height="22px"
                    /></span>
                    <span>discount for <br />long stays</span>
                  </p>
                </div>
                <div class="row">
                  <div class="col-6 col-sm-6 col-md-6">
                    <div class="checkinout">
                      <input
                        type="date"
                        v-model="start_date"
                        class="checkout"
                        placeholder="Check In"
                        @change="onChangedate($event)"
                       :min="oldDateDisabled"
                      />
                    </div>
                  </div>
                  <div class="col-6 col-sm-6 col-md-6">
                    <div class="checkinout">
                      <input
                        type="date"
                        v-model="end_date"
                        class="checkout"
                        placeholder="Check Out"
                        @change="onChangedate($event)"
                        :min="oldDateDisabled"
                      />
                    </div>
                  </div>
                </div>
                <div class="guest-toggle mt-4">
                  <a
                    href="#"
                    class="btn btn-filter"
                    id="dropdownMenuLink"
                    data-toggle="dropdown"
                    >Guests</a
                  >
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <strong>Guests</strong>
                    <div class="row mb-4">
                      <div class="col">
                        <div class="input-field">
                          <label class="guest-lable">Adults</label>
                          <small>Ages 13 or above</small>
                        </div>
                      </div>
                      <div class="col">
                        <div class="quantity buttons_added">
                          <input
                            type="button"
                            value="-"
                            class="minus"
                            @click="adultDecrement"
                            
                          />
                          <input
                            type="number"
                            step="1"
                            min="1"
                            title="Qty"
                            v-model="adultGuest"
                            size="4"
                            pattern=""
                            inputmode=""
                            class="input-text qty text"
                          />
                          <input
                            type="button"
                            value="+"
                            class="plus"
                            @click="adultIncrement"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col">
                        <div class="input-field">
                          <label class="guest-lable">Childs</label>
                          <small>Ages Below 13</small>
                        </div>
                      </div>
                      <div class="col">
                        <div class="quantity buttons_added">
                          <input
                            type="button"
                            value="-"
                            class="minus"
                            @click="childDecrement"
                          />
                          <input
                            type="number"
                            step="1"
                            v-model="childGuest"
                            min="0"
                            max=""
                            name="quantity"
                            title="Qty"
                            class="input-text qty text"
                            size="4"
                            pattern=""
                            inputmode=""
                          />
                          <input
                            type="button"
                            value="+"
                            class="plus"
                            @click="childIncrement"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="total-invoice">
                  <div
                    class="charges-section mt-3 d-flex justify-content-between"
                  >
                    <p class="service">
                      PKR {{ per_night }} x {{ nights }} night
                    </p>
                    <p class="charges">PKR {{ sub_total }}</p>
                  </div>
                  <div
                    class="charges-section d-flex justify-content-between"
                    v-if="service_fee_show"
                  >
                    <p class="service">Service fee</p>
                    <p class="charges">PKR {{ service_fee }}</p>
                  </div>
                  <div
                    class="charges-section d-flex justify-content-between"
                    v-if="cleaning_fee_show"
                  >
                    <p class="service">Cleaning fee</p>
                    <p class="charges">PKR {{ cleaning_fee }}</p>
                  </div>

                  <hr class="charges-line" />
                  
                  <div class="check-guest mt-4">
                    <label class="switch">
                      <input
                        type="checkbox"
                        v-model="breakfast_included"
                        @change="onChangedate($event)"
                      />
                      <span class="slider round"></span>
                    </label>
                    <span class="ml-2">Include Breakfast</span>
                  </div>
                  <span v-show="breakfast_included">
                    
                  {{ breakfast_price }}
                  </br>
                  <span>{{accommodation.breakfast_description}}</span>
                </span>
                 
                  <div class="check-guest mt-4">
                    <label class="switch">
                      <input
                        type="checkbox"
                        v-model="lunch_included"
                        @change="onChangedate($event)"
                      />
                      <span class="slider round"></span>
                    </label>
                    <span class="ml-2">Include Lunch</span>
                  </div>
                  <span v-show="lunch_included">{{ lunch_price }}
                    <br>
                    <span>{{accommodation.lunch_description}}</span>
                  </span>
                  
                  <div class="check-guest mt-4">
                    <label class="switch">
                      <input
                        type="checkbox"
                        v-model="dinner_included"
                        @change="onChangedate($event)"
                      />
                      <span class="slider round"></span>
                    </label>
                    <span class="ml-2">Include Dinner</span>
                  </div>
                  <span v-show="dinner_included">{{ dinner_price }}
                    <br>
                    <span>{{accommodation.dinner_description}}</span>
                  </span>
                  <div class="charges-section d-flex justify-content-between">
                    <p class="services service-total">Total</p>
                    <p class="charges charges-total">PKR {{ total }}</p>
                  </div>
                  <div
                    class="charges-section d-flex justify-content-between"
                    v-if="discount_show"
                  >
                    <p class="services service-total">Discount</p>
                    <p class="charges charges-total">PKR {{ discount }}</p>
                  </div>
                  <div class="charges-section d-flex justify-content-between">
                    <p class="services service-total">Grand Total</p>
                    <p class="charges charges-total">PKR {{ grand_total }}</p>
                  </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                  <button
                    :disabled="isDisabled"
                    id="btn-reserve"
                    type="button"
                    class="btn btn-reserve"
                    @click="reservebooking"
                  >
                    Reserve now!
                  </button>
                </div>
              </div>
            </div>
</template>
<script>
import VueTimepicker from "vue2-timepicker/src/vue-timepicker.vue";
export default {
  mode: 'history',
  name: "vehicleBooking",
  props:['accommodation'],
  data() {
    return {
      dinner_included: false,
      lunch_included: false,
      breakfast_included: false,
      service_fee_show: true,
      cleaning_fee_show: true,
      discount_show: false,
      nights: 1,
      per_night: "",
      cleaning_fee: "",
      service_fee: "",
      breakfast_price: "",
      lunch_price: "",
      dinner_price: "",
      total: "",
      sub_total: "",
      discount: "",
      grand_total: "",
      start_date: "",
      end_date: "",
      isDisabled: false,
      adultGuest: 1,
      childGuest: 0,
      accommodationId: this.$route.params.accommodationId,
      message:'',
           
    };
  },
  components: {
    VueTimepicker,
  },
  created() {
    this.start_date = this.$helpers.defaultStartDate();
    this.end_date = this.$helpers.defaultEndDate();
    this.onChangedate();
   },
   computed:{
    
   oldDateDisabled(){
     return this.$helpers.oldDateDisabled();
    }
  },
  methods: {
   onChangedate(event) {
      let start_date = new Date(this.start_date);
      let end_date = new Date(this.end_date);
      let Difference_In_Time = end_date.getTime() - start_date.getTime();
      if (Difference_In_Time <= 0) {
      this.message = "Please input valid date";
      return;
      }
      this.message = '';
      let bodyFormData = new FormData();
      bodyFormData.append("module_id", this.accommodationId);
      bodyFormData.append("start_date", this.start_date);
      bodyFormData.append("end_date", this.end_date);
      bodyFormData.append("breakfast_included", this.breakfast_included);
      bodyFormData.append("lunch_included", this.lunch_included);
      bodyFormData.append("dinner_included", this.dinner_included);
      bodyFormData.append("module_name", 'accommodations');
      if (
        this.start_date != "" &&
        this.end_date != "" &&
        this.start_date != undefined &&
        this.end_date != undefined
      ) {
        axios.post("/api/checkAccommodationAvailability", bodyFormData).then((response) => {
          if (response.status == 200) {
            
            if (response.data.data.availability == true) {
              // console.log(response.data.data.availability);
              this.isDisabled = false;
              if(localStorage.getItem('type') == '2' || localStorage.getItem('type') == '1'){
               this.isDisabled = true;
               
              }
              if (response.data.data.cleaning_fee == "0.00") {
                this.cleaning_fee_show = false;
              } else {
                this.cleaning_fee_show = true;
              }

              if (response.data.data.service_fee == "0.00") {
                this.service_fee_show = false;
              } else {
                this.service_fee_show = true;
              }

              if (response.data.data.discount == "0.00") {
                this.discount_show = false;
              } else {
                this.discount_show = true;
              }
              this.nights = response.data.data.nights;
              this.per_night = response.data.data.per_night;
              this.cleaning_fee = response.data.data.cleaning_fee;
              this.service_fee = response.data.data.service_fee;
              this.breakfast_price = response.data.data.breakfast_price;
              this.lunch_price = response.data.data.lunch_price;
              this.dinner_price = response.data.data.dinner_price;
              this.total = response.data.data.total;
              this.sub_total = response.data.data.sub_total;
              this.discount = response.data.data.discount;
              this.grand_total = response.data.data.grand_total;
              localStorage.setItem("serviceid", this.accommodationId);
              localStorage.setItem("start_date", this.start_date);
              localStorage.setItem("end_date", this.end_date);

            } else {
              this.message = response.data.message;
              this.isDisabled = true;
              return;
            }
        }
        }).catch((err) => {
        this.message = err.response.data.message;
        this.isDisabled = false;
        return ;
        });
      }
    },
    reservebooking() {
       if (!localStorage.getItem('user-token')) {
       localStorage.setItem('coming-location', 'booking');
       $('#loginmodal').modal('toggle');
       return;
      }
      let bodyFormData = new FormData();
      this.isDisabled = true;
      bodyFormData.append("module_name", "accommodations");
      bodyFormData.append("module_id", this.accommodationId);
      bodyFormData.append("start_date", this.start_date);
      bodyFormData.append("end_date", this.end_date);
      bodyFormData.append("no_of_adults", this.adultGuest);
      bodyFormData.append("no_of_childs", this.childGuest);
      bodyFormData.append("breakfast_included", this.breakfast_included);
      bodyFormData.append("lunch_included", this.lunch_included);
      bodyFormData.append("dinner_included", this.dinner_included);
      axios.post("/api/createAccommodationBooking", bodyFormData,this.$helpers.userAuth()).then((response) => {  
      if(response.status == 200) {
       localStorage.setItem("booking_id", response.data.data.booking_id);
       this.$router.push({ path: "/bookings/accommodation-summary" });
      }
      }).catch((err) => {
         this.message = err.response.data.message;
         this.isDisabled = false;
         return false;
        });
   
    },
    adultIncrement() {
      this.adultGuest++;
    },
    adultDecrement() {
      if (this.adultGuest > 1) {
        this.adultGuest--;
      }
    },
    childIncrement() {
      this.childGuest++;
    },
    childDecrement() {
      if (this.childGuest > 0) {
        this.childGuest--;
      }
    },
  
  },
  
  watch:{
   $route : 'updateId'
  }
};
</script>
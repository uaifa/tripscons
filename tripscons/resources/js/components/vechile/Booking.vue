<template>
     <div class="invoice-box">
     <span v-if="message" class="booking-error text-warning">{{message}}</span>  
              <div class="check-container mt-4">
                <div class="custom-title">
                  <h2>Booking type</h2>
                </div>

                <div class="form-group mt-2">
                  <select id="booking-type" class="form-control input_field" @change="changeBookingType" v-model="bookingType">
                    
                    <option value="Per day">Per day</option>
                    <option value="Hourly">Hourly</option>
                  </select>
                </div>

                <div class="mt-3" v-show="isDatePicker">
                  
                  <input
                    type="text"
                    class="form-control input_field"
                    onfocus="(this.type='date')"
                    onblur="(this.type='text')"
                    placeholder="Pickup date"
                    v-model="start_date"
                    :min="oldDateDisabled"
                    @change="onChangedate($event)"
                  />
                  <div v-show="isEndDate" class="mt-3">
                    <input
                      type="text"
                      class="form-control input_field"
                      onfocus="(this.type='date')"
                      onblur="(this.type='text')"
                      placeholder="drop off date"
                      v-model="end_date"
                      :min="oldDateDisabled"
                      @change="onChangedate($event)"
                    />
                       </div>
                
                </div>
              
                 <div class=" mt-3" v-show="isTimePicker">
                 <vue-timepicker
                v-model="start_time"
                class="form-control input_field"
                 @change="onChangedate($event)"></vue-timepicker>
                 <vue-timepicker
                v-model="end_time"
                class="form-control input_field mt-3"
                @change="onChangedate($event)"></vue-timepicker>
                </div>
               

                <div class="total-invoice">
                  <div
                    class="charges-section mt-3 d-flex justify-content-between"
                  >
                    <p class="service">PKR {{ per_day_price }} x {{ nights }} </p>
                   
                    <p class="charges">PKR {{ sub_total }}</p>
                  </div>
                  

                  <hr class="charges-line" />
                  <div class="charges-section d-flex justify-content-between">
                    <p class="services service-total">Total</p>
                    <p class="charges charges-total">PKR {{ total }}</p>
                  </div>
                   <div class="charges-section d-flex justify-content-between">
                    <p class="services service-total">Grand Total</p>
                    <p class="charges charges-total">PKR {{ grand_total }}</p>
                  </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                  <button type="button" class="btn btn-reserve"  @click="reservebooking" :disabled="isDisabled">
                    Book now!
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
  data() {
    return {
      start_time: "00:00:00",
      end_time: "00:00:00",
      isTimePicker:false,
      isDatePicker:true,
      isEndDate:true,
      bookingType:'Per day',
      start_date:'',
      end_date:'',
      message:'',
      nights:'',
      per_day_price:'',
      grand_total:'',
      sub_total:'',
      total:'',
      vechileId: this.$route.params.vechileId,
      isDisabled: false,
      st_dateTime:'',
      end_dateTime:'',
           
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
      
      if(this.bookingType =='Hourly'){
        if(this.start_time.length == 5){
        this.start_time = this.start_time+':00';
        }
      if(this.end_time.length == 5){
       this.end_time = this.end_time+':00';
      }
      
      let start_date = new Date(this.start_date+' '+this.start_time);
      let end_date = new Date(this.start_date+' '+this.end_time);
      let Difference_In_Time = end_date.getTime() - start_date.getTime();
      this.end_date = this.start_date;
     
      if (Difference_In_Time <= 0) {
      this.message = "Please input valid hours";
      this.isDisabled = true;
      return;
      }
    }else{
      let start_date = new Date(this.start_date);
      let end_date = new Date(this.end_date);
      let Difference_In_Time = end_date.getTime() - start_date.getTime();
      if (Difference_In_Time <= 0) {
      this.message = "Please input valid date";
      this.isDisabled = true;
      return;
      }
}

      
      this.st_dateTime = this.start_date+' '+this.start_time;
      this.end_dateTime = this.end_date+' '+this.end_time;
      
      this.message = '';
      let bodyFormData = new FormData();
      bodyFormData.append("module_id", this.vechileId);
      bodyFormData.append("module_name", "transports");
      bodyFormData.append("start_date", this.st_dateTime);
      bodyFormData.append("end_date", this.end_dateTime);
      bodyFormData.append("booking_type", this.bookingType);
      bodyFormData.append("airport_pick_drop", false);
      if (
        this.start_date != "" &&
        this.end_date != "" &&
        this.start_date != undefined &&
        this.end_date != undefined
      ) {
        axios.post("/api/checkVehicleAvailability", bodyFormData).then((response) => {
          if (response.status == 200) {
            if (response.data.data.availability == true) {
              this.isDisabled = false;
              if(localStorage.getItem('type') == '2' || localStorage.getItem('type') == '1'){
               this.isDisabled = true;
              }
              //console.log(response.data); 
              if(this.bookingType =='Hourly'){
              this.per_day_price = response.data.data.hourly_price;
              //per day price variable same for real time change better will be later 
              this.nights = response.data.data.Hours; //same this one dynamically represent hours 
              }else{
              this.nights = response.data.data.nights;
              this.per_day_price = response.data.data.per_day_price;
              }
              this.total = response.data.data.total;
              this.sub_total = response.data.data.sub_total;
              this.grand_total = response.data.data.grand_total;
              localStorage.setItem("serviceid", this.vechileId);
              
            } else {
              this.message = response.data.message;
              this.isDisabled = true;
              return;
            }
        }
        }).catch((err) => {
        this.message = err.response.data.message;
        this.isDisabled = false;
        return;
        });
      }
    },
    
    changeBookingType() {
    
    if(this.bookingType =='Per day'){
      this.isTimePicker = false;
      this.isDatePicker = true; 
      this.isEndDate = true; 
      this.onChangedate();
    }else{
      this.isTimePicker = true;
      this.isDatePicker = true;  
      this.isEndDate = false; 
      this.onChangedate();
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
      bodyFormData.append("module_name", "transports");
      bodyFormData.append("module_id", this.vechileId);
      bodyFormData.append("start_date", this.st_dateTime);
      bodyFormData.append("end_date", this.end_dateTime); 
      bodyFormData.append("booking_type", this.bookingType);
      bodyFormData.append("airport_pick_drop", false);
      axios.post("/api/createVehicleBooking", bodyFormData,this.$helpers.userAuth()).then((response) => {
      if(response.status == 200) {
      localStorage.setItem("booking_id", response.data.data.booking_id);
      this.$router.push({ path: "/bookings/vehicle-summary" });
      }
      }).catch((err) => {
        this.message = err.response.data.message;
        this.isDisabled = true;
        return;
        });
   
    },
  },
  
  watch:{
   $route : 'updateId'
  }
};
</script>
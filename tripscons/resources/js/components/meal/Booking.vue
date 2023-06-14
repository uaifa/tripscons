<template>
     <div class="invoice-box">
          <span v-if="message" class="booking-error text-warning">{{message}}</span>
              <div class="check-container mt-4">
                <div class="custom-title">
                  <h2>{{title}}</h2>
                  <p style="margin-top: -10px">
                    ({{des}})
                  </p>
                </div>
                 <span>{{unit}}</span>
                <div class="input-wrapper mt-3">
                  <span class="food-quantity">Quantity</span>
                  <input type="number" v-model="qty" @keyup="onChangQty">
                </div>
                  <div class="mt-3">
                  
                  <input
                    type="text"
                    class="form-control input_field"
                    onfocus="(this.type='date')"
                    onblur="(this.type='text')"
                    placeholder="Pickup date"
                    v-model="requiredDate"
                    :min="oldDateDisabled"
                    
                  />
                 </div>
              
                 <div class=" mt-3">
                 <vue-timepicker
                v-model="requiredTime"
                class="form-control input_field mt-3"
                ></vue-timepicker>
              
                </div>
                <div class="total-invoice">
                  <div
                    class="charges-section mt-3 d-flex justify-content-between"
                  >
                    <p class="service">Rs.{{per_item}} x {{qty}}</p>
                    <p class="charges">Rs.{{sub_total}}</p>
                  </div>

                  <hr class="charges-line" />
                  <div class="charges-section d-flex justify-content-between">
                    <p class="services service-total">Total</p>
                    <p class="charges charges-total">Rs.{{total}}</p>
                  </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                   <button type="button" class="btn btn-reserve" :disabled="isDisabled" @click="reservebooking">
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
  props:['title','des','unit'],
  data() {
    return {
      qty: 1,
      per_item: "",
      total: "",
      sub_total: "",
      discount: "",
      grand_total: "",
      isDisabled: false,
      mealId: this.$route.params.mealId,
      message:'',
      requiredDate:'',
      requiredTime:"00:00:00",
     
      
    };
  },
  
  created() {
    this.requiredDate = this.$helpers.defaultStartDate();
    this.onChangQty();
   },
   computed:{
    
   oldDateDisabled(){
     return this.$helpers.oldDateDisabled();
    }
  },
  methods: {
   onChangQty() {
      
       if(this.qty == ""){
        this.message = "Please input qty";
        this.isDisabled = true;
        return;
       }
       if(this.qty <= 0){
        this.message = "Please input valid qty";
        this.isDisabled = true;
        return;
       }
       if (this.requiredDate == "" ||  this.requiredDate == undefined){
        this.message = "Please input valid date";
        this.isDisabled = true;
        return;
      }
      if (this.requiredTime == "" ||  this.requiredTime == undefined){
        this.message = "Please input valid time";
        this.isDisabled = true;
        return;
      }
      
      this.message = '';
      this.isDisabled = false;
      let bodyFormData = new FormData();
      bodyFormData.append("module_id", this.mealId);
      bodyFormData.append("module_name", 'meals');
      bodyFormData.append("qty", this.qty);
      axios.post("/api/checkMealAvailability", bodyFormData).then((response) => {
          if (response.status == 200) {
            if (response.data.data.availability == true) {
              
              this.qty = response.data.data.qty;
              this.per_item = response.data.data.per_item;
              this.total = response.data.data.total;
              this.sub_total = response.data.data.sub_total;
              this.discount = response.data.data.discount;
              this.grand_total = response.data.data.grand_total;
              localStorage.setItem("serviceid", this.mealId);
              this.isDisabled = false;
              if(localStorage.getItem('type') == '2' || localStorage.getItem('type') == '1'){
               this.isDisabled = true;
              }
            } else {
              this.message = response.data.message;
              this.isDisabled = true;
              return;
            }
        }
        }).catch((err) => {
        this.message = err.response.data.message;
        this.isDisabled = true;
        return;
        });
     
    },
    
    
    reservebooking() {  
    if (!localStorage.getItem('user-token')) {
       localStorage.setItem('coming-location', 'booking');
       $('#loginmodal').modal('toggle');
       return;
      }
      
       
      let bodyFormData = new FormData();
      this.isDisabled = true;
      bodyFormData.append("module_name", "meals");
      bodyFormData.append("module_id", this.mealId);
      bodyFormData.append("qty", this.qty);
      bodyFormData.append("require_date", this.requiredDate);
      bodyFormData.append("require_time", this.requiredTime);
      axios.post("/api/createMealBooking", bodyFormData,this.$helpers.userAuth()).then((response) => {
      if(response.status == 200) {
       localStorage.setItem("booking_id", response.data.data.booking_id);
       this.$router.push({ path: "/bookings/meal-summary" });
      }
      }).catch((err) => {
        this.message = err.response.data.message;
        this.isDisabled = true;
        return;
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
   
  },
   components: {
    VueTimepicker,
   
  },
  watch:{
   $route : 'updateId'
  }
};
</script>
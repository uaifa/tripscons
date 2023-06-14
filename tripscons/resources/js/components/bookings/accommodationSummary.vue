<template>
  <main>
    <div class="container">
      <div class="country-banners-sec">
        <div class="booking-wrapper">
          <h4>Booking Summary</h4>
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="booking-details">
                <h2 class="booking-item-title">
                  {{ title }}
                </h2>
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-price">
                    Price
                  </span>
                  <span class="booking-price">
                   PKR {{ per_night }} / night
                  </span>
                </div>
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-value">
                    {{ type_name }}
                  </span>
                  <span class="booking-item-value">
                    {{ city }},
                    {{ country }}
                  </span>
                </div>
                <div class="d-flex cbrudcrumss mt-2">
                  <ul>
                    <li>
                      {{ no_of_people }}
                      guests/
                    </li>
                    <li>
                      {{ no_of_rooms }}
                      bedrooms/
                    </li>
                    <li>
                      {{ no_of_attach_bath }}
                      baths
                    </li>
                  </ul>
                </div>
                <div><ul>
                    <li>
                      No of adults :
                      {{ no_of_adults }}
                      
                    </li>
                    <li>
                       No of childs:
                      {{ no_of_childs }}
                     
                    </li>
                   
                  </ul></div>
              </div>
              <div class="booking-details">
                <div class="image-sction px-2">
                  <div class="image-section-left">
                    <div class="img-container">
                      <div class="img-holder" v-if="userObj.image != null">
                        <img
                          :src="'/assets/uploads/users/' + userObj.image"
                          alt="Host"
                        />
                      </div>
                      <div class="img-holder" v-else>
                        <img
                          :src="$imagePath + 'not-available.png'"
                          alt="Host"
                        />
                      </div>
                      <span class="user-status"></span>
                    </div>
                  </div>
                  <div class="image-section-right ml-3">
                    <div class="profile-bio profile-bioo">
                      <h2 class="company-title">
                        {{ userObj.name }}
                      </h2>

                      <p>
                        Member since
                        {{ userObj.created_at | formatDate }}
                      </p>
                    </div>
                  </div>
                </div>

                <div class="company-profile-details mt-3">
                  <p class="title-bold">
                    Address:
                    <span>{{ userObj.address }} </span>
                  </p>
                  <p class="guide-verified title-bold">
                    Phone number:
                    <span>{{ userObj.phone }}</span>
                    <img
                      src="/assets/img/icons/verified.png"
                      width="24px"
                      alt=""
                      srcset=""
                    />
                  </p>
                  <p class="guide-verified title-bold">
                    ID:
                    <span v-if="userObj.is_profile_complete != 0"
                      >Verified</span
                    >
                    <span v-else>Not Verified</span>
                  </p>

                  <!-- <p class="company-license title-bold">
                    Registration number:
                    <span>0123456</span>
                  </p> -->
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="booking-details">
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> Start date </span>
                  <span class="booking-item-value"> {{start_date | formatDate}}</span>
                   <!-- | formatDate -->
                </div> 
                <div class="d-flex booking-details-data mt-3">  
                  <span class="booking-item-key"> End Date </span>
                  <span class="booking-item-value"> {{end_date | formatDate}} </span>
                </div>

                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> SubTotal </span>
                  <span class="booking-item-value"> PKR {{ sub_total }} </span>
                </div>
                <!-- <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key">
                    Meals included
                  </span>
                  <span class="booking-item-value">
                    No
                 </span>
                </div> -->
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> Service fee </span>
                  <span class="booking-item-value">
                    PKR {{ service_fee }}
                  </span>
                </div>
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> Cleaning fee </span>
                  <span class="booking-item-value">
                    PKR {{ cleaning_fee }}
                  </span>
                </div>
                <div class="d-flex booking-details-data mt-3" v-if="breakfast_price !='0.00'">
                  <span class="booking-item-key"> BreakFast </span>
                  <span class="booking-item-value">
                    PKR {{ breakfast_price }}
                  </span>
                </div>
                <div class="d-flex booking-details-data mt-3" v-if="lunch_price !='0.00'">
                  <span class="booking-item-key"> Lunch </span>
                  <span class="booking-item-value">
                    PKR {{ lunch_price }}
                  </span>
                </div>
                <div class="d-flex booking-details-data mt-3" v-if="dinner_price !='0.00'">
                  <span class="booking-item-key"> Dinner </span>
                  <span class="booking-item-value">
                    PKR {{ dinner_price }}
                  </span>
                </div>
                <hr class="charges-line" />
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> Total </span>
                  <span class="booking-item-value"> PKR {{ total }} </span>
                </div>
                <hr class="charges-line" />
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> Discount </span>
                  <span class="booking-item-value"> PKR {{ discount }} </span>
                </div>
          
                <hr class="charges-line" />
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> Grand Total </span>
                  <span class="booking-item-value">
                    PKR {{ grand_total }}
                  </span>
                </div>
                 <hr class="charges-line" v-if="partial_amt > 0" />
                <div class="d-flex booking-details-data mt-3" v-if="partial_amt > 0">
                  <span class="booking-item-key"> Partial Amount </span>
                  <span class="booking-item-value">
                    PKR {{ partial_amt.toFixed(2) }} ({{partial_amt_in_percentage}}%)
                  </span>
                </div>
                <hr class="charges-line" v-if="remaining_amt > 0"/>
                <div class="d-flex booking-details-data mt-3" v-if="remaining_amt > 0">
                  <span class="booking-item-key"> Remaing Amount (Pay will be later) </span>
                  <span class="booking-item-value">
                    PKR {{ remaining_amt.toFixed(2) }} 
                  </span>
                </div>
              </div>
              <div class="d-flex justify-content-end">
                
                <button
                   @click="moveToCheckOut" class="btn btn-whitee mt-3" :disabled="isDisabled"
                  >
                     Pay Now
                  </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<script>
export default {
  name: "AccommodationDetail",
  data() {
    return {
      detailData: "",
      userObj: "",
      cart: "",
      accommodationId: "",
      start_date: "",
      end_date: "",
      nights: "",
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
      isDisabled: false,
      title:'', per_night:'', type_name:'', city:'', country:'', no_of_people:'', no_of_rooms:'', no_of_attach_bath:'',
      bookingDetailObj:'',
      no_of_childs:0,
      no_of_adults:0,
      partial_amt:0,
      remaining_amt:0,
      partial_amt_in_percentage:0,
      payment_mode:'',
    };
  },
  created() {
    this.booking_id = localStorage.getItem("booking_id");
    
    let bodyFormData = new FormData();
    bodyFormData.append("booking_id", this.booking_id);
    axios
        .post("/api/getBookingDetail",bodyFormData)
        .then((response) => {
            this.detailData = response.data.data;
            this.bookingDetailObj =  response.data.data.accommodation_booking_detail;
            this.no_of_adults = this.bookingDetailObj.no_of_adults;
            this.no_of_childs = this.bookingDetailObj.no_of_childs;
            
            this.start_date =  this.detailData.start_date;
            this.end_date =    this.detailData.end_date;
            this.nights = this.detailData.no_of_nights;
            this.per_night = this.detailData.price.toFixed(2);
            this.sub_total = this.detailData.sub_total.toFixed(2);
            this.total = this.detailData.total.toFixed(2);
            this.grand_total = this.detailData.grand_total.toFixed(2);
            //this.booking_type  = this.detailData.vehicle_booking_detail.booking_type;
            this.cleaning_fee = this.detailData.accommodation_booking_detail.cleaning_fee.toFixed(2);
            this.service_fee = this.detailData.accommodation_booking_detail.service_fee.toFixed(2);
            this.breakfast_price = this.detailData.accommodation_booking_detail.breakfast_price.toFixed(2);
            this.lunch_price = this.detailData.accommodation_booking_detail.lunch_price.toFixed(2);
            this.dinner_price = this.detailData.accommodation_booking_detail.dinner_price.toFixed(2);
            this.discount = this.detailData.discount.toFixed(2);
            this.userObj = this.detailData.provider;
            this.title = this.detailData.accommodation.title;
            this.per_night= this.detailData.accommodation.per_night.toFixed(2);
            this.type_name=  this.detailData.accommodation.type_name;
            this.city=this.detailData.accommodation.city;
            this.country=this.detailData.accommodation.country;
            this.no_of_people=this.detailData.accommodation.no_of_people;
            this.no_of_rooms=this.detailData.accommodation.no_of_rooms;
            this.no_of_attach_bath=this.detailData.accommodation.no_of_attach_bath;
            this.payment_mode = this.detailData.accommodation.payment_mode;
            if(this.detailData.partial_amt > 0){
            this.partial_amt = this.detailData.partial_amt;
            this.partial_amt_in_percentage = this.detailData.partial_amt_in_percentage;
            this.remaining_amt  = this.grand_total - this.partial_amt ;
            } 
          
        }).catch((err) => {
        this.message = err.response.data.message;
        this.isDisabled = true;
        return;
        });

  },

  methods: {
  moveToCheckOut() {
             
         this.$router.push({ path: "/bookings/checkout" });
      // if(this.payment_mode == 0) {
      //  this.$router.push({ path: "/bookings/thankyou" }); 
      // }else{
      //  this.$router.push({ path: "/bookings/checkout" });
      // }
      
      
    },
  },
};
</script>
<style scoped></style>

<template>
  <main>
    <div class="container">
      <div class="country-banners-sec">
        <div class="booking-wrapper">
          <h4>Booking Summary</h4>
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="booking-details">
               
                  <div class="d-flex booking-details-data mt-3">
                  <span class="booking-price">
                    PKR {{ per_head }} 
                  </span>
                   <span class="booking-price">
                   Adults  {{ no_of_adults }} 
                  </span>
                   <span class="booking-price">
                    Childs {{ no_of_childs }} 
                  </span>
                   
                </div>
                <div class="d-flex booking-details-data mt-3">
              
                 
                </div>
                <div class="d-flex cbrudcrumss mt-2">
                  <ul>
                  
                   
                  </ul>
                </div>
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
                  <span class="booking-item-key"> Price </span>
                  <span class="booking-item-value"> PKR {{ per_head }} </span>
                  <span class="booking-item-value"> {{ qty}} </span>
                </div>
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> SubTotal </span>
                  <span class="booking-item-value"> PKR {{ sub_total }} </span>
                </div>
               
                <hr class="charges-line" />
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> Total </span>
                  <span class="booking-item-value"> PKR {{ total }} </span>
                </div>
                
                <hr class="charges-line" />
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> Grand Total </span>
                  <span class="booking-item-value">
                    PKR {{ grand_total }}
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
  name: "experienceBookingDetail",
  data() {
    return {
      detailData: "",
      userObj: "",
      qty: "",
      per_head: "",
      no_of_adults: "",
      no_of_childs: "",
      total: "",
      sub_total: "",
      grand_total: "",
      isDisabled: false,
      booking_id:'',
      experienceId:'',
     
       
    };
  },
  created() {
      
    this.booking_id = localStorage.getItem("booking_id");
    this.experienceId =  localStorage.getItem("serviceid");
    let bodyFormData = new FormData();
    bodyFormData.append("booking_id", this.booking_id);
    bodyFormData.append("module_name", "experiences");     
    axios
        .post("/api/getBookingDetail",bodyFormData)
        .then((response) => {

            this.detailData = response.data.data;
           
             console.log(this.detailData);
            this.qty = this.detailData.no_of_nights;
            this.per_head = this.detailData.price;
            this.sub_total = this.detailData.sub_total;
            this.total = this.detailData.total;
            this.grand_total = this.detailData.grand_total;
           // this.unit  = this.detailData.meal_booking_detail.unit;
            this.userObj = this.detailData.provider;
            this.no_of_childs = this.detailData.experience_booking_detail.no_of_childs;
            this.no_of_adults =  this.detailData.experience_booking_detail.no_of_adults;
           
        }).catch((err) => {
        this.message = err.response.data.message;
        this.isDisabled = true;
        return;
        });
    
    
  },

  methods: {
  moveToCheckOut() {
      this.$router.push({ path: "/bookings/checkout" });
      
    },
  },
};
</script>
<style scoped></style>

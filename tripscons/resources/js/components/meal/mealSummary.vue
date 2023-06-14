<template>
  <main>
    <div class="container">
      <div class="country-banners-sec">
        <div class="booking-wrapper">
          <h4>Booking Summary</h4>
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="booking-details">
                <h5 class="booking-item-title">
                  {{ title }}
                </h5>
                <h5 class="booking-item-title">
                  {{ description }}
                </h5>
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-price">
                    PKR {{ per_item }} 
                  </span>
                   <span class="booking-item-value">
                    {{ city }},
                    {{ country }}
                  </span>
                </div>
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-value">
                    {{ brand }}
                  </span>
                 
                </div>
                <div class="d-flex cbrudcrumss mt-2">
                  <ul>
                    <li>
                    Unit:  {{ unit }} 
                      
                    </li>
                   
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

                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="booking-details">
               
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> Unit </span>
                  <span class="booking-item-value">  {{ unit }} </span>
                </div>
                 <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> Price </span>
                  <span class="booking-item-value"> PKR {{ per_item }} </span>
                  <span class="booking-item-value"> Qty </span>
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
  name: "mealBookingDetail",
  data() {
    return {
      detailData: "",
      userObj: "",
      qty: "",
      end_date: "",
      per_item: "",
      total: "",
      sub_total: "",
      grand_total: "",
      isDisabled: false,
      booking_id:'',
      mealId:'',
      unit:'',
      title:'',
      description:'',
      city:'',
      country:'',
       
    };
  },
  created() {
      
    this.booking_id = localStorage.getItem("booking_id");
    this.mealId =  localStorage.getItem("serviceid");
    let bodyFormData = new FormData();
    bodyFormData.append("booking_id", this.booking_id);
    bodyFormData.append("module_name", "meals");
    axios
        .post("/api/getBookingDetail",bodyFormData)
        .then((response) => {
            this.detailData = response.data.data;
            this.qty = this.detailData.no_of_nights;
            this.per_item = this.detailData.price;
            this.sub_total = this.detailData.sub_total;
            this.total = this.detailData.total;
            this.grand_total = this.detailData.grand_total;
            this.unit  = this.detailData.meal_booking_detail.unit;
            this.userObj = this.detailData.provider;
            this.title = this.detailData.meal.title;
            this.description =  this.detailData.meal.description;
            this.brand =  this.detailData.meal.brand;
            this.city = this.detailData.meal.city;
            this.country = this.detailData.meal.country;
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

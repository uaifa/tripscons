<template>
      <div class="invoice-box">
              <div class="check-container mt-4">
                <p class="price-perperson">PKR {{price}} per person</p>
                <div class="form-group mt-2">
                  <input
                    class="form-control input_field"
                    type="text"
                    :placeholder=date
                    disabled
                  />
                </div>
                <div class="form-group mt-2">
                  <input
                    class="form-control input_field"
                    type="number"
                    placeholder="Number of adults"
                    v-model="no_of_adults"/>
                  <input
                    class="form-control input_field"
                    type="number"
                    placeholder="Number of childs" 
                    v-model="no_of_childs"
                   />
                </div>
                <!-- <div class="d-flex justify-content-center mt-3">
                  <button
                    type="button"
                    class="btn btn-whitee"
                    data-toggle="modal"
                    data-target="#recipies"
                  >
                    Plesae provide other members details
                  </button>
                  <div
                    class="modal fade"
                    id="recipies"
                    role="dialog"
                    aria-labelledby="recipieslLabel"
                    aria-hidden="true"
                  >
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content pb-5">
                        <div class="modal-body">
                          <div class="member-wrapper">
                            <div class="member-item mt-4">
                              <div class="member-name">
                                <input
                                  type="text"
                                  class="form-control input_field"
                                  placeholder="Name"
                                />
                              </div>
                              <div class="member-gender">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option selected>Gender</option>
                                  <option value="male">Male</option>
                                  <option value="female">Feale</option>
                                </select>
                              </div>
                              <div class="member-email">
                                <input
                                  type="email"
                                  class="form-control input_field"
                                  placeholder="email"
                                />
                              </div>
                              <div class="member-status">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option value="adult" selected>Adult</option>
                                  <option value="child">Child</option>
                                </select>
                              </div>
                            </div>
                            <div class="member-item mt-4">
                              <div class="member-name">
                                <input
                                  type="text"
                                  class="form-control input_field"
                                  placeholder="Name"
                                />
                              </div>
                              <div class="member-gender">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option selected>Gender</option>
                                  <option value="male">Male</option>
                                  <option value="female">Feale</option>
                                </select>
                              </div>
                              <div class="member-email">
                                <input
                                  type="email"
                                  class="form-control input_field"
                                  placeholder="email"
                                />
                              </div>
                              <div class="member-status">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option value="adult" selected>Adult</option>
                                  <option value="child">Child</option>
                                </select>
                              </div>
                            </div>
                            <div class="member-item mt-4">
                              <div class="member-name">
                                <input
                                  type="text"
                                  class="form-control input_field"
                                  placeholder="Name"
                                />
                              </div>
                              <div class="member-gender">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option selected>Gender</option>
                                  <option value="male">Male</option>
                                  <option value="female">Feale</option>
                                </select>
                              </div>
                              <div class="member-email">
                                <input
                                  type="email"
                                  class="form-control input_field"
                                  placeholder="email"
                                />
                              </div>
                              <div class="member-status">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option value="adult" selected>Adult</option>
                                  <option value="child">Child</option>
                                </select>
                              </div>
                            </div>
                            <div class="member-item mt-4">
                              <div class="member-name">
                                <input
                                  type="text"
                                  class="form-control input_field"
                                  placeholder="Name"
                                />
                              </div>
                              <div class="member-gender">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option selected>Gender</option>
                                  <option value="male">Male</option>
                                  <option value="female">Feale</option>
                                </select>
                              </div>
                              <div class="member-email">
                                <input
                                  type="email"
                                  class="form-control input_field"
                                  placeholder="email"
                                />
                              </div>
                              <div class="member-status">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option value="adult" selected>Adult</option>
                                  <option value="child">Child</option>
                                </select>
                              </div>
                            </div>
                            <div class="member-item mt-4">
                              <div class="member-name">
                                <input
                                  type="text"
                                  class="form-control input_field"
                                  placeholder="Name"
                                />
                              </div>
                              <div class="member-gender">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option selected>Gender</option>
                                  <option value="male">Male</option>
                                  <option value="female">Feale</option>
                                </select>
                              </div>
                              <div class="member-email">
                                <input
                                  type="email"
                                  class="form-control input_field"
                                  placeholder="email"
                                />
                              </div>
                              <div class="member-status">
                                <select
                                  name=""
                                  id=""
                                  class="form-control input_field"
                                >
                                  <option value="adult" selected>Adult</option>
                                  <option value="child">Child</option>
                                </select>
                              </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                              <button class="btn btn-whitee">Proceed</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->

                <div class="total-invoice">
                  <div
                    class="charges-section mt-3 d-flex justify-content-between"
                  >
                    <p class="service">$25 X 1 hour</p>
                    <p class="charges">$25</p>
                  </div>
                  <div
                    class="charges-section mt-3 d-flex justify-content-between"
                  >
                    <p class="service">Tax</p>
                    <p class="charges">$2</p>
                  </div>

                  <hr class="charges-line" />
                  <div class="charges-section d-flex justify-content-between">
                    <p class="services service-total">Total</p>
                    <p class="charges charges-total">$27</p>
                  </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                  <button type="button" class="btn btn-reserve">
                    Book now!
                  </button>
                </div>
              </div>
            </div>
</template>
<script>

export default {
  mode: 'history',
  name: "vehicleBooking",
  props:['price','date','experienceSlotId'],
  data() {
    return {
    
      per_head: "",
      total: "",
      sub_total: "",
      discount: "",
      grand_total: "",
      isDisabled: false,
      experienceId : this.$route.params.experienceId,
      message:'',
      no_of_guest:'',
      no_of_adults:1,
      no_of_childs:0,
      
    };
  },
  
  created() {
   // alert(this.mealSlotId);
    this.onChangeGuest();
   },
  
  methods: {
   onChangeGuest() {
      
       if(this.no_of_adults == ""){
        this.message = "Please input guest";
        return;
       }
       if(this.no_of_adults <= 0){
        this.message = "Please input valid guest";
        return;
       }
       if(this.no_of_childs < 0){
        this.message = "Please input valid Childs";
        return;
       }
      this.no_of_guest = this.no_of_childs + this.no_of_adults;
      this.message = '';
      let bodyFormData = new FormData();
      bodyFormData.append("module_id", this.experienceId);
      bodyFormData.append("module_name", 'experiences');
      bodyFormData.append("no_of_guest", this.no_of_guest);
      bodyFormData.append("slot_id", this.experienceSlotId);
      axios.post("/api/checkExperienceAvailability", bodyFormData).then((response) => {
          if (response.status == 200) {
            if (response.data.data.availability == true) {
              if(localStorage.getItem('type') == '2' || localStorage.getItem('type') == '1'){
               this.isDisabled = true;
              }
              this.qty = response.data.data.qty;
              this.per_item = response.data.data.per_item;
              
              this.total = response.data.data.total;
              this.sub_total = response.data.data.sub_total;
              this.discount = response.data.data.discount;
              this.grand_total = response.data.data.grand_total;
              localStorage.setItem("serviceid", this.mealId);
              this.isDisabled = false;
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
      axios.post("/api/createMealBooking", bodyFormData,this.$helpers.userAuth()).then((response) => {
      if(response.status == 200) {
       localStorage.setItem("booking_id", response.data.data.booking_id);
       this.$router.push({ path: "/bookings/meal-summary" });
      }
      }).catch((err) => {
        this.message = err.response.data.message;
        this.isDisabled = false;
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
  
  watch:{
   $route : 'updateId'
  }
};
</script>
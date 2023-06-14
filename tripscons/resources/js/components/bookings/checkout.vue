<template>
  <main>
    <div class="container pb-5">
      <div class="card-information">
        <div class="checkout-loader" v-show="checkoutLoader"><img src="/assets/uploads/loader.gif" alt="img" /></div>
        <div class="payment-title">
          <h1>Card information</h1>
          <p>Fill card info</p>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-sm-7 col-md-7 pr-sm-2 pr-md-2 pr-lg-5">
          <div class="checkout-form mt-4">
            <form class="card-form">
              <!-- <div class="form-group mt-4">
               <select id="inputState" class="form-control input_field" @change="cardDetailView" v-model="card_id">
                <option value="0">Choose Cards</option>
                <option v-for="(i, index) in cards"
                  :key="index" :value="i.id">{{i.expiry_year}}-{{i.holder_name}}-{{i.card_number}}</option>
                </select>
              </div> -->
              <div class="form-group mt-4">
                <select id="inputState" class="form-control input_field" v-model="type">
                  <option value="0">Choose Card Type </option>
                  <option value="Visa">Visa </option>
                  <option value="Master">Master </option>
                  <option value="American">American </option>
                </select>
              </div>
              <div class="form-group mt-4">
                <input
                  type="text"
                  class="form-control input_field"
                  placeholder="Name on the card"
                  name="full-name"
                  v-model="holder_name"
                />
              </div>
              <div class="form-group mt-4">
                <input
                  type="number"
                  id="card-number"
                  name="number"
                  class="form-control input_field"
                  placeholder="Card number"
                  v-model="card_number"
                  v-max-length="16"   
                />
              </div>
               <div class="form-group mt-4">
             
                  <input
                    type="password"
                    class="form-control input_field"
                    placeholder="CCV"
                    v-model="cvc"
                    v-max-length="3"   
                  />
              
                <div class="col-12 col-sm-6"></div>
              </div>
              <div class="row mt-4">
               <div class="col-12 ">
                    <div class="form-group">
                      <input
                        type="text"
                        placeholder="expiry date"
                        onfocus="(this.type='date')"
                        onblur="(this.type='text')"
                        v-model="expiry_date"
                        class="form-control input_field"
                        :min="oldDateDisabled"
                       />
                    </div>
                  </div>
              </div>
             
             
             
            </form>
          </div>
        </div>
        <div class="col-12 col-sm-5 col-md-5">
          <div class="card-type mt-3 pl-sm-1 pl-md-1 pl-lg-5">
            <div class="card-info">
              <div class="card-wrapper">
              <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> Total </span>
                  <span class="booking-item-value"> PKR {{ total.toFixed(2) }} </span>
                </div>
                <hr class="charges-line" />
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> Discount </span>
                  <span class="booking-item-value"> PKR {{ discount.toFixed(2) }} </span>
                </div>
                <hr class="charges-line" />
                <div class="d-flex booking-details-data mt-3">
                  <span class="booking-item-key"> Grand Total </span>
                  <span class="booking-item-value">
                    PKR {{ grand_total.toFixed(2) }}
                  </span>
                </div>
                 <hr class="charges-line" v-if="partial_amt > 0" />
                <div class="d-flex booking-details-data mt-3" v-if="partial_amt > 0">
                  <span class="booking-item-key" v-if="payment_status == 0"> Partial Amount (Pay Now )</span>
                  <span class="booking-item-key" v-if="payment_status == 2"> Partial Amount (Paid Already )</span>
                  <span class="booking-item-value">
                    PKR {{ partial_amt.toFixed(2) }} ({{partial_amt_in_percentage}}%)
                  </span>
                </div>
                <hr class="charges-line" v-if="remaining_amt > 0"/>
                <div class="d-flex booking-details-data mt-3" v-if="remaining_amt > 0">
                  <span class="booking-item-key" v-if="payment_status == 0"> Remaing Amount (Pay will be later) </span>
                  <span class="booking-item-key" v-if="payment_status == 2"> Remaing Amount (Pay Now) </span>
                  <span class="booking-item-value">
                    PKR {{ remaining_amt.toFixed(2) }} 
                  </span>
                </div>
              
              </div>
            </div>
            <div class="d-flex justify-content-end mt-5">
              <button
                class="btn btn-blackk"
                data-toggle="modal"
                data-target="#confirm"
                @click="checkout"
                :disabled="isDisabled"
              >
              CheckOut
              </button>
            </div>
           
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: "checkout",
  data() {
    return {
      detailData: "",
      cards:"",
      card_id:0,
      holder_name: "",
      card_number: "",
      expiry_date: "",
      cvc: "",
      type: 0,
      singlecard:'',
      isDisabled: false,
      booking_id:'',
      checkoutLoader:false,
      total:0,
      grand_total:0,
      discount:0,
      partial_amt:0,
      remaining_amt:0,
      partial_amt_in_percentage:0,
      payment_status:'',

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
            
            this.total = this.detailData.total;
            this.grand_total = this.detailData.grand_total;
            this.discount = this.detailData.discount;
            if(this.detailData.accommodation.payment_mode == 1) {
            this.payment_status = this.detailData.payment_status;  
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
  computed:{
    
   oldDateDisabled(){
     
     return this.$helpers.oldDateDisabled();
    }
  },
 
  methods: {
    checkout() {
       if (this.type === 0) {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please choose card type",
          timer: 2500,
        });
        return;
      }
      if (this.holder_name === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter card holder name",
          timer: 2500,
        });
        return;
      }
      if (this.card_number == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter card number",
          timer: 2500,
        });
        return;
      }
       if (this.cvc === "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter cvc",
          timer: 2500,
        });
        return;
      }
      if (this.expiry_date === "" || this.expiry_date == undefined) {
         this.$swal({
          type: "error",
          title: "Error!",
          text: "Please enter expiry date",
          timer: 2500,
        });
        return;
      }
      this.isDisabled = true;
      this.checkoutLoader =true;
      let bodyFormData = new FormData();
      this.booking_id = localStorage.getItem("booking_id");
      bodyFormData.append("type", +this.type);
      bodyFormData.append("holder_name", this.holder_name);
      bodyFormData.append("card_number", this.card_number);
      bodyFormData.append("cvc", this.cvc);
      bodyFormData.append("expiry_date", this.expiry_date);
      bodyFormData.append("card_id", 0);
      bodyFormData.append("booking_id",this.booking_id);
      axios.post("/api/checkout", bodyFormData,this.$helpers.userAuth()).then((response) => {
        if(response.status == 200) {
         
          setTimeout(() => this.$router.push({ path: "/bookings/thankyou" }), 2000);
        }
      }).catch((err) => {
          this.$swal({
            type: "error",
            title: "Error!",
            text: err.response.data.message,
            timer: 2500,
          });
          this.checkoutLoader =false;
           this.isDisabled = false;
    });
   
     
},
//     cardDetailView() {
//       if(this.card_id != 0){
//         axios.get("/api/getCard/"+this.card_id).then((response) => {
//         this.singlecard = response.data.data;
//         this.holder_name= this.singlecard.holder_name;
//         this.card_number= this.singlecard.card_number;
//         this.expiry_date =this.singlecard.expiry_date;
//         this.cvc = this.singlecard.cvc;
//         this.type = this.singlecard.type;
       
//   });  
// }else{
      
//         this.holder_name= '';
//         this.card_number= '';
//         this.expiry_date ='';
//         this.cvc = '';
//         this.type = 0;
// }
     
    
//     },
    
  },
};
</script>
<style scoped>
.checkout-loader{
  position:absolute;
  top:0px;
  left:0px;
  width:100%;
  height:100%;
  background:rgba(0,0,0,0.5);
  display:flex;
  justify-content:center;
  align-items:center;
  z-index:999 !important;

}
</style>

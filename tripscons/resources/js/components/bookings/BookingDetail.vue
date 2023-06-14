<template>
    <!-- Button trigger modal -->
<div> 

<!-- Modal -->
<div class="modal right fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title ml-2" id="exampleModalLabel">Invoice</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="testHtml">
      <table class="body-wrap">
    <tbody><tr>
        <td></td>
        <td class="container">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td class="content-wrap aligncenter">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td class="content-block">
                                        <h4 class="margin-top">Thanks for using our app</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <table class="invoice">
                                            <tbody>
                                                <tr>
                                                <td><span class="customer-name"><strong class="mr-2">Customer Name:</strong> {{customerName}}</span>
                                                    <span class="customer-email ml-5"><strong class="mr-2">Customer Email:</strong> {{userEmail}}</span>
                                                  <br>
                                                    <span class="customer-invoice"><strong class="mr-2">Invoice:</strong> #{{invoiceNumber}}</span>
                                                    
                                                    <br>
                                                    <span class="customer-invoice"><strong class="mr-2">Invoice date:</strong> {{invoiceDate |formatDate}}</span>
                                                
                                                  <td v-if="invoiceStatus == 1">
                                                 <span class="paid-status"> Paid </span>
                                                  </td>
                                                  <td v-else-if="invoiceStatus == 2">
                                                    <span class="paid-status">Partial Paid </span>
                                                  </td>
                                                  <td v-else>
                                                    <span class="paid-status">Not Paid </span>
                                                  </td>
                                                  
                                            </tr>
                                            <tr>
                                                 <td> 
                                                    <span class="customer-name"><strong class="mr-2">Provider Name:</strong> {{ providerName }}</span>
                                                    <span class="customer-email ml-5"><strong class="mr-2">Provider Email:</strong> {{providerEmail}}</span>
                                                    
                                                 
                                                 </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table class="invoice-items" cellpadding="0" cellspacing="0">
                                                        <tbody>
                                                            <h6><strong class="mr-2">Title</strong>:{{title}}</h6>
                                                             <h6 class="my-3"><strong class="mr-2">Location</strong> :{{location}}</h6>
                     <h6 class="my-3"><strong class="mr-2">Booking Status</strong> :{{bookingStatus}}</h6>
                                                            
                                                        <tr v-if="module == 'accommodations'">
                                                            <td>Start Date</td>
                                                            <td class="alignright">{{start_date |formatDate}}</td>
                                                        </tr>   
                                                        <tr v-if="module == 'accommodations'">
                                                            <td>End Date </td>
                                                            <td class="alignright">{{end_date |formatDate}}</td>
                                                        </tr>
                                                       <tr v-if="module === 'accommodations'">
                                                            <td>No of Nights </td>
                                                            <td class="alignright">{{no_of_nights}}</td>
                                                        </tr>
                                                        <tr v-if="module ==='accommodations'">
                                                            <td>Per Night</td>
                                                            <td class="alignright" v-if="price">{{price.toFixed(2)}}
                                                                

                                                            </td></tr>

                                                            
 <template v-if="module === 'accommodations'">                                                       
<tr v-if="breakfast_price && breakfast_price!=0">
<td>Breakfast </td>
<td class="alignright">{{breakfast_price.toFixed(2)}}</td>
</tr>
<tr v-if="lunch_price && lunch_price!=0">
<td>Lunch </td>
<td class="alignright">{{lunch_price.toFixed(2)}}</td>
</tr>
<tr v-if="dinner_price && dinner_price!=0">
<td>Dinner </td>
<td class="alignright">{{dinner_price.toFixed(2)}}</td>
</tr>
<tr>
<td>Service fee </td>
<td class="alignright">{{service_fee.toFixed(2)}}</td>
</tr>
<tr>
<td>Cleaning fee </td>
<td class="alignright">{{cleaning_fee.toFixed(2)}}</td>
</tr>
</template> 
<template v-if="module === 'meals'">
<tr>
<td>Require Date </td>
<td class="alignright">{{require_date |formatDate}}</td>
</tr>
<tr>
<td>Require Time </td>
<td class="alignright">{{require_time }}</td>
</tr>
<tr >
<td>{{unit }} </td>
<td class="alignright">{{price.toFixed(2) }}</td>
</tr>
<tr>
<td>Total {{unit}} </td>
<td class="alignright">{{no_of_nights }} * {{price.toFixed(2) }}</td>
</tr>
</template>
 
    
                                                       
                                                       <template v-if="module === 'transports'">
                                                           <tr>
                                                            <td>Start Date</td>
                                                            <td class="alignright">{{start_date |formatDate}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>End Date </td>
                                                            <td class="alignright">{{end_date |formatDate}}</td>
                                                        </tr>
                                                           <tr>
                                                            <td>{{booking_type}}</td>
                                                            <td class="alignright" v-if="price">{{price.toFixed(2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Days</td>
                                                            <td class="alignright">{{noOfDays}} * {{price.toFixed(2)}}</td>
                                                        </tr>
                                                        
                                                            
                                                       </template>
                                                       <template v-if="module === 'experiences'">
                                                           <tr>
                                                            <td>Start Date</td>
                                                            <td class="alignright">{{activitystartDate |formatDate}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Duration </td>
                                                            <td class="alignright">{{duration }}</td>
                                                        </tr>
                                                           <tr>
                                                            <td>Class Size</td>
                                                            <td class="alignright">{{class_size}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>joining Persons</td>
                                                            <td class="alignright">{{totalPersons}} </td>
                                                        </tr>
                                                         <tr>
                                                            <td>Per Person </td>
                                                            <td class="alignright">{{price.toFixed(2)}}</td>
                                                        </tr>
                                                         <tr>
                                                            <td> </td>
                                                            <td class="alignright">{{totalPersons}} * {{price.toFixed(2)}}</td>
                                                        </tr>   
                                                       </template>
                                                       <tr>
                                                            <td>SubTotal </td>
                                                            <td class="alignright">{{sub_total.toFixed(2)}}</td>
                                                        </tr>
                                                        <tr class="total">
                                                            <td  >Total</td>
                                                            <td class="alignright">PKR {{total.toFixed(2)}}</td>
                                                        </tr>
                                                        <tr class="total">
                                                            <td class="">Discount</td>
                                                            <td class="alignright">PKR {{discount.toFixed(2)}}</td>
                                                        </tr>
                                                        <tr class="total">
                                                            <td  >Grand Total</td>
                                                            <td class="alignright">PKR {{grand_total.toFixed(2)}}</td>
                                                        </tr>
                                                       <template v-if="partial_amt> 0 && module === 'accommodations'" >

                                                        <tr class="total">
                                                        <td  >Partial Amount </td>
                                                        <td class="alignright">  PKR {{ partial_amt.toFixed(2) }} ({{partial_amt_in_percentage}}%)</td>
                                                        </tr>  
                                                        <tr class="total">
                                                        <td>Remainig Amount</td>
                                                        <td class="alignright">  PKR {{ remaining_amt.toFixed(2) }} </td>
                                                        </tr>                                         
                                                        </template>
                                                    </tbody></table>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                                <tr>
                                  
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        Company Wanological Solutions. Aqil Jafri Sadaat St, Lahore Pakistan
                                       
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
                <div class="footer">
                    <table width="100%">
                        <tbody><tr>
                            <td class="aligncenter content-block"><span class="mr-3"><em>Do you have queries?</em></span> <b>Email:</b> <a href="mailto:">tripsconpro@company.inc{{module}}</a></td>
                        </tr>
                    </tbody></table>
                </div></div>
        </td>
        <td></td>
    </tr>
</tbody></table>




      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button type="button" @click="generatePdf()"  class="btn btn-blackk">Downlaod Pdf</button>
      </div>
    </div>
  </div>
</div>
</div>
 
</template>
<script>
import { jsPDF } from "jspdf";

export default {
  name: "myBookings",
  props:['booking_id','module_name'],
  data() {
    return {
      bookingDetailObj:'',
      module:'',
      userObj:'',
      bookingObj:'',
      serviceObj:'',
      customerName:'',
      invoiceNumber:'',
      invoiceDate:'',
      invoiceStatus:0,
      start_date:'',
      end_date:'',
      discount:0,
      no_of_nights:'',
      price:0,
      sub_total:0,
      total:0, 
      grand_total:0,
      breakfast_price:0,
      dinner_price:0,
      lunch_price:0,
      service_fee:0,
      cleaning_fee:0,
      invoiceObj:'',
      title:'',
      bookingStatus:'',
      require_date:'',
      require_time:'',
      unit:'',
      qty:1,
      location:'',
      providerObj:'',
      providerName:'',
      providerEmail:'',
      userEmail:'',
      noOfDays:0,
      slotObj:'',
      totalPersons:'',
      activityTime:'',
      duration:'',
      class_size:'',
      activitystartDate:'',
      partial_amt:0,
      remaining_amt:0,
      partial_amt_in_percentage:0,
    };
  },
 
 watch:{
  booking_id(val){
    this.module = this.module_name;
    this.loadAccommodationsBookingDetail();
  }
},

  methods: {
      loadAccommodationsBookingDetail() {
      let bodyFormData = new FormData();
      //bodyFormData.append("module_name", this.module);
      bodyFormData.append("booking_id", this.booking_id);
      axios.post("/api/getBookingDetail",bodyFormData).then((response) => {
      this.bookingObj = response.data.data;
      this.start_date = this.bookingObj.start_date;
      this.end_date= this.bookingObj.end_date;
      this.discount= this.bookingObj.discount;
      this.no_of_nights= this.bookingObj.no_of_nights;
      this.sub_total= this.bookingObj.sub_total;
      this.price = this.bookingObj.price;
      if(this.bookingObj.status == 0){
       this.bookingStatus = 'Pending';
      }
      if(this.bookingObj.status == 1){
       this.bookingStatus = 'Cancelled';
      }
      if(this.bookingObj.status == 2){
       this.bookingStatus = 'Completed';
      }
      
      this.total= this.bookingObj.total;
      this.grand_total= this.bookingObj.grand_total;
      this.userObj = response.data.data.user;
      this.providerObj = response.data.data.provider;
      this.providerName = this.providerObj.name;
      this.providerEmail = this.providerObj.email;
      
      this.customerName = this.userObj.name;
      this.userEmail =    this.userObj.email;
      
      this.invoiceObj = response.data.data.invoice;
      if(this.invoiceObj !=null){
      this.invoiceNumber = this.invoiceObj.number;
      
      this.invoiceDate = this.invoiceObj.created_at;
      this.invoiceStatus = this.invoiceObj.status;
      }
      
      if(this.module == 'accommodations'){
      this.bookingDetailObj = response.data.data.accommodation_booking_detail;
      this.breakfast_price= this.bookingDetailObj.breakfast_price;
      
      this.dinner_price= this.bookingDetailObj.dinner_price;
      this.lunch_price= this.bookingDetailObj.lunch_price;
      this.service_fee= this.bookingDetailObj.service_fee;
      this.cleaning_fee = this.bookingDetailObj.cleaning_fee;
      this.serviceObj = response.data.data.accommodation;
      this.title = this.serviceObj.title;
      this.location = this.serviceObj.city+','+this.serviceObj.country; 
      if(this.bookingObj.accommodation.payment_mode == 1) {
            this.invoiceStatus = 2;
            // alert(this.invoiceStatus)
            this.partial_amt = this.bookingObj.partial_amt;
            this.partial_amt_in_percentage = this.bookingObj.partial_amt_in_percentage;
            this.remaining_amt  = this.grand_total - this.partial_amt ;
            }
      
      }else if(this.module == 'meals'){
      this.bookingDetailObj = response.data.data.meal_booking_detail;
      this.require_date= this.bookingDetailObj.require_date;
      this.require_time= this.bookingDetailObj.require_time;
      this.unit= this.bookingDetailObj.unit;
      this.qty = this.bookingObj.no_of_nights;
      this.serviceObj = response.data.data.meal;
      this.title = this.serviceObj.title; 
      this.location = this.providerObj.city+','+this.providerObj.country;  
      }
      else if(this.module == 'transports'){
      this.bookingDetailObj = response.data.data.vehicle_booking_detail;
      this.noOfDays= this.bookingObj.no_of_nights;
      this.booking_type= this.bookingDetailObj.booking_type; 
      //   if(this.booking_type == 'Hourly'){
      //     this.noOfDays= this.bookingObj.no_of_nights;  
      //   }
      this.serviceObj = response.data.data.transport;
      this.title = this.serviceObj.title; 
      this.location = this.serviceObj.city+','+this.serviceObj.country; 
      }
      else if(this.module == 'experiences'){
      this.bookingDetailObj = response.data.data.experience_booking_detail;
      if(this.bookingDetailObj.no_of_childs == null){
          this.totalPersons = this.bookingDetailObj.no_of_adults + 0;
      }else{
          this.totalPersons = this.bookingDetailObj.no_of_adults + this.bookingDetailObj.no_of_childs;
      }
      
      this.slotObj = response.data.data.slot_book.slot;
      this.class_size = this.slotObj.class_size;
      this.duration = this.slotObj.duration;
      this.activityTime  = this.slotObj.start_time;
      this.activitystartDate  = this.slotObj.date;
      this.location = this.slotObj.city+','+this.slotObj.country; 
      this.serviceObj = response.data.data.experience;
      this.title = this.serviceObj.title; 
      }
      //alert(this.invoiceStatus);
      
      
      //this.accommodationPastBooking = response.data.pastBookings.data;
      });
    },
    generatePdf() {
    var doc = new jsPDF('l', 'mm', [1200, 1500]);
	var pdfjs = document.querySelector('#testHtml');

	doc.html(pdfjs, {
		callback: function(doc) {
			doc.save("invoice.pdf");
		},
		x: 100,
		y: 100
	});
}
   
 },
 
};

</script>
<style scoped>
/* -------------------------------------
    GLOBAL
    A very basic CSS reset
------------------------------------- */

/* Let's make sure all tables have defaults */
table td {
    vertical-align: top;
}

/* -------------------------------------
    BODY & CONTAINER
------------------------------------- */

.body-wrap {
    
    width: 100%;
}

.right  .container {
    display: block !important;
    width: 100% !important;
    margin: 0 auto !important;
    /* makes it centered */
    clear: both !important;
}
.margin-top{
    margin-top: -17px !important;
}
.right  .content {
  width: 100%;
    margin: 0 auto;
    display: block;
    padding: 4px;
}

/* -------------------------------------
    HEADER, FOOTER, MAIN
------------------------------------- */
.paid-status{
    font-size: 16px;
    color: #c1dc6d;
    border-bottom: 2px solid #c1dc6d;
}
.right  .main {
    background: #fff;
   
    border-radius: 3px;
}

.right  .content-wrap {
    padding: 2px;
}

.content-block {
    padding: 0 0 10px;
}

.right  .header {
    width: 100%;
    margin-bottom: 10px;
}

.right  .footer {
    width: 100%;
    clear: both;
    color: #999;
    padding: 20px;
}
.right  .footer a {
    color: #999;
}
.footer p, .footer a, .footer unsubscribe, .footer td {
    font-size: 12px;
}
.modal-body{
    padding: 0px !important;
}
/* -------------------------------------
    TYPOGRAPHY
------------------------------------- */
.right  h3 {
  margin-top:10px !important;}
.right h1,  .right  h2,.right  h3 {
  
    color: #000;
    margin: 40px 0 0;
    line-height: 1.2;
    font-weight: 400;
}



.right p,.right ul,.right  ol {
    margin-bottom: 10px;
    font-weight: normal;
}
.right  p li,.right ul li,.right  ol li {
    margin-left: 5px;
    list-style-position: inside;
}

/* -------------------------------------
    LINKS & BUTTONS
------------------------------------- */  
.right a {
    color: #1ab394;
    text-decoration: underline;
}



/* -------------------------------------
    OTHER STYLES THAT MIGHT BE USEFUL
------------------------------------- */
.last {
    margin-bottom: 0;
}

.first {
    margin-top: 0;
}

.aligncenter {
    text-align: center;
}

.alignright {
    text-align: right;
}

.alignleft {
    text-align: left;
}

.clear {
    clear: both;
}

/* -------------------------------------
    ALERTS
    Change the class depending on warning email, good email or bad email
------------------------------------- */
.alert {
    font-size: 16px;
    color: #fff;
    font-weight: 500;
    padding: 20px;
    text-align: center;
    border-radius: 3px 3px 0 0;
}
.alert a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
}
.alert.alert-warning {
    background: #f8ac59;
}
.alert.alert-bad {
    background: #ed5565;
}
.alert.alert-good {
    background: #1ab394;
}

/* -------------------------------------
    INVOICE
    Styles for the billing tableDiscount	
------------------------------------- */
.invoice {
    margin: 20px auto;
    text-align: left;
    width: 90%;
}
.invoice td {
    padding: 8px 0;
}
.invoice .invoice-items {
    width: 100%;
}
.invoice .invoice-items td {
    border-top: #eee 1px solid;
}
.invoice .invoice-items .total td {
    border-top: 2px solid #333;
    border-bottom: 2px solid #333;
    font-weight: 700;
}

/* -------------------------------------
    RESPONSIVE AND MOBILE FRIENDLY STYLES
------------------------------------- */
@media only screen and (max-width: 640px) {
    h1, h2, h3, h4 {
        font-weight: 600 !important;
        margin: 20px 0 5px !important;
    }

    h1 {
        font-size: 22px !important;
    }

    h2 {
        font-size: 18px !important;
    }

    h3 {
        font-size: 16px !important;
    }

    .container {
        width: 100% !important;
    }

    .content, .content-wrap {
        padding: 10px !important;
    }

    .invoice {
        width: 100% !important;
    }
}
</style>

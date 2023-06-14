 <template>
<!-- Modal -->
<div class="modal fade" id="cancelModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cancel Booking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body custom-body">
        <label>Why you want to cancel?</label>
        <textarea class="form-control input-field" v-model="reason"></textarea>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-blackk" @click="cancelBookingPost">Cancel Booking</button>
      </div>
    </div>
  </div>
</div>
 </template>
 <script>
  export default {
  name: "CancelBooking",
  props:['booking_id'],
  data() {
    return {
      booking_id:'',
      reason:'',
    };
  },

 watch:{
  booking_id(val){
    this.booking_id = this.booking_id;
    this.loadAccommodationsBookingDetail();
  }
},
 methods: {
      cancelBookingPost() {
        if(this.reason ==''){
         this.$swal({
            type: "error",
            title: "Error!",
            text: 'Please enter reason',
            timer: 2500,
          });
          return;
        }
      let bodyFormData = new FormData();
      bodyFormData.append("reason", this.reason);
      bodyFormData.append("booking_id", this.booking_id);

      axios.post("/api/cancelBooking",bodyFormData).then((response) => {

       if (response.status == 200) {
            this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });

        $("#cancelModalLong").modal("hide");
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
  }

};

</script>
<style scoped>
  .custom-body{
    margin-top:-22px;
  }
  </style>

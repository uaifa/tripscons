<template>
  <div class="create-profile container">
        <!--profile steps-->
        <div class="profile-steps">
            <ul class="d-flex justify-content-around">
                <li class=""><img src="/assets/img/icons/feed.png">
                    <p>Personal info</p>
                </li>
                <li class=""><img src="/assets/img/icons/services.png">
                    <p>Services</p>
                </li>
                <li class=""><img src="/assets/img/icons/ident.png">
                    <p>Identification</p>
                </li>
            </ul>
        </div>
        <!--profile creation-->
        <div class="profile-form py-4">
            <form class="mt-5">

                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 pr-4">
                        <div class="title-heading steps">
                            <h1>STEP 6</h1>
                            <p class="ml-4">Discounts</p>
                        </div>
                        <div class="input-wrapper mt-5">
                        <input  class="form-control input_field" placeholder="One Week Discount %" v-model="discount_for_one_week" type="number">
                        <input  class="form-control input_field" placeholder="Two Weeks Discount %" v-model="discount_for_two_week" type="number">
                        </div>
                        <div class="input-wrapper mt-4">
                            <input  class="form-control input_field" placeholder="Three Week Discount %" v-model="discount_for_three_week" type="number">
                            <input  class="form-control input_field" placeholder="Monthly Discount %" v-model="discount_for_four_week" type="number">
                        </div>
       <div class="d-flex justify-content-end mt-5">
              <a class="btn btn-blackk" @click="updateAccommodation">
                save & continue
              </a>
            </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 bg-image">
                        <div class="right-image pl-4 d-flex ">
                            <img src="/assets/img/img11.png" class="img-fluid pl-2">
                        </div>
                    </div>
              
                </div>
            </form>
        </div>

    </div>
</template>

<script>
export default {
  name: "UserDashboard",
  data() {
    return {
      error: "",
      discount_for_one_week:'',
      discount_for_two_week:'',
      discount_for_three_week:'',
      discount_for_four_week:'',
    };
  },
  
  methods: {
    updateAccommodation() {
      let bodyFormData = new FormData();
      bodyFormData.append("accommodation_id", localStorage.getItem('accommodation_id'));
      bodyFormData.append("discount_for_one_week", this.discount_for_one_week);
      bodyFormData.append("discount_for_two_week", this.discount_for_two_week);
      bodyFormData.append("discount_for_three_week", this.discount_for_three_week);
      bodyFormData.append("discount_for_four_week", this.discount_for_four_week);
      axios.post("/api/accommodationUpdate", bodyFormData).then((response) => {
        // if (response.status == 200) {
        //   this.$swal({
        //     type: "success",
        //     title: "Success!",
        //     text: response.data.message,
        //     timer: 2500,
        //   });
          this.$router.push({ path: "/host/accommodations/add/step7" });
        // } else {
        //   this.$swal({
        //     type: "error",
        //     title: "Error!",
        //     text: response.data.message,
        //     timer: 2500,
        //   });
        // }
      });
    },
  },
};
</script>

<style scoped>
</style>

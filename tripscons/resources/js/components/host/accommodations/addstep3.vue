<template>
  <div class="create-profile container">
    <!--profile steps-->
    <div class="profile-steps">
      <ul class="d-flex justify-content-around">
        <li class="">
          <img src="/assets/img/icons/feed.png" />
          <p>Personal info</p>
        </li>
        <li class="">
          <img src="/assets/img/icons/services.png" />
          <p>Services</p>
        </li>
        <li class="">
          <img src="/assets/img/icons/ident.png" />
          <p>Identification</p>
        </li>
      </ul>
    </div>
    <!--profile creation-->
    <div class="profile-form py-4">
      <button class="btn btn-host">Host</button>
      <form class="mt-4">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-6 pr-4">
            <div class="title-heading steps">
              <h1>STEP 2 A</h1>
              <p class="ml-4">Setup Child Infromation</p>
            </div>
            <div class="input-wrapper mt-3">
              <select
                id="inputState"
                class="form-control input_field"
                v-model="ageLimitForChild"
              >
                <option value="">Choose Age Limit For Child</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>

              <select
                id="inputState"
                class="form-control input_field"
                v-model="ageLimitFreeChild"
              >
                <option value="">Choose Age Limit Free Child</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-6 px-4 colright">
            <div class="title-heading steps">
              <p class="ml-4"></p>
            </div>
            <div class="input-wrapper mt-4"></div>
            <div class="input-wrapper mt-3">
              <input
                type="text"
                name="child_discount"
                class="form-control input_field"
                placeholder="Discount On Childs"
                v-model="childDiscount"
              />
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-end pr-2 mt-3">
          <a class="btn btn-blackk" @click="updateAccommodation">
            save & continue
          </a>
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
      ageLimitForChild: "",
      ageLimitFreeChild: "",
      childDiscount: "",
    };
  },
  created() {
    this.getUserProfile();
  },
  methods: {
   
    updateAccommodation() {
      let bodyFormData = new FormData();
      bodyFormData.append("accommodation_id", localStorage.getItem('accommodation_id'));
      bodyFormData.append("ageLimitForChild", this.ageLimitForChild);
      bodyFormData.append("ageLimitFreeChild", this.ageLimitFreeChild);
      bodyFormData.append("childDiscount", this.childDiscount);
      axios.post("/api/accommodationUpdate", bodyFormData).then((response) => {
        // if (response.status == 200) {
        //   this.$swal({
        //     type: "success",
        //     title: "Success!",
        //     text: response.data.message,
        //     timer: 2500,
        //   });
          this.$router.push({ path: "/host/accommodations/add/step3" });
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

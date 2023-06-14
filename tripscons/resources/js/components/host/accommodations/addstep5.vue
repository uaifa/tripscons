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
      
      <form class="mt-5">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-6 pr-4">
            <div class="title-heading steps">
              <h1>STEP 5</h1>
              <p class="ml-4">Property Rules and Info</p>
            </div>
            <div class="property-rules mt-5">
              <input
                type="text"
                class="input_field"
                placeholder="Type your rules"
                v-model="rule_value"
              />
              <div class="d-flex justify-content-end">
                <a class="btn btn-add ml-3" @click="addRules"> add </a>
              </div>
              <div class="d-flex justify-content-end">
                {{ rules }}
              </div>
            </div>
            <div class="property-rules mt-4">
              <textarea
               
                rows="3"
                class="form-control"
                placeholder="Important info for your guests?"
                v-model="important_info"
              >
              </textarea>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-6 px-4">
            <div class="title-heading mt-4">
              <p>Which places your guests will be allowed to use?</p>
            </div>
            <div class="mt-3 facilities">
              <input
                type="text"
                class="input_field"
                placeholder="Important info for your guests?"
                v-model="places_allow_for_use_guest"
              />
            </div>
            <div class="personal-belongings">
              <div class="title-heading mt-4">
                <p>
                  Do you’ve any of your personal belongings at your
                  property/room?
                </p>
              </div>
              <div class="cust-radio mt-2">
                <div class="radio-item1">
                  <label>
                    <input
                      type="radio"
                      name="belongings"
                      value="yes"
                      v-model="personal_belongings_assets"
                      @change="onChange($event)"
                    />
                    <span class="checkmark"></span> Yes
                  </label>
                </div>
                <div class="radio-item">
                  <label>
                    <input
                      type="radio"
                      name="belongings"
                      value="no"
                      checked
                      v-model="personal_belongings_assets"
                      @change="onChange($event)"
                    />
                    <span class="checkmark"></span> No
                  </label>
                </div>
                <input
                  type="text"
                  v-model="personal_belongings_assets_value"
                  v-show="personal_belongings_show_of"
                  placeholder="personal belongings"
                />
              </div>
              <div class="title-heading mt-2">
                <p>Would you like your guests to pay at property?</p>
              </div>
              <div class="cust-radio mt-2">
                <div class="radio-item1">
                  <label>
                    <input
                      type="radio"
                      name="guests-pay"
                      v-bind:value="'1'"
                      v-model="pay_at_property"
                    />
                    <span class="checkmark"></span> Yes
                  </label>
                </div>
                <div class="radio-item">
                  <label>
                    <input
                      type="radio"
                      name="guests-pay"
                      v-bind:value="'0'"
                      v-model="pay_at_property"
                    />
                    <span class="checkmark"></span> No
                  </label>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <a class="btn btn-blackk" @click="updateAccommodation">
                save & continue
              </a>
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
      important_info: "",
      places_allow_for_use_guest: "",
      personal_belongings_assets: "no",
      personal_belongings_assets_value: "",
      personal_belongings_show_of: false,
      pay_at_property: 0,
      rule_value: "",
      rules: [],
    };
  },
  
  methods: {
   addRules() {
      this.rules.push(this.rule_value);
      this.rule_value = "";
    },
    onChange() {
      if (this.personal_belongings_assets == "no") {
        this.personal_belongings_assets = "";
        this.personal_belongings_show_of = false;
      } else {
        this.personal_belongings_show_of = true;
      }
    },

    updateAccommodation() {
      let bodyFormData = new FormData();

      this.personal_belongings_assets = this.personal_belongings_assets_value;
      bodyFormData.append("important_info", this.important_info);
      bodyFormData.append("rules", this.rules);
      bodyFormData.append(
        "places_allow_for_use_guest",
        this.places_allow_for_use_guest
      );
      bodyFormData.append("accommodation_id", localStorage.getItem('accommodation_id'));
      bodyFormData.append(
        "personal_belongings_assets",
        this.personal_belongings_assets
      );
      bodyFormData.append("pay_at_property", this.pay_at_property);
      axios.post("/api/accommodationUpdate", bodyFormData).then((response) => {
        // if (response.status == 200) {
        //   this.$swal({
        //     type: "success",
        //     title: "Success!",
        //     text: response.data.message,
        //     timer: 2500,
        //   });
          this.$router.push({ path: "/host/accommodations/add/step6" });
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

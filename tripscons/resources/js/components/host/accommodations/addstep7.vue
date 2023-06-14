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
              <h1>STEP 7</h1>
              <p class="ml-4">About your property</p>
            </div>

            <div class="form-group mt-4">
              <textarea
                class="form-control input_textarea"
                maxlength="250"
                placeholder="Describe your prorerty"
                rows="4"
                v-model="description"
              ></textarea>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-6 pr-4 right-sectionn">
            <div class="d-flex justify-content-around">
              
              <input
                type="file"
                name="normalImage"
                class="form-control-file"
                id="normalImage"
                @change="normalOnFileChange"
              />
            </div>
            <div class="row mt-3">
              <div class="col-12 col-sm-6 col-md-6 img-parent">
              
              </div>
              <div class="col-12 col-sm-6 col-md-6 images-right">
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <a class="btn btn-blackk" @click="updateAccommodation">
              save 
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import $ from "jquery";
export default {
  name: "UserDashboard",
  data() {
    return {
      error: "",
      description: "",
      normalImage: null,
      normalImagePreview: null,
      normalShowPreview: false,
      imagePath: "",
    };
  },
   methods: {
    updateAccommodation() {
      let bodyFormData = new FormData();

      if (this.description == "") {
        return;
      }
      bodyFormData.append("description", this.description);
      bodyFormData.append("accommodation_id", localStorage.getItem('accommodation_id'));
      axios.post("/api/accommodationUpdate", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
            this.$router.push({ path: "/host/accommodations/detail/"+localStorage.getItem('accommodation_id') });
        } else {
          this.$swal({
            type: "error",
            title: "Error!",
            text: response.data.message,
            timer: 2500,
          });
        }
      });
    },
   normalOnFileChange(event) {
      this.normalImage = event.target.files[0];
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.normalShowPreview = true;
          this.normalImagePreview = reader.result;
        }.bind(this),
        false
      );

      if (this.normalImage) {
        if (/\.(jpe?g|png|gif)$/i.test(this.normalImage.name)) {
          reader.readAsDataURL(this.normalImage);
        }
      }
      let bodyFormData = new FormData();
      bodyFormData.append("image", this.normalImage);
      bodyFormData.append("module", "accommodations");
       bodyFormData.append(
        "module_id",
        localStorage.getItem("accommodation_id")
      );
      axios.post("/api/uploadImages", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.imagePath =
            "/assets/uploads/accommodations/" + response.data.imagePath;

          $(".images-right").append(
            '<div class="images-container"><img  class="img-fluid" src="' +
              this.imagePath +
              '"/></div>'
          );
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
       
        } else {
          this.$swal({
            type: "error",
            title: "Error!",
            text: response.data.message,
            timer: 2500,
          });
        }
      });
    },
  },
};
</script>

<style scoped>
</style>

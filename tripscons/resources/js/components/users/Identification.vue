<template>
  <main>
    <div class="create-profile container">
      <!--profile steps-->
      <ProfileNavBar />
      <!-- <div class="profile-steps">
        <ul class="d-flex justify-content-around">
          <li class="">
            <img src="/assets/img/icons/feed.png" />
            <p>
              <router-link :to="{ path: '/account_info' }"
                >Personal info
              </router-link>
            </p>
          </li>
          <li class="" v-if="type!=2">
            <img src="/assets/img/icons/intrests.png" />
            <p>
              <router-link :to="{ path: '/user/interests' }"
                >Interests</router-link
              >
            </p>
          </li>
          <li class="">
            <img src="/assets/img/icons/ident.png" />
            <p>
              <router-link :to="{ path: '/user/identification' }"
                >Identification</router-link
              >
            </p>
          </li>
        </ul>
      </div> -->
      <!--profile creation-->
      <vue-confirm-dialog></vue-confirm-dialog>
      <div class="profile-form pl-5">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-6 py-4 pr-4">
            <div class="d-flex justify-content-start mb-3"> 
              <a href="#" type="button" class=" btn-back">
                <i class="fa fa-arrow-left mr-2"></i>
                Back</a>
            </div>
            <div class="title-heading">
              <h1>Please let us prove your identity</h1>
            </div>
          
              <div class="form-group mt-4">
                <select
                  id="document-typr"
                  class="form-control  input_field"
                  v-model="documentType"
                >
                  <option>Passport</option>
                  <option>National ID Card</option>
                  <option>Other</option>
                </select>
              </div>
              <div class="form-group mt-4">
                <input
                  type="text"
                  onfocus="(this.type='date')"
                   onblur="(this.type='text')"
                  placeholder="Expiration date"
                  class="form-control input_field datee_field"
                  v-model="expiryDate"
                  :min="oldDateDisabled"
                />
              </div>
              <div class="mt-5 d-flex justify-content-around">
                <div class="img-upload-parent">
                  <div class="img-upload-child">
                    <img
                      v-bind:src="frontImagePreview"
                      v-if="frontShowPreview"
                      class="img-fluid"
                    />
                    <img
                      :src="'/assets/uploads/users/' + frontPicture"
                      v-else      
                      class="img-fluid"
                    />
                  </div>
                  <button class="btn btn-blackk-upload mt-3">
                  <input
                    type="file"
                    name="frontPicture"
                    class="button-input"
                    id="frontPicture"
                    @change="frontOnFileChange"
                  />
                  <span class="button-span"> Upload image front</span>
                  </button>
                 
                </div>
                <div class="img-upload-parent">
                  <div class="img-upload-child">
                    <img
                      v-bind:src="backImagePreview"
                      v-if="backShowPreview"
                      class="img-fluid"
                    />
                    <img
                      :src="'/assets/uploads/users/' + backPicture"
                      v-else
                      class="img-fluid"
                    />
                  </div>
                  <button class="btn btn-blackk-upload mt-3">
                  <input
                    type="file"
                    name="backPicture"
                    class="button-input"
                    id="backPicture"
                    @change="backOnFileChange"
                  />
                 <span class="button-span"> Upload image back</span>
                  </button>
                </div>
              </div>

              <div class="mt-5 d-flex justify-content-center">
                <a @click="saveDocument" class="btn btn-blackk">
                  Save & Continue
                </a>
              </div>
           
          </div>
          <div class="col-12 col-sm-6 col-md-6 bg-image">
            <div class="right-image pl-4 d-flex">
              <img src="/assets/img/img6.png" class="img-fluid pl-2" />
            </div>
          </div>
          
        </div>
        <div class="documents">
          <h2>Documents</h2>

          <table class="documents-table">
            <tr>
              <th>Title</th>
              <th>Expiry Date</th>
              <th>Front Picture</th>
              <th>Back Picture</th>
              <th>Action</th>
            </tr>
            <tr v-for="(i, index) in userObj" :key="index">
              <td>{{ i.type }}</td>
              <td>{{ i.expiry }}</td>
              <td>
                <img
                  :src="'/assets/uploads/users/' + i.front"
                  class="img-fluid table-image-upload"
                />
              </td>
              <td>
                <img
                  :src="'/assets/uploads/users/' + i.back"
                  class="img-fluid table-image-upload"
                />
              </td>
              <td class="text-center">
                <!-- <i
                  type="button"
                  class="buttonDelete fa fa-times"
                  @click="deleteDocument(i.id)"
                >
                  
                </i> -->
                <button class="btn btn-whitee buttonDeletee"
                @click="deleteDocument(i.id)">
                  Remove
                </button>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </main>
</template>

<script>

import ProfileNavBar from './ProfileNavBar.vue';

export default {
  name: "Identification",
  components: {
        ProfileNavBar,
    },
  data() {
    return {
      frontPicture: "img1.jpg", //'/assets/uploads/users/not-available' ,
      backPicture: "img1.jpg",
      frontImagePreview: null,
      backImagePreview: null,
      frontShowPreview: false,
      backShowPreview: false,
      documentType: "Passport",
      expiryDate: "",
      type:0,
      userObj: [],
    };
  },
    computed:{
    
   oldDateDisabled(){
     return this.$helpers.oldDateDisabled();
    }
  },
  created() {
    this.getUserDocuments();
    this.type = localStorage.getItem("type");
  },
  methods: {
    getUserDocuments() {
      axios.get("/api/getUserDocuments").then((response) => {
        this.userObj = response.data.data;
      });
    },
    saveDocument() {
      let formData = new FormData();
      if (this.documentType == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select document type",
          timer: 2500,
        });
        return;
      } 
      if (this.expiryDate == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select expiry date",
          timer: 2500,
        });
        return;
      } 
      if (this.frontPicture == "img1.jpg") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select front side picture",
          timer: 2500,
        });
        return;
      } 
      if (this.backPicture == "img1.jpg") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please select back side picture",
          timer: 2500,
        });
        return;
      } 
      formData.append("document_type", this.documentType);
      formData.append("expiryDate", this.expiryDate);
      if (this.frontShowPreview == true) {
        formData.append("frontImage", this.frontPicture);
      }
      if (this.backShowPreview == true) {
        formData.append("backImage", this.backPicture);
      }
      axios.post("/api/AddUserDocument", formData).then((response) => {
        if (response.status == 200) {
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
          this.getUserDocuments();
        } else {
          this.$swal({
            type: "error",
            title: "Error!",
            text: response.data.message,
            timer: 2500,
          });
        }
      }).catch((err) => {
          this.$swal({
            type: "error",
            title: "Error!",
            text: err.response.data.message,
            timer: 2500,
          });
        });;
    },
    deleteDocument(document_id) {
 Vue.$confirm({
        title: 'Are you sure?',
        message: 'Are you sure you want to Remove?',
        button: {
          yes: 'Yes',
          no: 'Cancel'
        },
        callback: confirm => {
        if (confirm) {
        axios.delete("/api/deleteDocument/" + document_id).then((response) => {
        if (response.status == 200) {
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });

          this.getUserDocuments();
        } else {
          this.$swal({
            type: "error",
            title: "Error!",
            text: response.data.message,
            timer: 2500,
          });
        }
      }).catch((err) => {
          this.$swal({
            type: "error",
            title: "Error!",
            text: err.response.data.message,
            timer: 2500,
          });
        });
            }
       
        }
      })
   
      
    },
    frontOnFileChange(event) {
      this.frontPicture = event.target.files[0];
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.frontShowPreview = true;
          this.frontImagePreview = reader.result;
        }.bind(this),
        false
      );

      if (this.frontPicture) {
        if (/\.(jpe?g|png|gif)$/i.test(this.frontPicture.name)) {
          reader.readAsDataURL(this.frontPicture);
        }
      }
    },
    backOnFileChange(event) {
      this.backPicture = event.target.files[0];
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.backShowPreview = true;
          this.backImagePreview = reader.result;
        }.bind(this),
        false
      );

      if (this.backPicture) {
        if (/\.(jpe?g|png|gif)$/i.test(this.backPicture.name)) {
          reader.readAsDataURL(this.backPicture);
        }
      }
    },
  },
};
</script>

<style scoped>
a.btn.btn-ugrade {
  border: 1px solid greenyellow;
  margin: 25px 0 0 25px;
  border-color: #85b59e;
  background-image: linear-gradient(135deg, #85b59e 0%, #03996f 100%);
  padding: 10px;
  border-radius: 30px;
  color: white;
}

.bmd-label-floating {
  margin-top: 12px;
}

.form-check {
  position: relative;
  display: contents;
  padding-left: 1.25rem;
}

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td,
th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

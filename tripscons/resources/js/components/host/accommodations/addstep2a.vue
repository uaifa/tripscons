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
              <h1>Room Informations</h1>
            </div>
            <div class="facilities">
              <div class="activities-container mt-3">
                <ul class="d-flex activities-count">
                  <li>bedroom</li>
                  <li>swimming pool</li>
                </ul>
              </div>
            </div>
            <div class="input-wrapper">
              <input
                type="text"
                class="form-control input_field"
                placeholder="Room Title"
                v-model="roomTitle"
              />
              <input
                type="number"
                class="form-control input_field"
                placeholder="Quantity "
                v-model="roomQuantity"
              />
              <input
                type="number"
                class="form-control input_field"
                placeholder="Price"
                v-model="roomPrice"
              />
            </div>
            <div class="input-wrapper mt-4">
              <textarea
                type="text"
                rows="3"
                class="form-control"
                placeholder="Bed Details"
                v-model="roomDescription"
              ></textarea>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-6 px-4 colright">
            <div class="input-wrapper mt-4">
              <input
                type="number"
                class="form-control input_field"
                placeholder="No. Of Adults "
                v-model="noOfAdults"
              />
              <input
                type="number"
                class="form-control input_field"
                placeholder="No Of Childs"
                v-model="noOfChilds"
              />
            </div>

            <div class="input-wrapper mt-4">
              <input
                type="number"
                class="form-control input_field"
                placeholder="No. Of Extra Guest "
                v-model="noOfExtraGuest"
              />
              <input
                type="number"
                class="form-control input_field"
                placeholder="Price For Each Guest"
                v-model="priceForEachGuest"
              />
            </div>
            <div class="mt-5">
              <a
                href="#"
                class="btn-whitee mt-5"
                data-toggle="modal"
                data-target="#activities"
                >Explore Room Facilities</a
              >
            </div>

            <div
              class="modal fade"
              id="activities"
              role="dialog"
              aria-labelledby="loginmodalLabel"
              aria-hidden="true"
            >
              <div class="modal-dialog" role="document">
                <div class="modal-content pb-5">
                  <div clas="modal-body">
                    <div class="loginbody container p-3">
                      <div class="facilities-container">
                        <div
                          class="facility-item"
                          v-for="(genData, index) in generalobjects"
                          :key="index"
                        >
                          <input
                            type="checkbox"
                            :id="genData.name"
                            :value="genData.name + '|' + genData.image"
                            class="mr-2"
                            v-model="checkedFacilities"
                            checked
                          />

                          <img
                            :src="'/assets/icons/' + genData.image"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                          />
                          <p class="activity-name">{{ genData.name }}</p>
                        </div>
                      </div>
                      <button
                        class="btn btn-whitee"
                        data-dismiss="modal"
                        @click="showFacilitiesList"
                      >
                        Add
                      </button>
                    </div>
                    <label>Facilities Selected</label>
                    <ul v-for="(i, index) in splitedList" :key="index">
                      <li>
                        {{ i.name }}
                        <img
                          :src="'/assets/icons/' + i.image"
                          data-bs-toggle="tooltip"
                          data-bs-placement="top"
                        />
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-3 facilities">
              <div class="activities-container">
                <ul class="d-flex activities-count">
                  <li>extinguisher</li>
                  <li>smoke detectors</li>
                </ul>
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <a class="btn btn-blackk" @click="addRooms"> Add </a>
              <router-link
                class="btn btn-blackk"
                :to="{
                  path: '/host/accommodations/add/step4',
                }"
              >
                Next
              </router-link>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="tables">
      <h2>Rooms</h2>

      <table>
        <tr>
          <th>Title</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Description</th>
          <th>No Of Adults</th>
          <th>No Of Childs</th>
          <th>No Of Extra Guest</th>
          <th>Price For Each Guest</th>
          <th>Facilities</th>
          <th>Action</th>
        </tr>
        <tr v-for="(i, index) in rooms" :key="index">
          <td>{{ i.title }}</td>
          <td>{{ i.qty }}</td>
          <td>{{ i.price }}</td>
          <td>{{ i.beds_descriptions }}</td>
          <td>{{ i.no_of_adult }}</td>
          <td>{{ i.no_of_child }}</td>
          <td>N/A</td>
          <td>N/A</td>
          <td v-if="i.facilities != null">
            <div v-for="(j, index) in i.facilities" :key="index">
              {{ j.name }}
              <img
                :src="'/assets/icons/' + j.icon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
              />
            </div>
          </td>
          <td v-else>N/A</td>
          <td>
            <button
              type="button"
              class="buttonDelete"
              @click="deleteData(i.id)"
            >
              Delete
            </button>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: "UserDashboard",
  data() {
    return {
      email: "",
      password: "",
      error: "",
      userObj: "",
      roomTitle: "",
      roomQuantity: "",
      roomPrice: "",
      roomDescription: "",
      noOfAdults: "",
      noOfChilds: "",
      checkedFacilities: [],
      generalobjects: {},
      noOfExtraGuest: "",
      priceForEachGuest: "",
      rooms: [],
    };
  },
  created() {
    this.getUserProfile();
    this.facilities();
    this.getRooms();
  },
  computed: {
    splitedList() {
      let arraydata = [];
      this.checkedFacilities.map((el) => {
        let namedata = el.split("|");
        let facilityName = namedata[0];
        let facilityImage = namedata[1];
        arraydata.push({ name: facilityName, image: facilityImage });
      });
      return arraydata;
    },
  },
  methods: {
    showFacilitiesList(e) {
      e.preventDefault();
     // alert(this.checkedFacilities);
    },

    getUserProfile() {
      let bodyFormData = new FormData();
      axios.get("/api/getUserProfile", bodyFormData).then((response) => {
        this.userObj = response.data.userData;
      });
    },
    facilities() {
      axios.get("/api/getAllFacilities").then((response) => {
        this.generalobjects = response.data.data.facilities;
      });
    },
    resetRoom() {
      this.roomTitle = "";
      this.roomQuantity = "";
      this.roomPrice = "";
      this.roomDescription = "";
      this.noOfAdults = "";
      this.noOfChilds = "";
      this.checkedFacilities = [];
      this.noOfExtraGuest = "";
      this.priceForEachGuest = "";
    },
    getRooms() {
      let accommodation_id = localStorage.getItem("accommodation_id");
      axios.get("/api/getRooms/" + accommodation_id).then((response) => {
        this.rooms = response.data.rooms;
      });
    },
    deleteData(room_id) {
      axios.delete("/api/deleteRoom/" + room_id).then((response) => {
        if (response.status == 200) {
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });

          this.getRooms();
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
    addRooms() {
      let bodyFormData = new FormData();
      if (this.roomTitle == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please Enter Room Title.",
          timer: 2500,
        });
        return;
      }
      if (this.roomQuantity == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please Enter Room Quantity.",
          timer: 2500,
        });
        return;
      }
      if (this.roomPrice == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please Enter Room Price.",
          timer: 2500,
        });
        return;
      }
      if (this.roomDescription == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please Enter Room Description.",
          timer: 2500,
        });
        return;
      }
      if (this.noOfAdults == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please Enter No Of Adults.",
          timer: 2500,
        });
        return;
      }
      if (this.noOfChilds == "") {
        this.$swal({
          type: "error",
          title: "Error!",
          text: "Please Enter No Of Childs.",
          timer: 2500,
        });
        return;
      }
      bodyFormData.append(
        "accommodation_id",
        localStorage.getItem("accommodation_id")
      );
      bodyFormData.append("roomTitle", this.roomTitle);
      bodyFormData.append("roomQuantity", this.roomQuantity);
      bodyFormData.append("roomPrice", this.roomPrice);
      bodyFormData.append("roomDescription", this.roomDescription);
      bodyFormData.append("noOfAdults", this.noOfAdults);
      bodyFormData.append("noOfChilds", this.noOfChilds);
      bodyFormData.append("checkedFacilities", this.checkedFacilities);
      axios.post("/api/addRooms", bodyFormData).then((response) => {
        if (response.status == 200) {
          this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
          this.resetRoom();
          this.getRooms();
          // this.$router.push({ path: "/host/accommodations/add/step3" });
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
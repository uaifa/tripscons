<template>
  <div class="row hotel-suroundings">
    <div class="col-12 col-md-4">
      <div class="surrounding-title d-flex">
        <i
          class="fa fa-pencil"
          data-toggle="modal"
          data-target="#whatsnear"
          @click="updateplaceType('Hotel')"
        ></i>
        <!-- Modal -->
        <div
          class="modal fade"
          id="whatsnear"
          tabindex="-1"
          role="dialog"
          aria-labelledby="whatsnear"
          aria-hidden="true"
          
        >
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                <span aria-hidden="true">×</span>
                      </button>
              <div class="modal-body p-4">
                <h6 class="mb-3">Please Add Place</h6>
                <input type="text" v-model="title" class="form-control input-field" placeholder="Place Title"/>
                <input type="number" class="form-control input-field mt-3" v-model="distance" placeholder="Distance">
                <div class="d-flex justify-content-center">
                              <button
                                @click="addPlace"
                                class="btn btn-blackk mt-2"
                              >
                               Add
                              </button>
                            </div>
              </div>
            </div>
          </div>
        </div>
        <img src="/assets/img/icons/manwalk.png" class="mt-1" />
        <h4 class="ml-3">What's nearby</h4>
      </div>
      <div class="surrounding-list">
        <ul>
          <div v-for="(i,index) in generalobjects" :key="index">
          <li v-if="i.type=='Hotel'">

            <span class="list-title">{{i.title}}</span>
            <span class="list-distance">{{i.distance}}km</span>
            <i
               class="fa fa-times"
               @click="deletePlace(i.id)"
            ></i>
          </li>
          </div>
         
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="surrounding-title d-flex">
        <i
          class="fa fa-pencil"
          data-toggle="modal"
          data-target="#whatsnear"
          @click="updateplaceType('Restaurants')"
        ></i>
     
        <img src="/assets/img/icons/fork.png" class="mt-1" />
        <h4 class="ml-3">Restaurants & cafes</h4>
      </div>
      <div class="surrounding-list">
        <ul>
          <div v-for="(i,index) in generalobjects" :key="index">
          <li v-if="i.type=='Restaurants'">

            <span class="list-title">{{i.title}}</span>
            <span class="list-distance">{{i.distance}}km</span>
            <i
               class="fa fa-times"
               @click="deletePlace(i.id)"
            ></i>
          </li>
          </div>
         
        </ul>
      </div>

      <div class="surrounding-title d-flex mt-4">
        <i
          class="fa fa-pencil"
          data-toggle="modal"
          data-target="#whatsnear"
          @click="updateplaceType('attractions')"
        ></i>
        <!-- Modal -->
        
        <img src="/assets/img/icons/sway.png" class="mt-1" />
        <h4 class="ml-3">Top attractions</h4>
      </div>
      <div class="surrounding-list">
      <ul>
          <div v-for="(i,index) in generalobjects" :key="index">
          <li v-if="i.type=='attractions'">

            <span class="list-title">{{i.title}}</span>
            <span class="list-distance">{{i.distance}}km</span>
            <i
               class="fa fa-times"
               @click="deletePlace(i.id)"
            ></i>
          </li>
          </div>
         
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="surrounding-title d-flex">
        <i
          class="fa fa-pencil"
          data-toggle="modal"
          data-target="#whatsnear"
          @click="updateplaceType('Airports')"
        ></i>
       
        <img src="/assets/img/icons/airplane.png" class="mt-1" />
        <h4 class="ml-3">Closest Airports</h4>
      </div>
      <div class="surrounding-list">
      <ul>
          <div v-for="(i,index) in generalobjects" :key="index">
          <li v-if="i.type=='Airports'">

            <span class="list-title">{{i.title}}</span>
            <span class="list-distance">{{i.distance}}km</span>
            <i
               class="fa fa-times"
               @click="deletePlace(i.id)"
            ></i>
          </li>
          </div>
         
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "AddPlaces",
  components: {},
  data() {
    return {
      accommodationId: this.$route.params.accommodationId,
      generalobjects: {},
      rating: "",
      ratingCustom: "",
      ratingToggle: false,
      isActiverating: false,
      addressCountry: "",
      addressCity: "",
      title:'',
      type:'',
      distance:'',
      
     };
  },
  created() {
    this.getPlaces();
   },
  methods: {
    getPlaces() {
     
      let bodyFormData = new FormData();//+this.accommodationId
      axios.get("/api/getPlaces?module_id="+this.accommodationId).then((response) => {
       this.generalobjects = response.data.data;
      });
    },
    deletePlace(place_id) {
     
      let bodyFormData = new FormData();//+this.accommodationId
      axios.delete("/api/deletePlace?place_id="+place_id).then((response) => {
      if (response.status == 200) {
         this.getPlaces();
            this.$swal({
              type: "success",
              title: "Success!",
              text: response.data.message,
              timer: 2500,
            });
          }
      });
    },
    updateplaceType(placetype){
      this.type = placetype;
    },
    addPlace(e) {
     e.preventDefault();
      let bodyFormData = new FormData();//+this.accommodationId
      bodyFormData.append("type", this.type);
      bodyFormData.append("module_id", this.accommodationId);
      bodyFormData.append("module", 'accommodation');
      bodyFormData.append("title", this.title);
      bodyFormData.append("distance", this.distance);
      axios.post("/api/addPlace",bodyFormData).then((response) => {
      if (response.status == 200) {
      this.getPlaces();
      this.title='';
      this.distance ='';
        $("#whatsnear").modal("hide");
      
            this.$swal({
              type: "success",
              title: "Success!",
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
    },
    
    
  },
};
</script>
<style scoped>
</style>

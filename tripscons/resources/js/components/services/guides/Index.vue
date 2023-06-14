<template>
<main>
     <loader v-show="loader"></loader>
      <!-- <div class="col-12 col-sm-8 col-md-8"> -->
        <div class="profile-right p-5">
          <div class="stay-in-sec">
            <div class="d-flex justify-content-between my-2">
              <h3 class="title-section f-30">  
                 
                <span v-if="userObjects.length > 0">
                  {{ userObjects[0].module }} 
                </span>
                <span v-else>Guides</span>
              </h3>
              <router-link :to="{ path: '/guide/add' }">
                <button class="btn btn-blackk pl-4">
                  Add New &nbsp;
                  <span v-if="userObjects.length > 0"> 
                      {{ userObjects[0].module }}
                  </span>
                  <span v-else>
                     Guides
                  </span>

                </button>
              </router-link>
            </div>

            <div class="row">

              <div v-if="(guides.data).length > 0"
                class="col-12 col-sm-4"
                v-for="(guide, index) in guides.data"
                :key="index">
                <router-link
                  :to="{
                    path: '/guides/edit/' + guide.id,
                  }" >
                    
                  <div class="hotel-box">
                    <div class="img-holder">
                        <template v-if="guide.images.length > 0" v-for="images in guide.images">
                            <img v-if="images.type == 'main' " :src="`${$imagePath}guides/${images.name}`" />
                            
                        </template>
                      <img v-if="guide.images.length < 1" src="/assets/uploads/users/img1.jpg" alt="img" />
                    </div>
                    <div class="room-cap">
                      <img src="/assets/img/person-add.png" alt="icon" />
                      <small>up to <br />12 </small>
                    </div>
                    <div class="content-holder">
                      <small v-if="guide.city != null">
                        <img src="/assets/img/map-pin.png" alt="icon" />
                        {{ guide.city }} <span>1700 miles away</span>
                      </small>
                      <small v-else>
                        <img src="/assets/img/map-pin.png" alt="icon" />
                      </small>
                      <div
                        class="
                          d-flex
                          justify-content-between
                          align-self-center
                          mb-2
                        " >
                        <h3
                          class="align-self-center"
                          v-if="guide.country != null"
                        >
                          from {{ guide.country }}
                        </h3>
                        <a href="#">
                          <span class="rating align-self-center"
                            ><i class="fa fa-star"></i
                          ></span>
                          <span
                            class="rating-title align-self-center"
                            v-if="guide.rating != null"
                            >{{ guide.rating }}(0)</span
                          >
                          <span
                            class="count-rating align-self-center"
                            v-if="guide.no_of_reviews != null"
                            >({{ guide.no_of_reviews }})</span
                          >
                        </a>
                      </div>
       
                    </div>
                  </div>
                </router-link>
              </div>
              <div  v-if="(guides.data).length < 1" class="">
                <h4 class="text-center">Record Not Found!</h4>
              </div>
            </div>
          </div>
          <pagination
            :data="guides"
            @pagination-change-page="getServiceGuide"
          ></pagination>
        </div>

</main>
</template>

<script>
export default {
  props: ['userObjects'],
  data() {
    return {
      email: "",
      password: "",
      error: "",
      userObj: "",
      guides: {},
      'loader':true
    };
  },
  created() {
    this.getServiceGuide();
    this.loader = false;
  },
  methods: {
    logout() {
      localStorage.removeItem("user-token");
      this.$router.push("/user-login");
    },
    getServiceGuide(page) {
      if (typeof page === "undefined") {
        page = 1;
      }

      let bodyFormData = new FormData();
      bodyFormData.append("page", page);
      axios.post("/api/getServicerProviderGuides", bodyFormData).then((response) => {
         
        this.userObj = response.data.host;
        this.guides = response.data.guides;
      });
    },
  },
};
</script>

<style scoped>
</style>

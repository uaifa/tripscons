<template>

    <div class="modal show" id="add-services" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom modal-lg search-popup" role="document">        
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                </button>
                <div class="modal-body">
                    <div class=" py-5 mt-4 mb-5">
            <div class="title-heading pl-3">
                <h1> Add services 
                    <span class="ml-5" style="font-size: 14px;">You can add different service</span>
                </h1>
            </div>
            <div class="row services-container-main no-gutters mt-4">
                <div v-if="generalServices" v-for="(general_service, index) in generalServices" class="col-4" :key="index">

                    <label :for="`general_service_${index}`" class="services-container add_services">

                        <input type="radio" v-model="checkedGeneralServices" @onclick="selectOnlyThis(this.id)" class="checkmarkk-radio mr-2"  :id="`general_service_${index}`" name="accommodation" :value="general_service.id+ '|' +general_service.name + '|' + general_service.image" >
                                                                             
                        <div class="row">
                            <div class="col-3 service-image">
                                <img :src="`/assets/service_icons/${general_service.image}`" alt="">
                            </div>
                            <div class="col-9">
                                <h2 class="services-title">{{ general_service.module }}</h2>
                                <p class="service-type">{{ general_service.name }} </p>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
           
            <div v-if="generalServices" class="d-flex justify-content-center mt-3">
                <button class="btn btn-whitee" @click="addUpdateServices">Add Service</button>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  
  
    export default {
        
        data() {
            return {
                generalServices: [],
                checkedGeneralServices: '',
                user_services: 0,
            }
        },
        
        created(){
            this.getGeneralServices();
        },
        computed:{
            generalServicesList() {
              let arraydata = [];
            if(this.checkedGeneralServices.split("|")){
                let namedata = this.checkedGeneralServices.split("|");
                let id = namedata[0];
                let name = namedata[1];
                let image = namedata[2];
                arraydata.push({ id: id, name: name, image: image });
            }

            //   this.checkedGeneralServices.map((el) => {
            //     let namedata = el.split("|");
            //     let id = namedata[0];
            //     let name = namedata[1];
            //     let image = namedata[2];
            //     arraydata.push({ id: id, name: name, image: image });
            //   });
              return arraydata;
            },
        },
        methods: {
            selectOnlyThis(id) {
                for (var i = 1;i <= 4; i++)
                {
                    document.getElementById(i).checked = false;
                }
                document.getElementById(id).checked = true;
            },
            getGeneralServices(){
                axios.get("/api/getGeneralServices").then((response) => {
                    if(response && response.data.data.general_services){
                        this.generalServices = response.data.data.general_services;
                        let user_id = localStorage.getItem('user_id');
                        this.generalServices.forEach((item) => {
                            if(item.users && (item.users).length !== 0 && item.users[0] && item.users[0].id == user_id){
                                this.checkedGeneralServices = item.id+"|"+item.name + "|" + item.image;
                            }
                        });
                    }
                });
            },
            addUpdateServices(){
                            
                let bodyFormData = new FormData();
                bodyFormData.append("general_services", JSON.stringify(this.generalServicesList));
                axios.post("/api/addUpdateGeneralServices",bodyFormData,{headers: {'Authorization': `Bearer ${localStorage.getItem('user-token')}` }}).then((response) => {
                  if (response.status == 200) {
                          this.closeModal();
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
                }).catch((err) => {
                      this.$swal({
                          type: "error",
                          title: "Error!",
                          text: err.response.data.message,
                          timer: 2500,
                      });
                });
            },  
            closeModal() {
                $("#add-services").modal('hide');
            }                 
        }
    }
</script>

<style scoped>
    .multiselect {
        box-sizing: inherit;
    }
    textarea#host_description {
        padding: 15px;
    }

</style>

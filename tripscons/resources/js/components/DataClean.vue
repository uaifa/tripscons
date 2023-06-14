<template>
<div>
    
   <button type="button" class="btn btn-danger" @click="dataDelate('accommodations')">Accommodations</button>
   <button type="button" class="btn btn-danger" @click="dataDelate('meals')">Meals</button>
   <button type="button" class="btn btn-danger" @click="dataDelate('transports')">Transports</button>
   <button type="button" class="btn btn-danger" @click="dataDelate('experiences')">Experiences</button>
   <button type="button" class="btn btn-danger" @click="dataDelate('bookings')">Bookings</button>
   <button type="button" class="btn btn-danger" @click="dataDelate('all')">Turncate Db (All User Related Data)</button>
  
   </div>
</template>
<script>

export default {
  mode: 'history',
  name: "dataClean",
  data() {
    return {
      module:'',
    };
  },

  methods: {
  
    dataDelate(module) {
   
      axios.delete("/api/deleteData/"+module).then((response) => {
      if(response.status == 200) {
       alert('Data has been deleted');
      }
      }).catch((err) => {
        this.message = err.response.data.message;
        return;
        });
   
    },
},

};
</script>
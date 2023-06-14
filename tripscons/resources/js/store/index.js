import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

const store = new Vuex.Store({

   state: {
      isLoggedIn: null,
      updateId:'',
   },
   mutations:{
      SET_IS_LOGGED_IN(state, data){
         return state.isLoggedIn = data;
      },
      updateId(state,data){
       return state.updateId = data;
      }
   },
   actions: {

   }
});

export default store;

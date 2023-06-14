 import accommodations from './components/accommodations/Accommodation.vue';
 import indexComponent from './components/indexComponent.vue';
 import accommodationDetail from './components/accommodations/AccommodationDetail.vue';
 

 export const routesss = [
    { path: '/', component:indexComponent },
    { path: '/accommodations', component:accommodations },
    { path: '/accommodations/detail/:accommodationId', component:accommodationDetail },
  ]

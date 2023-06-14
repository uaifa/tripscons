/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
window.Vue = Vue;
require('./bootstrap'); 
import VueRouter from 'vue-router';
import VueSweetalert2 from 'vue-sweetalert2';
import Axios from 'axios';
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
import "font-awesome/scss/font-awesome.scss";
import Embed from 'v-video-embed'

Vue.use(Embed);
// Vue Sweet Alert2

Vue.use(VueSweetalert2);
import * as VueGoogleMaps from 'vue2-google-maps';
Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyBURKqVNB1eT1EPIj4KqCh2N4zwlo_aLW4',
        libraries: 'places',
    },
    installComponents: true
})
import VueCountryCode from "vue-country-code-select";

// import * as VeeValidate from 'vee-validate';
// Vue.use(VeeValidate)
    // import { ValidationProvider } from 'vee-validate';
    // Vue.component('VeeValidate', ValidationProvider);

Vue.use(VueCountryCode);

// import MiddlewarePlugin from 'vue-router-middleware-plugin'
// import routers from '@/path-to-router'
 
// Vue.use(MiddlewarePlugin);
import VueInputRestrictionDirectives from 'vue-input-restriction-directives';
 
Vue.use(VueInputRestrictionDirectives);

//import VoerroTagsInput from '@voerro/vue-tagsinput';
import VoerroTagsInput from '@voerro/vue-tagsinput';
Vue.component('tags-input', VoerroTagsInput);
//Vue.component('tags-input', VoerroTagsInput);
import myHelpers from "./helper.js";
//Vue.http.headers.common['Access-Control-Allow-Origin'] = true;
window.axios = Axios;
let base_url = window.location.origin; //new URL(location.href);
if (base_url + '/' == 'http://127.0.0.1:8000/') {
    axios.defaults.baseURL = 'http://127.0.0.1:8000/';
} else if (base_url + '/' == 'http://tripscon.local/') {
    axios.defaults.baseURL = 'http://tripscon.local/';
} else if (base_url + '/' == 'http://127.0.0.1:8007/') {
    axios.defaults.baseURL = 'http://127.0.0.1:8007/';
} else if (base_url + '/' == 'http://localhost:8000/') {
    axios.defaults.baseURL = 'http://localhost:8000/';
} else {
    // axios.defaults.baseURL = 'https://tripsconpro.wanologicalsolutions.com/';
    axios.defaults.baseURL = 'http://tripscon.me/';
}




//axios.defaults.headers.common['Access-Control-Allow-Origin'] = true;
//axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// import VueConfirmDialog from 'vue-confirm-dialog'

// Vue.use(VueConfirmDialog)
// Vue.component('vue-confirm-dialog', VueConfirmDialog.default)


const helpers = {
    install(Vue, options) {
        Vue.prototype.$helpers = myHelpers; // we use $ because it's the Vue convention
    }
};
Vue.use(helpers);

Vue.prototype.$imagePath = '/assets/uploads/';
Vue.prototype.$userImagePath = '/assets/uploads/users/';

//date formatting
import moment from 'moment';

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY')
    }
});

// Vue Notifications
import Snotify, { SnotifyPosition } from 'vue-snotify'; // 1. Import Snotify
import 'vue-snotify/styles/material.css';
// 2. Use Snotify
// You can pass {config, options} as second argument. See the next example or setConfig in [API] section
const options = {
    toast: {
        position: SnotifyPosition.rightTop,
        timeout: 5000
    }
};
Vue.use(Snotify, options);
Vue.use(require('vue-moment'));

import EasySlider from 'vue-easy-slider'
Vue.use(EasySlider)

import VCalendar from 'v-calendar';

// Use v-calendar & v-date-picker components
Vue.use(VCalendar, {

});
import Multiselect from "vue-multiselect";
Vue.component('multiselect', Multiselect);

Vue.component('pagination', require('laravel-vue-pagination'));


import store from './store/index';

// import money from 'v-money'
// register directive v-money and component <money>
// Vue.use(money, {precision: 4})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))



//  middleware
import auth from './middleware/auth';
import checkUserType from './middleware/checkUserType';
/**
 * @Description Web Views
 * @Author Mubasher Hussain
 */
import accommodations from './components/accommodations/Accommodation.vue';
import indexComponent from './components/indexComponent.vue';
import accommodationDetail from './components/accommodations/AccommodationDetail.vue';
import DataClean from './components/DataClean.vue';
/*
@22-12-21
@Rehan Hussain
@Host Routes
*/
import hosts from './components/host/Index.vue';
import hostDetail from './components/host/Detail.vue';

/* Host Routes Ended Here */

/* Vechile Routes Start Here */
import vechiles from './components/vechile/Index.vue';
import vechileDetail from './components/vechile/Detail.vue';

/* Vechile Routes Ended Here */

/* Activity  Routes Start Here */
import experiences from './components/experiences/Index.vue';
import experienceDetail from './components/experiences/Detail.vue';

/* Activity  Routes Ended  Here */
/* Meal  Routes Start Here */
import meals from './components/meal/Index.vue';
import mealDetail from './components/meal/Detail.vue';

/* Meal  Routes Ended  Here */

/* Trip  Routes Start Here */
import trips from './components/trip/Index.vue';
import tripDetail from './components/trip/Detail.vue';

/* Mates  Routes Start Here */
import mates from './components/mates/Index.vue';
import matesDetail from './components/mates/Detail.vue';


/* Gudie  Routes Start Here */
import guides from './components/guides/Index.vue';
import guideDetail from './components/guides/Detail.vue';
import guideEdit from './components/guides/Edit.vue';
import guideAdd from './components/guides/Add.vue';
import serviceGuide from './components/services/guides/Index.vue';
import guiderDetail from './components/guides/GuiderDetail.vue';
import guideDetails from './components/guides/GuideDetail.vue';

/* services providers routes start here */
import servicesProviderDetail from './components/services/ServicesProviderDetail';
/* Visa Consultant  Routes Start Here */
import visaConsultants from './components/visa_consultants/Index.vue';
import visaConsultantDetail from './components/visa_consultants/Detail.vue';

/* Movie Maker  Routes Start Here */
import movieMakers from './components/movie_makers/Index.vue';
import movieMakerDetail from './components/movie_makers/Detail.vue';

/* Trip Operators  Routes Start Here */
import tripoperators from './components/trip_operators/Index.vue';
import tripoperatorDetail from './components/trip_operators/Detail.vue';

/* Restaurant Routes Start Here */
import restaurants from './components/restaurants/Index.vue';
import restaurantDetail from './components/restaurants/Detail.vue';

import loginComponent from './components/auth/LoginComponent.vue';

/* traveler routes */
import accountInfo from './components/users/AccountInfoComponent.vue';
import userDashboard from './components/users/UserDashboard.vue';
import userBooking from './components/users/Booking.vue';

import Interests from './components/users/Interests.vue';
import About from './components/users/About.vue';
import Identification from './components/users/Identification.vue';
import forgotPassword from './components/auth/ForgetPasswordComponent.vue';
import sendEmail from './components/auth/sendEmailForResetPassword.vue';

//Vue.component('forget-password', require('./components/auth/ForgetPasswordComponent.vue').default);
/* host routes */
import hostDashboard from './components/host/Dashboard.vue';
import hostBooking from './components/host/Booking.vue';
import hostAccommodations from './components/host/accommodations/Index.vue';
import hostAccommodationDetail from './components/host/accommodations/Detail.vue';
import addAccommodationsStep1 from './components/host/accommodations/addstep1.vue';
import addAccommodationsStep2 from './components/host/accommodations/addstep2.vue';
import addAccommodationsStep2a from './components/host/accommodations/addstep2a.vue';
import addAccommodationsStep3 from './components/host/accommodations/addstep3.vue';
import addAccommodationsStep4 from './components/host/accommodations/addstep4.vue';
import addAccommodationsStep5 from './components/host/accommodations/addstep5.vue';
import addAccommodationsStep6 from './components/host/accommodations/addstep6.vue';
import addAccommodationsStep7 from './components/host/accommodations/addstep7.vue';
//for meal
import hostMeals from './components/host/meals/Index.vue';
import hostMealDetail from './components/host/meals/Detail.vue';
import addMealStep1 from './components/host/meals/addstep1.vue';
//for transport
import hostTransports from './components/host/transports/Index.vue';
import hostTransportDetail from './components/host/transports/Detail.vue';
import addTransportStep1 from './components/host/transports/addstep1.vue';

//for transport
import hostExperiencies from './components/host/experiencies/Index.vue';
import hostExperienceDetail from './components/host/experiencies/Detail.vue';
import addExperienceStep1 from './components/host/experiencies/addstep1.vue';

//for booking
import accommodationSummary from './components/bookings/accommodationSummary.vue';
import vehicleSummary from './components/vechile/vehicleSummary.vue';
import mealSummary from './components/meal/mealSummary.vue';
import experienceSummary from './components/experiences/experienceSummary.vue';

import checkout from './components/bookings/checkout.vue';
import thankyou from './components/bookings/thankyou.vue';


import notfound from './components/notfound.vue';
import thanku from './components/auth/thanku.vue';
// datatable vue js 
import Datatable from 'vue2-datatable-component';
Vue.component('datatable', Datatable);


function setAuth() {
    const auth = localStorage.getItem('user-token');
    axios.defaults.headers.common['Authorization'] = `Bearer ${auth}`
}

Vue.use(VueRouter);
const routes = [
        { path: '/', component: indexComponent },
        { path: '/notfound', component: notfound },
        { path: '/accommodations/', name: 'accommodations', component: accommodations },
        { path: '/accommodations/detail/:accommodationId', component: accommodationDetail },
        { path: '/data-clean', component: DataClean },
        
        { path: '/forget-password/:id/:token', component: forgotPassword },
        { path: '/send-email-for-reset-password', component: sendEmail },
        { path: '/thanku/:email', component: thanku },
        
        { path: '/hosts', component: hosts },
        { path: '/hosts/detail/:hostId', component: hostDetail },
        { path: '/vechiles', name: 'vechiles', component: vechiles },
        { path: '/vechiles/detail/:vechileId', component: vechileDetail },

        { path: '/experiences', name: 'experiences', component: experiences },
        { path: '/experiences/detail/:experienceId', component: experienceDetail },

        { path: '/meals', name: 'meals', component: meals },
        { path: '/meals/detail/:mealId', component: mealDetail },
        { path: '/trips', component: trips },
        { path: '/trips/detail/:tripId', component: tripDetail },

        // for guide
        { path: '/guides', component: guides },
        { path: '/guides/:guiderId', component: guiderDetail },
        { path: '/guides/detail/:guideId', component: guideDetail },
        { path: '/guides/details/:guideId', component: guideDetails },
        
        

        // for services provider

        { path: '/services/provider/detail/:serviceProviderId', component: servicesProviderDetail },

        // { path: '/guides/edit/:guideId', component: guideEdit },

        { path: '/visaconsultants', component: guides },
        { path: '/visaConsultants', component: visaConsultants },
        { path: '/visaConsultants/detail/:visaConsultantId', component: visaConsultantDetail },

        { path: '/moviemakers', component: guides },
        { path: '/movieMakers', component: movieMakers },
        { path: '/movieMakers/detail/:movieMakerId', component: movieMakerDetail },

        { path: '/user-login', name: 'login', component: loginComponent },

        {
            path: '/account_info',
            name: 'getUserSetting',
            component: accountInfo,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/user/setting',
            component: userDashboard,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/user/bookings',
            component: userBooking,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/user/interests',
            component: Interests,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/user/about',
            component: About,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },

        {
            path: '/user/identification',
            component: Identification,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        //host dashboard
        {
            path: '/host/dashboard',
            component: hostDashboard,
            meta: {
                middleware: [checkUserType],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/bookings',
            component: hostBooking,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },

        
        {
            path: '/host/accommodations',
            component: hostAccommodations,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/accommodations/detail/:accommodationId',
            component: hostAccommodationDetail,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/accommodations/add/step1',
            component: addAccommodationsStep1,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/accommodations/add/step2',
            component: addAccommodationsStep2,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/accommodations/add/step2a',
            component: addAccommodationsStep2a,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/accommodations/add/step3',
            component: addAccommodationsStep3,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },

        {
            path: '/host/accommodations/add/step4',
            component: addAccommodationsStep4,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/accommodations/add/step5',
            component: addAccommodationsStep5,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/accommodations/add/step6',
            component: addAccommodationsStep6,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/accommodations/add/step7',
            component: addAccommodationsStep7,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        //for meals
        {
            path: '/host/meals',
            component: hostMeals,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/meals/detail/:mealId',
            component: hostMealDetail,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/meals/add/step1',
            component: addMealStep1,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        //for transports
        {
            path: '/host/transports',
            component: hostTransports,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/transports/detail/:transportId',
            component: hostTransportDetail,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/transports/add/step1',
            component: addTransportStep1,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },

        //for experiencies
        {
            path: '/host/experiences',
            component: hostExperiencies,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/experiences/detail/:experienceId',
            component: hostExperienceDetail,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/host/experiences/add/step1',
            component: addExperienceStep1,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },

        //for guides
        {
            path: '/guides',
            component: guides,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/guides/detail/:guideId',
            component: guideDetail,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/guides/edit/:guideId',
            component: guideEdit,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/guide/add',
            component: guideAdd,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/services/guides',
            component: serviceGuide,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },

        //for booking
        {
            path: '/bookings/accommodation-summary',
            component: accommodationSummary,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        //for vehicle
        {
            path: '/bookings/vehicle-summary',
            component: vehicleSummary,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        //for meal
        {
            path: '/bookings/meal-summary',
            component: mealSummary,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        //for experience
        {
            path: '/bookings/experience-summary',
            component: experienceSummary,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/bookings/checkout',
            component: checkout,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        {
            path: '/bookings/thankyou',
            component: thankyou,
            meta: {
                middleware: ['auth','checkUserType'],
            },
            beforeEnter: (to, from, next) => {
                setAuth()
                axios.get('/api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'login' })
                })
            }
        },
        






        { path: '/tripoperators', component: guides },
        // { path: '/TripOperators', component: tripoperators },
        { path: '/TripOperators/detail/:tripOperatorId', component: tripoperatorDetail },

        { path: '/restaurants', component: restaurants },
        { path: '/restaurants/detail/:restaurantId/:type?', component: restaurantDetail },

        { path: '/tripmates', component: guides },
        { path: '/mates', component: mates },
        { path: '/mates/detail/:mateId', component: matesDetail },
    ]
    //alert('inside without web routes');
    // 3. Create the router instance and pass the `routes` option
    // You can pass in additional options here, but let's
    // keep it simple for now.
const router = new VueRouter({
    routes, // short for `routes: routes`
    mode: 'history',
})

//
Vue.component('index-component', require('./components/indexComponent.vue').default);
Vue.component('topmenu', require('./components/NavComponent.vue').default);
Vue.component('loginpop', require('./components/auth/LoginPopComponent.vue').default);
//Vue.component('account-info', require('./components/users/AccountInfoComponent.vue').default);
//Vue.component('login', require('./components/auth/LoginComponent.vue').default);
Vue.component('signup', require('./components/auth/SignupComponent.vue').default);

Vue.component('update-password', require('./components/auth/ConfirmPasswordComponent.vue').default);
Vue.component('where-to-go-modal', require('./components/models/WhereToGoComponent.vue').default);
Vue.component('my-test-modal', require('./components/models/MyTestComponent.vue').default);
Vue.component('custom-trip', require('./components/models/CustomTripComponent.vue').default);
Vue.component('change-password', require('./components/auth/ChangePasswordComponent.vue').default);
Vue.component('add-places', require('./components/host/AddPlaces.vue').default);
Vue.component('asset-tags', require('./components/host/accommodations/tags.vue').default);
Vue.component('loader', require('./components/Loader.vue').default);
Vue.component('add-services', require('./components/models/AddService.vue').default);
Vue.component('vehicle-booking', require('./components/vechile/Booking.vue').default);
Vue.component('accommodation-booking', require('./components/accommodations/Booking.vue').default);
Vue.component('meal-booking', require('./components/meal/Booking.vue').default);
Vue.component('experience-booking', require('./components/experiences/Booking.vue').default);
Vue.component('user-profile', require('./components/users/UserProfile.vue').default);
Vue.component('contact-us', require('./components/users/ContactUs.vue').default);
Vue.component('booking-detail', require('./components/bookings/BookingDetail.vue').default);
Vue.component('cancel-booking', require('./components/bookings/CancelBooking.vue').default);
Vue.component('meal-booking-detail', require('./components/bookings/MealBookingDetail.vue').default);
let loader = true;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// const app = new Vue({
//    router
//  }).$mount('#app');

const app = new Vue({
    el: '#app',
    router,
    store
});

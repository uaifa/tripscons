import AppListing from '../app-components/Listing/AppListing';
var converter = require('number-to-words');
import moment from 'moment';

Vue.filter('toWords', function (value) {
    if (!value) return '';
    return converter.toWords(value);
})

Vue.component('booking-listing', {
    mixins: [AppListing]
});
Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD-MM-YYYY')
    }
});

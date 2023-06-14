import AppForm from '../app-components/Form/AppForm';

Vue.component('booking-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                user_id:  '' ,
                provider_id:  '' ,
                module_name:  '' ,
                module_id:  '' ,
                price:  '' ,
                start_date:  '' ,
                end_date:  '' ,
                no_of_nights:  '' ,
                total:  '' ,
                discount:  '' ,
                grand_total:  '' ,
                status:  '' ,
                payment_status:  '' ,
                sub_total:  '' ,
                booking_number:  '' ,
                partial_amt:  '' ,
                partial_amt_in_percentage:  '' ,
                provider_name:  '' ,
                booking_type:  '' ,
                bookable:  '' ,
                
            }
        }
    }

});
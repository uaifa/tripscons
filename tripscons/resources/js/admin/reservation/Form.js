import AppForm from '../app-components/Form/AppForm';

Vue.component('reservation-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                reference_no:  '' ,
                bookable:  '' ,
                bookable_id:  '' ,
                room_id:  '' ,
                provider_user_id:  '' ,
                user_id:  '' ,
                date_from:  '' ,
                date_to:  '' ,
                booking_detail:  '' ,
                subtotal:  '' ,
                discounttotal:  '' ,
                grandtotal:  '' ,
                minimum_payable_amount:  '' ,
                status:  '' ,
                reservation_type:  '' ,
                remaining_amount:  '' ,
                
            }
        }
    }

});
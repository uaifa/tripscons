import AppForm from '../app-components/Form/AppForm';

Vue.component('booking-activity-log-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                booking_id:  '' ,
                admin_user_id:  '' ,
                status:  '' ,
                comments:  '' ,
                
            }
        }
    }

});
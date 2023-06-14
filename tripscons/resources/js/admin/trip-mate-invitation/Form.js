import AppForm from '../app-components/Form/AppForm';

Vue.component('trip-mate-invitation-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                trip_id:  '' ,
                request_user_id:  '' ,
                to_user_id:  '' ,
                status:  '' ,
                
            }
        }
    }

});
import AppForm from '../app-components/Form/AppForm';

Vue.component('trip-activity-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                image:  '' ,
                trip_id:  '' ,
                
            }
        }
    }

});
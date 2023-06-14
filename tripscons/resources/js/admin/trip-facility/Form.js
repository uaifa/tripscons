import AppForm from '../app-components/Form/AppForm';

Vue.component('trip-facility-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                title:  '' ,
                description:  '' ,
                image:  '' ,
                trip_id:  '' ,
                is_included:  '' ,
                
            }
        }
    }

});
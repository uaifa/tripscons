import AppForm from '../app-components/Form/AppForm';

Vue.component('trip-mate-destination-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                trip_id:  '' ,
                destination:  '' ,
                lat:  '' ,
                lng:  '' ,
                city:  '' ,
                country:  '' ,
                type:  '' ,
                
            }
        }
    }

});
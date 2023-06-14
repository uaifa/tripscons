import AppForm from '../app-components/Form/AppForm';

Vue.component('trip-mate-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                user_id:  '' ,
                trip_id:  '' ,
                image_ids:  '' ,
                pick_up:  '' ,
                destination:  '' ,
                lat:  '' ,
                lng:  '' ,
                city:  '' ,
                country:  '' ,
                date_from:  '' ,
                date_to:  '' ,
                activities:  '' ,
                description:  '' ,
                
            }
        }
    }

});
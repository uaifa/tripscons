import AppForm from '../app-components/Form/AppForm';

Vue.component('device-detail-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                user_id:  '' ,
                device_id:  '' ,
                device_token:  '' ,
                device_type:  '' ,
                status:  '' ,
                
            }
        }
    }

});
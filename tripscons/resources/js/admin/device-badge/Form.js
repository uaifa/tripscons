import AppForm from '../app-components/Form/AppForm';

Vue.component('device-badge-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                user_id:  '' ,
                type:  '' ,
                count:  '' ,
                status:  '' ,
                
            }
        }
    }

});
import AppForm from '../app-components/Form/AppForm';

Vue.component('notification-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                user_id:  '' ,
                message:  '' ,
                uri:  '' ,
                seen:  false ,
                status:  false ,
                type:  '' ,
                ref_id:  '' ,
                user_role:  '' ,
                
            }
        }
    }

});
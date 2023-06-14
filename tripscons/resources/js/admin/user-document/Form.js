import AppForm from '../app-components/Form/AppForm';

Vue.component('user-document-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                user_id:  '' ,
                type:  '' ,
                front:  '' ,
                back:  '' ,
                expiry:  '' ,
                status:  '' ,
                
            }
        }
    }

});
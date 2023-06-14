import AppForm from '../app-components/Form/AppForm';

Vue.component('accommodation-sub-type-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                type_id:  '' ,
                name:  '' ,
                
            }
        }
    }

});
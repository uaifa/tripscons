import AppForm from '../app-components/Form/AppForm';

Vue.component('facility-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                module_type:  '' ,
                status:  '' ,
                image:  '' ,
                
            }
        }
    }

});
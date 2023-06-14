import AppForm from '../app-components/Form/AppForm';

Vue.component('vehicle-type-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                type:  '' ,
                
            }
        }
    }

});
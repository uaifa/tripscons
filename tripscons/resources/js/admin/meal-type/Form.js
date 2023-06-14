import AppForm from '../app-components/Form/AppForm';

Vue.component('meal-type-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                status:  '' ,
                active:  false ,
                
            }
        }
    }

});
import AppForm from '../app-components/Form/AppForm';

Vue.component('meal-ingrediant-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                
            }
        }
    }

});
import AppForm from '../app-components/Form/AppForm';

Vue.component('trip-type-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                category_id:  '' ,
                
            }
        }
    }

});
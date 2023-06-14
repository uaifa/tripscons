import AppForm from '../app-components/Form/AppForm';

Vue.component('activity-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                image:  '' ,
                
            }
        }
    }

});
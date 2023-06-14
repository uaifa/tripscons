import AppForm from '../app-components/Form/AppForm';

Vue.component('user-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                type:  '' ,
                email:  '' ,
                password:  '' ,
                phone:  '' ,
                pin_code:  '' ,
                country_code:  '' ,
                postal_code:  '' ,
                address:  '' ,
                service_provider_type:  '' ,
                gender:  '' ,
                country:  '' ,
                state:  '' ,
                city:  '' ,
                currency:  '' ,
                lng:  '' ,
                lat:  '' ,
                social_platform:  '' ,
                social_platform_id:  '' ,
                device_type:  '' ,
                device_token:  '' ,
                about:  '' ,
                role_id:  '' ,
                verified:  '' ,
                date_of_birth:  '' ,
                is_mate:  false ,
                is_host:  '' ,
                is_traveler:  '' ,
                api_token:  '' ,
                is_profile_complete:  false ,
                role_profile_id:  '' ,
                rating:  '' ,
                no_of_reviews:  '' ,
                is_phone_verified:  '' ,
                email_verified_at:  '' ,
                phone_verified_at:  '' ,
                languages:  '' ,
                image:  '' ,
                status:  '' ,
                user_module_type:  '' ,
                stripe_id:  '' ,
                pm_type:  '' ,
                pm_last_four:  '' ,
                trial_ends_at:  '' ,
                
            }
        }
    }

});
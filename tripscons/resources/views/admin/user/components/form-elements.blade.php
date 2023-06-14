<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.user.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('is_phone_verified'), 'has-success': fields.is_phone_verified && fields.is_phone_verified.valid }">
    <label for="is_phone_verified" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.is_phone_verified') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.is_phone_verified" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('is_phone_verified'), 'form-control-success': fields.is_phone_verified && fields.is_phone_verified.valid}" id="is_phone_verified" name="is_phone_verified" placeholder="{{ trans('admin.user.columns.is_phone_verified') }}">
        <div v-if="errors.has('is_phone_verified')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('is_phone_verified') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('is_mate'), 'has-success': fields.is_mate && fields.is_mate.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="is_mate" type="checkbox" v-model="form.is_mate" v-validate="''" data-vv-name="is_mate"  name="is_mate_fake_element">
        <label class="form-check-label" for="is_mate">
            {{ trans('admin.user.columns.is_mate') }}
        </label>
        <input type="hidden" name="is_mate" :value="form.is_mate">
        <div v-if="errors.has('is_mate')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('is_mate') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('is_host'), 'has-success': fields.is_host && fields.is_host.valid }">
    <label for="is_host" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.is_host') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.is_host" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('is_host'), 'form-control-success': fields.is_host && fields.is_host.valid}" id="is_host" name="is_host" placeholder="{{ trans('admin.user.columns.is_host') }}">
        <div v-if="errors.has('is_host')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('is_host') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('is_traveler'), 'has-success': fields.is_traveler && fields.is_traveler.valid }">
    <label for="is_traveler" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.is_traveler') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.is_traveler" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('is_traveler'), 'form-control-success': fields.is_traveler && fields.is_traveler.valid}" id="is_traveler" name="is_traveler" placeholder="{{ trans('admin.user.columns.is_traveler') }}">
        <div v-if="errors.has('is_traveler')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('is_traveler') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('api_token'), 'has-success': fields.api_token && fields.api_token.valid }">
    <label for="api_token" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.api_token') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.api_token" v-validate="''" id="api_token" name="api_token"></textarea>
        </div>
        <div v-if="errors.has('api_token')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('api_token') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('is_profile_complete'), 'has-success': fields.is_profile_complete && fields.is_profile_complete.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="is_profile_complete" type="checkbox" v-model="form.is_profile_complete" v-validate="''" data-vv-name="is_profile_complete"  name="is_profile_complete_fake_element">
        <label class="form-check-label" for="is_profile_complete">
            {{ trans('admin.user.columns.is_profile_complete') }}
        </label>
        <input type="hidden" name="is_profile_complete" :value="form.is_profile_complete">
        <div v-if="errors.has('is_profile_complete')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('is_profile_complete') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('role_profile_id'), 'has-success': fields.role_profile_id && fields.role_profile_id.valid }">
    <label for="role_profile_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.role_profile_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.role_profile_id" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('role_profile_id'), 'form-control-success': fields.role_profile_id && fields.role_profile_id.valid}" id="role_profile_id" name="role_profile_id" placeholder="{{ trans('admin.user.columns.role_profile_id') }}">
        <div v-if="errors.has('role_profile_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('role_profile_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('rating'), 'has-success': fields.rating && fields.rating.valid }">
    <label for="rating" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.rating') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.rating" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('rating'), 'form-control-success': fields.rating && fields.rating.valid}" id="rating" name="rating" placeholder="{{ trans('admin.user.columns.rating') }}">
        <div v-if="errors.has('rating')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('rating') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('no_of_reviews'), 'has-success': fields.no_of_reviews && fields.no_of_reviews.valid }">
    <label for="no_of_reviews" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.no_of_reviews') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.no_of_reviews" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('no_of_reviews'), 'form-control-success': fields.no_of_reviews && fields.no_of_reviews.valid}" id="no_of_reviews" name="no_of_reviews" placeholder="{{ trans('admin.user.columns.no_of_reviews') }}">
        <div v-if="errors.has('no_of_reviews')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('no_of_reviews') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('email_verified_at'), 'has-success': fields.email_verified_at && fields.email_verified_at.valid }">
    <label for="email_verified_at" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.email_verified_at') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.email_verified_at" :config="datetimePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('email_verified_at'), 'form-control-success': fields.email_verified_at && fields.email_verified_at.valid}" id="email_verified_at" name="email_verified_at" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('email_verified_at')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email_verified_at') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('verified'), 'has-success': fields.verified && fields.verified.valid }">
    <label for="verified" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.verified') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.verified" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('verified'), 'form-control-success': fields.verified && fields.verified.valid}" id="verified" name="verified" placeholder="{{ trans('admin.user.columns.verified') }}">
        <div v-if="errors.has('verified')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('verified') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('phone_verified_at'), 'has-success': fields.phone_verified_at && fields.phone_verified_at.valid }">
    <label for="phone_verified_at" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.phone_verified_at') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.phone_verified_at" :config="datetimePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('phone_verified_at'), 'form-control-success': fields.phone_verified_at && fields.phone_verified_at.valid}" id="phone_verified_at" name="phone_verified_at" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('phone_verified_at')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('phone_verified_at') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('languages'), 'has-success': fields.languages && fields.languages.valid }">
    <label for="languages" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.languages') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.languages" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('languages'), 'form-control-success': fields.languages && fields.languages.valid}" id="languages" name="languages" placeholder="{{ trans('admin.user.columns.languages') }}">
        <div v-if="errors.has('languages')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('languages') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('image'), 'has-success': fields.image && fields.image.valid }">
    <label for="image" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.image') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.image" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('image'), 'form-control-success': fields.image && fields.image.valid}" id="image" name="image" placeholder="{{ trans('admin.user.columns.image') }}">
        <div v-if="errors.has('image')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('image') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <label for="status" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.status') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.status" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('status'), 'form-control-success': fields.status && fields.status.valid}" id="status" name="status" placeholder="{{ trans('admin.user.columns.status') }}">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_module_type'), 'has-success': fields.user_module_type && fields.user_module_type.valid }">
    <label for="user_module_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.user_module_type') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.user_module_type" v-validate="''" id="user_module_type" name="user_module_type"></textarea>
        </div>
        <div v-if="errors.has('user_module_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_module_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('stripe_id'), 'has-success': fields.stripe_id && fields.stripe_id.valid }">
    <label for="stripe_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.stripe_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.stripe_id" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('stripe_id'), 'form-control-success': fields.stripe_id && fields.stripe_id.valid}" id="stripe_id" name="stripe_id" placeholder="{{ trans('admin.user.columns.stripe_id') }}">
        <div v-if="errors.has('stripe_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('stripe_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pm_type'), 'has-success': fields.pm_type && fields.pm_type.valid }">
    <label for="pm_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.pm_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.pm_type" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('pm_type'), 'form-control-success': fields.pm_type && fields.pm_type.valid}" id="pm_type" name="pm_type" placeholder="{{ trans('admin.user.columns.pm_type') }}">
        <div v-if="errors.has('pm_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pm_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pm_last_four'), 'has-success': fields.pm_last_four && fields.pm_last_four.valid }">
    <label for="pm_last_four" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.pm_last_four') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.pm_last_four" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('pm_last_four'), 'form-control-success': fields.pm_last_four && fields.pm_last_four.valid}" id="pm_last_four" name="pm_last_four" placeholder="{{ trans('admin.user.columns.pm_last_four') }}">
        <div v-if="errors.has('pm_last_four')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pm_last_four') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('date_of_birth'), 'has-success': fields.date_of_birth && fields.date_of_birth.valid }">
    <label for="date_of_birth" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.date_of_birth') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.date_of_birth" :config="datePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('date_of_birth'), 'form-control-success': fields.date_of_birth && fields.date_of_birth.valid}" id="date_of_birth" name="date_of_birth" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('date_of_birth')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('date_of_birth') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('role_id'), 'has-success': fields.role_id && fields.role_id.valid }">
    <label for="role_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.role_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.role_id" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('role_id'), 'form-control-success': fields.role_id && fields.role_id.valid}" id="role_id" name="role_id" placeholder="{{ trans('admin.user.columns.role_id') }}">
        <div v-if="errors.has('role_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('role_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('type'), 'has-success': fields.type && fields.type.valid }">
    <label for="type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.type" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('type'), 'form-control-success': fields.type && fields.type.valid}" id="type" name="type" placeholder="{{ trans('admin.user.columns.type') }}">
        <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('gender'), 'has-success': fields.gender && fields.gender.valid }">
    <label for="gender" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.gender') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.gender" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('gender'), 'form-control-success': fields.gender && fields.gender.valid}" id="gender" name="gender" placeholder="{{ trans('admin.user.columns.gender') }}">
        <div v-if="errors.has('gender')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('gender') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('email'), 'has-success': fields.email && fields.email.valid }">
    <label for="email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.email') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.email" v-validate="'email'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('email'), 'form-control-success': fields.email && fields.email.valid}" id="email" name="email" placeholder="{{ trans('admin.user.columns.email') }}">
        <div v-if="errors.has('email')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('password'), 'has-success': fields.password && fields.password.valid }">
    <label for="password" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.password') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="password" v-model="form.password" v-validate="'min:7'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('password'), 'form-control-success': fields.password && fields.password.valid}" id="password" name="password" placeholder="{{ trans('admin.user.columns.password') }}" ref="password">
        <div v-if="errors.has('password')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('password_confirmation'), 'has-success': fields.password_confirmation && fields.password_confirmation.valid }">
    <label for="password_confirmation" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.password_repeat') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="password" v-model="form.password_confirmation" v-validate="'confirmed:password|min:7'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('password_confirmation'), 'form-control-success': fields.password_confirmation && fields.password_confirmation.valid}" id="password_confirmation" name="password_confirmation" placeholder="{{ trans('admin.user.columns.password') }}" data-vv-as="password">
        <div v-if="errors.has('password_confirmation')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password_confirmation') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('phone'), 'has-success': fields.phone && fields.phone.valid }">
    <label for="phone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.phone') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.phone" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('phone'), 'form-control-success': fields.phone && fields.phone.valid}" id="phone" name="phone" placeholder="{{ trans('admin.user.columns.phone') }}">
        <div v-if="errors.has('phone')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('phone') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pin_code'), 'has-success': fields.pin_code && fields.pin_code.valid }">
    <label for="pin_code" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.pin_code') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.pin_code" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('pin_code'), 'form-control-success': fields.pin_code && fields.pin_code.valid}" id="pin_code" name="pin_code" placeholder="{{ trans('admin.user.columns.pin_code') }}">
        <div v-if="errors.has('pin_code')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pin_code') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('country_code'), 'has-success': fields.country_code && fields.country_code.valid }">
    <label for="country_code" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.country_code') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.country_code" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('country_code'), 'form-control-success': fields.country_code && fields.country_code.valid}" id="country_code" name="country_code" placeholder="{{ trans('admin.user.columns.country_code') }}">
        <div v-if="errors.has('country_code')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('country_code') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('postal_code'), 'has-success': fields.postal_code && fields.postal_code.valid }">
    <label for="postal_code" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.postal_code') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.postal_code" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('postal_code'), 'form-control-success': fields.postal_code && fields.postal_code.valid}" id="postal_code" name="postal_code" placeholder="{{ trans('admin.user.columns.postal_code') }}">
        <div v-if="errors.has('postal_code')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('postal_code') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('address'), 'has-success': fields.address && fields.address.valid }">
    <label for="address" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.address') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.address" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('address'), 'form-control-success': fields.address && fields.address.valid}" id="address" name="address" placeholder="{{ trans('admin.user.columns.address') }}">
        <div v-if="errors.has('address')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('address') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('service_provider_type'), 'has-success': fields.service_provider_type && fields.service_provider_type.valid }">
    <label for="service_provider_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.service_provider_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.service_provider_type" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('service_provider_type'), 'form-control-success': fields.service_provider_type && fields.service_provider_type.valid}" id="service_provider_type" name="service_provider_type" placeholder="{{ trans('admin.user.columns.service_provider_type') }}">
        <div v-if="errors.has('service_provider_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('service_provider_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('country'), 'has-success': fields.country && fields.country.valid }">
    <label for="country" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.country') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.country" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('country'), 'form-control-success': fields.country && fields.country.valid}" id="country" name="country" placeholder="{{ trans('admin.user.columns.country') }}">
        <div v-if="errors.has('country')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('country') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('about'), 'has-success': fields.about && fields.about.valid }">
    <label for="about" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.about') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.about" v-validate="''" id="about" name="about"></textarea>
        </div>
        <div v-if="errors.has('about')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('about') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('state'), 'has-success': fields.state && fields.state.valid }">
    <label for="state" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.state') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.state" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('state'), 'form-control-success': fields.state && fields.state.valid}" id="state" name="state" placeholder="{{ trans('admin.user.columns.state') }}">
        <div v-if="errors.has('state')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('state') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('city'), 'has-success': fields.city && fields.city.valid }">
    <label for="city" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.city') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.city" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('city'), 'form-control-success': fields.city && fields.city.valid}" id="city" name="city" placeholder="{{ trans('admin.user.columns.city') }}">
        <div v-if="errors.has('city')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('city') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('currency'), 'has-success': fields.currency && fields.currency.valid }">
    <label for="currency" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.currency') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.currency" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('currency'), 'form-control-success': fields.currency && fields.currency.valid}" id="currency" name="currency" placeholder="{{ trans('admin.user.columns.currency') }}">
        <div v-if="errors.has('currency')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('currency') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('lng'), 'has-success': fields.lng && fields.lng.valid }">
    <label for="lng" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.lng') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.lng" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('lng'), 'form-control-success': fields.lng && fields.lng.valid}" id="lng" name="lng" placeholder="{{ trans('admin.user.columns.lng') }}">
        <div v-if="errors.has('lng')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('lng') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('lat'), 'has-success': fields.lat && fields.lat.valid }">
    <label for="lat" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.lat') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.lat" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('lat'), 'form-control-success': fields.lat && fields.lat.valid}" id="lat" name="lat" placeholder="{{ trans('admin.user.columns.lat') }}">
        <div v-if="errors.has('lat')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('lat') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('social_platform'), 'has-success': fields.social_platform && fields.social_platform.valid }">
    <label for="social_platform" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.social_platform') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.social_platform" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('social_platform'), 'form-control-success': fields.social_platform && fields.social_platform.valid}" id="social_platform" name="social_platform" placeholder="{{ trans('admin.user.columns.social_platform') }}">
        <div v-if="errors.has('social_platform')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('social_platform') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('social_platform_id'), 'has-success': fields.social_platform_id && fields.social_platform_id.valid }">
    <label for="social_platform_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.social_platform_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.social_platform_id" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('social_platform_id'), 'form-control-success': fields.social_platform_id && fields.social_platform_id.valid}" id="social_platform_id" name="social_platform_id" placeholder="{{ trans('admin.user.columns.social_platform_id') }}">
        <div v-if="errors.has('social_platform_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('social_platform_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('device_type'), 'has-success': fields.device_type && fields.device_type.valid }">
    <label for="device_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.device_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.device_type" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('device_type'), 'form-control-success': fields.device_type && fields.device_type.valid}" id="device_type" name="device_type" placeholder="{{ trans('admin.user.columns.device_type') }}">
        <div v-if="errors.has('device_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('device_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('device_token'), 'has-success': fields.device_token && fields.device_token.valid }">
    <label for="device_token" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.device_token') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.device_token" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('device_token'), 'form-control-success': fields.device_token && fields.device_token.valid}" id="device_token" name="device_token" placeholder="{{ trans('admin.user.columns.device_token') }}">
        <div v-if="errors.has('device_token')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('device_token') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('trial_ends_at'), 'has-success': fields.trial_ends_at && fields.trial_ends_at.valid }">
    <label for="trial_ends_at" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.trial_ends_at') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.trial_ends_at" :config="datetimePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('trial_ends_at'), 'form-control-success': fields.trial_ends_at && fields.trial_ends_at.valid}" id="trial_ends_at" name="trial_ends_at" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('trial_ends_at')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('trial_ends_at') }}</div>
    </div>
</div>



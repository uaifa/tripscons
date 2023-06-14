<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_id" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.trip-mate.columns.user_id') }}">
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('trip_id'), 'has-success': fields.trip_id && fields.trip_id.valid }">
    <label for="trip_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate.columns.trip_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.trip_id" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('trip_id'), 'form-control-success': fields.trip_id && fields.trip_id.valid}" id="trip_id" name="trip_id" placeholder="{{ trans('admin.trip-mate.columns.trip_id') }}">
        <div v-if="errors.has('trip_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('trip_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('image_ids'), 'has-success': fields.image_ids && fields.image_ids.valid }">
    <label for="image_ids" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate.columns.image_ids') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.image_ids" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('image_ids'), 'form-control-success': fields.image_ids && fields.image_ids.valid}" id="image_ids" name="image_ids" placeholder="{{ trans('admin.trip-mate.columns.image_ids') }}">
        <div v-if="errors.has('image_ids')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('image_ids') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pick_up'), 'has-success': fields.pick_up && fields.pick_up.valid }">
    <label for="pick_up" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate.columns.pick_up') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.pick_up" v-validate="''" id="pick_up" name="pick_up"></textarea>
        </div>
        <div v-if="errors.has('pick_up')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pick_up') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('destination'), 'has-success': fields.destination && fields.destination.valid }">
    <label for="destination" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate.columns.destination') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.destination" v-validate="''" id="destination" name="destination"></textarea>
        </div>
        <div v-if="errors.has('destination')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('destination') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('lat'), 'has-success': fields.lat && fields.lat.valid }">
    <label for="lat" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate.columns.lat') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.lat" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('lat'), 'form-control-success': fields.lat && fields.lat.valid}" id="lat" name="lat" placeholder="{{ trans('admin.trip-mate.columns.lat') }}">
        <div v-if="errors.has('lat')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('lat') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('lng'), 'has-success': fields.lng && fields.lng.valid }">
    <label for="lng" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate.columns.lng') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.lng" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('lng'), 'form-control-success': fields.lng && fields.lng.valid}" id="lng" name="lng" placeholder="{{ trans('admin.trip-mate.columns.lng') }}">
        <div v-if="errors.has('lng')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('lng') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('city'), 'has-success': fields.city && fields.city.valid }">
    <label for="city" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate.columns.city') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.city" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('city'), 'form-control-success': fields.city && fields.city.valid}" id="city" name="city" placeholder="{{ trans('admin.trip-mate.columns.city') }}">
        <div v-if="errors.has('city')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('city') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('country'), 'has-success': fields.country && fields.country.valid }">
    <label for="country" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate.columns.country') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.country" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('country'), 'form-control-success': fields.country && fields.country.valid}" id="country" name="country" placeholder="{{ trans('admin.trip-mate.columns.country') }}">
        <div v-if="errors.has('country')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('country') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('date_from'), 'has-success': fields.date_from && fields.date_from.valid }">
    <label for="date_from" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate.columns.date_from') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.date_from" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('date_from'), 'form-control-success': fields.date_from && fields.date_from.valid}" id="date_from" name="date_from" placeholder="{{ trans('admin.trip-mate.columns.date_from') }}">
        <div v-if="errors.has('date_from')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('date_from') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('date_to'), 'has-success': fields.date_to && fields.date_to.valid }">
    <label for="date_to" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate.columns.date_to') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.date_to" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('date_to'), 'form-control-success': fields.date_to && fields.date_to.valid}" id="date_to" name="date_to" placeholder="{{ trans('admin.trip-mate.columns.date_to') }}">
        <div v-if="errors.has('date_to')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('date_to') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('activities'), 'has-success': fields.activities && fields.activities.valid }">
    <label for="activities" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate.columns.activities') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.activities" v-validate="''" id="activities" name="activities"></textarea>
        </div>
        <div v-if="errors.has('activities')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('activities') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('description'), 'has-success': fields.description && fields.description.valid }">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate.columns.description') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.description" v-validate="''" id="description" name="description" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
        <div v-if="errors.has('description')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('description') }}</div>
    </div>
</div>



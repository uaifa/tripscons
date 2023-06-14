<div class="form-group row align-items-center" :class="{'has-danger': errors.has('trip_id'), 'has-success': fields.trip_id && fields.trip_id.valid }">
    <label for="trip_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate-destination.columns.trip_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.trip_id" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('trip_id'), 'form-control-success': fields.trip_id && fields.trip_id.valid}" id="trip_id" name="trip_id" placeholder="{{ trans('admin.trip-mate-destination.columns.trip_id') }}">
        <div v-if="errors.has('trip_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('trip_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('destination'), 'has-success': fields.destination && fields.destination.valid }">
    <label for="destination" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate-destination.columns.destination') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.destination" v-validate="''" id="destination" name="destination"></textarea>
        </div>
        <div v-if="errors.has('destination')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('destination') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('lat'), 'has-success': fields.lat && fields.lat.valid }">
    <label for="lat" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate-destination.columns.lat') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.lat" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('lat'), 'form-control-success': fields.lat && fields.lat.valid}" id="lat" name="lat" placeholder="{{ trans('admin.trip-mate-destination.columns.lat') }}">
        <div v-if="errors.has('lat')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('lat') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('lng'), 'has-success': fields.lng && fields.lng.valid }">
    <label for="lng" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate-destination.columns.lng') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.lng" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('lng'), 'form-control-success': fields.lng && fields.lng.valid}" id="lng" name="lng" placeholder="{{ trans('admin.trip-mate-destination.columns.lng') }}">
        <div v-if="errors.has('lng')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('lng') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('city'), 'has-success': fields.city && fields.city.valid }">
    <label for="city" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate-destination.columns.city') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.city" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('city'), 'form-control-success': fields.city && fields.city.valid}" id="city" name="city" placeholder="{{ trans('admin.trip-mate-destination.columns.city') }}">
        <div v-if="errors.has('city')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('city') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('country'), 'has-success': fields.country && fields.country.valid }">
    <label for="country" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate-destination.columns.country') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.country" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('country'), 'form-control-success': fields.country && fields.country.valid}" id="country" name="country" placeholder="{{ trans('admin.trip-mate-destination.columns.country') }}">
        <div v-if="errors.has('country')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('country') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('type'), 'has-success': fields.type && fields.type.valid }">
    <label for="type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate-destination.columns.type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.type" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('type'), 'form-control-success': fields.type && fields.type.valid}" id="type" name="type" placeholder="{{ trans('admin.trip-mate-destination.columns.type') }}">
        <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
    </div>
</div>



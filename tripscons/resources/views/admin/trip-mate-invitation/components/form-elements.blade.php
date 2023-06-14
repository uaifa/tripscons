<div class="form-group row align-items-center" :class="{'has-danger': errors.has('trip_id'), 'has-success': fields.trip_id && fields.trip_id.valid }">
    <label for="trip_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate-invitation.columns.trip_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.trip_id" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('trip_id'), 'form-control-success': fields.trip_id && fields.trip_id.valid}" id="trip_id" name="trip_id" placeholder="{{ trans('admin.trip-mate-invitation.columns.trip_id') }}">
        <div v-if="errors.has('trip_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('trip_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('request_user_id'), 'has-success': fields.request_user_id && fields.request_user_id.valid }">
    <label for="request_user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate-invitation.columns.request_user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.request_user_id" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('request_user_id'), 'form-control-success': fields.request_user_id && fields.request_user_id.valid}" id="request_user_id" name="request_user_id" placeholder="{{ trans('admin.trip-mate-invitation.columns.request_user_id') }}">
        <div v-if="errors.has('request_user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('request_user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('to_user_id'), 'has-success': fields.to_user_id && fields.to_user_id.valid }">
    <label for="to_user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate-invitation.columns.to_user_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.to_user_id" v-validate="''" id="to_user_id" name="to_user_id"></textarea>
        </div>
        <div v-if="errors.has('to_user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('to_user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <label for="status" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trip-mate-invitation.columns.status') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.status" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('status'), 'form-control-success': fields.status && fields.status.valid}" id="status" name="status" placeholder="{{ trans('admin.trip-mate-invitation.columns.status') }}">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}</div>
    </div>
</div>



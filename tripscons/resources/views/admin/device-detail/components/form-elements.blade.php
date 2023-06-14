<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.device-detail.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_id" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.device-detail.columns.user_id') }}">
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('device_id'), 'has-success': fields.device_id && fields.device_id.valid }">
    <label for="device_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.device-detail.columns.device_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.device_id" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('device_id'), 'form-control-success': fields.device_id && fields.device_id.valid}" id="device_id" name="device_id" placeholder="{{ trans('admin.device-detail.columns.device_id') }}">
        <div v-if="errors.has('device_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('device_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('device_token'), 'has-success': fields.device_token && fields.device_token.valid }">
    <label for="device_token" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.device-detail.columns.device_token') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.device_token" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('device_token'), 'form-control-success': fields.device_token && fields.device_token.valid}" id="device_token" name="device_token" placeholder="{{ trans('admin.device-detail.columns.device_token') }}">
        <div v-if="errors.has('device_token')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('device_token') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('device_type'), 'has-success': fields.device_type && fields.device_type.valid }">
    <label for="device_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.device-detail.columns.device_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.device_type" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('device_type'), 'form-control-success': fields.device_type && fields.device_type.valid}" id="device_type" name="device_type" placeholder="{{ trans('admin.device-detail.columns.device_type') }}">
        <div v-if="errors.has('device_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('device_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <label for="status" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.device-detail.columns.status') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.status" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('status'), 'form-control-success': fields.status && fields.status.valid}" id="status" name="status" placeholder="{{ trans('admin.device-detail.columns.status') }}">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}</div>
    </div>
</div>



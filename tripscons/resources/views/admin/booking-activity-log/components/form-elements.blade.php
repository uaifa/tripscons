<div class="form-group row align-items-center" :class="{'has-danger': errors.has('booking_id'), 'has-success': fields.booking_id && fields.booking_id.valid }">
    <label for="booking_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking-activity-log.columns.booking_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.booking_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('booking_id'), 'form-control-success': fields.booking_id && fields.booking_id.valid}" id="booking_id" name="booking_id" placeholder="{{ trans('admin.booking-activity-log.columns.booking_id') }}">
        <div v-if="errors.has('booking_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('booking_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('admin_user_id'), 'has-success': fields.admin_user_id && fields.admin_user_id.valid }">
    <label for="admin_user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking-activity-log.columns.admin_user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.admin_user_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('admin_user_id'), 'form-control-success': fields.admin_user_id && fields.admin_user_id.valid}" id="admin_user_id" name="admin_user_id" placeholder="{{ trans('admin.booking-activity-log.columns.admin_user_id') }}">
        <div v-if="errors.has('admin_user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('admin_user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <label for="status" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking-activity-log.columns.status') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.status" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('status'), 'form-control-success': fields.status && fields.status.valid}" id="status" name="status" placeholder="{{ trans('admin.booking-activity-log.columns.status') }}">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('comments'), 'has-success': fields.comments && fields.comments.valid }">
    <label for="comments" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking-activity-log.columns.comments') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.comments" v-validate="''" id="comments" name="comments"></textarea>
        </div>
        <div v-if="errors.has('comments')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('comments') }}</div>
    </div>
</div>



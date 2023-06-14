<div class="form-group row align-items-center" :class="{'has-danger': errors.has('reference_no'), 'has-success': fields.reference_no && fields.reference_no.valid }">
    <label for="reference_no" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.reference_no') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.reference_no" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('reference_no'), 'form-control-success': fields.reference_no && fields.reference_no.valid}" id="reference_no" name="reference_no" placeholder="{{ trans('admin.reservation.columns.reference_no') }}">
        <div v-if="errors.has('reference_no')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('reference_no') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('bookable'), 'has-success': fields.bookable && fields.bookable.valid }">
    <label for="bookable" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.bookable') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.bookable" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('bookable'), 'form-control-success': fields.bookable && fields.bookable.valid}" id="bookable" name="bookable" placeholder="{{ trans('admin.reservation.columns.bookable') }}">
        <div v-if="errors.has('bookable')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('bookable') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('bookable_id'), 'has-success': fields.bookable_id && fields.bookable_id.valid }">
    <label for="bookable_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.bookable_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.bookable_id" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('bookable_id'), 'form-control-success': fields.bookable_id && fields.bookable_id.valid}" id="bookable_id" name="bookable_id" placeholder="{{ trans('admin.reservation.columns.bookable_id') }}">
        <div v-if="errors.has('bookable_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('bookable_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('room_id'), 'has-success': fields.room_id && fields.room_id.valid }">
    <label for="room_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.room_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.room_id" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('room_id'), 'form-control-success': fields.room_id && fields.room_id.valid}" id="room_id" name="room_id" placeholder="{{ trans('admin.reservation.columns.room_id') }}">
        <div v-if="errors.has('room_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('room_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('provider_user_id'), 'has-success': fields.provider_user_id && fields.provider_user_id.valid }">
    <label for="provider_user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.provider_user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.provider_user_id" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('provider_user_id'), 'form-control-success': fields.provider_user_id && fields.provider_user_id.valid}" id="provider_user_id" name="provider_user_id" placeholder="{{ trans('admin.reservation.columns.provider_user_id') }}">
        <div v-if="errors.has('provider_user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('provider_user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_id" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.reservation.columns.user_id') }}">
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('date_from'), 'has-success': fields.date_from && fields.date_from.valid }">
    <label for="date_from" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.date_from') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.date_from" :config="datePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('date_from'), 'form-control-success': fields.date_from && fields.date_from.valid}" id="date_from" name="date_from" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('date_from')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('date_from') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('date_to'), 'has-success': fields.date_to && fields.date_to.valid }">
    <label for="date_to" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.date_to') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.date_to" :config="datePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('date_to'), 'form-control-success': fields.date_to && fields.date_to.valid}" id="date_to" name="date_to" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('date_to')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('date_to') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('booking_detail'), 'has-success': fields.booking_detail && fields.booking_detail.valid }">
    <label for="booking_detail" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.booking_detail') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.booking_detail" v-validate="''" id="booking_detail" name="booking_detail"></textarea>
        </div>
        <div v-if="errors.has('booking_detail')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('booking_detail') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('subtotal'), 'has-success': fields.subtotal && fields.subtotal.valid }">
    <label for="subtotal" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.subtotal') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.subtotal" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('subtotal'), 'form-control-success': fields.subtotal && fields.subtotal.valid}" id="subtotal" name="subtotal" placeholder="{{ trans('admin.reservation.columns.subtotal') }}">
        <div v-if="errors.has('subtotal')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('subtotal') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('discounttotal'), 'has-success': fields.discounttotal && fields.discounttotal.valid }">
    <label for="discounttotal" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.discounttotal') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.discounttotal" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('discounttotal'), 'form-control-success': fields.discounttotal && fields.discounttotal.valid}" id="discounttotal" name="discounttotal" placeholder="{{ trans('admin.reservation.columns.discounttotal') }}">
        <div v-if="errors.has('discounttotal')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('discounttotal') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('grandtotal'), 'has-success': fields.grandtotal && fields.grandtotal.valid }">
    <label for="grandtotal" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.grandtotal') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.grandtotal" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('grandtotal'), 'form-control-success': fields.grandtotal && fields.grandtotal.valid}" id="grandtotal" name="grandtotal" placeholder="{{ trans('admin.reservation.columns.grandtotal') }}">
        <div v-if="errors.has('grandtotal')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('grandtotal') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('minimum_payable_amount'), 'has-success': fields.minimum_payable_amount && fields.minimum_payable_amount.valid }">
    <label for="minimum_payable_amount" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.minimum_payable_amount') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.minimum_payable_amount" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('minimum_payable_amount'), 'form-control-success': fields.minimum_payable_amount && fields.minimum_payable_amount.valid}" id="minimum_payable_amount" name="minimum_payable_amount" placeholder="{{ trans('admin.reservation.columns.minimum_payable_amount') }}">
        <div v-if="errors.has('minimum_payable_amount')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('minimum_payable_amount') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <label for="status" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.status') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.status" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('status'), 'form-control-success': fields.status && fields.status.valid}" id="status" name="status" placeholder="{{ trans('admin.reservation.columns.status') }}">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('reservation_type'), 'has-success': fields.reservation_type && fields.reservation_type.valid }">
    <label for="reservation_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.reservation_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.reservation_type" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('reservation_type'), 'form-control-success': fields.reservation_type && fields.reservation_type.valid}" id="reservation_type" name="reservation_type" placeholder="{{ trans('admin.reservation.columns.reservation_type') }}">
        <div v-if="errors.has('reservation_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('reservation_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('remaining_amount'), 'has-success': fields.remaining_amount && fields.remaining_amount.valid }">
    <label for="remaining_amount" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reservation.columns.remaining_amount') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.remaining_amount" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('remaining_amount'), 'form-control-success': fields.remaining_amount && fields.remaining_amount.valid}" id="remaining_amount" name="remaining_amount" placeholder="{{ trans('admin.reservation.columns.remaining_amount') }}">
        <div v-if="errors.has('remaining_amount')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('remaining_amount') }}</div>
    </div>
</div>



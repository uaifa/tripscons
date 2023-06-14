<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_id" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.booking.columns.user_id') }}">
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <label for="status" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.status') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.status" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('status'), 'form-control-success': fields.status && fields.status.valid}" id="status" name="status" placeholder="{{ trans('admin.booking.columns.status') }}">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('booking_type'), 'has-success': fields.booking_type && fields.booking_type.valid }">
    <label for="booking_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.booking_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.booking_type" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('booking_type'), 'form-control-success': fields.booking_type && fields.booking_type.valid}" id="booking_type" name="booking_type" placeholder="{{ trans('admin.booking.columns.booking_type') }}">
        <div v-if="errors.has('booking_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('booking_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('provider_name'), 'has-success': fields.provider_name && fields.provider_name.valid }">
    <label for="provider_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.provider_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.provider_name" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('provider_name'), 'form-control-success': fields.provider_name && fields.provider_name.valid}" id="provider_name" name="provider_name" placeholder="{{ trans('admin.booking.columns.provider_name') }}">
        <div v-if="errors.has('provider_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('provider_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('partial_amt_in_percentage'), 'has-success': fields.partial_amt_in_percentage && fields.partial_amt_in_percentage.valid }">
    <label for="partial_amt_in_percentage" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.partial_amt_in_percentage') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.partial_amt_in_percentage" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('partial_amt_in_percentage'), 'form-control-success': fields.partial_amt_in_percentage && fields.partial_amt_in_percentage.valid}" id="partial_amt_in_percentage" name="partial_amt_in_percentage" placeholder="{{ trans('admin.booking.columns.partial_amt_in_percentage') }}">
        <div v-if="errors.has('partial_amt_in_percentage')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('partial_amt_in_percentage') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('partial_amt'), 'has-success': fields.partial_amt && fields.partial_amt.valid }">
    <label for="partial_amt" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.partial_amt') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.partial_amt" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('partial_amt'), 'form-control-success': fields.partial_amt && fields.partial_amt.valid}" id="partial_amt" name="partial_amt" placeholder="{{ trans('admin.booking.columns.partial_amt') }}">
        <div v-if="errors.has('partial_amt')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('partial_amt') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('booking_number'), 'has-success': fields.booking_number && fields.booking_number.valid }">
    <label for="booking_number" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.booking_number') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.booking_number" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('booking_number'), 'form-control-success': fields.booking_number && fields.booking_number.valid}" id="booking_number" name="booking_number" placeholder="{{ trans('admin.booking.columns.booking_number') }}">
        <div v-if="errors.has('booking_number')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('booking_number') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('sub_total'), 'has-success': fields.sub_total && fields.sub_total.valid }">
    <label for="sub_total" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.sub_total') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.sub_total" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('sub_total'), 'form-control-success': fields.sub_total && fields.sub_total.valid}" id="sub_total" name="sub_total" placeholder="{{ trans('admin.booking.columns.sub_total') }}">
        <div v-if="errors.has('sub_total')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('sub_total') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('payment_status'), 'has-success': fields.payment_status && fields.payment_status.valid }">
    <label for="payment_status" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.payment_status') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.payment_status" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('payment_status'), 'form-control-success': fields.payment_status && fields.payment_status.valid}" id="payment_status" name="payment_status" placeholder="{{ trans('admin.booking.columns.payment_status') }}">
        <div v-if="errors.has('payment_status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('payment_status') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('grand_total'), 'has-success': fields.grand_total && fields.grand_total.valid }">
    <label for="grand_total" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.grand_total') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.grand_total" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('grand_total'), 'form-control-success': fields.grand_total && fields.grand_total.valid}" id="grand_total" name="grand_total" placeholder="{{ trans('admin.booking.columns.grand_total') }}">
        <div v-if="errors.has('grand_total')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('grand_total') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('provider_id'), 'has-success': fields.provider_id && fields.provider_id.valid }">
    <label for="provider_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.provider_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.provider_id" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('provider_id'), 'form-control-success': fields.provider_id && fields.provider_id.valid}" id="provider_id" name="provider_id" placeholder="{{ trans('admin.booking.columns.provider_id') }}">
        <div v-if="errors.has('provider_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('provider_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('discount'), 'has-success': fields.discount && fields.discount.valid }">
    <label for="discount" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.discount') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.discount" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('discount'), 'form-control-success': fields.discount && fields.discount.valid}" id="discount" name="discount" placeholder="{{ trans('admin.booking.columns.discount') }}">
        <div v-if="errors.has('discount')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('discount') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('total'), 'has-success': fields.total && fields.total.valid }">
    <label for="total" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.total') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.total" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('total'), 'form-control-success': fields.total && fields.total.valid}" id="total" name="total" placeholder="{{ trans('admin.booking.columns.total') }}">
        <div v-if="errors.has('total')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('total') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('no_of_nights'), 'has-success': fields.no_of_nights && fields.no_of_nights.valid }">
    <label for="no_of_nights" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.no_of_nights') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.no_of_nights" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('no_of_nights'), 'form-control-success': fields.no_of_nights && fields.no_of_nights.valid}" id="no_of_nights" name="no_of_nights" placeholder="{{ trans('admin.booking.columns.no_of_nights') }}">
        <div v-if="errors.has('no_of_nights')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('no_of_nights') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('end_date'), 'has-success': fields.end_date && fields.end_date.valid }">
    <label for="end_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.end_date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.end_date" :config="datetimePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('end_date'), 'form-control-success': fields.end_date && fields.end_date.valid}" id="end_date" name="end_date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('end_date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('end_date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('start_date'), 'has-success': fields.start_date && fields.start_date.valid }">
    <label for="start_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.start_date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.start_date" :config="datetimePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('start_date'), 'form-control-success': fields.start_date && fields.start_date.valid}" id="start_date" name="start_date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('start_date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('start_date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('price'), 'has-success': fields.price && fields.price.valid }">
    <label for="price" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.price') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.price" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('price'), 'form-control-success': fields.price && fields.price.valid}" id="price" name="price" placeholder="{{ trans('admin.booking.columns.price') }}">
        <div v-if="errors.has('price')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('price') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('module_id'), 'has-success': fields.module_id && fields.module_id.valid }">
    <label for="module_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.module_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.module_id" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('module_id'), 'form-control-success': fields.module_id && fields.module_id.valid}" id="module_id" name="module_id" placeholder="{{ trans('admin.booking.columns.module_id') }}">
        <div v-if="errors.has('module_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('module_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('module_name'), 'has-success': fields.module_name && fields.module_name.valid }">
    <label for="module_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.module_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.module_name" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('module_name'), 'form-control-success': fields.module_name && fields.module_name.valid}" id="module_name" name="module_name" placeholder="{{ trans('admin.booking.columns.module_name') }}">
        <div v-if="errors.has('module_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('module_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('bookable'), 'has-success': fields.bookable && fields.bookable.valid }">
    <label for="bookable" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.bookable') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.bookable" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('bookable'), 'form-control-success': fields.bookable && fields.bookable.valid}" id="bookable" name="bookable" placeholder="{{ trans('admin.booking.columns.bookable') }}">
        <div v-if="errors.has('bookable')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('bookable') }}</div>
    </div>
</div>



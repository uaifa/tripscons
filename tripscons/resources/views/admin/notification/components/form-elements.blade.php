<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.notification.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_id" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.notification.columns.user_id') }}">
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('message'), 'has-success': fields.message && fields.message.valid }">
    <label for="message" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.notification.columns.message') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.message" v-validate="''" id="message" name="message"></textarea>
        </div>
        <div v-if="errors.has('message')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('message') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('uri'), 'has-success': fields.uri && fields.uri.valid }">
    <label for="uri" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.notification.columns.uri') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.uri" v-validate="''" id="uri" name="uri"></textarea>
        </div>
        <div v-if="errors.has('uri')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('uri') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('seen'), 'has-success': fields.seen && fields.seen.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="seen" type="checkbox" v-model="form.seen" v-validate="''" data-vv-name="seen"  name="seen_fake_element">
        <label class="form-check-label" for="seen">
            {{ trans('admin.notification.columns.seen') }}
        </label>
        <input type="hidden" name="seen" :value="form.seen">
        <div v-if="errors.has('seen')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('seen') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="status" type="checkbox" v-model="form.status" v-validate="''" data-vv-name="status"  name="status_fake_element">
        <label class="form-check-label" for="status">
            {{ trans('admin.notification.columns.status') }}
        </label>
        <input type="hidden" name="status" :value="form.status">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('type'), 'has-success': fields.type && fields.type.valid }">
    <label for="type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.notification.columns.type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.type" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('type'), 'form-control-success': fields.type && fields.type.valid}" id="type" name="type" placeholder="{{ trans('admin.notification.columns.type') }}">
        <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('ref_id'), 'has-success': fields.ref_id && fields.ref_id.valid }">
    <label for="ref_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.notification.columns.ref_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.ref_id" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('ref_id'), 'form-control-success': fields.ref_id && fields.ref_id.valid}" id="ref_id" name="ref_id" placeholder="{{ trans('admin.notification.columns.ref_id') }}">
        <div v-if="errors.has('ref_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('ref_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_role'), 'has-success': fields.user_role && fields.user_role.valid }">
    <label for="user_role" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.notification.columns.user_role') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_role" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_role'), 'form-control-success': fields.user_role && fields.user_role.valid}" id="user_role" name="user_role" placeholder="{{ trans('admin.notification.columns.user_role') }}">
        <div v-if="errors.has('user_role')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_role') }}</div>
    </div>
</div>



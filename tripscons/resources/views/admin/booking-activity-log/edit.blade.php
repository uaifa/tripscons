@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.booking-activity-log.actions.edit', ['name' => $bookingActivityLog->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <booking-activity-log-form
                :action="'{{ $bookingActivityLog->resource_url }}'"
                :data="{{ $bookingActivityLog->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.booking-activity-log.actions.edit', ['name' => $bookingActivityLog->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.booking-activity-log.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </booking-activity-log-form>

        </div>
    
</div>

@endsection
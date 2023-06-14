@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.trip-activity.actions.edit', ['name' => $tripActivity->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <trip-activity-form
                :action="'{{ $tripActivity->resource_url }}'"
                :data="{{ $tripActivity->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.trip-activity.actions.edit', ['name' => $tripActivity->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.trip-activity.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </trip-activity-form>

        </div>
    
</div>

@endsection
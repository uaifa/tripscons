@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.vehicle-type.actions.edit', ['name' => $vehicleType->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <vehicle-type-form
                :action="'{{ $vehicleType->resource_url }}'"
                :data="{{ $vehicleType->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.vehicle-type.actions.edit', ['name' => $vehicleType->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.vehicle-type.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </vehicle-type-form>

        </div>
    
</div>

@endsection
@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.trip-type.actions.edit', ['name' => $tripType->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <trip-type-form
                :action="'{{ $tripType->resource_url }}'"
                :data="{{ $tripType->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.trip-type.actions.edit', ['name' => $tripType->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.trip-type.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </trip-type-form>

        </div>
    
</div>

@endsection
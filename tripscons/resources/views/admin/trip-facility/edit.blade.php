@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.trip-facility.actions.edit', ['name' => $tripFacility->title]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <trip-facility-form
                :action="'{{ $tripFacility->resource_url }}'"
                :data="{{ $tripFacility->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.trip-facility.actions.edit', ['name' => $tripFacility->title]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.trip-facility.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </trip-facility-form>

        </div>
    
</div>

@endsection
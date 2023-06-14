@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.trip-mate-destination.actions.edit', ['name' => $tripMateDestination->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <trip-mate-destination-form
                :action="'{{ $tripMateDestination->resource_url }}'"
                :data="{{ $tripMateDestination->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.trip-mate-destination.actions.edit', ['name' => $tripMateDestination->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.trip-mate-destination.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </trip-mate-destination-form>

        </div>
    
</div>

@endsection
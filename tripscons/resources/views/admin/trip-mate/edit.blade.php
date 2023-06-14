@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.trip-mate.actions.edit', ['name' => $tripMate->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <trip-mate-form
                :action="'{{ $tripMate->resource_url }}'"
                :data="{{ $tripMate->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.trip-mate.actions.edit', ['name' => $tripMate->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.trip-mate.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </trip-mate-form>

        </div>
    
</div>

@endsection
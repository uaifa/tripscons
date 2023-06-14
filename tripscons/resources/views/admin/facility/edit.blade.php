@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.facility.actions.edit', ['name' => $facility->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <facility-form
                :action="'{{ $facility->resource_url }}'"
                :data="{{ $facility->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.facility.actions.edit', ['name' => $facility->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.facility.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </facility-form>

        </div>
    
</div>

@endsection
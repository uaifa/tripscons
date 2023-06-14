@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.accommodation-sub-type.actions.edit', ['name' => $accommodationSubType->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <accommodation-sub-type-form
                :action="'{{ $accommodationSubType->resource_url }}'"
                :data="{{ $accommodationSubType->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.accommodation-sub-type.actions.edit', ['name' => $accommodationSubType->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.accommodation-sub-type.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </accommodation-sub-type-form>

        </div>
    
</div>

@endsection
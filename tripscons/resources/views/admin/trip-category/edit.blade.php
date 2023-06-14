@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.trip-category.actions.edit', ['name' => $tripCategory->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <trip-category-form
                :action="'{{ $tripCategory->resource_url }}'"
                :data="{{ $tripCategory->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.trip-category.actions.edit', ['name' => $tripCategory->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.trip-category.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </trip-category-form>

        </div>
    
</div>

@endsection
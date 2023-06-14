@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.device-badge.actions.edit', ['name' => $deviceBadge->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <device-badge-form
                :action="'{{ $deviceBadge->resource_url }}'"
                :data="{{ $deviceBadge->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.device-badge.actions.edit', ['name' => $deviceBadge->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.device-badge.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </device-badge-form>

        </div>
    
</div>

@endsection
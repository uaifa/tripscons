@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.trip-mate-invitation.actions.edit', ['name' => $tripMateInvitation->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <trip-mate-invitation-form
                :action="'{{ $tripMateInvitation->resource_url }}'"
                :data="{{ $tripMateInvitation->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.trip-mate-invitation.actions.edit', ['name' => $tripMateInvitation->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.trip-mate-invitation.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </trip-mate-invitation-form>

        </div>
    
</div>

@endsection
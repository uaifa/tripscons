<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            @can('admin.administrator')

                <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/users') }}"><i class="nav-icon icon-umbrella"></i> {{ trans('admin.user.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/activities') }}"><i class="nav-icon icon-graduation"></i> {{ trans('admin.activity.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/facilities') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.facility.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/meal-types') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.meal-type.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/trip-types') }}"><i class="nav-icon icon-globe"></i> {{ trans('admin.trip-type.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/vehicle-types') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.vehicle-type.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/trip-facilities') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.trip-facility.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/trip-categories') }}"><i class="nav-icon icon-magnet"></i> {{ trans('admin.trip-category.title') }}</a></li>
                <!-- <li class="nav-item"><a class="nav-link" href="{{ url('admin/rip-activities') }}"><i class="nav-icon icon-magnet"></i> {{ trans('admin.rip-activity.title') }}</a></li> -->
                <!-- <li class="nav-item"><a class="nav-link" href="{{ url('admin/meal-ingrediants') }}"><i class="nav-icon icon-plane"></i> {{ trans('admin.meal-ingrediant.title') }}</a></li> -->
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/accommodation-sub-types') }}"><i class="nav-icon icon-book-open"></i> {{ trans('admin.accommodation-sub-type.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/accommodation-types') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.accommodation-type.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/trip-activities') }}"><i class="nav-icon icon-graduation"></i> {{ trans('admin.trip-activity.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/roles') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.role.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/bookings') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.booking.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/bookings/booking-list') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('Bookings Request') }}</a></li>
                {{--           <li class="nav-item"><a class="nav-link" href="{{ url('admin/permissions') }}"><i class="nav-icon icon-umbrella"></i> {{ trans('admin.permission.title') }}</a></li>--}}
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/booking-activity-logs') }}"><i class="nav-icon icon-compass"></i> {{ trans('admin.booking-activity-log.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/trip-mates') }}"><i class="nav-icon icon-star"></i> {{ trans('admin.trip-mate.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/trip-mate-destinations') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.trip-mate-destination.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/trip-mate-invitations') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.trip-mate-invitation.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/reservations') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.reservation.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/user-documents') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.user-document.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/notifications') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.notification.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/device-details') }}"><i class="nav-icon icon-compass"></i> {{ trans('admin.device-detail.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/device-badges') }}"><i class="nav-icon icon-compass"></i> {{ trans('admin.device-badge.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}
                <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
                {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
                {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}

            @endcan

                @can('admin.marketer')
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/bookings/booking-list') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('Bookings Requests') }}</a></li>
                @endcan

        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>

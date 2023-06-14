@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.booking.actions.index'))

@section('body')

    <booking-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/bookings') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.booking.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/bookings/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.booking.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">

                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-hover table-listing">
                                <thead>
                                <tr>
                                    <th class="bulk-checkbox">
                                        <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                        <label class="form-check-label" for="enabled">
                                            #
                                        </label>
                                    </th>

                                    <th is='sortable' :column="'id'">{{ trans('admin.booking.columns.id') }}</th>
                                    <th is='sortable' :column="'user_id'">{{ trans('admin.booking.columns.user_id') }}</th>
                                    <th is='sortable' :column="'phone'">{{ trans('User Phone') }}</th>
                                    <th is='sortable' :column="'provider_id'">{{ trans('admin.booking.columns.provider_id') }}</th>
                                    <th is='sortable' :column="'phone'">{{ trans('Provider Phone') }}</th>
                                    <th is='sortable' :column="'module_name'">{{ trans('admin.booking.columns.module_name') }}</th>
                                     <th is='sortable' :column="'price'">{{ trans('admin.booking.columns.price') }}</th>
                                    <th is='sortable' :column="'start_date'">{{ trans('admin.booking.columns.start_date') }}</th>
                                    <th is='sortable' :column="'end_date'">{{ trans('admin.booking.columns.end_date') }}</th>
                                     <th is='sortable' :column="'status'">{{ trans('admin.booking.columns.status') }}</th>
                                     <th is='sortable' :column="'booking_type'">{{ trans('admin.booking.columns.booking_type') }}</th>

                                    <th></th>
                                </tr>
                                <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                    <td class="bg-bulk-info d-table-cell text-center" colspan="23">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/bookings')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                    href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                        <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/bookings/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                            </span>

                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                    <td class="bulk-checkbox">
                                        <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                        <label class="form-check-label" :for="'enabled' + item.id">
                                        </label>
                                    </td>

                                    <td>@{{ item.id }}</td>
                                    <td>@{{ item.user['name'] }}</td>
                                    <td>@{{ item.user['phone'] }}</td>
                                    <td>@{{ item.provider['name'] }}</td>
                                    <td>@{{ item.provider['phone'] }}</td>
                                    <td>@{{ item.module_name }}</td>
                                     <td>@{{ item.price }}</td>
                                    <td>@{{ item.start_date | datetime }}</td>
                                    <td>@{{ item.end_date | datetime }}</td>
                                     <td v-if ="item.status == 0">Pending</td>
                                     <td v-else>Active</td>
                                     <td>@{{ item.booking_type }}</td>

                                    <td>
                                        <div class="row no-gutters">
                                            <div class="col-6">
                                                <a class="btn btn-sm btn-spinner btn-info text-white" :href="item.id + '/detailed-view'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-eye"></i> View</a>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-sm btn-primary ApprovalForm" :data-id="item.id" data-toggle="modal" data-target="#approveORreject" title="{{ trans('Approve') }}" role="button"><i class="fa fa-check"></i> Approve</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/bookings/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.booking.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </booking-listing>
    <!-- Modal -->
    <div class="modal fade" id="approveORreject" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary justify-content-center">
                    <h3 class="text-center">Add Booking Status</h3>
                </div>
                <div class="modal-body">
                    <div class="text-left mt-3">
                        <h5>Choose Status for Provider / Customer</h5>
                        <select name="status" class="form-control status" id="">
                            <option value="7">Partial-Confirmed</option>
                            <option value="8">Confirmed</option>
                        </select>
                    </div>
                    <div class="text-left mt-3">
                        <h5>Add Comment for Provider / Customer</h5>
                        <textarea class="form-control Comment" name="validate" cols="65" rows="10"></textarea>
                    </div>
                    <input type="hidden" name="bookingId" class="bookingId form-control">
                </div>
                <div class="modal-footer">
{{--                    <button type="button" class="btn btn-Danger col-md-6" id="reject" >Reject</button>--}}
                    <button type="button" class="ml-auto btn btn-success col-md-6 text-white btn-lg" id="approve">Submit</button>
                </div>
            </div>
        </div>
    </div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ApprovalForm').on('click', function () {
           var id =  $(this).attr("data-id");
            $('.bookingId').val(id);
        });
        $('#approve').on('click', function () {
            var bookingId = $(".bookingId").val();
            var comment = $(".comment").val();
            var status = $(".status").val();
            $(this).prop('disabled', true);
            $.ajax({
                url: '{{url('admin/bookings/approve')}}',
                type:"post",
                data:
                    {
                        booking_id:bookingId,
                        comment:comment,
                        status:status
                    },
                success:function(response) {
                    if (response['message'] == 'Success') {
                        $('#approveORreject').modal('toggle');
                        $('.bookingId').val = '';
                        $('.comment').val = '';
                        $('.status').val = '';
                        window.location.reload();
                    }
                    else if (response['message'] == 'Error') {
                        alert("Error found please try again");
                    }
                }
            });
        });
        $('#reject').on('click', function () {
            var bookingId = $(".bookingId").val();
            var comment = $(".comment").val();
            $.ajax({
                url: '{{url('admin/booking/reject')}}',
                type:"post",
                data: {bookingId , comment},
                cache:false,
                contentType: false,
                processData: false,
                success:function(response) {
                    if (response['message'] == 'Success') {
                        $('#approveORreject').modalClass("fade");

                    }
                    else if (response['message'] == 'Error') {
                        alert("Error found please try again");
                    }
                }
            });

        });
    })
</script>

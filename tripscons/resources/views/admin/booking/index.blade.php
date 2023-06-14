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
                        @can('admin.administrator')
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/bookings/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.booking.actions.create') }}</a>
                        @endcan
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
                                        <th is='sortable' :column="'provider_id'">{{ trans('admin.booking.columns.provider_id') }}</th>
                                        <th is='sortable' :column="'module_name'">{{ trans('admin.booking.columns.module_name') }}</th>
                                        <th is='sortable' :column="'module_id'">{{ trans('admin.booking.columns.module_id') }}</th>
                                        <th is='sortable' :column="'price'">{{ trans('admin.booking.columns.price') }}</th>
                                        <th is='sortable' :column="'start_date'">{{ trans('admin.booking.columns.start_date') }}</th>
                                        <th is='sortable' :column="'end_date'">{{ trans('admin.booking.columns.end_date') }}</th>
                                        <th is='sortable' :column="'no_of_nights'">{{ trans('admin.booking.columns.no_of_nights') }}</th>
                                        <th is='sortable' :column="'total'">{{ trans('admin.booking.columns.total') }}</th>
                                        <th is='sortable' :column="'discount'">{{ trans('admin.booking.columns.discount') }}</th>
                                        <th is='sortable' :column="'grand_total'">{{ trans('admin.booking.columns.grand_total') }}</th>
                                        <th is='sortable' :column="'status'">{{ trans('admin.booking.columns.status') }}</th>
                                        <th is='sortable' :column="'payment_status'">{{ trans('admin.booking.columns.payment_status') }}</th>
                                        <th is='sortable' :column="'sub_total'">{{ trans('admin.booking.columns.sub_total') }}</th>
                                        <th is='sortable' :column="'booking_number'">{{ trans('admin.booking.columns.booking_number') }}</th>
                                        <th is='sortable' :column="'partial_amt'">{{ trans('admin.booking.columns.partial_amt') }}</th>
                                        <th is='sortable' :column="'partial_amt_in_percentage'">{{ trans('admin.booking.columns.partial_amt_in_percentage') }}</th>
                                        <th is='sortable' :column="'provider_name'">{{ trans('admin.booking.columns.provider_name') }}</th>
                                        <th is='sortable' :column="'booking_type'">{{ trans('admin.booking.columns.booking_type') }}</th>
                                        <th is='sortable' :column="'bookable'">{{ trans('admin.booking.columns.bookable') }}</th>

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
                                        <td>@{{ item.user_id }}</td>
                                        <td>@{{ item.provider_id }}</td>
                                        <td>@{{ item.module_name }}</td>
                                        <td>@{{ item.module_id }}</td>
                                        <td>@{{ item.price }}</td>
                                        <td>@{{ item.start_date | datetime }}</td>
                                        <td>@{{ item.end_date | datetime }}</td>
                                        <td>@{{ item.no_of_nights }}</td>
                                        <td>@{{ item.total }}</td>
                                        <td>@{{ item.discount }}</td>
                                        <td>@{{ item.grand_total }}</td>
                                        <td>@{{ item.status }}</td>
                                        <td>@{{ item.payment_status }}</td>
                                        <td>@{{ item.sub_total }}</td>
                                        <td>@{{ item.booking_number }}</td>
                                        <td>@{{ item.partial_amt }}</td>
                                        <td>@{{ item.partial_amt_in_percentage }}</td>
                                        <td>@{{ item.provider_name }}</td>
                                        <td>@{{ item.booking_type }}</td>
                                        <td>@{{ item.bookable }}</td>

                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>
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
                                @can('admin.administrator')
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/bookings/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.booking.actions.create') }}</a>
                                @endcan
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </booking-listing>

@endsection

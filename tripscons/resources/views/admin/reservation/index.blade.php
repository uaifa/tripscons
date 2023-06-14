@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.reservation.actions.index'))

@section('body')

    <reservation-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/reservations') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.reservation.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/reservations/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.reservation.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block" style="overflow-x: scroll !important;">
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

                                        <th is='sortable' :column="'id'">{{ trans('admin.reservation.columns.id') }}</th>
                                        <th is='sortable' :column="'reference_no'">{{ trans('admin.reservation.columns.reference_no') }}</th>
                                        <th is='sortable' :column="'bookable'">{{ trans('admin.reservation.columns.bookable') }}</th>
                                        <th is='sortable' :column="'bookable_id'">{{ trans('admin.reservation.columns.bookable_id') }}</th>
                                        <th is='sortable' :column="'room_id'">{{ trans('admin.reservation.columns.room_id') }}</th>
                                        <th is='sortable' :column="'provider_user_id'">{{ trans('admin.reservation.columns.provider_user_id') }}</th>
                                        <th is='sortable' :column="'user_id'">{{ trans('admin.reservation.columns.user_id') }}</th>
                                        <th is='sortable' :column="'date_from'">{{ trans('admin.reservation.columns.date_from') }}</th>
                                        <th is='sortable' :column="'date_to'">{{ trans('admin.reservation.columns.date_to') }}</th>
                                        <th is='sortable' :column="'subtotal'">{{ trans('admin.reservation.columns.subtotal') }}</th>
                                        <th is='sortable' :column="'discounttotal'">{{ trans('admin.reservation.columns.discounttotal') }}</th>
                                        <th is='sortable' :column="'grandtotal'">{{ trans('admin.reservation.columns.grandtotal') }}</th>
                                        <th is='sortable' :column="'minimum_payable_amount'">{{ trans('admin.reservation.columns.minimum_payable_amount') }}</th>
                                        <th is='sortable' :column="'status'">{{ trans('admin.reservation.columns.status') }}</th>
                                        <th is='sortable' :column="'reservation_type'">{{ trans('admin.reservation.columns.reservation_type') }}</th>
                                        <th is='sortable' :column="'remaining_amount'">{{ trans('admin.reservation.columns.remaining_amount') }}</th>

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="18">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/reservations')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/reservations/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
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
                                        <td>@{{ item.reference_no }}</td>
                                        <td>@{{ item.bookable }}</td>
                                        <td>@{{ item.bookable_id }}</td>
                                        <td>@{{ item.room_id }}</td>
                                        <td>@{{ item.provider_user_id }}</td>
                                        <td>@{{ item.user_id }}</td>
                                        <td>@{{ item.date_from | date }}</td>
                                        <td>@{{ item.date_to | date }}</td>
                                        <td>@{{ item.subtotal }}</td>
                                        <td>@{{ item.discounttotal }}</td>
                                        <td>@{{ item.grandtotal }}</td>
                                        <td>@{{ item.minimum_payable_amount }}</td>
                                        <td>@{{ item.status }}</td>
                                        <td>@{{ item.reservation_type }}</td>
                                        <td>@{{ item.remaining_amount }}</td>

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
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/reservations/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.reservation.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </reservation-listing>

@endsection

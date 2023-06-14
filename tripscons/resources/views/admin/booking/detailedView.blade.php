@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('Detailed View'))

<style>
    .table td, .table th {
         font-size: 16px !important;
     }
</style>
@section('body')

    <booking-form
        :action="'{{ $booking->resource_url }}'"
        :data="{{ $booking->toJson() }}"
        v-cloak
        inline-template>
        <div class="container-xl">
            <div class="row">
                <div class="card col-lg-8 col-md-6 col-sm-12">
                    <div class="card-header">
                        <h5> <i class="fa fa-align-justify"></i> {{ trans('Booking Detail') }}  # @{{data.booking_number}}</h5>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="row">
                            <div class="col-sm-6 col-md-9 col-lg-12 ">
                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td>Booking Number #</td>
                                        <td>@{{data.booking_number}}</td>
                                    </tr>

                                    <tr>
                                        <td>Payment Type</td>
                                        <td v-if="data.payment_status == 1">Payment Successful</td>
                                        <td v-else-if="data.payment_status == 0">Payment Pending</td>
                                    </tr>

                                    <tr>
                                        <td>Booking Duration</td>
                                        <td>@{{data.start_date | formatDate }} to @{{data.end_date | formatDate }}</td>
                                    </tr>
                                    <tr>
                                        <td>Booking Module</td>
                                        <td>@{{data.module_name}}</td>
                                    </tr>

                                    <tr>
                                        <td>Number of Nights Stay</td>
                                        <td>@{{data.no_of_nights}}</td>
                                    </tr>
                                    <tr>
                                        <td>Booking Type (per day / package)</td>
                                        <td>@{{data.booking_type}}</td>
                                    </tr>
                                    <tr>
                                        <td>Price</td>
                                        <td>@{{data.price | toWords | capitalize}} (@{{data.price}} PKR)</td>
                                    </tr>
                                    <tr>
                                        <td>Per Day Price</td>
                                        <td>@{{data.price | toWords | capitalize}} (@{{data.price}} PKR)</td>
                                    </tr>
                                    <tr>
                                        <td>Total Price</td>
                                        <td>@{{data.total | toWords | capitalize}} (@{{data.total}} PKR)</td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td>@{{data.discount | toWords | capitalize}} (@{{data.discount}} PKR)</td>
                                    </tr>
                                    <tr>
                                        <td>Grand Total</td>
                                        <td>@{{data.grand_total | toWords | capitalize}} (@{{data.grand_total}} PKR)</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card col-lg-12 col-md-12 col-sm-12">
                        <div class="card-header">
                            <h5> <i class="fa fa-align-justify"></i> {{ trans('User Detail') }} </h5>
                        </div>
                        <div class="card-body" v-cloak>
                            <div class="row">
                                <div class="col-sm-6 col-md-9 col-lg-12 ">
                                    <table class="table table-user-information">
                                        <tbody>
                                        <tr>
                                            <td>Name </td>
                                            <td>@{{data.user['name'] }}</td>
                                        </tr>

                                        <tr>
                                            <td>Phone Number</td>
                                            <td>@{{data.user['country_code']}}@{{data.user['phone']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>@{{data.user['email']}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card col-lg-12 col-md-12 col-sm-12">
                        <div class="card-header">
                            <h5> <i class="fa fa-align-justify"></i> {{ trans('Provider Detail') }}</h5>
                        </div>
                        <div class="card-body" v-cloak>
                            <div class="row">
                                <div class="col-sm-6 col-md-9 col-lg-12 ">
                                    <table class="table table-user-information">
                                        <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>@{{data.provider['name']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number</td>
                                            <td>@{{data.provider['country_code']}}@{{data.provider['phone']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>@{{data.provider['email']}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </booking-form>
@endsection




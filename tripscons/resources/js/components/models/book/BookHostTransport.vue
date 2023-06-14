<template>
    <div class="modal fade"
         id="book-host-transport"
         tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:1060px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reserve Transport</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="errors"
                         v-for="(error, index) in errors"
                         :key="index"
                         class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Error!</strong>
                        {{ error[0] }}
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <ul>
                                <li v-show="book.transportFreeKm" style="color: red;">
                                    Free miles for pick/drop:
                                    <b>
                                        {{ book.transportFreeKm }} KM
                                    </b>
                                </li>
                                <li v-show="book.transportExtraKmRate" style="color: red;">
                                    Extra miles charges for pick/drop:
                                    <b>${{ book.transportExtraKmRate }}</b>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4">
                            <div class="form-group">
                                <input type="radio"
                                       class="form-radio"
                                       v-model="book.transportCity"
                                       value="in"
                                       @change="inCityRequire('in')"/>
                                <span style="position: relative; top: 10px; padding: 5px ">In City</span>
                                <input type="radio"
                                       class="form-radio"
                                       v-model="book.transportCity"
                                       value="out"
                                       @change="inCityRequire('out')"/>
                                <span
                                    style=" position: relative; top: 10px; padding: 5px">Out Of City</span>
                            </div>
                        </div>

                        <div class="col-xs-5 col-sm-5">
                            <div class="form-group has-search">
                                <div class="search-wrapper">
                                    <vue-google-autocomplete
                                        style="z-index: 99999999 !important;"
                                        ref="address"
                                        id="map"
                                        class="text-form-control"
                                        placeholder="Please enter pickup location"
                                        types="(regions)"
                                        v-on:placechanged="getAddressData"
                                    ></vue-google-autocomplete>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-show="book.transportCity == 'in'" style="margin-top: 30px;">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <input type="radio"
                                           class="form-radio"
                                           v-model="book.transportInCityRequire"
                                           value="day"
                                           @change="dayOrHourlySelect('day')"/>
                                    <span
                                        style="position: relative; top: 10px; padding: 5px ">One Day</span>
                                    <input type="radio"
                                           class="form-radio"
                                           v-model="book.transportInCityRequire"
                                           value="days"
                                           @change="dayOrHourlySelect('days')"/>
                                    <span
                                        style="position: relative; top: 10px; padding: 5px ">Multiple Day</span>
                                    <input type="radio"
                                           class="form-radio"
                                           v-model="book.transportInCityRequire"
                                           value="hourly"
                                           @change="dayOrHourlySelect('hourly')"/>
                                    <span style=" position: relative; top: 10px; padding: 5px">Hourly</span>
                                </div>
                            </div>
                        </div>

                        <div class="row"
                             v-show="book.transportInCityRequire == 'day' || book.transportInCityRequire == 'days'"
                             style="margin-top: 30px;">
                            <div class="col-sm-4 col-md-4" v-if="book.transportInCityRequire == 'day'">
                                <div class="form-group">
                                    <label class="bmd-label-floating">{{book.transportInCityRequire == 'day'
                                        ? 'Select Date':'From'}}</label>
                                    <v-date-picker
                                        mode="single"
                                        id="picker_day"
                                        ref="picker_day"
                                        v-model='transportOneDayDate'
                                        :min-date='new Date()'
                                        color="green"
                                    />
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-4" v-if="book.transportInCityRequire == 'days'">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Select Dates</label>
                                    <v-date-picker
                                        id="picker_days"
                                        ref="picker_days"
                                        mode='range'
                                        v-model='transportDates'
                                        :min-date='new Date()'
                                        color="green"
                                        :columns="$screens({ default: 1, lg: 2 })"
                                    />

                                </div>
                            </div>

                            <div class="col-sm-2 col-md-2">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Pickup Time</label>
                                    <input type="text" class="form-control timepicker "
                                           placeholder="Time Picker"
                                           id="transportTime"
                                           ref="transportTime"
                                           :value="book.transportTime"
                                           :v-model="book.transportTime"
                                           @change="setTimepickerValues()"
                                    />
                                </div>
                            </div>

                            <div class="col-sm-2 col-md-2">
                                <div class="form-group">
                                    <label for="transport-price" class="bmd-label-floating">Price in
                                        $:</label>
                                    <input type="text"
                                           class="form-control"
                                           id="transport-price"
                                           v-model="book.transportPrice"
                                           readonly/>
                                </div>
                            </div>
                        </div>

                        <div v-if="book.transportInCityRequire == 'hourly'">
                            <div class="row" style="margin-top:20px;">
                                <div class="col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Select Date</label>
                                        <v-date-picker
                                            mode="single"
                                            id="picker_hourly"
                                            ref="picker_hourly"
                                            v-model='book.transportHoulyDate'
                                            :min-date='new Date()'
                                            color="green"
                                        />

                                    </div>
                                </div>

                                <div class="col-sm-2 col-md-2">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Check In Time</label>
                                        <input type="text" class="form-control timepicker "
                                               placeholder="Time Picker"
                                               id="transportHoulyCheckIn"
                                               ref="transportHoulyCheckIn"
                                               :value="book.transportHoulyCheckIn"
                                        />

                                    </div>
                                </div>

                                <div class="col-sm-2 col-md-2">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Check Out Time</label>
                                        <input type="text" class="form-control timepicker "
                                               placeholder="Time Picker"
                                               id="transportHoulyCheckOut"
                                               ref="transportHoulyCheckOut"
                                               :value="book.transportHoulyCheckOut"
                                        />
                                    </div>
                                </div>

                                <div class="col-sm-2 col-md-2">
                                    <div class="form-group">
                                        <label for="transport-price-hourly" class="bmd-label-floating">Price
                                            in
                                            $:</label>
                                        <input type="text"
                                               class="form-control"
                                               id="transport-price-hourly"
                                               v-model="book.transportPrice"
                                               readonly/>
                                    </div>
                                </div>

                                <div class="col-sm-2 col-md-2" style="margin-top:30px;">
                                    <div class="form-group">
                                        <button class="btn btn-white" style="margin: -10px;width:100%;"
                                                @click="addHourlyBooking">Add
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-10" v-if="book.hourlyBookings">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group phone-input">
                                        <ul class="list-group">
                                            <li class="list-group-item"
                                                style="border: 1px #cfcbcb solid; margin: 5px 20px 0 20px;background-color: rgba(234, 234, 234, 0.22);"
                                                v-for="(booking,index) in book.hourlyBookings"
                                                :key="index">
                                                <b style="color: #049970">Date:</b>
                                                {{ booking.date }} ,
                                                <b style="color: #049970">Check In:</b>
                                                {{ booking.check_in }} ,
                                                <b style="color: #049970"
                                                >Check Out:</b>
                                                {{ booking.check_out }}
                                                <button class="btn btn-sm btn-verify ripple"
                                                        style="position: absolute;right: 6px;   top: 8px;    color: green;    font-weight: bold;"
                                                        @click="removeBooking(booking)"
                                                >Remove
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-show="book.transportCity == 'out'" style="margin-top: 30px;">
                        <div class="row">
                            <div class="col-sm-4 col-md-4">

                                <div class="form-group">
                                    <label class="bmd-label-floating">Select Dates</label>
                                    <v-date-picker
                                        id="picker_out_dates"
                                        ref="picker_out_dates"
                                        mode='range'
                                        v-model='transportDates'
                                        :min-date='new Date()'
                                        color="green"
                                        :columns="$screens({ default: 1, lg: 2 })"
                                    />

                                </div>
                            </div>

                            <div class="col-sm-2 col-md-2">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Pickup Time</label>
                                    <input type="text" class="form-control timepicker "
                                           placeholder="Time Picker"
                                           id="time_out_date"
                                           ref="time_out_date"
                                           :value="book.transportTime"
                                    />

                                </div>
                            </div>

                            <div class="col-sm-2 col-md-2">
                                <div class="form-group">
                                    <label for="transport-price-outcity" class="bmd-label-floating">Price in
                                        $:</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="transport-price-outcity"
                                        v-model="book.transportPrice"
                                        readonly
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer" style="margin-top: 30px;">
                    <button type="button" class="btn btn-secondary" ref="btnClose" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" @click="reserve">Next</button>
                </div>
                <form action="/transportTerms" method="post" ref="formReserve" style="display: none;">
                    <input type="hidden" name="_token" :value="csrf">
                    <input type="hidden" name="data" :value="JSON.stringify(book)">
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    var moment = require("moment");
    export default {
        name: "BookHostTransport",
        props: ['allData', 'userCheck', 'loginUser'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors: {},
                book: {
                    user: this.loginUser ? this.loginUser : '',
                    selectedTransport: this.allData.transport,
                    transportDays: "",
                    transportPrice: 0,
                    transportCity: "",
                    transportInCityRequire: "",
                    transportDateFrom: "",
                    transportDateTo: "",
                    transportExtraKmPrice: "",
                    transportTime: "",
                    transportHoulyDate: "",
                    transportHoulyCheckIn: "",
                    transportHoulyCheckOut: "",
                    hourlyBookings: [],
                    transportFreeKm: this.allData.transport.free_km,
                    transportExtraKmRate: this.allData.transport.extra_km_rate,
                },
                transportDates: {},
                transportOneDayDate: '',
            }
        },
        created() {
            this.$helpers.initilizesMDTimepicker();
        },
        methods: {
            dayOrHourlySelect(val) {
                this.$helpers.initilizesMDTimepicker();
                this.book.transportDateFrom = "";
                this.book.transportDateTo = "";
                this.book.transportPrice = 0;
                this.book.transportExtraKmPrice = 0;
                this.calculatePrice();
                this.book.transportTime = "";
                this.accommodationDates = {};
                this.mealDates = {};
                this.transportDates = {};
                this.transportOneDayDate = '';
                this.book.transportDateFrom = "";
                this.book.transportDateTo = "";
                this.book.transportTime = "";
                this.book.transportHoulyDate = "";
                this.book.transportHoulyCheckIn = "";
                this.book.transportHoulyCheckOut = "";
                this.transportDates = {};
                this.book.totalAmount = 0;
            },
            calculatePrice() {
                this.setTimepickerValues();
                this.book.totalAmount = this.book.transportDays = this.book.transportPrice = 0;
                var transportPrice = 0;
                // Transport Pricing
                if (this.book.selectedTransport) {
                    if (this.book.transportInCityRequire == "day" ||
                        this.book.transportInCityRequire == "days" ||
                        this.book.transportCity == "out" ||
                        this.book.transportInCityRequire == "hourly") {

                        if (this.book.hourlyBookings.length && this.book.transportInCityRequire == "hourly") {
                            var hourlyPrice = this.book.selectedTransport.hourly_price;
                            var totalHours = 0;
                            if (this.book.hourlyBookings.length) {
                                this.book.hourlyBookings.forEach(booking => {
                                    totalHours += parseInt(booking.hours);
                                });
                                transportPrice = parseInt(hourlyPrice) * parseInt(totalHours);
                                // console.log('Total Hours: ', totalHours, 'Per Hour Price', hourlyPrice, 'total Price of hours: ', transportPrice);
                            }
                        } else {
                            if (this.book.transportInCityRequire == 'day') {
                                this.book.transportDateFrom = this.transportOneDayDate;
                                if (this.book.transportDateFrom != '') {
                                    this.book.transportDays = 1;
                                    transportPrice = parseInt(this.book.transportDays) * parseInt(this.book.selectedTransport.per_day_price);
                                }
                            } else if (this.transportDates) {
                                this.book.transportDateFrom = moment(this.transportDates.start).format("YYYY-MM-DD");
                                this.book.transportDateTo =  moment(this.transportDates.end).format("YYYY-MM-DD");

                                var date1 = new Date(this.book.transportDateFrom);
                                var date2 = new Date(this.book.transportDateTo);
                                // To calculate the time difference of two dates
                                var DifferenceInTime = date2.getTime() - date1.getTime();
                                // To calculate the no. of days between two dates
                                this.book.transportDays = DifferenceInTime / (1000 * 3600 * 24) + 1;
                                transportPrice = parseInt(this.book.transportDays) * parseInt(this.book.selectedTransport.full_day_price);
                            }
                        }
                        var userLat = parseFloat(this.loginUser.latitude);
                        var userLong = parseFloat(this.loginUser.longitude);
                        var pickUpLat = this.book.userPickUpLocation.latitude;
                        var pickUpLong = this.book.userPickUpLocation.longitude;
                        // console.log("userLat", userLat, "userLong", userLong, "pickUpLat", pickUpLat, "pickUpLong", pickUpLong);
                        var pickUpKm = 0;
                        this.$helpers.getDistanceByLatitudeAndLongitude(userLat, userLong, pickUpLat, pickUpLong, "K", km => {
                            pickUpKm = km;
                            if (pickUpKm > this.book.selectedTransport.free_km) {
                                var diffKm = pickUpKm - this.book.selectedTransport.free_km;
                                this.book.transportExtraKmPrice = diffKm * this.book.selectedTransport.extra_km_rate;
                            }
                            this.book.transportPrice = transportPrice + parseInt(this.book.transportExtraKmPrice);
                            // console.log("difference km", pickUpKm,
                            //     "free_km ", this.book.selectedTransport.free_km,
                            //     "extra_km_rate", this.book.selectedTransport.extra_km_rate,
                            //     "extra price", this.book.transportExtraKmPrice
                            // );
                        });
                    }
                }

                this.book.totalAmount = Number.isNaN(parseInt(this.book.transportPrice)) ? 0 : parseInt(this.book.transportPrice);
                return this.book.totalAmount;
            },
            addHourlyBooking() {
                this.setTimepickerValues();
                if (
                    this.book.transportHoulyDate &&
                    this.book.transportHoulyCheckIn &&
                    this.book.transportHoulyCheckOut
                ) {
                    this.book.hourlyBookings.push({
                        date: moment(this.book.transportHoulyDate).format("YYYY-MM-DD"),
                        check_in: this.book.transportHoulyCheckIn,
                        check_out: this.book.transportHoulyCheckOut,
                        hours: this.getHoursDiffByDates()
                    });
                    this.calculatePrice();
                    // this.book.transportHoulyDate = "";
                    // this.book.transportHoulyCheckIn = "";
                    // this.book.transportHoulyCheckOut = "";
                } else {
                    this.$swal("Please, Select full fill all requirement.");
                }
            },
            removeBooking(book) {
                var allbookings = [];
                if (this.book.hourlyBookings.length > 0) {
                    this.book.hourlyBookings.forEach((currentBook, index) => {
                        if (
                            currentBook.date != book.date &&
                            currentBook.check_in != book.check_in &&
                            currentBook.check_out != book.check_out
                        ) {
                            allbookings.push(currentBook);
                        }
                    });
                }
                this.book.hourlyBookings = [];
                this.book.hourlyBookings = allbookings;
                this.calculatePrice();
            },
            getHoursDiffByDates() {
                var timeStart = new Date(((moment(this.book.transportHoulyDate).format("YYYY-MM-DD")) + " " + this.book.transportHoulyCheckIn));
                var timeEnd = new Date(((moment(this.book.transportHoulyDate).format("YYYY-MM-DD")) + " " + this.book.transportHoulyCheckOut));
                var diffInHours = Math.abs(timeStart - timeEnd) / 36e5;
                return diffInHours;
            },
            inCityRequire(val) {
                this.book.transportDateFrom = "";
                this.book.transportDateTo = "";
                this.book.transportPrice = 0;
                this.book.transportExtraKmPrice = 0;
                this.calculatePrice();
                this.book.transportTime = "";
                this.$helpers.initilizesMDTimepicker();
            },
            /**
             * When the location found
             * @param {Object} addressData Data of the found location
             * @param {Object} placeResultData PlaceResult object
             * @param {String} id Input container ID
             */
            getAddressData: function (addressData, placeResultData, id) {
                this.book.userPickUpLocation = addressData;
                this.calculatePrice();
            },
            setTimepickerValues() {
                if (this.book.transportCity == 'out') {
                    this.book.transportTime = $('#time_out_date').attr('value');
                } else if (this.book.transportCity == 'in'
                    && (this.book.transportInCityRequire == 'day' || this.book.transportInCityRequire == 'days')) {
                    this.book.transportTime = $('#transportTime').attr('value');
                } else if (this.book.transportCity == 'in' && this.book.transportInCityRequire == 'hourly') {
                    this.book.transportHoulyCheckIn = $('#transportHoulyCheckIn').attr('value');
                    this.book.transportHoulyCheckOut = $('#transportHoulyCheckOut').attr('value');
                }
            },
            reserve() {
                this.setTimepickerValues();
                setTimeout(() => {
                    if ((this.book.transportDateFrom && this.book.transportDateTo)
                        || (this.book.hourlyBookings)
                        || (this.book.totalAmount)) {
                        this.$refs.formReserve.submit();
                    } else {
                        this.$swal('Please, Full fill all require field.')
                    }
                }, 1100)

            }
        },
        watch: {
            "transportDates": function () {
                this.calculatePrice();
            },
            "transportOneDayDate": function () {
                this.calculatePrice();
            },
        }
    }
</script>

<style scoped>

</style>

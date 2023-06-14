<template>
    <div class="modal fade"
         id="buy-host"
         tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:1000px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Book Host</h5>
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

                    <!--                    tab view-->
                    <div v-show="showCard==false">

                        <!--                        tab link-->
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <ul class="nav nav-tabs pages_tab">
                                    <li class="nav-item">
                                        <a class="nav-link active " id="tab_accommodation" data-toggle="tab"
                                           href="#tb_accommodation">
                                            Accommodations
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="host_transport" data-toggle="tab" href="#tb_transport">Host
                                            Transports</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab_meals" data-toggle="tab" href="#tb_meals">
                                            Meals
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="tab_availability" data-toggle="tab"
                                           href="#tb_availability">
                                            Availability
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!--                        tab contents-->
                        <div class="tab-content">
                            <!--                    Accommodation-->
                            <div role="tabpanel" class="tab-pane active" id="tb_accommodation">

                                <div class="row" v-show="accommodations.length>0" style="margin-top: 20px;">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label for="accommodation-type" class="bmd-label-floating">Select
                                                Accommodation:</label>
                                            <select class="custom-select"
                                                    id="accommodation-type"
                                                    name="accommodation-type"
                                                    v-model="form.selectedAccommodation"
                                                    @change="accommodaitonChange">
                                                <option value>No Need</option>
                                                <option v-for="(accommodation,index) in accommodations"
                                                        :key="index"
                                                        :value="accommodation">
                                                    {{accommodation.title }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6" style="margin-top:35px;">
                                        <v-date-picker
                                            ref="picker"
                                            mode='range'
                                            v-model='accommodationDates'
                                            :min-date='new Date()'
                                            color="green"
                                            :columns="$screens({ default: 1, lg: 2 })"
                                        />
                                    </div>

                                    <!--                                    <div class="col-sm-3 col-md-3">-->
                                    <!--                                        <div class="form-group">-->
                                    <!--                                            <label class="bmd-label-floating">From</label>-->
                                    <!--                                            <vuejs-datepicker-->
                                    <!--                                                :bootstrap-styling="true"-->
                                    <!--                                                placeholder="From"-->
                                    <!--                                                v-model="form.accommodationFrom"-->
                                    <!--                                                :format="accommodationFrom"-->
                                    <!--                                            ></vuejs-datepicker>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->

                                    <!--                                    <div class="col-sm-3 col-md-3">-->
                                    <!--                                        <div class="form-group">-->
                                    <!--                                            <label class="bmd-label-floating">To</label>-->
                                    <!--                                            <vuejs-datepicker-->
                                    <!--                                                :bootstrap-styling="true"-->
                                    <!--                                                placeholder="To"-->
                                    <!--                                                v-model="form.accommodationTo"-->
                                    <!--                                                :format="accommodationTo"></vuejs-datepicker>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->

                                    <div class="col-sm-2 col-md-2">
                                        <div class="form-group">
                                            <label for="accommodation-price" class="bmd-label-floating">Price in
                                                $:</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="accommodation-price"
                                                   v-model="form.accommodationPrice"
                                                   readonly/>
                                        </div>
                                    </div>
                                </div>

                                <section v-show="form.selectedAccommodation">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12" style="text-align: center;">
                                            <h2><b>Accommodation Detail</b></h2>
                                        </div>
                                        <div class="col-md-8 col-sm-8" style="border-right: 1px solid gainsboro;">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                    <h6><b class="green">Property Type: </b><small>
                                                        {{form.selectedAccommodation.property_type+' place' }}
                                                    </small></h6>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                    <h6><b class="green">Place: </b><small>
                                                        {{form.selectedAccommodation.type_name+','+form.selectedAccommodation.sub_type_name
                                                        }}
                                                    </small></h6>
                                                </div>

                                                <div class="col-sm-12 col-md-12"
                                                     v-show="form.selectedAccommodation.beds_types_links">
                                                    <h6><b class="green">Arrangements: </b>
                                                        <small
                                                            v-for="(arrange,i) in form.selectedAccommodation.beds_types_links"
                                                            :key="i">
                                                            {{arrange.total +' '+ arrange.bed_name+','}}
                                                        </small>
                                                    </h6>
                                                </div>

                                                <div class="col-sm-12 col-md-12"
                                                     v-show="form.selectedAccommodation.facilities">
                                                    <h6><b class="green">Facilities: </b>
                                                        <small
                                                            v-for="(facility,i) in form.selectedAccommodation.facilities"
                                                            :key="i">
                                                            {{facility.name+','}}
                                                        </small>
                                                    </h6>
                                                </div>

                                                <div class="col-sm-12 col-md-12"
                                                     v-show="form.selectedAccommodation && getLength(form.selectedAccommodation.share_accommodation_links)">
                                                    <h6><b class="green">Share Portions: </b>
                                                        <small
                                                            v-for="(share,i) in form.selectedAccommodation.share_accommodation_links"
                                                            :key="i">
                                                            {{share.name+','}}
                                                        </small>
                                                    </h6>
                                                </div>

                                                <div class="col-sm-12 col-md-12"
                                                     v-show="form.selectedAccommodation && getLength(form.selectedAccommodation.safety_amenity_links)">
                                                    <h6><b class="green">Safety Amenity: </b>
                                                        <small
                                                            v-for="(amenity,i) in form.selectedAccommodation.safety_amenity_links"
                                                            :key="i">
                                                            {{amenity.title+','}}
                                                        </small>
                                                    </h6>
                                                </div>


                                                <div class="col-sm-12 col-md-12">
                                                    <h6><b class="green">Check In: </b><small>
                                                        {{form.selectedAccommodation.check_in }}
                                                    </small></h6>
                                                </div>

                                                <div class="col-sm-12 col-md-12">
                                                    <h6><b class="green">Check Out: </b><small>
                                                        {{form.selectedAccommodation.check_out }}
                                                    </small></h6>
                                                </div>


                                            </div>
                                        </div>

                                        <!--                                        adults,childrens,infant counter-->
                                        <div class="col-md-4 col-sm-4">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12" style="margin:5px;">
                                                    <label class="lable-i-d-title">Adults</label>
                                                    <button class="btn lable-d" @click="decrement('adult')">-</button>
                                                    <label class="lable-i-d-counter">{{form.adults}}</label>
                                                    <button class="btn lable-i" @click="increment('adult')"
                                                            :disabled="form.adultsChildrensDisable">+
                                                    </button>
                                                </div>
                                                <div class="col-md-12 col-sm-12" style="margin:5px;">
                                                    <label class="lable-i-d-title">Children <small>Ages
                                                        2–12</small></label>
                                                    <button class="btn lable-d" @click="decrement('children')">-
                                                    </button>
                                                    <label class="lable-i-d-counter">{{form.childrens}}</label>
                                                    <button class="btn lable-i" @click="increment('children')"
                                                            :disabled="form.adultsChildrensDisable">+
                                                    </button>
                                                </div>
                                                <div class="col-md-12 col-sm-12" style="margin:5px;">
                                                    <label class="lable-i-d-title">Infants <small>Under
                                                        2</small></label>
                                                    <button class="btn lable-d" @click="decrement('infant')">-</button>
                                                    <label class="lable-i-d-counter">{{form.infants}}</label>
                                                    <button class="btn lable-i" @click="increment('infant')">+</button>
                                                </div>

                                                <div class="col-sm-12 col-md-12" style="margin-top: 20px;">
                                                    <h6><b class="green">Per Night: </b><small
                                                        style="font-weight: bold;  font-size: large; float: right;">
                                                        ${{ form.perNight ? form.perNight :
                                                        form.selectedAccommodation.per_night }} &#10008;
                                                        {{this.form.accommodationDays}}</small></h6>
                                                    <hr>
                                                </div>

                                                <div class="col-sm-12 col-md-12"
                                                     v-show="form.selectedAccommodation.clean_fee">
                                                    <h6><b class="green">Cleaning fee: </b><small
                                                        style="font-weight: bold;  font-size: large; float: right;">
                                                        ${{form.selectedAccommodation.clean_fee }}</small></h6>
                                                    <hr>
                                                </div>

                                                <div class="col-sm-12 col-md-12"
                                                     v-show="form.selectedAccommodation.service_fee">
                                                    <h6><b class="green">Service fee: </b><small
                                                        style="font-weight: bold;  font-size: large; float: right;">
                                                        ${{form.selectedAccommodation.service_fee }}</small></h6>
                                                    <hr>
                                                </div>

                                                <div class="col-sm-12 col-md-12"
                                                     v-show="form.selectedAccommodation.taxes_fees">
                                                    <h6><b class="green">Occupancy taxes and fees: </b><small
                                                        style="font-weight: bold;  font-size: large; float: right;">
                                                        ${{form.selectedAccommodation.taxes_fees }}</small></h6>
                                                    <hr>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </section>

                            </div>

                            <!--                    Meals-->
                            <div role="tabpanel" class="tab-pane " id="tb_meals">

                                <!--                                meal type-->
                                <div class="row" v-show="mealTypes.length>0" style="margin-top: 20px;">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label for="meal-type" class="bmd-label-floating">Select Meal Type:</label>
                                            <select class="custom-select"
                                                    id="meal-type"
                                                    name="meal-type"
                                                    v-model="form.selectedMealType"
                                                    @change="mealTypechange">
                                                <option value>No Need</option>
                                                <option v-for="(meal, index) in mealTypes"
                                                        :key="index"
                                                        :value="meal">
                                                    {{meal.name}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!--                                select meal-->
                                <div class="row" v-show="meals.length>0">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label for="meal" class="bmd-label-floating">Select Meal Menu:</label>
                                            <select class="custom-select"
                                                    id="meal"
                                                    name="meal"
                                                    v-model="form.selectedMeal"
                                                    @change="calculatePrice">
                                                <option value>No Need</option>
                                                <option v-for="(meal, index) in meals"
                                                        :key="index"
                                                        :value="meal">
                                                    {{meal.title}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4" style="margin-top:35px;">
                                        <v-date-picker
                                            ref="picker"
                                            mode='range'
                                            v-model='mealDates'
                                            :min-date='new Date()'
                                            color="green"
                                            :columns="$screens({ default: 1, lg: 2 })"
                                        />
                                    </div>
                                    <!--                                    <div class="col-sm-2 col-md-2">-->
                                    <!--                                        <div class="form-group">-->
                                    <!--                                            <label class="bmd-label-floating">From</label>-->
                                    <!--                                            <vuejs-datepicker-->
                                    <!--                                                :bootstrap-styling="true"-->
                                    <!--                                                placeholder="From"-->
                                    <!--                                                v-model="form.mealFrom"-->
                                    <!--                                                :format="mealFrom"-->
                                    <!--                                            ></vuejs-datepicker>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->

                                    <!--                                    <div class="col-sm-2 col-md-2">-->
                                    <!--                                        <div class="form-group">-->
                                    <!--                                            <label class="bmd-label-floating">To</label>-->
                                    <!--                                            <vuejs-datepicker-->
                                    <!--                                                :bootstrap-styling="true"-->
                                    <!--                                                placeholder="To"-->
                                    <!--                                                v-model="form.mealTo"-->
                                    <!--                                                :format="mealTo"-->
                                    <!--                                            ></vuejs-datepicker>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->

                                    <div class="col-sm-2 col-md-2">
                                        <div class="form-group">
                                            <label for="meal-price" class="bmd-label-floating">Price in $:</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="meal-price"
                                                   v-model="form.mealPrice"
                                                   readonly/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-md-2" style="margin-top:30px;">
                                        <div class="form-group">
                                            <button class="btn btn-white" style="margin: -10px;width:100%;"
                                                    @click="addMealBooking">Add
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row"
                                     style="margin-bottom: 10px;"
                                     v-if="form.mealBookings">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group phone-input">
                                            <ul class="list-group">
                                                <li class="list-group-item"
                                                    style="border: 1px #cfcbcb solid; margin: 5px 20px 0 20px;background-color: rgba(234, 234, 234, 0.22);"
                                                    v-for="(booking,index) in form.mealBookings"
                                                    :key="index">

                                                    <b style="color: #049970"
                                                    >Meal:</b>
                                                    {{ booking.meal.title }}
                                                    <b style="color: #049970">Date From:</b>
                                                    {{ booking.date_from }} ,
                                                    <b style="color: #049970">Date To:</b>
                                                    {{ booking.date_to }} ,

                                                    <button class="btn btn-sm btn-verify ripple"
                                                            style="position: absolute;right: 6px;   top: 8px;    color: green;    font-weight: bold;"
                                                            @click="removeMealBooking(booking,index)"
                                                    >Remove
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!--                    Transports-->
                            <div role="tabpanel" class="tab-pane " id="tb_transport">

                                <div class="row" v-show="transports.length>0" style="margin-top: 20px;">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label for="transport-type" class="bmd-label-floating">Select
                                                Transports:</label>
                                            <select
                                                class="custom-select"
                                                id="transport-type"
                                                name="transport-type"
                                                v-model="form.selectedTransport"
                                                @change="selectTransport"
                                            >
                                                <option value>No Need</option>
                                                <option v-for="(transport, index) in transports"
                                                        :key="index"
                                                        :value="transport">
                                                    {{transport.title}}
                                                </option>
                                            </select>
                                        </div>
                                        <ul style="padding-left: 22px; list-style: circle;">
                                            <li v-show="transportFreeKm" style="color: red;">
                                                Free miles for pick/drop:
                                                <b>
                                                    {{ transportFreeKm }} KM
                                                </b>
                                            </li>
                                            <li v-show="transportExtraKmRate" style="color: red;">
                                                Extra miles charges for pick/drop:
                                                <b>${{ transportExtraKmRate }}</b>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-xs-3 col-sm-3">
                                        <div class="form-group" style="margin: 20px 0 0px 0">
                                            <input type="radio"
                                                   class="form-radio"
                                                   v-model="form.transportCity"
                                                   value="in"
                                                   @change="inCityRequire('in')"/>
                                            <span style="position: relative; top: 10px; padding: 5px ">In City</span>
                                            <input type="radio"
                                                   class="form-radio"
                                                   v-model="form.transportCity"
                                                   value="out"
                                                   @change="inCityRequire('out')"/>
                                            <span
                                                style=" position: relative; top: 10px; padding: 5px">Out Of City</span>
                                        </div>
                                    </div>

                                    <div class="col-xs-5 col-sm-5">
                                        <div class="form-group has-search">
                                            <div class="search-wrapper" style="margin-top:15px">
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

                                <div v-show="form.transportCity == 'in'" style="margin:0px 0 20px 0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group" style="margin: 0px 0 0px 0">
                                                <input type="radio"
                                                       class="form-radio"
                                                       v-model="form.transportInCityRequire"
                                                       value="day"
                                                       @change="dayOrHourlySelect('day')"/>
                                                <span
                                                    style="position: relative; top: 10px; padding: 5px ">One Day</span>
                                                <input type="radio"
                                                       class="form-radio"
                                                       v-model="form.transportInCityRequire"
                                                       value="days"
                                                       @change="dayOrHourlySelect('days')"/>
                                                <span
                                                    style="position: relative; top: 10px; padding: 5px ">Multiple Day</span>
                                                <input type="radio"
                                                       class="form-radio"
                                                       v-model="form.transportInCityRequire"
                                                       value="hourly"
                                                       @change="dayOrHourlySelect('hourly')"/>
                                                <span style=" position: relative; top: 10px; padding: 5px">Hourly</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row"
                                         v-show="form.transportInCityRequire == 'day' || form.transportInCityRequire == 'days'"
                                         style="margin-top:20px;">
                                        <div class="col-sm-4 col-md-4" v-if="form.transportInCityRequire == 'day'">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">{{form.transportInCityRequire == 'day'
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

                                        <div class="col-sm-4 col-md-4" v-if="form.transportInCityRequire == 'days'">
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
                                                <!--                                                <vuejs-datepicker-->
                                                <!--                                                    :bootstrap-styling="true"-->
                                                <!--                                                    placeholder="To"-->
                                                <!--                                                    v-model="form.transportDateTo"-->
                                                <!--                                                    :format="inCityDateTo"-->
                                                <!--                                                ></vuejs-datepicker>-->
                                            </div>
                                        </div>

                                        <div class="col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Pickup Time</label>
                                                <input type="text" class="form-control timepicker "
                                                       placeholder="Time Picker"
                                                       id="transportTime"
                                                       ref="transportTime"
                                                       :value="form.transportTime"
                                                />
                                                <!--                                                <vue-timepicker-->
                                                <!--                                                    v-model="form.transportTime"-->
                                                <!--                                                    close-on-complete-->
                                                <!--                                                    placeholder="Select Time"-->
                                                <!--                                                ></vue-timepicker>-->
                                            </div>
                                        </div>

                                        <div class="col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="transport-price" class="bmd-label-floating">Price in
                                                    $:</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="transport-price"
                                                       v-model="form.transportPrice"
                                                       readonly/>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="form.transportInCityRequire == 'hourly'">
                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-sm-4 col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Select Date</label>
                                                    <v-date-picker
                                                        mode="single"
                                                        id="picker_hourly"
                                                        ref="picker_hourly"
                                                        v-model='form.transportHoulyDate'
                                                        :min-date='new Date()'
                                                        color="green"
                                                    />

                                                    <!--                                                    <vuejs-datepicker-->
                                                    <!--                                                        :bootstrap-styling="true"-->
                                                    <!--                                                        placeholder="Select Date"-->
                                                    <!--                                                        v-model="form.transportHoulyDate"-->
                                                    <!--                                                        :format="hourlyDate"-->
                                                    <!--                                                    ></vuejs-datepicker>-->
                                                </div>
                                            </div>

                                            <div class="col-sm-2 col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Check In Time</label>
                                                    <input type="text" class="form-control timepicker "
                                                           placeholder="Time Picker"
                                                           id="transportHoulyCheckIn"
                                                           ref="transportHoulyCheckIn"
                                                           :value="form.transportHoulyCheckIn"
                                                    />
                                                    <!--                                                    <vue-timepicker-->
                                                    <!--                                                        v-model="form.transportHoulyCheckIn"-->
                                                    <!--                                                        close-on-complete-->
                                                    <!--                                                        placeholder="Select Time"-->
                                                    <!--                                                        format="h:m a"-->
                                                    <!--                                                    ></vue-timepicker>-->
                                                </div>
                                            </div>

                                            <div class="col-sm-2 col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Check Out Time</label>
                                                    <input type="text" class="form-control timepicker "
                                                           placeholder="Time Picker"
                                                           id="transportHoulyCheckOut"
                                                           ref="transportHoulyCheckOut"
                                                           :value="form.transportHoulyCheckOut"
                                                    />
                                                    <!--                                                    <vue-timepicker-->
                                                    <!--                                                        v-model="form.transportHoulyCheckOut"-->
                                                    <!--                                                        close-on-complete-->
                                                    <!--                                                        placeholder="Select Time"-->
                                                    <!--                                                        format="h:m a"-->
                                                    <!--                                                    ></vue-timepicker>-->
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
                                                           v-model="form.transportPrice"
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

                                        <div class="row" v-if="form.hourlyBookings">
                                            <div class="col-sm-12 col-md-12">
                                                <div class="form-group phone-input">
                                                    <ul class="list-group">
                                                        <li class="list-group-item"
                                                            style="border: 1px #cfcbcb solid; margin: 5px 20px 0 20px;background-color: rgba(234, 234, 234, 0.22);"
                                                            v-for="(booking,index) in form.hourlyBookings"
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

                                <div v-show="form.transportCity == 'out'" style="margin-top:20px;">
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
                                                <!--                                                <vuejs-datepicker-->
                                                <!--                                                    :bootstrap-styling="true"-->
                                                <!--                                                    placeholder="From"-->
                                                <!--                                                    v-model="form.transportDateFrom"-->
                                                <!--                                                    :format="inCityDateFrom"-->
                                                <!--                                                ></vuejs-datepicker>-->
                                            </div>
                                        </div>

                                        <!--                                        <div class="col-sm-4 col-md-4">-->
                                        <!--                                            <div class="form-group">-->
                                        <!--                                                <label class="bmd-label-floating">To</label>-->
                                        <!--                                                <vuejs-datepicker-->
                                        <!--                                                    :bootstrap-styling="true"-->
                                        <!--                                                    placeholder="To"-->
                                        <!--                                                    v-model="form.transportDateTo"-->
                                        <!--                                                    :format="inCityDateTo"-->
                                        <!--                                                ></vuejs-datepicker>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->

                                        <div class="col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Pickup Time</label>
                                                <input type="text" class="form-control timepicker "
                                                       placeholder="Time Picker"
                                                       id="time_out_date"
                                                       ref="time_out_date"
                                                       :value="form.transportTime"
                                                />
                                                <!--                                                <vue-timepicker-->
                                                <!--                                                    v-model="form.transportTime"-->
                                                <!--                                                    close-on-complete-->
                                                <!--                                                    placeholder="Select Time"-->
                                                <!--                                                ></vue-timepicker>-->
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
                                                    v-model="form.transportPrice"
                                                    readonly
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--                            Availablity Class-->
                            <div role="tabpanel" class="tab-pane" id="tb_availability"
                                 v-show="allAvailabilities.length>0">

                                <!--                              select availabilities-->
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label for="meal-type" class="bmd-label-floating">Select
                                                Availability:</label>
                                            <select class="custom-select"
                                                    name="meal-type"
                                                    v-model="form.selectedAvailability"
                                                    @change="getAvailableDates">
                                                <option value>No Need</option>
                                                <option v-for="(avail, index) in allAvailabilities"
                                                        :key="index"
                                                        :value="avail.data">
                                                    {{avail.data.title}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" :class="availableDates.length>0 ? '' :'div-disable'">
                                    <div class="col-md-12 col-sm-12">
                                        <label><b>Select dates for availability</b></label>
                                        <div class="input-field ">
                                            <v-date-picker
                                                id="selectedAvailabilityDates"
                                                ref="selectedAvailabilityDates"
                                                mode='range'
                                                v-model='form.availableDates'
                                                color="green"
                                                :columns="$screens({ default: 1, lg: 3 })"
                                                :available-dates="availableDates"
                                                is-inline
                                                is-expanded
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 20px;">

                                    <!--                    counter adults,children,infants-->
                                    <div class="col-md-6 col-sm-6">
                                        <div class="card-invo">
                                            <h4>Guests</h4>
                                            <div class="card-body">
                                                <div class="invoice-inner">
                                                    <div class="invoice-details">
                                                        <div class="col-md-12 col-sm-12" style="margin:5px;">
                                                            <label class="lable-i-d-title">Adults</label>
                                                            <button class="btn lable-d"
                                                                    @click="decrementAvailability('adult')">-
                                                            </button>
                                                            <label
                                                                class="lable-i-d-counter">{{form.availabilityAdults}}</label>
                                                            <button class="btn lable-i"
                                                                    @click="incrementAvailability('adult')"
                                                                    :disabled="form.availabilityAdultsChildrensDisable">
                                                                +
                                                            </button>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12" style="margin:5px;">
                                                            <label class="lable-i-d-title">Children <small>Ages
                                                                2–12</small></label>
                                                            <button class="btn lable-d"
                                                                    @click="decrementAvailability('children')">-
                                                            </button>
                                                            <label class="lable-i-d-counter">{{form.availabilityChildrens}}</label>
                                                            <button class="btn lable-i"
                                                                    @click="incrementAvailability('children')"
                                                                    :disabled="form.availabilityAdultsChildrensDisable">
                                                                +
                                                            </button>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12" style="margin:5px;">
                                                            <label class="lable-i-d-title">Infants <small>Under
                                                                2</small></label>
                                                            <button class="btn lable-d"
                                                                    @click="decrementAvailability('infant')">-
                                                            </button>
                                                            <label class="lable-i-d-counter">{{form.infants}}</label>
                                                            <button class="btn lable-i"
                                                                    @click="incrementAvailability('infant')">+
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--                    invoice-->
                                    <div class="col-md-6 col-sm-6" v-show="form.availabilityTotalAmount">
                                        <div class="card-invo">
                                            <h4>Your Invoice</h4>
                                            <div class="card-body">
                                                <div class="invoice-inner">
                                                    <div class="invoice-details">
                                                        <ul>
                                                            <li style="border: none;">
                                                                <span class="text-detail">${{(form.availabilityAdults + form.availabilityChildrens) }} x {{form.availabilityDays}} x {{form.selectedAvailability.per_person_price}} per person</span>
                                                                <span class="aomunt-detail">${{form.availabilityTotalAmount}}</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>

                        <!--                        Description-->
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="description" class="bmd-label-floating">Note:</label>
                                    <textarea
                                        name="description"
                                        class="textarea-form-control"
                                        id="description"
                                        cols="30"
                                        rows="4"
                                        v-model="form.description"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <!--                        total amount Area-->
                        <div class="row">

                            <div class="col-sm-8 col-md-8">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12" style="margin-top:20px;">
                                        <h6><b class="green">Accommodation Total: </b><small>
                                            ${{form.accommodationPrice}}
                                        </small></h6>
                                        <h6><b class="green">Transport Total: </b><small>
                                            ${{form.transportPrice}}
                                        </small></h6>
                                        <h6><b class="green">Meals Total: </b><small>
                                            ${{form.mealPrice}}
                                        </small></h6>
                                        <h6><b class="green">Availability Total: </b><small>
                                            ${{form.availabilityTotalAmount}}
                                        </small></h6>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-4">
                                <div class="form-group" style="float: right;font-size: 25px;    margin-right: 0px;">
                                    <small
                                        style="color: red;font-size: 15px;margin-bottom: -10px; margin-top:10px; display: block;"
                                        v-show="form.weeklyDiscountPercent">
                                        Discount: <b>{{form.weeklyDiscountPercent}}%</b></small>
                                    <hr v-show="form.weeklyDiscountPercent"/>
                                    <small
                                        style="color: red;font-size: 15px;margin-bottom: -10px; margin-top:10px; display: block;"
                                        v-show="form.totalAmount">
                                        10% Advance: <b>${{form.totalAmount*10/100}}</b></small>
                                    <hr/>
                                    <b>Total:</b>
                                    $ {{ form.totalAmount }}
                                </div>
                            </div>
                        </div>

                    </div>

                    <!--                    Card view for payment-->
                    <div class="row" v-show="showCard">
                        <VCreditCard @change="creditInfoChanged"/>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" v-show="showCard" class="btn btn-dark" @click="showCard=false">Back</button>
                    <button type="button" class="btn btn-secondary" ref="btnClose" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" @click="send">{{ showCard ? 'Send Proposal' :
                        'Next'}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from "vuejs-datepicker";
    import VueTimepicker from "vue2-timepicker/src";
    import VueGoogleAutocomplete from "vue-google-autocomplete";
    import VCreditCard from 'v-credit-card';
    import 'v-credit-card/dist/VCreditCard.css';

    Vue.component('v-credit-card', VCreditCard);
    var moment = require("moment");

    export default {
        name: "BuyHostService",
        props: ["profile_id"],
        components: {
            Datepicker,
            VueTimepicker,
            VueGoogleAutocomplete,
            VCreditCard
        },
        data() {
            return {
                errors: {},
                userData: "",
                accommodations: "",
                transports: "",
                meals: [],
                allMeals: [],
                allAvailabilities: [],
                transportFreeKm: "",
                transportExtraKmRate: "",
                showCard: false,
                mealTypes: [],
                form: {
                    providerId: this.profile_id,
                    // accommodations
                    selectedAccommodation: "",
                    accommodationFrom: "",
                    accommodationTo: "",
                    accommodationDays: 0,
                    accommodationPrice: 0,
                    adults: 1,
                    childrens: 0,
                    infants: 0,
                    adultsChildrensDisable: false,

                    // transports
                    selectedTransport: "",
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

                    // meals
                    selectedMeal: "",
                    selectedMealType: [],
                    mealFrom: "",
                    mealTo: "",
                    mealDays: 0,
                    mealPrice: 0,
                    mealBookings: [],

                    // availability
                    selectedAvailability: '',
                    availableDates: {},
                    availabilityAdults: 1,
                    availabilityChildrens: 0,
                    availabilityInfants: 0,
                    availabilityAdultsChildrensDisable: false,
                    availabilityDays: 0,
                    availabilityTotalAmount: 0,


                    totalAmount: 0,
                    description: "",
                    userPickUpLocation: "",

                    // strip
                    card: {
                        name: '',
                        cardNumber: '',
                        expiration: '',
                        security: ''
                    },
                    perNight: 0,
                    weeklyDiscountPercent: 0,
                    weeklyDiscount: 0,
                },
                accommodationDates: {},
                mealDates: {},
                transportDates: {},
                transportOneDayDate: '',
                availableDates: {},
            };
        },
        created() {
            this.$helpers.getUserData(this.profile_id, data => {
                this.userData = data;
                this.accommodations = data.host_accommodations;
                this.transports = data.host_transports;
                this.allMeals = data.host_meals;
                this.activities = data.host_activities;
                this.allAvailabilities = data.host_availabilities;
            });
            this.$helpers.getAllMeals(mealTypes => {
                this.mealTypes = mealTypes;
            });
        },
        methods: {
            incrementAvailability(type) {
                if (type == 'adult') {
                    if (this.maxPeopleAvailability()) {
                        this.form.availabilityAdults++;
                        this.getAvailableDates();
                    }
                } else if (type == 'children') {
                    if (this.maxPeopleAvailability()) {
                        this.form.availabilityChildrens++;
                        this.getAvailableDates();
                    }
                } else if (type == 'infant') {
                    this.form.availabilityInfants++;
                }
                this.calculatePrice();
            },
            decrementAvailability(type) {
                if (type == 'adult') {
                    if (this.form.availabilityAdults > 1) {
                        this.form.availabilityAdults--;
                        this.maxPeopleAvailability();
                        this.getAvailableDates();
                    }
                } else if (type == 'children') {
                    if (this.form.availabilityChildrens > 0) {
                        this.form.availabilityChildrens--;
                        this.maxPeopleAvailability();
                        this.getAvailableDates();
                    }
                } else if (type == 'infant') {
                    if (this.form.availabilityInfants > 0) {
                        this.form.availabilityInfants--;
                    }
                }
                this.calculatePrice();
            },
            maxPeopleAvailability() {
                var res = false;
                if ((this.form.availabilityAdults + this.form.availabilityChildrens) < this.form.selectedAvailability.no_of_people) {
                    res = true;
                    this.form.availabilityAdultsChildrensDisable = false;
                } else {
                    res = false;
                    this.form.availabilityAdultsChildrensDisable = true;
                }
                return res;
            },
            getAvailableDates() {
                this.$helpers.isLoading(true);
                this.$helpers.getAvailableDatesByAvailabilityIdAndGroupSize(
                    this.form.selectedAvailability.id,
                    (parseInt(this.form.availabilityAdults) + parseInt(this.form.availabilityChildrens))
                    , dates => {
                        this.availableDates = [];
                        if (dates) {
                            this.form.availableDates = {};
                            dates.forEach((date, i) => {
                                if (date) {
                                    this.availableDates.push({
                                        start: new Date(date.start),
                                        end: new Date(date.end)
                                    })
                                }
                            });
                        }
                        this.$helpers.isLoading(false);
                    })
            },

            mealTypechange() {
                var res = [];
                this.allMeals.forEach(userMeal => {
                    if (this.form.selectedMealType.id == userMeal.meal_id) {
                        res.push(userMeal);
                    }
                });
                this.meals = res;
                this.form.selectedMeal = "";
                this.form.mealFrom = "";
                this.form.mealTo = "";
                this.form.mealDays = 0;
                this.form.mealPrice = 0;
            },
            getLength(myArr) {
                return myArr.length;
            },
            accommodaitonChange() {
                this.form.adultsChildrensDisable = false;
                this.form.adults = 1;
                this.form.childrens = 0;
                this.form.infants = 0;
                this.calculatePrice();
            },
            increment(type) {
                if (type == 'adult') {
                    if (this.maxPeople()) {
                        this.form.adults++;
                    }
                    this.calculatePrice();
                } else if (type == 'children') {
                    if (this.maxPeople()) {
                        this.form.childrens++;
                    }
                    this.calculatePrice();
                } else if (type == 'infant') {
                    this.form.infants++;
                }
            },
            decrement(type) {
                if (type == 'adult') {
                    if (this.form.adults > 1) {
                        this.form.adults--;
                        this.maxPeople();
                    }
                    this.calculatePrice();
                } else if (type == 'children') {
                    if (this.form.childrens > 0) {
                        this.form.childrens--;
                        this.maxPeople();
                    }
                    this.calculatePrice();
                } else if (type == 'infant') {
                    if (this.form.infants > 0) {
                        this.form.infants--;
                    }
                }
            },
            maxPeople() {
                var res = false;
                if ((this.form.adults + this.form.childrens) < this.form.selectedAccommodation.no_of_people) {
                    res = true;
                    this.form.adultsChildrensDisable = false;
                } else {
                    res = false;
                    this.form.adultsChildrensDisable = true;
                }
                return res;
            },
            creditInfoChanged(values) {
                for (const key in values) {
                    this.form.card[key] = values[key];
                }
            },
            removeBooking(book) {
                var allbookings = [];
                if (this.form.hourlyBookings.length > 0) {
                    this.form.hourlyBookings.forEach((currentBook, index) => {
                        if (
                            currentBook.date != book.date &&
                            currentBook.check_in != book.check_in &&
                            currentBook.check_out != book.check_out
                        ) {
                            allbookings.push(currentBook);
                        }
                    });
                }
                this.form.hourlyBookings = [];
                this.form.hourlyBookings = allbookings;
                this.calculatePrice();
            },
            removeMealBooking(book, index) {
                var allbookings = [];
                if (this.form.mealBookings.length > 0) {
                    this.form.mealBookings.forEach((currentBook, i) => {
                        if (
                            i != index
                        ) {
                            allbookings.push(currentBook);
                        }
                    });
                }
                this.form.mealBookings = [];
                this.form.mealBookings = allbookings;
                this.calculatePrice();
            },
            addHourlyBooking() {
                if (
                    this.form.transportHoulyDate &&
                    this.form.transportHoulyCheckIn &&
                    this.form.transportHoulyCheckOut
                ) {
                    this.form.hourlyBookings.push({
                        date: moment(this.form.transportHoulyDate).format("YYYY-MM-DD"),
                        check_in: this.form.transportHoulyCheckIn,
                        check_out: this.form.transportHoulyCheckOut,
                        hours: this.getHoursDiffByDates()
                    });
                    this.calculatePrice();
                    // this.form.transportHoulyDate = "";
                    // this.form.transportHoulyCheckIn = "";
                    // this.form.transportHoulyCheckOut = "";
                } else {
                    this.$swal("Please, Select full fill all requirement.");
                }
            },
            addMealBooking() {
                if (
                    this.form.selectedMeal &&
                    this.mealDates
                ) {
                    this.form.mealBookings.push({
                        meal: this.form.selectedMeal,
                        date_from: moment(this.mealDates.start).format("YYYY-MM-DD"),
                        date_to: moment(this.mealDates.end).format("YYYY-MM-DD"),
                    });
                    this.calculatePrice();
                    // this.form.transportHoulyDate = "";
                    // this.form.transportHoulyCheckIn = "";
                    // this.form.transportHoulyCheckOut = "";
                } else {
                    this.$swal("Please, Select full fill all requirement.");
                }
            },
            getHoursDiffByDates() {
                var timeStart = new Date(((moment(this.form.transportHoulyDate).format("YYYY-MM-DD")) + " " + this.form.transportHoulyCheckIn));
                var timeEnd = new Date(((moment(this.form.transportHoulyDate).format("YYYY-MM-DD")) + " " + this.form.transportHoulyCheckOut));
                var diffInHours = Math.abs(timeStart - timeEnd) / 36e5;
                return diffInHours;
            },
            /**
             * When the location found
             * @param {Object} addressData Data of the found location
             * @param {Object} placeResultData PlaceResult object
             * @param {String} id Input container ID
             */
            getAddressData: function (addressData, placeResultData, id) {
                this.form.userPickUpLocation = addressData;
                this.calculatePrice();
            },
            inCityRequire(val) {
                this.form.transportDateFrom = "";
                this.form.transportDateTo = "";
                this.form.transportPrice = 0;
                this.form.transportExtraKmPrice = 0;
                this.calculatePrice();
                this.form.transportTime = "";
                this.$helpers.initilizesMDTimepicker();
            },
            dayOrHourlySelect(val) {
                this.form.transportDateFrom = "";
                this.form.transportDateTo = "";
                this.form.transportPrice = 0;
                this.form.transportExtraKmPrice = 0;
                this.calculatePrice();
                this.form.transportTime = "";
                this.accommodationDates = {};
                this.mealDates = {};
                this.transportDates = {};
                this.transportOneDayDate = '';
                this.form.transportDateFrom = "";
                this.form.transportDateTo = "";
                this.form.transportTime = "";
                this.form.transportHoulyDate = "";
                this.form.transportHoulyCheckIn = "";
                this.form.transportHoulyCheckOut = "";
                this.$helpers.initilizesMDTimepicker();
            },
            hourlyDate(date) {
                return (this.form.transportHoulyDate = moment(date).format("YYYY-MM-DD"));
            },
            inCityDateFrom(date) {
                return (this.form.transportDateFrom = moment(date).format("YYYY-MM-DD"));
            },
            inCityDateTo(date) {
                return (this.form.transportDateTo = moment(date).format("YYYY-MM-DD"));
            },
            accommodationFrom(date) {
                return (this.form.accommodationFrom = moment(date).format("YYYY-MM-DD"));
            },
            accommodationTo(date) {
                return (this.form.accommodationTo = moment(date).format("YYYY-MM-DD"));
            },
            mealFrom(date) {
                return (this.form.mealFrom = moment(date).format("YYYY-MM-DD"));
            },
            mealTo(date) {
                return (this.form.mealTo = moment(date).format("YYYY-MM-DD"));
            },
            selectTransport() {
                this.transportFreeKm = this.form.selectedTransport.free_km;
                this.transportExtraKmRate = this.form.selectedTransport.extra_km_rate;
                this.calculatePrice();
            },
            reset() {
                this.form.selectedAccommodation = "";
                this.form.accommodationFrom = "";
                this.form.accommodationTo = "";
                this.form.accommodationDays = 0;
                this.form.accommodationPrice = 0;
                this.form.selectedTransport = "";
                this.form.transportDays = "";
                this.form.transportPrice = 0;
                this.form.transportCity = "";
                this.form.transportInCityRequire = "";
                this.form.transportDateFrom = "";
                this.form.transportDateTo = "";
                this.form.transportExtraKmPrice = "";
                this.form.transportTime = "";
                this.form.transportHoulyDate = "";
                this.form.transportHoulyCheckIn = "";
                this.form.transportHoulyCheckOut = "";
                this.form.hourlyBookings = [];
                this.form.selectedMeal = "";
                this.form.mealFrom = "";
                this.form.mealTo = "";
                this.form.mealDays = 0;
                this.form.mealPrice = 0;
                this.form.totalAmount = 0;
                this.form.description = "";
                this.form.userPickUpLocation = '';
                this.form.card.name = '';
                this.form.card.cardNumber = '';
                this.form.card.expiration = '';
                this.form.card.security = '';

                this.accommodationDates = {};
                this.mealDates = {};
                this.transportDates = {};
                this.transportOneDayDate = '';

                this.showCard = false;
            },
            calculatePrice() {
                this.form.totalAmount = this.form.accommodationDays = this.form.transportDays = this.form.mealDays = this.form.accommodationPrice = this.form.mealPrice = this.form.transportPrice = 0;
                var transportPrice = 0;

                // Accommodation Pricing
                if (this.form.selectedAccommodation && this.accommodationDates) {
                    this.form.accommodationFrom = moment(this.accommodationDates.start).format("YYYY-MM-DD");
                    this.form.accommodationTo = moment(this.accommodationDates.end).format("YYYY-MM-DD");
                    var date1 = new Date(this.form.accommodationFrom);
                    var date2 = new Date(this.form.accommodationTo);
                    // To calculate the time difference of two dates
                    var DifferenceInTime = date2.getTime() - date1.getTime();

                    var clean_fee = this.form.selectedAccommodation.clean_fee ? this.form.selectedAccommodation.clean_fee : 0;
                    var service_fee = this.form.selectedAccommodation.service_fee ? this.form.selectedAccommodation.service_fee : 0;
                    var taxes_fees = this.form.selectedAccommodation.taxes_fees ? this.form.selectedAccommodation.taxes_fees : 0;
                    this.form.perNight = parseInt(this.form.selectedAccommodation.per_night);
                    var adultsCounter = parseInt(this.form.adults) + parseInt(this.form.childrens);

                    if (adultsCounter > this.form.selectedAccommodation.limit_people) {
                        var extraAdults = adultsCounter - parseInt(this.form.selectedAccommodation.limit_people);
                        this.form.perNight = parseInt(this.form.perNight) + (extraAdults * parseInt(this.form.selectedAccommodation.extra_price));
                    }
                    // To calculate the no. of days between two dates
                    this.form.accommodationDays = DifferenceInTime / (1000 * 3600 * 24);
                    this.form.accommodationPrice = (parseInt(this.form.accommodationDays) * parseInt(this.form.perNight)) + clean_fee + service_fee + taxes_fees;

                    this.form.weeklyDiscount = 0;
                    this.form.weeklyDiscountPercent = 0;
                    // Weekly Discount
                    if (parseInt(this.form.accommodationDays) >= 28 && parseInt(this.form.selectedAccommodation.discount_week_4) > 0) {
                        this.form.weeklyDiscountPercent = parseInt(this.form.selectedAccommodation.discount_week_4);
                        this.form.weeklyDiscount = (this.form.accommodationPrice / 100) * parseInt(this.form.selectedAccommodation.discount_week_4);
                    } else if (parseInt(this.form.accommodationDays) >= 21 && parseInt(this.form.selectedAccommodation.discount_week_3) > 0) {
                        this.form.weeklyDiscountPercent = parseInt(this.form.selectedAccommodation.discount_week_3);
                        this.form.weeklyDiscount = (this.form.accommodationPrice / 100) * parseInt(this.form.selectedAccommodation.discount_week_3);
                    } else if (parseInt(this.form.accommodationDays) >= 14 && parseInt(this.form.selectedAccommodation.discount_week_2) > 0) {
                        this.form.weeklyDiscountPercent = parseInt(this.form.selectedAccommodation.discount_week_2);
                        this.form.weeklyDiscount = (this.form.accommodationPrice / 100) * parseInt(this.form.selectedAccommodation.discount_week_2);
                    } else if (parseInt(this.form.accommodationDays) >= 7 && parseInt(this.form.selectedAccommodation.discount_week_1) > 0) {
                        this.form.weeklyDiscountPercent = parseInt(this.form.selectedAccommodation.discount_week_1);
                        this.form.weeklyDiscount = (this.form.accommodationPrice / 100) * parseInt(this.form.selectedAccommodation.discount_week_1);
                    }
                    this.form.accommodationPrice = this.form.accommodationPrice - this.form.weeklyDiscount;
                }

                // Meal Pricing
                if (this.form.mealBookings.length) {
                    var totalDays = 0;
                    var price = 0;
                    this.form.mealPrice = 0;
                    this.form.mealBookings.forEach(booking => {
                        price = booking.meal.price;
                        var date1 = new Date(booking.date_from);
                        var date2 = new Date(booking.date_to);
                        // To calculate the time difference of two dates
                        var DifferenceInTime = date2.getTime() - date1.getTime();
                        // To calculate the no. of days between two dates
                        totalDays = DifferenceInTime / (1000 * 3600 * 24);
                        this.form.mealDays += totalDays;
                        this.form.mealPrice += parseInt(totalDays) * parseInt(price);
                        // console.log('Days: ', totalDays, ' Price', price, 'total Price: ', this.form.mealPrice);
                    });
                }

                // Transport Pricing
                if (this.form.selectedTransport) {
                    if (this.form.transportInCityRequire == "day" ||
                        this.form.transportInCityRequire == "days" ||
                        this.form.transportCity == "out" ||
                        this.form.transportInCityRequire == "hourly") {

                        if (this.form.hourlyBookings.length && this.form.transportInCityRequire == "hourly") {
                            var hourlyPrice = this.form.selectedTransport.hourly_price;
                            var totalHours = 0;
                            if (this.form.hourlyBookings.length) {
                                this.form.hourlyBookings.forEach(booking => {
                                    totalHours += parseInt(booking.hours);
                                });
                                transportPrice = parseInt(hourlyPrice) * parseInt(totalHours);
                                console.log('Total Hours: ', totalHours, 'Per Hour Price', hourlyPrice, 'total Price of hours: ', transportPrice);
                            }
                        } else {
                            if (this.form.transportInCityRequire == 'day') {
                                this.form.transportDateFrom = this.transportOneDayDate;
                                if (this.form.transportDateFrom) {
                                    this.form.transportDays = 1;
                                    transportPrice = parseInt(this.form.transportDays) * parseInt(this.form.selectedTransport.per_day_price);
                                }
                            } else {
                                this.form.transportDateFrom = moment(this.transportDates.start).format("YYYY-MM-DD");
                                this.form.transportDateTo = moment(this.transportDates.end).format("YYYY-MM-DD");

                                var date1 = new Date(this.form.transportDateFrom);
                                var date2 = new Date(this.form.transportDateTo);
                                // To calculate the time difference of two dates
                                var DifferenceInTime = date2.getTime() - date1.getTime();
                                // To calculate the no. of days between two dates
                                this.form.transportDays = DifferenceInTime / (1000 * 3600 * 24) + 1;
                                transportPrice = parseInt(this.form.transportDays) * parseInt(this.form.selectedTransport.full_day_price);
                            }
                        }
                        var userLat = parseFloat(this.userData.user.latitude);
                        var userLong = parseFloat(this.userData.user.longitude);
                        var pickUpLat = this.form.userPickUpLocation.latitude;
                        var pickUpLong = this.form.userPickUpLocation.longitude;
                        console.log("userLat", userLat, "userLong", userLong, "pickUpLat", pickUpLat, "pickUpLong", pickUpLong);
                        var pickUpKm = 0;
                        this.$helpers.getDistanceByLatitudeAndLongitude(userLat, userLong, pickUpLat, pickUpLong, "K", km => {
                            pickUpKm = km;
                            if (pickUpKm > this.form.selectedTransport.free_km) {
                                var diffKm = pickUpKm - this.form.selectedTransport.free_km;
                                this.form.transportExtraKmPrice = diffKm * this.form.selectedTransport.extra_km_rate;
                            }
                            this.form.transportPrice = transportPrice + parseInt(this.form.transportExtraKmPrice);
                            // console.log("difference km", pickUpKm,
                            //     "free_km ", this.form.selectedTransport.free_km,
                            //     "extra_km_rate", this.form.selectedTransport.extra_km_rate,
                            //     "extra price", this.form.transportExtraKmPrice
                            // );
                        });
                    }
                }

                this.form.availabilityTotalAmount = this.form.availabilityDays = 0;
                // Availability Pricing
                if (this.form.selectedAvailability && this.form.availableDates.start && this.form.availableDates.end) {
                    var date1 = new Date(this.form.availableDates.start);
                    var date2 = new Date(this.form.availableDates.end);
                    // To calculate the time difference of two dates
                    var differenceInTime = date2.getTime() - date1.getTime();
                    // To calculate the no. of days between two dates
                    this.form.availabilityDays = differenceInTime / (1000 * 3600 * 24) + 1;
                    this.form.availabilityTotalAmount = (parseInt(this.form.availabilityAdults + this.form.availabilityChildrens) * parseInt(this.form.availabilityDays)) * parseInt(this.form.selectedAvailability.per_person_price);
                }
                let accommodationTotalPrice = Number.isNaN(parseInt(this.form.accommodationPrice)) ? 0 : parseInt(this.form.accommodationPrice);
                let transportTotalPrice = Number.isNaN(parseInt(this.form.transportPrice)) ? 0 : parseInt(this.form.transportPrice);
                let mealTotalPrice = Number.isNaN(parseInt(this.form.mealPrice)) ? 0 : parseInt(this.form.mealPrice);

                return this.form.totalAmount = accommodationTotalPrice + transportTotalPrice + mealTotalPrice + this.form.availabilityTotalAmount;
            },
            setTimepickerValues() {
                if (this.form.transportCity == 'out') {
                    this.form.transportTime = $('#time_out_date').attr('value');
                } else if (this.form.transportCity == 'in'
                    && (this.form.transportInCityRequire == 'day' || this.form.transportInCityRequire == 'days')) {
                    this.form.transportTime = $('#transportTime').attr('value');
                } else if (this.form.transportCity == 'in' && this.form.transportInCityRequire == 'hourly') {
                    this.form.transportHoulyCheckIn = $('#transportHoulyCheckIn').attr('value');
                    this.form.transportHoulyCheckOut = $('#transportHoulyCheckOut').attr('value');
                }
            },
            send() {
                this.errors = {};
                this.setTimepickerValues();
                if (this.form.availableDates.start && this.form.availableDates.end) {
                    this.form.availableDates.start = moment(this.form.availableDates.start).format("YYYY-MM-DD");
                    this.form.availableDates.end = moment(this.form.availableDates.end).format("YYYY-MM-DD");
                }
                this.$helpers.getAuthCheck(authCheck => {
                    if (authCheck) {
                        if (this.showCard) {
                            this.$helpers.isLoading(true);
                            axios.post("/sendNotificationForBookHost", this.form)
                                .then(res => {
                                    this.$helpers.isLoading(false);
                                    this.$refs.btnClose.click();
                                    this.$swal({
                                        type: "success",
                                        title: "Congrats!",
                                        text: res.data.message,
                                        timer: 2500
                                    });
                                    this.reset();
                                })
                                .catch(err => {
                                    console.log(err);
                                    if ((err.response.status = 422 && err.response.data.errors)) {
                                        this.errors = err.response.data.errors;
                                        var self = this;
                                        setTimeout(function () {
                                            self.errors = {};
                                        }, 10000);
                                    }
                                    this.$helpers.isLoading(false);
                                });
                        } else {
                            this.showCard = true;
                        }
                    } else {
                        this.$swal({
                            type: "danger",
                            title: "Sorry!",
                            text: "Please, Login or signup before book Host.",
                            timer: 2500
                        });
                    }
                });
            }
        },
        watch: {
            "form.accommodationFrom": function () {
                this.calculatePrice();
            },
            "form.accommodationTo": function () {
                this.calculatePrice();
            },
            "form.mealFrom": function () {
                this.calculatePrice();
            },
            "form.mealTo": function () {
                this.calculatePrice();
            },
            "form.transportDateFrom": function () {
                this.calculatePrice();
            },
            "form.transportDateTo": function () {
                this.calculatePrice();
            },
            "form.transportHourlyDate": function () {
                this.calculatePrice();
            },
            "accommodationDates": function () {
                this.calculatePrice();
            },
            "mealDates": function () {
                this.calculatePrice();
            },
            "transportDates": function () {
                this.calculatePrice();
            },
            "form.availableDates": function () {
                this.calculatePrice();
            }

        }
    };
</script>

<style scoped>
    .container-checkbox {
        display: block;
        position: relative;
        padding-left: 35px;
        margin: 30px 0 0 0;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #3bc0687a;
        border: 1px solid #0dc068;
        border-radius: 20px;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ffffff;
        border: 2px solid #0dc068;
        border-radius: 20px;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
        background-color: #0dc068;
        border-radius: 20px;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .radiobtn {
        background-color: #2196f3;
    }

    .radiobtn {
        position: absolute;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
    }


    .green {
        color: #2ad4b7;
    }
</style>

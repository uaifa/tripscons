<template>
    <main>
        <div v-if="errors" v-for="(error,index) in errors" :key="index" class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>Error! </strong>{{error[0]}}
        </div>

        <div class="row" v-show="showForm=='0'">
            <div class="col-sm-12 col-md-12">
                <div style="margin: 20px 0 0 0;">
                    <h1><span class="color-green">Do You</span> Provide Trip ?</h1>
                    <!-- Material unchecked -->
                    <div class="form-check">
                        <input type="radio" class="form-radio" id="materialUnchecked" name="materialExampleRadios"
                               value="1" v-model="showForm">
                        <label style="position:relative;top:18px;left:5px;">Yes</label>
                    </div>
                    <!-- Material checked -->
                    <div class="form-check">
                        <input type="radio" class="form-radio" id="materialChecked" name="materialExampleRadios"
                               value="0" v-model="showForm">
                        <label style="position:relative;top:18px;left:5px;">No</label>
                    </div>
                </div>
            </div>
        </div>

        <!--        Listing-->
        <div class="row" v-show="showList && showForm=='1'">
            <div class="col-12">
                <a href="javascript:void(0)"
                   style="float: right; padding: 13px; border-radius: 35px; color: #fffdf9; background-image: linear-gradient( 135deg, #008c72 10%, #10CE66 100%);"
                   class="btn add-new" @click="addNew">Add Trip</a>

                <div v-show="allTrips" style="margin-top:60px">
                    <div class="hotel-box" v-for="(trip,index) in allTrips"
                         :key="index" style="margin-bottom: 15px">
                        <div class="row">
                            <div class="col-sm-4 col-md-4">
                                <div class="hotel-images">
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">
                                            <div class="carousel-item active"
                                                 :style="'background-image: url('+$helpers.getPrimaryImageFromArrayByKey(trip.images,'url')+')'">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-8">
                                <div class="hotel-items">
                                    <div class="row">
                                        <div class="col-sm-10 col-md-10">
                                            <h3><a href="javascript:void (0)">{{trip.title}}</a></h3>
                                        </div>
                                        <div class="col-sm-2 col-md-2">
                                            <div class="person-icon ">
                                                <img src="/basic/img/002-group-1.png" alt="icon">
                                                <span class="number-person">{{trip.group_size}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p>{{trip.about_trip.substr(0,100)}}... </p>

                                    <a href="javascript:void (0)"
                                       style="float:right;margin:10px;"
                                       class="btn-edit" @click="edit(trip)">
                                        <b>Edit</b> </a>
                                    <small v-if="loggedInUser">{{loggedInUser.tag_line}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--        create or update-->
        <div v-show="showList==false && showForm=='1'" style="margin-top:10px">

            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Title:</label>
                        <input type="text" class="form-control"
                               title="Attract guests with a listing title that highlights what makes your place special."
                               v-model="form.title">
                    </div>
                </div>

                <div class="col-sm-3 col-md-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">Trip Type:</label>
                        <select class="custom-select"
                                v-model="form.trip_type">
                            <option value="historical">Historical</option>
                            <option value="linear">Linear</option>
                            <option value="adventure">Adventure</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 col-md-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">Level:</label>
                        <select class="custom-select"
                                v-model="form.level">
                            <option value="easy">Easy</option>
                            <option value="strenuous">Strenuous</option>
                            <option value="moderate">Moderate</option>
                        </select>
                    </div>
                </div>

            </div>

            <!--            Location-->
            <div class="row" style="margin-top:10px;">
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <vue-google-autocomplete
                            style="z-index: 99999999 !important;"
                            ref="address"
                            id="map1"
                            classname="form-control"
                            placeholder="Please type your address"
                            types="(regions)"
                            v-on:placechanged="getAddressData"
                        >
                        </vue-google-autocomplete>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 10px;">
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <label class="bmd-label-floating">Group Size:</label>
                        <input type="number" min="0" class="form-control"
                               title="Number of people"
                               v-model="form.group_size">
                    </div>
                </div>

                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <label class="bmd-label-floating">Traveller Age:</label>
                        <input type="number" min="0" class="form-control"
                               title="Number of people"
                               v-model="form.travelers_age">
                    </div>
                </div>

                <div class="col-sm-5 col-md-5" style="margin-top: 30px;">
                    <div class="custom-switch">
                        <input type="checkbox" class="custom-control-input" id="enquiry_allow1"
                               v-model="form.enquiry_allow">
                        <label class="custom-control-label" for="enquiry_allow1"> Would you allow enquiry before
                            booking?</label>
                    </div>
                </div>

                <div class="col-sm-3 col-md-3" v-show="form.enquiry_allow" style="margin-top: -10px;">
                    <div class="form-group">
                        <label for="enquiry_response1" class="bmd-label-floating">Enquiry response in hours?</label>
                        <input type="number" min="0" class="form-control" name="enquiry_response1"
                               id="enquiry_response1"
                               title="You would response in hours."
                               v-model="form.enquiry_response">
                    </div>
                </div>

            </div>

            <!--   select activities-->
            <div class="row" style="margin-top: 20px;">
                <div class="col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="multi-activities2" class="bmd-label-floating"><b>Select Activities</b></label>
                        <multiselect id="multi-activities2" class="form-control"
                                     v-model="form.selectedActivities"
                                     tag-placeholder="Select Activity"
                                     title="This portion about your activities, what type of activities you can"
                                     placeholder="Select Activity" label="name" track-by="id"
                                     :options="optionsActivities" :multiple="true" :taggable="true"
                                     @tag="addActivity"></multiselect>
                    </div>
                </div>
            </div>

            <!--            Add Includes-->
            <div class="row" style="margin-top: 20px;">
                <div class="col-sm-12 col-md-12">
                    <h1><span class="color-green">Add</span> Includes:</h1>
                    <div class="form-group phone-input">
                        <label for="included" class="bmd-label-floating">What would be included.</label>
                        <input type="text"
                               title="What would be included in trip."
                               class="form-control" id="included" name="include"
                               v-model="includedText"/>
                        <button class="btn btn-sm btn-verify ripple" @click="addIncluded">Add
                        </button>
                    </div>
                </div>
            </div>

            <!--Show Includes List-->
            <div class="row" v-if="form.included">
                <div class="col-sm-12 col-md-12">
                    <div class="form-group phone-input">
                        <ul class="list-group">
                            <li class="list-group-item"
                                style="border: 1px #cfcbcb solid; border-radius: 6px; margin: 2px;background-color: rgba(234, 234, 234, 0.22);"
                                v-for="(included,index) in form.included" :key="index">
                                <b style="color: #049970;margin-right:6px;">{{index+1}} )</b>{{included.text}}
                                <button class="btn btn-sm btn-verify ripple"
                                        style="position: absolute; right: 6px;top: 6px; bottom: 0px;"
                                        @click="removeIncluded(included)">Remove
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!--            Add Excluded-->
            <div class="row" style="margin-top: 20px;">
                <div class="col-sm-12 col-md-12">
                    <h1><span class="color-green">Add</span> Excludes:</h1>
                    <div class="form-group phone-input">
                        <label for="excluded" class="bmd-label-floating">What would be excluded in trip.</label>
                        <input type="text"
                               title="What would be excluded in trip."
                               class="form-control" id="excluded" name="include"
                               v-model="excludedText"/>
                        <button class="btn btn-sm btn-verify ripple" @click="addExcluded">Add
                        </button>
                    </div>
                </div>
            </div>

            <!--Show Excludes List-->
            <div class="row" v-if="form.excluded">
                <div class="col-sm-12 col-md-12">
                    <div class="form-group phone-input">
                        <ul class="list-group">
                            <li class="list-group-item"
                                style="border: 1px #cfcbcb solid; border-radius: 6px; margin: 2px;background-color: rgba(234, 234, 234, 0.22);"
                                v-for="(excluded,index) in form.excluded" :key="index">
                                <b style="color: #049970; margin-right:6px;">{{index+1}} )</b>{{excluded.text}}
                                <button class="btn btn-sm btn-verify ripple"
                                        style="position: absolute; right: 6px;top: 6px; bottom: 0px;"
                                        @click="removeExcluded(excluded)">Remove
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!--                            Agenda Section-->
            <div class="include-section">
                <h1><span class="color-green">Add Your </span> Agenda:</h1>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div style="display: inline-flex;">
                            <!-- Material unchecked -->
                            <div class="form-check">
                                <input type="radio" class="form-radio" name="materialExampleRadios"
                                       value="daywise" v-model="form.agenda_type" @change="changeAgendaType">
                                <label style="position:relative;top:14px;left:5px;">Day wise</label>
                            </div>
                            <!-- Material checked -->
                            <div class="form-check">
                                <input type="radio" class="form-radio" name="materialExampleRadios"
                                       value="datewise" v-model="form.agenda_type" @change="changeAgendaType">
                                <label style="position:relative;top:14px;left:5px;">Date wise</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="form.agenda_type=='datewise'" style="margin-top:20px;">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">

                                <vuejs-datepicker :bootstrap-styling="true"
                                                  placeholder=" Select Date From..."
                                                  v-model="form.agenda_date_from"
                                                  :format="dateFrom"></vuejs-datepicker>

                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">

                                <vuejs-datepicker :bootstrap-styling="true"
                                                  placeholder=" Select Date From..."
                                                  v-model="form.agenda_date_to"
                                                  :format="dateTo"></vuejs-datepicker>

                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="form.agenda_type=='daywise'" style="margin-top:20px;">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="agenda_day" class="bmd-label-floating">Agenda Days?</label>
                                <input type="number" min="0" class="form-control" name="agenda_day" id="agenda_day"
                                       v-model="form.agenda_day" @change="agendaDays">
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" agenda_row" v-show="form.agenda.length"
                     v-for="(day,index) in form.agenda"
                     :key="index">
                    <h1>Day {{index+1}}:</h1>
                    <div class="row" v-for="(activity, indexactivity) in day.activities"
                         :key="indexactivity">
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group ">
                                <label class="bmd-label-floating">Time {{indexactivity+1}}</label>
                                <vue-timepicker v-model="activity.time" close-on-complete
                                                placeholder="Select Time"></vue-timepicker>

                                <!--                                                <input v-model="activity.time" type="time" class="form-control"-->
                                <!--                                                       :id="'day'+(index+1)" :name="'day'+(index+1)"-->
                                <!--                                                >-->
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-4">
                            <div class="form-group ">
                                <label class="bmd-label-floating">Activity {{indexactivity+1}}</label>
                                <input v-model="activity.description" type="text" class="form-control"
                                       :id="'activity_day'+(index+1)"
                                       :name="'activity_day'+(index+1)"
                                >
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-4">
                            <div class="form-group ">
                                <label class="bmd-label-floating">Location {{indexactivity+1}}</label>
                                <div class="search-wrapper">
                                    <vue-google-autocomplete
                                        style="z-index: 99999999 !important;"
                                        :id="'map'+index+'_'+indexactivity"
                                        classname="form-control"
                                        placeholder="Please Enter location"
                                        types="(regions)"
                                        v-on:placechanged="getAddressData"
                                        @change="saveAgendaLocation(index,indexactivity)"
                                    >
                                    </vue-google-autocomplete>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group ">
                                <button v-if="indexactivity != 0" class="btn btn-success"
                                        style="float: right;font-size: 35px;"
                                        @click="deleteActivtiy(day,indexactivity)"><i
                                    class="fa fa-trash-o" style="color: #5bc068;"></i></button>
                                <button class="btn btn-success" style="float: right;font-size: 35px;"
                                        @click="addActivityAgenda(day)"><i
                                    class="fa fa-plus-square" style="color: #5bc068;"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--            Pricing And Free Ages and Paid ages pricing-->
            <div class="row" style="margin-top:30px;">
                <div class="col-sm-12 col-md-12">
                    <h1><span class="color-green">Smart</span> Pricing:</h1>
                </div>
                <div class="col-sm-3 col-md-3" style="margin-top: -10px;">
                    <div class="form-group">
                        <label for="price" class="bmd-label-floating">Price in $:</label>
                        <input type="number" min="0" class="form-control" name="price"
                               id="price"
                               title="Actual price of all services."
                               v-model="form.price">
                    </div>
                </div>

                <div class="col-sm-3 col-md-3" style="margin-top: -10px;">
                    <div class="form-group">
                        <label for="free_age" class="bmd-label-floating">Free Age Limit:</label>
                        <input type="number" min="0" class="form-control" name="free_age"
                               id="free_age"
                               title="Write down maximum age OR you would allow to be free in trip."
                               v-model="form.free_age">
                    </div>
                </div>

                <div class="col-sm-3 col-md-3" style="margin-top: -10px;">
                    <div class="form-group">
                        <label for="limit_age" class="bmd-label-floating">Age For Paid:</label>
                        <input type="number" min="0" class="form-control" name="limit_age"
                               id="limit_age"
                               title="Write down age when age limit cross it would be paid."
                               v-model="form.paid_age">
                    </div>
                </div>

                <div class="col-sm-3 col-md-3" style="margin-top: -10px;">
                    <div class="form-group">
                        <label for="price_for_age" class="bmd-label-floating">Price For paid age:</label>
                        <input type="number" min="0" class="form-control" name="price_for_age"
                               id="price_for_age"
                               title="Write down price for paid age."
                               v-model="form.price_for_paid_age">
                    </div>
                </div>

            </div>

            <!--         Instructions-->
            <div class="row">
                <div class="col-sm-12 col-md-12" style="margin-top: 20px">
                    <div class="form-group">
                        <label class="bmd-label-floating">Instructions:</label>
                        <textarea name="description"
                                  title="Write a quick summary of your instruction about trip and traveler."
                                  class="form-control" cols="60" rows="5"
                                  v-model="form.instructions"></textarea>
                    </div>
                </div>
            </div>

            <!--            Add Highlights-->
            <div class="row" style="margin-top: 20px;">
                <div class="col-sm-12 col-md-12">
                    <h1><span class="color-green">Add</span> Highlights:</h1>
                    <div class="form-group phone-input">
                        <label for="highlight" class="bmd-label-floating">Highlights about trip</label>
                        <input type="text"
                               title="What would be excluded in trip."
                               class="form-control" id="highlight" name="highlight"
                               v-model="highlightText"/>
                        <button class="btn btn-sm btn-verify ripple" @click="addHighlight">Add
                        </button>
                    </div>
                </div>
            </div>

            <!--Show Highlights List-->
            <div class="row" v-if="form.highlights">
                <div class="col-sm-12 col-md-12">
                    <div class="form-group phone-input">
                        <ul class="list-group">
                            <li class="list-group-item"
                                style="border: 1px #cfcbcb solid; border-radius: 6px; margin: 2px;background-color: rgba(234, 234, 234, 0.22);"
                                v-for="(highlight,index) in form.highlights" :key="index">
                                <b style="color: #049970; margin-right:6px;">{{index+1}} )</b>{{highlight.text}}
                                <button class="btn btn-sm btn-verify ripple"
                                        style="position: absolute; right: 6px;top: 6px; bottom: 0px;"
                                        @click="removeHighlight(highlight)">Remove
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!--         Description-->
            <div class="row">
                <div class="col-sm-12 col-md-12" style="margin-top: 20px">
                    <div class="form-group">
                        <label class="bmd-label-floating">Describe your place to guests:</label>
                        <textarea name="description"
                                  title="Write a quick summary of your place. You can highlight what’s special about your space, the neighborhood, and how you’ll interact with guests."
                                  class="form-control" cols="60" rows="5"
                                  v-model="form.about_trip"></textarea>
                    </div>
                </div>
            </div>

            <!--           Image Gallery-->
            <div>
                <div class="row">
                    <div class="col-sm-12 col-md-12" style="margin:10px 0 10px -10px;">
                        <h1><span class="color-green">Image</span> Gallery:</h1>
                    </div>
                </div>
                <div class="row glry-row">
                    <div v-show="form.files.length>0"
                         v-for="(image,index) in form.files" :key="index">
                        <!--                                <button v-if="image.primary && image.primary == 1" type="button"-->
                        <!--                                        class="btn btn-lg btn-pill btn-primary primary-img"-->
                        <!--                                        @click="primaryImage(image.fileName)"><i class="fa fa-star"></i> Primary-->
                        <!--                                </button>-->
                        <!--                                <button v-else type="button" class="btn btn-lg btn-pill btn-danger make-primary"-->
                        <!--                                        @click="primaryImage(image.fileName)"><i class="fa fa-star-o"></i> Make Primary-->
                        <!--                                </button>-->
                        <img :src="image.url ? image.url : image"
                             alt="thumbnail" class="img-thumbnail"
                             style="width: 210px; height: 200px;margin: 6px;"/>
                        <button type="button" class="btn-dlt"
                                @click="deleteImage(image.fileName?image.fileName:'',index)">
                            <i class="fa fa-trash"></i></button>
                    </div>

                    <div class="add-more" data-toggle="modal" data-target="#crop-img-trip-operator"
                         title="Photos help guests imagine staying in your place. You can start with one and add more after you publish.">
                        <a href="javascript:void(0)"
                           style="font-size: 40px"
                        ><i class="fa fa-plus"></i>
                        </a>
                    </div>

                </div>
            </div>

            <!--            Buttons-->
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="banner-btn text-right">

                        <a href="javascription:void(0)" id="btn-back" ref="btn-back"
                           class="btn btn-md search-btn-now ripple" style="float: left;display: inline-block;"
                           @click="listShow"
                        ><i class="fa fa-arrow-circle-left"> </i> Back</a>

                        <a href="javascription:void(0)" v-show="textSave=='Update'"
                           class="btn btn-md btn-guide ripple" style="float: left;display: inline-block;top:20px;"
                            @click="deleteTrip"
                        ><i class="fa fa-trash-o"> </i> Delete</a>

                        <a href="javascript:void(0)" id="btn-create" v-show="showForm=='1'"
                           @click="save" class="btn btn-md search-btn-now ripple"
                        >{{textSave}}</a>
                    </div>
                </div>
            </div>
        </div>

        <cropper-img
            @cropped_file="croppedFile"
            :model_id="'crop-img-trip-operator'"
        ></cropper-img>

    </main>
</template>

<script>
    import VueGoogleAutocomplete from 'vue-google-autocomplete'

    export default {
        name: "TripsOfTripOperator",
        props: ['login_user'],
        components: {
            VueGoogleAutocomplete,
        },
        data() {
            return {
                loggedInUser: this.login_user,
                showForm: '0',
                showList: true,
                textSave: 'Save',
                errors: {},
                optionsActivities: [],
                allTrips: [],
                includedText: '',
                excludedText: '',
                highlightText: '',
                difference_In_Days: 0,
                location: '',
                form: {
                    id: '',
                    title: '',
                    trip_type: '',
                    level: '',
                    group_size: '',
                    travelers_age: '',
                    enquiry_allow: true,
                    enquiry_response: '',
                    selectedActivities: [],
                    location: [],
                    included: [],
                    excluded: [],
                    highlights: [],
                    about_trip: '',
                    instructions: '',
                    agenda_date_from: '',
                    agenda_date_to: '',
                    agenda_type: '',
                    agenda_day: '',
                    agenda: [],
                    price: '',
                    free_age: '',
                    paid_age: '',
                    price_for_paid_age: '',
                    files: [],
                },
                idAndFileName: {
                    id: '',
                    fileName: ''
                }
            }
        },
        mounted() {
            this.$helpers.getAllActivities(activities => {
                this.optionsActivities = activities;
            });
            this.getAll();
        },
        methods: {
            addNew() {
                this.listShow();
                this.showList = false;
                this.showForm = '1';
                this.$refs.address.clear();
            },
            dateFrom(date) {
                this.form.agenda_date_from = moment(date).format('YYYY-MM-DD');
                this.agendaDays();
                return this.form.agenda_date_from;
            },
            dateTo(date) {
                this.form.agenda_date_to = moment(date).format('YYYY-MM-DD');
                this.agendaDays();
                return this.form.agenda_date_to;
            },
            addActivityAgenda(day) {
                day.activities.push({time: '', description: ''})
            },
            deleteActivtiy(day, index) {
                day.activities.splice(index, 1);
            },
            saveAgendaLocation(agendaIndex, activityIndex) {
                this.form.agenda[agendaIndex].activities[activityIndex].location = this.location;
                this.location = '';
            },
            changeAgendaType() {
                this.difference_In_Days = 0;
                this.form.agenda_date_from = '';
                this.form.agenda_date_to = '';
                this.form.agenda = [];
                this.form.agenda_day = '';
            },
            agendaDays() {
                if (this.form.agenda_date_to && this.form.agenda_date_from && this.form.agenda_type == 'datewise') {
                    var dateTo = new Date(this.form.agenda_date_to);
                    var dateFrom = new Date(this.form.agenda_date_from);
                    // To calculate the time difference of two dates
                    var Difference_In_Time = dateTo.getTime() - dateFrom.getTime();
                    // To calculate the no. of days between two dates
                    this.difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

                } else if (this.form.agenda_type == 'daywise' && this.form.agenda_day) {
                    this.difference_In_Days = parseInt(this.form.agenda_day);
                }

                if (this.difference_In_Days) {
                    var days = [];
                    for (var i = 0; i < this.difference_In_Days; i++) {
                        days.push({
                            dayNumber: i + 1,
                            activities: [
                                {
                                    time: "",
                                    description: '',
                                    location: '',
                                }
                            ]
                        })
                    }
                    this.form.agenda = [];
                    this.form.agenda = days;
                    return days;
                }
            },
            addIncluded() {
                if (this.includedText) {
                    this.form.included.push({
                        text: this.includedText
                    });
                    this.includedText = '';
                } else {
                    this.$swal({
                        type: 'error',
                        title: 'Sorry!',
                        text: 'Please, Type about include description then try again.',
                        timer: 2500
                    });
                }
            },
            removeIncluded(included) {
                var all = [];
                if (this.form.included.length > 0) {
                    this.form.included.forEach((include, index) => {
                        if (included.text != include.text) {
                            all.push(include);
                        }
                    });
                }
                this.form.included = [];
                this.form.included = all;
            },
            addExcluded() {
                if (this.excludedText) {
                    this.form.excluded.push({
                        text: this.excludedText
                    });
                    this.excludedText = '';
                } else {
                    this.$swal({
                        type: 'error',
                        title: 'Sorry!',
                        text: 'Please, Type about exclude description then try again.',
                        timer: 2500
                    });
                }
            },
            removeExcluded(excluded) {
                var all = [];
                if (this.form.excluded.length > 0) {
                    this.form.excluded.forEach((exclude, index) => {
                        if (excluded.text != exclude.text) {
                            all.push(exclude);
                        }
                    });
                }
                this.form.excluded = [];
                this.form.excluded = all;
            },
            addHighlight() {
                if (this.highlightText) {
                    this.form.highlights.push({
                        text: this.highlightText
                    });
                    this.highlightText = '';
                } else {
                    this.$swal({
                        type: 'error',
                        title: 'Sorry!',
                        text: 'Please, Type about exclude description then try again.',
                        timer: 2500
                    });
                }
            },
            removeHighlight(highlighted) {
                var all = [];
                if (this.form.highlights.length > 0) {
                    this.form.highlights.forEach((highlight, index) => {
                        if (highlighted.text != highlight.text) {
                            all.push(highlight);
                        }
                    });
                }
                this.form.highlights = [];
                this.form.highlights = all;
            },
            addActivity(newTag) {
                const tag = {
                    name: newTag,
                    id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                };
                this.optionsActivities.push(tag);
                this.form.selectedActivities.push(tag)
            },
            save() {
                this.$helpers.isLoading(true);
                this.errors = {};
                axios.post("/trip/store", this.form)
                    .then((res) => {
                        this.$helpers.isLoading(false);
                        this.showList=true;
                        this.$swal({
                            type: 'success',
                            title: 'Congrats!',
                            text: res.data.message,
                            timer: 2500
                        });
                        this.getAll();
                    })
                    .catch((err) => {
                        this.$helpers.isLoading(false);
                        this.showList=false;
                        console.log(err);
                        if (err.response.status = 422 && err.response.data.errors) {
                            this.errors = err.response.data.errors;
                        }
                    });
            },
            deleteImage(fileName, index) {
                if (fileName) {
                    this.idAndFileName.fileName = fileName;
                    this.idAndFileName.id = this.form.id;
                    axios.post("/trip/delete/image", this.idAndFileName)
                        .then((res) => {
                            this.getImages();
                        })
                        .catch((err) => {
                            console.log(err)
                        })
                } else {
                    this.accommodationForm.files.splice(index, 1)
                }
            },
            getImages() {
                if (this.form.id) {
                    axios.get("/get/trip/images/" + this.form.id)
                        .then((res) => {
                            this.form.files = [];
                            this.form.files = res.data.images;
                        })
                        .catch((err) => {
                            console.log(err)
                        })
                }
            },
            listShow() {
                this.form.showForm = true;
                this.form.textSave = 'Save';
                this.showList = true;
                this.errors = {};
                this.includedText = '';
                this.excludedText = '';
                this.highlightText = '';
                this.difference_In_Days = 0;
                this.location = '';
                this.form.id = '';
                this.form.title = '';
                this.form.trip_type = '';
                this.form.level = '';
                this.form.group_size = '';
                this.form.travelers_age = '';
                this.form.enquiry_allow = true;
                this.form.enquiry_response = '';
                this.form.selectedActivities = [];
                this.form.location = [];
                this.form.included = [];
                this.form.excluded = [];
                this.form.highlights = [];
                this.form.about_trip = '';
                this.form.instructions = '';
                this.form.agenda_date_from = '';
                this.form.agenda_date_to = '';
                this.form.agenda_type = '';
                this.form.agenda_day = '';
                this.form.agenda = [];
                this.form.price = '';
                this.form.free_age = '';
                this.form.paid_age = '';
                this.form.price_for_paid_age = '';
                this.form.files = [];
                this.getAll();
            },
            getAll() {
                this.$helpers.isLoading(true);
                axios.get("/get/all/trips")
                    .then((res) => {
                        this.allTrips = res.data.allTrips;
                        if (this.allTrips.length > 0) {
                            this.showForm = '1';
                        } else {
                            this.showList = false;
                        }
                        this.$helpers.isLoading(false);
                    })
                    .catch((err) => {
                        this.$helpers.isLoading(false);
                        console.log(err)
                    })
            },
            edit(trip) {
                this.showList = false;
                this.textSave = 'Update';
                this.showForm = '1';
                this.form.id = trip.id;
                this.form.title = trip.title;
                this.form.trip_type = trip.trip_type;
                this.form.level = trip.level;
                this.form.group_size = trip.group_size;
                this.form.travelers_age = trip.travelers_age;
                this.form.enquiry_allow = trip.enquiry_allow ? true : false;
                this.form.enquiry_response = trip.enquiry_allow ? trip.enquiry_response : '';
                this.form.location = JSON.parse(trip.location);
                this.form.included = JSON.parse(trip.included);
                this.form.excluded = JSON.parse(trip.excluded);
                this.form.highlights = JSON.parse(trip.highlights);
                this.form.about_trip = trip.about_trip;
                this.form.instructions = trip.instructions;
                this.form.agenda_type = trip.agenda_type;
                this.form.agenda_day = trip.agenda_type == 'daywise' ? trip.agenda_day : '';
                this.form.agenda_date_from = trip.agenda_type == 'datewise' ? trip.agenda_date_from : '';
                this.form.agenda_date_to = trip.agenda_type == 'datewise' ? trip.agenda_date_to : '';
                this.form.agenda = this.$helpers.getAgendaDayFormat(trip.agendas);
                this.form.price = trip.price;
                this.form.free_age = trip.free_age;
                this.form.paid_age = trip.paid_age;
                this.form.price_for_paid_age = trip.price_for_paid_age;
                this.form.files = JSON.parse(trip.images);

                if (trip.activities) {
                    trip.activities.forEach((act, index) => {
                        this.form.selectedActivities.push({
                            name: act.name,
                            id: act.id
                        });
                    })
                }
            },
            deleteTrip() {
                this.$swal({
                    title: "Are you sure?",
                    text: "You Want To Delete?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Yes, Delete it!"
                }).then((result) => {
                    if (result.value) {
                        this.$helpers.isLoading(true);
                        axios.get('/trip/delete/' + this.form.id)
                            .then(res => {
                                this.$helpers.isLoading(false);
                                this.$swal({
                                    type: 'success',
                                    title: 'Congrats!',
                                    text: res.data.message,
                                    timer: 2500
                                });
                                this.showList=true;
                                this.getAll();
                            })
                            .catch(err => {
                                this.$helpers.isLoading(false);
                                this.showList=false;
                                console.log(err);
                            });
                    }
                });
            },
            croppedFile(base64) {
                this.form.files.push(base64);
            },
            /**
             * When the location found
             * @param {Object} addressData Data of the found location
             * @param {Object} placeResultData PlaceResult object
             * @param {String} id Input container ID
             */
            getAddressData: function (addressData, placeResultData, id) {
                this.form.location = addressData;
                this.location = addressData;
            },
        }
    }
</script>


<style scoped>
    #dropfile {
        padding: 20px;
        /*text-align: center;*/
        /*border: 3px #ded5d5 solid;*/
        margin-top: 15px;
    }

    .primary-img {
        position: absolute;
        margin: 10px;
    }

    .make-primary {
        position: absolute;
        background: none;
    }



    .btn-dlt {
        background: #ffffff;
        position: absolute;
        /* top: 7px; */
        margin: 165px 0 0 -40px;
        border: 1px #8b7878 solid;
        padding: 5px;
        border-radius: 30px;
    }


    .multiselect {
        box-sizing: inherit;
    }

    .agenda_row {
        margin-top: 10px;
    }

    .agenda_row .row {
        padding: 10px;
        background: #eee;
        /*border-radius: 25px;*/
    }

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
        background-color: #2196F3;
    }

    .radiobtn {
        position: absolute;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
    }

</style>

<template>

    <div class="modal fade" id="custom-trip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom modal-lg search-popup" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                </button>
                <div class="modal-body">
                    <div class="get-started-sec">
                            <div class="mapsearch-sec">
                            <iframe
                                :src="'https://maps.google.com/maps?q='+quoteForm.lat+','+quoteForm.long+'&hl=es&z=14&amp;output=embed'"
                                width="100%"
                                height="300"
                                frameborder="0"
                                style="border:0; z-index:0">
                            </iframe>
                            <div class="group-icon ">
                                <div class="search-wrapper">
                            <vue-google-autocomplete
                                                    style="z-index: 99999999 !important;"
                                                    ref="address"
                                                    id="map-custom"
                                                    classname="form-control"
                                                    placeholder="    Please type your address"
                                                    types="(regions)"
                                                    v-on:placechanged="getAddressData"
                                                >
                                                </vue-google-autocomplete>
                                </div>
                            </div>
                            </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div v-show="errors" v-for="(error,index) in errors" :key="index"
                                     class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <strong>Error! </strong>{{error[0]}}
                                </div>
                            </div>
                        </div>

                    <div class="letfind-sec">
                        <div class="header-title">
                            <strong>Filters</strong>
                        </div>
                        <div class="row row-pd0" style="margin-bottom: 7px;">
                            <div class="col-sm-6 col-md-6">
                                <label>From</label>
                                <div class="calendar-div">
                                    <vuejs-datepicker :bootstrap-styling="true"
                                                      placeholder=" Select Date From..."
                                                      v-model="quoteForm.dateFrom"
                                                      :format="dateFrom"></vuejs-datepicker>
                                    <img class="calendar-icon" src="/basic/img/calendar-icon.png" alt="icon">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <label>To</label>
                                <div class="calendar-div">
                                    <vuejs-datepicker
                                        :bootstrap-styling="true"
                                        placeholder=" Select Date To..."
                                        v-model="quoteForm.dateTo"
                                        :format="dateTo"></vuejs-datepicker>
                                    <img class="calendar-icon" src="/basic/img/calendar-icon.png" alt="icon">
                                </div>
                            </div>
                        </div>
                        <ul class="icon-btn" v-show="is_index">
                          <li :class="quoteForm.selectedType == 'accommodation'?'active':''"><a href="javascript:void(0);" @click="selectType('accommodation')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/acommodation.svg" alt="img" /></span> Accomodation</a></li>
                          <li :class="quoteForm.selectedType == 'transport'?'active':''"><a href="javascript:void(0);" @click="selectType('transport')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/vehicles.svg" alt="img" /></span> Vehicles</a></li>
                          <li :class="quoteForm.selectedType == 'host'?'active':''"><a href="javascript:void(0);" @click="selectType('host')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/guides.svg" alt="img" /></span> Hosts</a></li>
                          <li :class="quoteForm.selectedType == 'activities'?'active':''"><a href="javascript:void(0);" @click="selectType('activities')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/activity.svg" alt="Activities" /></span> Activities</a></li>
                          <li :class="quoteForm.selectedType == 'trip'?'active':''"><a href="javascript:void(0);" @click="selectType('trip')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/trips.svg" alt="Trips" /></span> Trips</a></li>
                          <li :class="quoteForm.selectedType == 'guide'?'active':''"><a href="javascript:void(0);" @click="selectType('guide')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/guides.svg" alt="Guides" /></span> Guides</a></li>
                          <li :class="quoteForm.selectedType == 'visa_consultant'?'active':''"><a href="javascript:void(0);" @click="selectType('visa_consultant')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/visa.svg" alt="Visa Consultants" /></span> Visa Consultants</a></li>
                          <li :class="quoteForm.selectedType == 'trip_operator'?'active':''"><a href="javascript:void(0);" @click="selectType('trip_operator')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/tripoperator.svg" alt="Trip Operators" /></span> Trip Operators</a></li>
                          <li :class="quoteForm.selectedType == 'movie_maker'?'active':''"><a href="javascript:void(0);" @click="selectType('movie_maker')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/moviemakers.svg" alt="Movie Makers" /></span> Movie Makers</a></li>
                          <li :class="quoteForm.selectedType == 'photographer'?'active':''"><a href="javascript:void(0);" @click="selectType('photographer')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/Photo.svg" alt="Photographers" /></span> Photographers</a></li>
                          <li :class="quoteForm.selectedType == 'events'?'active':''"><a href="javascript:void(0);" @click="selectType('events')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/events.svg" alt="Events" /></span> Events</a></li>
                          <li :class="quoteForm.selectedType == 'restaurants'?'active':''"><a href="javascript:void(0);" @click="selectType('restaurants')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/restaurant.svg" alt="Restaurants" /></span> Restaurants</a></li>
                          <li :class="quoteForm.selectedType == 'cruises'?'active':''"><a href="javascript:void(0);" @click="selectType('cruises')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/cruise.svg" alt="Cruise" /></span> Cruise</a></li>
                          <li :class="quoteForm.selectedType == 'mate'?'active':''"><a href="javascript:void(0);" @click="selectType('mate')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/tripmates.svg" alt="Trip Mates" /></span> Trip Mates</a></li>
                        </ul>


                        <!--                        solo or group-->
                        <div class="row">
                            <div class="col-sm-12 col-md-12"
                                 v-if="quoteForm.selectedType && quoteForm.selectedType.length>0 || is_index || !is_index">
                                <label>Trip Type</label>
                                <select class="custom-select from-control" v-model="quoteForm.tripType">
                                    <option value="one">Solo.</option>
                                    <option value="many">Group</option>
                                </select>
                            </div>
                        </div>
                        <!--                        number of people-->
                        <div class="row" v-show="quoteForm.tripType=='many'">
                            <div class="col-sm-12 col-md-12  mb-10">
                                <label>Select number's of people</label>
                                <input type="text" name="no_of_people" class="form-control"
                                       v-model="quoteForm.no_of_people">
                            </div>
                        </div>

                        <!--                        price minimum and maximum price-->
                        <div class="row" v-show="quoteForm.selectedType=='guide' || quoteForm.selectedType=='visa_consultants'
                         || quoteForm.selectedType=='accommodation' ">
                            <div class="col-sm-6 col-md-6  mb-10">
                                <label>Minimum Price</label>
                                <input type="number" min="0" name="min_price" class="form-control"
                                       v-model="quoteForm.min_price">
                            </div>
                            <div class="col-sm-6 col-md-6  mb-10">
                                <label>Maximum Price</label>
                                <input type="number" min="0" name="max_price" class="form-control"
                                       v-model="quoteForm.max_price">
                            </div>
                        </div>


                        <!--accommodation type and sub type-->
                        <div class="row" v-show="quoteForm.selectedType=='accommodation'">

                            <div class="col-sm-12 col-md-12" v-if="accommodationsTypes && accommodationsTypes.length>0">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Select Accommodation Type:</label>
                                    <select class="custom-select"
                                            v-model="quoteForm.accommodation_type_id">
                                        <option value="">Select One</option>
                                        <option v-for="(type,index) in accommodationsTypes"
                                                :key="index"
                                                :value="type.id">{{type.name.toUpperCase()}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12" v-if="accommodationsSubTypes && accommodationsSubTypes.length>0">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Select Extact Type:</label>
                                    <select class="custom-select"
                                            v-model="quoteForm.accommodation_sub_type_id">
                                        <option v-for="(type,index) in accommodationsSubTypes"
                                                :key="index"
                                                :value="type.id">{{type.name.toUpperCase()}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!--                        Guide inputs-->
                        <div v-show="quoteForm.selectedType=='guide'">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <label>Select Gender</label>
                                    <select class="custom-select" v-model="quoteForm.guideForm.gender   ">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="no">No Preference</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <label for="multi-activities" class=""><b>Interested in</b></label>
                                    <multiselect id="multi-activities" class="select-box-sh"
                                                 v-model="quoteForm.guideForm.selectedActivities"
                                                 tag-placeholder="Select Activity"
                                                 placeholder="Select Activity" label="name" track-by="id"
                                                 :options="optionsActivities" :multiple="true" :taggable="true"
                                                 @tag="addGuideActivity"></multiselect>
                                </div>
                            </div>
                        </div>

                        <!--                        Mate inputs-->
                        <div class="row" v-show="quoteForm.selectedType=='mate'">
                            <div class="col-sm-12 col-md-12">
                                <label for="gender_mate" class="">Gender</label>
                                <div class="form-group">

                                    <select class="custom-select" id="gender_mate" name="gender_mate"
                                            v-model="quoteForm.mateForm.gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="no">No Preference</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!--                        Host inputs and services-->
                        <div class="row" v-show="quoteForm.selectedType=='host'">
                            <div class="col-sm-12 col-md-12">
                                <label for="gender_host">Gender</label>
                                <div class="form-group">

                                    <select class="custom-select" id="gender_host" name="gender_mate"
                                            v-model="quoteForm.hostOptions.gender">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="no">No Preference</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12">
                                <label for="multi-host-services">Services</label>
                                <div class="form-group">
                                    <multiselect id="multi-host-services" class="select-box-sh"
                                                 v-model="quoteForm.hostOptions.selectServices"
                                                 tag-placeholder="Select Services"
                                                 placeholder="Select Services" label="name" track-by="id"
                                                 :options="optionsHostServices" :multiple="true" :taggable="true"
                                                 @tag="addHostService"></multiselect>
                                </div>
                            </div>

                        </div>

                        <!--                        Host service min and max price-->
                        <div class="row"
                             style="margin-top: 10px;"
                             v-show="quoteForm.hostOptions.selectServices"
                             v-for="(service,i) in quoteForm.hostOptions.selectServices"
                             :key="i"
                        >
                            <div class="col-sm-6 col-md-6  mb-10">
                                <label>{{service.name}} Min Price</label>
                                <input type="number" min="0" name="min_price" class="form-control"
                                       v-model="service.min_price" required>
                            </div>
                            <div class="col-sm-6 col-md-6  mb-10">
                                <label>{{service.name}} Max Price</label>
                                <input type="number" min="0" name="max_price" class="form-control"
                                       v-model="service.max_price" required>
                            </div>

                        </div>

                        <div class="col-sm-12 col-md-12">
                            <div class="textarea_custom">
                                <textarea class="form-control count_words" placeholder="250 Words" rows="8" id="host_description"
                                          name="host_description"
                                          v-model="quoteForm.description"></textarea>
                            </div>
                        </div>
                        </div>

                        <div class="btn-sec text-center">
                            <a href="javascript:void(0);" style="margin-top: 0px; margin-bottom: 20px;" class="btn btn-more" @click="getQuote">Submit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueGoogleAutocomplete from 'vue-google-autocomplete'
    import Datepicker from 'vuejs-datepicker';

    Vue.component('vuejs-datepicker', Datepicker);
    var moment = require('moment');

    export default {
        name: "CustomTripComponent",
        props: ['user', 'is_index'],
        components: {
            VueGoogleAutocomplete,
            Datepicker
        },
        data() {
            return {
                allActivities: {},
                optionsActivities: [],
                accommodationsTypes: [],
                accommodationsSubTypes: [],
                optionsHostServices: [{id: 1, name: 'Accommodation', min_price: 0, max_price: 0}, {
                    id: 2,
                    name: 'Meal',
                    min_price: 0,
                    max_price: 0
                }, {id: 3, name: 'Transport', min_price: 0, max_price: 0}],
                quoteForm: {
                    userId: this.user && this.user != '0' ? this.user.id : '0',
                    user: this.user && this.user != '0' ? this.user : '',
                    location: '',
                    lat: 31.5203696,
                    long: 74.35874729999999,
                    selectedType: '',
                    tripType: 'one',
                    no_of_people: 1,
                    dateFrom: '',
                    dateTo: '',
                    description: '',
                    min_price: 0,
                    max_price: 0,
                    accommodation_type_id: [],
                    accommodation_sub_type_id: [],
                    guideForm: {
                        selectedActivities: [],
                        gender: 'no',
                    },
                    mateForm: {
                        gender: 'no',
                    },
                    hostOptions: {
                        gender: 'no',
                        selectServices: [],
                    },
                    transportFrom: {
                        vehicle: ''
                    },
                },
                errors: {},
            }
        },
        mounted() {

            axios.get('/getAllActivities')
                .then(res => {
                    this.allActivities = JSON.parse(res.data.activities);
                    if (this.allActivities.length > 0) {
                        this.allActivities.forEach((act, index) => {
                            this.optionsActivities.push({
                                name: act.name,
                                id: act.id
                            });
                        })
                    }
                })
                .catch(err => {
                    console.log(err);
                    console.log(err.response.data);
                });

            this.$helpers.getAllAccommodationTypes(types => {
                this.accommodationsTypes = types;
            });
        },
        methods: {
            addHostService(newTag) {
                const tag = {
                    name: newTag,
                    id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                };
                this.optionsHostServices.push(tag);
                this.quoteForm.hostOptions.selectServices.push(tag);
            },
            dateFrom(date) {
                return this.quoteForm.dateFrom = moment(date).format('YYYY-MM-DD');
            },
            dateTo(date) {
                return this.quoteForm.dateTo = moment(date).format('YYYY-MM-DD');
            },
            /**
             * When the location found
             * @param {Object} addressData Data of the found location
             * @param {Object} placeResultData PlaceResult object
             * @param {String} id Input container ID
             */
            getAddressData: function (addressData, placeResultData, id) {
                this.quoteForm.location = addressData;
                // this.quoteForm.country = addressData.country;
                // this.quoteForm.state = addressData.administrative_area_level_1;
                // this.quoteForm.city = addressData.locality;
                this.quoteForm.lat = addressData.latitude;
                this.quoteForm.long = addressData.longitude;
            },
            getQuote() {
                this.$helpers.isLoading(true);
                this.errors = {};

                axios.post('/api/getQuote', this.quoteForm)
                    .then(res => {
                        this.$helpers.isLoading(false);
                        // this.$swal({
                        //     type: 'success',
                        //     title: 'Congrats!',
                        //     text: res.data.message,
                        //     timer: 2500
                        // });
                        // this.reset();
                    })
                    .catch(err => {
                        this.$helpers.isLoading(false);
                        if (err.response.status == 422 && err.response.data.errors) {
                            this.errors = err.response.data.errors;
                        }
                    })
                    .finally(() => {
                        // this.$refs.closeModal.click();
                    });
            },
            selectType(type) {
                this.reset();
                this.quoteForm.selectedType = type;
            },
            addGuideActivity(newTag) {
                const tag = {
                    name: newTag,
                    id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                };
                this.optionsActivities.push(tag);
                this.quoteForm.guideForm.selectedActivities.push(tag)
            },
            reset() {
                this.quoteForm.location = '';
                this.quoteForm.lat = 31.5203696;
                this.quoteForm.long = 74.35874729999999;
                this.quoteForm.selectedType = '';
                this.quoteForm.tripType = 'one';
                this.quoteForm.no_of_people = 1;
                this.quoteForm.dateFrom = '';
                this.quoteForm.dateTo = '';
                this.quoteForm.description = '';
                this.quoteForm.guideForm.selectedActivities = [];
                this.quoteForm.guideForm.transport = '';
                this.quoteForm.guideForm.gender = '';
                this.quoteForm.mateForm.gender = '';
                this.quoteForm.hostOptions.gender = '';
                this.quoteForm.transportFrom.vehicle = '';
                this.quoteForm.min_price = '';
                this.quoteForm.max_price = '';
                this.quoteForm.accommodation_type_id = [];
                this.quoteForm.accommodation_sub_type_id = [];
                this.quoteForm.hostOptions.selectServices = [];
            }
        },
        watch: {
            'quoteForm.accommodation_type_id': function () {
                this.$helpers.isLoading(true);
                this.accommodationsSubTypes = [];
                if (this.quoteForm.accommodation_type_id) {
                    this.$helpers.getAllAccommodationSubTypes(this.quoteForm.accommodation_type_id, subTypes => {
                        this.accommodationsSubTypes = subTypes;
                    });
                }
                this.$helpers.isLoading(false);
            },
            'quoteForm.description': function () {
                var res = this.$helpers.wordsLenghtCheck(250, this.quoteForm.description);
                if (!res.success) {
                    this.$swal({
                        type: 'error',
                        title: 'Sorry!',
                        text: 'Please, check words limit, 250 words',
                        timer: 2500
                    });
                }
            },
        }
    }
</script>

<style scoped>
    .multiselect {
        box-sizing: inherit;
    }
    textarea#host_description {
        padding: 15px;
    }

</style>

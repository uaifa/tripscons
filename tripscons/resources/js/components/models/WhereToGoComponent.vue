<template>
    <div class="modal fade" id="where-to-go" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom modal-lg search-popup" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">×</span>
                </button>
                <div class="modal-body">
                    <form action="#" method="get" ref="searchForm">
                        <div class="get-started-sec">


                            <div class="mapsearch-sec ">
                                <iframe
                                    :src="'https://maps.google.com/maps?q='+findForm.lat+','+findForm.long+'&hl=es&z=14&amp;output=embed'"
                                    width="100%"
                                    height="300"
                                    frameborder="0"
                                    style="border:0;z-index:0">
                                </iframe>
                                <div class="group-icon ">
                                    <div class="search-wrapper">
                                        <vue-google-autocomplete
                                            style="z-index: 99999999 !important;padding-left: 35px;"
                                            ref="address"
                                            id="map"
                                            classname="form-control"
                                            placeholder="Please type your address"
                                            types="(regions)"
                                            v-on:placechanged="getAddressData"
                                        >
                                        </vue-google-autocomplete>
                                    </div>
                                </div>
                            </div>

                            <div class="letfind-sec">
                                <strong>Let`s find</strong>
                                <ul class="icon-btn">
                                    <li :class="findForm.selectedType == 'accommodation'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('accommodation')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/acommodation.svg" alt="img" /></span> Accomodation</a></li>
                                    <li :class="findForm.selectedType == 'transport'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('transport')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/vehicles.svg" alt="img" /></span> Vehicles</a></li>
                                    <li :class="findForm.selectedType == 'host'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('host')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/guides.svg" alt="img" /></span> Hosts</a></li>
                                    <li :class="findForm.selectedType == 'activities'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('activities')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/activity.svg" alt="Activities" /></span> Activities</a></li>
                                    <li :class="findForm.selectedType == 'trip'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('trip')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/trips.svg" alt="Trips" /></span> Trips</a></li>
                                    <li :class="findForm.selectedType == 'guide'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('guide')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/guides.svg" alt="Guides" /></span> Guides</a></li>
                                    <li :class="findForm.selectedType == 'visa_consultant'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('visa_consultant')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/visa.svg" alt="Visa Consultants" /></span> Visa Consultants</a></li>
                                    <li :class="findForm.selectedType == 'trip_operator'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('trip_operator')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/tripoperator.svg" alt="Trip Operators" /></span> Trip Operators</a></li>
                                    <li :class="findForm.selectedType == 'movie_maker'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('movie_maker')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/moviemakers.svg" alt="Movie Makers" /></span> Movie Makers</a></li>
                                    <li :class="findForm.selectedType == 'photographer'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('photographer')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/Photo.svg" alt="Photographers" /></span> Photographers</a></li>
<!--                                    <li :class="findForm.selectedType == 'events'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('events')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/events.svg" alt="Events" /></span> Events</a></li>-->
                                    <li :class="findForm.selectedType == 'restaurants'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('restaurants')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/restaurant.svg" alt="Restaurants" /></span> Restaurants</a></li>
<!--                                    <li :class="findForm.selectedType == 'cruises'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('cruises')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/cruise.svg" alt="Cruise" /></span> Cruise</a></li>-->
<!--                                    <li :class="findForm.selectedType == 'mate'?'active':''"><a href="javascript:void(0);" @click="selectForSearch('mate')" class="btn btn-service"><span class="icon-holder"><img src="assets/img/icons/tripmates.svg" alt="Trip Mates" /></span> Trip Mates</a></li>-->
                                </ul>
                                <strong>Filters</strong>

                                <!--                        Guide inputs-->
                                <div class="row" v-if="findForm.selectedType == 'guide'" v-show="findForm.selectedType=='guide'">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group input-field">
                                            <select class="custom-select"
                                                    id="gender_guide"
                                                    name="gender_guide"
                                                    v-model="findForm.guideOptions.gender">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="no">No Preference</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6" >
                                        <div class="form-group input-field">
                                            <multiselect id="multi-activities2" class="selectpicker"
                                                         v-model="findForm.guideOptions.selectedActivities"
                                                         tag-placeholder="Select Activity"
                                                         placeholder="Select Activity" label="name" track-by="id"
                                                         :options="optionsActivities" :multiple="true" :taggable="true"
                                                         @tag="addGuideActivity"></multiselect>
                                        </div>
                                    </div>
                                </div>
                                <!--                        Mate inputs-->

                                <div v-if="findForm.selectedType == 'mate'" class="row" v-show="findForm.selectedType=='mate'">
                                    <div class="col-12 col-sm-6" style="padding: 0 !important;">
                                        <label for="gender_guide">Gender</label>
                                        <div class="form-group input-field">
                                            <select class="custom-select" id="gender_mate" name="gender_mate"
                                                    v-model="findForm.mateOptions.gender">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="no">No Preference</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!--                        Host inputs-->
                                <div class="row" v-if="findForm.selectedType == 'host'"  v-show="findForm.selectedType=='host'">
                                    <div class="col-12 col-sm-6" >
                                        <label for="gender_guide">Gender</label>
                                        <div class="form-group input-field">
                                            <select class="custom-select" id="gender_host" name="gender_mate"
                                                    v-model="findForm.hostOptions.gender">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="no">No Preference</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6" >
                                        <label for="multi-host-services">Services</label>
                                        <div class="form-group input-field">
                                            <multiselect id="multi-host-services" class="selectpicker"
                                                         v-model="findForm.hostOptions.selectServices"
                                                         tag-placeholder="Select Services"
                                                         placeholder="Select Services" label="name" track-by="id"
                                                         :options="optionsServices" :multiple="true" :taggable="true"
                                                         @tag="addHostService"></multiselect>
                                        </div>
                                    </div>

                                </div>

                                <!--                        Photographer inputs-->
                                <div class="row" v-if="findForm.selectedType == 'photographer'"  v-show="findForm.selectedType=='photographer'">
                                    <div class="col-12 col-sm-6" >
                                        <label for="gender_guide">Gender</label>
                                        <div class="form-group input-field">
                                            <select class="custom-select" id="gender_photographer" name="gender_mate"
                                                    v-model="findForm.photographerOptions.gender">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="no">No Preference</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!--                        Movie Maker inputs-->
                                <div class="row" v-if="findForm.selectedType == 'movie maker'"  v-show="findForm.selectedType=='movie maker'">
                                    <div class="col-12 col-sm-6" >
                                        <label for="gender_guide">Gender</label>
                                        <div class="form-group input-field">
                                            <select class="custom-select" id="gender_movieMaker" name="gender_mate"
                                                    v-model="findForm.movieMakerOptions.gender">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="no">No Preference</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!--                        Visa Consultant inputs-->
                                <div class="row"  v-if="findForm.selectedType == 'visa_consultant'" v-show="findForm.selectedType=='visa_consultant'">
                                    <div class="col-12 col-sm-6" >
                                        <label for="multi-activities2">What kind of consultancy are you finding</label>
                                        <div class="form-group input-field">
                                            <multiselect id="multi-vs-consultancy" class="selectpicker"
                                                         v-model="findForm.visaConsultantOptions.selectTypes"
                                                         tag-placeholder="Select "
                                                         placeholder="Select " label="name" track-by="id"
                                                         :options="optionsVSTypes" :multiple="true" :taggable="true"
                                                         @tag="addVSType"></multiselect>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <input type="hidden" :value="findForm.country" name="country">
                            <input type="hidden" :value="findForm.city" name="city">
                            <div class="btn-sec text-center">
                                <a href="javascript:void(0);" style="margin-top: 0px; margin-bottom: 20px;" class="btn btn-more" @click="searchNow">search now!</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--            <input type="hidden" name="_token" :value="csrf">-->
        <!--            <input type="hidden" name="findForm" :value="JSON.stringify(findForm)">-->
    </div>
</template>

<script>
import VueGoogleAutocomplete from 'vue-google-autocomplete'

export default {
    name: "WhereToGoComponent",
    components: {
        VueGoogleAutocomplete
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            config: {
                headers: {'Access-Control-Allow-Origin': '*'}
            },
            allActivities: '',
            optionsActivities: [],
            optionsVSTypes: [],
            optionsServices: [{id: 1, name: 'Accommodation'}, {id: 2, name: 'Meal'}, {id: 3, name: 'Transport'}],
            findForm: {
                selectedType: '',
                guideOptions: {
                    gender: 'no',
                    service: '',
                    selectedActivities: [],
                },
                mateOptions: {
                    gender: 'no',
                },
                photographerOptions: {
                    gender: 'no',
                },
                movieMakerOptions: {
                    gender: 'no',
                },
                hostOptions: {
                    gender: 'no',
                    selectServices: []
                },
                visaConsultantOptions: {
                    selectTypes: [],
                },
                location: 'lahore',
                country: '',
                state: '',
                city: '',
                lat: 31.5203696,
                long: 74.35874729999999
            }
        }
    },
    mounted() {
        //axios.defaults.headers.common['Authorization'] = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI4IiwianRpIjoiYWJkY2NjZDAzMDg1ZTdmYWQ0ZDY3YjlkZDlhZjcxMGU0YTJlNWE1MmY0N2MwZGFmMjI2Y2Q3ZTNhMzk4MTc4MjE4ZTYxYTg0NDczMjQzM2YiLCJpYXQiOjE2Mzc5MzE3NjQuNjc4OTA3LCJuYmYiOjE2Mzc5MzE3NjQuNjc4OTExLCJleHAiOjE2Njk0Njc3NjQuMjU3MzQ5LCJzdWIiOiI0MTEiLCJzY29wZXMiOltdfQ.WV1TK9zYHxOmiD4NmHrgmB-VJoQ7XVfUsex85Aj1rvx2DqayzhKLdIhaz64WjYLcnGSlfmYha6Ig7UsDa_ZQb9Y85cVLRdUhcNjaVo3c2dnmn3ngxkNorsK2GRcnkh7rLmIytvf9sT3Dr873mqoZzFfMnRTV1zufXc3kbAVBOGYZ10VRipUqfL53G8gPq57dSsZGdv4g2I8gbwSBB0JjR0m_UUF99aoEIfFOPWdpOccXlDixBJTC4XMtyKeUESbXuheT2omMNvHdpvWuYkAc7-QfOfy7len4k3pAYxI92bn0Qr0MLG1gWMLmJneZ1xw_6E0Q3j2aAqiZf9FvuzBklUnWJS18LsVep0Lhk1uA6pdKVPq1EcZBCig4IKlN9dkIbCP8w-gny-gbL53klo1NAgipcAAm2Rdxy3E9umbGQk8bRaLLToepHJrY5iwdL81XYx6qxhQGAZlgZbUJcbNlPMuvnjhLUq9t1j--TuTi0wLYZN-arNA4wwmIbbFEy4FxeNrVO1jeRA8cni3BQJz1UIXLqCyMZScFormcBG5_FL1oLC-3aG0mEqM9_ROAh9cZE9jOXSknsyZD4oYWa28jlpoXM5eH9TIErjErUCKREVzG9YwFgC87iqhmQgaj3Q_G4WXq3terSzW73Jwtn_D9_ijaKLa-dzNLP2pJXZKBaNE';
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
            });

        this.$helpers.getAllVisaConsultantTypes(types => {
            this.optionsVSTypes = types;
        })

    },
    methods: {
        /**
         * When the location found
         * @param {Object} addressData Data of the found location
         * @param {Object} placeResultData PlaceResult object
         * @param {String} id Input container ID
         */
        getAddressData: function (addressData, placeResultData, id) {
            this.findForm.location = addressData;
            this.findForm.country = addressData.country;
            this.findForm.state = addressData.administrative_area_level_1;
            this.findForm.city = addressData.locality;
            this.findForm.lat = addressData.latitude;
            this.findForm.long = addressData.longitude;
            // console.log(this.findForm.location);
            },
        addVSType(newTag) {
            const tag = {
                name: newTag,
                id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            };
            this.optionsVSTypes.push(tag);
            this.findForm.visaConsultantOptions.selectTypes.push(tag);
        }, addHostService(newTag) {
            const tag = {
                name: newTag,
                id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            };
            this.optionsServices.push(tag);
            this.findForm.hostOptions.selectServices.push(tag);
        },
        addGuideActivity(newTag) {
            const tag = {
                name: newTag,
                id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            };
            this.optionsActivities.push(tag);
            this.findForm.guideOptions.selectedActivities.push(tag);
        },
        selectForSearch(type) {
            this.findForm.selectedType = type;
        },
        searchNow() {
            var conditionValidate = '';
            //alert(this.findForm.selectedType);
            if (this.findForm.selectedType == 'guide') {
                conditionValidate = this.findForm.selectedType && this.findForm.location && this.findForm.guideOptions.gender && this.findForm.guideOptions.selectedActivities.length > 0;
                if (conditionValidate) {
                    this.$refs.searchForm.action = '/guides';
                    this.$refs.searchForm.submit();
                }
                else {
                    this.$swal({ type: 'error', title: 'Sorry!', text: 'Please, Full Fill All Requirements.', timer: 2500 })
                }
            } else if (this.findForm.selectedType == 'mate') {
                conditionValidate = this.findForm.selectedType && this.findForm.location && this.findForm.mateOptions.gender;
                if (conditionValidate) {
                    this.$refs.searchForm.action = '/mates';
                    this.$refs.searchForm.submit();
                }
                else {
                    this.$swal({ type: 'error', title: 'Sorry!', text: 'Please, Full Fill All Requirements.', timer: 2500 })
                }

            } else if (this.findForm.selectedType == 'host') {
                conditionValidate = this.findForm.selectedType && this.findForm.location && this.findForm.hostOptions.gender && this.findForm.hostOptions.selectServices.length > 0;
                if (conditionValidate) {
                    this.$refs.searchForm.action = '/hosts';
                    this.$refs.searchForm.submit();
                }
                else {
                    this.$swal({ type: 'error', title: 'Sorry!', text: 'Please, Full Fill All Requirements.', timer: 2500 })
                }
            } else if (this.findForm.selectedType == 'photographer' || this.findForm.selectedType == 'movie maker') {
                conditionValidate = this.findForm.selectedType && this.findForm.location && this.findForm.photographerOptions.gender;
                if (conditionValidate) {
                    this.$refs.searchForm.action = '/movieMakers';
                    this.$refs.searchForm.submit();
                }
                else {
                    this.$swal({ type: 'error', title: 'Sorry!', text: 'Please, Full Fill All Requirements.', timer: 2500 })
                }
            } else if (this.findForm.selectedType == 'visa_consultant') {
                conditionValidate = this.findForm.selectedType && this.findForm.location && this.findForm.visaConsultantOptions.selectTypes;
                if (conditionValidate) {
                    this.$refs.searchForm.action = '/visaConsultants';
                    this.$refs.searchForm.submit();
                }
                else {
                    this.$swal({ type: 'error', title: 'Sorry!', text: 'Please, Full Fill All Requirements.', timer: 2500 })
                }
            }else if (this.findForm.selectedType == 'accommodation') {
                conditionValidate = true;
                if (conditionValidate) {
                    this.$refs.searchForm.action = '/accommodations';
                    this.$refs.searchForm.submit();
                }
                else {
                    this.$swal({ type: 'error', title: 'Sorry!', text: 'Please, Full Fill All Requirements.', timer: 2500 })
                }
            }
            else if (this.findForm.selectedType == 'transport')
            {
                this.$refs.searchForm.action = '/vechiles';
                this.$refs.searchForm.submit();
            }
            else if (this.findForm.selectedType == 'trip_operator')
            {
                this.$refs.searchForm.action = '/TripOperators';
                this.$refs.searchForm.submit();
            }
            else if (this.findForm.selectedType == 'activities')
            {
                this.$refs.searchForm.action = '/experiences';
                this.$refs.searchForm.submit();
            }
            else if (this.findForm.selectedType == 'trips')
            {
                this.$refs.searchForm.action = '/trips';
                this.$refs.searchForm.submit();
            }
            else if (this.findForm.selectedType == 'events')
            {
                this.$refs.searchForm.action = '/events';
                this.$refs.searchForm.submit();
            }
            else if (this.findForm.selectedType == 'restaurants')
            {
                this.$refs.searchForm.action = '/restaurants';
                this.$refs.searchForm.submit();
            }
            // alert(this.findForm.location);
            // if (conditionValidate) {
            //     if (this.findForm.selectedType == 'accommodation') {
            //         this.$refs.searchForm.action = '/accommodations?address='+this.findForm.location;
            //         this.$refs.searchForm.submit();
            //     }else if (this.findForm.selectedType == 'guide'){
            //         this.$refs.searchForm.action = '/guide';
            //
            //         this.$refs.searchForm.submit();
            //     }
            //     this.$refs.searchForm.action = this.findForm.selectedType;
            //     this.$refs.searchForm.submit();
            //
            // } else {
            //     this.$swal({ type: 'error', title: 'Sorry!', text: 'Please, Full Fill All Requirements.', timer: 2500 })
            // }

        }
    }
}
</script>

<style scoped>
.multiselect {
    box-sizing: inherit;
}

</style>

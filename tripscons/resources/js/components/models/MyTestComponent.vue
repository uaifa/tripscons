<template>

    <div class="modal fade" id="my-test" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:1000px">
            <div class="modal-content search-popup">
                <div class="modal-header">
                    <div class="Close-btn">
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    my test model body
                </div>
            </div>
        </div>
        <form action="/search" method="post" ref="searchForm" style="display: none;">
            <input type="hidden" name="_token" :value="csrf">
            <input type="hidden" name="findForm" :value="JSON.stringify(findForm)">
        </form>
    </div>
</template>

<script>
    import VueGoogleAutocomplete from 'vue-google-autocomplete'

    export default {
        name: "MyTestComponent",
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
                    location: '',
                    country: '',
                    state: '',
                    city: '',
                    lat: 31.5203696,
                    long: 74.35874729999999
                }
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
                if (this.findForm.selectedType == 'guide') {
                    conditionValidate = this.findForm.selectedType && this.findForm.location && this.findForm.guideOptions.gender && this.findForm.guideOptions.selectedActivities.length > 0;
                } else if (this.findForm.selectedType == 'mate') {
                    conditionValidate = this.findForm.selectedType && this.findForm.location && this.findForm.mateOptions.gender;
                } else if (this.findForm.selectedType == 'host') {
                    conditionValidate = this.findForm.selectedType && this.findForm.location && this.findForm.hostOptions.gender && this.findForm.hostOptions.selectServices.length > 0;
                } else if (this.findForm.selectedType == 'photographer' || this.findForm.selectedType == 'movie maker') {
                    conditionValidate = this.findForm.selectedType && this.findForm.location && this.findForm.photographerOptions.gender;
                } else if (this.findForm.selectedType == 'visa_consultant') {
                    conditionValidate = this.findForm.selectedType && this.findForm.location && this.findForm.visaConsultantOptions.selectTypes;
                }

                if (conditionValidate) {
                    this.$refs.searchForm.submit();
                } else {
                    this.$swal({
                        type: 'error',
                        title: 'Sorry!',
                        text: 'Please, Full Fill All Requirements.',
                        timer: 2500
                    })
                }

            }
        }
    }
</script>

<style scoped>
    .multiselect {
        box-sizing: inherit;
    }

</style>

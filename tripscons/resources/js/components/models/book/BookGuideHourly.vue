<template>
    <div class="modal fade"
         id="book-guide-hourly"
         tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:1000px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Book Guide</h5>
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

                    <div v-show="showCard==false">

                        <div class="row">
                            <div class="col-sm-12 col-md-12 " style="margin-top: 10px;">
                                <label>Select Dates</label>
                                <div class="input-field text-center">
                                    <v-date-picker
                                        id="selectedDates"
                                        ref="selectedDates"
                                        mode='single'
                                        v-model='form.selectedDate'
                                        color="green"
                                        :columns="$screens({ default: 1, lg: 3 })"
                                        :disabled-dates="disabledDates"
                                        is-inline
                                        is-expanded
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" v-show="guideProfile && form.selectedDate">
                        <div class="col-sm-12 col-md-12 text-center mt-10">
                            <div class="alert alert-info">You can hire guide between this time
                                {{guideProfile.start_hourly_time}} - {{guideProfile.end_hourly_time}}
                            </div>
                        </div>
                    </div>

                    <div class="row" v-show="guideProfile && form.selectedDate">
                        <div class="col-sm-6 col-md-6 ">
                            <label>Start Time</label>
                            <div class="form-group">
                                <select class="custom-select" name="start_time"
                                        v-model="form.start_time">
                                    <option
                                        v-for="(hour,i) in hoursList"
                                        :key="i"
                                        :value="hour">{{hour}}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 ">
                            <label>End Time</label>
                            <div class="form-group">
                                <select class="custom-select" name="end_time"
                                        v-model="form.end_time">
                                    <option
                                        v-for="(hour,i) in hoursList"
                                        :key="i"
                                        :value="hour">{{hour}}
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <!--                        Description-->
                    <div class="row" style="margin-top:20px;">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="description" class="bmd-label-floating">Description</label>
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

                    <!--                        total amount-->
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mt-20">
                            <div class="form-group" style="float: right;font-size: 25px;    margin-right: 0px;">
                                <!--                                <hr/>-->
                                <!--                                <small style="color: red;font-size: 15px;margin-bottom: 5px;display: block;"-->
                                <!--                                       v-show="form.totalAmount">-->
                                <!--                                    10% Advance: <b>${{form.totalAmount*10/100}}</b></small>-->
                                <b>Total:</b>
                                $ {{ form.totalAmount }}
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row" v-show="showCard">
                    <VCreditCard @change="creditInfoChanged"/>
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
        name: "BookGuideHourly",
        props: ["profile_user"],
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
                showCard: false,
                profileUser: this.profile_user,
                guideProfile: '',
                hoursList: [],
                form: {
                    type: 'hourly',
                    providerId: this.profile_user.id,
                    description: '',
                    totalHours: 0,
                    totalAmount: 0,
                    selectedDate: "",
                    start_time: '',
                    end_time: '',
                    card: {
                        name: '',
                        cardNumber: '',
                        expiration: '',
                        security: ''
                    }
                },
                disabledDates: [],
            }
        },
        created() {
            this.$helpers.getUserData(this.profileUser.id, data => {
                this.guideProfile = data.guide_profile;
                this.hoursList = this.$helpers.getHoursBetweenTwoTimes(this.guideProfile.start_hourly_time, this.guideProfile.end_hourly_time);
            });

            this.disabledDates.push({
                start: null,
                end: new Date()
            });
            this.$helpers.getGuideBookingDisabledDates(this.form.providerId, dates => {
                if (dates) {
                    dates.forEach((date, i) => {
                        if (date) {
                            this.disabledDates.push({
                                start: new Date(date.start),
                                end: new Date(date.end)
                            })
                        }
                    });
                }
            });

        },
        methods: {
            creditInfoChanged(values) {
                for (const key in values) {
                    this.form.card[key] = values[key];
                }
            },
            calculatePrice() {
                this.form.totalAmount = 0;
                if (this.form.selectedDate && this.form.totalHours > 0) {
                    this.form.totalAmount = this.form.totalHours * this.guideProfile.hourly_rate;
                }
                return this.form.totalAmount;
            },
            send() {
                this.errors = {};
                this.$helpers.getAuthCheck(authCheck => {
                    if (authCheck) {
                        if (this.form.totalAmount > 0) {
                            axios.post("/sendNotificationForBookGuide", this.form)
                                .then(res => {
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
                                });
                        } else {
                            this.$swal({
                                type: "danger",
                                title: "Sorry!",
                                text: "Please, Full Fill all requirement.",
                                timer: 2500
                            });
                        }
                    } else {
                        this.$swal({
                            type: "danger",
                            title: "Sorry!",
                            text: "Please, Login or signup before form.Host.",
                            timer: 2500
                        });
                    }
                });
            },
            reset() {
                this.form.selectedPackage = '';
                this.form.description = '';
                this.form.totalAmount = 0;
                this.form.selectedDates = {};
                this.form.totalDays = 0;
                this.form.card.name = '';
                this.form.card.cardNumber = '';
                this.form.card.expiration = '';
                this.form.card.security = '';
                this.showCard = false;
            },
        },
        watch: {
            "form.selectedDate": function () {
                this.form.selectedDate = moment(this.form.selectedDate).format("YYYY-MM-DD");
                this.calculatePrice();
            },
            "form.start_time": function () {
                if (this.form.start_time && this.form.end_time) {
                    this.form.totalHours = this.$helpers.getHoursCountByTimes(this.form.start_time, this.form.end_time);
                    this.calculatePrice();
                }
            },
            "form.end_time": function () {
                if (this.form.start_time && this.form.end_time) {
                    this.form.totalHours = this.$helpers.getHoursCountByTimes(this.form.start_time, this.form.end_time);
                    this.calculatePrice();
                }
            },
        }
    }
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


</style>


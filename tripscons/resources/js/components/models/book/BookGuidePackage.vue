<template>
    <div class="modal fade"
         id="book-guide-package"
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

                        <!--              Guide Packages-->
                        <div v-show="allPackages.length>0">

                            <div class="row">
                                <div class="col-sm-8 col-md-8">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Select Package</label>
                                        <select class="custom-select"
                                                name="package_id"
                                                v-model="form.selectedPackage"
                                                @change="calculatePrice">
                                            <option v-for="(pack,index) in allPackages" :key="index"
                                                    :value="pack">
                                                {{pack.title}}

                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Price in $</label>
                                        <input type="text"
                                               class="form-control"
                                               v-model="form.totalAmount"
                                               readonly/>
                                    </div>
                                </div>
                            </div>

                            <!--                            Days Wise-->
                            <div v-show="form.selectedPackage && form.selectedPackage.agenda_type=='daywise'">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 " style="margin-top: 10px;">
                                        <label>Select Dates</label>
                                        <div class="input-field text-center">
                                            <v-date-picker
                                                id="selectedDates"
                                                ref="selectedDates"
                                                mode='range'
                                                v-model='selectedDates'
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

<!--                            counters and invoice-->
                            <div class="row" style="margin-top: 20px;" v-show="form.selectedPackage">

                                <!--                    counter adults,children,infants-->
                                <div class="col-md-6 col-sm-6">
                                    <div class="card-invo">
                                        <h4>Guests</h4>
                                        <div class="card-body">
                                            <div class="invoice-inner">
                                                <div class="invoice-details">
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--                    invoice-->
                                <div class="col-md-6 col-sm-6" v-if="form.totalAmount">
                                    <div class="card-invo">
                                        <h4>Your Invoice</h4>
                                        <div class="card-body">
                                            <div class="invoice-inner">
                                                <div class="invoice-details">
                                                    <ul>
                                                        <li style="border: none;">
                                                            <span class="text-detail">${{(form.adults + form.childrens) }} x {{form.totalDays}} x {{form.selectedPackage.price}} per person</span>
                                                            <span class="aomunt-detail">${{form.totalAmount}}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group" style="float: right;font-size: 25px;    margin-right: 0px;">
                                    <hr/>
                                    <small style="color: red;font-size: 15px;margin-bottom: 5px;display: block;"
                                           v-show="form.totalAmount">
                                        10% Advance: <b>${{form.totalAmount*10/100}}</b></small>
                                    <b>Total:</b>
                                    $ {{ form.totalAmount }}
                                </div>
                            </div>
                        </div>

                    </div>

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
        name: "BookGuidePackage",
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
                allPackages: '',
                profileUser: this.profile_user,
                selectedDates: {},
                form: {
                    type: 'package',
                    providerId: this.profile_user.id,
                    selectedPackage: '',
                    description: '',
                    totalAmount: 0,
                    selectedDates: {},
                    totalDays: 0,
                    adults: 1,
                    childrens: 0,
                    infants: 0,
                    adultsChildrensDisable: false,
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
                this.userData = data;
                this.allPackages = data.guide_packages;
            });

        },
        methods: {
            increment(type) {
                if (type == 'adult') {
                    if (this.maxPeople()) {
                        this.form.adults++;
                        this.getAvailableDates();
                    }
                } else if (type == 'children') {
                    if (this.maxPeople()) {
                        this.form.childrens++;
                        this.getAvailableDates();
                    }
                } else if (type == 'infant') {
                    this.form.infants++;
                }
                this.calculatePrice();
            },
            decrement(type) {
                if (type == 'adult') {
                    if (this.form.adults > 1) {
                        this.form.adults--;
                        this.maxPeople();
                        this.getAvailableDates();
                    }
                } else if (type == 'children') {
                    if (this.form.childrens > 0) {
                        this.form.childrens--;
                        this.maxPeople();
                        this.getAvailableDates();
                    }
                } else if (type == 'infant') {
                    if (this.form.infants > 0) {
                        this.form.infants--;
                    }
                }
                this.calculatePrice();
            },
            maxPeople() {
                var res = false;
                if ((this.form.adults + this.form.childrens) < this.form.selectedPackage.no_of_people) {
                    res = true;
                    this.form.adultsChildrensDisable = false;
                } else {
                    res = false;
                    this.form.adultsChildrensDisable = true;
                }
                return res;
            },
            getAvailableDates() {
                this.$helpers.isLoading(true);
                this.$helpers.getAvailableDatesByAvailabilityIdAndGroupSize(
                    this.form.selectedPackage.id,
                    (parseInt(this.form.adults) + parseInt(this.form.childrens))
                    , dates => {
                        this.availableDates = [];
                        if (dates) {
                            this.form.selectedDates = {};
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
            creditInfoChanged(values) {
                for (const key in values) {
                    this.form.card[key] = values[key];
                }
            },
            calculatePrice() {
                this.form.totalAmount = this.form.totalDays = 0;
                if (this.form.selectedPackage) {
                    if (this.form.selectedPackage.agenda_type == 'daywise') {
                        if (this.form.selectedDates.start && this.form.selectedDates.end) {
                            var date1 = new Date(this.form.selectedDates.start);
                            var date2 = new Date(this.form.selectedDates.end);
                            var DifferenceInTime = date2.getTime() - date1.getTime();
                            this.form.totalDays = DifferenceInTime / (1000 * 3600 * 24) + 1;
                            if (this.form.selectedPackage.agendas.length == this.form.totalDays) {
                                this.form.totalAmount = parseInt(this.form.totalDays) * parseInt(this.form.selectedPackage.price);
                            } else {
                                this.form.selectedDates = {};
                                var msg = 'Please, Select ' + this.form.selectedPackage.agendas.length + ' Days';
                                this.form.totalDays = 0;
                                this.$swal(msg);
                            }
                        }
                    }else if (this.form.selectedPackage.agenda_type == 'datewise'){

                    }
                }
                return this.form.totalAmount;
            },
            send() {
                this.errors = {};
                this.$helpers.getAuthCheck(authCheck => {
                    if (authCheck) {
                        if (this.showCard) {
                            axios.post("/sendNotificationForBookGuide", this.form)
                                .then(res => {
                                    this.$refs.btnClose.click();
                                    // this.$swal({
                                    //     type: "success",
                                    //     title: "Congrats!",
                                    //     text: res.data.message,
                                    //     timer: 2500
                                    // });
                                    // this.reset();
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
                            this.showCard = true;
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
            "form.selectedPackage": function () {
                if(this.form.selectedPackage.agenda_type=='daywise'){
                    this.$helpers.isLoading(true);
                    this.disabledDates=[];
                    this.disabledDates.push({
                        start: null,
                        end: new Date()
                    });

                    this.$helpers.getGuidePackageDisabledDatesById(this.form.selectedPackage.id, dates => {
                        this.$helpers.isLoading(false);

                        // if (dates) {
                        //     dates.forEach((date, i) => {
                        //         if (date) {
                        //             this.disabledDates.push({
                        //                 start: new Date(date.start),
                        //                 end: new Date(date.end)
                        //             })
                        //         }
                        //     })
                        // }
                    });
                }
                this.calculatePrice();

            },
            "selectedDates": function () {
                this.form.selectedDates.start = moment(this.selectedDates.start).format("YYYY-MM-DD");
                this.form.selectedDates.end = moment(this.selectedDates.end).format("YYYY-MM-DD");
                this.calculatePrice();
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


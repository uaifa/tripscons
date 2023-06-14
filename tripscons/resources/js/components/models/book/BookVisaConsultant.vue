<template>
    <div class="modal fade"
         id="book-visa-consultant"
         tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:1000px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Book Visa Consultant</h5>
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


                        <div class="row" style="margin-top:20px;">
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

                        <!--                        <div class="row">-->
                        <!--                            <div class="col-sm-12 col-md-12">-->
                        <!--                                <div class="form-group" style="float: right;font-size: 25px;    margin-right: 0px;">-->
                        <!--                                    <hr/>-->
                        <!--                                    <small style="color: red;font-size: 15px;margin-bottom: 5px;display: block;"-->
                        <!--                                           v-show="form.totalAmount">-->
                        <!--                                        10% Advance: <b>${{form.totalAmount*10/100}}</b></small>-->
                        <!--                                    <b>Total:</b>-->
                        <!--                                    $ {{ form.totalAmount }}-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
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
        name: "BookVisaConsultant",
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
                form: {
                    providerId: this.profile_user.id,
                    description: '',
                    card: {
                        name: '',
                        cardNumber: '',
                        expiration: '',
                        security: ''
                    }
                }
            };
        },
        methods: {

            creditInfoChanged(values) {
                for (const key in values) {
                    this.form.card[key] = values[key];
                }
            },
            reset() {
                this.form.description = '';
                this.showCard = false;
            },
            calculatePrice() {
                // this.form.totalAmount = 0;
                // if (this.form.dayOrHourly == "day" || this.form.dayOrHourly == "hourly") {
                //     if (this.form.hourlyBookings.length && this.form.dayOrHourly == "hourly") {
                //         var hourlyPrice = this.profileUser.hourly_rate;
                //         var totalHours = 0;
                //         if (this.form.hourlyBookings.length) {
                //             this.form.hourlyBookings.forEach(booking => {
                //                 totalHours += parseInt(booking.hours);
                //             });
                //             return this.form.totalAmount = parseInt(hourlyPrice) * parseInt(totalHours);
                //         }
                //     } else if (this.form.date_from && this.form.date_to && this.form.dayOrHourly == 'day') {
                //         var date1 = new Date(this.form.date_from);
                //         var date2 = new Date(this.form.date_to);
                //         // To calculate the time difference of two dates
                //         var DifferenceInTime = date2.getTime() - date1.getTime();
                //         // To calculate the no. of days between two dates
                //         this.form.totalDays = DifferenceInTime / (1000 * 3600 * 24) + 1;
                //         return this.form.totalAmount = parseInt(this.form.totalDays) * parseInt(this.profileUser.per_day_rate);
                //     }
                // }
                // return this.form.totalAmount = 0;
            },
            send() {
                this.errors = {};
                this.$helpers.getAuthCheck(authCheck => {
                    if (authCheck) {
                        if (this.showCard) {
                            axios.post("/sendNotificationForBookVisaConsultant", this.form)
                                .then(res => {
                                    // this.$refs.btnClose.click();
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
                            text: "Please, Login or signup before book Host.",
                            timer: 2500
                        });
                    }
                });
            }
        },
        watch: {}
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


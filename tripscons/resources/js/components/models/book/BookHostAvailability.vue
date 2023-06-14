<template>
    <div class="modal fade"
         id="book-host-activity"
         tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:1090px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Availability</h5>
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

                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <label><b>{{book.availability.title}}</b></label>
                                <br>
                                <small>{{book.availability.location}}</small>
                                <iframe
                                    :src="'https://maps.google.com/maps?q='+book.availability.latitude+','+book.availability.longitude+'&hl=es&z=14&amp;output=embed'"
                                    width="100%" height="200" frameborder="0" style="border:0;"
                                    allowfullscreen=""></iframe>
                            </div>
                        </div>



                        <div class="row" :class="availableDates.length>0 ? '' :'div-disable'">
                            <div class="col-md-12 col-sm-12">
                                <label><b>Select dates for availability</b></label>
                                <div class="input-field ">
                                    <v-date-picker
                                        id="selectedDates"
                                        ref="selectedDates"
                                        mode='range'
                                        v-model='book.selectedDates'
                                        color="green"
                                        :columns="$screens({ default: 1, lg: 4 })"
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
                                                    <button class="btn lable-d" @click="decrement('adult')">-</button>
                                                    <label class="lable-i-d-counter">{{book.adults}}</label>
                                                    <button class="btn lable-i" @click="increment('adult')"
                                                            :disabled="book.adultsChildrensDisable">+
                                                    </button>
                                                </div>
                                                <div class="col-md-12 col-sm-12" style="margin:5px;">
                                                    <label class="lable-i-d-title">Children <small>Ages
                                                        2–12</small></label>
                                                    <button class="btn lable-d" @click="decrement('children')">-
                                                    </button>
                                                    <label class="lable-i-d-counter">{{book.childrens}}</label>
                                                    <button class="btn lable-i" @click="increment('children')"
                                                            :disabled="book.adultsChildrensDisable">+
                                                    </button>
                                                </div>
                                                <div class="col-md-12 col-sm-12" style="margin:5px;">
                                                    <label class="lable-i-d-title">Infants <small>Under
                                                        2</small></label>
                                                    <button class="btn lable-d" @click="decrement('infant')">-</button>
                                                    <label class="lable-i-d-counter">{{book.infants}}</label>
                                                    <button class="btn lable-i" @click="increment('infant')">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--                    invoice-->
                            <div class="col-md-6 col-sm-6" v-if="book.totalAmount">
                                <div class="card-invo">
                                    <h4>Your Invoice</h4>
                                    <div class="card-body">
                                        <div class="invoice-inner">
                                            <div class="invoice-details">
                                                <ul>
                                                    <li style="border: none;">
                                                        <span class="text-detail">${{(book.adults + book.childrens) }} x {{book.days}} x {{book.availability.per_person_price}} per person</span>
                                                        <span class="aomunt-detail">${{book.totalAmount}}</span>
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

                <div class="modal-footer" style="margin-top: 30px;">
                    <button type="button" class="btn btn-secondary" ref="btnClose" data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-success" @click="reserve">Next</button>
                </div>
                <form action="/availabilityTerms" method="post" ref="formReserve" style="display: none;">
                    <input type="hidden" name="_token" :value="csrf">
                    <input type="hidden" name="data" :value="JSON.stringify(book)">
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BookHostAvailability",
        props: ['allData', 'userCheck', 'loginUser'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors: {},
                mealTypes: [],
                meals: [],
                book: {
                    availability: this.allData.availability,
                    selectedDates: {},
                    adults: 1,
                    childrens: 0,
                    infants: 0,
                    adultsChildrensDisable: false,
                    days: 0,
                    totalAmount: 0,
                },
                availableDates: [],
            }
        },
        created() {
            if (this.book.availability.id) {
                this.$helpers.getAvailableDatesByAvailabilityId(this.book.availability.id, dates => {
                    this.availableDates = [];
                    if (dates) {
                        dates.forEach((date, i) => {
                            if (date) {
                                this.availableDates.push({
                                    start: new Date(date.start),
                                    end: new Date(date.end)
                                })
                            }
                        })
                    }
                });
            }
        },
        methods: {
            increment(type) {
                if (type == 'adult') {
                    if (this.maxPeople()) {
                        this.book.adults++;
                        this.getAvailableDates();
                    }
                } else if (type == 'children') {
                    if (this.maxPeople()) {
                        this.book.childrens++;
                        this.getAvailableDates();
                    }
                } else if (type == 'infant') {
                    this.book.infants++;
                }
                this.calculatePrice();
            },
            decrement(type) {
                if (type == 'adult') {
                    if (this.book.adults > 1) {
                        this.book.adults--;
                        this.maxPeople();
                        this.getAvailableDates();
                    }
                } else if (type == 'children') {
                    if (this.book.childrens > 0) {
                        this.book.childrens--;
                        this.maxPeople();
                        this.getAvailableDates();
                    }
                } else if (type == 'infant') {
                    if (this.book.infants > 0) {
                        this.book.infants--;
                    }
                }
                this.calculatePrice();
            },
            maxPeople() {
                var res = false;
                if ((this.book.adults + this.book.childrens) < this.book.availability.no_of_people) {
                    res = true;
                    this.book.adultsChildrensDisable = false;
                } else {
                    res = false;
                    this.book.adultsChildrensDisable = true;
                }
                return res;
            },
            getAvailableDates() {
                this.$helpers.isLoading(true);
                this.$helpers.getAvailableDatesByAvailabilityIdAndGroupSize(
                    this.book.availability.id,
                    (parseInt(this.book.adults) + parseInt(this.book.childrens))
                    , dates => {
                        this.availableDates = [];
                        if (dates) {
                            this.book.selectedDates = {};
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
            calculatePrice() {
                this.book.totalAmount = this.book.days = 0;
                // Availability Pricing
                if (this.book.availability && this.book.selectedDates.start && this.book.selectedDates.end) {
                    var date1 = new Date(this.book.selectedDates.start);
                    var date2 = new Date(this.book.selectedDates.end);
                    // To calculate the time difference of two dates
                    var differenceInTime = date2.getTime() - date1.getTime();
                    // To calculate the no. of days between two dates
                    this.book.days = differenceInTime / (1000 * 3600 * 24) + 1;
                    this.book.totalAmount = (parseInt(this.book.adults + this.book.childrens) * parseInt(this.book.days)) * parseInt(this.book.availability.per_person_price);

                }
                return this.book.totalAmount;
            },
            reserve() {
                if (this.book.selectedDates.start && this.book.selectedDates.end) {
                    this.$helpers.isLoading(true);
                    this.book.selectedDates.start = moment(this.book.selectedDates.start).format("YYYY-MM-DD");
                    this.book.selectedDates.end = moment(this.book.selectedDates.end).format("YYYY-MM-DD");
                    setTimeout(() => {
                        this.$refs.formReserve.submit()
                    }, 1000);
                } else {
                    this.$swal('Please, Select dates for booking.')
                }
            }
        },
        watch: {
            "book.selectedDates": function () {
                this.calculatePrice();
            }
        }
    }
</script>

<style scoped>

</style>

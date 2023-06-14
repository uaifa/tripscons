<template>
    <div class="modal fade"
         id="book-host-accommodation"
         tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:1060px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reserve Accommodation</h5>
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
                        <div class="col-md-12 col-sm-12" id="reserve_area">
                            <div class="input-field ">
                                <v-date-picker
                                    id="accommodationDates"
                                    ref="accommodationDates"
                                    mode='range'
                                    v-model='book.accommodationDates'
                                    :min-date='new Date()'
                                    color="green"
                                    :columns="$screens({ default: 1, lg: 4 })"
                                    is-inline
                                    is-expanded
                                />
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top:15px;">

                        <!--                    counter adults,children,infants-->
                        <div class="col-md-6 col-sm-6">
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

                        <div class="col-md-6 col-sm-6">
                            <!--                    invoice-->
                            <div class="invoice-details" v-if="book.totalAmount">
                                <ul>
                                    <li>
                                    <span
                                        class="text-detail">${{book.perNight}} x {{book.accommodationDays}} nights</span>
                                        <span class="aomunt-detail">${{book.perNight * book.accommodationDays }}</span>
                                    </li>
                                    <li v-if="book.selectedAccommodation.clean_fee">
                                        <span class="text-detail">Cleaning fee</span>
                                        <span class="aomunt-detail">${{book.selectedAccommodation.clean_fee }}</span>
                                    </li>

                                    <li v-if="book.selectedAccommodation.service_fee">
                                        <span class="text-detail">Service fee</span>
                                        <span class="aomunt-detail">${{book.selectedAccommodation.service_fee }}</span>
                                    </li>

                                    <li v-show="book.weeklyDiscountPercent">
                                        <span class="text-detail">Discount</span>
                                        <span class="aomunt-detail">%{{book.weeklyDiscountPercent }}</span>
                                    </li>
                                    <li>
                                        <span class="text-detail">Total</span>
                                        <span class="aomunt-detail">${{book.totalAmount }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ref="btnClose" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" @click="reserve">Next</button>
                </div>
                <form action="/accommodationTerms" method="post" ref="formReserve" style="display: none;">
                    <input type="hidden" name="_token" :value="csrf">
                    <input type="hidden" name="data" :value="JSON.stringify(book)">
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BookHostAccommodation",
        props: ['allData', 'userCheck', 'loginUser'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors: {},
                book: {
                    user: this.loginUser ? this.loginUser : '',
                    selectedAccommodation: this.allData,
                    accommodationDates: {},
                    adults: 1,
                    childrens: 0,
                    infants: 0,
                    adultsChildrensDisable: false,
                    accommodationDays: 0,
                    accommodationPrice: 0,
                    totalAmount: 0,
                    weeklyDiscount: 0,
                    weeklyDiscountPercent: 0,
                    perNight: 0,
                }
            }
        },
        methods: {
            increment(type) {
                if (type == 'adult') {
                    if (this.maxPeople()) {
                        this.book.adults++;
                    }
                    this.calculatePrice();
                } else if (type == 'children') {
                    if (this.maxPeople()) {
                        this.book.childrens++;
                    }
                    this.calculatePrice();
                } else if (type == 'infant') {
                    this.book.infants++;
                }
            },
            decrement(type) {
                if (type == 'adult') {
                    if (this.book.adults > 1) {
                        this.book.adults--;
                        this.maxPeople();
                    }
                    this.calculatePrice();
                } else if (type == 'children') {
                    if (this.book.childrens > 0) {
                        this.book.childrens--;
                        this.maxPeople();
                    }
                    this.calculatePrice();
                } else if (type == 'infant') {
                    if (this.book.infants > 0) {
                        this.book.infants--;
                    }
                }
            },
            maxPeople() {
                var res = false;
                if ((this.book.adults + this.book.childrens) < this.book.selectedAccommodation.no_of_people) {
                    res = true;
                    this.book.adultsChildrensDisable = false;
                } else {
                    res = false;
                    this.book.adultsChildrensDisable = true;
                }
                return res;
            },
            calculatePrice() {
                this.book.totalAmount = this.book.accommodationDays = this.book.accommodationPrice = 0;

                // Accommodation Pricing
                if (this.book.selectedAccommodation && this.book.accommodationDates.start && this.book.accommodationDates.end) {
                    this.book.accommodationFrom = moment(this.book.accommodationDates.start).format("YYYY-MM-DD");
                    this.book.accommodationTo = moment(this.book.accommodationDates.end).format("YYYY-MM-DD");
                    var date1 = new Date(this.book.accommodationFrom);
                    var date2 = new Date(this.book.accommodationTo);
                    // To calculate the time difference of two dates
                    var DifferenceInTime = date2.getTime() - date1.getTime();

                    var clean_fee = this.book.selectedAccommodation.clean_fee ? this.book.selectedAccommodation.clean_fee : 0;
                    var service_fee = this.book.selectedAccommodation.service_fee ? this.book.selectedAccommodation.service_fee : 0;
                    var taxes_fees = this.book.selectedAccommodation.taxes_fees ? this.book.selectedAccommodation.taxes_fees : 0;
                    this.book.perNight = parseInt(this.book.selectedAccommodation.per_night);
                    var adultsCounter = parseInt(this.book.adults) + parseInt(this.book.childrens);

                    if (adultsCounter > this.book.selectedAccommodation.limit_people) {
                        var extraAdults = adultsCounter - parseInt(this.book.selectedAccommodation.limit_people);
                        this.book.perNight = parseInt(this.book.perNight) + (extraAdults * parseInt(this.book.selectedAccommodation.extra_price));
                    }
                    // To calculate the no. of days between two dates
                    this.book.accommodationDays = DifferenceInTime / (1000 * 3600 * 24) + 1;
                    this.book.accommodationPrice = (parseInt(this.book.accommodationDays) * parseInt(this.book.perNight)) + (clean_fee + service_fee);

                    this.book.weeklyDiscount = 0;
                    this.book.weeklyDiscountPercent = 0;
                    // Weekly Discount
                    if (parseInt(this.book.accommodationDays) >= 28 && parseInt(this.book.selectedAccommodation.discount_week_4) > 0) {
                        this.book.weeklyDiscountPercent = parseInt(this.book.selectedAccommodation.discount_week_4);
                        this.book.weeklyDiscount = (this.book.accommodationPrice / 100) * this.book.weeklyDiscountPercent;
                    } else if (parseInt(this.book.accommodationDays) >= 21 && parseInt(this.book.selectedAccommodation.discount_week_3) > 0) {
                        this.book.weeklyDiscountPercent = parseInt(this.book.selectedAccommodation.discount_week_3);
                        this.book.weeklyDiscount = (this.book.accommodationPrice / 100) * this.book.weeklyDiscountPercent;
                    } else if (parseInt(this.book.accommodationDays) >= 14 && parseInt(this.book.selectedAccommodation.discount_week_2) > 0) {
                        this.book.weeklyDiscountPercent = parseInt(this.book.selectedAccommodation.discount_week_2);
                        this.book.weeklyDiscount = (this.book.accommodationPrice / 100) * this.book.weeklyDiscountPercent;
                    } else if (parseInt(this.book.accommodationDays) >= 7 && parseInt(this.book.selectedAccommodation.discount_week_1) > 0) {
                        this.book.weeklyDiscountPercent = parseInt(this.book.selectedAccommodation.discount_week_1);
                        this.book.weeklyDiscount = (this.book.accommodationPrice / 100) * this.book.weeklyDiscountPercent;
                    }
                    this.book.accommodationPrice = this.book.accommodationPrice - this.book.weeklyDiscount;
                }
                let accommodationTotalPrice = Number.isNaN(parseInt(this.book.accommodationPrice)) ? 0 : parseInt(this.book.accommodationPrice);
                return this.book.totalAmount = accommodationTotalPrice;
            },
            reserve() {
                // if (this.book.user){
                if (this.book.accommodationDates.start && this.book.accommodationDates.end) {
                    if (this.book.adults > 0) {
                        this.$refs.formReserve.submit();
                    } else {
                        this.$swal('Please, Select atleast one adult.');
                    }
                } else {
                    this.$swal('Please, Select Dates')
                }
                // }else {
                //     $('#reserve_area').addClass('div-disable');
                // }
            }
        },
        watch: {
            "book.accommodationDates": function () {
                this.calculatePrice();
            }
        }
    }
</script>

<style scoped>

</style>

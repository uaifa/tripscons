<template>
    <div class="modal fade"
         id="book-host-meal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:1000px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buy Meal</h5>
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


                    <!--                                meal type-->
                    <div class="row" v-show="mealTypes.length>0" style="margin-top: 20px;">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="meal-type" class="bmd-label-floating">Select Meal Type:</label>
                                <select class="custom-select"
                                        id="meal-type"
                                        name="meal-type"
                                        v-model="book.selectedMealType"
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
                                        v-model="book.selectedMeal"
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
                        <!--                                                v-model="book.mealFrom"-->
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
                        <!--                                                v-model="book.mealTo"-->
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
                                       v-model="book.mealPrice"
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
                         v-if="book.mealBookings">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group phone-input">
                                <ul class="list-group">
                                    <li class="list-group-item"
                                        style="border: 1px #cfcbcb solid; margin: 5px 20px 0 20px;background-color: rgba(234, 234, 234, 0.22);"
                                        v-for="(booking,index) in book.mealBookings"
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

                <div class="modal-footer" style="margin-top: 30px;">
                    <button type="button" class="btn btn-secondary" ref="btnClose" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" @click="reserve">Next</button>
                </div>
                <form action="/mealTerms" method="post" ref="formReserve" style="display: none;">
                    <input type="hidden" name="_token" :value="csrf">
                    <input type="hidden" name="data" :value="JSON.stringify(book)">
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BookHostMeal",
        props: ['allData', 'userCheck', 'loginUser'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors: {},
                mealTypes: [],
                meals: [],
                book: {
                    selectedMeal: this.allData.meal,
                    selectedMealType: [],
                    mealFrom: "",
                    mealTo: "",
                    mealDays: 0,
                    mealPrice: 0,
                    totalAmount: 0,
                    mealBookings: [],
                },
                mealDates: {},
            }
        },
        created() {
            this.$helpers.getUserData(this.allData.profile_user.id, data => {
                this.allMeals = data.host_meals;
            });
            this.$helpers.getAllMeals(mealTypes => {
                this.mealTypes = mealTypes;
            });
        },
        methods: {
            mealTypechange() {
                var res = [];
                this.allMeals.forEach(userMeal => {
                    if (this.book.selectedMealType.id == userMeal.meal_id) {
                        res.push(userMeal);
                    }
                });
                this.meals = res;
                this.book.selectedMeal = "";
                this.book.mealFrom = "";
                this.book.mealTo = "";
                this.book.mealDays = 0;
                this.book.mealPrice = 0;
            },
            addMealBooking() {
                if (
                    this.book.selectedMeal &&
                    this.mealDates
                ) {
                    this.book.mealBookings.push({
                        meal: this.book.selectedMeal,
                        date_from: moment(this.mealDates.start).format("YYYY-MM-DD"),
                        date_to: moment(this.mealDates.end).format("YYYY-MM-DD"),
                    });
                    this.calculatePrice();
                } else {
                    this.$swal("Please, Select full fill all requirement.");
                }
            },
            removeMealBooking(book, index) {
                var allbookings = [];
                if (this.book.mealBookings.length > 0) {
                    this.book.mealBookings.forEach((currentBook, i) => {
                        if (
                            i != index
                        ) {
                            allbookings.push(currentBook);
                        }
                    });
                }
                this.book.mealBookings = [];
                this.book.mealBookings = allbookings;
                this.calculatePrice();
            },
            calculatePrice() {
                this.book.totalAmount = this.book.mealDays = this.book.mealPrice = 0;

                // Meal Pricing
                if (this.book.mealBookings.length) {
                    var totalDays = 0;
                    var price = 0;
                    this.book.mealPrice = 0;
                    this.book.mealBookings.forEach(booking => {
                        price = booking.meal.price;
                        var date1 = new Date(booking.date_from);
                        var date2 = new Date(booking.date_to);
                        // To calculate the time difference of two dates
                        var DifferenceInTime = date2.getTime() - date1.getTime();
                        // To calculate the no. of days between two dates
                        totalDays = DifferenceInTime / (1000 * 3600 * 24) + 1;
                        this.book.mealDays += totalDays;
                        this.book.mealPrice += parseInt(totalDays) * parseInt(price);
                        // console.log('Days: ', totalDays, ' Price', price, 'total Price: ', this.book.mealPrice);
                    });
                }

                this.book.totalAmount = Number.isNaN(parseInt(this.book.mealPrice)) ? 0 : parseInt(this.book.mealPrice);

                return this.book.totalAmount;
            },
            reserve() {
                if (this.book.mealBookings.length > 0) {
                    this.$refs.formReserve.submit();
                } else {
                    this.$swal('Please, Add meal booking.')
                }
            }
        }
    }
</script>

<style scoped>

</style>

<template>
      <main>
      <div class="profilee-detail container py-5">
        <div class="row">
          <user-profile> </user-profile>

          <div class="col-12 col-md-8">

            <!--Tabs-->
      <!-- Nav tabs -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation" @click="loadAccommodationsBooking">
    <button class="nav-link active" id="accomodation-tab" data-toggle="tab" data-target="#accomodation" type="button" role="tab" aria-controls="accomodation" aria-selected="true">Accomodations</button>
  </li>
  <li class="nav-item" role="presentation" @click="loadMealsBooking">
    <button class="nav-link" id="meal-tab" data-toggle="tab" data-target="#meal" type="button" role="tab" aria-controls="meal" aria-selected="false">Meals</button>
  </li>    
  <li class="nav-item" role="presentation" @click="loadTransportsBooking">
    <button class="nav-link" id="vehicle-tab" data-toggle="tab" data-target="#vehicle" type="button" role="tab" aria-controls="vehicle" aria-selected="false">Vehicles</button>
  </li>
  <li class="nav-item" role="presentation" @click="loadExperiencesBooking">
    <button class="nav-link" id="activity-tab" data-toggle="tab" data-target="#activity" type="button" role="tab" aria-controls="activity" aria-selected="false">Activities</button>
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content mt-4">
  <!--Accomodatio-->
  <div class="tab-pane active" id="accomodation" role="tabpanel" aria-labelledby="accomodation-tab">
    <div class="booking-services">
      <div class="booking-card">
        <h5 class="booking-title my-3">
          <img src="/assets/img/icons/booking.png" class="mr-2"> | Current Bookings
        </h5>
        <!--booking-row-->
        <div class="booking-list" v-for="(detail, index) in accommodationDetail"
                  :key="index">
          <div class="row">
            <div class="view-wrapper"  @click="loadBookingDetail(detail.id,detail.module_name)" 
            >
              <img src="/assets/img/view.png"  >
            </div>
            <!--1 is fully paid 2 for partial and 0 is unpaid -->
            <div v-if="detail.payment_status !=1" class="payment-wrapper pay_now"  @click="movePayNow(detail.id)" 
            >
              <img src="/assets/img/payment.png"  >
            </div>
            <div class="col-12 col-md-2"> 
              <div class="booking-profile" v-if="detail.accommodation.single_image !=null">
                <img  :src="$imagePath +'accommodations/' + detail.accommodation.single_image.name" alt="">
              </div>
              <div class="booking-profile" v-else>
                <img  src="/assets/uploads/not-found.png" alt="" srcset="">
              </div>
              
            </div>
            <div class="col-12 col-md-4">
              <div class="booking-profile-info">
                <div class="profile-info">
                  <div class="profile-info-avatar" v-if="detail.provider.image !=null">
                        <img  :src="'/assets/uploads/users/' + detail.provider.image" alt="" srcset="">
                   
                  </div>
                  <div class="profile-info-avatar" v-else>
                   <img src="/assets/uploads/not-found.png" alt="">
                  </div>
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      {{detail.provider.name}}
                    </h5>
                    <h6 class="booking-profile-location">
                      <img src="/assets/img/icons/map-pin.png" class="mr-2">  {{detail.accommodation.title}}
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                  <button><img src="/assets/img/icons/message.png" alt="" class="mr-1"> Message</button>
                  <button class="ml-2"> <img src="/assets/img/icons/map-pin.png" alt="" class="mr-1">View map</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      Accomodation
                    </h5>
                    <h6 class="booking-profile-location">
                      {{ detail.start_date |formatDate}}  to {{ detail.end_date |formatDate}} 
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/change.png" alt="" class="mr-1">Change</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">

              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                     Duration
                    </h5>
                    <h6 class="booking-profile-location">
                     {{ detail.no_of_nights}}  days
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2" @click="cancelBooking(detail.id)">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/cancel.png" alt="" class="mr-1">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>
       
      </div>


      <!--Past Bookings start-->
       <div class="booking-card">
        <h5 class="booking-title my-3">
          <img src="/assets/img/icons/booking.png" class="mr-2"> | Past Bookings
        </h5>
        <!--booking-row-->
        <div class="booking-list" v-for="(detail, index) in accommodationPastBooking"
                  :key="index">
          <div class="row">
            <div class="view-wrapper"  @click="loadBookingDetail(detail.id,detail.module_name)" 
            >
              <img src="/assets/img/view.png"  >
            </div>
            <!--1 is fully paid 2 for partial and 0 is unpaid -->
            <div v-if="detail.payment_status !=1" class="payment-wrapper pay_now"  @click="movePayNow(detail.id)" 
            >
              <img src="/assets/img/payment.png"  >
            </div>
            <div class="col-12 col-md-2"> 
              <div class="booking-profile" v-if="detail.accommodation.single_image !=null">
                <img  :src="$imagePath +'accommodations/' + detail.accommodation.single_image.name" alt="">
              </div>
              <div class="booking-profile" v-else>
                <img  src="/assets/uploads/not-found.png" alt="" srcset="">
              </div>
              
            </div>
            <div class="col-12 col-md-4">
              <div class="booking-profile-info">
                <div class="profile-info">
                  <div class="profile-info-avatar" v-if="detail.provider.image !=null">
                        <img  :src="'/assets/uploads/users/' + detail.provider.image" alt="" srcset="">
                   
                  </div>
                  <div class="profile-info-avatar" v-else>
                   <img src="/assets/uploads/not-found.png" alt="">
                  </div>
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      {{detail.provider.name}}
                    </h5>
                    <h6 class="booking-profile-location">
                      <img src="/assets/img/icons/map-pin.png" class="mr-2">  {{detail.accommodation.title}}
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                  <button><img src="/assets/img/icons/message.png" alt="" class="mr-1"> Message</button>
                  <button class="ml-2"> <img src="/assets/img/icons/map-pin.png" alt="" class="mr-1">View map</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      Accomodation
                    </h5>
                    <h6 class="booking-profile-location">
                      {{ detail.start_date |formatDate}}  to {{ detail.end_date |formatDate}} 
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/change.png" alt="" class="mr-1">Change</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">

              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                     Duration
                    </h5>
                    <h6 class="booking-profile-location">
                     {{ detail.no_of_nights}}  days
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2" @click="cancelBooking(detail.id)">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/cancel.png" alt="" class="mr-1">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>
       
      </div>
    </div>

  </div>
  <!--Meals-->
  <div class="tab-pane" id="meal" role="tabpanel" aria-labelledby="meal-tab">
    <div class="booking-services">
      <div class="booking-card">
        <h5 class="booking-title my-3">
          <img src="/assets/img/icons/booking.png" class="mr-2"> | Current Bookings
        </h5>
        <!--booking-row-->
        <div class="booking-list" v-for="(detail, index) in mealDetail"
                  :key="index">
          <div class="row">
            <div class="view-wrapper"  @click="loadBookingDetail(detail.id,detail.module_name)" 
            >
              <img src="/assets/img/view.png"  >
            </div>
            <!--1 is fully paid 2 for partial and 0 is unpaid -->
            <div v-if="detail.payment_status !=1" class="payment-wrapper pay_now"  @click="movePayNow(detail.id)" 
            >
              <img src="/assets/img/payment.png"  >
            </div>
            <div class="col-12 col-md-2"> 
              <div class="booking-profile" v-if="detail.meal.single_image !=null">
                <img  :src="$imagePath +'meals/' + detail.meal.single_image.name" alt="">
              </div>
              <div class="booking-profile" v-else>
                <img  src="/assets/uploads/not-found.png" alt="" srcset="">
              </div>
              
            </div>
            <div class="col-12 col-md-4">
              <div class="booking-profile-info">
                <div class="profile-info">
                  <div class="profile-info-avatar" v-if="detail.provider.image !=null">
                        <img  :src="'/assets/uploads/users/' + detail.provider.image" alt="" srcset="">
                   
                  </div>
                  <div class="profile-info-avatar" v-else>
                   <img src="/assets/uploads/not-found.png" alt="">
                  </div>
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      {{detail.provider.name}}
                    </h5>
                    <h6 class="booking-profile-location">
                      <img src="/assets/img/icons/map-pin.png" class="mr-2">  {{detail.meal.title}}
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                  <button><img src="/assets/img/icons/message.png" alt="" class="mr-1"> Message</button>
                  <button class="ml-2"> <img src="/assets/img/icons/map-pin.png" alt="" class="mr-1">View map</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                    Booking Date
                    </h5>
                    <h6 class="booking-profile-location">
                      {{ detail.start_date |formatDate}}  to {{ detail.end_date |formatDate}} 
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/change.png" alt="" class="mr-1">Change</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">

              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                     Duration
                    </h5>
                    <h6 class="booking-profile-location">
                     {{ detail.no_of_nights}}  days
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2" @click="cancelBooking(detail.id)">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/cancel.png" alt="" class="mr-1">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>
       
      </div>


      <!--Past Bookings start-->
       <div class="booking-card">
        <h5 class="booking-title my-3">
          <img src="/assets/img/icons/booking.png" class="mr-2"> | Past Bookings
        </h5>
        <!--booking-row-->
        <div class="booking-list" v-for="(detail, index) in mealPastBooking"
                  :key="index">
          <div class="row">
            <div class="view-wrapper"  @click="loadBookingDetail(detail.id,detail.module_name)" 
            >
              <img src="/assets/img/view.png"  >
            </div>
            <!--1 is fully paid 2 for partial and 0 is unpaid -->
            <div v-if="detail.payment_status !=1" class="payment-wrapper pay_now"  @click="movePayNow(detail.id)" 
            >
              <img src="/assets/img/payment.png"  >
            </div>
            <div class="col-12 col-md-2"> 
              <div class="booking-profile" v-if="detail.meal.single_image !=null">
                <img  :src="$imagePath +'meals/' + detail.meal.single_image.name" alt="">
              </div>
              <div class="booking-profile" v-else>
                <img  src="/assets/uploads/not-found.png" alt="" srcset="">
              </div>
              
            </div>
            <div class="col-12 col-md-4">
              <div class="booking-profile-info">
                <div class="profile-info">
                  <div class="profile-info-avatar" v-if="detail.provider.image !=null">
                        <img  :src="'/assets/uploads/users/' + detail.provider.image" alt="" srcset="">
                   
                  </div>
                  <div class="profile-info-avatar" v-else>
                   <img src="/assets/uploads/not-found.png" alt="">
                  </div>
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      {{detail.provider.name}}
                    </h5>
                    <h6 class="booking-profile-location">
                      <img src="/assets/img/icons/map-pin.png" class="mr-2">  {{detail.meal.title}}
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                  <button><img src="/assets/img/icons/message.png" alt="" class="mr-1"> Message</button>
                  <button class="ml-2"> <img src="/assets/img/icons/map-pin.png" alt="" class="mr-1">View map</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      Booking Date
                    </h5>
                    <h6 class="booking-profile-location">
                      {{ detail.start_date |formatDate}}  to {{ detail.end_date |formatDate}} 
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/change.png" alt="" class="mr-1">Change</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">

              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                     Duration
                    </h5>
                    <h6 class="booking-profile-location">
                     {{ detail.no_of_nights}}  days
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2" @click="cancelBooking(detail.id)">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/cancel.png" alt="" class="mr-1">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>
       
      </div>
    </div>
  </div>

  <!--vehicle-->
  <div class="tab-pane" id="vehicle" role="tabpanel" aria-labelledby="vehicle-tab">
     <div class="booking-services">
    <div class="booking-card">
        <h5 class="booking-title my-3">
          <img src="/assets/img/icons/booking.png" class="mr-2"> | Current Bookings
        </h5>
        <!--booking-row-->
        <div class="booking-list" v-for="(detail, index) in transportDetail"
                  :key="index">
          <div class="row">
            <div class="view-wrapper"  @click="loadBookingDetail(detail.id,detail.module_name)" 
            >
              <img src="/assets/img/view.png"  >
            </div>
            <!--1 is fully paid 2 for partial and 0 is unpaid -->
            <div v-if="detail.payment_status !=1" class="payment-wrapper pay_now"  @click="movePayNow(detail.id)" 
            >
              <img src="/assets/img/payment.png"  >
            </div>
            <div class="col-12 col-md-2"> 
              <div class="booking-profile" v-if="detail.transport.single_image !=null">
                <img  :src="$imagePath +'transports/' + detail.transport.single_image.name" alt="">
              </div>
              <div class="booking-profile" v-else>
                <img  src="/assets/uploads/not-found.png" alt="" srcset="">
              </div>
              
            </div>
            <div class="col-12 col-md-4">
              <div class="booking-profile-info">
                <div class="profile-info">
                  <div class="profile-info-avatar" v-if="detail.provider.image !=null">
                        <img  :src="'/assets/uploads/users/' + detail.provider.image" alt="" srcset="">
                   
                  </div>
                  <div class="profile-info-avatar" v-else>
                   <img src="/assets/uploads/not-found.png" alt="">
                  </div>
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      {{detail.provider.name}}
                    </h5>
                    <h6 class="booking-profile-location">
                      <img src="/assets/img/icons/map-pin.png" class="mr-2">  {{detail.transport.title}}
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                  <button><img src="/assets/img/icons/message.png" alt="" class="mr-1"> Message</button>
                  <button class="ml-2"> <img src="/assets/img/icons/map-pin.png" alt="" class="mr-1">View map</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      Booking Date
                    </h5>
                    <h6 class="booking-profile-location">
                      {{ detail.start_date |formatDate}}  to {{ detail.end_date |formatDate}} 
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/change.png" alt="" class="mr-1">Change</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">

              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                     Duration
                    </h5>
                    <h6 class="booking-profile-location">
                     {{ detail.no_of_nights}}  days
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2" @click="cancelBooking(detail.id)">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/cancel.png" alt="" class="mr-1">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>
       
      </div>


      <!--Past Bookings start-->
       <div class="booking-card">
        <h5 class="booking-title my-3">
          <img src="/assets/img/icons/booking.png" class="mr-2"> | Past Bookings
        </h5>
        <!--booking-row-->
        <div class="booking-list" v-for="(detail, index) in transportPastBooking"
                  :key="index">
          <div class="row">
            <div class="view-wrapper"  @click="loadBookingDetail(detail.id,detail.module_name)" 
            >
              <img src="/assets/img/view.png"  >
            </div>
            <!--1 is fully paid 2 for partial and 0 is unpaid -->
            <div v-if="detail.payment_status !=1" class="payment-wrapper pay_now"  @click="movePayNow(detail.id)" 
            >
              <img src="/assets/img/payment.png"  >
            </div>
            <div class="col-12 col-md-2"> 
              <div class="booking-profile" v-if="detail.transport.single_image !=null">
                <img  :src="$imagePath +'transports/' + detail.transport.single_image.name" alt="">
              </div>
              <div class="booking-profile" v-else>
                <img  src="/assets/uploads/not-found.png" alt="" srcset="">
              </div>
              
            </div>
            <div class="col-12 col-md-4">
              <div class="booking-profile-info">
                <div class="profile-info">
                  <div class="profile-info-avatar" v-if="detail.provider.image !=null">
                        <img  :src="'/assets/uploads/users/' + detail.provider.image" alt="" srcset="">
                   
                  </div>
                  <div class="profile-info-avatar" v-else>
                   <img src="/assets/uploads/not-found.png" alt="">
                  </div>
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      {{detail.provider.name}}
                    </h5>
                    <h6 class="booking-profile-location">
                      <img src="/assets/img/icons/map-pin.png" class="mr-2">  {{detail.transport.title}}
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                  <button><img src="/assets/img/icons/message.png" alt="" class="mr-1"> Message</button>
                  <button class="ml-2"> <img src="/assets/img/icons/map-pin.png" alt="" class="mr-1">View map</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      Booking Date
                    </h5>
                    <h6 class="booking-profile-location">
                      {{ detail.start_date |formatDate}}  to {{ detail.end_date |formatDate}} 
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/change.png" alt="" class="mr-1">Change</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">

              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                     Duration
                    </h5>
                    <h6 class="booking-profile-location">
                     {{ detail.no_of_nights}}  days
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/cancel.png" alt="" class="mr-1">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>
       
      </div>
    </div>
  </div>
<!--Activity-->
  <div class="tab-pane" id="activity" role="tabpanel" aria-labelledby="activity-tab">
    
  <div class="booking-services">
    <div class="booking-card">
        <h5 class="booking-title my-3">
          <img src="/assets/img/icons/booking.png" class="mr-2"> | Current Bookings
        </h5>
        <!--booking-row-->
        <div class="booking-list" v-for="(detail, index) in experienceDetail"
                  :key="index">
          <div class="row">
            <div class="view-wrapper"  @click="loadBookingDetail(detail.id,detail.module_name)" 
            >
              <img src="/assets/img/view.png"  >
            </div>
            <!--1 is fully paid 2 for partial and 0 is unpaid -->
            <div v-if="detail.payment_status !=1" class="payment-wrapper pay_now"  @click="movePayNow(detail.id)" 
            >
              <img src="/assets/img/payment.png"  >
            </div>
            <div class="col-12 col-md-2"> 
              <div class="booking-profile" v-if="detail.experience.single_image !=null">
                <img  :src="$imagePath +'experiences/' + detail.experience.single_image.name" alt="">
              </div>
              <div class="booking-profile" v-else>
                <img  src="/assets/uploads/not-found.png" alt="" srcset="">
              </div>
              
            </div>
            <div class="col-12 col-md-4">
              <div class="booking-profile-info">
                <div class="profile-info">
                  <div class="profile-info-avatar" v-if="detail.provider.image !=null">
                        <img  :src="'/assets/uploads/users/' + detail.provider.image" alt="" srcset="">
                   
                  </div>
                  <div class="profile-info-avatar" v-else>
                   <img src="/assets/uploads/not-found.png" alt="">
                  </div>
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      {{detail.provider.name}}
                    </h5>
                    <h6 class="booking-profile-location">
                      <img src="/assets/img/icons/map-pin.png" class="mr-2">  {{detail.experience.title}}
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                  <button><img src="/assets/img/icons/message.png" alt="" class="mr-1"> Message</button>
                  <button class="ml-2"> <img src="/assets/img/icons/map-pin.png" alt="" class="mr-1">View map</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      Booking Date
                    </h5>
                    <h6 class="booking-profile-location">
                      {{ detail.start_date |formatDate}}  to {{ detail.end_date |formatDate}} 
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/change.png" alt="" class="mr-1">Change</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">

              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                     Duration
                    </h5>
                    <h6 class="booking-profile-location">
                     {{ detail.no_of_nights}}  days
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2" @click="cancelBooking(detail.id)">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/cancel.png" alt="" class="mr-1">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>
       
      </div>


      <!--Past Bookings start-->
       <div class="booking-card">
        <h5 class="booking-title my-3">
          <img src="/assets/img/icons/booking.png" class="mr-2"> | Past Bookings
        </h5>
        <!--booking-row-->
        <div class="booking-list" v-for="(detail, index) in experiencePastBooking"
                  :key="index">
          <div class="row">
            <div class="view-wrapper"  @click="loadBookingDetail(detail.id,detail.module_name)" 
            >
              <img src="/assets/img/view.png"  >
            </div>
            <!--1 is fully paid 2 for partial and 0 is unpaid -->
            <div v-if="detail.payment_status !=1" class="payment-wrapper pay_now"  @click="movePayNow(detail.id)" 
            >
              <img src="/assets/img/payment.png"  >
            </div>
            <div class="col-12 col-md-2"> 
              <div class="booking-profile" v-if="detail.experience.single_image !=null">
                <img  :src="$imagePath +'experiences/' + detail.experience.single_image.name" alt="">
              </div>
              <div class="booking-profile" v-else>
                <img  src="/assets/uploads/not-found.png" alt="" srcset="">
              </div>
              
            </div>
            <div class="col-12 col-md-4">
              <div class="booking-profile-info">
                <div class="profile-info">
                  <div class="profile-info-avatar" v-if="detail.provider.image !=null">
                        <img  :src="'/assets/uploads/users/' + detail.provider.image" alt="" srcset="">
                   
                  </div>
                  <div class="profile-info-avatar" v-else>
                   <img src="/assets/uploads/not-found.png" alt="">
                  </div>
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      {{detail.provider.name}}
                    </h5>
                    <h6 class="booking-profile-location">
                      <img src="/assets/img/icons/map-pin.png" class="mr-2">  {{detail.experience.title}}
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                  <button><img src="/assets/img/icons/message.png" alt="" class="mr-1"> Message</button>
                  <button class="ml-2"> <img src="/assets/img/icons/map-pin.png" alt="" class="mr-1">View map</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                      Booking Date
                    </h5>
                    <h6 class="booking-profile-location">
                      {{ detail.start_date |formatDate}}  to {{ detail.end_date |formatDate}} 
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/change.png" alt="" class="mr-1">Change</button>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">

              <div class="booking-profile-info">
                <div class="profile-info">
                  
                  <div class="booking-profile-details ml-2">
                    <h5 class="booking-profile-name">
                     Duration
                    </h5>
                    <h6 class="booking-profile-location">
                     {{ detail.no_of_nights}}  days
                    </h6>
                  </div>
                </div>
                <div class="booking-button mt-2" @click="cancelBooking(detail.id)">
                 
                  <button class="ml-2"> <img src="/assets/img/icons/cancel.png" alt="" class="mr-1">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>
       
      </div>
    </div>
    </div>
 
</div>
            <!--Tabs-->
  <booking-detail :booking_id="updateData" :module_name="module"></booking-detail>
  <cancel-booking :booking_id="cancelBookingData"></cancel-booking>   
          </div>
        </div>


      </div>
    </main>

</template>
<script>
export default {
  name: "myBookings",

  data() {
    return {
      accommodationDetail:{},
      accommodationPastBooking:{},
      mealDetail:{},
      mealPastBooking:{},
      experienceDetail:{},
      experiencePastBooking:{},
      transportDetail:{},
      transportPastBooking:{},
      booking_id :'',
      module:'',
    };
  },
 computed:{
   updateData(){
     return this.booking_id;
   },
   cancelBookingData(){
     return this.booking_id;
   },
  },
  created() {
    this.loadAccommodationsBooking();
  },
  methods: {
      loadAccommodationsBooking() {
      axios.get("/api/getMyBookingsForWeb/accommodations").then((response) => {
      this.accommodationDetail = response.data.data.data;
      this.accommodationPastBooking = response.data.pastBookings.data;
      });
    },
     movePayNow(booking_id){
        localStorage.setItem("booking_id", booking_id);
        this.$router.push({ path: "/bookings/checkout" });

    },
     loadMealsBooking() {
      axios.get("/api/getMyBookingsForWeb/meals").then((response) => {
      this.mealDetail = response.data.data.data;
      this.mealPastBooking = response.data.pastBookings.data;
      });
    },
    loadExperiencesBooking() {
      
      axios.get("/api/getMyBookingsForWeb/experiences").then((response) => {
      this.experienceDetail = response.data.data.data;
      this.experiencePastBooking = response.data.pastBookings.data;
      });
    },
    loadTransportsBooking() {  
      axios.get("/api/getMyBookingsForWeb/transports").then((response) => {
      this.transportDetail = response.data.data.data;
      this.transportPastBooking = response.data.pastBookings.data;
     
      });
    },
    loadBookingDetail(id,module_name) { 
      this.booking_id = id;
      this.module = module_name;
      $("#exampleModal").modal('toggle');
    },
    cancelBooking(id) { 
      this.booking_id = id;
      $("#cancelModalLong").modal('toggle'); 
         
    },
    
 },
};
</script>
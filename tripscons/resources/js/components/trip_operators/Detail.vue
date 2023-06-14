<template>
    <main>
      <div class="container">
        <div class="country-banners-sec">
          <div class="row">
            <div class="col-12 col-sm-8">
              <div class="row position-relative">
                <button class="btn  slide-photos" data-toggle="modal" data-target="#image-slider">
                  Show all photos
                </button>
                <div class="col-12 col-sm-8">
                  <div class="larger-img-holder" data-toggle="modal" data-target="#image-slider" v-for="(main_img,index) in dataAcc.images" :key="index">
                    <img v-if="main_img.type=='main' && main_img.module=='trip_operator'" :src="'/assets/uploads/'+main_img.name" alt="img" />
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="center-img-holder" v-for="(imge ,index) in dataAcc.images" :key="index" data-toggle="modal" data-target="#image-slider">
                    <img v-if="imge.type=='normal' && imge.module=='trip_operator'" :src="'/assets/uploads/'+imge.name" alt="img" />
                  </div>
                  <!-- <div class="center-img-holder">
                    <img src="/assets/img/country-1.jpg" alt="img" />
                  </div> -->
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="hotel-title-sec">
                <h1>{{ dataAcc.title }}</h1>
              </div>
              <div class="d-flex mt-1 justify-content-start">
                <div>
                  <p class="longright"><span><img class="starr" src="/assets/img/icons/star.png" width="25px" height="25px"/></span> <span class="ratingg">{{ dataAcc.id.toFixed(1)}} <span>(140)</span></span></p>
                </div>
              </div>
              <div class="d-flex justify-content-between mt-0">
            
               
              </div>
              <div class="d-flex cbrudcrums mt-2">
                <ul>
                  <li>{{ dataAcc.id}}guests/</li>
                  <li>3 beds/</li>
                  <li>3 bedrooms/</li>
                  <li>2 baths</li>
                </ul>
              </div>
              
              <div class="d-flex justify-content-center mt-4">
                <button type="button" class="btn btn-customm">Check availability</button>
              </div>
              <div class="invoice-box">
                <div class="check-container mt-4">
                  <div class="d-flex mt-3 justify-content-between">
                      <p class="pricepernight">${{ dataAcc.price }} <span>/ night</span></p>
                      <p class="check-container-right"><span><img src="/assets/img/icons/tgg.png" width="30px" height="22px"/></span> <span>discount for <br />long stays</span></p>
                  </div>
                  <div class="row">
                    <div class="col-6 col-sm-6 col-md-6">
                      <div class="checkinout">
                        <input type="date" class="checkout" placeholder="Check In" />
                      </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6">
                      <div class="checkinout">
                        <input type="date" class="checkout" placeholder="Check Out" />
                      </div>
                    </div>
                  </div>
                  <div class="guest-toggle mt-4">
                    <a href="#" class="btn btn-filter" id="dropdownMenuLink" data-toggle="dropdown">Guests</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <strong>Guests</strong>
                      <div class="row mb-4">
                        <div class="col">
                          <div class="input-field">
                            <label class="guest-lable">Adults</label>
                            <small>Ages 13 or above</small>
                          </div>
                        </div>
                        <div class="col">
                          <div class="quantity buttons_added">
                            <input type="button" value="-" class="minus" />
                            <input type="number" step="1" min="1" title="Qty" size="4" pattern="" inputmode=""
                              class="input-text qty text" />
                            <input type="button" value="+" class="plus" />
                          </div>
                        </div>
                      </div>
                      <div class="row mb-4">
                        <div class="col">
                          <div class="input-field">
                            <label class="guest-lable">Childs</label>
                            <small>Ages Below 13</small>
                          </div>
                        </div>
                        <div class="col">
                          <div class="quantity buttons_added">
                            <input type="button" value="-" class="minus" />
                            <input type="number" step="1" min="1" max="" name="quantity" title="Qty"
                              class="input-text qty text" size="4" pattern="" inputmode="" />
                            <input type="button" value="+" class="plus" @ />
                          </div>
                        </div>
                      </div>
                      <div class="btn-sec text-center">
                        <a href="#" class="btn btn-apply">Apply</a>
                      </div>
                    </div>
                  </div>
                  <div class="check-guest mt-4">
                    <label class="switch">
                      <input type="checkbox" checked>
                      <span class="slider round"></span>
                    </label>
                    <span class="ml-2">Include Meals</span>
                  </div>
                  <div class="total-invoice">
                    <div class="charges-section mt-3 d-flex justify-content-between">
                      <p class="service">$190 x 7 nights</p>
                      <p class="charges">$1330</p>
                    </div>
                    <div class="charges-section d-flex justify-content-between">
                        <p class="service">Service fee</p>
                        <p class="charges">$133</p>
                    </div>
                    <div class="charges-section d-flex justify-content-between">
                        <p class="service">Meals</p>
                        <p class="charges">$100</p>
                    </div>
                    <hr class="charges-line">
                    <div class="charges-section d-flex justify-content-between">
                        <p class=" services service-total">Total</p>
                        <p class="charges charges-total">$1563</p>
                    </div>
                  </div>
                  <div class="d-flex justify-content-center mt-3">
                    <button type="button" class="btn btn-reserve">Reserve now!</button>
                  </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                  <button type="button" class="btn btn-weather">Check weather for this dates </button>
                </div>
                
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-8">
            <div class="home-details">
              <div class="media mb-4">
                <img class="mr-3" src="/assets/img/icons/acommodation.png" alt="Generic placeholder image">
                <div class="media-body">
                  <h5 class="mt-0">Main feature</h5>
                  <p>Host offers meals and vehicle booking</p>
                </div>
              </div>
              <div class="media mb-4">
                <img class="mr-3" src="/assets/img/icons/feat.png" alt="Generic placeholder image">
                <div class="media-body">
                  <h5 class="mt-0">Entire accomodation</h5>
                  <p>Accomodation will be completely at your disposal.</p>
                </div>
              </div>
              <div class="media mb-4">
                <img class="mr-3" src="/assets/img/icons/time.png" alt="Generic placeholder image">
                <div class="media-body">
                  <h5 class="mt-0">Flexible check in</h5>
                  <p>The landlord offers a long period of time for check-in and out </p>
                </div>
              </div>
            </div>
            <div class="about-txt">
             
            </div>
            <div class="home-services">
              <ul>
                <li v-for="(fac,index) in dataAcc.facility" :key="index">
                  <span class="service-icon align-self-center "><img :src="'/assets/icons/'+fac.icon"></span>
                  <span class="service-txt align-self-center"> {{fac.name}} </span>
                </li>
              </ul>
              <div class="btnsec mt-4">
                <a href="#" class="btn btn-showall ripple">Show all 27 amenities</a>
              </div>
            </div>
          </div>
        </div>
        <div class="location-sec">
        
          <!-- <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2686.220695675786!2d-122.12713518448905!3d47.680133779189575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x549072b3a89bff93%3A0xa7079ac57e754c81!2sC.%20Joy%20Salon!5e0!3m2!1sen!2s!4v1621617955731!5m2!1sen!2s"
            width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
            <GmapMap   
              :center="{lat:dataAcc.id, lng:dataAcc.id}"
              :zoom="7"   
              map-type-id="terrain"
              style="width: 100%; height: 350px"
            >
             
           </GmapMap>
        </div>
        <div class="about-host">
          <h3>About Host</h3>
          <div class="row">
            <div class="col-12 col-sm-4 col-md-5">
              <div class="host-profilesec">
                <div class="row">
                  <div class="col-12 col-sm-6 col-md-6">
                    <div class="img-holder">
                      <img src="img/guide-1.jpg" alt="Generic placeholder image" />
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6">
                    <div class="host-name">
                      <div class="top-rated">
                        <a href="#" class="btn btn-ribbon ripple"> <span class="icon-holder"><img
                              src="img/icons/ribbon.png" alt="img"></span> Top rated host</a>
                      </div>
                      <h5 class="mt-0">John Smith</h5>
                      <p>USA, New York</p>
                      <a href="#" class="btn btn-contacthost ripple">Contact host</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-8 col-md-7">
              <div class="host-tab">
                <ul class="d-flex">
                  <li class="justify-content-between align-self-center">
                    <a href="#">
                      <span class="rating-title d-flex align-self-center justify-content-center">4.5 <span
                          class="rating"><i class="fa fa-star"></i></span></span>
                      <span class="rate-review">90 reviews</span>
                    </a>
                  </li>
                  <li class="justify-content-between align-self-center"><span>100 <br />times hosted</span></li>
                  <li class="justify-content-between align-self-center"><span>90% <br />respose rate</span></li>
                  <li class="justify-content-between align-self-center"><span>1 hour <br />respose time</span></li>
                </ul>
              </div>
              <div class="abouthost">
                <h4>About John</h4>
                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                  classical Latin literature from 45 BC, making it over 2000 years old. </p>
              </div>
            </div>
          </div>
        </div>
        <div class="vehicles-sec detail-page-vehicles">
          <h3 class="title-section">Other host services</h3>
          <div class="row">
            <div class="col-12 col-sm-3">
              <div class="vehicles-box">
                <a href="#">
                  <img src="/assets/img/hotel-2.jpg" alt="img">
                  <div class="d-flex justify-content-between align-self-center ">
                    <strong>Accomodation</strong>
                    <a href="#"><strong> 90</strong></a>
                  </div>
                </a>
              </div>
            </div>
            <div class="col-12 col-sm-3">
              <div class="vehicles-box">
                <a href="#">
                  <img src="/assets/img/car.jpg" alt="img">
                  <div class="d-flex justify-content-between align-self-center ">
                    <strong>Vehicles</strong>
                    <a href="#"><strong> 90</strong></a>
                  </div>
                </a>
              </div>
            </div>
            <div class="col-12 col-sm-3">
              <div class="vehicles-box">
                <a href="#">
                  <img src="/assets/img/home_1.jpg" alt="img">
                  <div class="d-flex justify-content-between align-self-center ">
                    <strong> Meals</strong>
                    <a href="#"><strong> 90</strong></a>
                  </div>
                </a>
              </div>
            </div>
            <div class="col-12 col-sm-3">
              <div class="vehicles-box">
                <a href="#">
                  <img src="/assets/img/activity-1.png" alt="img">
                  <div class="d-flex justify-content-between align-self-center ">
                    <strong> Activities</strong>
                    <a href="#"><strong> 90</strong></a>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="feedback-sec">
          <div class="feedback-title d-flex mb-20">
            <h3 class="align-self-center">Feedback</h3>
            <a href="#" class="align-self-center">
              <span class="rating align-self-center"><i class="fa fa-star"></i></span>
              <span class="rating-title align-self-center">4.5</span>
              <span class="count-rating align-self-center">(14)</span>
            </a>
          </div>
          <div class="d-flex justify-content-between mb-40">
            <a href="" class="btn btn-feedback-rate">
              <span>Location</span>
              <span>
                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                <span class="rating-title align-self-center">4.5</span>
              </span>
            </a>
            <a href="" class="btn btn-feedback-rate">
              <span>Cleanliness</span>
              <span>
                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                <span class="rating-title align-self-center">4.5</span>
              </span>
            </a>
            <a href="" class="btn btn-feedback-rate">
              <span>Room comfort</span>
              <span>
                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                <span class="rating-title align-self-center">4.5</span>
              </span>
            </a>
            <a href="" class="btn btn-feedback-rate">
              <span>Service quality</span>
              <span>
                <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                <span class="rating-title align-self-center">4.5</span>
              </span>
            </a>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6 col-md-6">
              <div class="media">
                <div class="review-img mr-3">
                  <img src="/assets/img/profil.jpg" alt="Generic placeholder image">
                  <h4>Julia S.</h4>
                </div>
                <div class="media-body">
                  <ul class="star-list">
                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                  </ul>
                  <div class="review-btnsec d-flex justify-content-between mb-3">
                    <a href="" class="btn btn-feedback-rate">
                      <span>Location</span>
                      <span>
                        <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                        <span class="rating-title align-self-center">5</span>
                      </span>
                    </a>
                    <a href="" class="btn btn-feedback-rate">
                      <span>Cleanliness</span>
                      <span>
                        <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                        <span class="rating-title align-self-center">5</span>
                      </span>
                    </a>
                    <a href="" class="btn btn-feedback-rate">
                      <span>Comfort</span>
                      <span>
                        <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                        <span class="rating-title align-self-center">5</span>
                      </span>
                    </a>
                    <a href="" class="btn btn-feedback-rate">
                      <span>Quality</span>
                      <span>
                        <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                        <span class="rating-title align-self-center">5</span>
                      </span>
                    </a>
                  </div>
                  <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                    classical Latin literature from 45 BC, making it over 2000 years old. </p>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
              <div class="media">
                <div class="review-img mr-3">
                  <img src="/assets/img/profil.jpg" alt="Generic placeholder image">
                  <h4>Julia S.</h4>
                </div>
                <div class="media-body">
                  <ul class="star-list">
                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                  </ul>
                  <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                    classical Latin literature from 45 BC, making it over 2000 years old. </p>
                </div>
              </div>
            </div>
          </div>
          <div class="btnsec mt-4">
            <a href="#" class="btn btn-showall">Show more</a>
          </div>
        </div>
        <div class="tripmate-sec">
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="rules-sec">
                <h4 class="mb-4">Important information</h4>
                <div class="panel-group" id="accordion">
                  <!-- First Panel -->
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                        aria-controls="collapseOne">Rules</h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse show">
                      <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus.
                      </div>
                    </div>
                  </div>
                  <!-- Second Panel -->
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title" data-toggle="collapse" data-target="#collapseTwo">Cancellation policy</h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                      <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title" data-toggle="collapse" data-target="#collapseThree">Important info</h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                      <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="tripsmate-img">
                <img src="/assets/img/tripmate.png" alt="img" />
              </div>
            </div>
          </div>
        </div>
        <div class="stay-in-sec">
          <h3 class="title-section f-30">Near by </h3>
          <div class="row">
            <div class="col-12 col-sm-3" v-for="(a,index) in nearByAcc" :key="index">
              <div class="hotel-box">
                <div class="img-holder">    
                 <img v-if="a.single_image !=null" :src="$imagePath+a.single_image.name" alt="hotel"/>
                <img v-else src="/assets/img/not-found.png" alt="hotel"/>
                </div>
                <div class="room-cap">
                  <img src="/assets/img/person-add.png" alt="icon" />
                  <small>up to <br />12 </small>
                </div>
                <div class="content-holder">
                  <small> <img src="/assets/img/map-pin.png" alt="icon" /> {{a.title}} <span>1700 miles away</span> </small>
                  <div class="d-flex justify-content-between align-self-center mb-2">
                    <h3 class="align-self-center"> from New York</h3>
                    <a href="#">
                      <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                      <span class="rating-title align-self-center">4.5</span>
                      <span class="count-rating align-self-center">(14)</span>
                    </a>
                  </div>
                  <a href="#" class="btn btn-price"> {{a.per_night}}$ / <span>night</span></a>
                </div>
              </div>
            </div>
            
           
          </div>
        </div>
      </div>
      <!-- Modal -->
        <div class="modal fade" id="image-slider" tabindex="-1" role="dialog"
        aria-labelledby="image-sliderLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
          
             <div class="images-wrapper">
               <div class="single-image-modal" v-for="(slider_img ,index) in dataAcc.images" :key="index">
              <img v-if="slider_img.module=='trip_operator'" :src="'/assets/uploads/'+slider_img.name" alt="img" />

               </div>
              
              </div>
            
          </div>
        </div>
      </div>

    </main>

</template>

<script>
import {gmapApi} from 'vue2-google-maps'
 export default {
        name: "AccommodationDetail",
        data(){
        return{
        dataAcc :'',
        nearByAcc:'',
        };
        
        },
        created(){
        this.accommodationGet();
        google: gmapApi;
        },
        methods:{
          accommodationGet(){
          let bodyFormData = new FormData();
           
          const  href = window.location ;
          const segments = new URL(href).pathname.split('/');
          const accommodationId = segments.pop() || segments.pop(); // Handle potential trailing slash 
         
          //bodyFormData.append("id", last); 
          axios.get("/api/tripOperatorDetail/"+accommodationId).then((response) => {
          this.dataAcc = response.data.acc_detail;
          this.nearByAcc= response.data.acc; 
           }); 
         
        },
        
  },
 
}
</script>
<style scoped>
#image-slider .modal-content{
  background: transparent !important;
}
.images-wrapper{
  display: flex;
  flex-wrap: wrap;
}
.images-wrapper .single-image-modal {
  flex:1 1 98%;
  margin: 4px 0px;
 
}
.images-wrapper .single-image-modal img{
  width: 100%;
  height: 97vh;
}
.slide-photos{
      box-shadow: 1px 0px 2px 2px #f1baba;
    position: absolute;
    bottom: 50px;
    right: 50px;
    background: #fff;
    border-radius: 8px;
    color: black;
    text-shadow: 2px 2px 2px #fff;
    padding: 4px 20px;
    z-index: 444;
}
.center-img-holder:hover,.larger-img-holder:hover,.single-image-modal:hover{
  filter: brightness(0.6);
}
</style>


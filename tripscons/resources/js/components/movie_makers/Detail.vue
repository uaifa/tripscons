<template>
    <main>
      <div class="profilee-detail container py-5">
                <div class="row mb-4" style="margin-left: 0px;">
                    <div class="col-12 col-sm-4 col-md-4">
                        <div class="profile-left profile-leftt p-4">
                            
                            <div class="row image-sction px-2">
                                <div class="col-5">
                                    <div class="img-container">
                                        <img :src="'/assets/img/'+userObj.image" class="img-fluid">
                                        <span class="user-status"></span>
                                    </div>

                                </div>
                                <div class="ml-3 col-6">
                                    <div class="profile-bio profile-bioo">
                                        <h2 class="company-title ">{{generalData.title}}</h2>
                                      
                                      <p>Member since {{userObj.created_at | formatDate}}</p>
                                        <p class="f-bold">Rs.{{generalData.price}} / hour</p>
                                    </div>

                                </div>
                            </div>
                            <!--comments section-->
                            <div class="row comment-section mt-4 px-2 mt-5">
                                <div>
                                    <span>4.9 <img src="/assets/img/icons/star.png" alt="" srcset=""></span>
                                    <span>90 reviews</span>
                                </div>
                                <div>
                                    <span>100</span>
                                    <span>times hosted</span>
                                </div>
                                <div>
                                    <span>90%</span>
                                    <span> respose rate</span>
                                </div>
                                <div>
                                    <span>1hour</span>
                                    <span>respose time</span>
                                </div>
                            </div>
                            <div class="company-profile-details mt-3">
                                <p class="title-bold">Address: <span>{{userObj.address+', '+ userObj.city+' '+userObj.country}}</span></p>
                                <p class="guide-verified title-bold">Phone number: <span>{{userObj.phone}}</span>
                                    <img src="/assets/img/icons/verified.png" width="24px" alt="" srcset="">
                                </p>
                                <p class="guide-verified title-bold">ID: <span v-if="userObj.is_phone_verified ==1">Verified</span>
                                <span v-else>Not Verified</span>
                                    <img src="/assets/img/icons/verified.png" width="24px" alt="" srcset="">
                                </p>
                                <p class="company-license title-bold">
                                    Registration number: <span>0123456</span>
                                </p>
                                
                            </div>


                            <button class="btn btn-whitee mt-4">Contact</button>
                        </div>

                    </div>
                    <div class="col-12 col-sm-8 col-md-8">

                        <div id="photographer" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#photographer" data-slide-to="0" class="active"></li>
                                <li data-target="#photographer" data-slide-to="1"></li>
                                <li data-target="#photographer" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="slider-parent" v-for="(i,index) in generalData.images" :key="index">
                                <div class="carousel-item active" v-if="i.image!=null">
                                    <img class="d-block w-100" :src="$imagePath+i.name" alt="Third slide">
                                </div>
                                <div class="carousel-item active" v-else>
                                    <img class="d-block w-100" :src="$imagePath+'not-available.png'" alt="Third slide">
                                </div>
                                 </div>
                                
                            </div>
                            <a class="carousel-control-prev" href="#photographer" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#photographer" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>


                    </div>
                </div>
                <!--Sticky menu-->
                <nav class="navbar navbar-expand-lg navbar-light custom-sticky-nav bg-light container sticky-top
            justify-content-between">

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">

                            <li class="nav-item">
                                <a class="nav-link" href="#about">About us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#reviews">Reviews</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#gallery">Gallery</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#experties">Experties</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#services">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#packages">Packages</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#team">Team</a>
                            </li>


                        </ul>
                    </div>
                </nav>
                <!--About Us section-->
                <div class="company-about-section mt-5" id="about">
                    <h3 class="title-section f-30 pt-3">About </h3>
                    <p>{{generalData.about}}</p>

                </div>
                <!--Reviews and travellers comments-->
                <div class="company-reviews-section mt-5" id="reviews">
                    <h3 class="title-section f-30 pt-3">Reviews &  comments </h3>
                    <h5>Rating & Reviews</h5>
                    <div class="row ratting-row">
                        <div class="col-12 col-sm-5 col-md-5">
                            <h5 class="rating-title mt-2">
                                Awesome Rating 4.9 out of 90 Reviews
                            </h5>
                            <div class="rating-level">
                                <span class="rating-status">Awesome</span>
                                <span>
                                    <ul class="star-list">
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </span>
                                <span class="rating-count">85</span>
                            </div>
                            <div class="rating-level">
                                <span class="rating-status">Excellent </span>
                                <span>
                                    <ul class="star-list">
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>

                                    </ul>
                                </span>
                                <span class="rating-count">4</span>
                            </div>
                            <div class="rating-level">
                                <span class="rating-status">Average</span>
                                <span>
                                    <ul class="star-list">
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>

                                    </ul>
                                </span>
                                <span class="rating-count">0</span>
                            </div>
                            <div class="rating-level">
                                <span class="rating-status">Bad &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</span>
                                <span>
                                    <ul class="star-list">
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>

                                    </ul>
                                </span>
                                <span class="rating-count">0</span>
                            </div>
                            <div class="rating-level">
                                <span class="rating-status">Terrible</span>
                                <span>
                                    <ul class="star-list">
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>

                                    </ul>
                                </span>
                                <span class="rating-count">1</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-7 col-md-7 pl-5">
                            <h5 class="rating-title mt-2">
                                Reviews & comments
                            </h5>
                            <div class="reviews-based-on">
                                <div class="review-on">
                                    <span class="review-item-name">Quality</span>
                                    <div class="review-item-value">
                                        <ul class="star-list">
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        </ul>
                                        <span class="review-item-value-count ml-2 ">5.0</span>
                                    </div>
                                </div>
                           
                                <div class="review-on">
                                    <span class="review-item-name">Value of money</span>
                                    <div class="review-item-value">
                                        <ul class="star-list">
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        </ul>
                                        <span class="review-item-value-count ml-2 ">5.0</span>
                                    </div>
                                </div>

                                <div class="review-on">
                                    <span class="review-item-name">satisfaction</span>
                                    <div class="review-item-value">
                                        <ul class="star-list">
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        </ul>
                                        <span class="review-item-value-count ml-2 ">5.0</span>
                                    </div>
                                </div>
                                <div class="review-on">
                                    <span class="review-item-name">Moviemaker</span>
                                    <div class="review-item-value">
                                        <ul class="star-list">
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        </ul>
                                        <span class="review-item-value-count ml-2 ">5.0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Feedback section-->
                    <div class="feedback-sec mt-4">
                        <h3 class="title-section f-30"> reviews </h3>

                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="media">
                                    <div class="review-img mr-3">
                                        <img src="/assets/img/profil.jpg" alt="Generic placeholder image">
                                        <h4>Julia S.</h4>
                                    </div>
                                    <div class="media-body">
                                        <div class="start-list-wrapper">
                                            <ul class="star-list">
                                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star"></i></a></li>

                                                <span class="review-date ml-5">12 dec 2020</span>
                                            </ul>
                                        </div>
                                        <div class="review-btnsec d-flex justify-content-between mb-3">
                                            <a href="" class="btn btn-feedback-rate">
                                                <span>Quality</span>
                                                <span>
                                                    <span class="rating align-self-center"><i
                                                            class="fa fa-star"></i></span>
                                                    <span class="rating-title align-self-center">5</span>
                                                </span>
                                            </a>
                                            <a href="" class="btn btn-feedback-rate">
                                                <span>Price</span>
                                                <span>
                                                    <span class="rating align-self-center"><i
                                                            class="fa fa-star"></i></span>
                                                    <span class="rating-title align-self-center">5</span>
                                                </span>
                                            </a>
                                            <a href="" class="btn btn-feedback-rate">
                                                <span>Satisfaction</span>
                                                <span>
                                                    <span class="rating align-self-center"><i
                                                            class="fa fa-star"></i></span>
                                                    <span class="rating-title align-self-center">5</span>
                                                </span>
                                            </a>
                                            <a href="" class="btn btn-feedback-rate">
                                                <span>Moviemaker</span>
                                                <span>
                                                    <span class="rating align-self-center"><i
                                                            class="fa fa-star"></i></span>
                                                    <span class="rating-title align-self-center">5</span>
                                                </span>
                                            </a>
                                        </div>
                                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has
                                            roots
                                            in a piece of
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
                                        <div class="start-list-wrapper">
                                            <ul class="star-list">
                                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star"></i></a></li>

                                                <span class="review-date ml-5">12 dec 2020</span>
                                            </ul>
                                        </div>
                                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has
                                            roots
                                            in a piece of
                                            classical Latin literature from 45 BC, making it over 2000 years old. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btnsec mt-4">
                            <a href="#" class="btn btn-showall">Show more</a>
                        </div>
                    </div>
                </div>



                <!--Media Gallery-->
                <div class="media-gallery mt-5" id="gallery">
                    <h3 class="title-section f-30 pt-3">Our gallery </h3>
                    <div class="row video-gallery">
                        <div class="col-12 col-sm-6 col-md-3" v-for="(i,index) in generalData.video" :key="index">
                            <div class="embed-responsive embed-responsive-16by9">
                            <iframe
                            class="embed-responsive-item"
                            :src="i.name"
                            
                            allowfullscreen
                            ></iframe>
                           </div>
                        </div>
                      
                      
                        <!-- <div class="col-12 col-sm-6 col-md-3">
                            <div class="embed-responsive embed-responsive-16by9">
                                <video controls>
                                    <source src="/assets/img/sample.mp4" type="video/mp4">

                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div> -->

                    </div>
                </div>


                <!--Trip Experties-->
                <div class="trip-experties mt-5" id="experties">
                    <div class="d-flex justify-content-between pt-3">
                        <h3 class="title-section f-30">Our expertise </h3>

                    </div>
                    <div class="home-services">
                        <ul>
                            <li v-for="(i,index) in generalData.expertiese" :key="index">
                                <span class="service-icon align-self-center ">
                                    <img :src="'/assets/img/icons/'+i.image">
                                    
                                    </span>
                                <span class="service-txt align-self-center">{{i.title}} </span>
                            </li>
                         
                        </ul>
                         
                    </div>
                </div>
                <!--Services-->
                <div class="trip-experties mt-5" id="services">
                    <div class="d-flex justify-content-between pt-3">
                        <h3 class="title-section f-30">Our Services </h3>

                    </div>
                    <div class="home-services">
                        <ul>
                            <li v-for="(i,index) in generalData.general_service" :key="index">
                                <span class="service-icon align-self-center ">
                                    <img :src="'/assets/img/icons/'+i.image">
                                    
                                    </span>
                                <span class="service-txt align-self-center">{{i.name}} </span>
                            </li>
                          
                        </ul>
                      
                    </div>
                </div>
                <!--See our  packages-->
                <div class="stay-in-sec mt-5" id="packages">
                    <div class="d-flex justify-content-between pt-4">
                        <h3 class="title-section f-30">See our packages </h3>
                       
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="hotel-box">
                                <div class="img-holder">
                                    <img src="/assets/img/wedding.webp" alt="hotel" />
                                </div>

                                <div class="content-holder"> 
                                    <div class="d-flex justify-content-between">
                                        <h5 class="">Wedding coverage</h5>
                                        <div class="d-flex f-bold">
                                            <span class="rating align-self-center "><i class="fa fa-star"></i></span>
                                            <span class="rating-title align-self-center ">4.5</span>
                                            <span class="count-rating align-self-center ml-1">(114)</span>
                                           
                                        </div>
                                    </div>
                                    
                                 
                                    <p class="package-offer">2 Photographers coverage
                                        300+ high res images
                                    </p>
                                    <p class="package-price">Rs.12000 / day
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="hotel-box">
                                <div class="img-holder">
                                    <img src="/assets/img/wedding.webp" alt="hotel" />
                                </div>

                                <div class="content-holder"> 
                                    <div class="d-flex justify-content-between">
                                        <h5 class="">Wedding coverage</h5>
                                        <div class="d-flex f-bold">
                                            <span class="rating align-self-center "><i class="fa fa-star"></i></span>
                                            <span class="rating-title align-self-center ">4.5</span>
                                            <span class="count-rating align-self-center ml-1">(114)</span>
                                           
                                        </div>
                                    </div>
                                    
                                 
                                    <p class="package-offer">2 Photographers coverage
                                        300+ high res images
                                    </p>
                                    <p class="package-price">Rs.12000 / day
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="hotel-box">
                                <div class="img-holder">
                                    <img src="/assets/img/wedding.webp" alt="hotel" />
                                </div>

                                <div class="content-holder"> 
                                    <div class="d-flex justify-content-between">
                                        <h5 class="">Wedding coverage</h5>
                                        <div class="d-flex f-bold">
                                            <span class="rating align-self-center "><i class="fa fa-star"></i></span>
                                            <span class="rating-title align-self-center ">4.5</span>
                                            <span class="count-rating align-self-center ml-1">(114)</span>
                                           
                                        </div>
                                    </div>
                                    
                                 
                                    <p class="package-offer">2 Photographers coverage
                                        300+ high res images
                                    </p>
                                    <p class="package-price">Rs.12000 / day
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="hotel-box">
                                <div class="img-holder">
                                    <img src="/assets/img/wedding.webp" alt="hotel" />
                                </div>

                                <div class="content-holder"> 
                                    <div class="d-flex justify-content-between">
                                        <h5 class="">Wedding coverage</h5>
                                        <div class="d-flex f-bold">
                                            <span class="rating align-self-center "><i class="fa fa-star"></i></span>
                                            <span class="rating-title align-self-center ">4.5</span>
                                            <span class="count-rating align-self-center ml-1">(114)</span>
                                           
                                        </div>
                                    </div>
                                    
                                 
                                    <p class="package-offer">2 Photographers coverage
                                        300+ high res images
                                    </p>
                                    <p class="package-price">Rs.12000 / day
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Banner Looking for quoataion-->
                <div class="quoatation-banner mt-5">
                    <div class="text-center">
                        <h3 class="title-section title-section-inquiry " style="color: white;">For customized events </h3>
                        <button class="btn btn-whitee btn-whitee-inquiry mt-3">
                            Make enquiry
                        </button>
                    </div>
                </div>

                <!--Meet our Team-->
                <div class="stay-in-sec mt-5" id="team">
                    <div class="d-flex justify-content-between pt-4">
                        <h3 class="title-section f-30">Meet our Team </h3>
                        <a href="">See all....</a>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="hotel-box">
                                <div class="img-holder">
                                    <img src="/assets/img/photographer1.webp" alt="hotel" />
                                </div>

                                <div class="content-holder">

                                    <p class="member-name">Faisal Khan<span class="member-age">(30 yeas old)</span> </p>
                                    <p class="member-type">Cinematography expert</p>


                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="hotel-box">
                                <div class="img-holder">
                                    <img src="/assets/img/creative-director.webp" alt="hotel" />
                                </div>

                                <div class="content-holder">

                                    <p class="member-name">Anees<span class="member-age">(30 yeas old)</span> </p>
                                    <p class="member-type">Creative director</p>


                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="hotel-box">
                                <div class="img-holder">
                                    <img src="/assets/img/moviee2.webp" alt="hotel" />
                                </div>

                                <div class="content-holder">

                                    <p class="member-name">Faisal Khan<span class="member-age">(30 yeas old)</span> </p>
                                    <p class="member-type">Indoor shoots expert</p>


                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="hotel-box">
                                <div class="img-holder">
                                    <img src="/assets/img/photographer2.webp" alt="hotel" />
                                </div>

                                <div class="content-holder">

                                    <p class="member-name">Anees<span class="member-age">(30 yeas old)</span> </p>
                                    <p class="member-type">Outdoor shooting expert</p>


                                </div>
                            </div>

                        </div>


                    </div>
                </div>
                <!--Other photographers you might want to hire-->
                <div class="stay-in-sec">
                    <h3 class="title-section f-30">Other movie makers you might want to hire</h3>
                    <div class="row">

                        <div class="col-12 col-sm-6 col-md-3" v-for="(i,index) in relatedData" :key="index">
                            <div class="hotel-box">
                                <router-link  :to="{path:'/movieMakers/detail/'+i.id}">
                                <div class="img-holder" v-if="i.single_image!=null">
                                    <img :src="$imagePath+'movies/'+i.single_image.name" alt="hotel" />
                                </div>
                                <div class="img-holder" v-else>
                                    <img :src="$imagePath+'not-available.png'" alt="hotel" />
                                </div>

                                <div class="content-holder">

                                    <h5 class="comapny-name">{{ i.title}}</h5>



                                    <div class="d-flex justify-content-between align-self-center mb-2">


                                        <a href="#">
                                            <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                            <span class="rating-title align-self-center">{{ i.rating}}</span>
                                            <span class="count-rating align-self-center">({{ i.no_of_reviews}})</span>
                                            <span class="ml-2">90 reviews</span>
                                        </a>

                                    </div>
                                    
                                    <p class="package-price">
                                        Rs.{{ i.price}} / day
                                    </p>

                                </div>
                                </router-link>
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
        name: "movieMakerDetail",
        data(){
        return{
        generalData :'',
        relatedData:'',
        userObj :'',
        accCount:'',
        transCount:'',
        Id: this.$route.params.movieMakerId,
        };
        
        },
        created(){
        
        this.idGet();
        google: gmapApi;
        },
        methods:{
        idGet() {
      
        axios.get("/api/movieMakerDetail/" + this.Id).then((response) => {
        this.generalData = response.data.detail;
        this.relatedData  = response.data.relatedData;
        this.userObj =      response.data.userObj;
        this.accCount =     response.data.accCount;
        this.transCount    = response.data.transCount;
        this.activityCount  =   response.data.activityCount;
      });
    },
   updateId(){
   this.Id = this.$route.params.movieMakerId;
   this.idGet();
  
   }, 
            
  },
 
  watch:{
   $route : 'updateId'
  }
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


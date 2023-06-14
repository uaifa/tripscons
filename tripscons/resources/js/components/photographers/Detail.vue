<template>
    <main>
      <div class="profilee-detail container py-5">
                <div class="row mb-4" style="margin-left: 0px;">
                    <div class="col-12 col-sm-4 col-md-4">
                        <div class="profile-left profile-leftt p-4">
                            
                            <div class="row image-sction px-2">
                                <div class="col-5">
                                    <div class="img-container">
                                        <img src="/assets/img/movie-logo.webp" class="img-fluid">
                                        <span class="user-status"></span>
                                    </div>

                                </div>
                                <div class="ml-3 col-6">
                                    <div class="profile-bio profile-bioo">
                                        <h2 class="company-title ">MotionBlurrPictures</h2>
                                        <!-- <div class="certification ">
                                            <h2>Certified Photographer </h2>
                                            <span><img src="img/icons/badge.png" width="20px" alt=""></span>
                                        </div> -->

                                        <p>Member since 2019</p>
                                        <p class="f-bold">Rs.2000 / hour</p>
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
                                <p class="title-bold">Address: <span>23 G8, Islamabad Pakistan </span></p>
                                <p class="guide-verified title-bold">Phone number: <span>+923123456789</span>
                                    <img src="/assets/img/icons/verified.png" width="24px" alt="" srcset="">
                                </p>
                                <p class="guide-verified title-bold">ID: <span>Verified</span>
                                    <img src="/assets/img/icons/verified.png" width="24px" alt="" srcset="">
                                </p>
                                <p class="company-license title-bold">
                                    Registration number: <span>0123456</span>
                                </p>
                                <p class="company-team-size title-bold">
                                    Team size: <span>10 - 15 people</span>
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
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="/assets/img/moviee1.webp" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="/assets/img/moviee2.webp" alt="Second slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="/assets/img/movie2.webp" alt="Third slide">
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
                    <p>Lorem ipusum description Lorem ipusum description Lorem ipusum description Lorem ipusum
                        description Lorem ipusum description Lorem ipusum description Lorem ipusum description Lorem
                        ipusum description Lorem ipusum description Lorem ipusum description Lorem ipusum description
                        Lorem ipusum description Lorem ipusum description Lorem ipusum description Lorem ipusum
                        description Lorem ipusum <a href="" class="ml-4">Read more</a></p>

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
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="embed-responsive embed-responsive-16by9">
                                <video controls>
                                    <source src="/assets/img/sample.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="embed-responsive embed-responsive-16by9">
                                <video controls>
                                    <source src="/assets/img/sample.mp4" type="video/mp4">

                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="embed-responsive embed-responsive-16by9">
                                <video controls>
                                    <source src="/assets/img/sample.mp4" type="video/mp4">

                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="embed-responsive embed-responsive-16by9">
                                <video controls>
                                    <source src="/assets/img/sample.mp4" type="video/mp4">

                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>

                    </div>
                </div>


                <!--Trip Experties-->
                <div class="trip-experties mt-5" id="experties">
                    <div class="d-flex justify-content-between pt-3">
                        <h3 class="title-section f-30">Our expertise </h3>

                    </div>
                    <div class="home-services">
                        <ul>
                            <li>
                                <span class="service-icon align-self-center "><img src="/assets/img/icons/teamwork.png"></span>
                                <span class="service-txt align-self-center"> Culture </span>
                            </li>
                            <li>
                                <span class="service-icon align-self-center "><img src="/assets/img/icons/coliseum.png"></span>
                                <span class="service-txt align-self-center"> History </span>
                            </li>
                            <li>
                                <span class="service-icon align-self-center "><img src="/assets/img/icons/nature.png"></span>
                                <span class="service-txt align-self-center"> Nature </span>
                            </li>
                            <li>
                                <span class="service-icon align-self-center "><img src="/assets/img/icons/elephant.png"></span>
                                <span class="service-txt align-self-center"> Wildlife </span>
                            </li>
                            <li>
                                <span class="service-icon align-self-center "><img src="/assets/img/icons/family.png"></span>
                                <span class="service-txt align-self-center"> Adventure  </span>
                            </li>
                            <li>
                                <span class="service-icon align-self-center "><img src="/assets/img/icons/adventure.png"></span>
                                <span class="service-txt align-self-center">  Family events </span>
                            </li>
                            <li>
                                <span class="service-icon align-self-center "><img src="/assets/img/icons/mosque.png"></span>
                                <span class="service-txt align-self-center"> Religious </span>
                            </li>

                        </ul>
                        <div class="btnsec mt-4">
                            <a href="#" class="btn btn-showall ripple">Show all </a>
                        </div>
                    </div>
                </div>
                <!--Services-->
                <div class="trip-experties mt-5" id="services">
                    <div class="d-flex justify-content-between pt-3">
                        <h3 class="title-section f-30">Our Services </h3>

                    </div>
                    <div class="home-services">
                        <ul>
                            <li>
                                <span class="service-icon align-self-center "><img src="/assets/img/icons/camera.png"></span>
                                <span class="service-txt align-self-center"> Indoor studio </span>
                            </li>
                            <li>
                                <span class="service-icon align-self-center "><img src="/assets/img/icons/studio.png"></span>
                                <span class="service-txt align-self-center"> Outdoor studio </span>
                            </li>
                            <li>
                                <span class="service-icon align-self-center "><img src="/assets/img/icons/couple.png"></span>
                                <span class="service-txt align-self-center"> Wedding </span>
                            </li>
                            <li>
                                <span class="service-icon align-self-center "><img src="/assets/img/icons/vest.png"></span>
                                <span class="service-txt align-self-center"> Fashion </span>
                            </li>
                            <li>
                                <span class="service-icon align-self-center "><img
                                        src="/assets/img/icons/photography.png"></span>
                                <span class="service-txt align-self-center">Nature </span>
                            </li>
                            <li>
                                <span class="service-icon align-self-center "><img
                                        src="/assets/img/icons/travekphot.png"></span>
                                <span class="service-txt align-self-center"> Travel </span>
                            </li>

                        </ul>
                        <div class="btnsec mt-4">
                            <a href="#" class="btn btn-showall ripple">Show all </a>
                        </div>
                    </div>
                </div>
                <!--See our  packages-->
                <div class="stay-in-sec mt-5" id="packages">
                    <div class="d-flex justify-content-between pt-4">
                        <h3 class="title-section f-30">See our packages </h3>
                        <a href="">See all....</a>
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

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="hotel-box">
                                <div class="img-holder">
                                    <img src="/assets/img/movie-logo.webp" alt="hotel" />
                                </div>

                                <div class="content-holder">

                                    <h5 class="comapny-name">Akasi Studios</h5>



                                    <div class="d-flex justify-content-between align-self-center mb-2">


                                        <a href="#">
                                            <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                            <span class="rating-title align-self-center">4.5</span>
                                            <span class="count-rating align-self-center">(14)</span>
                                            <span class="ml-2">90 reviews</span>
                                        </a>

                                    </div>
                                    
                                    <p class="package-price">
                                        Rs.12000 / day
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="hotel-box">
                                <div class="img-holder">
                                    <img src="/assets/img/movie-logo2.webp" alt="hotel" />
                                </div>

                                <div class="content-holder">

                                    <h5 class="comapny-name">Naveed Sami</h5>



                                    <div class="d-flex justify-content-between align-self-center mb-2">


                                        <a href="#">
                                            <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                            <span class="rating-title align-self-center">4.5</span>
                                            <span class="count-rating align-self-center">(14)</span>
                                            <span class="ml-2">90 reviews</span>
                                        </a>

                                    </div>
                                    
                                    <p class="package-price">
                                        Rs.1000 / hour
                                    </p>

                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="hotel-box">
                                <div class="img-holder">
                                    <img src="/assets/img/movie-logo.webp" alt="hotel" />
                                </div>

                                <div class="content-holder">

                                    <h5 class="comapny-name">Akasi Studios</h5>



                                    <div class="d-flex justify-content-between align-self-center mb-2">


                                        <a href="#">
                                            <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                            <span class="rating-title align-self-center">4.5</span>
                                            <span class="count-rating align-self-center">(14)</span>
                                            <span class="ml-2">90 reviews</span>
                                        </a>

                                    </div>
                                    
                                    <p class="package-price">
                                        Rs.12000 / day
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="hotel-box">
                                <div class="img-holder">
                                    <img src="/assets/img/movie-logo1.webp" alt="hotel" />
                                </div>

                                <div class="content-holder">

                                    <h5 class="comapny-name">Naveed Sami</h5>



                                    <div class="d-flex justify-content-between align-self-center mb-2">


                                        <a href="#">
                                            <span class="rating align-self-center"><i class="fa fa-star"></i></span>
                                            <span class="rating-title align-self-center">4.5</span>
                                            <span class="count-rating align-self-center">(14)</span>
                                            <span class="ml-2">90 reviews</span>
                                        </a>

                                    </div>
                                    
                                    <p class="package-price">
                                        Rs.1000 / hour
                                    </p>

                                </div>
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
          axios.get("/api/movieMakerDetail/"+accommodationId).then((response) => {
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


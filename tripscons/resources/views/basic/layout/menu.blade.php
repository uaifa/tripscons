<header >

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="/"><img src="/assets/img/logo_white.png" /></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="nav navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="/">E-mart </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" target="_blank" href="http://tripscon-community.wanologicalsolutions.com/">Community</a>
          </li>

          @if(!\Illuminate\Support\Facades\Auth::check())
          <li class="nav-item">
              <a class="nav-link "  href="#" data-toggle="modal" data-target="#loginmodal">Login </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="#" data-toggle="modal" data-target="#signupmodal">Sign Up</a>
              <div class="modal fade" id="signupmodal" role="dialog"
                  aria-labelledby="signupmodalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content pb-5">
                          <div class="modal-header">
                              <div class="header-image">
                                  <img src="/assets/img/headerr.png" class="img-fluid" alt="" srcset="">
                              </div>
                              <button type="button" class="close closee" data-dismiss="modal"
                                  aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <div class="loginbody container p-3">
                                  <div class="card-information">
                                      <div class="payment-title">
                                          <h2> Sign up </h2>

                                      </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-12 col-sm-7 col-md-7">
                                          <div class="checkout-form mt-4">
                                              <form>
                                                  <div class="form-group  mt-4">
                                                      <input type="email"
                                                          class="form-control checkout-field"
                                                          placeholder="E-mail">
                                                  </div>
                                                  <div class="form-group  mt-4">
                                                      <input type="text"
                                                          class="form-control checkout-field"
                                                          placeholder="Name">
                                                  </div>
                                                  <div class="form-group  mt-4">
                                                      <input type="password"
                                                          class="form-control checkout-field"
                                                          placeholder="Password">
                                                  </div>
                                                  <div class="form-group  mt-4">

                                                      <input type="password"
                                                          class="form-control checkout-field"
                                                          placeholder="Confirm password">
                                                  </div>
                                              </form>
                                          </div>
                                      </div>
                                      <div class="col-12 col-sm-5 col-md-5">
                                          <div class="card-information mt-3">
                                              <div class="payment-title">
                                                  <h2> Sign up with </h2>

                                              </div>
                                          </div>
                                          <div
                                              class="mt-4  d-flex justify-content-around loginpatterns">
                                              <div class="">
                                                  <img src="/assets/img/fb.png" class="img-fluid fbook" alt=""
                                                      srcset="">
                                              </div>
                                              <div class="">
                                                  <img src="/assets/img/g1.png" class="img-fluid googlee"
                                                      alt="" srcset="">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="row px-4">
                                  <div class="col-12 col-sm-7">
                                      <button class="btn btn-blackk mt-5 pl-4" data-toggle="modal"
                                      data-target="#profilemodal">Sign
                                          up!</button>
                                                <!-- Modal -->
                                      <div class="modal fade" id="profilemodal" tabindex="-1"
                                      role="dialog" aria-labelledby="profilemodal"
                                      aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content container p-5">
                                              <div class="modal-header">

                                                      <div class="login-title text-center">
                                                          <h2>  Welcome John! </h2>
                                                            <p>Let`s create your profile</p>
                                                      </div>


                                              </div>
                                              <div class="modal-body px-5">
                                                  <div class="form-check text-center" >
                                                      <input class="form-check-input" type="radio" name="profilecategory" id="tarveler" checked>
                                                      <label class="form-check-label" for="flexRadioDefault1">
                                                          As Traveler
                                                      </label>
                                                    </div>
                                                    <div class="form-check  text-center">
                                                      <input class="form-check-input" type="radio" name="profilecategory" id="Business" >
                                                      <label class="form-check-label" for="flexRadioDefault2">
                                                          As Business
                                                      </label>
                                                    </div>
                                                    <div class="d-flex justify-content-around mt-5">
                                                        <a class="btn btn-closee">Later</a>
                                                        <a class="btn btn-create" href="create-profile.html">Create</a>
                                                    </div>
                                              </div>

                                          </div>
                                      </div>
                                  </div>
                                  </div>
                                  <div class="col-12 col-sm-5">
                                      <div class="login-title ">
                                          <p> Already have acount? </p>

                                      </div>
                                      <button class="btn btn-whitee mt-1" data-dismiss="modal" data-toggle="modal" data-target="#loginmodal">Log in</button>
                                  </div>
                              </div>
                          </div>
                      </div>

                  </div>
              </div>
          </li>
          @endif
          <li class="nav-item">
            <div  class="header-buttons">
                <a class="nav-link btn btn-white ripple" href="#">Add Services</a>
                <a class="nav-link" href="#">Hosts Listings</a>
            </div>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="#"><span class="select-lang"><img src="/assets/img/flag-1.png" alt="language" /></span></a>
          </li> -->
          <!-- <img src="/assets/img/prof.png"
          alt="Profile" /> -->
          @if(!empty(Auth::user()->username))
          <li class="nav-item">
          @if(request()->is('user/setting'))
          <a class="nav-link"  href="#"><span class="nav-profile-image"></span></a>
          @else
          <a class="nav-link"  href="/user/setting"><span class="nav-profile-image"><img src="/assets/img/prof.png"
          alt="Profile" /></span></a>
          @endif
        </li>
        @endif
        </ul>
      </div>
    </div>
  </nav>
</header>


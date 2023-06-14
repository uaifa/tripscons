<template>
<div class="modal fade" id="loginmodal" role="dialog" aria-labelledby="loginmodalLabel"
        aria-hidden="true" tabindex="-1" >
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
                <form>
                    <div class="loginbody container p-3" >
                        <div class="card-information">
                            <div class="payment-title">
                                <h2> Log in </h2>
                            </div>
                            <div id="errorMessage" style="color:red" >{{ message }}</div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-7 col-md-7">
                                <div class="checkout-form mt-4" @click="clearMessage()">
                                    
                                        <div class="form-group  mt-4">
                                            <input  id="email" type="email" name="email" required
                                                class="form-control input_field" v-model="loginForm.email"
                                                placeholder="E-mail" @keypress="validateEmail">
                                        </div>  
                                        <div class="form-group  mt-4">
                                            <input id="password" name="password" required  type="password"
                                                class="form-control input_field" v-model="loginForm.password" v-on:keyup.enter="enterClicked"
                                                placeholder="Password">
                                        </div>
                                    
                                    <div class="forget-pass mt-4">
                                        <a href="#" @click="resetPasswordEmail()">Forgot your password?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-5 col-md-5">
                                <div class="card-information mt-3">
                                    <div class="payment-title">
                                        <h2> Log in with </h2>
                                    </div>
                                </div>
                                <div
                                    class="mt-4  d-flex justify-content-around loginpatterns">
                                    <div class="">
                                        <img  @click="checkLoginState()" src="/assets/img/fb.png" class="img-fluid fbook" alt=""
                                            srcset="">
                                    </div>
                                    <div class="">
                                        <img src="/assets/img/g1.png" class="img-fluid googlee"
                                            alt="" srcset="">
                                    </div>
                                </div>
                                <!-- <fb:login-button 
                                scope="public_profile,email"
                                @click="checkLoginState();">
                                </fb:login-button> -->
                                
                            </div>
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="col-12 col-sm-7 ">
                            <button  type="button" id="btn-login" ref="btnLogin" @click="loginUser" class="btn btn-blackk mt-4">Log
                                in</button>
                        </div>
                        <div class="col-12 col-sm-5">
                            <div class="login-title ">
                                <p> Don`t have account? </p>
                            </div>
                            <button class="btn btn-whitee " data-dismiss="modal" data-toggle="modal" data-target="#signupmodal">Sign up</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>

        </div>
    </div>

    
</template>

<script>
import facebookLogin from 'facebook-login-vuejs';
    export default {
        name: "LoginPopComponent",
        data() {
            return {
                loginForm: {
                    email: '',
                    password: '',
                    device_type:'web',
                    name:'',
                    device_token:'',
                    social_platform:'',
                    social_platform_id:'',
                },
                message:''
            }
        },
        components: {
        facebookLogin
    },
     methods: {
            
            enterClicked(){
              this.$refs.btnLogin.click();
             },
            
             getUserData(obj){
             console.log(obj);
             },
            clearMessage(){
                this.message = '';
            },
             checkLoginState() {
                  this.loginForm.email     =    'ghilman@gmail.com';// userData.email;
                  this.loginForm.name     =     'Ghilman Chudhuray';// userData.name;
                  this.loginForm.device_type     =     'Web';
                  this.loginForm.device_token     =   '12134';
                  this.loginForm.social_platform     = 'FaceBook';
                  this.loginForm.social_platform_id  = '732463242'//userData.id;   
              axios.post('/api/socialRegister', this.loginForm)
                .then((res) => { 
                    //this.message = res.data.data;
                    this.token=res.data.data.api_token;
                    axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                    axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
                    localStorage.setItem('user-token', this.token);
                    localStorage.setItem('user_id', res.data.data.id);
                    localStorage.setItem('type', res.data.data.type);
                    localStorage.setItem('is_profile_complete', res.data.data.is_profile_complete);
                    //localStorage.setItem('user', response.data.data.role_id)
                    //this.$root.updateRoutes()

                    if (res.data.data.is_profile_complete == 1){
                        window.location.href = '/';
                        // this.$router.push({name: 'getDashboard'});
                    }else{
                        if(res.data.data.type==2){
                            window.location.href = '/host/dashboard';
                        }else{
                            window.location.href = '/user/setting';
                        }
                        //this.$router.push({name: 'getUserSetting'});
                    }
                })
                .catch((err) => { 
                    this.message = 'Credentials does not exist.';
                    
                });
                 //enabled below code when ap setup with live url 
        //         FB.getLoginStatus(function(response) {
        //         //console.log(response); 
        //         FB.api('/me?fields=id,name,email,picture.type(large)',function(userData){
        //           this.loginForm.email     =    'ghilman@gmail.com';// userData.email;
        //           this.loginForm.name     =     'Ghilman Chudhuray';// userData.name;
        //           this.loginForm.device_type     =     'Web';
        //           this.loginForm.device_token     =   '12134';
        //           this.loginForm.social_platform     = 'FaceBook';
        //           this.loginForm.social_platform_id  = '732463242'//userData.id;
        //         //console.log(userData);
        //         });
        //         //call social api ...
        //        axios.post('/api/socialRegister', this.loginForm)
        //         .then((res) => { 
        //             //this.message = res.data.data;
        //             this.token=res.data.data.api_token;
        //             axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        //             axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
        //             localStorage.setItem('user-token', this.token);
        //             localStorage.setItem('type', res.data.data.type);
        //             localStorage.setItem('is_profile_complete', res.data.data.is_profile_complete);
        //             //localStorage.setItem('user', response.data.data.role_id)
        //             //this.$root.updateRoutes()

        //             if (res.data.data.is_profile_complete == 1){
        //                 window.location.href = '/';
        //                 // this.$router.push({name: 'getDashboard'});
        //             }else{
        //                 if(res.data.data.type==2){
        //                     window.location.href = '/host/dashboard';
        //                 }else{
        //                     window.location.href = '/user/setting';
        //                 }
        //                 //this.$router.push({name: 'getUserSetting'});
        //             }
        //         })
        //         .catch((err) => { 
        //             this.message = 'Credentials does not exist.';
                    
        //         });
        // },{scope:'public_profile,email'});
 },
            loginUser() {
                if(this.loginForm.email ==  '') {
                this.message = 'Please enter a valid email address';
                return;
                }
                 if(this.loginForm.password ==  '') {
                 this.message = 'Please enter password';
                 return;
                 }
                if (this.loginForm.email.length > 0 && this.loginForm.password.length > 0){ 
                    axios.post('/api/login', this.loginForm)
                        .then((res) => { 
                            //this.message = res.data.data;
                            this.token=res.data.data.api_token;
                            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                            axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
                            localStorage.setItem('user-token', this.token);
                            localStorage.setItem('user_id', res.data.data.id);
                            localStorage.setItem('type', res.data.data.type);
                            localStorage.setItem('is_profile_complete', res.data.data.is_profile_complete);
                            if (res.data.data.is_profile_complete == 1){
                                window.location.href = '/';
                            }else{
                                this.$store.commit('SET_IS_LOGGED_IN', this.token);
                                
                                if(res.data.data.type==2){
                                    window.location.href = '/host/dashboard';
                                }else{
                                    if(localStorage.getItem('coming-location') == 'booking'){
                                    //window.location.href = localStorage.getItem('bookingUrl');
                                    $('#loginmodal').modal('toggle');
                                    $('#loginNavmodal').hide();
                                    $('#signUpNavmodal').hide();
                                    $('#userIcon').css('display','block');
                                    $('#usserInnerIcon').css('display','block');
                                    }else{
                                       window.location.href = '/user/setting';
                                    }
                                   
                                }
                            }
                        })
                        .catch((err) => { 
                            this.message = err.response.data.message;
                           
                        });
                }else{
                    this.message = 'Please full fill all requirements.';
                }
                   
            },
             validateEmail() {
             if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.loginForm.email)) {
                this.message = '';
             }else{
                 this.message = 'Please enter a valid email address';
                 return
             }
             },
             resetPasswordEmail(){
                 $('#loginmodal').modal('toggle');
                  this.$router.push({ path: "/send-email-for-reset-password" });
                   
              }
             
        }
    }
window.fbAsyncInit = function() {
    FB.init({
      appId      : '636914027572379',
      cookie     : true,
      xfbml      : true,
      version    : 'v13.0'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));    
</script>

<style scoped>
   
</style> 

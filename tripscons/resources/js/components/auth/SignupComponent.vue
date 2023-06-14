<template>
<main>
    <div class="modal fade" id="signupmodal" role="dialog" aria-labelledby="signupmodalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
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
                            <div id="errorMessage" style="color:red" >{{ message }}</div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-7 col-md-7">
                                <div class="checkout-form mt-4">
                                    <form>
                                        <div class="form-group  mt-4">
                                            <input type="email" v-model="signupForm.email"
                                                class="form-control input_field"
                                                placeholder="E-mail" @keyup="validateEmail" autocomplete="off" value="">
                                        </div>
                                        <div class="form-group  mt-4">
                                            <input type="text" v-model="signupForm.name"
                                                class="form-control input_field"
                                                placeholder="Name" autocomplete="off" value="">
                                        </div>
                                        <div class="form-group  mt-4">
                                            <input type="password" v-model="signupForm.password"
                                                class="form-control input_field"
                                                placeholder="Password" autocomplete="off" value="">
                                        </div>
                                        <div class="form-group  mt-4">
                                            <input type="password" v-model="signupForm.c_password"
                                                class="form-control input_field"
                                                placeholder="Confirm password" autocomplete="off" value="">
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
                    <div class="row px-4 pb-3">
                        <div class="col-12 col-sm-7">
                            <button class="btn btn-blackk mt-5 pl-4" @click="signupUser" >Sign up!</button>
                                    <!-- Modal -->
                            
                        </div>
                        <div class="col-12 col-sm-5">
                            <div class="login-title mt-4">
                                <p> Already have acount? </p>
                            </div>
                            <button class="btn btn-whitee mt-1" data-dismiss="modal" data-toggle="modal" data-target="#loginmodal">Log in</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="profilemodal"  role="dialog" aria-labelledby="profilemodalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content container p-5">
                <div class="modal-header">
                        <div class="login-title ">
                            <p>Let`s create your profile</p>
                        </div>
                </div>
                <div class="modal-body px-5">
                    <div class="form-check " >
                        <input class="form-check-input" type="radio" name="type" value="0" id="tarveler" 
                        v-model="type" checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                            As Traveler
                        </label>
                    </div>
                    <div class="form-check ">
                        <input class="form-check-input" type="radio" value="1" name="type" id="Business" 
                        v-model="type">
                        <label class="form-check-label" for="flexRadioDefault2">
                            As Service Provider
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="type" id="Service" 
                        v-model="type">
                        <label class="form-check-label" for="flexRadioDefault2">
                            As Host
                        </label>
                    </div>
                    <div class="d-flex justify-content-around mt-5">
                        <a class="btn btn-closee" href="/account_info">Later</a>
                        <a class="btn btn-create" @click="updateAccount">Create</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    
</main>
</template>

<script>
   // import $ from 'jquery'
    export default {
        name: "SignupComponent",
        data() {
            return {
                signupForm: {
                    name: '',
                    email: '',
                    password: '',
                    c_password: '',
                    device_type:'web',
                    type:0
                },
                type:0,
                message:''
                 
            }
        },
        created(){

        },
        methods: {
          
            signupUser() {
            if(this.signupForm.email ==  '') {
             this.message = 'Please enter a valid email address';
             return;
            }
            if(this.signupForm.name ==  '') {
             this.message = 'Please enter name';
             return;
            }
            if(this.signupForm.password ==  '') {
             this.message = 'Please enter password';
             return;
            }
            if(this.signupForm.c_password ==  '') {
             this.message = 'Please enter conform password';
             return;
            }
                if (this.signupForm.password == this.signupForm.c_password) {
                    if (this.signupForm.name.length > 0 && this.signupForm.email.length > 0 && this.signupForm.password.length > 0) {
                        axios.post('/api/register', this.signupForm)
                            .then((res) => {
                                this.token=res.data.data.api_token;
                                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                                axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
                                localStorage.setItem('user-token', this.token);
                                localStorage.setItem('user_id', res.data.data.id);
                                localStorage.setItem('type', res.data.data.type);
                                localStorage.setItem('is_profile_complete', res.data.data.is_profile_complete);
                                $("#signupmodal").modal('hide');
                                window.jQuery($('#profilemodal')).modal('show');
                                
                                if (res.data.data.type == 0){
                                    // window.location.href = '/account_info';
                                }else{
                                    //window.location.href = '/host/account_info'
                                }
                                // }, 1500);
                            })
                            .catch((err) => {
                                  this.message = err.response.data.message;
                            });
                    } else{
                        this.message = 'Full fill all requirements.';
                    } 
                } else{
                     this.message = 'Passwords should be same';
                }
            },
            validateEmail() {
                
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.signupForm.email)) {
                this.message = '';
             }else{
                 this.message = 'Please enter a valid email address';
                 return
             }
             },
             
            updateAccount() {
                let typeForm = new FormData();
                typeForm.append("type", this.type);
                //console.log(typeForm);
                axios.post('/api/updateUser', typeForm)
                .then((res) => {
                    localStorage.setItem('type', res.data.data.type);
                    if (res.data.data.type == 0){
                        if(localStorage.getItem('coming-location') == 'booking'){
                         $('#profilemodal').modal('toggle');
                         //$('#loginmodal').modal('toggle');
                                    $('#loginNavmodal').hide();
                                    $('#signUpNavmodal').hide();
                                    $('#userIcon').css('display','block');
                                    $('#usserInnerIcon').css('display','block');
                   
                         }else{
                          //window.location.href = '/user/setting';
                          window.location.href = '/account_info';
                        }
                        
                    }else if (res.data.data.type == 1){
                        window.location.href = '/account_info';
                    }else{
                        window.location.href = '/host/dashboard'
                    }
                })
                .catch((err) => {
                    // console.log(err);
                    this.message = err.response.data.message;
                });
            },
            //     validatePassword(){

            //      if(this.signupForm.password == this.signupForm.c_password){
            //        this.message = '';
            //       }else{
            //       this.message = 'Passwords should be same'; 
            //     return
            //      }
            //  },
                
        },
        
    }
</script>

<style scoped>

</style>

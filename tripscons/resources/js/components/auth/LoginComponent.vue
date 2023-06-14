<template>
<main>
<div class="main-login">
      <div class="login-container">
          <div class="card-information">
              <div class="payment-title">
                  <h2> Log in </h2>
              </div>
              <div id="errorMessage" style="color:red" >{{ message }}</div>
          </div>
                  <div class="checkout-form mt-4">
                      <form @click="clearMessage()">
                          <div class="form-group  mt-4">
                                <input  id="email" type="email" name="email" required
                                    class="form-control input_field" v-model="loginForm.email"
                                    placeholder="E-mail" @keyup="validateEmail">
                            </div>
                            <div class="form-group  mt-4">
                                <input id="password" name="password" required  type="password"
                                    class="form-control input_field" v-model="loginForm.password" v-on:keyup.enter="enterClicked"
                                    placeholder="Password">
                            </div>
                      </form>
                      <div class="forget-pass mt-4">
                          <a href="">Forgot your password?</a>
                      </div>
                  </div>
                  <div class="card-information mt-3">
                      <div class="payment-title">
                          <h2> Log in with </h2>
                      </div>
                  </div>
                  <div
                      class="mt-4  d-flex  loginpatterns">
                      <div class="">
                         <a href="login/facebook">
                                        <img src="/assets/img/fb.png" class="img-fluid" alt=""
                                            srcset=""></a>
                      </div>
                      <div class="">
                          <a href="login/google">
                                        <img src="/assets/img/g1.png" class="img-fluid" alt=""
                                            srcset=""></a>
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
                            <button class="btn btn-whitee mt-1" data-dismiss="modal" data-toggle="modal" data-target="#signupmodal">Sign up</button>
                        </div>
                    </div>
      
      </div>
    </div>
</main>
    
</template>

<script>
    export default {
        name: "LoginComponent",
        data() {
            return {
                loginForm: {
                    email: '',
                    password: '',
                    'device_type':'web'
                },
                message:''
            }
        },
        methods: {
            enterClicked(){      
              this.$refs.btnLogin.click();
              //this.message = '';
            },
            clearMessage(){
                this.message = '';
            },
            loginUser() {
              
                
                if (this.loginForm.email.length > 0 && this.loginForm.password.length > 0){ 
                    axios.post('/api/login', this.loginForm)
                        .then((res) => {
                           
                            this.token=res.data.data.api_token;
                            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                            axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
                            localStorage.setItem('user-token', this.token);
                            localStorage.setItem('user_id', res.data.data.id);
                            localStorage.setItem('type', res.data.data.type);
                            localStorage.setItem('is_profile_complete', res.data.data.is_profile_complete);
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
                            this.message = 'Credentials does not exist.';//err'';
                           
                        });
                }else{
                    this.message = 'Please Full fill all requirements.';
                }
                   
            },
           
        }
    }
</script>

<style scoped>
    .swal-overlay  
{
    z-index: 9999999 !important    
}
</style>

<template>
    <main>
        <div class="login-sec">
            <div class="container">
                <div class="login2-panel">
                    <div class="login-holder">
                        <img src="/assets/img/logo_white.png" alt="logo"/>
                    </div>
                    <form>
                        <div class="form-group">{{message}}
                            <label for="email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" id="email" v-model="sendEmailForm.email" @keypress="validateEmail">
                        </div>
                        <div class="submit-btn">
                            <button type="button" @click="sendEmailForResetPassword" class="btn btn-whitee ">
                                Send Email
                            </button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        name: "ForgetPasswordComponent",
        data() {
            return {
                sendEmailForm: {
                    email: '',
                    message:'',
                }
            }
        },
        methods: {
            sendEmailForResetPassword() {
                 if (this.email == "") {
                this.$swal({
                type: "error",
                title: "Error!",
                text: "Please input email",
                timer: 2500,
                });
                return;
                }
                if (this.confirm_password == "") {
                this.$swal({
                type: "error",
                title: "Error!",
                text: "Please input confirm password",
                timer: 2500,
                });
                return;
                }
                 let bodyFormData = new FormData();
                  bodyFormData.append("email", this.sendEmailForm.email);
                 if (this.sendEmailForm.email.length > 0)
                    axios.post('/api/sendEmailForResetPassword',bodyFormData)
                        .then((res) => {
                        this.$router.push({ path: "/thanku/"+ this.sendEmailForm.email });
                      //  window.location.href = '/thanku/' + this.sendEmailForm.email;
                        })
                        .catch((err) => {
                            
                            this.$swal({
                                type: 'warning',
                                title: 'Sorry!',
                                text: err.response.data.message,
                                timer: 2500
                            });
                        });
                else
                    this.$swal({
                        type: 'warning',
                        title: 'Sorry!',
                        text: 'Please, enter the email.',
                        timer: 2500
                    });
            },
            validateEmail() {
                
             if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.sendEmailForm.email)) {
                this.message = '';
             }else{
                 this.message = 'Please enter a valid email address';
                 return
             }
        },
        }
    }
</script>

<style scoped>

</style>

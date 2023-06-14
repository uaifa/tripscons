<template>
    <main>
        <div class="login-sec">
            <div class="container">
                <div class="login2-panel">
                    <div class="login-holder">
                        <img src="/assets/img/logo_white.png" alt="logo"/>
                    </div>
                    <form>
                        <div class="form-group mt-4">
                            <label for="password" class="bmd-label-floating">New Password</label>
                            <input type="password" class="form-control" id="email" v-model="password" v-min-length="8">
                        </div>
                        <div class="form-group">
                            <label for="password" class="bmd-label-floating">Confirm Password</label>
                            <input type="password" class="form-control" id="email" v-model="confirm_password"
                            v-min-length="8">
                        </div>
                        <div class="submit-btn ">
                            <button type="button" @click="resetPassword" class="btn mt-3 btn-whitee btn-raised">
                                Reset Password
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
                user_id:'',
                verification_code:'',
                password:'',
                confirm_password:'',
            }
        },
        methods: {
            resetPassword() {
                if (this.password == "") {
                this.$swal({
                type: "error",
                title: "Error!",
                text: "Please input password",
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
                if (this.confirm_password != this.password) {
                this.$swal({
                type: "error",
                title: "Error!",
                text: "Please make sure both passwords are same",
                timer: 2500,
                });
                return;
                }
                if (this.password.length < 8) {
                this.$swal({
                type: "error",
                title: "Error!",
                text: "Please make sure password atleast 8 chracters",
                timer: 2500,
                });
                return;
                }
                if (this.confirm_password.length < 8) {
                this.$swal({
                type: "error",
                title: "Error!",
                text: "Please make sure confirm password atleast 8 chracters",
                timer: 2500,
                });
                return;
                }
                this.user_id = this.$route.params.id;
                this.verification_code = this.$route.params.token;
                let bodyFormData = new FormData();
                bodyFormData.append("user_id", this.user_id);
                bodyFormData.append("verification_code", this.verification_code);
                bodyFormData.append("password", this.password);
                bodyFormData.append("confirm_password", this.confirm_password);
               
                axios.post("/api/updateForgotPassword", bodyFormData).then((response) => {  
                    
                if(response.status == 200) {
                this.$swal({
                type: "success",
                title: "Success!",
                text: response.data.message,
                timer: 2500,
                });
                this.$router.push({ path: "/" });
                }
                }).catch((err) => {
                this.$swal({
                type: "error",
                title: "Error!",
                text: err.response.data.message,
                timer: 2500,
                });
                return;    
                
                });
              
                    
            }
        }
    }
</script>

<style scoped>

</style>

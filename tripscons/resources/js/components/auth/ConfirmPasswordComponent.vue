<template>
    <main>
        <div class="login-sec">
            <div class="container">
                <div class="login2-panel">
                    <div class="login-holder">
                        <img src="/public/basic/img/logo.gif" alt="logo"/>
                    </div>
                    <form>
                        <div class="form-group">
                            <label for="password" class="bmd-label-floating">Password</label>
                            <input type="password" class="form-control" id="password" v-model="resetPassword.password">
                        </div>

                        <div class="form-group">
                            <label for="c_password" class="bmd-label-floating">Password</label>
                            <input type="password" class="form-control" id="c_password"
                                   v-model="resetPassword.c_password">
                        </div>
                        <div class="submit-btn text-center">
                            <button type="button" @click="updatePassword" class="btn btn-primary btn-raised">Reset
                                Password
                            </button>
                        </div>
                    </form>
                </div>
                <div class="login-now text-center">
                    <p>Already have Tripscon Account? <a href="signup">Sign Up</a></p>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        name: "ConfirmPasswordComponent",
        data() {
            return {
                resetPassword: {
                    password: '',
                    c_password: '',
                    user_id:'',
                    token: ''
                }
            }
        },
        created() {
            var url = window.location.href.split('/');
            if (url.length > 0){
               this.resetPassword.user_id=url[5];
               this.resetPassword.token=url[6];
            }
        },
        methods: {
            updatePassword() {
                if (this.resetPassword.password.length > 0 && this.resetPassword.c_password.length > 0)
                    if (this.resetPassword.password == this.resetPassword.c_password)
                        axios.post('/forgot/password/updatePassword', this.resetPassword)
                            .then((res) => {
                                this.$swal({
                                    type: 'success',
                                    title: 'Congrats!',
                                    text: 'Password updated.',
                                    timer: 2500
                                });
                                setTimeout(function () {
                                    window.location.href = '/login';
                                }, 2500);
                            })
                            .catch((err) => {
                                console.log(err)
                            });
                    else
                        this.$swal({
                            type: 'warning',
                            title: 'Sorry!',
                            text: 'Please, Enter the same password.',
                            timer: 2500
                        });
                else
                    this.$swal({
                        type: 'warning',
                        title: 'Sorry!',
                        text: 'Please, Enter both passwords.',
                        timer: 2500
                    });

            }
        }
    }
</script>

<style scoped>

</style>

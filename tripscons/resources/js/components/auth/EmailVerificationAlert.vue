<template>
<!--    <div class="fixed">-->
<!--        <a class="verify-email-fixed" style="color: white" href="javascript:void(0)">Verify Email</a>-->
<!--    </div>-->
    <div class="col-md-12 col-sm-12">
        <div v-show="showAlert" :class="'alert tc-alert-'+classAlert" role="alert" >
            <div>Your Email Not Verified Yet. <a href="javascript:void(0)"
                                                 style="font-weight: bold;text-decoration: underline;font-size: 18px;"
                                                 v-on:click="sendEmailForVerification">Verify</a></div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "EmailVerificationAlert",
        data() {
            return {
                classAlert: 'danger',
                showAlert: 0,
                loggedInUser: '',
            }
        },
        mounted() {
            this.$helpers.getCurrentUserData(data => {
                this.loggedInUser = data.user;
                if (this.loggedInUser) {
                    if (this.loggedInUser.verified == 1) {
                        this.showAlert = 0;
                    } else {
                        this.showAlert = 1;
                    }
                }
            });
        },
        methods: {
            sendEmailForVerification() {
                this.$swal({
                    type: 'success',
                    title: 'Congrats!',
                    text: 'Verification email sent to you.',
                    timer: 2500
                });
                this.showAlert = 0;
                axios.get('/user/sendVerificationEmail')
                    .then(res => {
                    })
                    .catch(err => {
                        console.log(err);
                    });
            }
        }
    }
</script>

<style scoped>
    /*.fixed {*/
    /*    position: fixed;*/
    /*    background: #f83d23;*/
    /*    width: 100px;*/
    /*    height: 40px;*/
    /*    display: flex;*/
    /*    justify-content: center;*/
    /*    align-items: center;*/
    /*    box-shadow: 0 0 6px #000;*/
    /*    color: #fff;*/
    /*    z-index: 99999;*/
    /*}*/

    .tc-alert-danger{
        margin:20px;
        text-align: center;
        background: #ffffff;
        /*border: 1px solid #ff4e4ea6;*/
        border-radius: 11px;
        box-shadow:  0px 0px 9px 0px grey;
        color:black;
        font-size: 16px;
    }
    .tc-alert-info{
        margin: 10px;
        text-align: center;
        background: #ffffff;
        border: 1px solid #c0c7c3;
        border-radius: 11px;
        box-shadow: #ccd1ce 0px 0px 7px 4px;
        color: black;
        font-size: 16px;
    }

</style>

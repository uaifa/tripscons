<template>
  <main> <div class="login-sec"> <div class="container"> <div class="thnkyou-panel"> <h1><span>Thank You</span></h1> <div class="img-holder"> <img src="/assets/img/thnk-icon.png" alt="Image"> </div> <div class="email-body"> <p>We have sent an email to {{email}} </p> <small>Please click in the link in the email to verify and log into your Tripscon account (if you have not received an email, check the "spam" folder Or, click here to resend)</small> </div> </div> <div class="login-now text-center"> <p>Already have Tripscon Account? <a href="#">Login</a></p> </div> </div> </div> </main>
</template>

<script>
export default {
  name: "Thanku",
  data() {
    return {
      email: "",
    }; 
  },
  created() {
      
   this.email = this.$route.params.email;
},
 
};
</script>

<style scoped>
</style>

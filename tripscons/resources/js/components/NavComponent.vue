<template>
<div>
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
            <a class="nav-link" href="http://tripscon-community.wanologicalsolutions.com/" target="_blank">Community</a>
          </li>

          <template v-if="isLoggedIn==null">
          <li class="nav-item" id="loginNavmodal">
              <a class="nav-link" href="#" data-toggle="modal" data-target="#loginmodal">Login </a>
          </li>
          <li class="nav-item" id="signUpNavmodal">
              <a class="nav-link" href="#" data-toggle="modal" data-target="#signupmodal">Sign Up</a>
          </li>
          </template>

          <li class="nav-item">
            <div  class="header-buttons">
                <a class="nav-link btn btn-white ripple" type="button" data-toggle="modal" data-target="#add-services">Add Services</a>
                <a class="nav-link" href="#">Hosts Listings</a>
            </div>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="#"><span class="select-lang"><img src="/assets/img/flag-1.png" alt="language" /></span></a>
          </li> -->
          
          <li class="nav-item" :style="isLoggedIn!=null ? 'display:block' : 'display:none'" id="userIcon">
            <a id="usserInnerIcon" :style="type != 1 && type != 2 && type==0 ? 'display:block' : 'display:none'" lass="nav-link"  :href=" path=='/user/setting' ? '#' :'/user/setting'"><span class="nav-profile-image"><img src="/assets/img/prof.png"
                        alt="Profile" /></span></a>
            <a v-if="type==1" class="nav-link" :href=" path=='/user/setting' ? '#' :'/user/setting'"><span class="nav-profile-image"><img src="/assets/img/prof.png"
                        alt="Profile" /></span></a>
            <a  v-if="type==2" class="nav-link" :href=" path =='/host/dashboard' ? '#' :'/host/dashboard'"><span class="nav-profile-image"><img src="/assets/img/prof.png"
                        alt="Profile" /></span></a>
           
                   
        </li>
      
        </ul>
      </div>
    </div>
  </nav>
</header>
<add-service />
</div>



</template>
<script>
import AddService from './models/AddService.vue';
export default {
  mode: "history",
  components: { AddService },
  name:'navComponent',
  data() {
        return {
            type:0,
            is_profile_complete:0,
            path:'',
        }
    },
 created(){
    this.path = window.location.pathname
  },
  computed: {
   
   isLoggedIn() {
     this.type = window.localStorage.getItem("type");
     this.is_profile_complete = window.localStorage.getItem("is_profile_complete");
     return window.localStorage.getItem("user-token");
  }
},

  methods:{
        handleLogout(){
            localStorage.removeItem('user-token');
            localStorage.removeItem('type');
            this.$router.push('/user-login');
          }
        }
  }

</script>

 <style>

  </style>

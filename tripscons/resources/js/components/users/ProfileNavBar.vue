<template>
    <div class="profile-steps">
      <ul class="d-flex justify-content-around">
        <li class="">
          <img src="/assets/img/icons/feed.png" />
          <p>
            <router-link :to="{ path: '/account_info' }"
              >Personal info
            </router-link>
          </p>
        </li>
        <li class="" v-if="type!=2 && type!=1">
          <img src="/assets/img/icons/intrests.png" />
          <p>
            <router-link :to="{ path: '/user/interests' }"
              >Interests</router-link
            >
          </p>
        </li>
        <li class="" v-if="type==1">
          <img src="/assets/img/icons/intrests.png" />
          <p>
            <router-link :to="{ path: '/user/about' }"
              >About</router-link
            >
          </p>
        </li>

        <li class="">
          <img src="/assets/img/icons/ident.png" />
          <p>
            <router-link :to="{ path: '/user/identification' }"
              >Identification</router-link
            >
          </p>
        </li>
      </ul>
    </div>
</template>



<script>

export default {
    data(){
        return {
            type: 0,
        }
    },
    created() {
        this.type = localStorage.getItem("type");
    },
}
</script>

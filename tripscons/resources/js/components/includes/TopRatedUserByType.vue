<template>
    <!--why chose End-->
    <div class="guide-sec top-guide" v-if="users">
        <div class="explore-services-sec" style="margin: 12px;">
            <h2>Top Rated {{type}}'s</h2>
<!--            <small>Find best accommodations in the town.</small>-->
        </div>
        <div class="container">
            <div id="mate-slider" class="owl-carousel owl-theme">
                <div class="item" v-for="(user,index) in users" :key="index">
                    <div class="guide-box">
                        <div class="guide-img-holder">
                            <img :src="$helpers.getSplitAvatarByKey(user.avatar,'url')" alt="guide"/>
                            <div :class="type=='guide' && user.hourly_rate ? 'guide-price' : 'guide-price visibility-hide'">
                                <span><a href="#">${{ type=='guide' && user.hourly_rate ? user.hourly_rate :0}}/<sub>Hour</sub></a></span>
                            </div>
                        </div>
                        <div class="guide-content-holder">
                            <div class="row">
                                <div class="col-xs-7 col-sm-7">
                                    <strong class="name-guide"><a
                                        :href="'/show/'+type+'/profile/'+user.username">{{user.name}}</a></strong>
                                </div>
                                <div class="col-xs-5 col-sm-5">
                                    <div class="verify-tag">
                                        <i class="fa fa-check-circle"></i><span>Verified</span>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-sm-7">
                                    <small class="guide-city">{{user.city+','+user.country}}</small>
                                    <div class="feedback-itm">
                                        <ul class="feedback-star">
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><span class="total-feedback">({{user.id}})</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-5 ">
                                    <!--                                    <a href="javascript:void (0)" data-toggle="modal"-->
                                    <!--                                       @click="changeUser(user)" data-target="#send-message"-->
                                    <!--                                       class="btn btn-md see-more-btn">Contact</a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TopRatedUserByType",
        props: ['user_type', 'country_name',],
        data() {
            return {
                type: this.user_type,
                users: {},
                sendMessageTo: '',

            }
        },
        created() {
            axios.get('/getTopRated/' + this.type)
                .then(res => {
                    this.users = res.data.users;
                })
                .catch(err => {
                    console.log(err);
                });

        },
        methods: {
            // changeUser(user) {
            //     this.sendMessageTo = user;
            //     // this.messageForm.lblCaptcha = Math.random().toString(36).substr(5, 6);
            // },
        }

    }
</script>

<style scoped>

    .visibility-hide {
        visibility: hidden;
    }
</style>

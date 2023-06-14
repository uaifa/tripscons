<template>
    <main>
        <div class="profile-sec">
            <div class="container">
                <div class="profile-panel ">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active " id="tab_basic" data-toggle="tab"
                                       href="#trips_tab">
                                        Trips
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="trips_tab">
                                    <trips-operator-trips
                                        :login_user="loggedInUser"
                                    ></trips-operator-trips>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        name: "TripOperatorServices",
        props: ['login_user'],
        data() {
            return {
                loggedInUser: this.login_user,
            }
        }
    }
</script>

<style scoped>
    .nav-tabs .nav-link.active {
        border-bottom: 3px #10cb67 solid;
        color: #0fca67;
    }
</style>

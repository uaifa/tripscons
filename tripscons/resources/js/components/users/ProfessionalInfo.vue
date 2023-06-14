<template>
    <main>
        <div class="profile-sec">
            <div class="container">
                <div class="profile-panel ">
                    <div v-if="errors" v-for="(error,index) in errors" :key="index" class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Error! </strong>{{error[0]}}
                    </div>
<!--                    <h1><span class="color-green">{{user.name}},Tell us</span> about your skills:</h1>-->
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="tag_line" class="bmd-label-floating">Tag Line <b class="b-req">*</b> <i class="fa fa-info-circle" title="Best taglines always help businesses to convey what they’re trying to offer,"></i></label>
                                        <input type="text" class="form-control count_words" id="tag_line" name="tag_line" maxlength="100" placeholder="100 Characters"
                                               v-model="professionalForm.tagLine">
                                    </div>
                                </div>
                            </div>

                            <!--about me-->
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="about" class="bmd-label-floating">About me <b class="b-req">*</b></label>
                                        <textarea class="form-control count_words" rows="10" id="about" name="about"
                                                  placeholder="250 words"
                                                  v-model="professionalForm.about"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!--select languages-->
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="multi-languages" class="bmd-label-floating"><b>My Languages  <b class="b-req">*</b></b></label>
                                        <multiselect id="multi-languages" class="select-box-sh"
                                                     v-model="professionalForm.selectedLanguages"
                                                     tag-placeholder="Select Language"
                                                     placeholder="Select Language" label="name" track-by="id"
                                                     :options="optionsLanguages"
                                                     :multiple="true" :taggable="true"
                                                     @tag="addLanguage"></multiselect>
                                    </div>
                                </div>
                            </div>

                            <!--   select activities-->
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-sm-12 col-md-12" >
                                    <div class="form-group">
                                        <label for="multi-activities-pro" class="bmd-label-floating"><b>Select Activities <b class="b-req">*</b> </b></label>
                                        <multiselect id="multi-activities-pro" class="select-box-sh"
                                                     v-model="professionalForm.selectedActivities"
                                                     tag-placeholder="Select Activity"
                                                     placeholder="Select Activity" label="name" track-by="id"
                                                     :options="optionsActivities" :multiple="true" :taggable="true"
                                                     @tag="addActivity"></multiselect>
                                    </div>
                                </div>
                            </div>

<!--                            hourly rate-->
                            <div class="row" style="margin-top:10px;"
                                 v-if=" user.role_id==8 || user.role_id==9 ">
                                <!--                                <div class="col-xs-6 col-sm-6">-->
                                <!--                                    <div class="form-group phone-input">-->
                                <!--                                        <label for="currency" class="bmd-label-floating">Currency</label>-->
                                <!--                                        <select class="custom-select" id="currency" name="currency"-->
                                <!--                                                v-model="professionalForm.currency_id">-->
                                <!--                                            <option v-show="allCurrencies[0]"-->
                                <!--                                                    v-for="(currency, index) in allCurrencies[0]"-->
                                <!--                                                    :key="index"-->
                                <!--                                                    :value="currency.id">{{currency.prefix+' '+currency.code}}-->
                                <!--                                            </option>-->
                                <!--                                        </select>-->
                                <!--                                    </div>-->
                                <!--                                </div>-->

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group phone-input">
                                        <label for="hourly_rate" class="bmd-label-floating">Hourly Rate in (USD
                                            $)</label>
                                        <input type="number" min="0" style="padding-right:0px" class="form-control"
                                               id="hourly_rate" name="hourly_rate"
                                               v-model="professionalForm.hourly_rate">
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6"
                                     v-show="user.role_id==8 || user.role_id==9">
                                    <div class="form-group phone-input">
                                        <label for="hourly_rate" class="bmd-label-floating">Per Day Rate in (USD
                                            $)</label>
                                        <input type="number" min="0" style="padding-right:0px" class="form-control"
                                               id="per_day_rate" name="hourly_rate"
                                               v-model="professionalForm.per_day_rate">
                                    </div>
                                </div>
                            </div>

                            <!--  Video Maker-->
                            <div v-show=" user.role_id==9">
                                <div class="row"
                                     style="margin-top: 20px;"
                                     v-show="allPhotographerSkills">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="multi-skills" class="bmd-label-floating"><b>Photographer
                                                Skills <b class="b-req">*</b></b></label>
                                            <multiselect id="multi-skills" class="select-box-sh"
                                                         v-model="professionalForm.selectedSkills"
                                                         tag-placeholder="Select Photographer Skills"
                                                         placeholder="Select Photographer Skills" label="name"
                                                         track-by="id"
                                                         :options="allPhotographerSkills" :multiple="true"
                                                         :taggable="true"
                                                         @tag="addSkill"></multiselect>
                                        </div>
                                    </div>
                                </div>

                                <div class="row"
                                     style="margin-top: 20px;"
                                     v-show="allPhotographerTypes">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="multi-types" class="bmd-label-floating"><b>Photographer
                                                Types <b class="b-req">*</b></b></label>
                                            <multiselect id="multi-types" class="select-box-sh"
                                                         v-model="professionalForm.selectedTypes"
                                                         tag-placeholder="Select Photographer Types"
                                                         placeholder="Select Photographer Types" label="name"
                                                         track-by="id"
                                                         :options="allPhotographerTypes" :multiple="true"
                                                         :taggable="true"
                                                         @tag="addType"></multiselect>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- For Visa Consultant-->
                            <div v-show="user.role_id==6">
                                <div class="row" v-show="allCountries">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="multi-countries" class="bmd-label-floating"><b>Select
                                                Countries <b class="b-req">*</b></b></label>
                                            <multiselect id="multi-countries" class="select-box-sh"
                                                         v-model="professionalForm.selectedCountries"
                                                         tag-placeholder="Select Countries"
                                                         placeholder="Select Countries" label="name"
                                                         track-by="id"
                                                         :options="allCountries" :multiple="true"
                                                         :taggable="true"
                                                         @tag="addCountry"></multiselect>
                                        </div>
                                    </div>
                                </div>


                            </div>

<!--                            select knowledge cities-->
                            <div class="row" style="margin-top: 20px;"
                                 v-show=" user.role_id==9 ">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="multi-selectedKnowledgeCities" class="bmd-label-floating"><b>Select Area of knowledge <b class="b-req">*</b></b></label>
                                        <multiselect id="multi-selectedKnowledgeCities" class="select-box-sh"
                                                     v-model="professionalForm.selectedKnowledgeCities"
                                                     tag-placeholder="Select Area of knowledge"
                                                     placeholder="Select Area of knowledge" label="name" track-by="id"
                                                     :options="knowledgeCities"
                                                     :multiple="true" :taggable="true"
                                                     @tag="addKnowledgeCity"></multiselect>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="banner-btn text-right mt-50">
                                <a href="javascript:void(0)" id="btn-save-professional-info"
                                   class="btn btn-md search-btn-now ripple" style="float: right;"
                                   @click="updateProfessionalInfo">Save & Continue</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    Vue.component('multiselect', Multiselect);

    export default {
        name: "ProfessionalInfo",
        props: ['user', 'all_activities', 'all_languages', 'user_activities', 'user_languages'],
        components: {
            Multiselect
        },
        data() {
            return {
                allActivities: this.all_activities,
                allLanguages: this.all_languages,
                allCountries: [],
                selectedUserLanguages: this.user_languages,
                selectedUserActivities: this.user_activities,
                optionsActivities: [],
                optionsLanguages: [],
                allCurrencies: [],
                knowledgeCities:[],
                professionalForm: {
                    userId: this.user.id,
                    about: this.user.about,
                    tagLine: this.user.tag_line,
                    selectedActivities: [],
                    currency_id: this.user.currency_id,
                    hourly_rate: this.user.hourly_rate ? this.user.hourly_rate : 0,
                    per_day_rate: this.user.per_day_rate ? this.user.per_day_rate : 0,
                    selectedLanguages: [],
                    selectedSkills: [],
                    selectedTypes: [],
                    selectedCountries: [],
                    selectedKnowledgeCities:[],
                },
                errors: {},
                currentLoggedInUserData: [],
                allPhotographerSkills: [],
                allPhotographerTypes: [],
            }
        },
        mounted() {
            if (this.allActivities.length > 0) {
                this.allActivities.forEach((act, index) => {
                    this.optionsActivities.push({
                        name: act.name,
                        id: act.id
                    });
                })
            }
            if (this.allLanguages.length > 0) {
                this.allLanguages.forEach((lang, index) => {
                    this.optionsLanguages.push({
                        name: lang.name,
                        id: lang.id
                    })
                });
            }

            if (this.selectedUserActivities.length > 0) {
                this.selectedUserActivities.forEach((act, index) => {
                    this.professionalForm.selectedActivities.push({
                        name: act.name,
                        id: act.id
                    });
                })
            }
            if (this.selectedUserLanguages.length > 0) {
                this.selectedUserLanguages.forEach((lang, index) => {
                    this.professionalForm.selectedLanguages.push({
                        name: lang.name,
                        id: lang.id
                    })
                });
            }

            this.$helpers.getCurrentUserData(data => {
                this.currentLoggedInUserData = data;
                if (this.currentLoggedInUserData) {
                    if (this.currentLoggedInUserData.user.role_id == 5 || this.currentLoggedInUserData.user.role_id == 9) {
                        // photographer
                        var photographerSkills = this.currentLoggedInUserData.photographer_skills;
                        var photographerTypes = this.currentLoggedInUserData.photographer_types;

                        if (photographerSkills.length) {
                            photographerSkills.forEach(skill => {
                                this.professionalForm.selectedSkills.push(skill)
                            })
                        }
                        if (photographerTypes.length) {
                            photographerTypes.forEach(type => {
                                this.professionalForm.selectedTypes.push(type)
                            })
                        }
                    } else if (this.currentLoggedInUserData.user.role_id == 6) {
                        // visa consultant
                        var visaConsultantCountries = this.currentLoggedInUserData.visa_consultant_countries;
                        if (visaConsultantCountries.length) {
                            visaConsultantCountries.forEach(country => {
                                this.professionalForm.selectedCountries.push(country)
                            })
                        }
                    }
                }
            });

            this.$helpers.getAllCurrencies(currency => {
                this.allCurrencies.push(currency)
            });

            this.$helpers.getAllCountries(countries => {
                this.allCountries = countries;
            });

            this.$helpers.getAllPhotographerSkills(skills => {
                this.allPhotographerSkills = skills;
            });

            this.$helpers.getAllPhotographerTypes(types => {
                this.allPhotographerTypes = types;
            });

            this.$helpers.getAllCitiesOfUserCountry(this.user.id,cities=>{
               this.knowledgeCities = cities;
            });

            this.$helpers.getAllKnowledgeCities(this.user.id,cities=>{
                if (cities){
                    cities.forEach(knowledge=>{
                        this.professionalForm.selectedKnowledgeCities.push(knowledge.city);
                    })
                }
            });
        },
        methods: {
            addCountry(newTag) {
                const tag = {
                    name: newTag,
                    id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                };
                this.allCountries.push(tag);
                this.professionalForm.selectedCountries.push(tag)
            },
            addKnowledgeCity(newTag) {
                const tag = {
                    name: newTag,
                    id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                };
                this.knowledgeCities.push(tag);
                this.professionalForm.selectedKnowledgeCities.push(tag)
            },
            addType(newTag) {
                const tag = {
                    name: newTag,
                    id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                };
                this.allPhotographerTypes.push(tag);
                this.professionalForm.selectedTypes.push(tag)
            },
            addSkill(newTag) {
                const tag = {
                    name: newTag,
                    id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                };
                this.allPhotographerSkills.push(tag);
                this.professionalForm.selectedSkills.push(tag)
            },
            addActivity(newTag) {
                const tag = {
                    name: newTag,
                    id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                };
                this.optionsActivities.push(tag);
                this.professionalForm.selectedActivities.push(tag)
            },
            addLanguage(newTag) {
                const tag = {
                    name: newTag,
                    id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                };
                this.optionsLanguages.push(tag);
                this.professionalForm.selectedLanguages.push(tag)
            },
            updateProfessionalInfo() {
                var res = this.$helpers.wordsLenghtCheck(250,this.professionalForm.about);
                if(!res.success){
                    this.$swal({
                        type: 'error',
                        title: 'Sorry!',
                        text: 'Please, You can describe yourself only under 250 words.',
                        timer: 2500
                    });
                    return false;
                }

                this.$helpers.isLoading(true);
                axios.post('/user/update/professional/info', this.professionalForm)
                    .then((res) => {
                        this.$helpers.isLoading(false);
                        // this.$swal({
                        //     type: 'success',
                        //     title: 'Congrats!',
                        //     text: res.data.message,
                        //     timer: 2500
                        // });
                        this.errors = {};
                        // if (jQuery('.pages_tab .nav-link.active').parent('.nav-item').next().find('a').length) {
                        //     if (this.user.is_host == 1) {
                        //         jQuery('.pages_tab .nav-link.active').parent('.nav-item').next().find('a').click();
                        //     } else if (jQuery('.pages_tab .nav-link.active').parent('.nav-item').next().next().find('a').length) {
                        //         jQuery('.pages_tab .nav-link.active').parent('.nav-item').next().next().find('a').click();
                        //     }
                        // }
                        this.$emit('expertise_update', res.data.user);

                        // Move to next tab
                        // if (jQuery('.pages_tab .nav-link.active').parent('.nav-item').next().find('a').length) {
                        //     jQuery('.pages_tab .nav-link.active').parent('.nav-item').next().find('a').click();
                        // }

                    })
                    .catch((err) => {
                        console.log(err);
                        this.$helpers.isLoading(false);
                        if (err.response.status = 422 && err.response.data.errors) {
                            this.errors = err.response.data.errors;
                        }
                    })
            }
        },
        watch:{
            'professionalForm.about':function() {
                var res = this.$helpers.wordsLenghtCheck(250,this.professionalForm.about);
                if(!res.success){
                    this.$swal({
                        type: 'error',
                        title: 'Sorry!',
                        text: 'Please, You can describe your self in 250 words',
                        timer: 2500
                    });
                }
            }

        }
    }
</script>

<style scoped>
    .multiselect {
        box-sizing: inherit;
    }
</style>

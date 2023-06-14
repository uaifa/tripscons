module.exports = {
    /**
     * @Description Avatar Object split by key name
     *
     * @param avatar
     * @param key
     * @returns {string}
     *
     * @Author Khuram Qadeer.
     */
    getSplitAvatarByKey: (avatar = null, key) => {
        var res = '/basic/img/default-img.png';
        if (avatar) {
            var file = JSON.parse(avatar);
            if (file[key].length) {
                res = file[key];
                // res = key=='url' ? file[key].replace('localhost','localhost:8000'):file[key];
            }
        }
        return res;
    },

    /**
     * @Description get Domain name
     * @returns {string}
     * @Author Khuram Qadeer.
     */
    getDomainName: () => {
        return (new URL(window.location)).origin;
    },

    /**
     * @Description Get Primary Image from images array
     *
     * @param images
     * @param key
     * @returns {string}
     *
     * @Author Khuram Qadeer.
     */
    getPrimaryImageFromArrayByKey: (images = null, key) => {
        var res = '/basic/img/default-img.png';
        if (images) {
            var files = JSON.parse(images);
            files.forEach((file, index) => {
                if (file['primary'] && file['primary'] == 1) {
                    if (file[key].length) {
                        res = file[key];
                        return false;
                    }
                }
            })
        }
        return res;
    },


    /**
     * @Description We are using this route for drop zone first response its just fake for drop zone
     * @returns {string}
     * @Author Khuram Qadeer.
     */
    getDropZoneResponseUrlFake: () => {
        return (new URL(window.location)).origin + "/uploadImagePreviousTrips";
    },

    /**
     * @Description Get Month Name
     * @param $monthNumber
     * @returns {*}
     *
     * @Author Khuram Qadeer.
     */
    getMonthName: ($monthNumber) => {
        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];
        return monthNames[$monthNumber];
    },
    defaultStartDate: ()  => {
        const date = new Date();
        date.setDate(date.getDate() + 1);
        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear();
        if (day < 10) {
          day = "0" + day;
        }
        if (month < 10) {
          month = "0" + month;
        }
        return  `${year}-${month}-${day}`;
      
      },
      defaultEndDate: () => {
        const date = new Date();
        date.setDate(date.getDate() + 2);
        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear();
        if (day < 10) {
          day = "0" + day;
        }
        if (month < 10) {
          month = "0" + month;
        }
       return `${year}-${month}-${day}`;
       
      },
      oldDateDisabled: () => {
        
        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();
        var minDate = year + '-' + month + '-' + day;
        return minDate;   
      },
      futureDateDisabled: () => {
        
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();

        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;     
        return maxDate;
      },
      userAuth: () => {
        
        const auth = localStorage.getItem('user-token');
        return   { headers: {"Authorization" : `Bearer ${auth}`} }
      
     },


    /**
     * @Description Get Agenda Format Days wise
     *
     * @param agendasArray
     * @returns {[]|Array}
     *
     * @Author Khuram Qadeer.
     */
    getAgendaDayFormat: (agendasArray) => {
        allAgendas = [];
        if (agendasArray) {
            agendasArray.forEach((agenda, index) => {
                if (allAgendas.length > 0) {
                    var dayNumberExist = true;
                    allAgendas.forEach((allAgenda, i) => {
                        if (allAgenda.dayNumber == agenda.day) {
                            dayNumberExist = false;
                            allAgenda.activities.push({
                                time: agenda.time,
                                description: agenda.description,
                                location: agenda.location ? JSON.parse(agenda.location) : ''
                            });
                        }
                    });
                    if (dayNumberExist) {
                        allAgendas.push({
                            dayNumber: agenda.day,
                            activities: [
                                {
                                    time: agenda.time,
                                    description: agenda.description,
                                    location: agenda.location ? JSON.parse(agenda.location) : ''
                                }
                            ]
                        });
                    }
                } else {
                    allAgendas.push({
                        dayNumber: agenda.day,
                        activities: [
                            {
                                time: agenda.time,
                                description: agenda.description,
                                location: agenda.location ? JSON.parse(agenda.location) : ''
                            }
                        ]
                    });
                }
            })
        }
        return allAgendas;
    },

    /**
     * @Description Get All Activities By Request
     * @param callBack callBack
     * @Description
     */
    getAllActivities: (callBack) => {
        axios.get('/getAllActivities')
            .then(res => {
                callBack(JSON.parse(res.data.activities));
            })
            .catch(err => {
                callBack(err);
            });
    },

    /**
     * @Description Get Logged in user State of its country
     * @Function callBack
     * @param callBack
     */
    getLoggedInUserStatesOfCountry: (callBack) => {
        axios.get('/user/getLoggedInUserStatesOfCountry')
            .then(res => {
                callBack(JSON.parse(res.data.states))
            })
            .catch(err => {
                console.log(err);
            });
    },

    /**
     * @Description Get Logged in user cities of its state
     * @Function callBack
     * @param callBack
     */
    getLoggedInUserCitiesOfState: (callBack) => {
        axios.get('/user/getLoggedInUserCitiesOfState')
            .then(res => {
                callBack(JSON.parse(res.data.cities))
            })
            .catch(err => {
                console.log(err);
            });
    },

    /**
     * @Description Get All Currencies
     * @Function callBack
     * @param callBack
     */
    getAllCurrencies: (callBack) => {
        axios.get('/user/getAllCurrencies')
            .then(res => {
                callBack(JSON.parse(res.data.currencies))
            })
            .catch(err => {
                console.log(err);
            });
    },

    /**
     * @Description Get Current User Data
     * @param callBack callBack
     */
    getCurrentUserData: (callBack) => {
        axios.get('/user/getCurrentUserData')
            .then(res => {
                callBack(JSON.parse(res.data.data))
            })
            .catch(err => {
                console.log(err);
            });
    },

    /**
     * @Description Get All Data by User id
     *
     * @param userId
     * @param callBack callBack
     *
     * @Author Khuram Qadeer.
     */
    getUserData: (userId, callBack) => {
        axios.get('/user/getUserData/' + userId)
            .then(res => {
                callBack(JSON.parse(res.data.data))
            })
            .catch(err => {
                console.log(err);
            });
    },

    /**
     * @Description Get Auth Check Or User Logged in or not
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAuthCheck: (callBack) => {
        axios.get('/user/getAuthCheck')
            .then(res => {
                callBack(JSON.parse(res.data.data))
            })
            .catch(err => {
                console.log(err);
            });
    },
    /**
     * @Description Get All Facilities
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllFacilities: (callBack) => {
        axios.get('/user/getAllFacilities')
            .then(res => {
                callBack(res.data.facilities)
            })
            .catch(err => {
                console.log(err);
            });
    },

    /**
     * @Description Get All Languages
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllLanguages: (callBack) => {
        axios.get('/user/getAllLanguages')
            .then(res => {
                callBack(res.data.languages)
            })
            .catch(err => {
                console.log(err);
            });
    },

    /**
     * @Description Get All Availabilities
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllAvailabilities: (callBack) => {
        axios.get('/user/getAllAvailabilities')
            .then(res => {
                callBack(res.data.availabilities)
            })
            .catch(err => {
                console.log(err);
            });
    },

    getAllAmenities: (callBack) => {
        axios.get('/user/getAllAmenities')
            .then(res => {
                callBack(res.data.amenities);
            })
            .catch(err => {
                console.log(err);
            });
    },

    /**
     * @Description Get meals
     * @param callBack callBack
     * @Author Khuram Qadeer.
     */
    getAllMeals: (callBack) => {
        axios.get('/user/getAllMeals')
            .then(res => {
                callBack(res.data.meals)
            })
            .catch(err => {
                console.log(err);
            });
    },

    /**
     * @Description Get all countries
     * @param callBack callBack
     * @Author Khuram Qadeer.
     */
    getAllCountries: (callBack) => {
        axios.get('/user/getAllCountries')
            .then(res => {
                callBack(res.data.countries)
            })
            .catch(err => {
                console.log(err);
            });
    },

    /**
     * @Description get all photographer skills
     * @param callBack callBack
     * @Author Khuram Qadeer.
     */
    getAllPhotographerSkills: (callBack) => {
        axios.get('/user/getAllPhotographerSkills')
            .then(res => {
                callBack(res.data.skills)
            })
            .catch(err => {
                console.log(err);
            });
    },

    /**
     * @Description get all photographer skills
     * @param callBack callBack
     * @Author Khuram Qadeer.
     */
    getAllPhotographerTypes: (callBack) => {
        axios.get('/user/getAllPhotographerTypes')
            .then(res => {
                callBack(res.data.types)
            })
            .catch(err => {
                console.log(err);
            });
    },

    /**
     * @Description Get Distance between 2 lattitude and longitude in KM and N
     *
     * @param lat1
     * @param lon1
     * @param lat2
     * @param lon2
     * @param unit
     * @param callBack callBack
     *
     * @Author Khuram Qadeer.
     */
    getDistanceByLatitudeAndLongitude(lat1, lon1, lat2, lon2, unit, callBack) {
        if ((lat1 == lat2) && (lon1 == lon2)) {
            callBack(0);
        } else {
            var radlat1 = Math.PI * lat1 / 180;
            var radlat2 = Math.PI * lat2 / 180;
            var theta = lon1 - lon2;
            var radtheta = Math.PI * theta / 180;
            var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
            if (dist > 1) {
                dist = 1;
            }
            dist = Math.acos(dist);
            dist = dist * 180 / Math.PI;
            dist = dist * 60 * 1.1515;
            if (unit == "K" || unit == 'k') {
                dist = dist * 1.609344
            } else if (unit == "N" || unit == 'n') {
                dist = dist * 0.8684
            }
            callBack(dist);
        }
    },
    /**
     * @Description Get Age from birthday
     * @param dateString
     * @returns {number}
     * @Author Khuram Qadeer.
     */
    getAge(dateString) {
        var today = new Date();
        var birthDate = new Date(dateString);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    },

    /**
     * @Description Get All Accommodations types
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllAccommodationTypes(callBack) {
        axios.get('/getAllAccommodationTypes')
            .then(res => {
                // handle success
                callBack(res.data.types);
            })
            .catch(err => {
                // handle error
                console.log(err);
            })
    },
    /**
     * @Description Get All Accommodation Sub types
     * @param typeId
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllAccommodationSubTypes(typeId, callBack) {
        axios.get('/getAllAccommodationSubTypes/' + typeId)
            .then(res => {
                // handle success
                callBack(res.data.types);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },
    /**
     * @Description Get All Safety Amenities By Accommodation Type
     * @param type
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllSafetyAmenitiesByType(type, callBack) {
        axios.get('/getAllSafetyAmenitiesByType/' + type)
            .then(res => {
                // handle success
                callBack(res.data.amenities);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },
    /**
     * @Description Get All Beds Types
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllBedsType(callBack) {
        axios.get('/getAllBedsType')
            .then(res => {
                // handle success
                callBack(res.data.types);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },
    /**
     * @Description Get All About Accommodation Question
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllAboutAccommodationQuestions(callBack) {
        axios.get('/getAllAboutAccommodationQuestions')
            .then(res => {
                // handle success
                callBack(res.data.questions);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },
    /**
     * @Description Get All Share Accommodation things
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllShareAccommodations(callBack) {
        axios.get('/getAllShareAccommodations')
            .then(res => {
                // handle success
                callBack(res.data.places);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },
    /**
     * @Description Get All Vehicle
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllVehicles(callBack) {
        axios.get('/getAllVehicles')
            .then(res => {
                // handle success
                callBack(res.data.vehicles);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },

    /**
     * @Description Get All city of user country
     * @param userId
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllCitiesOfUserCountry(userId, callBack) {
        axios.get('/getAllCitiesOfUserCountry/' + userId)
            .then(res => {
                // handle success
                callBack(res.data.cities);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },
    /**
     * @Description Get All knowledge Cities
     * @param userId
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllKnowledgeCities(userId, callBack) {
        axios.get('/getAllKnowledgeCities/' + userId)
            .then(res => {
                // handle success
                callBack(res.data.cities);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },

    /**
     * @Description jquery loader show and hide
     * @param isLoading
     * @Author Khuram Qadeer.
     */
    isLoading(isLoading) {
        $.LoadingOverlaySetup({
            imageColor: "#2ad4b7"
        });
        if (isLoading) {
            $.LoadingOverlay("show");
        } else {
            $.LoadingOverlay("hide");
        }
    },
    /**
     * @Description Get all near by places list
     * @param callBack
     * @Author Khuram Qadeer
     */
    getAllNearByPlacesList(callBack) {
        axios.get('/user/getAllNearByPlacesList')
            .then(res => {
                // handle success
                callBack(res.data.places);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },
    /**
     * @Description get All Guide Skills
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllGuideSkills(callBack) {
        axios.get('/user/getAllGuideSkills')
            .then(res => {
                // handle success
                callBack(res.data.skills);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },
    /**
     * @Description Get Trip Categories
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllTripCategories(callBack) {
        axios.get('/user/getAllTripCategories')
            .then(res => {
                // handle success
                callBack(res.data.categories);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },
    /**
     * @Description Get all trip types
     * @param categoryId
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllTripTypes(categoryId, callBack) {
        axios.get('/user/getAllTripTypes/' + categoryId)
            .then(res => {
                // handle success
                callBack(res.data.types);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },

    /**
     * @Description Get all visa consultant types
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAllVisaConsultantTypes(callBack) {
        axios.get('/user/getAllVisaConsultantTypes')
            .then(res => {
                // handle success
                callBack(res.data.types);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },

    /**
     * @Desription words count
     * @param limit
     * @param data
     * @Author Khuram Qadeer.
     */
    wordsLenghtCheck(limit, data) {
        var res = [];
        var words = data.split(/[\s]+/);
        if (words.length > limit) {
            res = {
                success: false,
                limit: limit,
                words: words.length,
            }
        } else {
            res = {
                success: true,
                limit: limit,
                words: words.length,
            }
        }
        return res;
    },

    /**
     * @Description Get Vue google complete location array convert to as a string text
     * @param location
     * @returns {string}
     * @Author Khuram Qadeer.
     */
    getVueGoogleCompleteAddress(location) {
        return location ? location.locality + ',' + location.administrative_area_level_1 + ',' + location.country : '';
    },

    /**
     * @Description initilizesMDTimepicker
     * @Author Khuram Qadeer.
     */
    initilizesMDTimepicker() {
        $(document).ready(function () {
            $('.timepicker').mdtimepicker(); //Initializes the time picker
        });
    },

    /**
     * @Description Count Days from dates
     * @param dateFrom
     * @param dateTo
     * @returns {number}
     * @Author Khuram Qadeer.
     */
    getDaysByDates(dateFrom, dateTo) {
        var date1 = new Date(dateFrom);
        var date2 = new Date(dateTo);
        // To calculate the time difference of two dates
        var DifferenceInTime = date2.getTime() - date1.getTime();
        // To calculate the no. of days between two dates
        return DifferenceInTime / (1000 * 3600 * 24) + 1;
    },

    /**
     * @Description get all dates sets in whick sit available
     * @param availableId
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAvailableDatesByAvailabilityId(availableId, callBack) {
        axios.get('/user/getAvailableDatesByAvailabilityId/' + availableId)
            .then(res => {
                // handle success
                callBack(res.data.dates);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },

    /**
     * @Description Get Available dates by available id and group size that's user want
     * @param availableId
     * @param $requiredGroupSize
     * @param callBack
     * @Author Khuram Qadeer.
     */
    getAvailableDatesByAvailabilityIdAndGroupSize(availableId, $requiredGroupSize, callBack) {
        axios.get('/user/getAvailableDatesByAvailabilityIdAndGroupSize/' + availableId + '/' + $requiredGroupSize)
            .then(res => {
                // handle success
                callBack(res.data.dates);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },

    /**
     * @Description Get all list of hours in AM PM
     * @returns {[]}
     * @Author Khuram Qadeer.
     */
    getHoursList($halfHourRequire = false) {
        const locale = 'en'; // or whatever you want...
        const hours = [];
        moment.locale(locale);  // optional - can remove if you are only dealing with one locale
        for (let hour = 0; hour < 24; hour++) {
            hours.push(moment({hour}).format('h:mm A'));
            if ($halfHourRequire) {
                hours.push(
                    moment({
                        hour,
                        minute: 30
                    }).format('h:mm A')
                );
            }
        }
        return hours;
    },

    /**
     * @Description Get Hours List by start to end time
     * @param startTime
     * @param endTime
     * @returns {[]}
     * @Author Khuram Qadeer.
     */
    getHoursBetweenTwoTimes(startTime, endTime, $halfHourRequire = false) {
        const locale = 'en'; // or whatever you want...
        const hours = [];
        const betweenHours = [];
        moment.locale(locale);  // optional - can remove if you are only dealing with one locale
        for (let hour = 0; hour < 24; hour++) {
            hours.push(moment({hour}).format('h:mm A'));
            if ($halfHourRequire) {
                hours.push(
                    moment({
                        hour,
                        minute: 30
                    }).format('h:mm A')
                );
            }
        }

        if (hours) {
            hours.forEach((hour, index) => {
                if (Date.parse('01/01/2020 ' + hour) >= Date.parse('01/01/2020 ' + startTime)
                    && Date.parse('01/01/2020 ' + hour) <= Date.parse('01/01/2020 ' + endTime)) {
                    betweenHours.push(hour)
                }
            });
        }

        return betweenHours;
    },

    /**
     * @Description Get count hours number by start time and end time
     * @param startTime
     * @param endTime
     * @returns {number}
     * @Author Khuram Qadeer.
     */
    getHoursCountByTimes(startTime, endTime) {
        var timeStart = new Date(((moment('2020/01/01').format("YYYY-MM-DD")) + " " + startTime));
        var timeEnd = new Date(((moment('2020/01/01').format("YYYY-MM-DD")) + " " + endTime));
        var diffHours = Math.abs(timeStart - timeEnd) / 36e5;
        return diffHours;
    },

    getGuideBookingDisabledDates(guideUserId, callBack) {
        axios.get('/user/getGuideBookingDisabledDates/' + guideUserId)
            .then(res => {
                // handle success
                callBack(res.data.dates);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },


    getGuidePackageDisabledDatesByIdAndGroupSize(packageId, $requiredGroupSize, callBack) {
        axios.get('/user/getGuidePackageDisabledDatesByIdAndGroupSize/' + packageId + '/' + $requiredGroupSize)
            .then(res => {
                // handle success
                callBack(res.data.dates);
            })
            .catch(err => {
                // handle error
                console.log(err);
            });
    },


}; // End Helpers

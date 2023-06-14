/**
 * @Description mdtimepicker js
 * @Author Khuram Qadeer.
 */
$(document).ready(function () {
    $('.timepicker').mdtimepicker(); //Initializes the time picker
});
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36251023-1']);
_gaq.push(['_setDomainName', 'jqueryscript.net']);
_gaq.push(['_trackPageview']);

(function () {
    var ga = document.createElement('script');
    ga.type = 'text/javascript';
    ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);
})();

// end mdtimepicker js

/**
 * @Description Show service popup for this
 * @param element
 * @Author Khuram Qadeer.
 */
function makeServiceProvider(element) {
    var current_user = JSON.parse($('#current_user').val());
    var type = $(element).attr('data-type');
    var text = $(element).text();

    if (current_user.is_profile_complete == 1) {
        // Add Services
        if (type == 'services') {
            if (text.toLowerCase().trim() == 'become a company') {
                makeCompany(current_user.id, '/services/company');
            } else if (current_user.is_company == 1) {
                window.location.href = '/services/company';
            } else if (current_user.is_company == 0) {
                // user already company
                window.location.href = '/services/individual';
            } else {

                // if (current_user.role_id != 0 && current_user.role_id != '' && current_user.role_id != null) {
                //     alert('Please, you cannot add more than two services as individual , for more services you should as a company.');
                // } else {
                //     window.location.href = '/services/individual';
                // }

                if (current_user.role_id != 0 && current_user.role_id != '' && current_user.role_id != null) {
                    $('#individual-radio').removeClass('div-disable');
                    $('#individual-radio').addClass('div-disable');
                    $('#service_company_question_error_msg').html('  <div class="col-sm-12 col-md-12">  <div   class="alert alert-danger">  <button type="button" class="close" data-dismiss="alert">x</button>          <p>Please, you cannot add more than two services as individual , for more services you should as a company</p> </div>');
                    $('#service_company_question_error_msg').show();
                }
                $('#service_company_question').modal('show');

            }
        } else if (type == 'host') {
            // make a host if is not
            makeHost(current_user.id, '/user/setting');
        }
    } else {
        window.location.href = '/user/setting';
    }

}

/**
 * @Description User become as a company or individual
 * @Author Khuram Qadeer.
 */
function userAsCompanyOrIndividual() {
    var current_user = JSON.parse($('#current_user').val());


    if ($('#radio-individual').is(':checked')) {
        makeIndividual(current_user.id, '/services/individual');
        // if (current_user.is_company == 0) {
        //     // user is individual
        //     if (current_user.role_id == 0 || current_user.role_id == '' || current_user.role_id == null
        //         || current_user.second_role_id == 0 || current_user.second_role_id == '' || current_user.second_role_id == null) {
        //         // user have limit to add another role
        //         window.location.href = '/services/individual';
        //     } else {
        //         $('#individual-radio').removeClass('div-disable');
        //         $('#individual-radio').addClass('div-disable');
        //         $('#service_company_question_error_msg').html('  <div class="col-sm-12 col-md-12">  <div   class="alert alert-danger">  <button type="button" class="close" data-dismiss="alert">x</button>          <p>Please, you cannot add more than two services as individual , for more services you should as a company</p> </div>');
        //         $('#service_company_question_error_msg').show();
        //     }
        // } else if (current_user.is_company == 1) {
        //     // user already company
        //     window.location.href = '/services/company';
        // }
    } else if ($('#radio-company').is(':checked')) {
        // company
        makeCompany(current_user.id, '/services/company');
    } else {
        alert('Please, choose one.')
    }
}

/**
 * @Description make a host
 * @param userId
 * @Author Khuram Qadeer.
 */
function makeHost(userId, successUrl = null) {
    $.ajax({
        type: "GET",
        url: '/make/host/' + parseInt(userId),
        data: {},
        success: function (res) {
            if (successUrl) {
                window.location.href = successUrl;
            } else {
                window.location.reload();
            }
        }
    });
}

/**
 * @Description make a company to user
 * @param userId
 * @param successUrl
 * @Author Khuram Qadeer.
 */
function makeCompany(userId, successUrl = null) {
    $.ajax({
        type: "GET",
        url: '/make/company/' + userId,
        data: {},
        success: function (res) {
            if (successUrl) {
                window.location.href = successUrl;
            } else {
                window.location.reload();
            }
        }
    });
}

/**
 * @Description Make Individual
 * @param userId
 * @param successUrl
 * @Author Khuram Qadeer.
 */
function makeIndividual(userId, successUrl = null) {
    $.ajax({
        type: "GET",
        url: '/make/individual/' + userId,
        data: {},
        success: function (res) {
            if (successUrl) {
                window.location.href = successUrl;
            } else {
                window.location.reload();
            }
        }
    });
}

/**
 * @Description Youtube slider
 * @Author Khuram Qadeer.
 */
$(document).ready(function() {
    $("#youtube-slider").owlCarousel({
        nav: true,
        items: 2,
        loop: true,
        margin: 0,
        lazyLoad:true,
        dots: false,
        margin:20,
        autoplay:false,
        smartSpeed:450,
        responsive:{
            0:{
                items:2,
                nav:true
            },
            600:{
                items:2,
                nav:false
            },
            1000:{
                items:2,
                nav:true,
                loop:false
            }
        }
    });


// get a quote
    $("#custom-trip-slider").owlCarousel({
        nav: true,
        items: 4,
        loop: true,
        margin: 0,
        lazyLoad:true,
        dots: false,
        margin:10,
        autoplay:false,
        smartSpeed:450,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:3,
                nav:false
            },
            1000:{
                items:4,
                nav:true,
                loop:false
            }
        }
    });

});




// var card = new Card({
//     form: '.form-card',
//     container: '.card-wrapper',

//     formSelectors: {
//         nameInput: 'input[name="full-name"]'
//     }
// });

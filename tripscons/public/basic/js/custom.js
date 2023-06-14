$(document).ready(function() {
  $("#owl-demo").owlCarousel({
    navigation : true,
    items:3,
    autoplay:true,
    animateOut: 'slideOutDown',
    animateIn: 'flipInX',
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
            items:3,
            nav:true,
            loop:false
        }
    }
  });
});
/*---Testimotionals---*/
$(document).ready(function() {
  $("#Testi-slider").owlCarousel({
    navigation : true,
    items:1,
    autoplay:true,
    smartSpeed:450,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:1,
            nav:false
        },
        1000:{
            items:1,
            nav:true,
            loop:false
        }
    }
  });
});
/*---Guides Slider---*/
$(document).ready(function() {
  $("#guides-slider").owlCarousel({
    navigation : true,
    items:1,
    autoplay:true,
    smartSpeed:450,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:3,
            nav:true
        }
    }
  });
});
$(document).ready(function() {
  $("#company-slider").owlCarousel({
     nav: true,
    items: 4,
    loop: true,
    margin: 0,
    lazyLoad:true,
    dots: false,
    margin:20,
    autoplay:true,
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

$(document).ready(function() {
  $("#guide-slider").owlCarousel({
    nav: true,
    items: 4,
    loop: true,
    margin: 0,
    lazyLoad:true,
    dots: false,
    margin:20,
    autoplay:true,
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
$(document).ready(function() {
  $("#Organizers-slider").owlCarousel({
    nav: true,
    items: 3,
    loop: true,
    margin: 0,
    lazyLoad:true,
    dots: false,
    margin:20,
    autoplay:true,
    smartSpeed:450,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:2,
            nav:false
        },
        1000:{
            items:3,
            nav:true,
            loop:false
        }
    }
  });
});
$(document).ready(function() {
    $("#categories-slider").owlCarousel({
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
//Make sure that the dom is ready
$(function () {

  $("#rateYo").rateYo({
    rating: 4.2,
    starWidth: "30px",
multiColor: {

  "startColor": "#FF0000", //RED
  "endColor"  : "#d45729"  //GREEN
 }

  });

});
//second rating star
    //rating js
//Make sure that the dom is ready
$(function () {

  $("#rateYo1").rateYo({
    rating: 4.2,
    starWidth: "21px",
multiColor: {

  "startColor": "#FF0000", //RED
  "endColor"  : "#d45729"  //GREEN
 }

  });

});
//3rd rating star
    //rating js
//Make sure that the dom is ready
$(function () {

  $(".rateYo2").rateYo({
    rating: 4.2,
    starWidth: "15px",
multiColor: {

  "startColor": "#FF0000", //RED
  "endColor"  : "#d45729"  //GREEN
 }

  });

});
//scrollable
$(function() {

jcf.replaceAll();

});
$( function() {
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");

    if (output){
        output.innerHTML = slider.value;
        slider.oninput = function() {
            output.innerHTML = this.value;
        }
    }
} );

$('body').bootstrapMaterialDesign();
$(document).ready(function() {
  $("#customer-slider").owlCarousel({
    navigation : true,
    items:1,
    autoplay:true,
    smartSpeed:450,
  });
});
//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').click(function(e){
  e.preventDefault();

  fieldName = $(this).attr('data-field');
  type      = $(this).attr('data-type');
  var input = $("input[name='"+fieldName+"']");
  var currentVal = parseInt(input.val());
  if (!isNaN(currentVal)) {
      if(type == 'minus') {

          if(currentVal > input.attr('min')) {
              input.val(currentVal - 1).change();
          }
          if(parseInt(input.val()) == input.attr('min')) {
              $(this).attr('disabled', true);
          }

      } else if(type == 'plus') {

          if(currentVal < input.attr('max')) {
              input.val(currentVal + 1).change();
          }
          if(parseInt(input.val()) == input.attr('max')) {
              $(this).attr('disabled', true);
          }

      }
  } else {
      input.val(0);
  }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {

    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());

   var name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
});
$(".input-number").keydown(function (e) {
  // Allow: backspace, delete, tab, escape, enter and .
  if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
       // Allow: Ctrl+A
      (e.keyCode == 65 && e.ctrlKey === true) ||
       // Allow: home, end, left, right
      (e.keyCode >= 35 && e.keyCode <= 39)) {
           // let it happen, don't do anything
           return;
  }
  // Ensure that it is a number and stop the keypress
  if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      e.preventDefault();
  }
});

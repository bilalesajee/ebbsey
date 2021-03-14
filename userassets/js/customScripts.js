jQuery(document).ready(function () {

    if (jQuery('.bannerCarousel').length > 0) {
        jQuery('.bannerCarousel').owlCarousel({
            items: 1,
            animateOut: 'fadeOut',
            loop: true,
            margin: 10,
            nav: false,
            pagination: false,
            dots: false,
            autoplay: true,
            mouseDrag: false
        });
    }
    if (jQuery('.trainer_slider').length > 0) {
        jQuery('.trainer_slider').owlCarousel({
            items: 1,
            animateOut: 'fadeOut',
            loop: true,
            margin: 10,
            nav: true,
            navText: ['', ''],
            pagination: false,
            dots: false,
            autoplay: true,
            mouseDrag: false
        });
    }

    /****Mobile toggle btn for edit profile tabs*****/
    jQuery('.edit_profile_tabs .nav a').click(function () {
        jQuery('.edit_profile_tabs').toggleClass('activetab');
    });
    jQuery('.mobile_edit_profile_tab_head .back').click(function () {
        jQuery('.edit_profile_tabs').toggleClass('activetab');
    });
    /****Mobile toggle btn for edit profile tabs*****/


    /****Mobile menu toggle *****/
    jQuery('.menu_button').click(function () {
        jQuery('.mobile_menu_wrap').toggleClass('open-menu');
    });
    /****Mobile menu toggle END *****/

    /**** Passes Package info button for mobile *****/
    jQuery('.mobile_info_button').click(function () {
        jQuery(this).parent('.info_wrap').find('.info').slideToggle();
        jQuery(this).find('span').toggle();
    });
    /****  Passes Package info button for mobile  *****/


    $('.search_result .fa-times-circle').click(function () {
        $(this).parents('.search_result').find('.eb-form-control').val('');
        $(this).hide();
        $("#filter_chat_users").trigger('keyup');
    });

    jQuery('.search_result .eb-form-control').keyup(function () {
        var closeicon = jQuery(this).parents('.search_result').find('.fa-times-circle');
        if (jQuery(this).val().length > 0) {
            closeicon.show();
        } else {
            closeicon.hide();
        }
    });

    jQuery('.upload_gallery .profile_gallery .image').click(function () {
        var selected_img = jQuery(this).parents('li').find('.image').css('backgroundImage');
        jQuery('.profile_pic .image').css({'backgroundImage': selected_img});
    });

    jQuery('.day-box input[type="radio"]').click(function () {
        jQuery('.day-box').removeClass('element-selected');
        jQuery(this).parent('.day-box').addClass('element-selected');
    });

    jQuery('.time-period input[type="radio"]').click(function () {
        jQuery('.time-period .block').removeClass('element-selected');
        jQuery(this).parent('.block').addClass('element-selected');
    });

    jQuery('.price-plan-wrap input[type="radio"]').click(function () {
        jQuery('.price-plan-wrap').removeClass('element-selected');
        jQuery(this).parent('.price-plan-wrap').addClass('element-selected');
    });

    jQuery('.calender_popup .calender_body input[type="radio"]').click(function () {
        jQuery('.calender_popup .date_box').removeClass('element-selected');
        jQuery(this).parent('.date_box').addClass('element-selected');
    });

//    jQuery('.pay-now-section input[type="radio"]').click(function () {
//        jQuery(this).parent('.pay-now-section').toggleClass('element-selected');
//    });

    jQuery('.pay-now-section input[type="radio"]').click(function () {
        jQuery('.pay-now-section').removeClass('element-selected');
        jQuery(this).parent('.pay-now-section').addClass('element-selected');

    });

    jQuery(".chat_user_list_wrap").mCustomScrollbar({});
    jQuery(".active_chatBox").mCustomScrollbar({});
});

jQuery('.datetimepicker_default').datetimepicker();

var monthNamesTimepicker = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

var monthNamesTimepicker = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

var currentMonthTimePicker = new Date().getMonth() + 1;

jQuery('.only_time').datetimepicker({
    format: 'LT',
    minDate: currentMonthTimePicker + '/' + new Date().getDate() + '/' + new Date().getFullYear() + ' 5:30 AM',
    maxDate: currentMonthTimePicker + '/' + new Date().getDate() + '/' + new Date().getFullYear() + ' 9:31 PM'
});

jQuery('.only_time_weekend').datetimepicker({
    format: 'LT',
    minDate: currentMonthTimePicker + '/' + new Date().getDate() + '/' + new Date().getFullYear() + ' 7:00 AM',
    maxDate: currentMonthTimePicker + '/' + new Date().getDate() + '/' + new Date().getFullYear() + ' 9:31 PM'
});

jQuery('.only_date').datetimepicker({
    format: 'dddd, MMMM D, YYYY'
});




//jQuery('#startDate').datetimepicker({ 
//      pickTime: false, 
//      format: "YYYY/MM/DD", 
//      defaultDate: sd, 
//      maxDate: ed 
//    });
//  
//    jQuery('#endDate').datetimepicker({
//      pickTime: false, 
//      format: "YYYY/MM/DD", 
//      defaultDate: ed, 
//      minDate: sd 
//    });

jQuery('#startDate').datetimepicker();
jQuery('#endDate').datetimepicker({
    useCurrent: false //Important! See issue #1075
});
jQuery("#startDate").on("dp.change", function (e) {
    jQuery('#endDate').data("DateTimePicker").minDate(e.date);
});
jQuery("#endDate").on("dp.change", function (e) {
    jQuery('#startDate').data("DateTimePicker").maxDate(e.date);
});

jQuery('.show_date').datetimepicker({
    format: 'Y-M-D',
    minDate: moment()
});

jQuery('#datetimepicker13').datetimepicker({
    inline: true,
    sideBySide: true
});
jQuery.validator.addMethod("phone", function (phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, "");
    return this.optional(element) || phone_number.length > 0 &&
            phone_number.match(/^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/);
}, "Please enter a valid phone number");

jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
}, "Please enter letters only");


function showLoading() {
    jQuery.blockUI({
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: 'rgb(138, 133, 133)',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: 1,
            color: '#fff'
        }
    });
}
function hideLoading() {
    jQuery.unblockUI();
}

function getUserTimeZone() {
    var offset = (new Date()).getTimezoneOffset();

    var timezones = {
        '-12': 'Pacific/Kwajalein',
        '-11': 'Pacific/Samoa',
        '-10': 'Pacific/Honolulu',
        '-9': 'America/Juneau',
        '-8': 'America/Los_Angeles',
        '-7': 'America/Denver',
        '-6': 'America/Mexico_City',
        '-5': 'America/New_York',
        '-4': 'America/Caracas',
        '-3.5': 'America/St_Johns',
        '-3': 'America/Argentina/Buenos_Aires',
        '-2': 'Atlantic/Azores',
        '-1': 'Atlantic/Azores',
        '0': 'Europe/London',
        '1': 'Europe/Paris',
        '2': 'Europe/Helsinki',
        '3': 'Europe/Moscow',
        '3.5': 'Asia/Tehran',
        '4': 'Asia/Baku',
        '4.5': 'Asia/Kabul',
        '5': 'Asia/Karachi',
        '5.5': 'Asia/Calcutta',
        '6': 'Asia/Colombo',
        '7': 'Asia/Bangkok',
        '8': 'Asia/Singapore',
        '9': 'Asia/Tokyo',
        '9.5': 'Australia/Darwin',
        '10': 'Pacific/Guam',
        '11': 'Asia/Magadan',
        '12': 'Asia/Kamchatka'
    };

    return timezones[-offset / 60];
}

function checkAge(day, month, year) {
    day = parseInt(day);
    month = parseInt(month) - 1;
    year = parseInt(year) + 18;
    return new Date(year, month, day) <= new Date();
}

function daysInMonth(m, y) {
    switch (m) {
        case 1 :
            return (y % 4 == 0 && y % 100) || y % 400 == 0 ? 29 : 28;
        case 8 :
        case 3 :
        case 5 :
        case 10 :
            return 30;
        default :
            return 31
    }
}

function validateDate(day, month, year) {
    month = parseInt(month, 10) - 1;
    return month >= 0 && month < 12 && day > 0 && day <= daysInMonth(month, year);
}
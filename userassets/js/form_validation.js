$(document).ready(function () {
     //create class validation
     $("#creat_class_frm").validate({
        rules: {
            class_name: {
                required: true
            },
            season: {
                required: true
            },
            difficulty_level: {
                required: true
            },
            clas_type    : {
                required: true
            },
            calories    : {
                required: true
            },
            location    : {
                required: true
            },
            spot : {
                required: true
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group").addClass('has_error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group").removeClass('has_error');
        }
    });
});
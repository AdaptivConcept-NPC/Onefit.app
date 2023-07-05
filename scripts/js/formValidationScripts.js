$(document).ready(function () {
    // source: https://stackoverflow.com/questions/6800098/jquery-validation-checking-if-form-is-validated
    function runMyFunction() {

    }

    $.validateForm = function (formid) {
        if (formid.startsWith("#") == false) {
            formid = "#" + formid;
            console.log("formid: !have# " + formid);
        } else {
            console.log("formid: had# " + formid);
        }

        let form = $(formid);
        // form.removeData("validator");
        // form.removeData("unobtrusiveValidation");
        // $.validator.unobtrusive.parse(formid);

        // select validation rules based on form id
        var validationRules;
        switch (formid) {
            case "#aboutyou-info-form":
                validationRules = {
                    category_1_weight_field: {
                        required: true,
                        number: true
                    },
                    category_1_height_field: {
                        required: true,
                        number: true
                    }
                };
                break;
            case "#goalseeting-info-form":
                validationRules = {
                    'category_2_question_1_field[]': {
                        required: true,
                        minlength: 1
                    },
                    category_2_question_2_field: {
                        required: true,
                        text: true
                    },
                    category_2_question_3_field: {
                        required: true,
                        date: true
                    },
                    'category_2_question_4_field[]': {
                        required: true,
                        minlength: 1
                    },
                    'category_2_question_5_field[]': {
                        required: true,
                        maxlength: 1
                    },
                    'category_2_question_6_field[]': {
                        required: true,
                        maxlength: 1
                    },
                    'category_2_question_7_field[]': {
                        required: true,
                        maxlength: 1
                    },
                    'category_2_question_8_field[]': {
                        required: true,
                        minlength: 1
                    },
                    'category_2_question_9_field[]': {
                        required: true,
                        maxlength: 1
                    },
                    category_2_question_10_field: {
                        required: true,
                        text: true
                    },
                    category_2_question_11_field: {
                        required: true,
                        text: true
                    }
                };
                break;
            case "#fitprefs-info-form":
                validationRules = {
                    'category_3_question_1_field[]': {
                        required: true,
                        maxlength: 1
                    },
                    'category_3_question_2_field[]': {
                        required: true,
                        maxlength: 1
                    },
                    'category_3_question_3_field[]': {
                        required: true,
                        maxlength: 1
                    },
                    'category_3_question_4_field[]': {
                        required: true,
                        maxlength: 1
                    },
                    'category_3_question_5_field[]': {
                        required: true,
                        maxlength: 1
                    },
                    'category_3_question_6_field[]': {
                        required: true,
                        maxlength: 1
                    },
                    'category_3_question_7_field[]': {
                        required: true,
                        maxlength: 1
                    },
                    'category_3_question_8_field[]': {
                        required: true,
                        maxlength: 1
                    },
                    'category_3_question_9_field[]': {
                        required: true,
                        maxlength: 1
                    }
                };
                break;
            case "#tou-policy-info-form":
                validationRules = {
                    tou_user_id: {
                        required: true,
                        number: true
                    },
                    agree_terms: {
                        required: true
                    }
                };
                break;
            case "#eula-policy-info-form":
                validationRules = {
                    eula_user_id: {
                        required: true,
                        number: true
                    },
                    agree_eula: {
                        required: true
                    }
                };
                break;

            default:
                break;
        }

        let validateForm = form.validate(
            {
                /* debug: true, */
                ignore: [],
                rules: {
                    // pass validation rules
                    validationRules
                },
                success: function (label) {
                    // label.addClass("valid").text("Ok!")
                    return true;
                },
                /* submitHandler: function (e) {
                    //getting consoleerror: e.preventDefault is not a function
                    e.preventDefault();
                }, */
                showErrors: function (errorMap, errorList) {
                    var errorOutput = "[" + formid + "] \nYour form contains "
                        + this.numberOfInvalids()
                        + " errors, see details below.";
                    alert(errorOutput);
                    console.log(errorOutput);
                    this.defaultShowErrors();

                    return errorOutput;
                },
                invalidHandler: function (event, validator) {
                    // 'this' refers to the form
                    var errors = validator.numberOfInvalids();
                    if (errors) {
                        var message = errors == 1
                            ? 'You missed 1 field. It has been highlighted'
                            : 'You missed ' + errors + ' fields. They have been highlighted';
                        console.log(message);
                        alert(message);
                    }
                    /* else {
                        $("div.error").hide();
                    } */
                }
            }
        );

        // Nick Craver's answer (stackoverflow): https://stackoverflow.com/questions/4220738/jquery-validate-returning-undefined
        // https://jqueryvalidation.org/valid/
        let validateResult = validateForm.valid();
        return validateResult;
    }
});

// {
//     ignore: '',
//     /* rules: {
//         //
//     }, */
//     success: function (label) {
//         // label.addClass("valid").text("Ok!")
//         return true;
//     },
//     submitHandler: function (e) {
//         e.preventDefault();
//         return false;
//     },
//     showErrors: function (errorMap, errorList) {
//         var errorOutput = "Your form contains "
//             + this.numberOfInvalids()
//             + " errors, see details below.";
//         alert(errorOutput);
//         console.log(errorOutput);
//         this.defaultShowErrors();

//         return errorOutput;
//     }
// }
/*global $, console, alert*/
var InputValidation = function (element) {
    'use strict';

    var sArabicPattern = /^([\0-\9]|[\u0600-\u06ff]|[\u0750-\u077f]|[\ufb50-\ufbc1]|[\ufbd3-\ufd3f]|[\ufd50-\ufd8f]|[\ufd92-\ufdc7]|[\ufe70-\ufefc]|[\ufdf0-\ufdfd]|[ ])*$/g,
            sNumberPattern = /^[0-9]+$/i,
            /*check if the element is arabic string or not */
            check_arabic_string = function () {
                if (sArabicPattern.test($(element).val())) {
                    return true;
                } else {
                    return false;
                }
            },
            /*check if the element is english string or not */
            check_english_string = function () {
                if (!sArabicPattern.test($(element).val())) {
                    return true;
                } else {
                    return false;
                }
            },
            /*check if the element is empty or not */
            check_element_empty = function () {
                if ($(element).val() === '' || $(element).val() === null || $(element).val() === "") {
                    return true;
                } else {
                    return false;
                }
            },
            /*check if the element is required or not */
            check_element_required = function () {
                var bRequired = $(element).attr('required');
                if (typeof bRequired !== typeof undefined && bRequired !== false) {
                    return true;
                } else {
                    return false;
                }
            },
            /*check if the element is must be arabic string or not */
            check_arabic_required = function () {
                var bArabicRequired = $(element).attr('arabic');
                if (typeof bArabicRequired !== typeof undefined && bArabicRequired !== false) {
                    return true;
                } else {
                    return false;
                }
            },
            /*check if the element is must be english string or not */
            check_english_required = function () {
                var bEnglishRequired = $(element).attr('english');
                if (typeof bEnglishRequired !== typeof undefined && bEnglishRequired !== false) {
                    return true;
                } else {
                    return false;
                }
            },
            /*check if the element meet the validations attributes or not*/
            validate_text_input = function () {
                var sError = "";
                if (this.isRequired()) {
                    if (this.isEmpty()) {
                        sError = "هذا الحقل يجب إدخاله";
                    } else {
                        if (this.isArabic()) {
                            if (!this.isArabicString()) {
                                sError = "This field must be in Arabic Letters";
                            }
                        } else if (this.isEnglish()) {
                            if (!this.isEnglishString()) {
                                sError = "This field must be in English Letters";
                            }
                        }
                    }
                } else if (this.isArabic()) {
                    if (!this.isArabicString()) {
                        sError = "This field must be in Arabic Letters";
                    }
                } else if (this.isEnglish()) {
                    if (this.isEnglishString()) {
                        sError = "This field must be in English Letters";
                    }
                }

                return sError;
            },
            validate_number_input = function () {
                var sError = "";
                if (this.isRequired()) {
                    if (this.isEmpty()) {
                        sError = "هذا الحقل يجب إدخاله";
                    } else {
                        if (!sNumberPattern.test($(element).val())) {
                            sError = 'هذا الحقل يجب أن يكون رقم';
                        }
                    }
                }
                return sError;
            },
            validate_dropdown_input = function () {
                if (this.isRequired() && $(element).val() < 1) {
                    return 'This field is required';
                } else {
                    return '';
                }
            };

    return {
        isArabicString: check_arabic_string,
        isEnglishString: check_english_string,
        isEmpty: check_element_empty,
        isRequired: check_element_required,
        isArabic: check_arabic_required,
        isEnglish: check_english_required,
        validateTextInput: validate_text_input,
        validateDropdownInput: validate_dropdown_input,
        validateNumberInput: validate_number_input
    };
};

/*
 * display error to the form child
 * @param {string} sError
 * @param {form child} oField
 * @returns {Boolean}
 */
function appendError(sError, oField) {
    if (($($(oField).parent()).children('span')).text() !== "") {
        // if span error exist pass error to it
        $(oField).parent().find(".is-error").text(sError);
        return true;
    } else {
        // if span error not exist, create it and pass error to it
        var oSpanError = document.createElement("span");
        oSpanError.setAttribute("class", "is-error help-block help-block-error");
        oSpanError.setAttribute('style', 'opacity:1;');
        oSpanError.appendChild(document.createTextNode(sError));
        $(oField).parent().append(oSpanError);
        $(oField).parent().addClass("has-error");
        return true;
    }
}

/*
 * remove span error from the form child
 * @param {form child} oField
 * @returns {Boolean}
 */
function removeError(oField) {
    $(oField).parent().removeClass('has-error');
    ($($(oField).parent()).children('span')).remove();
    return true;
}

/*
 * if there is error, stop submit functions else run it
 * @param {Boolean} bError
 * @param {form child} oField
 * @returns {Boolean}
 */
function toggleForm(bError, oFormChild) {
    /*if there are any error stop submitation form else run it*/
    if (bError === 1) {
        $($(oFormChild).parents().find("form")).submit(function (e) {
            return false;
        });
    } else {
        $($(oFormChild).parents().find("form")).submit(function (e) {
            $(this).unbind('submit').submit();
        });
    }
}

$('.submit-button').bind('click', function () {
    'use strict';
    var aAllTextInputs = $(this).parents('form').find('input[type="text"]'),
            aAllNumberInputs = $(this).parents('form').find('input[number="number"]'),
            aAllCheckBoxes = $(this).parents('form').find('input[type="checkbox"]'),
            aAllRadioButtons = $(this).parents('form').find('input[type="radio"]'),
            aAllSelects = $(this).parents('form').find('select'),
            aAllTextAreas = $(this).parents('form').find('textarea'),
            index,
            bError = 0;
    for (index = 0; index < aAllTextInputs.length; index += 1) {
        var oInput = new InputValidation(aAllTextInputs[index]),
                sError = oInput.validateTextInput();
        if (sError !== "") {
            bError = 1;
            appendError(sError, aAllTextInputs[index]);
        } else if (($($(aAllTextInputs[index]).parent()).children('span')).text() !== "") {
            removeError(aAllTextInputs[index]);
        }
    }

    for (index = 0; index < aAllSelects.length; index += 1) {
        var oDropdown = new InputValidation(aAllSelects[index]),
                sError = oDropdown.validateDropdownInput();
        if (sError !== "") {
            bError = 1;
            appendError(sError, aAllSelects[index]);
        } else if (($($(aAllSelects[index]).parent()).children('span')).text() !== "") {
            removeError(aAllSelects[index]);
        }
    }

    for (index = 0; index < aAllNumberInputs.length; index += 1) {
        var oInput = new InputValidation(aAllNumberInputs[index]),
                sError = oInput.validateNumberInput();
        if (sError !== "") {
            bError = 1;
            appendError(sError, aAllNumberInputs[index]);
        } else if (($($(aAllNumberInputs[index]).parent()).children('span')).text() !== "") {
            removeError(aAllNumberInputs[index]);
        }
    }
    toggleForm(bError, ".submit-button");

});

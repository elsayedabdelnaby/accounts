/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    var sNumberPattern = /^[0-9]+$/i;
    $('#typeahead_example_2').attr('readonly', 'readonly');
    $('#whoList').change(function () {
        if ($(this).val() === '0') {
            $('#typeahead_example_2').attr('readonly', 'readonly');
        } else {
            $('#typeahead_example_2').removeAttr('readonly');
            $(".tt-dataset-typeahead_example_2").empty();
            $('.tt-menu').css("display", "none");
            $('#typeahead_example_2').val('');
        }
    });
    $('#typeahead_example_2').keydown(function () {
        $('.tt-menu').css("display", "block");
        var arrData,
                i = 0;
        $(".tt-dataset-typeahead_example_2").empty();
        switch ($('#whoList').val()) {
            case '1':
                $.get('instructors?val=' + $('#typeahead_example_2').val(), function (data, status) {
                    arrData = JSON.parse(data);

                    for (i = 0; i < arrData.length; i++) {
                        $(".tt-dataset-typeahead_example_2").append($('<div></div>').attr('class', 'tt-suggestion tt-selectable').text(arrData[i]['name'] + ' - ' + arrData[i]['phone']).click(function () {
                            $('#typeahead_example_2').val($(this).text());
                            $('.tt-menu').css("display", "none");
                        }));
                    }
                    if (arrData.length == 0) {
                        $('.tt-menu').css("display", "none");
                    }
                });
                break;
            case '2':
                $.get('employes?val=' + $('#typeahead_example_2').val(), function (data, status) {
                    arrData = JSON.parse(data);
                    if (typeof (arrData.length) !== 'undefined') {
                        for (i = 0; i < arrData.length; i++) {
                            $(".tt-dataset-typeahead_example_2").append($('<div></div>').attr('class', 'tt-suggestion tt-selectable').text(arrData[i]['name']).click(function () {
                                $('#typeahead_example_2').val($(this).text());
                                $('.tt-menu').css("display", "none");
                            }));
                        }
                    } else {
                        if (arrData !== false) {
                            $(".tt-dataset-typeahead_example_2").append($('<div></div>').attr('class', 'tt-suggestion tt-selectable').text(arrData['name']).click(function () {
                                $('#typeahead_example_2').val($(this).text());
                                $('.tt-menu').css("display", "none");
                            }));
                        } else {
                            $('.tt-menu').css("display", "none");
                        }
                    }
                });
                break;
            case '3':
                $.get('vendors?val=' + $('#typeahead_example_2').val(), function (data, status) {
                    arrData = JSON.parse(data);
                    if (typeof (arrData.length) !== 'undefined') {
                        for (i = 0; i < arrData.length; i++) {
                            $(".tt-dataset-typeahead_example_2").append($('<div></div>').attr('class', 'tt-suggestion tt-selectable').text(arrData[i]['name'] + ' - ' + arrData[i]['phone']).click(function () {
                                $('#typeahead_example_2').val($(this).text());
                                $('.tt-menu').css("display", "none");
                            }));
                        }
                    } else {
                        if (arrData !== false) {
                            $(".tt-dataset-typeahead_example_2").append($('<div></div>').attr('class', 'tt-suggestion tt-selectable').text(arrData['name'] + ' - ' + arrData['phone']).click(function () {
                                $('#typeahead_example_2').val($(this).text());
                                $('.tt-menu').css("display", "none");
                            }));
                        } else {
                            $('.tt-menu').css("display", "none");
                        }
                    }
                });
                break;
            case '4':
                $('.tt-menu').css("display", "none");
                break;
        }
    });
});

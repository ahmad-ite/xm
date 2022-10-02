let dateToday = new Date();

alert(111);
$("#start_data").datepicker({
    dateFormat: "mm/dd/yy'",
    numberOfMonths: 1,
    maxDate: "0d",
    onSelect: function (selectedDate) {
        var end_data = $("#end_data");
        var startDate = $(this).datepicker("getDate");
        var minDate = $(this).datepicker("getDate");
        end_data.datepicker("option", "minDate", minDate);
    },
});

$("#end_data").datepicker({
    dateFormat: "mm/dd/yy'",
    maxDate: "0d",
});

$(document).on("click", "form button[type=submit]", function (e) {
    var isValid = $("#createForm").valid();
    if (!isValid) {
        e.preventDefault(); //prevent the default action
    }
});

$(document).ready(function () {
    $("#createForm").validate({
        rules: {
            sympol: {
                required: true,
            },
            start_data: {
                required: true,
            },
            end_data: {
                required: true,
            },
            email: {
                required: true,
                email: "email:rfc,dns",
            },
        },

        messages: {
            sympol: {
                required: "Sympol is required",
            },
            start_data: {
                required: "Start date  is required",
            },
            end_data: {
                required: "End date is required",
            },
            email: {
                required: "Email is required",
                email: "Email is not valid",
            },
        },
    });
});

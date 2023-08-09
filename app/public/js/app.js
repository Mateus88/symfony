$(function () {
    $('.date').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d'
    });
});

$(".btn-search").on("click", function (event) {

    let url = $(".url-info").data('url');
    let sourceCity = $('.sourcecity').val();
    let date = $('#datevalue').val();

    if (validateParameters(sourceCity, date) === false) {
        event.stopPropagation();
        return;
    }

    $(".btn-search").attr("disabled", true);

    if ($.fn.DataTable.isDataTable('#tickets-info')) {
        $('#tickets-info').DataTable().destroy();
    }

    $('.tableresult').removeClass('d-none');
    $('.tableresult').addClass('d-block');

    let data = {
        sourceCity: sourceCity,
        date: date,
    }

    let columnDefs = [
        {
            targets: [0, 1, 2],
            orderable: false
        },
        {
            targets: 2,
            data: 'scheduledTravels',
            render: function (data, type, row, meta) {
                date = splitDate(row.departureTime.date, ' ')[0]
                urlSearchMoreDetails = $(".url-info").data('url-more-details');
                return `<a href=${urlSearchMoreDetails}?sourceCity=${row.sourceCityId}&destinationCity=${row.destinationCityId}&date=${date}>
                More Details
                </a>`;
            }
        }
    ]

    let columns = [
        { data: 'sourceCity' },
        { data: 'destinationCity' },
        { data: 'scheduledTravels' }
    ]
    createDataTableAjaxByClass('#tickets-info', url, 'get', data, columnDefs, columns);
    $(".btn-search").attr("disabled", false);
});

if ($(".tickets-info-hours").length) {

    let url = $(".ticket-info").data('url');
    let date = $(".ticket-info").data('datetravel');

    let data = {
        date: date,
    }

    let collumnsDef = [
        {
            targets: [0, 1, 2, 3, 4],
            orderable: false
        },
        {
            targets: 2,
            data: 'departureTime',
            render: function (data) {
                date = ''
                if (data.date.length > 0) {
                    date = splitDate(data.date, '.')[0]
                }
                return date

            }
        },
        {
            targets: 3,
            data: 'arrivalTime',
            render: function (data) {
                date = ''
                if (data.date.length > 0) {
                    date = splitDate(data.date, '.')[0]
                }
                return date
            }
        },
    ]

    let columns = [
        { data: 'sourceCity' },
        { data: 'destinationCity' },
        { data: 'departureTime' },
        { data: 'arrivalTime' },
        { data: 'price' },
    ]

    createDataTableAjaxByClass('#tickets-info-hours', url, 'get', data, collumnsDef, columns);
}

function validateParameters(sourceCity, date) {
    let validate = true;
    let dateRegex = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/;

    cleanError('.sourcecity', '.source-city-error');
    cleanError('#datevalue', '.date-error');


    if (sourceCity == '') {
        validate = false;
        fillError('.sourcecity', '.source-city-error', 'City is required to search');
    }

    if (date == '') {
        validate = false;
        fillError('#datevalue', '.date-error', 'Date is required to search');
    }

    if (date.length > 0 && !date.match(dateRegex)) {
        validate = false;
        fillError('#datevalue', '.date-error', 'Format is invalid (yyyy-mm-dd)');
    }

    return validate;
}

function createDataTableAjaxByClass(selectorId, url, method, data, columnDefs, columns) {
    new DataTable(selectorId, {
        ajax: {
            url: url,
            headers: {"apikey": $(".container").data('apikey')},
            type: method,
            data: data,
            dataType: 'json',
            dataSrc: 'response',
            error: function (data) {
                alert(data.responseJSON.response);
            },
        },
        columnDefs: columnDefs,
        columns: columns,
        processing: true,
        serverSide: false,
        responsive: true,
        info: false,
        paging: false,
        searching: false,
        orderable: false,
    });
}

function splitDate(date, separator) {
    return date.split(separator);
}

function fillError(selector, selectorText, message) {
    $(selector).addClass('border-input-error');
    $(selectorText).html(message);
}

function cleanError(selector, selectorText) {
    $(selector).removeClass('border-input-error');
    $(selectorText).html('');
}
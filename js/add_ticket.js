var rangeMin = parseInt($('.concealed-data').attr('data-range-min'));
var rangeMax = parseInt($('.concealed-data').attr('data-range-max'));

$('#chkbx-random-digits').on('click', function(){
    if ($(this).is(':checked')) {
        giveRandomNumberForAllSelects();
    }
});

function giveRandomNumberForAllSelects() {
    for (i=0; i<$('select').length; i++) {
        $('select').eq(i).val(randomDigitFromInterval(rangeMin, rangeMax));
    }
}

function randomDigitFromInterval(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}
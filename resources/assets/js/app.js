
const flatpickr = require("flatpickr");
const $ = require("jquery");

$(document).ready(function() {
    flatpickr(".flatpickr", {
        dateFormat: "Y-m-d",
        altFormat: "J F Y",
        altInput: true
    });

    if ($('.flash-messages').length) {
        $('.flash-messages').delay(5000).fadeOut();
    }
});


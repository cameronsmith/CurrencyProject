
const flatpickr = require("flatpickr");
const $ = require("jquery");

$(document).ready(function() {
    flatpickr(".flatpickr", {
        dateFormat: "d/m/Y",
        altFormat: "J F Y",
        altInput: true
    });
});


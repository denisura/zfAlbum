// Filename: helpers/view
define([
    'jquery'
], function ($) {
    var viewHelpers = {
        htmlEncode: function (value) {
            return $('<div/>').text(value).html();
        },

        htmlDecode: function (value) {
            return $('<div/>').html(value).text();
        }
    }
    // Return the model for the module
    return viewHelpers;
});

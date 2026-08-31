define([
    'jquery',
    'mage/validation'
], function ($) {
    'use strict';

    return function (config, element) {
        $(element).on('click', function () {
            var form = $('#product_addtocart_form');

            if (!form.length) {
                return;
            }

            if (!form.validation('isValid')) {
                return;
            }

            form.attr('action', $(element).data('url'));
            form.attr('method', 'POST');

            HTMLFormElement.prototype.submit.call(form[0]);
        });
    };
});

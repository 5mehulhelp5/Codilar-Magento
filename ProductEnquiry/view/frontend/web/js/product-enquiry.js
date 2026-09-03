define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'Magento_Customer/js/customer-data'
], function ($, modal, customerData) {
    'use strict';

    return function () {

        var modalElement = $('#product-enquiry-modal');
        var form = $('#product-enquiry-form');
        var addToCartButton = $('#product-addtocart-button');

        if (
            !modalElement.length ||
            !form.length ||
            !addToCartButton.length
        ) {
            return;
        }


        /*
         * Initialize Product Enquiry Modal
         */
        modal({
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: 'Product Enquiry',
            buttons: []
        }, modalElement);


        /*
         * Change Magento's existing Add to Cart button
         * into Product Enquiry button.
         */
        addToCartButton
            .attr('type', 'button')
            .attr('title', 'Product Enquiry')
            .find('span')
            .text('Product Enquiry');


        /*
         * Open Product Enquiry modal
         * instead of adding product to cart.
         */
        addToCartButton.on('click', function (event) {

            event.preventDefault();
            event.stopImmediatePropagation();

            modalElement.modal('openModal');

        });


        /*
         * Product Enquiry Submit
         */
        $('#product-enquiry-submit').on('click', function (event) {

            event.preventDefault();

            var name = $.trim($('#enquiry-name').val());
            var email = $.trim($('#enquiry-email').val());
            var address = $.trim($('#enquiry-address').val());
            var sku = $.trim($('#enquiry-sku').val());
            var qty = parseInt($('#enquiry-qty').val(), 10);

            var message = $('#product-enquiry-message');
            var button = $(this);

            message
                .removeClass('success error')
                .empty();


            /*
             * Name validation
             */
            if (!name) {

                message
                    .addClass('error')
                    .text('Name is required.');

                return;
            }


            /*
             * Email validation
             */
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {

                message
                    .addClass('error')
                    .text('Please enter a valid email address.');

                return;
            }


            /*
             * Address validation
             */
            if (!address) {

                message
                    .addClass('error')
                    .text('Address is required.');

                return;
            }


            /*
             * SKU validation
             */
            if (!sku) {

                message
                    .addClass('error')
                    .text('SKU is required.');

                return;
            }


            /*
             * Quantity validation
             */
            if (!qty || qty <= 0) {

                message
                    .addClass('error')
                    .text('Quantity must be greater than zero.');

                return;
            }


            /*
             * Disable submit button
             */
            button.prop('disabled', true);


            /*
             * Submit enquiry using AJAX
             */
            $.ajax({

                url: form.attr('data-submit-url'),

                type: 'POST',

                dataType: 'json',

                data: {
                    form_key: form.find('[name="form_key"]').val(),
                    name: name,
                    email: email,
                    address: address,
                    sku: sku,
                    qty: qty
                },

                showLoader: true,


                /*
                 * AJAX success
                 */
                success: function (response) {

                    if (response.success) {

                        /*
                         * Reset form
                         */
                        $('#enquiry-name').val('');
                        $('#enquiry-email').val('');
                        $('#enquiry-address').val('');
                        $('#enquiry-qty').val(1);


                        /*
                         * Close Product Enquiry modal
                         */
                        modalElement.modal('closeModal');


                        /*
                         * Show success message in
                         * Magento's standard message area.
                         */
                        customerData.set('messages', {
                            messages: [
                                {
                                    type: 'success',
                                    text: response.message
                                }
                            ]
                        });

                    } else {

                        /*
                         * Show error inside modal
                         */
                        message
                            .addClass('error')
                            .text(response.message);

                    }

                },


                /*
                 * AJAX error
                 */
                error: function (xhr) {

                    var errorMessage =
                        'Something went wrong. Please try again.';


                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        errorMessage = xhr.responseJSON.message;

                    } else if (xhr.responseText) {

                        try {

                            var response =
                                JSON.parse(xhr.responseText);

                            if (response.message) {
                                errorMessage = response.message;
                            }

                        } catch (error) {

                            console.error(
                                'Product Enquiry Error:',
                                xhr.responseText
                            );

                        }
                    }


                    message
                        .addClass('error')
                        .text(errorMessage);

                },


                /*
                 * AJAX complete
                 */
                complete: function () {

                    button.prop('disabled', false);

                }

            });

        });

    };
});

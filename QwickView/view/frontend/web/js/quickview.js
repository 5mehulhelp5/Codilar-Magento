define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
    'use strict';

    return function (config) {

        var popup = $('#quick-view-popup');

        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: 'Quick View',
            buttons: []
        };

        modal(options, popup);

        /*
         * Add Quick View button beside Add to Cart
         */
        $('.product-item').each(function () {

            var productItem = $(this);
            var addToCartButton = productItem.find('.action.tocart');

            if (!addToCartButton.length) {
                return;
            }

            if (productItem.find('.quick-view-button').length) {
                return;
            }

            var productUrl = productItem.find('.product-item-link').attr('href');

            if (!productUrl) {
                return;
            }

            var productId = productItem.data('product-id');

            if (!productId) {
                productId = productItem.find('[data-product-id]').first().data('product-id');
            }

            if (!productId) {
                return;
            }

            var quickViewButton = $(
                '<button type="button" class="action primary quick-view-button">' +
                '<span>Quick View</span>' +
                '</button>'
            );

            quickViewButton.attr('data-product-id', productId);

            addToCartButton.after(quickViewButton);
        });

        /*
         * Quick View button click
         */
        $(document).on('click', '.quick-view-button', function () {

            var productId = $(this).data('product-id');

            if (!productId) {
                return;
            }

            $('.quick-view-loader')
                .text('Loading...')
                .show();

            $('.quick-view-product').hide();

            popup.modal('openModal');

            $.ajax({
                url: config.ajaxUrl,
                type: 'GET',
                data: {
                    product_id: productId
                },
                dataType: 'json',

                success: function (response) {

                    if (!response.success) {
                        $('.quick-view-loader').text(response.message);
                        return;
                    }

                    var product = response.product;

                    $('#quick-view-product-image')
                        .attr('src', product.image)
                        .attr('alt', product.name);

                    $('#quick-view-product-name')
                        .text(product.name);

                    $('#quick-view-product-price')
                        .text(product.price);

                    $('#quick-view-product-sku')
                        .text(product.sku);

                    $('#quick-view-product-stock')
                        .text(product.stock_status);

                    $('#quick-view-product-description')
                        .html(product.description);

                    $('.quick-view-loader').hide();
                    $('.quick-view-product').show();
                },

                error: function () {

                    $('.quick-view-loader')
                        .text('Something went wrong. Please try again.');
                }
            });
        });
    };
});

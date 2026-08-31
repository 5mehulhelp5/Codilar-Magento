define([
    'swiper'
], function (Swiper) {
    'use strict';

    return function (config, element) {

        new Swiper(
            element.querySelector('.same-category-products__slider'),
            {
                slidesPerView: 4,
                spaceBetween: 20,

                navigation: {
                    nextEl: '.same-category-products__next',
                    prevEl: '.same-category-products__prev'
                }
            }
        );
    };
});

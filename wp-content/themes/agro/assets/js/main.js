$(document).ready(function () {
    $('span.readmore').on('click',function(){
        $(this).addClass('active').css('display','none');
        $('.main-text-full').slideDown().addClass('active');
    });
    
	$("#phone_mask,#phone_mask2").mask("+38(999) 999-99-99");
	
	$("#billing_phone").mask("+38(999) 999-99-99");

    /* OWL - carousel */
    var sliderList = $('.slider_list');
    $(sliderList).addClass('owl-carousel');
    $(sliderList).owlCarousel({
        loop: true,
        autoplay: true,
        nav: true,
        dots: true,
        items: 1,
    });

    /* OWL - carousel  Related Products*/
    var relatedProducts = $('.related.products .products');
    $(relatedProducts).addClass('owl-carousel');
    $(relatedProducts).owlCarousel({
        loop: false,
        autoplay: false,
        nav: true,
        dots: false,
        margin: 10,
        responsive: {
            1260: {
                items: 4
            },
            910: {
                items: 3
            },
            570: {
                items: 2
            },
            0: {
                items: 1
            }
        },
    });

    // Модальное окно fancybox

    $(".modal").fancybox({
        wrapCSS: 'call-back',
        padding: 10,
        autoFocus: false,
    });


    // Табы сайдбара

    $('.acc-body').hide();

    function f_acc() {

        if ($(this).hasClass('open')) {
            $(this).removeClass('open');

        } else {
            $('.questions .acc-head').removeClass('open');
            $(this).addClass('open');
        }
        $('.questions .acc-body').not($(this).next()).slideUp(500);
        $(this).next().slideToggle(500);
    }

    $(document).ready(function () {

        //прикрепляем клик по заголовкам acc-head
        $('.questions .acc-head').on('click', f_acc);
    });

    // Фиксированная шапка

    function scrolling() {
        if ($(window).scrollTop() >= ($('body').offset().top) + 1) {
            $('.header').addClass('header_fixed');
            $('.header').parent().addClass('header_fixed');
        } else {
            $('.header').removeClass('header_fixed');
            $('.header').parent().removeClass('header_fixed');
        }
    }

    if ($('body').length) {
        $(window).scroll(function () {
            scrolling();
        });
    }


    // Burger menu

    $('.burger-menu').on('click', function () {
            $('.burger-menu, .header').toggleClass('active');
            $('body').toggleClass('lock');
        }
    );


// Scroll Menu

    function scrollMenu() {
        var mobMenu = $('.wrap_mob');
        var headerHeight = $('.header').height();
        var windowHeight = $(window).height();
        if ($(window).width() < 850) {
            var height = windowHeight - headerHeight;
            $(mobMenu).css("height", height);
        } else if ($(window).width() > 850) {
            $(mobMenu).css('height', 'auto');
        }
    }

    $(window).on('load resize', function () {
        scrollMenu();
    });

    var filterButton = $('.category_filter .filter_button');
    var closeBtn = $('.close_button .close_btn');

    $(filterButton).on('click', function () {
       $(this).parent().parent().find('.sidebar').addClass('active');
        $('body').addClass('lock filter_active');
        $(closeBtn).on('click', function () {
            $('body').removeClass('lock filter_active');
            $(this).parent().parent().removeClass('active');
        });
    });

});

$(function ($) {
    /* Счетчик количества товара */

    $(document.body).on('click', '.minus.button', function () {
        var quantity = $(this).parent().find('.input-text.qty');
        var quantityVal = $(this).parent().find('.input-text.qty').val();
        if (quantityVal > 1) {
            quantityVal--;
        }
        quantity.val(quantityVal);
        $(".shop_table.cart button").each(function () {
            $(this).prop('disabled', false);
        });
    });
    $(document.body).on('click', '.plus.button', function () {
        var quantity = $(this).parent().find('.input-text.qty');
        var quantityVal = $(this).parent().find('.input-text.qty').val();
        quantityVal++;
        quantity.val(quantityVal);
        $(".shop_table.cart button").each(function () {
            $(this).prop('disabled', false);
        });
    });


});

$(function ($) {
    $(document.body).on('updated_wc_div', function () {
        // Get the formatted cart total
        $.ajax({
            url: '/wp-content/themes/agro/admin-ajax.php',
            type: 'post',
            data: {
                action: 'the_function_that_creates_inputs'
            },
            success: function (data) {
                var quantity = data.split('|');
                var qty = $('.cart_qty');
                var sum = $('.cart_price .price');

                qty.html(quantity[1]);
                sum.html(quantity[0]);

            }
        });

    });

    $('[name="update_cart"], .product-remove .remove').on('click', function (event) {
        $(document.body).trigger('updated_wc_div');
    });

    /*$('body').on('click', '.add_to_cart_button', function (event) {
        setTimeout(function () {
            $(document.body).trigger('updated_wc_div');
        }, 1000);
    });*/
	jQuery(document.body).on('wc_cart_button_updated', function( $e, $button ) {
        $(document.body).trigger('updated_wc_div');
    });
});

$(function(){
    $(".term-description").after('<span id="readmore">&#9660;</span>');
    $('body').on('click','#readmore',function(){
        $(this).toggleClass('active'); 
        if( $('#readmore').hasClass('active') ) {
            $('#readmore').html('&#9650');
        }
        else {
            $('#readmore').html('&#9660;');
        }
        $(".term-description").toggleClass('active');
    });
});
$(document).ready(function(){
        // Делаем активной вкладку "Характеристики" в карточке товара
    $( "#tab-title-additional_information a" ).trigger( "click" );
});

$(function(){
    $('body').on('click','.cart button.single_add_to_cart_button',function(event){
        var id = $('#g_id').val();
        var name = $('.product h1.product_title').text();
        var list_name = 'Карточка товара';
        var brand = $('#g_brand').val();
        var category = $('#g_category').val();
        var variant = 'Standard';
        var quantity = $('.product .quantity input.input-text').val();
        var price = $('#g_price').val();

        gtag_add_to_cart(id, name, list_name, brand, category, variant, quantity, price);
    });

    $('body').on('click','.list-products .product_item .ajax_add_to_cart ',function(event){
        var id = $(this).attr('data-product_id');
        var name = $(this).parent().children('.product_title').children('a').text();
        var list_name = 'Список продуктов';
        var brand = $(this).parent().attr('prod_brand');
        var category = $(this).parent().attr('prod_category');
        var variant = 'Standard';
        var quantity = $(this).attr('data-quantity');
        var price = $(this).parent().attr('prod_category');

        gtag_add_to_cart(id, name, list_name, brand, category, variant, quantity, price);
    });

    $('body').on('click','.woocommerce-cart-form .product-remove a ',function(event){
        var id = $(this).attr('data-product_id');
        var name = $(this).parent().parent().children('.product-name').children('a').text();
        var list_name = 'Удаление товара';
        var brand = $(this).parent().attr('prod_brand');
        var category = $(this).parent().attr('category_prod');
        var variant = 'Standard';
        var quantity = $(this).parent().parent().children('.product-quantity').children('.quantity').children('input.input-text').val();
        var price = $(this).parent().attr('product_price');

        gtag_remove_from_cart(id, name, list_name, brand, category, variant, quantity, price);
    });

    function gtag_add_to_cart(id, name, list_name, brand, category, variant, quantity, price) {
        gtag('event', 'add_to_cart', {
            "items": [
                {
                    "id": id,
                    "name": name,
                    "list_name": list_name,
                    "brand": brand,
                    "category": category,
                    "variant": variant,
                    "quantity": quantity,
                    "price": price
                }
            ]
        });
    }

    function gtag_remove_from_cart(id, name, list_name, brand, category, variant, quantity, price) {
        gtag('event', 'remove_from_cart', {
            "items": [
                {
                    "id": id,
                    "name": name,
                    "list_name": list_name,
                    "brand": brand,
                    "category": category,
                    "variant": variant,
                    "quantity": quantity,
                    "price": price
                }
            ]
        });
    }

});

jQuery(document).ready(function($) {
    document.addEventListener( 'wpcf7mailsent', function( event ) {
        if ( event.detail.contactFormId == '1969' || event.detail.contactFormId == '1972' ) {
            gtag('event', 'product', {
                'event_category': 'quick order'
            });
            
            function sayHi() {
                $('.wpcf7-response-output').text($('#agro_wpcf7mailsent_ok').val());
            }
            setTimeout(sayHi, 10);
        }
    }, false );
});
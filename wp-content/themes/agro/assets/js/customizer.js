$(document).ready(function () {
    //  Блок "Категории"
    viewFlow($('.archive #woocommerce_product_categories-2'), 15);

    function viewFlow(el, margin) {
        if (el.length !== 0 && $(".product_item").length > 9) {
            var offset = el.offset();

            flow(el, offset, margin);
            
            $(window).scroll(function() {
                flow(el, offset, margin);
            });
        
            $(window).resize(function() {
                el.css('position', 'static');
                offset = el.offset();
                flow(el, offset, margin);
            });
        }
    }
    
    function flow(el, offset, margin) {
        var topPosition = $(".header").height() + margin;
        var elWidth = $('.filter_wrapper').width();
        var flag = $(".archive .sitetext").height() > $(".archive .sidebar .filter_wrapper").height();

        if ($(window).scrollTop() > offset.top - topPosition && window.innerWidth > 1020 && flag) {
            el.stop().css('position', 'fixed');
            el.stop().css('top', topPosition + 'px');

            el.stop().css('width', elWidth + 'px');
            el.stop().css('max-height', $(window).height() - topPosition - margin + 'px');

            el.children(".product-categories").css("max-height", 
                parseInt(el.css("max-height"), 10) - 
                parseInt(el.css("padding-top"), 10) -
                parseInt(el.css("padding-bottom"), 10) -
                parseInt(el.children(".widgettitle").css("padding-top"), 10) -
                parseInt(el.children(".widgettitle").css("padding-bottom"), 10) -
                parseInt(el.children(".widgettitle").css("margin-top"), 10) -
                parseInt(el.children(".widgettitle").css("margin-bottom"), 10) -
                el.children(".widgettitle").height() +
                "px");

            el.stop().css('background-color', '#fff');

            maxBottomPosition = $(".footer").offset().top - el.offset().top - el.height();
            if (maxBottomPosition < topPosition) {
                el.css('top', maxBottomPosition + 'px');
            }
        }
        else {

            el.stop().css('position', 'static');
            el.stop().css('top', '0px');

            el.stop().css('width', '100%');
            el.stop().css('max-height', 'auto');

            el.children(".product-categories").css("max-height", "auto");
            
            el.stop().css('background-color', 'transparent');

        }
    }

    var toTop = $(".scroll_to_top");

    $(window).scroll(function() {     
        if ($(window).scrollTop() > $(window).height()) {
            toTop.addClass("scroll_to_top--show");
            toTop.removeClass("scroll_to_top--hide");
         } else {
            toTop.removeClass("scroll_to_top--show");
            toTop.addClass("scroll_to_top--hide");
         }
       });
       toTop.on('click', function(e) {
         e.preventDefault();
         $('html, body').animate({scrollTop:0}, '300');
       });
       
       if ($(window).scrollTop() > 50) {
        $('.header__messengers').addClass('header__messengers--scroll');
        } else {
            $('.header__messengers').removeClass('header__messengers--scroll');
        }
        $(window).scroll(function(){
        var st = $(this).scrollTop();
        if (st > 50) {
            $('.header__messengers').addClass('header__messengers--scroll');
        } else {
            $('.header__messengers').removeClass('header__messengers--scroll');
        }
    });
    $(".br_compare_button:not(.compare__btn)").click(function() {compareProcess(this)});
    $(".br_compare_button .fa.fa-check-square-o:not(.compare__count-minus)").click(function() {compareProcess(this)});
});
function compareProcess(elem) {
    count = Number($(".compare__btn--header").attr("count"));
    headerBtn = $(".compare__btn--header");
    headerCount = $(".compare__btn--header .compare__count");

    if ($(elem).hasClass("br_remove_all_compare")) count = 0;
    //else if ($(elem).hasClass("fa-check-square-o") || $(elem).hasClass("br_remove_compare_product_reload")) count--;
    else if (!$(elem).hasClass("br_compare_added")) count++;

    headerBtn.attr("count", count);
    headerCount.text(count);
}

$(".single-product").on('click', '.fnd-link', function() {
    $('#fnd-form .fnd-form__input[name="our-url"]').val(window.location.href);
});

$(".products").on('click', '.fnd-link', function() {
    $('#fnd-form .fnd-form__input[name="our-url"]').val($(this).parents('.product_item').children('.product_title').children().attr('href'));
});

$('[data-fancybox=""]').fancybox({
    autoFocus: false
});
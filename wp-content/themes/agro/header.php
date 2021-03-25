<?
$phone_1 = carbon_get_theme_option('agro_phone_1');
$phone_1_mob = carbon_get_theme_option('agro_phone_1_mob');

$phone_2 = carbon_get_theme_option('agro_phone_2');
$phone_2_mob = carbon_get_theme_option('agro_phone_2_mob');

$viber = carbon_get_theme_option('agro_phone_viber');
$viber_mob = carbon_get_theme_option('agro_phone_viber_mob');

$telegram = carbon_get_theme_option('agro_phone_telegram');
?>


<!DOCTYPE html>
<html lang="<? print get_locale();?>">

<head>
    <meta name="google-site-verification" content="qwEUInGGbFSJe9QZVHkKt1lmTDS78_Z6bxY0zWqXiCo" />
    <!-- Google Ads: 561428751 -->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=AW-561428751"></script>
    <!-- Google Analytics 179954029-1 -->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-179954029-1"></script>
    <!-- GA4 G-W3EWHVZ3H1 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-W3EWHVZ3H1"></script>
    <!-- Global site tag (gtag.js) -->
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-179954029-1');
        gtag('config', 'AW-561428751');
        gtag('config', 'G-W3EWHVZ3H1');
    </script>
    <meta charset="UTF-8">
    <meta name="robots" content="index, follow"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
</head>
<? wp_deregister_script('jquery'); ?>
<? wp_head(); ?>
<body <? body_class(); ?>>
    <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K9PGLJC"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
<div class="overlay_content"></div>
<div class="header_wrap">
    <header class="header">
        <div class="wrap_mob">
            <div class="header_top">
                <div class="container container_flex">
                    <div class="lang_switch mobile">
                        <ul class="lang_list"><?php pll_the_languages();?></ul>
                    </div>
                    <div class="phones container_flex">

                        <? if (!empty($phone_1))  : ?>
                            <div class="phone_number">
                                <svg class="phone_icon" enable-background="new 0 0 512.021 512.021" height="512"
                                     viewBox="0 0 512.021 512.021" width="512" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path d="m367.988 512.021c-16.528 0-32.916-2.922-48.941-8.744-70.598-25.646-136.128-67.416-189.508-120.795s-95.15-118.91-120.795-189.508c-8.241-22.688-10.673-46.108-7.226-69.612 3.229-22.016 11.757-43.389 24.663-61.809 12.963-18.501 30.245-33.889 49.977-44.5 21.042-11.315 44.009-17.053 68.265-17.053 7.544 0 14.064 5.271 15.645 12.647l25.114 117.199c1.137 5.307-.494 10.829-4.331 14.667l-42.913 42.912c40.482 80.486 106.17 146.174 186.656 186.656l42.912-42.913c3.837-3.837 9.36-5.466 14.667-4.331l117.199 25.114c7.377 1.581 12.647 8.101 12.647 15.645 0 24.256-5.738 47.224-17.054 68.266-10.611 19.732-25.999 37.014-44.5 49.977-18.419 12.906-39.792 21.434-61.809 24.663-6.899 1.013-13.797 1.518-20.668 1.519zm-236.349-479.321c-31.995 3.532-60.393 20.302-79.251 47.217-21.206 30.265-26.151 67.49-13.567 102.132 49.304 135.726 155.425 241.847 291.151 291.151 34.641 12.584 71.867 7.64 102.132-13.567 26.915-18.858 43.685-47.256 47.217-79.251l-95.341-20.43-44.816 44.816c-4.769 4.769-12.015 6.036-18.117 3.168-95.19-44.72-172.242-121.772-216.962-216.962-2.867-6.103-1.601-13.349 3.168-18.117l44.816-44.816z"/>
                                        <path d="m496.02 272c-8.836 0-16-7.164-16-16 0-123.514-100.486-224-224-224-8.836 0-16-7.164-16-16s7.164-16 16-16c68.381 0 132.668 26.628 181.02 74.98s74.98 112.639 74.98 181.02c0 8.836-7.163 16-16 16z"/>
                                        <path d="m432.02 272c-8.836 0-16-7.164-16-16 0-88.224-71.776-160-160-160-8.836 0-16-7.164-16-16s7.164-16 16-16c105.869 0 192 86.131 192 192 0 8.836-7.163 16-16 16z"/>
                                        <path d="m368.02 272c-8.836 0-16-7.164-16-16 0-52.935-43.065-96-96-96-8.836 0-16-7.164-16-16s7.164-16 16-16c70.58 0 128 57.42 128 128 0 8.836-7.163 16-16 16z"/>
                                    </g>
                                </svg>
                                <a href="tel:<? print $phone_1_mob; ?>"><? print $phone_1; ?></a>
                            </div>
                        <? endif; ?>
                        <? if (!empty($phone_2))  : ?>
                            <div class="phone_number">
                                <svg class="phone_icon" enable-background="new 0 0 512.021 512.021" height="512"
                                     viewBox="0 0 512.021 512.021" width="512" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path d="m367.988 512.021c-16.528 0-32.916-2.922-48.941-8.744-70.598-25.646-136.128-67.416-189.508-120.795s-95.15-118.91-120.795-189.508c-8.241-22.688-10.673-46.108-7.226-69.612 3.229-22.016 11.757-43.389 24.663-61.809 12.963-18.501 30.245-33.889 49.977-44.5 21.042-11.315 44.009-17.053 68.265-17.053 7.544 0 14.064 5.271 15.645 12.647l25.114 117.199c1.137 5.307-.494 10.829-4.331 14.667l-42.913 42.912c40.482 80.486 106.17 146.174 186.656 186.656l42.912-42.913c3.837-3.837 9.36-5.466 14.667-4.331l117.199 25.114c7.377 1.581 12.647 8.101 12.647 15.645 0 24.256-5.738 47.224-17.054 68.266-10.611 19.732-25.999 37.014-44.5 49.977-18.419 12.906-39.792 21.434-61.809 24.663-6.899 1.013-13.797 1.518-20.668 1.519zm-236.349-479.321c-31.995 3.532-60.393 20.302-79.251 47.217-21.206 30.265-26.151 67.49-13.567 102.132 49.304 135.726 155.425 241.847 291.151 291.151 34.641 12.584 71.867 7.64 102.132-13.567 26.915-18.858 43.685-47.256 47.217-79.251l-95.341-20.43-44.816 44.816c-4.769 4.769-12.015 6.036-18.117 3.168-95.19-44.72-172.242-121.772-216.962-216.962-2.867-6.103-1.601-13.349 3.168-18.117l44.816-44.816z"/>
                                        <path d="m496.02 272c-8.836 0-16-7.164-16-16 0-123.514-100.486-224-224-224-8.836 0-16-7.164-16-16s7.164-16 16-16c68.381 0 132.668 26.628 181.02 74.98s74.98 112.639 74.98 181.02c0 8.836-7.163 16-16 16z"/>
                                        <path d="m432.02 272c-8.836 0-16-7.164-16-16 0-88.224-71.776-160-160-160-8.836 0-16-7.164-16-16s7.164-16 16-16c105.869 0 192 86.131 192 192 0 8.836-7.163 16-16 16z"/>
                                        <path d="m368.02 272c-8.836 0-16-7.164-16-16 0-52.935-43.065-96-96-96-8.836 0-16-7.164-16-16s7.164-16 16-16c70.58 0 128 57.42 128 128 0 8.836-7.163 16-16 16z"/>
                                    </g>
                                </svg>
                                <a href="tel:<? print $phone_2_mob; ?>"><? print $phone_2; ?></a>
                            </div>
                        <? endif; ?>
                        <div class="phone_number back_call">
                            <svg class="phone_icon" enable-background="new 0 0 512.021 512.021" height="512"
                                 viewBox="0 0 512.021 512.021" width="512" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path d="m367.988 512.021c-16.528 0-32.916-2.922-48.941-8.744-70.598-25.646-136.128-67.416-189.508-120.795s-95.15-118.91-120.795-189.508c-8.241-22.688-10.673-46.108-7.226-69.612 3.229-22.016 11.757-43.389 24.663-61.809 12.963-18.501 30.245-33.889 49.977-44.5 21.042-11.315 44.009-17.053 68.265-17.053 7.544 0 14.064 5.271 15.645 12.647l25.114 117.199c1.137 5.307-.494 10.829-4.331 14.667l-42.913 42.912c40.482 80.486 106.17 146.174 186.656 186.656l42.912-42.913c3.837-3.837 9.36-5.466 14.667-4.331l117.199 25.114c7.377 1.581 12.647 8.101 12.647 15.645 0 24.256-5.738 47.224-17.054 68.266-10.611 19.732-25.999 37.014-44.5 49.977-18.419 12.906-39.792 21.434-61.809 24.663-6.899 1.013-13.797 1.518-20.668 1.519zm-236.349-479.321c-31.995 3.532-60.393 20.302-79.251 47.217-21.206 30.265-26.151 67.49-13.567 102.132 49.304 135.726 155.425 241.847 291.151 291.151 34.641 12.584 71.867 7.64 102.132-13.567 26.915-18.858 43.685-47.256 47.217-79.251l-95.341-20.43-44.816 44.816c-4.769 4.769-12.015 6.036-18.117 3.168-95.19-44.72-172.242-121.772-216.962-216.962-2.867-6.103-1.601-13.349 3.168-18.117l44.816-44.816z"/>
                                    <path d="m496.02 272c-8.836 0-16-7.164-16-16 0-123.514-100.486-224-224-224-8.836 0-16-7.164-16-16s7.164-16 16-16c68.381 0 132.668 26.628 181.02 74.98s74.98 112.639 74.98 181.02c0 8.836-7.163 16-16 16z"/>
                                    <path d="m432.02 272c-8.836 0-16-7.164-16-16 0-88.224-71.776-160-160-160-8.836 0-16-7.164-16-16s7.164-16 16-16c105.869 0 192 86.131 192 192 0 8.836-7.163 16-16 16z"/>
                                    <path d="m368.02 272c-8.836 0-16-7.164-16-16 0-52.935-43.065-96-96-96-8.836 0-16-7.164-16-16s7.164-16 16-16c70.58 0 128 57.42 128 128 0 8.836-7.163 16-16 16z"/>
                                </g>
                            </svg>
                            <a href="#call-back" class="modal"><? pll_e('Замовити дзвінок'); ?></a>
                        </div>
                        <div class="phone_number messengers">
                        <? if (!empty($viber))  : ?>
                            <div class="phone_number phone_number--viber">
                                <a href="viber://chat?number=<? print $viber_mob; ?>">
                                    <svg class="phone_icon messenger_icon" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512">
                                        <g fill="#8e24aa"><path d="m23.155 13.893c.716-6.027-.344-9.832-2.256-11.553l.001-.001c-3.086-2.939-13.508-3.374-17.2.132-1.658 1.715-2.242 4.232-2.306 7.348-.064 3.117-.14 8.956 5.301 10.54h.005l-.005 2.419s-.037.98.589 1.177c.716.232 1.04-.223 3.267-2.883 3.724.323 6.584-.417 6.909-.525.752-.252 5.007-.815 5.695-6.654zm-12.237 5.477s-2.357 2.939-3.09 3.702c-.24.248-.503.225-.499-.267 0-.323.018-4.016.018-4.016-4.613-1.322-4.341-6.294-4.291-8.895.05-2.602.526-4.733 1.93-6.168 3.239-3.037 12.376-2.358 14.704-.17 2.846 2.523 1.833 9.651 1.839 9.894-.585 4.874-4.033 5.183-4.667 5.394-.271.09-2.786.737-5.944.526z"/>
                                        <path d="m12.222 4.297c-.385 0-.385.6 0 .605 2.987.023 5.447 2.105 5.474 5.924 0 .403.59.398.585-.005h-.001c-.032-4.115-2.718-6.501-6.058-6.524z"/>
                                        <path d="m16.151 10.193c-.009.398.58.417.585.014.049-2.269-1.35-4.138-3.979-4.335-.385-.028-.425.577-.041.605 2.28.173 3.481 1.729 3.435 3.716z"/>
                                        <path d="m15.521 12.774c-.494-.286-.997-.108-1.205.173l-.435.563c-.221.286-.634.248-.634.248-3.014-.797-3.82-3.951-3.82-3.951s-.037-.427.239-.656l.544-.45c.272-.216.444-.736.167-1.247-.74-1.337-1.237-1.798-1.49-2.152-.266-.333-.666-.408-1.082-.183h-.009c-.865.506-1.812 1.453-1.509 2.428.517 1.028 1.467 4.305 4.495 6.781 1.423 1.171 3.675 2.371 4.631 2.648l.009.014c.942.314 1.858-.67 2.347-1.561v-.007c.217-.431.145-.839-.172-1.106-.562-.548-1.41-1.153-2.076-1.542z"/>
                                        <path d="m13.169 8.104c.961.056 1.427.558 1.477 1.589.018.403.603.375.585-.028-.064-1.346-.766-2.096-2.03-2.166-.385-.023-.421.582-.032.605z"/></g>
                                    </svg>
                                </a>
                            </div>
                        <? endif; ?>
                        <? if (!empty($telegram))  : ?>
                            <div class="phone_number phone_number--telegram">
                                <a href="https://telegram.im/<? print $telegram; ?>">
                                    <svg class="phone_icon messenger_icon" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512"><circle cx="12" cy="12" fill="#039be5" r="12"/>
                                        <path d="m5.491 11.74 11.57-4.461c.537-.194 1.006.131.832.943l.001-.001-1.97 9.281c-.146.658-.537.818-1.084.508l-3-2.211-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.121l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953z" fill="#fff"/>
                                    </svg>
                                </a>
                            </div>
                        <? endif; ?>
                        </div>
                    </div>
                    <nav class="main_nav container_flex">
                        <?php
                        wp_nav_menu(array(
                            'container' => false,
                            'theme_location' => 'primary',
                            'items-wrap' => ' <ul id="%1$s" class="%2$s">%3$s</ul>',
                            'menu_class' => 'menu_list container_flex',
                            'menu_id' => 'menu-primary-menu',
                            'depth' => 1
                        ));
                        ?>
                        <div class="account">
                            <svg class="account_icon" xmlns="http://www.w3.org/2000/svg" id="Outline"
                                 viewBox="0 0 512 512"
                                 width="512" height="512">
                                <path d="M68.169,447.023C71.835,449.023,159.075,496,256,496c105.008,0,184.772-47.134,188.116-49.14A8,8,0,0,0,448,440c0-64.593-19.807-123.7-55.771-166.442-25.158-29.9-56.724-50.28-91.539-59.662a104,104,0,1,0-89.38,0c-34.815,9.382-66.381,29.765-91.539,59.662C83.807,316.3,64,375.407,64,440A8,8,0,0,0,68.169,447.023ZM168,120a88,88,0,1,1,88,88A88.1,88.1,0,0,1,168,120ZM132.013,283.859C164.5,245.258,208.528,224,256,224s91.5,21.258,123.987,59.859c32.681,38.838,51.056,92.48,51.977,151.474C414.845,444.6,343.708,480,256,480c-81.11,0-157.5-35.609-175.96-44.856C81,376.223,99.367,322.656,132.013,283.859Z"/>
                            </svg>

                            <a href="<?php echo get_permalink(pll_get_post(123)); ?>" class="login"><?php

                                if (is_user_logged_in()) {
                                    print pll_e('Мій аккаунт');
                                } else {
                                    print pll_e('Увійти / Реєстрація');
                                }
                                ?></a>
                        </div>
                    </nav>
                    <div class="search-holder mobile">
                        <div class="search_form">
                            <?
                            $link_search = esc_url( home_url( '/' ) );
                            if(esc_url( home_url( '/' ) ) != get_site_url().'/'){
                                $link_search = get_site_url().'/'. pll_current_language().'/';
                            }?>
                            <form action="<?php print $link_search; ?>" method="get" class="search_form">
                                <label for="s"><?php _e('', 'mytextdomain'); ?></label>
                                <input type="text" name="s" id="s" class="search-input" value=""
                                       placeholder="<? pll_e('Поиск'); ?>" data-swplive="true">
                                <!-- data-swplive="true" enables SearchWP Live Search -->
                                <button type="submit" class="search-btn"><?php _e('', 'mytextdomain'); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header_bottom">
            <div class="container container_flex">
                <div class="burger-menu">
                    <div class="menu-btn"></div>
                </div>
                <div class="left_side container_flex">
                    <div class="logo">
                        <? if (is_front_page()) : ?>
                            <?php
                            $logo_img = '';
                            if ($custom_logo_id = get_theme_mod('custom_logo')) {
                                $logo_img = wp_get_attachment_image($custom_logo_id, 'full', false, array(
                                    'class' => 'custom-logo',
                                    'itemprop' => 'logo',
                                ));
                            }
                            echo $logo_img;
                            ?>

                        <? else: ?>
                            <?php the_custom_logo(); ?>
                        <? endif; ?>
                    </div>
                    <div class="lang_switch">
                        <ul class="lang_list"><?php pll_the_languages();?></ul>
                    </div>
                </div>
                <div class="right_side container_flex">
                    <div class="search-holder">
                        <div class="search_form">
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                    <a class="compare__btn compare__btn--header add_to_cart_button button br_compare_button berocket_product_smart_compare <?php
                
                    $BeRocket_Compare_Products = BeRocket_Compare_Products::getInstance();
                    $products = $BeRocket_Compare_Products->get_all_compare_products();

                    $count = 0;

                    foreach ($products as $prod) {
                        if ($prod != NULL && $prod != "undefined") {
                            $count++;
                        }
                    }

                    if ($count) echo "br_compare_added";
                ?>" count="<?php echo $count; ?>" href="<?php echo home_url(); ?>/compare/">
                        <span class="br_compare_button_text">
                            <svg x="0px" y="0px" viewBox="0 0 213.933 213.933" style="enable-background:new 0 0 213.933 213.933;" xml:space="preserve">
                                <path d="M213.416,123.608l-30.872-61.861c0.677-0.875,1.096-1.96,1.096-3.152c0-2.86-2.319-5.179-5.179-5.179h-58.334  c2.509-0.812,4.324-3.164,4.324-5.943v0c0-3.451-2.797-6.248-6.248-6.248h-2.297c3.407-2.662,5.606-6.799,5.606-11.457  c0-8.033-6.512-14.544-14.544-14.544c-8.033,0-14.544,6.512-14.544,14.544c0,4.659,2.199,8.796,5.606,11.457h-2.298  c-3.451,0-6.248,2.797-6.248,6.248v0c0,2.779,1.816,5.131,4.324,5.943H36.065l-0.009-0.018l-0.009,0.018h-0.574  c-2.86,0-5.179,2.319-5.179,5.179c0,1.368,0.541,2.603,1.407,3.529L0.518,124.608c-0.487,0.976-0.613,2.032-0.45,3.033  c-0.017,0.194-0.026,0.392-0.006,0.593c1.756,18.334,17.201,32.671,35.994,32.671s34.239-14.337,35.995-32.671  c0.019-0.202,0.011-0.399-0.006-0.594c0.163-1,0.037-2.056-0.45-3.032l-30.36-60.834h58.748v119.44H51.8  c-5.797,0-10.496,4.699-10.496,10.496c0,2.763,2.24,5.003,5.003,5.003h121.321c2.763,0,5.003-2.24,5.003-5.003  c0-5.797-4.699-10.496-10.496-10.496h-48.183V63.773H172.2l-29.861,59.834c-0.487,0.976-0.613,2.033-0.45,3.033  c-0.017,0.194-0.026,0.391-0.006,0.593c1.756,18.334,17.201,32.671,35.994,32.671c18.794,0,34.239-14.337,35.995-32.671  c0.019-0.202,0.011-0.399-0.006-0.594C214.029,125.64,213.903,124.584,213.416,123.608z M11.625,124.744l24.43-48.953l24.43,48.953  H11.625z M153.447,123.744l24.43-48.953l24.43,48.953H153.447z"/>
                            </svg>
                        </span>
                        <span class="compare__count"><?php echo $count; ?></span>
                    </a>
                    <div class="cart">
                        <?php
                        global $woocommerce; ?>
                        <a href="<?php echo $woocommerce->cart->get_cart_url() ?>" class="cart_link">
                            <span class="cart_icon"><strong
                                        class="cart_qty"><?php echo sprintf($woocommerce->cart->cart_contents_count); ?></strong></span>
                            <span class="cart_title"><? pll_e('Корзина'); ?> / </span>
                            <span class="cart_price">
                                <span class="price"><?
                                    $price_product = $woocommerce->cart->total;
                                    if (stristr($price_product, '.')) {
                                        $price_product = number_format($price_product, 2, '.', ' ');
                                    } else {
                                        $price_product = number_format($price_product, 0, '.', ' ');
                                    }
                                    echo $price_product; ?>
                                    </span>
                                <span class="cart__currency"> <? echo get_woocommerce_currency_symbol($currency = get_woocommerce_currency()); ?></span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__messengers">
            <ul class="messengers__list">
                <? if (!empty($phone_1) || !empty($phone_2))  : ?>
                <li class="messengers__item">
                    <button class="item__link item__btn" onclick="$(this).siblings('.phones__list').toggleClass('phones__list--show');">
                        <svg class="item__icon" enable-background="new 0 0 512.021 512.021" height="20"
                                viewBox="0 0 512.021 512.021" width="20" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path d="m367.988 512.021c-16.528 0-32.916-2.922-48.941-8.744-70.598-25.646-136.128-67.416-189.508-120.795s-95.15-118.91-120.795-189.508c-8.241-22.688-10.673-46.108-7.226-69.612 3.229-22.016 11.757-43.389 24.663-61.809 12.963-18.501 30.245-33.889 49.977-44.5 21.042-11.315 44.009-17.053 68.265-17.053 7.544 0 14.064 5.271 15.645 12.647l25.114 117.199c1.137 5.307-.494 10.829-4.331 14.667l-42.913 42.912c40.482 80.486 106.17 146.174 186.656 186.656l42.912-42.913c3.837-3.837 9.36-5.466 14.667-4.331l117.199 25.114c7.377 1.581 12.647 8.101 12.647 15.645 0 24.256-5.738 47.224-17.054 68.266-10.611 19.732-25.999 37.014-44.5 49.977-18.419 12.906-39.792 21.434-61.809 24.663-6.899 1.013-13.797 1.518-20.668 1.519zm-236.349-479.321c-31.995 3.532-60.393 20.302-79.251 47.217-21.206 30.265-26.151 67.49-13.567 102.132 49.304 135.726 155.425 241.847 291.151 291.151 34.641 12.584 71.867 7.64 102.132-13.567 26.915-18.858 43.685-47.256 47.217-79.251l-95.341-20.43-44.816 44.816c-4.769 4.769-12.015 6.036-18.117 3.168-95.19-44.72-172.242-121.772-216.962-216.962-2.867-6.103-1.601-13.349 3.168-18.117l44.816-44.816z"/>
                                <path d="m496.02 272c-8.836 0-16-7.164-16-16 0-123.514-100.486-224-224-224-8.836 0-16-7.164-16-16s7.164-16 16-16c68.381 0 132.668 26.628 181.02 74.98s74.98 112.639 74.98 181.02c0 8.836-7.163 16-16 16z"/>
                                <path d="m432.02 272c-8.836 0-16-7.164-16-16 0-88.224-71.776-160-160-160-8.836 0-16-7.164-16-16s7.164-16 16-16c105.869 0 192 86.131 192 192 0 8.836-7.163 16-16 16z"/>
                                <path d="m368.02 272c-8.836 0-16-7.164-16-16 0-52.935-43.065-96-96-96-8.836 0-16-7.164-16-16s7.164-16 16-16c70.58 0 128 57.42 128 128 0 8.836-7.163 16-16 16z"/>
                            </g>
                        </svg>
                        <? if (get_locale() == 'uk')  : ?>
                        <span>Подзвонити</span>
                        <? elseif (get_locale() == 'ru_RU') : ?>
                        <span>Позвонить</span>
                        <? endif; ?>
                    </button>
                    <ul class="phones__list">
                        <? if (!empty($phone_1))  : ?>
                        <li class="phones__item">
                            <a href="tel:<? print $phone_1_mob; ?>" target="_blank" class="item__link">
                                <span><? print $phone_1; ?></span>
                            </a>
                        </li>
                        <? endif; ?>
                        <? if (!empty($phone_2))  : ?>
                        <li class="phones__item">
                            <a href="tel:<? print $phone_2_mob; ?>" target="_blank" class="item__link">
                                <span><? print $phone_2; ?></span>
                            </a>
                        </li>
                        <? endif; ?>
                    </ul>
                </li>
                <? endif; ?>
                <? if (!empty($viber))  : ?>
                <li class="messengers__item"><a href="viber://chat?number=<? print $viber_mob; ?>" target="_blank" class="item__link">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Capa_1" x="0px" y="0px"
                            viewBox="0 0 52.511 52.511" xml:space="preserve" width="20" height="20"
                            class="item__icon"><g>
                            <g>
                                <g>
                                    <path d="M31.256,0H21.254C10.778,0,2.255,8.521,2.255,18.995v9.01c0,7.8,4.793,14.81,12,17.665v5.841    c0,0.396,0.233,0.754,0.595,0.914c0.13,0.058,0.268,0.086,0.405,0.086c0.243,0,0.484-0.089,0.671-0.259L21.725,47h9.531    c10.476,0,18.999-8.521,18.999-18.995v-9.01C50.255,8.521,41.732,0,31.256,0z M48.255,28.005C48.255,37.376,40.63,45,31.256,45    h-9.917c-0.248,0-0.487,0.092-0.671,0.259l-4.413,3.997v-4.279c0-0.424-0.267-0.802-0.667-0.942    C8.81,41.638,4.255,35.196,4.255,28.005v-9.01C4.255,9.624,11.881,2,21.254,2h10.002c9.374,0,16.999,7.624,16.999,16.995V28.005z"
                                            data-original="#000000" class="active-path"/>
                                    <path d="M39.471,30.493l-6.146-3.992c-0.672-0.437-1.472-0.585-2.255-0.423c-0.784,0.165-1.458,0.628-1.895,1.303l-0.289,0.444    c-2.66-0.879-5.593-2.002-7.349-7.085l0.727-0.632h0c1.248-1.085,1.379-2.983,0.294-4.233l-4.808-5.531    c-0.362-0.417-0.994-0.46-1.411-0.099l-3.019,2.624c-2.648,2.302-1.411,5.707-1.004,6.826c0.018,0.05,0.04,0.098,0.066,0.145    c0.105,0.188,2.612,4.662,6.661,8.786c4.065,4.141,11.404,7.965,11.629,8.076c0.838,0.544,1.781,0.805,2.714,0.805    c1.638,0,3.244-0.803,4.202-2.275l2.178-3.354C40.066,31.413,39.934,30.794,39.471,30.493z M35.91,34.142    c-0.901,1.388-2.763,1.782-4.233,0.834c-0.073-0.038-7.364-3.835-11.207-7.75c-3.592-3.659-5.977-7.724-6.302-8.291    c-0.792-2.221-0.652-3.586,0.464-4.556l2.265-1.968l4.152,4.776c0.369,0.424,0.326,1.044-0.096,1.411l-1.227,1.066    c-0.299,0.26-0.417,0.671-0.3,1.049c2.092,6.798,6.16,8.133,9.13,9.108l0.433,0.143c0.433,0.146,0.907-0.021,1.155-0.403    l0.709-1.092c0.146-0.226,0.37-0.379,0.63-0.434c0.261-0.056,0.527-0.004,0.753,0.143l5.308,3.447L35.91,34.142z"
                                            data-original="#000000" class="active-path"/>
                                    <path d="M28.538,16.247c-0.532-0.153-1.085,0.156-1.236,0.688c-0.151,0.531,0.157,1.084,0.688,1.235    c1.49,0.424,2.677,1.613,3.097,3.104c0.124,0.44,0.525,0.729,0.962,0.729c0.09,0,0.181-0.012,0.272-0.037    c0.531-0.15,0.841-0.702,0.691-1.234C32.405,18.578,30.69,16.859,28.538,16.247z"
                                            data-original="#000000" class="active-path"/>
                                    <path d="M36.148,22.219c0.09,0,0.181-0.012,0.272-0.037c0.532-0.15,0.841-0.703,0.691-1.234c-1.18-4.183-4.509-7.519-8.689-8.709    c-0.531-0.153-1.084,0.158-1.235,0.689c-0.151,0.531,0.157,1.084,0.688,1.235c3.517,1,6.318,3.809,7.311,7.328    C35.311,21.931,35.711,22.219,36.148,22.219z"
                                            data-original="#000000" class="active-path"/>
                                    <path d="M27.991,7.582c-0.532-0.153-1.085,0.156-1.236,0.689c-0.151,0.531,0.157,1.084,0.688,1.235    c5.959,1.695,10.706,6.453,12.388,12.416c0.124,0.44,0.525,0.729,0.962,0.729c0.09,0,0.181-0.012,0.272-0.037    c0.531-0.15,0.841-0.703,0.691-1.234C39.887,14.753,34.613,9.467,27.991,7.582z"
                                            data-original="#000000" class="active-path"/>
                                </g>
                            </g>
                        </g>
                    </svg>
                    <span>Viber</span>
                </a></li>
                <? endif; ?>
                <? if (!empty($telegram))  : ?>
                <li class="messengers__item"><a href="https://telegram.im/<? print $telegram ?>" target="_blank" class="item__link">
                    <svg class="item__icon" height="20" viewBox="0 -39 512.00011 512" width="20"
                            xmlns="http://www.w3.org/2000/svg">
                        <path d="m504.09375 11.859375c-6.253906-7.648437-15.621094-11.859375-26.378906-11.859375-5.847656 0-12.042969 1.230469-18.410156 3.664062l-433.398438 165.441407c-23 8.777343-26.097656 21.949219-25.8984375 29.019531s4.0390625 20.046875 27.4999995 27.511719c.140626.042969.28125.085937.421876.125l89.898437 25.726562 48.617187 139.023438c6.628907 18.953125 21.507813 30.726562 38.835938 30.726562 10.925781 0 21.671875-4.578125 31.078125-13.234375l55.605469-51.199218 80.652344 64.941406c.007812.007812.019531.011718.027343.019531l.765625.617187c.070313.054688.144532.113282.214844.167969 8.964844 6.953125 18.75 10.625 28.308594 10.628907h.003906c18.675781 0 33.546875-13.824219 37.878906-35.214844l71.011719-350.640625c2.851563-14.074219.460937-26.667969-6.734375-35.464844zm-356.191406 234.742187 173.441406-88.605468-107.996094 114.753906c-1.769531 1.878906-3.023437 4.179688-3.640625 6.683594l-20.824219 84.351562zm68.132812 139.332032c-.71875.660156-1.441406 1.25-2.164062 1.792968l19.320312-78.25 35.144532 28.300782zm265.390625-344.566406-71.011719 350.644531c-.683593 3.355469-2.867187 11.164062-8.480468 11.164062-2.773438 0-6.257813-1.511719-9.824219-4.257812l-91.390625-73.585938c-.011719-.011719-.027344-.023437-.042969-.03125l-54.378906-43.789062 156.175781-165.949219c5-5.3125 5.453125-13.449219 1.074219-19.285156-4.382813-5.835938-12.324219-7.671875-18.820313-4.351563l-256.867187 131.226563-91.121094-26.070313 433.265625-165.390625c3.660156-1.398437 6.214844-1.691406 7.710938-1.691406.917968 0 2.550781.109375 3.15625.855469.796875.972656 1.8125 4.289062.554687 10.511719zm0 0"/>
                    </svg>
                    <span>Telegram</span>
                </a></li>
                <? endif; ?>
            </ul>
        </div>
    </header>
</div>
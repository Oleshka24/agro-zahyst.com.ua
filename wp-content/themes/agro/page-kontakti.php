<?php
/*
Template Name: Contacts
Template post type: page
*/
?>

<?
$phone_1 = carbon_get_theme_option('agro_phone_1');
$phone_1_mob = carbon_get_theme_option('agro_phone_1_mob');

$phone_2 = carbon_get_theme_option('agro_phone_2');
$phone_2_mob = carbon_get_theme_option('agro_phone_2_mob');

$viber = carbon_get_theme_option('agro_phone_viber');
$viber_mob = carbon_get_theme_option('agro_phone_viber_mob');

$telegram = carbon_get_theme_option('agro_phone_telegram');
$facebook = carbon_get_theme_option('agro_facebook');
$facebook_name = carbon_get_theme_option('agro_facebook_name');

$agro_adress_country = carbon_get_theme_option('agro_adress_country'.carbon_lang());
$agro_adress_city = carbon_get_theme_option('agro_adress_city'.carbon_lang());
$agro_adress_street = carbon_get_theme_option('agro_adress_street'.carbon_lang());
$agro_adress_index = carbon_get_theme_option('agro_adress_index'.carbon_lang());
$agro_adress_map = carbon_get_theme_option('agro_adress_map');

$agro_schedule = carbon_get_theme_option('agro_schedule'.carbon_lang());
$agro_email = carbon_get_theme_option('agro_email');

?>
<? get_header(); ?>

    <main class="info_page dostavka kontakti">
        <section class="breadcrumbs_wrapper">
            <div class="container">
                <div class="title">
                    <h1><? the_title(); ?></h1>
                </div>
                <div class="breadcrumbs">
                    <div class="breadcrumb-container">
                        <ul class="breadcrumb">
                            <?php
                            if (function_exists('yoast_breadcrumb')) {
                                yoast_breadcrumb('<div class="kama_breadcrumbs" id="breadcrumbs">', '</div>');
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container" itemscope itemtype="https://schema.org/Organization">
                <div class="wp-block-group">
                    <div class="wp-block-columns">
                        <div class="wp-block-column">
                            <h4 class="has-text-align-center"><? pll_e('Телефон')?></h4>
                            <ul class="contacts_list">
                                <? if (!empty($phone_1))  : ?>
                                    <li class="contact" itemprop="telephone">
                                        <svg class="phone_icon" enable-background="new 0 0 512.021 512.021" height="512"
                                             viewBox="0 0 512.021 512.021" width="512"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path d="m367.988 512.021c-16.528 0-32.916-2.922-48.941-8.744-70.598-25.646-136.128-67.416-189.508-120.795s-95.15-118.91-120.795-189.508c-8.241-22.688-10.673-46.108-7.226-69.612 3.229-22.016 11.757-43.389 24.663-61.809 12.963-18.501 30.245-33.889 49.977-44.5 21.042-11.315 44.009-17.053 68.265-17.053 7.544 0 14.064 5.271 15.645 12.647l25.114 117.199c1.137 5.307-.494 10.829-4.331 14.667l-42.913 42.912c40.482 80.486 106.17 146.174 186.656 186.656l42.912-42.913c3.837-3.837 9.36-5.466 14.667-4.331l117.199 25.114c7.377 1.581 12.647 8.101 12.647 15.645 0 24.256-5.738 47.224-17.054 68.266-10.611 19.732-25.999 37.014-44.5 49.977-18.419 12.906-39.792 21.434-61.809 24.663-6.899 1.013-13.797 1.518-20.668 1.519zm-236.349-479.321c-31.995 3.532-60.393 20.302-79.251 47.217-21.206 30.265-26.151 67.49-13.567 102.132 49.304 135.726 155.425 241.847 291.151 291.151 34.641 12.584 71.867 7.64 102.132-13.567 26.915-18.858 43.685-47.256 47.217-79.251l-95.341-20.43-44.816 44.816c-4.769 4.769-12.015 6.036-18.117 3.168-95.19-44.72-172.242-121.772-216.962-216.962-2.867-6.103-1.601-13.349 3.168-18.117l44.816-44.816z"/>
                                                <path d="m496.02 272c-8.836 0-16-7.164-16-16 0-123.514-100.486-224-224-224-8.836 0-16-7.164-16-16s7.164-16 16-16c68.381 0 132.668 26.628 181.02 74.98s74.98 112.639 74.98 181.02c0 8.836-7.163 16-16 16z"/>
                                                <path d="m432.02 272c-8.836 0-16-7.164-16-16 0-88.224-71.776-160-160-160-8.836 0-16-7.164-16-16s7.164-16 16-16c105.869 0 192 86.131 192 192 0 8.836-7.163 16-16 16z"/>
                                                <path d="m368.02 272c-8.836 0-16-7.164-16-16 0-52.935-43.065-96-96-96-8.836 0-16-7.164-16-16s7.164-16 16-16c70.58 0 128 57.42 128 128 0 8.836-7.163 16-16 16z"/>
                                            </g>
                                        </svg>
                                        <a href="tel:<? print $phone_1_mob; ?>"><? print $phone_1; ?></a>
                                    </li>
                                <? endif; ?>
                                <? if (!empty($phone_1))  : ?>
                                    <li class="contact" itemprop="telephone">
                                        <svg class="phone_icon" enable-background="new 0 0 512.021 512.021" height="512"
                                             viewBox="0 0 512.021 512.021" width="512"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path d="m367.988 512.021c-16.528 0-32.916-2.922-48.941-8.744-70.598-25.646-136.128-67.416-189.508-120.795s-95.15-118.91-120.795-189.508c-8.241-22.688-10.673-46.108-7.226-69.612 3.229-22.016 11.757-43.389 24.663-61.809 12.963-18.501 30.245-33.889 49.977-44.5 21.042-11.315 44.009-17.053 68.265-17.053 7.544 0 14.064 5.271 15.645 12.647l25.114 117.199c1.137 5.307-.494 10.829-4.331 14.667l-42.913 42.912c40.482 80.486 106.17 146.174 186.656 186.656l42.912-42.913c3.837-3.837 9.36-5.466 14.667-4.331l117.199 25.114c7.377 1.581 12.647 8.101 12.647 15.645 0 24.256-5.738 47.224-17.054 68.266-10.611 19.732-25.999 37.014-44.5 49.977-18.419 12.906-39.792 21.434-61.809 24.663-6.899 1.013-13.797 1.518-20.668 1.519zm-236.349-479.321c-31.995 3.532-60.393 20.302-79.251 47.217-21.206 30.265-26.151 67.49-13.567 102.132 49.304 135.726 155.425 241.847 291.151 291.151 34.641 12.584 71.867 7.64 102.132-13.567 26.915-18.858 43.685-47.256 47.217-79.251l-95.341-20.43-44.816 44.816c-4.769 4.769-12.015 6.036-18.117 3.168-95.19-44.72-172.242-121.772-216.962-216.962-2.867-6.103-1.601-13.349 3.168-18.117l44.816-44.816z"/>
                                                <path d="m496.02 272c-8.836 0-16-7.164-16-16 0-123.514-100.486-224-224-224-8.836 0-16-7.164-16-16s7.164-16 16-16c68.381 0 132.668 26.628 181.02 74.98s74.98 112.639 74.98 181.02c0 8.836-7.163 16-16 16z"/>
                                                <path d="m432.02 272c-8.836 0-16-7.164-16-16 0-88.224-71.776-160-160-160-8.836 0-16-7.164-16-16s7.164-16 16-16c105.869 0 192 86.131 192 192 0 8.836-7.163 16-16 16z"/>
                                                <path d="m368.02 272c-8.836 0-16-7.164-16-16 0-52.935-43.065-96-96-96-8.836 0-16-7.164-16-16s7.164-16 16-16c70.58 0 128 57.42 128 128 0 8.836-7.163 16-16 16z"/>
                                            </g>
                                        </svg>
                                        <a href="tel:<? print $phone_2_mob; ?>"><? print $phone_2; ?></a>
                                    </li>
                                <? endif; ?>
                                <li class="contact">
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
                                </li>
                            </ul>
                        </div>
                        <div class="wp-block-column">
                            <h4 class="has-text-align-center"><? pll_e('Соціальні мережі'); ?></h4>
                            <ul class="contacts_list">
                                <? if (!empty($viber))  : ?>
                                    <li class="contact">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Capa_1" x="0px"
                                             y="0px"
                                             viewBox="0 0 52.511 52.511" xml:space="preserve" width="512px"
                                             height="512px"
                                             class="phone_icon"><g>
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
                                        <a href="viber://chat?number=<? print $viber_mob; ?>">Viber: <span
                                                    class="number"><? print $viber; ?></span></a>
                                    </li>
                                <? endif; ?>
                                <? if (!empty($telegram))  : ?>
                                    <li class="contact">
                                        <svg class="phone_icon" height="512pt" viewBox="0 -39 512.00011 512"
                                             width="512pt"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="m504.09375 11.859375c-6.253906-7.648437-15.621094-11.859375-26.378906-11.859375-5.847656 0-12.042969 1.230469-18.410156 3.664062l-433.398438 165.441407c-23 8.777343-26.097656 21.949219-25.8984375 29.019531s4.0390625 20.046875 27.4999995 27.511719c.140626.042969.28125.085937.421876.125l89.898437 25.726562 48.617187 139.023438c6.628907 18.953125 21.507813 30.726562 38.835938 30.726562 10.925781 0 21.671875-4.578125 31.078125-13.234375l55.605469-51.199218 80.652344 64.941406c.007812.007812.019531.011718.027343.019531l.765625.617187c.070313.054688.144532.113282.214844.167969 8.964844 6.953125 18.75 10.625 28.308594 10.628907h.003906c18.675781 0 33.546875-13.824219 37.878906-35.214844l71.011719-350.640625c2.851563-14.074219.460937-26.667969-6.734375-35.464844zm-356.191406 234.742187 173.441406-88.605468-107.996094 114.753906c-1.769531 1.878906-3.023437 4.179688-3.640625 6.683594l-20.824219 84.351562zm68.132812 139.332032c-.71875.660156-1.441406 1.25-2.164062 1.792968l19.320312-78.25 35.144532 28.300782zm265.390625-344.566406-71.011719 350.644531c-.683593 3.355469-2.867187 11.164062-8.480468 11.164062-2.773438 0-6.257813-1.511719-9.824219-4.257812l-91.390625-73.585938c-.011719-.011719-.027344-.023437-.042969-.03125l-54.378906-43.789062 156.175781-165.949219c5-5.3125 5.453125-13.449219 1.074219-19.285156-4.382813-5.835938-12.324219-7.671875-18.820313-4.351563l-256.867187 131.226563-91.121094-26.070313 433.265625-165.390625c3.660156-1.398437 6.214844-1.691406 7.710938-1.691406.917968 0 2.550781.109375 3.15625.855469.796875.972656 1.8125 4.289062.554687 10.511719zm0 0"/>
                                        </svg>
                                        <a href="https://telegram.im/<? print $telegram ?>" target="_blank">Telegram:
                                            <span
                                                    class="number"><? print $telegram ?></span></a>
                                    </li>
                                <? endif; ?>
                                <? if (!empty($facebook))  : ?>
                                    <li class="contact">
                                        <svg class="phone_icon" enable-background="new 0 0 24 24" height="512"
                                             viewBox="0 0 24 24"
                                             width="512" xmlns="http://www.w3.org/2000/svg">
                                            <path d="m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z"/>
                                        </svg>
                                        <a href="<? print $facebook; ?>" target="_blank">Facebook: <span
                                                    class="link"><? print $facebook_name; ?></span></a>
                                    </li>
                                <? endif; ?>
                            </ul>
                        </div>
                        <div class="wp-block-column" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                            <h4 class="has-text-align-center"><? pll_e('Наш офіс'); ?></h4>
                            <ul class="contacts_list">
                                <? if (!empty($agro_adress_country) || !empty($agro_adress_city) || !empty($agro_adress_street))  : ?>
                                    <li class="contact">
                                        <svg enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512"
                                             width="512" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path d="m361 166c0-58.049-47.116-106-105-106-57.809 0-105 47.884-105 106 0 57.897 47.103 105 105 105s105-47.103 105-105zm-180 0c0-41.907 33.645-76 75-76s75 34.093 75 76c0 41.355-33.645 75-75 75s-75-33.645-75-75z"/>
                                                <path d="m421 166c0-91.012-73.881-166-165-166-86.015 0-165 68.718-165 166 0 60.654 59.386 152.311 94.646 202.675-39.197 7.878-94.646 28.221-94.646 68.325 0 57.35 106.821 75 165 75 58.184 0 165-17.651 165-75 0-40.106-55.454-60.448-94.646-68.325 35.079-50.105 94.646-141.951 94.646-202.675zm-300 0c0-84.003 70.075-136 135-136 74.439 0 135 61.009 135 136 0 63.524-88.762 188.742-135.001 247.145-46.243-58.391-134.999-183.582-134.999-247.145zm270 271c0 25.061-73.461 45-135 45-61.457 0-135-19.955-135-45 0-11.939 26.796-32.636 84.08-41.282 21.878 29.688 38.345 49.615 39.371 50.853 2.849 3.439 7.083 5.429 11.549 5.429s8.7-1.99 11.549-5.429c1.026-1.238 17.493-21.165 39.371-50.853 57.284 8.646 84.08 29.343 84.08 41.282z"/>
                                            </g>
                                        </svg>
                                       <? pll_e('Адрес')?>:
                                        <? if(!empty($agro_adress_country)){ ?>
                                            <span itemprop="addressCountry"><? print $agro_adress_country; ?></span>
                                        <? } if(!empty($agro_adress_city)){ ?>
                                            <span itemprop="addressLocality"><? print $agro_adress_city; ?></span>
                                        <? } if(!empty($agro_adress_street)){ ?>
                                            <span itemprop="streetAddress" ><? print $agro_adress_street; ?></span>
                                        <? } if(!empty($agro_adress_index)){ ?>
                                            <meta itemprop="postalCode" content="<? print $agro_adress_index; ?>">
                                        <? } ?>
                                    </li>
                                <? endif; ?>
                                <? if (!empty($agro_schedule))  : ?>
                                    <li class="contact">
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" x="0px"
                                             y="0px"
                                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"
                                             xml:space="preserve">
                                                <g>
                                                    <g>
                                                        <g>
                                                            <circle cx="386" cy="210" r="20"/>
                                                            <path d="M432,40h-26V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v20h-91V20c0-11.046-8.954-20-20-20
                                                                c-11.046,0-20,8.954-20,20v20h-90V20c0-11.046-8.954-20-20-20s-20,8.954-20,20v20H80C35.888,40,0,75.888,0,120v312
                                                                c0,44.112,35.888,80,80,80h153c11.046,0,20-8.954,20-20c0-11.046-8.954-20-20-20H80c-22.056,0-40-17.944-40-40V120
                                                                c0-22.056,17.944-40,40-40h25v20c0,11.046,8.954,20,20,20s20-8.954,20-20V80h90v20c0,11.046,8.954,20,20,20s20-8.954,20-20V80h91
                                                                v20c0,11.046,8.954,20,20,20c11.046,0,20-8.954,20-20V80h26c22.056,0,40,17.944,40,40v114c0,11.046,8.954,20,20,20
                                                                c11.046,0,20-8.954,20-20V120C512,75.888,476.112,40,432,40z"/>
                                                            <path d="M391,270c-66.72,0-121,54.28-121,121s54.28,121,121,121s121-54.28,121-121S457.72,270,391,270z M391,472
                                                                c-44.663,0-81-36.336-81-81s36.337-81,81-81c44.663,0,81,36.336,81,81S435.663,472,391,472z"/>
                                                            <path d="M420,371h-9v-21c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v41c0,11.046,8.954,20,20,20h29
                                                                c11.046,0,20-8.954,20-20C440,379.954,431.046,371,420,371z"/>
                                                            <circle cx="299" cy="210" r="20"/>
                                                            <circle cx="212" cy="297" r="20"/>
                                                            <circle cx="125" cy="210" r="20"/>
                                                            <circle cx="125" cy="297" r="20"/>
                                                            <circle cx="125" cy="384" r="20"/>
                                                            <circle cx="212" cy="384" r="20"/>
                                                            <circle cx="212" cy="210" r="20"/>
                                                        </g>
                                                    </g>
                                                </g>
                                                </svg>

                                        <? pll_e('Графік роботи')?>: <span
                                                    class="number"><? print $agro_schedule ?></span>
                                    </li>
                                <? endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <? if (!empty($agro_email))  : ?>
                    <div class="wp-block-group email_group">
                        <h5><? pll_e('Партнерство та співпраця');?></h5>
                        <p><? pll_e('Всі пропозиції надсилайте нам')?> email: <a
                                    href="mailto:<? print $agro_email; ?>" ><span itemprop="email"><? print $agro_email; ?></span></a></p>
                    </div>
                <? endif; ?>
                <? the_post();
                the_content(); ?>
            </div>
        </section>
    </main>
<? get_footer(); ?>
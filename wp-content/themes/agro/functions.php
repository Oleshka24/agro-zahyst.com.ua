<?php

function no_link_current_page($p)
{
    return preg_replace('%((current_page_item|current-menu-item)[^<]+)[^>]+>([^<]+)</a>%', '$1<a>$3</a>', $p, 1);
}

add_filter('wp_nav_menu', 'no_link_current_page');

function agro_setup()
{
    load_theme_textdomain('wpagro');

    add_theme_support('title-tag');

    add_theme_support('custom-logo', array(
        'height' => 58,
        'width' => 220,
        'flex-height' => true,
    ));

    add_theme_support('post-thumbnails');

    set_post_thumbnail_size(306, 226);

    add_theme_support('html5', array(
        'search_form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ));

    add_theme_support('post-formats', array(
        'aside',
        'image',
        'video',
        'gallery'
    ));

    register_nav_menu('primary', 'Главное меню');
    register_nav_menu('footer', 'Футер');

}

add_action('after_setup_theme', 'agro_setup');


//Подключаю Carbonfields для вывода своих дополнительных полей https://carbonfields.net/
function crb_load()
{
    require_once(get_template_directory() . '/assets/vendor/autoload.php');
    \Carbon_Fields\Carbon_Fields::boot();
}

//Подключаю Carbonfields для вывода своих дополнительных полей https://carbonfields.net/

add_action('after_setup_theme', 'crb_load');

use Carbon_Fields\Container;
use Carbon_Fields\Field;

//Добавление настроек полей темы в админку
function agro_attach_theme_options()
{
    Container::make('theme_options', 'Опции темы')
        ->add_fields(array(
                    Field::make('text', 'agro_phone_1', 'Номер телефона 1')->set_width(25),
            Field::make('text', 'agro_phone_1_mob', 'Номер телефона 1')->set_width(25)->help_text(' (для набора с мобильного, без пробелов)'),
            Field::make('text', 'agro_phone_2', 'Номер телефона 2')->set_width(25),
            Field::make('text', 'agro_phone_2_mob', 'Номер телефона 2')->set_width(25)->help_text(' (для набора с мобильного, без пробелов)'),
            Field::make('text', 'agro_phone_viber', 'Номер телефона для Viber')->set_width(30),
            Field::make('text', 'agro_phone_viber_mob', 'Номер телефона Viber')->set_width(30)->help_text(' (для набора с мобильного, без пробелов)'),
            Field::make('text', 'agro_phone_telegram', 'Логин в Telegram')->set_width(30),
            Field::make('text', 'agro_facebook', 'Ссылка на Facebook')->set_width(50)->help_text(' (полная ссылка на сайт)'),
            Field::make('text', 'agro_facebook_name', 'Название страницы на Facebook')->set_width(50),
            Field::make('text', 'agro_adress_country' . carbon_lang(), 'Страна компании')->set_width(16.5),
            Field::make('text', 'agro_adress_city' . carbon_lang(), 'Город компании')->set_width(16.5),
            Field::make('text', 'agro_adress_street' . carbon_lang(), 'Улица/дом компании')->set_width(16.5),
            Field::make('text', 'agro_adress_index' . carbon_lang(), 'Индекс города(Микроразметка)')->set_width(16.5),
            Field::make('text', 'agro_adress_map', 'Ссылка на геопозицию компании (гугл-карту)')->set_width(33),
            Field::make('text', 'agro_schedule' . carbon_lang(), 'График работы')->set_width(50),
            Field::make('text', 'agro_email', 'Электронная почта для сотрудничества')->set_width(50),
            Field::make('text', 'agro_copyright' . carbon_lang(), 'Текст поля Copyright')->set_width(100)
        ))
        ->add_fields(array(
            Field::make('text', 'advantage_1_title' . carbon_lang(), 'Преимущество 1 (заголовок)')->set_width(25),
            Field::make('textarea', 'advantage_1_text' . carbon_lang(), 'Преимущество 1 (описание)')->set_width(25),

            Field::make('text', 'advantage_2_title' . carbon_lang(), 'Преимущество 2 (заголовок)')->set_width(25),
            Field::make('textarea', 'advantage_2_text' . carbon_lang(), 'Преимущество 2 (описание)')->set_width(25),

            Field::make('text', 'advantage_3_title' . carbon_lang(), 'Преимущество 3 (заголовок)')->set_width(25),
            Field::make('textarea', 'advantage_3_text' . carbon_lang(), 'Преимущество 3 (описание)')->set_width(25),

            Field::make('text', 'advantage_4_title' . carbon_lang(), 'Преимущество 4 (заголовок)')->set_width(25),
            Field::make('textarea', 'advantage_4_text' . carbon_lang(), 'Преимущество 4 (описание)')->set_width(25),

        ))
        ->add_fields(array(
            Field::make('text', 'map_title' . carbon_lang(), 'Заголовок блока с картой')->set_width(100),
            Field::make('complex', 'legend_list' . carbon_lang(), 'Условные обозначения для карты')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                        Field::make('color', 'legend_color' . carbon_lang(), 'Цвет')->set_width(50),
                        Field::make('text', 'legend_text' . carbon_lang(), 'Описание')->set_width(50)
                    )
                ),
            Field::make('image', 'map_image', 'Изображение карты')->set_width(100),


        ))
        ->add_fields(array(
            Field::make('radio', 'info_block_button', 'Отображать блок вопрос-ответ?')
                ->add_options(array(
                    'off' => 'Нет',
                    'on' => 'Да',
                )),
            Field::make('text', 'info_block_title' . carbon_lang(), 'Заголовок блока Вопрос-ответ')->set_conditional_logic(array(
                'relation' => 'OR',
                array(
                    'value' => 'on',
                    'compare' => '=',
                    'field' => 'info_block_button',

                )
            )),
            Field::make('complex', 'info_block' . carbon_lang(), 'Вопрос-ответ')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                        Field::make('text', 'info_title' . carbon_lang(), 'Вопрос')->set_width(100),
                        Field::make('textarea', 'info_text' . carbon_lang(), 'Ответ')->set_width(100)
                    )
                )
                ->set_conditional_logic(array(
                    'relation' => 'OR',
                    array(
                        'value' => 'on',
                        'compare' => '=',
                        'field' => 'info_block_button',

                    )
                )),

        ))
        ->add_fields(array(
            Field::make('radio', 'partners_block_button', 'Отображать список партнеров?')
                ->add_options(array(
                    'off' => 'Нет',
                    'on' => 'Да',
                )),
            Field::make('text', 'partners_block_title' . carbon_lang(), 'Заголовок блока Наши партнеры')->set_conditional_logic(array(
                'relation' => 'OR',
                array(
                    'value' => 'on',
                    'compare' => '=',
                    'field' => 'partners_block_button',

                )
            )),
            Field::make('complex', 'partners_block' , 'Наши партнеры')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                        Field::make('image', 'partner_image', 'Логотип')->set_width(100),
                    )
                )
                ->set_conditional_logic(array(
                    'relation' => 'OR',
                    array(
                        'value' => 'on',
                        'compare' => '=',
                        'field' => 'partners_block_button',

                    )
                )),
            Field::make('complex', 'dostavka_i_oplata_list'.carbon_lang(), 'Список блоков в карточке товара')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('text', 'dostavka_title'.carbon_lang(), 'Заголовок')->set_width(50),
                    Field::make('rich_text', 'dostavka_link'.carbon_lang(), 'Описание')->set_width(50)->help_text(''),
                    Field::make('image', 'dostavka_icon'.carbon_lang(), 'Иконка')->set_width(50),
                )),
        ))
        
        ->add_fields(array(
            Field::make('textarea', 'agro_wpcf7mailsent_ok' . carbon_lang(), 'Уведомление при успешной отправка формы "Быстрый заказ" вне рабочего времени.')->set_width(50),
            Field::make( 'time', 'agro_wpcf7mailsent_timestart', 'Время С которого начнет отображаться уведомление (AM — до полудня, PM — после полудня)' )->set_width(25),
            Field::make( 'time', 'agro_wpcf7mailsent_timeend', 'Время ДО которого будет отображаться уведомление (AM — до полудня, PM — после полудня)' )->set_width(25)
        ))
    
        ->add_fields(array(
            Field::make('checkbox', 'fnd-form', 'Отображать форму "Нашли дешевле"?')->set_width(100),
            Field::make('checkbox', 'fnd-form-product', 'Отображать кнопку "Нашли дешевле" на карточке товара?')->set_width(50),
            Field::make('checkbox', 'fnd-form-home', 'Отображать кнопку "Нашли дешевле" на главной странице?')->set_width(50),
            Field::make('checkbox', 'fnd-form-search', 'Отображать кнопку "Нашли дешевле" на странице поиска?')->set_width(50),
            Field::make('checkbox', 'fnd-form-single-product', 'Отображать кнопку "Нашли дешевле" на странице товара?')->set_width(50),
            
            Field::make('checkbox', 'interesting-products', 'Отображать блок "Вас может заинтересовать" на странице корзины?')->set_width(100),
        ));      
}

//Добавление настроек полей темы в админку

add_action('carbon_fields_register_fields', 'agro_attach_theme_options');

//Регистрирую вывод дополнительных полей на Главной странице
function home_page_fields()
{
    Container::make('post_meta', __('Слайдер на главной странице', 'home_page_slider'))
        ->where('post_id', '=', 29)
        ->or_where('post_id', '=', 1801)
        ->add_fields(array(
            Field::make('complex', 'home_page_slider_list', 'Изображения слайдера')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('image', 'home_page_slider_image', 'Изображение')->set_width(50),
                    Field::make('text', 'home_page_slider_title', 'Заголовок')->set_width(50),
                    Field::make('text', 'home_page_slider_button', 'Текст кнопки')->set_width(50),
                    Field::make('text', 'home_page_slider_link', 'Ссылка кнопки (относительная)')->set_width(50),
                )),
        ));

    Container::make('post_meta', __('Категории с изображениями', 'home_page_category'))
        ->where('post_id', '=', 29)
        ->or_where('post_id', '=', 1801)
        ->add_fields(array(
            Field::make('complex', 'home_page_categories_list', 'Список категорий')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('image', 'home_page_category_image', 'Изображение')->set_width(100),
                    Field::make('text', 'home_page_category_title', 'Заголовок')->set_width(50),
                    Field::make('text', 'home_page_category_link', 'Ссылка кнопки (относительная)')->set_width(50),
                )),
        ));
}

//Регистрирую вывод дополнительных полей на Главной странице
add_action('carbon_fields_register_fields', 'home_page_fields');

//Регистрирую вывод дополнительных полей на странице О компании
function o_nas_page_fields()
{
    Container::make('post_meta', __('Основные настройки', 'main_settings_o_nas'))
        ->where('post_id', '=', 52)
        ->or_where('post_id', '=', 209)
        ->add_fields(array(
            Field::make('image', 'o_nas_background', 'Фоновое изображение'),
        ));

}

//Регистрирую вывод дополнительных полей на странице О компании
add_action('carbon_fields_register_fields', 'o_nas_page_fields');


function product_page()
{
    Container::make('post_meta', __('Блок вопрос-ответ', 'question_answer'))
        ->where('post_type', '=', 'product' )
        ->add_fields(array(
            Field::make('radio', 'question_answer_block_button', 'Отображать блок вопрос-ответ?')
                ->add_options(array(
                    'off' => 'Нет',
                    'on' => 'Да',
                )),
            Field::make('text', 'question_answer_block_title' . carbon_lang(), 'Заголовок блока Вопрос-ответ')->set_conditional_logic(array(
                'relation' => 'OR',
                array(
                    'value' => 'on',
                    'compare' => '=',
                    'field' => 'question_answer_block_button',
                )
            )),
            Field::make('complex', 'question_answer_block' . carbon_lang(), 'Вопрос-ответ')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                        Field::make('text', 'question_answer_title' . carbon_lang(), 'Вопрос')->set_width(100),
                        Field::make('textarea', 'question_answer_text' . carbon_lang(), 'Ответ')->set_width(100)
                    )
                )
                ->set_conditional_logic(array(
                    'relation' => 'OR',
                    array(
                        'value' => 'on',
                        'compare' => '=',
                        'field' => 'question_answer_block_button',

                    )
                )),
        ));
}
//Регистрирую вывод дополнительных полей на странице Товаров
add_action('carbon_fields_register_fields', 'product_page');

function category_product_page()
{
    Container::make( 'term_meta', 'Блок вопрос-ответ' )
        ->show_on_taxonomy( 'product_cat' )
        ->add_fields(array(
            Field::make('radio', 'question_answer_block_button', 'Отображать блок вопрос-ответ?')
                ->add_options(array(
                    'off' => 'Нет',
                    'on' => 'Да',
                )),
            Field::make('text', 'question_answer_block_title' . carbon_lang(), 'Заголовок блока Вопрос-ответ')->set_conditional_logic(array(
                'relation' => 'OR',
                array(
                    'value' => 'on',
                    'compare' => '=',
                    'field' => 'question_answer_block_button',
                )
            )),
            Field::make('complex', 'question_answer_block' . carbon_lang(), 'Вопрос-ответ')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                        Field::make('text', 'question_answer_title' . carbon_lang(), 'Вопрос')->set_width(100),
                        Field::make('textarea', 'question_answer_text' . carbon_lang(), 'Ответ')->set_width(100)
                    )
                )
                ->set_conditional_logic(array(
                    'relation' => 'OR',
                    array(
                        'value' => 'on',
                        'compare' => '=',
                        'field' => 'question_answer_block_button',

                    )
                )),
        ));
}
//Регистрирую вывод дополнительных полей на странице категорий Товаров
add_action('carbon_fields_register_fields', 'category_product_page');


function bulbs_load_resources()

    //Подключаю стили

{
    // wp_enqueue_style('fonts', get_template_directory_uri() . '/assets/css/fonts.css');
    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css');
    wp_enqueue_style('owl-theme', get_template_directory_uri() . '/assets/css/owl.theme.default.min.css');
    wp_enqueue_style('fancybox', get_template_directory_uri() . '/assets/css/jquery.fancybox.min.css');
    wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_style('adaptive', get_template_directory_uri() . '/assets/css/adaptive.css');
    wp_enqueue_style('customizer', get_template_directory_uri() . '/assets/css/customizer.css');

//Подключаю скрипты

    wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-2.2.4.min.js', array(), '1.0,0', true);
		wp_enqueue_script('mask', get_template_directory_uri() . '/assets/js/mask.js', array(), '1.0,0', true);
    wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), '1.0,0', true);
    wp_enqueue_script('fancybox', get_template_directory_uri() . '/assets/js/jquery.fancybox.min.js', array(), '1.0,0', true);
    wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0,0', true);
    wp_enqueue_script('customizer', get_template_directory_uri() . '/assets/js/customizer.js', array(), '1.0,0', true);
};

add_action('wp_enqueue_scripts', 'bulbs_load_resources');


function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'    => 300,

        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ) );
}

add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );


function my_woocommerce_before_cart() {
    // some your code
}
add_action( 'woocommerce_before_cart', 'my_woocommerce_before_cart' );

add_action('widgets_init', 'register_my_widgets');
function register_my_widgets()
{
    register_sidebar(array(
        'name' => "Виджет фильтра",
        'id' => 'filter',
        'description' => '',
        'class' => '',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => "</li>\n",
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => "</h2>\n",
    ));
    
    register_sidebar(array(
        'id' => 'content',
        'name' => 'Content Sidebar',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<div>',
        'after_title' => '</div>',
    ));    
}


//Исключаю страницы из поиска
function searchExcludePages($query)
{
    if ($query->is_search) {
        $query->set('post_type', 'product');
    }
    return $query;
}

add_filter('pre_get_posts', 'searchExcludePages');




// Общая локализация
add_action('init', function () {
    pll_register_string('search-site', 'Поиск');
    pll_register_string('search-result', 'Результаты поиска');
    pll_register_string('search-error', 'По Вашему запросу ничего не найдено');
    pll_register_string('search-error-2', 'Поискать ещё');
    pll_register_string('404crumb', 'Cтраница, которую вы ищете, не существует');
    pll_register_string('back-home', 'Вернуться на главную');
    pll_register_string('phone', 'Телефон');
    pll_register_string('partners_title', 'Партнерство та співпраця');
    pll_register_string('partners_proposal', 'Всі пропозиції надсилайте нам');
    pll_register_string('social', 'Соціальні мережі');
    pll_register_string('office', 'Наш офіс');
    pll_register_string('address', 'Адрес');
    pll_register_string('schedule', 'Графік роботи');
    pll_register_string('cart', 'Корзина');
    pll_register_string('outofsctock', 'Немає в наявності');
    pll_register_string('more', 'Детальніше');
    pll_register_string('my_account', 'Мій аккаунт');
    pll_register_string('login', 'Увійти / Реєстрація');
    pll_register_string('call-back', 'Замовити дзвінок');
    pll_register_string('popular', 'Топ продаж');
    pll_register_string('related', 'Останні надходження');
    pll_register_string('to_cart', 'У кошик');
});


function carbon_lang()
{
    $suffix = '';
    if (!defined('ICL_LANGUAGE_CODE')) {
        return $suffix;
    }
    $suffix = '_' . ICL_LANGUAGE_CODE;
    return $suffix;
}

add_action( 'after_setup_theme', 'yourtheme_setup' );
function yourtheme_setup() {
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

add_filter( 'loop_shop_per_page', function ( $cols ) {
    // $cols contains the current number of products per page based on the value stored on Options -> Reading
    // Return the number of products you wanna show per page.
    return 9;
}, 10 );


add_filter('wc_ukr_shipping_get_nova_poshta_translates', function ($translates) {
    $currentLanguage = wp_doing_ajax() ? $_COOKIE['pll_language'] : pll_current_language();

    if ($currentLanguage === 'uk') {
        // Возвращаем украинские переводы
        return [
            'method_title' => 'Доставка службою Нова Пошта (за тарифом перевізника)',
            'block_title' => 'Вкажіть відділення доставки',
            'placeholder_area' => 'Оберіть область',
            'placeholder_city' => 'Оберіть місто',
            'placeholder_warehouse' => 'Оберіть відділення',
            'address_title' => 'Потрібна адресна доставка',
            'address_placeholder' => 'Введіть адресу доставки'
        ];
    }

    // Возвращаем русские переводы
    return [
        'method_title' => 'Доставка службой Новая Почта (по тарифу перевозчика)',
        'block_title' => 'Укажите отделение доставки',
        'placeholder_area' => 'Выберите область',
        'placeholder_city' => 'Выберите город',
        'placeholder_warehouse' => 'Выберите отделение',
        'address_title' => 'Нужна адресная доставка',
        'address_placeholder' => 'Введите адрес доставки'
    ];
});

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {

$fields['billing']['billing_state']['required'] = false;
$fields['billing']['billing_city']['required'] = false;
$fields['billing']['billing_country']['required'] = false;
$fields['billing']['billing_last_name']['required'] = false;
$fields['billing']['billing_address_1']['required'] = false;
$fields['billing']['billing_address_2']['required'] = false;
$fields['billing']['billing_postcode']['required'] = false;
$fields['billing']['billing_email']['required'] = false;

$fields['billing']['billing_first_name']['label']="Ф.И.О.";

unset($fields['billing']['billing_last_name']);
// unset($fields['billing']['billing_city']);
unset($fields['billing']['billing_address_1']);
unset($fields['billing']['billing_company']);
unset($fields['billing']['billing_address_2']);
// unset($fields['billing']['billing_country']);
unset($fields['billing']['billing_state']);
unset($fields['billing']['billing_postcode']);

return $fields;
}


// function skip_cart_page_redirection_to_checkout() {

//     if( is_cart() )
//         wp_redirect( wc_get_checkout_url() );
// }
// add_action('template_redirect', 'skip_cart_page_redirection_to_checkout');

add_filter( 'woocommerce_product_tabs', 'woo_reorder_tabs', 98 );
function woo_reorder_tabs( $tabs ) {
//   $tabs['additional_information']['priority'] = 1;  // вкладка Атрибуты
     $tabs['description']['priority'] = 1;    // вкладка Описание
//   $tabs['reviews']['priority'] = 65;    // Вкладка Отзывы
  return $tabs;
}

add_filter( 'woocommerce_currencies', 'add_my_currency' );

function add_my_currency( $currencies ) {

     $currencies['UAH'] = __( 'Українська гривня', 'woocommerce' );

     return $currencies;

}

add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);
function add_my_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
         case 'UAH': $currency_symbol = 'грн'; break;
     }
     return $currency_symbol;
}

add_filter( 'get_search_form', 'header_form_search' );
function header_form_search( $form ) {

	$form = '
	<div itemscope itemtype="https://schema.org/WebSite">
        <meta itemprop="url" content="'.get_site_url( null, "", "https" ).'"/>
        <form itemprop="potentialAction" itemscope itemtype="https://schema.org/SearchAction" action="' . esc_url( home_url( '/' ) ) . '" role="search" method="get" class="search_form">
            <label for="s">' . _e('', 'mytextdomain') . '</label>
            <meta itemprop="target" content="'.get_site_url( null, "", "https" ).'/?s={s}"/>
            <input itemprop="query-input" type="text" name="s" id="s" class="search-input" value="" placeholder="' . pll__('Поиск') . '"
                data-swplive="true">
            <!-- data-swplive="true" enables SearchWP Live Search -->
            <button type="submit" class="search-btn">' .  _e('', 'mytextdomain') . '</button>
        </form>
    </div>';

	return $form;
}







add_action( 'template_redirect', 'truemisha_recently_viewed_product_cookie', 20 );
 
function truemisha_recently_viewed_product_cookie() { 
 
	if ( empty( $_COOKIE[ 'woocommerce_recently_viewed_2' ] ) ) {
		$viewed_products = array();
	} else {
		$viewed_products = (array) explode( '|', $_COOKIE[ 'woocommerce_recently_viewed_2' ] );
	}
 
	// добавляем в массив текущий товар
	if ( ! in_array( get_the_ID(), $viewed_products ) ) {
		$viewed_products[] = get_the_ID();
	}
 
	// нет смысла хранить там бесконечное количество товаров
	if ( sizeof( $viewed_products ) > 4 ) {
		array_shift( $viewed_products ); // выкидываем первый элемент
	}
 
 	// устанавливаем в куки
	wc_setcookie( 'woocommerce_recently_viewed_2', join( '|', $viewed_products ) );
 
}

add_shortcode( 'recently_viewed_products', 'truemisha_recently_viewed_products' );
 
function truemisha_recently_viewed_products() {
 
	if( empty( $_COOKIE[ 'woocommerce_recently_viewed_2' ] ) ) {
		$viewed_products = array();
	} else {
		$viewed_products = (array) explode( '|', $_COOKIE[ 'woocommerce_recently_viewed_2' ] );
	}
 
	if ( empty( $viewed_products ) ) {
		return;
	}
 
	// надо ведь сначала отображать последние просмотренные
	$viewed_products = array_reverse( array_map( 'absint', $viewed_products ) );
 
    if (get_locale() == 'uk')
	    $title = 'Вас може зацікавити';

    else if (get_locale() == 'ru_RU')
        $title = 'Вас может заинтересовать';
 
	$product_ids = join( ",", $viewed_products );
    $productList = do_shortcode( "[products ids='$product_ids']" );
    if (strlen($productList) > 100)
	    return '<div class="products top_sales interesting-products">
                    <div class="container">
                        <div class="products_wrap">
                            <div class="title">
                                <h2>' . $title . '</h2>
                            </div>' 
                            . $productList . 
                        '</div>
                    </div>
                </div>';
    else 
        return;
}

/**
 * Order product collections by stock status, instock products first.
 */
class iWC_Orderby_Stock_Status
{
 
	public function __construct()
	{
		// Check if WooCommerce is active
		if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
			add_filter('posts_clauses', array($this, 'order_by_stock_status'), 2000);
		}
	}
 
	public function order_by_stock_status($posts_clauses)
	{
		global $wpdb;
		// only change query on WooCommerce loops
		if (is_woocommerce() && (is_shop() || is_product_category() || is_product_tag())) {
			$posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
			$posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
			$posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
		}
		return $posts_clauses;
	}
}
 
new iWC_Orderby_Stock_Status;




function sortByPriceTextReplace( $text ) {
	if ( $text == 'Сортувати за ціною: від нижчої до вищої' ) {
		$text = 'Від дешевих до дорогих';
	} 
    elseif ( $text == 'Сортувати за ціною: від вищої до нижчої' ) {
		$text = 'Від дорогих до дешевих';
	}
    elseif ( $text == 'Цены: по возрастанию' ) {
		$text = 'От дешёвых к дорогим';
	}
    elseif ( $text == 'Цены: по убыванию' ) {
		$text = 'От дорогих к дешёвым';
	}
	return $text;
}
add_filter( 'gettext', 'sortByPriceTextReplace', 20 );
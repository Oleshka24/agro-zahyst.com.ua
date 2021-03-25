<?php defined( 'ABSPATH' ) OR exit;
/*
Plugin Name: XML for Google Merchant Center
Description: Connect your store to Google Merchant Center and unload products, getting new customers!
Tags: xml, google, Google Merchant Center, export, woocommerce
Author: Maxim Glazunov
Author URI: https://icopydoc.ru
License: GPLv2
Version: 2.3.3
Text Domain: xml-for-google-merchant-center
Domain Path: /languages/
WC requires at least: 3.0.0
WC tested up to: 4.8.0
*/
/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : djdiplomat@yandex.ru)
	// https://support.google.com/merchants/answer/7052112 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
require_once plugin_dir_path(__FILE__).'/functions.php'; // Подключаем файл функций
require_once plugin_dir_path(__FILE__).'/offer.php';
register_activation_hook(__FILE__, array('XmlforGoogleMerchantCenter', 'on_activation'));
register_deactivation_hook(__FILE__, array('XmlforGoogleMerchantCenter', 'on_deactivation'));
register_uninstall_hook(__FILE__, array('XmlforGoogleMerchantCenter', 'on_uninstall'));
add_action('plugins_loaded', array('XmlforGoogleMerchantCenter', 'init'));
add_action('plugins_loaded', 'xfgmc_load_plugin_textdomain'); // load translation
function xfgmc_load_plugin_textdomain() {
 load_plugin_textdomain('xfgmc', false, dirname(plugin_basename(__FILE__)).'/languages/');
}
class XmlforGoogleMerchantCenter {
 protected static $instance;
 public static function init() {
	is_null( self::$instance ) AND self::$instance = new self;
	return self::$instance;
 }
	
 public function __construct() {
	// xfgmc_DIR contains /home/p135/www/site.ru/wp-content/plugins/myplagin/
	define('xfgmc_DIR', plugin_dir_path(__FILE__)); 
	// xfgmc_URL contains http://site.ru/wp-content/plugins/myplagin/
	define('xfgmc_URL', plugin_dir_url(__FILE__));
	// xfgmc_UPLOAD_DIR contains /home/p256/www/site.ru/wp-content/uploads
	$upload_dir = (object)wp_get_upload_dir();
	define('xfgmc_UPLOAD_DIR', $upload_dir->basedir);
	// xfgmc_UPLOAD_DIR contains /home/p256/www/site.ru/wp-content/uploads/xfgmc
	$name_dir = $upload_dir->basedir."/xfgmc"; 
	define('xfgmc_NAME_DIR', $name_dir);
	$xfgmc_keeplogs = xfgmc_optionGET('xfgmc_keeplogs');
	define('xfgmc_KEEPLOGS', $xfgmc_keeplogs);
	define('xfgmc_VER', '2.3.3');
	$xfgmc_version = xfgmc_optionGET('xfgmc_version');
  	if ($xfgmc_version !== xfgmc_VER) {xfgmc_set_new_options();} // автообновим настройки, если нужно		
	if (!defined('xfgmc_ALLNUMFEED')) {
		define('xfgmc_ALLNUMFEED', '3');
	}

	add_action('admin_menu', array($this, 'add_admin_menu' ));
	add_filter('upload_mimes', array($this, 'xfgmc_add_mime_types'));
	
	add_filter('cron_schedules', array($this, 'cron_add_seventy_sec'));
	add_filter('cron_schedules', array($this, 'cron_add_five_min'));
	add_filter('cron_schedules', array($this, 'cron_add_six_hours'));
	 
	add_action('xfgmc_cron_sborki', array($this, 'xfgmc_do_this_seventy_sec'), 10, 1); 
	add_action('xfgmc_cron_period', array($this, 'xfgmc_do_this_event'), 10, 1);
		
	// индивидуальные опции доставки товара
//	add_action('add_meta_boxes', array($this, 'xfgmc_add_custom_box'));
	add_action('save_post', array($this, 'xfgmc_save_post_product_function'), 50, 3);
	// пришлось юзать save_post вместо save_post_product ибо wc блочит обновы

	// https://wpruse.ru/woocommerce/custom-fields-in-products/
	// https://wpruse.ru/woocommerce/custom-fields-in-variations/
	add_filter('woocommerce_product_data_tabs', array($this, 'xfgmc_added_wc_tabs'), 10, 1);
	add_action('admin_footer', array($this, 'xfgmc_art_added_tabs_icon'), 10, 1);
	add_action('woocommerce_product_data_panels', array($this, 'xfgmc_art_added_tabs_panel'), 10, 1);
//	add_action('woocommerce_process_product_meta',  array($this, 'xfgmc_art_woo_custom_fields_save'), 10, 1);	
	
	add_action('admin_notices', array($this, 'xfgmc_admin_notices_function'));

	/* Регаем стили только для страницы настроек плагина	*/
	add_action('admin_init', function() {
		wp_register_style('xfgmc-admin-css', plugins_url('css/xfgmc_style.css', __FILE__));
	}, 9999);

	add_filter('plugin_action_links', array($this, 'xfgmc_plugin_action_links'), 10, 2 );

	/* Мета-поля для категорий товаров */
	add_action("product_cat_edit_form_fields", array($this, 'xfgmc_add_meta_product_cat'), 10, 1);
	add_action('edited_product_cat', array($this, 'xfgmc_save_meta_product_cat'), 10, 1); 
	add_action('create_product_cat', array($this, 'xfgmc_save_meta_product_cat'), 10, 1);
 }

 public static function xfgmc_add_meta_product_cat($term) { ?>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e('Google product category', 'xfgmc'); ?></label></th>
		<td>
			<input id="xfgmc_google_product_category" type="text" name="xfgmc_cat_meta[xfgmc_google_product_category]" value="<?php echo esc_attr(get_term_meta($term->term_id, 'xfgmc_google_product_category', 1)) ?>" /><br />
			<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>google_product_category</strong>. <a href="//support.google.com/merchants/answer/6324436" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a></span>
		</td>
	<tr>		
	</tr>		
		<th scope="row" valign="top"><label>tax_category</label></th>
		<td>
			<input id="xfgmc_tax_category" type="text" name="xfgmc_cat_meta[xfgmc_tax_category]" value="<?php echo esc_attr(get_term_meta($term->term_id, 'xfgmc_tax_category', 1)) ?>" /><br />
			<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>tax_category</strong>. <a href="//support.google.com/merchants/answer/7569847" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a></span>
		</td>		
    </tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e('Facebook product category', 'xfgmc'); ?></label></th>
		<td>
			<input id="xfgmc_fb_product_category" type="text" name="xfgmc_cat_meta[xfgmc_fb_product_category]" value="<?php echo esc_attr(get_term_meta($term->term_id, 'xfgmc_fb_product_category', 1)) ?>" /><br />
			<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>fb_product_category</strong>. <?php _e('Used only if "Yes" is selected in the "Adapt for Facebook" field in the plugin settings', 'xfgmc'); ?>. <a href="//www.facebook.com/business/help/120325381656392?id=725943027795860&recommended_by=2041876302542944" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a></span>
		</td>
	<tr>	
	<?php
} 
 /* Сохранение данных в БД */
 function xfgmc_save_meta_product_cat($term_id){
    if (!isset($_POST['xfgmc_cat_meta'])) {return;}
    $xfgmc_cat_meta = array_map('trim', $_POST['xfgmc_cat_meta']);
    foreach($xfgmc_cat_meta as $key => $value){
        if(empty($value)){
            delete_term_meta($term_id, $key);
            continue;
        }
        update_term_meta($term_id, $key, $value);
    }
    return $term_id;
 }

 public static function xfgmc_plugin_action_links($actions, $plugin_file) {
	if (false === strpos($plugin_file, basename(__FILE__))) {
		// проверка, что у нас текущий плагин
		return $actions;
	}
	$settings_link = '<a href="/wp-admin/admin.php?page=xfgmcexport">'. __('Settings', 'xfgmc').'</a>';
	array_unshift($actions, $settings_link); 
	return $actions; 
 } 

 public static function xfgmc_admin_css_func() {
	/* Ставим css-файл в очередь на вывод */
	wp_enqueue_style('xfgmc-admin-css');
 } 
 
 public static function xfgmc_admin_head_css_func() {
	/* печатаем css в шапке админки */
	print '<style>/* XML for Google Merchant Center */
		.metabox-holder .postbox-container .empty-container {height: auto !important;}
		.icp_img1 {background-image: url('. xfgmc_URL .'/img/sl1.jpg);}
		.icp_img2 {background-image: url('. xfgmc_URL .'/img/sl2.jpg);}
		.icp_img3 {background-image: url('. xfgmc_URL .'/img/sl3.jpg);}
		.icp_img4 {background-image: url('. xfgmc_URL .'/img/sl4.jpg);}
		.icp_img5 {background-image: url('. xfgmc_URL .'/img/sl5.jpg);}
		.icp_img6 {background-image: url('. xfgmc_URL .'/img/sl6.jpg);}
	</style>';
 } 
 
 // Срабатывает при активации плагина (вызывается единожды)
 public static function on_activation() {
	$upload_dir = (object)wp_get_upload_dir();
	$name_dir = $upload_dir->basedir."/xfgmc";
	if (!is_dir($name_dir)) {
		if (!mkdir($name_dir)) {
		   error_log('ERROR: Ошибка создания папки '.$name_dir.'; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
		   //return false;
		}
	}
	$numFeed = '1'; // (string)
	if (!defined('xfgmc_ALLNUMFEED')) {define('xfgmc_ALLNUMFEED', '3');}
	$allNumFeed = (int)xfgmc_ALLNUMFEED;
	for ($i = 1; $i<$allNumFeed+1; $i++) {
		$name_dir = $upload_dir->basedir.'/xfgmc/feed'.$numFeed;
		if (!is_dir($name_dir)) {
		 if (!mkdir($name_dir)) {
			error_log('ERROR: Ошибка создания папки '.$name_dir.'; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
			//return false;
		 }
		}

		xfgmc_optionADD('xfgmc_status_sborki', '-1', $numFeed); // статус сборки файла
		xfgmc_optionADD('xfgmc_date_sborki', 'unknown', $numFeed); // дата последней сборки
		xfgmc_optionADD('xfgmc_date_sborki_end', 'unknown', $numFeed); // дата последней сборки
		xfgmc_optionADD('xfgmc_file_url', '', $numFeed); // урл до файла
		xfgmc_optionADD('xfgmc_file_file', '', $numFeed); // путь до файла
		xfgmc_optionADD('xfgmc_errors', '', $numFeed);
		xfgmc_optionADD('xfgmc_status_cron', 'off', $numFeed);
		xfgmc_optionADD('xfgmc_date_save_set', 'unknown', $numFeed);

		xfgmc_optionADD('xfgmc_run_cron', 'off', $numFeed);
		xfgmc_optionADD('xfgmc_ufup', '0', $numFeed); // нужно ли запускать обновление фида при перезаписи файла
		xfgmc_optionADD('xfgmc_feed_assignment', '', $numFeed);
		xfgmc_optionADD('xfgmc_adapt_facebook', 'no', $numFeed);
		xfgmc_optionADD('xfgmc_whot_export', 'all', $numFeed); // что выгружать (все или там где галка)
		xfgmc_optionADD('xfgmc_desc', 'fullexcerpt', $numFeed);
		xfgmc_optionADD('xfgmc_the_content', 'enabled', $numFeed);
		xfgmc_optionADD('xfgmc_var_desc_priority', 'on', $numFeed);
		$blog_title = get_bloginfo('name');
		xfgmc_optionADD('xfgmc_shop_name', $blog_title, $numFeed);
		xfgmc_optionADD('xfgmc_shop_description', $blog_title, $numFeed);	
		xfgmc_optionADD('xfgmc_target_country', 'RU', $numFeed);
		if (class_exists('WooCommerce')) {$currencyId_xml = get_woocommerce_currency();} else {$currencyId_xml = 'USD';}
		xfgmc_optionADD('xfgmc_default_currency', $currencyId_xml, $numFeed);
		xfgmc_optionADD('xfgmc_wooc_currencies', '', $numFeed);
		xfgmc_optionADD('xfgmc_main_product', 'other', $numFeed);
		xfgmc_optionADD('xfgmc_step_export', '500', $numFeed);
		xfgmc_optionADD('xfgmc_behavior_onbackorder', 'out_of_stock', $numFeed);
		xfgmc_optionADD('xfgmc_skip_missing_products', '0', $numFeed);	
		xfgmc_optionADD('xfgmc_skip_backorders_products', '0', $numFeed);
		xfgmc_optionADD('xfgmc_one_variable', '0', $numFeed);
		xfgmc_optionADD('xfgmc_def_shipping_country', '', $numFeed);
		xfgmc_optionADD('xfgmc_def_delivery_area_type', 'region', $numFeed);
		xfgmc_optionADD('xfgmc_def_delivery_area_value', '', $numFeed);
		xfgmc_optionADD('xfgmc_def_shipping_service', '', $numFeed);
		xfgmc_optionADD('xfgmc_def_shipping_price', '', $numFeed);

		xfgmc_optionADD('xfgmc_tax_info', 'disabled', $numFeed);
		xfgmc_optionADD('xfgmc_def_shipping_label', '', $numFeed);
		xfgmc_optionADD('xfgmc_def_min_handling_time', '', $numFeed);
		xfgmc_optionADD('xfgmc_def_max_handling_time', '', $numFeed);
		xfgmc_optionADD('xfgmc_product_type', 'disabled', $numFeed);
		xfgmc_optionADD('xfgmc_product_type_home', '', $numFeed);
		xfgmc_optionADD('xfgmc_sale_price', 'no', $numFeed);
		xfgmc_optionADD('xfgmc_gtin', 'disabled', $numFeed);
		xfgmc_optionADD('xfgmc_gtin_post_meta', '', $numFeed);
		xfgmc_optionADD('xfgmc_mpn', 'disabled', $numFeed);
		xfgmc_optionADD('xfgmc_mpn_post_meta', '', $numFeed);
		xfgmc_optionADD('xfgmc_age', 'default', $numFeed);
		xfgmc_optionADD('xfgmc_age_group_post_meta', '', $numFeed);	
		xfgmc_optionADD('xfgmc_brand', 'off', $numFeed);
		xfgmc_optionADD('xfgmc_brand_post_meta', '', $numFeed); 
		xfgmc_optionADD('xfgmc_color', 'off', $numFeed);
		xfgmc_optionADD('xfgmc_material', 'off', $numFeed);
		xfgmc_optionADD('xfgmc_pattern', 'off', $numFeed);
		
		xfgmc_optionADD('xfgmc_gender', 'off', $numFeed);
		xfgmc_optionADD('xfgmc_gender_alt', 'off', $numFeed);
		xfgmc_optionADD('xfgmc_size', 'off', $numFeed);
		xfgmc_optionADD('xfgmc_size_type', 'off', $numFeed);
		xfgmc_optionADD('xfgmc_size_type_alt', 'off', $numFeed);
		xfgmc_optionADD('xfgmc_size_system', 'off', $numFeed);	
		xfgmc_optionADD('xfgmc_size_system_alt', 'off', $numFeed);
		$numFeed++;	
	}
	if (is_multisite()) {
		add_blog_option(get_current_blog_id(), 'xfgmc_version', '2.3.3');
		add_blog_option(get_current_blog_id(), 'xfgmc_keeplogs', '0');
		add_blog_option(get_current_blog_id(), 'xfgmc_disable_notices', '0');
		add_blog_option(get_current_blog_id(), 'xfgmc_enable_five_min', '0');
	} else {
		add_option('xfgmc_version', '2.3.3');
		add_option('xfgmc_keeplogs', '0');
		add_option('xfgmc_disable_notices', '0');
		add_option('xfgmc_enable_five_min', '0');
	}
 }
 
 // Срабатывает при отключении плагина (вызывается единожды)
 public static function on_deactivation() {
	$numFeed = '1'; // (string)
	if (!defined('xfgmc_ALLNUMFEED')) {define('xfgmc_ALLNUMFEED', '3');}
	$allNumFeed = (int)xfgmc_ALLNUMFEED;
	for ($i = 1; $i<$allNumFeed+1; $i++) {	 
		wp_clear_scheduled_hook('xfgmc_cron_period', array($numFeed));
		wp_clear_scheduled_hook('xfgmc_cron_sborki', array($numFeed));
		$numFeed++;
	}
	deactivate_plugins('xml-for-google-merchant-center-pro/xml-for-google-merchant-center-pro.php');		
 } 
 
 // Срабатывает при удалении плагина (вызывается единожды)
 public static function on_uninstall() {
	if (is_multisite()) {
		delete_blog_option(get_current_blog_id(), 'xfgmc_version');
		delete_blog_option(get_current_blog_id(), 'xfgmc_keeplogs');
		delete_blog_option(get_current_blog_id(), 'xfgmc_disable_notices');
		delete_blog_option(get_current_blog_id(), 'xfgmc_enable_five_min');
	} else {
		delete_option('xfgmc_version');
		delete_option('xfgmc_keeplogs');
		delete_option('xfgmc_disable_notices');
		delete_option('xfgmc_enable_five_min');
	}	
	$numFeed = '1'; // (string)
	$allNumFeed = (int)xfgmc_ALLNUMFEED;
	for ($i = 1; $i<$allNumFeed+1; $i++) {			
		xfgmc_optionDEL('xfgmc_status_sborki', $numFeed); // статус сборки файла
		xfgmc_optionDEL('xfgmc_date_sborki', $numFeed); // дата последней сборки
		xfgmc_optionDEL('xfgmc_date_sborki_end', $numFeed); 
		xfgmc_optionDEL('xfgmc_file_url', $numFeed); // урл до файла
		xfgmc_optionDEL('xfgmc_file_file', $numFeed); // путь до файла
		xfgmc_optionDEL('xfgmc_errors', $numFeed);
		xfgmc_optionDEL('xfgmc_status_cron', $numFeed);
		xfgmc_optionDEL('xfgmc_date_save_set', $numFeed);

		xfgmc_optionDEL('xfgmc_run_cron', $numFeed);
		xfgmc_optionDEL('xfgmc_ufup', $numFeed); // нужно ли запускать обновление фида при перезаписи файла
		xfgmc_optionDEL('xfgmc_feed_assignment', $numFeed);
		xfgmc_optionDEL('xfgmc_adapt_facebook', $numFeed);
		xfgmc_optionDEL('xfgmc_whot_export', $numFeed); // что выгружать (все или там где галка)
		xfgmc_optionDEL('xfgmc_desc', $numFeed);
		xfgmc_optionDEL('xfgmc_the_content', $numFeed);
		xfgmc_optionDEL('xfgmc_var_desc_priority', $numFeed);
		xfgmc_optionDEL('xfgmc_shop_name', $numFeed);
		xfgmc_optionDEL('xfgmc_shop_description', $numFeed);	
		xfgmc_optionDEL('xfgmc_target_country', $numFeed);
		xfgmc_optionDEL('xfgmc_default_currency', $numFeed);
		xfgmc_optionDEL('xfgmc_wooc_currencies', $numFeed);
		xfgmc_optionDEL('xfgmc_main_product', $numFeed);
		xfgmc_optionDEL('xfgmc_step_export', $numFeed);	
		xfgmc_optionDEL('xfgmc_behavior_onbackorder', $numFeed);
		xfgmc_optionDEL('xfgmc_skip_missing_products', $numFeed);	
		xfgmc_optionDEL('xfgmc_skip_backorders_products', $numFeed);
		xfgmc_optionDEL('xfgmc_one_variable', $numFeed);

		xfgmc_optionDEL('xfgmc_def_shipping_country', $numFeed);
		xfgmc_optionDEL('xfgmc_def_delivery_area_type', $numFeed);
		xfgmc_optionDEL('xfgmc_def_delivery_area_value', $numFeed);
		xfgmc_optionDEL('xfgmc_def_shipping_service', $numFeed);
		xfgmc_optionDEL('xfgmc_def_shipping_price', $numFeed);		

		xfgmc_optionDEL('xfgmc_tax_info', $numFeed);
		xfgmc_optionDEL('xfgmc_def_shipping_label', $numFeed);
		xfgmc_optionDEL('xfgmc_def_min_handling_time', $numFeed);
		xfgmc_optionDEL('xfgmc_def_max_handling_time', $numFeed);
		xfgmc_optionDEL('xfgmc_product_type', $numFeed);
		xfgmc_optionDEL('xfgmc_product_type_home', $numFeed);		
		xfgmc_optionDEL('xfgmc_sale_price', $numFeed);
		xfgmc_optionDEL('xfgmc_gtin', $numFeed);
		xfgmc_optionDEL('xfgmc_gtin_post_meta', $numFeed);
		xfgmc_optionDEL('xfgmc_mpn', $numFeed);
		xfgmc_optionDEL('xfgmc_mpn_post_meta', $numFeed);
		xfgmc_optionDEL('xfgmc_age', $numFeed);
		xfgmc_optionDEL('xfgmc_age_group_post_meta', $numFeed);	
		xfgmc_optionDEL('xfgmc_brand', $numFeed); 
		xfgmc_optionDEL('xfgmc_brand_post_meta', $numFeed); 
		xfgmc_optionDEL('xfgmc_color', $numFeed);
		xfgmc_optionDEL('xfgmc_material', $numFeed);
		xfgmc_optionDEL('xfgmc_pattern', $numFeed);	

		xfgmc_optionDEL('xfgmc_gender', $numFeed);
		xfgmc_optionDEL('xfgmc_gender_alt', $numFeed);	
		xfgmc_optionDEL('xfgmc_size', $numFeed);
		xfgmc_optionDEL('xfgmc_size_type', $numFeed);
		xfgmc_optionDEL('xfgmc_size_type_alt', $numFeed);
		xfgmc_optionDEL('xfgmc_size_system', $numFeed);	
		xfgmc_optionDEL('xfgmc_size_system_alt', $numFeed);
		$numFeed++;	
	}
 }

 // Добавляем пункты меню
 public function add_admin_menu() {
	$page_suffix = add_menu_page(null , __('Export Google Merchant Center', 'xfgmc'), 'manage_options', 'xfgmcexport', 'xfgmc_export_page', 'dashicons-redo', 51);
	require_once xfgmc_DIR.'/export.php'; // Подключаем файл настроек
	// создаём хук, чтобы стили выводились только на странице настроек
	add_action('admin_print_styles-' . $page_suffix, array($this, 'xfgmc_admin_css_func'));
	add_action('admin_print_styles-' . $page_suffix, array($this, 'xfgmc_admin_head_css_func'));	

	$page_suffix = add_submenu_page('xfgmcexport', __('Debug', 'xfgmc'), __('Debug page', 'xfgmc'), 'manage_options', 'xfgmcdebug', 'xfgmc_debug_page');
	require_once xfgmc_DIR.'/debug.php';
	add_action('admin_print_styles-' . $page_suffix, array($this, 'xfgmc_admin_css_func'));
	add_submenu_page( 'xfgmcexport', __('Add Extensions', 'xfgmc'), __('Extensions', 'xfgmc'), 'manage_options', 'xfgmcextensions', 'xfgmc_extensions_page' );
	require_once xfgmc_DIR.'/extensions.php';
 } 
 
 // Разрешим загрузку xml и csv файлов
 public function xfgmc_add_mime_types($mimes) {
	$mimes ['csv'] = 'text/csv';
	$mimes ['xml'] = 'text/xml';		
	return $mimes;
 } 

 /* добавляем интервалы крон в 70 секунд и 6 часов */
 public function cron_add_seventy_sec($schedules) {
	$schedules['seventy_sec'] = array(
		'interval' => 70,
		'display' => '70 sec'
	);
	return $schedules;
 }
 public function cron_add_five_min($schedules) {
	$schedules['five_min'] = array(
		'interval' => 360,
		'display' => '6 hours'
	);
	return $schedules;
 }  
 public function cron_add_six_hours($schedules) {
	$schedules['six_hours'] = array(
		'interval' => 21600,
		'display' => '6 hours'
	);
	return $schedules;
 }
 /* end добавляем интервалы крон в 70 секунд и 6 часов */ 
 
 // Сохраняем данные блока, когда пост сохраняется
 function xfgmc_save_post_product_function ($post_id, $post, $update) {
	xfgmc_error_log('Стартовала функция xfgmc_save_post_product_function! Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
	
	if ($post->post_type !== 'product') {return;} // если это не товар вукомерц
	if (wp_is_post_revision($post_id)) {return;} // если это ревизия
	// проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
//	if (!wp_verify_nonce($_POST['xfgmc_noncename'], plugin_basename(__FILE__))) {return;}
	// если это автосохранение ничего не делаем
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return;}
	// проверяем права юзера
	if (!current_user_can('edit_post', $post_id)) {return;}
	// Все ОК. Теперь, нужно найти и сохранить данные
	// Очищаем значение поля input.
	xfgmc_error_log('Работает функция xfgmc_save_post_product_function! Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);

	// Убедимся что поле установлено.
	if (isset($_POST['xfgmc_google_product_category'])) {	
		$xfgmc_google_product_category = sanitize_text_field($_POST['xfgmc_google_product_category']);
		$xfgmc_fb_product_category = sanitize_text_field($_POST['_xfgmc_fb_product_category']);
		$xfgmc_tax_category = sanitize_text_field($_POST['_xfgmc_tax_category']);
		$xfgmc_identifier_exists = sanitize_text_field($_POST['xfgmc_identifier_exists']);
		$xfgmc_adult = sanitize_text_field($_POST['xfgmc_adult']);
		$xfgmc_condition = sanitize_text_field($_POST['xfgmc_condition']);
		$xfgmc_shipping_label = sanitize_text_field($_POST['_xfgmc_shipping_label']);
		$xfgmc_min_handling_time = sanitize_text_field($_POST['_xfgmc_min_handling_time']);
		$xfgmc_max_handling_time = sanitize_text_field($_POST['_xfgmc_max_handling_time']);		
		$xfgmc_custom_label_0 = sanitize_text_field($_POST['xfgmc_custom_label_0']);
		$xfgmc_custom_label_1 = sanitize_text_field($_POST['xfgmc_custom_label_1']);		
		$xfgmc_custom_label_2 = sanitize_text_field($_POST['xfgmc_custom_label_2']);
		$xfgmc_custom_label_3 = sanitize_text_field($_POST['xfgmc_custom_label_3']);
		$xfgmc_custom_label_4 = sanitize_text_field($_POST['xfgmc_custom_label_4']);						
		// Обновляем данные в базе данных
		update_post_meta($post_id, 'xfgmc_google_product_category', $xfgmc_google_product_category);
		update_post_meta($post_id, '_xfgmc_fb_product_category', $xfgmc_fb_product_category);
		update_post_meta($post_id, '_xfgmc_tax_category', $xfgmc_tax_category);
		update_post_meta($post_id, 'xfgmc_identifier_exists', $xfgmc_identifier_exists);
		update_post_meta($post_id, 'xfgmc_adult', $xfgmc_adult);
		update_post_meta($post_id, 'xfgmc_condition', $xfgmc_condition);
		update_post_meta($post_id, '_xfgmc_shipping_label', $xfgmc_shipping_label);
		update_post_meta($post_id, '_xfgmc_min_handling_time', $xfgmc_min_handling_time);
		update_post_meta($post_id, '_xfgmc_max_handling_time', $xfgmc_max_handling_time);
		update_post_meta($post_id, 'xfgmc_custom_label_0', $xfgmc_custom_label_0);
		update_post_meta($post_id, 'xfgmc_custom_label_1', $xfgmc_custom_label_1);
		update_post_meta($post_id, 'xfgmc_custom_label_2', $xfgmc_custom_label_2);
		update_post_meta($post_id, 'xfgmc_custom_label_3', $xfgmc_custom_label_3);
		update_post_meta($post_id, 'xfgmc_custom_label_4', $xfgmc_custom_label_4);		
	}
	do_action('xfgmc_save_post_product', $post_id, $post, $update);

	$numFeed = '1'; // (string) создадим строковую переменную
	// нужно ли запускать обновление фида при перезаписи файла
	$allNumFeed = (int)xfgmc_ALLNUMFEED;
	for ($i = 1; $i<$allNumFeed+1; $i++) {

		xfgmc_error_log('FEED № '.$numFeed.'; Шаг $i = '.$i.' цикла по формированию кэша файлов; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);

		$result_xml_unit = xfgmc_unit($post_id, $numFeed); // формируем фид товара
		if (is_array($result_xml_unit)) {
			$result_xml = $result_xml_unit[0];
			$ids_in_xml = $result_xml_unit[1];
		} else {
			$result_xml = $result_xml_unit;
			$ids_in_xml = '';
		}
		xfgmc_wf($result_xml, $post_id, $numFeed, $ids_in_xml); // записываем кэш-файл

		// нужно ли запускать обновление фида при перезаписи файла
		$xfgmc_ufup = xfgmc_optionGET('xfgmc_ufup', $numFeed);
		if ($xfgmc_ufup !== 'on') {$numFeed++; continue; /*return;*/}
		$status_sborki = (int)xfgmc_optionGET('xfgmc_status_sborki', $numFeed);
		if ($status_sborki > -1) {$numFeed++; continue; /*return;*/} // если идет сборка фида - пропуск
		
		$xfgmc_date_save_set = xfgmc_optionGET('xfgmc_date_save_set', $numFeed);
		$xfgmc_date_sborki = xfgmc_optionGET('xfgmc_date_sborki', $numFeed);

		if ($numFeed === '1') {$prefFeed = '';} else {$prefFeed = $numFeed;}	
		if (is_multisite()) {
			/*
			*	wp_get_upload_dir();
			*   'path'    => '/home/site.ru/public_html/wp-content/uploads/2016/04',
			*	'url'     => 'http://site.ru/wp-content/uploads/2016/04',
			*	'subdir'  => '/2016/04',
			*	'basedir' => '/home/site.ru/public_html/wp-content/uploads',
			*	'baseurl' => 'http://site.ru/wp-content/uploads',
			*	'error'   => false,
			*/
			$upload_dir = (object)wp_get_upload_dir();
			$filenamefeed = $upload_dir->basedir."/".$prefFeed."feed-xml-".get_current_blog_id().".xml";		
		} else {
			$upload_dir = (object)wp_get_upload_dir();
			$filenamefeed = $upload_dir->basedir."/".$prefFeed."feed-xml-0.xml";
		}
		if (!file_exists($filenamefeed)) {
			xfgmc_error_log('FEED № '.$numFeed.'; WARNING: Файла filenamefeed = '.$filenamefeed.' не существует! Пропускаем быструю сборку; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
			$numFeed++; continue; /*return;*/ 
		} // файла с фидом нет

		clearstatcache(); // очищаем кэш дат файлов
		$last_upd_file = filemtime($filenamefeed);
		xfgmc_error_log('FEED № '.$numFeed.'; $xfgmc_date_save_set='.$xfgmc_date_save_set.';$filenamefeed='.$filenamefeed, 0);
		xfgmc_error_log('FEED № '.$numFeed.'; Начинаем сравнивать даты! Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);	
		if ($xfgmc_date_save_set > $last_upd_file) {
			// настройки фида сохранялись позже, чем создан фид		
			// нужно полностью пересобрать фид
			xfgmc_error_log('FEED № '.$numFeed.'; NOTICE: Настройки фида сохранялись позже, чем создан фид; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
			$xfgmc_status_cron = xfgmc_optionGET('xfgmc_status_cron', $numFeed);
			$recurrence = $xfgmc_status_cron;
			wp_clear_scheduled_hook('xfgmc_cron_period', array($numFeed));
			wp_schedule_event(time(), $recurrence, 'xfgmc_cron_period', array($numFeed));
			xfgmc_error_log('FEED № '.$numFeed.'; xfgmc_cron_period внесен в список заданий! Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
		} else { // нужно лишь обновить цены	
			xfgmc_error_log('FEED № '.$numFeed.'; NOTICE: Настройки фида сохранялись раньше, чем создан фид. Нужно лишь обновить цены; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
			xfgmc_clear_file_ids_in_xml($numFeed); /* С версии 2.0.0 */
			xfgmc_onlygluing($numFeed);
		}
		$numFeed++;
	}
	return;
 }
  
 /* функции крона */
 public function xfgmc_do_this_seventy_sec($numFeed = '1') {
	xfgmc_error_log('FEED № '.$numFeed.'; Крон xfgmc_do_this_seventy_sec запущен; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);	 
	// xfgmc_optionGET('xfgmc_status_sborki', $numFeed);	
	$this->xfgmc_construct_xml($numFeed); // делаем что-либо каждые 70 сек
 }
 public function xfgmc_do_this_event($numFeed = '1') {
	xfgmc_error_log('FEED № '.$numFeed.'; Крон xfgmc_do_this_event включен. Делаем что-то каждый час; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
	$step_export = (int)xfgmc_optionGET('xfgmc_step_export', $numFeed);
	if ($step_export === 0) {$step_export = 500;}		
	xfgmc_optionUPD('xfgmc_status_sborki', $step_export, $numFeed);

	wp_clear_scheduled_hook('xfgmc_cron_sborki', array($numFeed));

	// Возвращает nul/false. null когда планирование завершено. false в случае неудачи.
	$res = wp_schedule_event(time(), 'seventy_sec', 'xfgmc_cron_sborki', array($numFeed));
	if ($res === false) {
		xfgmc_error_log('FEED № '.$numFeed.'; ERROR: Не удалось запланировань CRON seventy_sec; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
	} else {
		xfgmc_error_log('FEED № '.$numFeed.'; CRON seventy_sec успешно запланирован; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
	}
 }
 /* end функции крона */
 
 public static function xfgmc_added_wc_tabs($tabs) {
	$tabs['xfgmc_special_panel'] = array(
		'label' => __('XML for Google Merchant Center', 'xfgmc'), // название вкладки
		'target' => 'xfgmc_added_wc_tabs', // идентификатор вкладки
		'class' => array('hide_if_grouped'), // классы управления видимостью вкладки в зависимости от типа товара
		'priority' => 70, // приоритет вывода
	);
	return $tabs;
 }

 public static function xfgmc_art_added_tabs_icon() { ?>
	<style>
		#woocommerce-coupon-data ul.wc-tabs li.special_panel_options a::before,
		#woocommerce-product-data ul.wc-tabs li.special_panel_options a::before,
		.woocommerce ul.wc-tabs li.special_panel_options a::before {
			content: "\f172";
		}
	</style>
	<?php
 }

 public static function xfgmc_art_added_tabs_panel() {
	global $post; ?>
	<div id="xfgmc_added_wc_tabs" class="panel woocommerce_options_panel">
		<?php do_action('xfgmc_before_options_group', $post); ?>
		<div class="options_group">
			<h2><strong><?php _e('Individual product settings for XML for Google Merchant Center', 'xfgmc'); ?></strong></h2>
			<?php do_action('xfgmc_prepend_options_group', $post); ?>
			<?php
			// текстовое поле
			woocommerce_wp_text_input(array(
				'id'				=> 'xfgmc_google_product_category',
				'label'				=> __('Google product category', 'xfgmc'),
				'placeholder'		=> '',
				// 'desc_tip'			=> 'true',
				// 'custom_attributes' => array('required' => 'required'),
				'description'		=> __('Optional element', 'xfgmc'). ' <strong>google_product_category</strong>. <a href="//support.google.com/merchants/answer/6324436" target="_blank">'. __('Read more', 'xfgmc'). '</a>',
			));

			woocommerce_wp_text_input(array(
				'id'				=> '_xfgmc_tax_category',
				'label'				=> 'tax_category',
				'placeholder'		=> '',
				// 'desc_tip'			=> 'true',
				// 'custom_attributes' => array('required' => 'required'),
				'description'		=> __('Optional element', 'xfgmc'). ' <strong>tax_category</strong>. <a href="//support.google.com/merchants/answer/7569847" target="_blank">'. __('Read more', 'xfgmc'). '</a>',
			));	

			woocommerce_wp_text_input(array(
				'id'				=> '_xfgmc_fb_product_category',
				'label'				=> __('Facebook product category', 'xfgmc'),
				'placeholder'		=> '',
				// 'desc_tip'			=> 'true',
				// 'custom_attributes' => array('required' => 'required'),
				'description'		=> __('Optional element', 'xfgmc'). ' <strong>fb_product_category</strong>. '. __('Used only if "Yes" is selected in the "Adapt for Facebook" field in the plugin settings', 'xfgmc'). '. <a href="//www.facebook.com/business/help/120325381656392?id=725943027795860&recommended_by=2041876302542944" target="_blank">'. __('Read more', 'xfgmc'). '</a>',
			));

			woocommerce_wp_select(array(
				'id' => 'xfgmc_identifier_exists',
				'label' => __('Identifier exists', 'xfgmc'),
				'options' => array(
					'off' => __('Off', 'xfgmc'),
					'no' => __('No', 'xfgmc'),
					'yes' => __('Yes', 'xfgmc'),
				),
				'description'		=> __('Optional element', 'xfgmc'). ' <strong>identifier_exists</strong>. <a href="//support.google.com/merchants/answer/6324478" target="_blank">'. __('Read more', 'xfgmc'). '</a>',
			));
			 
			woocommerce_wp_select(array(
				'id' => 'xfgmc_adult',
				'label' => __('Adult', 'xfgmc'),
				'options' => array(
					'off' => __('Off', 'xfgmc'),
					'no' => __('No', 'xfgmc'),
					'yes' => __('Yes', 'xfgmc'),
				),
				'description'		=> __('Optional element', 'xfgmc'). ' <strong>adult</strong>. <a href="//support.google.com/merchants/answer/6324508" target="_blank">'. __('Read more', 'xfgmc'). '</a>',
			));

			woocommerce_wp_select(array(
				'id' => 'xfgmc_condition',
				'label' => __('Сondition', 'xfgmc'),
				'options' => array(
					'off' => __('Off', 'xfgmc'),
					'new' => __('New', 'xfgmc'),
					'refurbished' => __('Refurbished', 'xfgmc'),
					'used' => __('Used', 'xfgmc'),
				),
				'description' => __('Optional element', 'xfgmc'). ' <strong>condition</strong>',
			));

			woocommerce_wp_text_input(array(
				'id'				=> '_xfgmc_shipping_label',
				'label'				=> __('Definition', 'xfgmc'). ' shipping_label',
				'placeholder'		=> '',
				'description'		=> __('Optional element', 'xfgmc'). ' <strong>shipping_label</strong>. <a href="//support.google.com/merchants/answer/6324504" target="_blank">'. __('Read more', 'xfgmc'). '</a>',
			));	
			
			woocommerce_wp_text_input(array(
				'id'				=> '_xfgmc_min_handling_time',
				'label'				=> __('Definition', 'xfgmc'). ' min_handling_time',
				'placeholder'		=> '',
				'description'		=> __('Optional element', 'xfgmc'). ' <strong>min_handling_time</strong>. <a href="//support.google.com/merchants/answer/7388496" target="_blank">'. __('Read more', 'xfgmc'). '</a>',
			));	
			
			woocommerce_wp_text_input(array(
				'id'				=> '_xfgmc_max_handling_time',
				'label'				=> __('Definition', 'xfgmc'). ' max_handling_time',
				'placeholder'		=> '',
				'description'		=> __('Optional element', 'xfgmc'). ' <strong>max_handling_time</strong>. <a href="//support.google.com/merchants/answer/7388496" target="_blank">'. __('Read more', 'xfgmc'). '</a>',
			));				

			woocommerce_wp_text_input(array(
				'id'				=> 'xfgmc_custom_label_0',
				'label'				=> __('Definition', 'xfgmc'). ' custom_label_0',
				'placeholder'		=> '',
				'description'		=> __('Optional element', 'xfgmc'). ' <strong>custom_label_0</strong>. <a href="//support.google.com/merchants/answer/6324473" target="_blank">'. __('Read more', 'xfgmc'). '</a>',
			));	
			
			woocommerce_wp_text_input(array(
				'id'				=> 'xfgmc_custom_label_1',
				'label'				=> __('Definition', 'xfgmc'). ' custom_label_1',
				'placeholder'		=> '',
				'description'		=> __('Optional element', 'xfgmc'). ' <strong>custom_label_1</strong>. <a href="//support.google.com/merchants/answer/6324473" target="_blank">'. __('Read more', 'xfgmc'). '</a>',
			));
			
			woocommerce_wp_text_input(array(
				'id'				=> 'xfgmc_custom_label_2',
				'label'				=> __('Definition', 'xfgmc'). ' custom_label_2',
				'placeholder'		=> '',
				'description'		=> __('Optional element', 'xfgmc'). ' <strong>custom_label_2</strong>. <a href="//support.google.com/merchants/answer/6324473" target="_blank">'. __('Read more', 'xfgmc'). '</a>',
			));
			
			woocommerce_wp_text_input(array(
				'id'				=> 'xfgmc_custom_label_3',
				'label'				=> __('Definition', 'xfgmc'). ' custom_label_3',
				'placeholder'		=> '',
				'description'		=> __('Optional element', 'xfgmc'). ' <strong>custom_label_3</strong>. <a href="//support.google.com/merchants/answer/6324473" target="_blank">'. __('Read more', 'xfgmc'). '</a>',
			));
			
			woocommerce_wp_text_input(array(
				'id'				=> 'xfgmc_custom_label_4',
				'label'				=> __('Definition', 'xfgmc'). ' custom_label_4',
				'placeholder'		=> '',
				'description'		=> __('Optional element', 'xfgmc'). ' <strong>custom_label_4</strong>. <a href="//support.google.com/merchants/answer/6324473" target="_blank">'. __('Read more', 'xfgmc'). '</a>',
			));			
			?>
			<?php do_action('xfgmc_append_options_group', $post); ?>
		</div>
		<?php do_action('xfgmc_after_options_group', $post); ?>
	</div>
	<?php
 } 

 public static function xfgmc_art_woo_custom_fields_save($post_id) {
	// Сохранение текстового поля
	if (isset($_POST['_xfgmc_condition'])) {update_post_meta($post_id, '_xfgmc_condition', esc_attr($_POST['_xfgmc_condition']));}
	if (isset($_POST['_xfgmc_custom'])) {update_post_meta($post_id, '_xfgmc_custom', esc_attr($_POST['_xfgmc_custom']));}
 }  

 // Вывод различных notices
 public function xfgmc_admin_notices_function() {
	$numFeed = '1'; // (string) создадим строковую переменную
	// нужно ли запускать обновление фида при перезаписи файла
	$allNumFeed = (int)xfgmc_ALLNUMFEED;

	$xfgmc_disable_notices = xfgmc_optionGET('xfgmc_disable_notices');
	if ($xfgmc_disable_notices !== 'on') {
		for ($i = 1; $i<$allNumFeed+1; $i++) {
			$status_sborki = xfgmc_optionGET('xfgmc_status_sborki', $numFeed);
			if ($status_sborki == false) {
				$numFeed++; continue;
			} else {
				$status_sborki = (int)$status_sborki;
			}		
			if ($status_sborki !== -1) {	
				$count_posts = wp_count_posts('product');
				$vsegotovarov = $count_posts->publish;
				$step_export = (int)xfgmc_optionGET('xfgmc_step_export', $numFeed);
				if ($step_export === 0) {$step_export = 500;}
				$vobrabotke = $status_sborki-$step_export;
				if ($vsegotovarov > $vobrabotke) {
					$vyvod = 'FEED № '.$numFeed.' '. __('Progress', 'xfgmc').': '.$vobrabotke.' '. __('from', 'xfgmc').' '.$vsegotovarov.' '. __('products', 'xfgmc') .'.<br />'.__('If the progress indicators have not changed within 20 minutes, try reducing the "Step of export" in the plugin settings', 'xfgmc');
				} else {
					$vyvod = 'FEED № '.$numFeed.' '. __('Prior to the completion of less than 70 seconds', 'xfgmc');
				}	
				print '<div class="updated notice notice-success is-dismissible"><p>'. __('We are working on automatic file creation. XML will be developed soon', 'xfgmc').'. '.$vyvod.'.</p></div>';
			}
			$numFeed++;
		}
	}	
	if (xfgmc_optionGET('xfgmc_magazin_type', $numFeed) === 'woocommerce') { 
		if (!class_exists('WooCommerce')) {
			print '<div class="notice error is-dismissible"><p>'. __('WooCommerce is not active', 'xfgmc'). '!</p></div>';
		}
	}

	if (isset($_REQUEST['xfgmc_submit_action'])) {
		$run_text = '';
		if (sanitize_text_field($_POST['xfgmc_run_cron']) !== 'off') {
			$run_text = '. '. __('Creating the feed is running. You can continue working with the website', 'xfgmc');
		}
		print '<div class="updated notice notice-success is-dismissible"><p>'. __('Updated', 'xfgmc'). $run_text .'.</p></div>';
	}

	/* сброс настроек */
	if (isset($_REQUEST['xfgmc_submit_reset'])) { 
		if (!empty($_POST) && check_admin_referer('xfgmc_nonce_action_reset', 'xfgmc_nonce_field_reset')) {
			$this->on_uninstall();
			$this->on_activation();
			print '<div class="updated notice notice-success is-dismissible"><p>'. __('The settings have been reset', 'xfgmc'). '.</p></div>';
		}
	}

	/* отправка отчёта */
	if (isset($_REQUEST['xfgmc_submit_send_stat'])) {
	 if (!empty($_POST) && check_admin_referer('xfgmc_nonce_action_send_stat', 'xfgmc_nonce_field_send_stat')) { 	
		if (is_multisite()) { 
			$xfgmc_is_multisite = 'включен';	
			$xfgmc_keeplogs = get_blog_option(get_current_blog_id(), 'xfgmc_keeplogs');
		} else {
			$xfgmc_is_multisite = 'отключен'; 
			$xfgmc_keeplogs = get_option('xfgmc_keeplogs');
		}
		$numFeed = '1'; // (string)
		$mail_content = "Версия плагина: ". xfgmc_VER . PHP_EOL;
		$mail_content .= "Версия WP: ".get_bloginfo('version'). PHP_EOL;	 
		$woo_version = xfgmc_get_woo_version_number();
		$mail_content .= "Версия WC: ".$woo_version. PHP_EOL;
		$mail_content .= "Версия PHP: ".phpversion(). PHP_EOL;   
		$mail_content .= "Режим мультисайта: ".$xfgmc_is_multisite. PHP_EOL;
		$mail_content .= "Вести логи: ".$xfgmc_keeplogs. PHP_EOL;
		$mail_content .= "Расположение логов: ". xfgmc_UPLOAD_DIR .'/xfgmc.log'. PHP_EOL;
		if (!class_exists('XmlforGoogleMerchantCenterPro')) {$mail_content .= "Pro: не активна". PHP_EOL;} else {if (!defined('xfgmcp_VER')) {define('xfgmcp_VER', 'н/д');} $mail_content .= "Pro: активна (v ".xfgmcp_VER.")". PHP_EOL;}
		if (isset($_REQUEST['xfgmc_its_ok'])) {
			$mail_content .= PHP_EOL ."Помог ли плагин: ".sanitize_text_field($_REQUEST['xfgmc_its_ok']);
		}
		if (isset($_POST['xfgmc_email'])) {
			$mail_content .= PHP_EOL ."Почта: ".sanitize_text_field($_POST['xfgmc_email']);
		}
		if (isset($_POST['xfgmc_message'])) {
			$mail_content .= PHP_EOL ."Сообщение: ".sanitize_text_field($_POST['xfgmc_message']);
		}
		$argsp = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => -1, 'fields'  => 'ids',);
		$products = new WP_Query($argsp);
		$vsegotovarov = $products->found_posts;
		$mail_content .= PHP_EOL ."Число товаров на выгрузку: ". $vsegotovarov;
		$allNumFeed = (int)xfgmc_ALLNUMFEED;
		for ($i = 1; $i<$allNumFeed+1; $i++) {
			$status_sborki = (int)xfgmc_optionGET('xfgmc_status_sborki', $numFeed);
			$xfgmc_file_url = urldecode(xfgmc_optionGET('xfgmc_file_url', $numFeed));
			$xfgmc_file_file = urldecode(xfgmc_optionGET('xfgmc_file_file', $numFeed));	  
			$xfgmc_whot_export = xfgmc_optionGET('xfgmc_whot_export', $numFeed);
			$xfgmc_skip_missing_products = xfgmc_optionGET('xfgmc_skip_missing_products', $numFeed);	
			$xfgmc_skip_backorders_products = xfgmc_optionGET('xfgmc_skip_backorders_products', $numFeed);
			$xfgmc_status_cron = xfgmc_optionGET('xfgmc_status_cron', $numFeed);
			$xfgmc_ufup = xfgmc_optionGET('xfgmc_ufup', $numFeed);	
			$xfgmc_date_sborki = xfgmc_optionGET('xfgmc_date_sborki', $numFeed);
			$xfgmc_main_product = xfgmc_optionGET('xfgmc_main_product', $numFeed);
			$xfgmc_errors = xfgmc_optionGET('xfgmc_errors', $numFeed);

			$mail_content .= PHP_EOL."ФИД №: ".$i. PHP_EOL . PHP_EOL;
			$mail_content .= "status_sborki: ".$status_sborki. PHP_EOL;
			$mail_content .= "УРЛ: ".get_site_url(). PHP_EOL;
			$mail_content .= "УРЛ XML-фида: ".$xfgmc_file_url . PHP_EOL;
			$mail_content .= "Временный файл: ".$xfgmc_file_file. PHP_EOL;
			$mail_content .= "Что экспортировать: ".$xfgmc_whot_export. PHP_EOL;
			$mail_content .= "Исключать товары которых нет в наличии (кроме предзаказа): ".$xfgmc_skip_missing_products. PHP_EOL;
			$mail_content .= "Исключать из фида товары для предзаказа: ".$xfgmc_skip_backorders_products. PHP_EOL;
			$mail_content .= "Автоматическое создание файла: ".$xfgmc_status_cron. PHP_EOL;
			$mail_content .= "Обновить фид при обновлении карточки товара: ".$xfgmc_ufup. PHP_EOL;
			$mail_content .= "Дата последней сборки XML: ".$xfgmc_date_sborki. PHP_EOL;
			$mail_content .= "Что продаёт: ".$xfgmc_main_product. PHP_EOL;			
			$mail_content .= "Ошибки: ".$xfgmc_errors. PHP_EOL;
			$numFeed++;
	  	}
		wp_mail('support@icopydoc.ru', 'Cтатистика о работе плагина XML for Google Merchant Center', $mail_content);
		print '<div class="updated notice notice-success is-dismissible"><p>'. __('The data has been sent. Thank you', 'xfgmc'). '.</p></div>';
	 }
	} /* end отправка отчёта */


	if (isset($_REQUEST['xfgmc_submit_clear_logs'])) {
		$upload_dir = (object)wp_get_upload_dir();
		$name_dir = $upload_dir->basedir."/xfgmc";
		$filename = $name_dir.'/xfgmc.log';
		$res = unlink($filename);
		if ($res == true) {
			print '<div class="notice notice-success is-dismissible"><p>' .__('Logs were cleared', 'xfgmc'). '.</p></div>';					
		} else {
			print '<div class="notice notice-warning is-dismissible"><p>' .__('Error accessing log file. The log file may have been deleted previously', 'xfgmc'). '.</p></div>';		
		}
	}	
 }
 
 // сборка
 public static function xfgmc_construct_xml($numFeed = '1') {
	xfgmc_error_log('FEED № '.$numFeed.'; Стартовала xfgmc_construct_xml. Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__ , 0);

 	$result_xml = '';
	$status_sborki = (int)xfgmc_optionGET('xfgmc_status_sborki', $numFeed);
  
	// файл уже собран. На всякий случай отключим крон сборки
	if ($status_sborki == -1 ) {wp_clear_scheduled_hook('xfgmc_cron_sborki', array($numFeed)); return;}
		  
	$xfgmc_date_save_set = xfgmc_optionGET('xfgmc_date_save_set', $numFeed);
	if ($xfgmc_date_save_set == '') {
		$unixtime = current_time('timestamp', 1); // 1335808087 - временная зона GMT(Unix формат)
		xfgmc_optionUPD('xfgmc_date_save_set', $unixtime, $numFeed);
	}
	$xfgmc_date_sborki = xfgmc_optionGET('xfgmc_date_sborki', $numFeed);
	  
	if ($numFeed === '1') {$prefFeed = '';} else {$prefFeed = $numFeed;}	  
	if (is_multisite()) {
		/*
		* wp_get_upload_dir();
		* 'path'    => '/home/site.ru/public_html/wp-content/uploads/2016/04',
		* 'url'     => 'http://site.ru/wp-content/uploads/2016/04',
		* 'subdir'  => '/2016/04',
		* 'basedir' => '/home/site.ru/public_html/wp-content/uploads',
		* 'baseurl' => 'http://site.ru/wp-content/uploads',
		* 'error'   => false,
		*/
		$upload_dir = (object)wp_get_upload_dir();
		$filenamefeed = $upload_dir->basedir."/".$prefFeed."feed-xml-".get_current_blog_id().".xml";		
	} else {
		$upload_dir = (object)wp_get_upload_dir();
		$filenamefeed = $upload_dir->basedir."/".$prefFeed."feed-xml-0.xml";
	}
	if (file_exists($filenamefeed)) {		
		xfgmc_error_log('FEED № '.$numFeed.'; Файл с фидом '.$filenamefeed.' есть. Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__ , 0);
		// return; // файла с фидом нет
		clearstatcache(); // очищаем кэш дат файлов
		$last_upd_file = filemtime($filenamefeed);
		xfgmc_error_log('FEED № '.$numFeed.'; $xfgmc_date_save_set='.$xfgmc_date_save_set.'; $filenamefeed='.$filenamefeed, 0);
		xfgmc_error_log('FEED № '.$numFeed.'; Начинаем сравнивать даты! Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);	
		if ($xfgmc_date_save_set < $last_upd_file) {
			xfgmc_error_log('FEED № '.$numFeed.'; NOTICE: Нужно лишь обновить цены во всём фиде! Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
			xfgmc_clear_file_ids_in_xml($numFeed); /* С версии 2.0.0 */
			xfgmc_onlygluing($numFeed);
			return;
		}	
	}
	// далее исходим из того, что файла с фидом нет, либо нужна полная сборка
	
	$step_export = (int)xfgmc_optionGET('xfgmc_step_export', $numFeed);
	if ($step_export == 0) {$step_export = 500;}
	  
	if ($status_sborki == $step_export) { // начинаем сборку файла
		do_action('xfgmc_before_construct', 'full'); // сборка стартовала
		$result_xml = xfgmc_feed_header($numFeed);
		/* создаем файл или перезаписываем старый удалив содержимое */
		$result = xfgmc_write_file($result_xml, 'w+', $numFeed);
		if ($result !== true) {
			xfgmc_error_log('FEED № '.$numFeed.'; xfgmc_write_file вернула ошибку! $result ='.$result.'; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
			return; 
		} else {
			xfgmc_error_log('FEED № '.$numFeed.'; xfgmc_write_file отработала успешно; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
		}
		xfgmc_clear_file_ids_in_xml($numFeed); /* С версии 2.0.0 */	
	} 
	if ($status_sborki > 1) {
		$result_xml	= '';
		$offset = $status_sborki-$step_export;
		$whot_export = xfgmc_optionGET('xfgmc_whot_export', $numFeed);
		if ($whot_export === 'xfgmc_vygruzhat') {
			$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'posts_per_page' => $step_export,
				'offset' => $offset,
				'relation' => 'AND',
				'meta_query' => array(
					array(
						'key' => '_xfgmc_vygruzhat',
						'value' => 'yes'
					)
				)
			);			
		} else if ($whot_export === 'xmlset') {
			$xfgmc_xmlset_number = '1';
			$xfgmc_xmlset_number = apply_filters('xfgmc_xmlset_number_filter', $xfgmc_xmlset_number, $numFeed);
			$xfgmc_xmlset_key = '_xfgmc_xmlset'.$xfgmc_xmlset_number;
			$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'posts_per_page' => $step_export,
				'offset' => $offset,
				'relation' => 'AND',
				'meta_query' => array(
					array(
						'key' => $xfgmc_xmlset_key,
						'value' => 'on'
					)
				)
			);			
		} else { // if ($whot_export == 'all' || $whot_export == 'simple')
			$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'posts_per_page' => $step_export, // сколько выводить товаров
				'offset' => $offset,
				'relation' => 'AND'
			);
		}

		$args = apply_filters('xfgmc_query_arg_filter', $args, $numFeed);
		$featured_query = new WP_Query($args);
		$prod_id_arr = array(); 
		if ($featured_query->have_posts()) { 		
			for ($i = 0; $i < count($featured_query->posts); $i++) {
				// $prod_id_arr[] .= $featured_query->posts[$i]->ID;
				$prod_id_arr[$i]['ID'] = $featured_query->posts[$i]->ID;
				$prod_id_arr[$i]['post_modified_gmt'] =$featured_query->posts[$i]->post_modified_gmt;
			}
			wp_reset_query(); /* Remember to reset */
			unset($featured_query); // чутка освободим память
			xfgmc_gluing($prod_id_arr, $numFeed);
			$status_sborki = $status_sborki + $step_export;
			xfgmc_error_log('FEED № '.$numFeed.'; status_sborki увеличен на '.$step_export.' и равен '.$status_sborki.'; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);	  
			xfgmc_optionUPD('xfgmc_status_sborki', $status_sborki, $numFeed);		   
		} else {
			// если постов нет, пишем концовку файла
			xfgmc_error_log('FEED № '.$numFeed.'; Постов больше нет, пишем концовку файла; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);	
			$result_xml = apply_filters('xfgmc_after_offers_filter', $result_xml);
			$result_xml .= '</channel>'. PHP_EOL;
			$result_xml .= '</rss>'. PHP_EOL;
			/* создаем файл или перезаписываем старый удалив содержимое */
			$result = xfgmc_write_file($result_xml, 'a', $numFeed);
			xfgmc_error_log('FEED № '.$numFeed.'; Файл фида готов. Осталось только переименовать временный файл в основной; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
			xfgmc_rename_file($numFeed);
			// выставляем статус сборки в "готово"
			$status_sborki = -1;
			if ($result === true) {
				xfgmc_optionUPD('xfgmc_status_sborki', $status_sborki, $numFeed);
				// останавливаем крон сборки
				wp_clear_scheduled_hook('xfgmc_cron_sborki', array($numFeed));
				do_action('xfgmc_after_construct', 'full'); // сборка закончена
				xfgmc_error_log('FEED № '.$numFeed.'; SUCCESS: Сборка успешно завершена; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
			} else {
				xfgmc_error_log('FEED № '.$numFeed.'; ERROR: На завершающем этапе xfgmc_write_file вернула ошибку! Я не смог записать концовку файла... $result ='.$result.'; Файл: xml-for-google-merchant-center.php; Строка: '.__LINE__, 0);
				do_action('xfgmc_after_construct', 'false'); // сборка закончена
				return;
			}
		} // end if ($featured_query->have_posts())
	  } // end if ($status_sborki > 1)
   } // end public static function xfgmc_construct_xmlы
} /* end class XmlforGoogleMerchantCenter */
?>
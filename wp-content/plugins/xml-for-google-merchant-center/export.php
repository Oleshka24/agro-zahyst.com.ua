<?php if (!defined('ABSPATH')) {exit;} // Защита от прямого вызова скрипта
function xfgmc_export_page() { 
	$numFeed = '1'; // (string)
	if (isset($_REQUEST['xfgmc_submit_send_select_feed'])) {
	 if (!empty($_POST) && check_admin_referer('xfgmc_nonce_action_send_select_feed', 'xfgmc_nonce_field_send_select_feed')) {
	   $numFeed = $_POST['xfgmc_num_feed'];
	 } 
	}	
	$status_sborki = (int)xfgmc_optionGET('xfgmc_status_sborki', $numFeed);

	if (isset($_REQUEST['xfgmc_submit_action'])) {
	  if (!empty($_POST) && check_admin_referer('xfgmc_nonce_action', 'xfgmc_nonce_field')) {
	   do_action('xfgmc_prepend_submit_action', $numFeed);
   
	   $numFeed = sanitize_text_field($_POST['xfgmc_num_feed_for_save']);
   
	   $unixtime = current_time('timestamp', 1); // 1335808087 - временная зона GMT (Unix формат)
	   xfgmc_optionUPD('xfgmc_date_save_set', $unixtime, $numFeed);
	   
	   $arr_maybe = array("off", "five_min", "hourly", "six_hours", "twicedaily", "daily");
	   $xfgmc_run_cron = sanitize_text_field($_POST['xfgmc_run_cron']);
	   
		if (in_array($xfgmc_run_cron, $arr_maybe)) {		
			xfgmc_optionUPD('xfgmc_status_cron', $xfgmc_run_cron, $numFeed);
			if ($xfgmc_run_cron === 'off') {
				// отключаем крон
				wp_clear_scheduled_hook('xfgmc_cron_period', array($numFeed));
				xfgmc_optionUPD('xfgmc_status_cron', 'off', $numFeed);
			
				wp_clear_scheduled_hook('xfgmc_cron_sborki', array($numFeed));
				xfgmc_optionUPD('xfgmc_status_sborki', '-1', $numFeed);
			} else {
				$recurrence = $xfgmc_run_cron;
				wp_clear_scheduled_hook('xfgmc_cron_period', array($numFeed));
				wp_schedule_event(time(), $recurrence, 'xfgmc_cron_period', array($numFeed));
				xfgmc_error_log('FEED № '.$numFeed.'; xfgmc_cron_period внесен в список заданий; Файл: export.php; Строка: '.__LINE__, 0);
			}
		} else {
		   xfgmc_error_log('Крон '.$xfgmc_run_cron.' не зарегистрирован. Файл: export.php; Строка: '.__LINE__, 0);
	  	}	
   
	   if (isset($_POST['xfgmc_ufup'])) {
		   xfgmc_optionUPD('xfgmc_ufup', sanitize_text_field($_POST['xfgmc_ufup']), $numFeed);
	   } else {
		   xfgmc_optionUPD('xfgmc_ufup', '0', $numFeed);
	   }

	   xfgmc_optionUPD('xfgmc_feed_assignment', sanitize_text_field($_POST['xfgmc_feed_assignment']), $numFeed);
	   xfgmc_optionUPD('xfgmc_adapt_facebook', sanitize_text_field($_POST['xfgmc_adapt_facebook']), $numFeed);
	   xfgmc_optionUPD('xfgmc_whot_export', sanitize_text_field($_POST['xfgmc_whot_export']), $numFeed);	
	   xfgmc_optionUPD('xfgmc_desc', sanitize_text_field($_POST['xfgmc_desc']), $numFeed);
	   xfgmc_optionUPD('xfgmc_the_content', sanitize_text_field($_POST['xfgmc_the_content']), $numFeed);
	   if (isset($_POST['xfgmc_var_desc_priority'])) {
		xfgmc_optionUPD('xfgmc_var_desc_priority', sanitize_text_field($_POST['xfgmc_var_desc_priority']), $numFeed);
		} else {
		xfgmc_optionUPD('xfgmc_var_desc_priority', '0', $numFeed);
		}	   
		xfgmc_optionUPD('xfgmc_shop_name', sanitize_text_field($_POST['xfgmc_shop_name']), $numFeed);
		xfgmc_optionUPD('xfgmc_shop_description', sanitize_text_field($_POST['xfgmc_shop_description']), $numFeed);
		xfgmc_optionUPD('xfgmc_target_country', sanitize_text_field($_POST['xfgmc_target_country']), $numFeed);
		xfgmc_optionUPD('xfgmc_default_currency', sanitize_text_field($_POST['xfgmc_default_currency']), $numFeed);
		if (isset($_POST['xfgmc_wooc_currencies'])) {
			xfgmc_optionUPD('xfgmc_wooc_currencies', sanitize_text_field($_POST['xfgmc_wooc_currencies']), $numFeed);
		}
		xfgmc_optionUPD('xfgmc_main_product', sanitize_text_field($_POST['xfgmc_main_product']), $numFeed);	
		xfgmc_optionUPD('xfgmc_step_export', sanitize_text_field($_POST['xfgmc_step_export']), $numFeed);
		xfgmc_optionUPD('xfgmc_behavior_onbackorder', sanitize_text_field($_POST['xfgmc_behavior_onbackorder']), $numFeed);
	   
	   if (isset($_POST['xfgmc_skip_missing_products'])) {
		   xfgmc_optionUPD('xfgmc_skip_missing_products', sanitize_text_field($_POST['xfgmc_skip_missing_products']), $numFeed);
	   } else {
		   xfgmc_optionUPD('xfgmc_skip_missing_products', '0', $numFeed);
	   }
	   
	   if (isset($_POST['xfgmc_skip_backorders_products'])) {
		   xfgmc_optionUPD('xfgmc_skip_backorders_products', sanitize_text_field($_POST['xfgmc_skip_backorders_products']), $numFeed);
	   } else {
		   xfgmc_optionUPD('xfgmc_skip_backorders_products', '0', $numFeed);
	   }
	   
	   if (isset($_POST['xfgmc_one_variable'])) {
		   xfgmc_optionUPD('xfgmc_one_variable', sanitize_text_field($_POST['xfgmc_one_variable']), $numFeed);
	   } else {
		   xfgmc_optionUPD('xfgmc_one_variable', '0', $numFeed);
	   }

	   xfgmc_optionUPD('xfgmc_def_shipping_country', sanitize_text_field($_POST['xfgmc_def_shipping_country']), $numFeed);
	   xfgmc_optionUPD('xfgmc_def_delivery_area_type', sanitize_text_field($_POST['xfgmc_def_delivery_area_type']), $numFeed);
	   xfgmc_optionUPD('xfgmc_def_delivery_area_value', sanitize_text_field($_POST['xfgmc_def_delivery_area_value']), $numFeed);
	   xfgmc_optionUPD('xfgmc_def_shipping_service', sanitize_text_field($_POST['xfgmc_def_shipping_service']), $numFeed);      
	   xfgmc_optionUPD('xfgmc_def_shipping_price', sanitize_text_field($_POST['xfgmc_def_shipping_price']), $numFeed);

	   xfgmc_optionUPD('xfgmc_tax_info', sanitize_text_field($_POST['xfgmc_tax_info']), $numFeed);
	   xfgmc_optionUPD('xfgmc_def_shipping_label', sanitize_text_field($_POST['xfgmc_def_shipping_label']), $numFeed);
	   xfgmc_optionUPD('xfgmc_def_min_handling_time', sanitize_text_field($_POST['xfgmc_def_min_handling_time']), $numFeed);
	   xfgmc_optionUPD('xfgmc_def_max_handling_time', sanitize_text_field($_POST['xfgmc_def_max_handling_time']), $numFeed);      
	   xfgmc_optionUPD('xfgmc_product_type', sanitize_text_field($_POST['xfgmc_product_type']), $numFeed);
	   xfgmc_optionUPD('xfgmc_product_type_home', sanitize_text_field($_POST['xfgmc_product_type_home']), $numFeed);
	   xfgmc_optionUPD('xfgmc_sale_price', sanitize_text_field($_POST['xfgmc_sale_price']), $numFeed);	   
	   xfgmc_optionUPD('xfgmc_gtin', sanitize_text_field($_POST['xfgmc_gtin']), $numFeed);
	   xfgmc_optionUPD('xfgmc_gtin_post_meta', sanitize_text_field($_POST['xfgmc_gtin_post_meta']), $numFeed);
	   xfgmc_optionUPD('xfgmc_mpn', sanitize_text_field($_POST['xfgmc_mpn']), $numFeed);
	   xfgmc_optionUPD('xfgmc_mpn_post_meta', sanitize_text_field($_POST['xfgmc_mpn_post_meta']), $numFeed);
	   xfgmc_optionUPD('xfgmc_age', sanitize_text_field($_POST['xfgmc_age']), $numFeed);
	   xfgmc_optionUPD('xfgmc_age_group_post_meta', sanitize_text_field($_POST['xfgmc_age_group_post_meta']), $numFeed);
	   xfgmc_optionUPD('xfgmc_brand', sanitize_text_field($_POST['xfgmc_brand']), $numFeed);
	   xfgmc_optionUPD('xfgmc_brand_post_meta', sanitize_text_field($_POST['xfgmc_brand_post_meta']), $numFeed);
	   xfgmc_optionUPD('xfgmc_color', sanitize_text_field($_POST['xfgmc_color']), $numFeed);
	   xfgmc_optionUPD('xfgmc_material', sanitize_text_field($_POST['xfgmc_material']), $numFeed);
	   xfgmc_optionUPD('xfgmc_pattern', sanitize_text_field($_POST['xfgmc_pattern']), $numFeed);
	   
	   xfgmc_optionUPD('xfgmc_gender', sanitize_text_field($_POST['xfgmc_gender']), $numFeed);
	   xfgmc_optionUPD('xfgmc_gender_alt', sanitize_text_field($_POST['xfgmc_gender_alt']), $numFeed);
	   xfgmc_optionUPD('xfgmc_size', sanitize_text_field($_POST['xfgmc_size']), $numFeed);
	   xfgmc_optionUPD('xfgmc_size_type', sanitize_text_field($_POST['xfgmc_size_type']), $numFeed);
	   xfgmc_optionUPD('xfgmc_size_type_alt', sanitize_text_field($_POST['xfgmc_size_type_alt']), $numFeed);	
	   xfgmc_optionUPD('xfgmc_size_system', sanitize_text_field($_POST['xfgmc_size_system']), $numFeed);
	   xfgmc_optionUPD('xfgmc_size_system_alt', sanitize_text_field($_POST['xfgmc_size_system_alt']), $numFeed);	
	 }
	} 
   
	$xfgmc_file_url = urldecode(xfgmc_optionGET('xfgmc_file_url', $numFeed));
	$xfgmc_date_sborki = xfgmc_optionGET('xfgmc_date_sborki', $numFeed);  
	$xfgmc_status_cron = xfgmc_optionGET('xfgmc_status_cron', $numFeed);
	
	$xfgmc_ufup = xfgmc_optionGET('xfgmc_ufup', $numFeed);
	$xfgmc_feed_assignment = xfgmc_optionGET('xfgmc_feed_assignment', $numFeed);
	$xfgmc_adapt_facebook = xfgmc_optionGET('xfgmc_adapt_facebook', $numFeed);
	$xfgmc_whot_export = xfgmc_optionGET('xfgmc_whot_export', $numFeed); 
	$xfgmc_desc = xfgmc_optionGET('xfgmc_desc', $numFeed);
	$xfgmc_the_content = xfgmc_optionGET('xfgmc_the_content', $numFeed);
	$xfgmc_var_desc_priority = xfgmc_optionGET('xfgmc_var_desc_priority', $numFeed);
	$xfgmc_shop_name = stripslashes(htmlspecialchars(xfgmc_optionGET('xfgmc_shop_name', $numFeed)));
	$xfgmc_shop_description = stripslashes(htmlspecialchars(xfgmc_optionGET('xfgmc_shop_description', $numFeed))); 
	$xfgmc_target_country = xfgmc_optionGET('xfgmc_target_country', $numFeed); 
	$xfgmc_default_currency = xfgmc_optionGET('xfgmc_default_currency', $numFeed);
	$xfgmc_wooc_currencies = xfgmc_optionGET('xfgmc_wooc_currencies', $numFeed);
	$xfgmc_main_product = xfgmc_optionGET('xfgmc_main_product', $numFeed);   
	$xfgmc_step_export = xfgmc_optionGET('xfgmc_step_export', $numFeed);  
	$xfgmc_behavior_onbackorder = xfgmc_optionGET('xfgmc_behavior_onbackorder', $numFeed);
	$xfgmc_skip_missing_products = xfgmc_optionGET('xfgmc_skip_missing_products', $numFeed); 
	$xfgmc_skip_backorders_products = xfgmc_optionGET('xfgmc_skip_backorders_products', $numFeed); 
	$xfgmc_one_variable = xfgmc_optionGET('xfgmc_one_variable', $numFeed); 

	$xfgmc_def_shipping_country	= xfgmc_optionGET('xfgmc_def_shipping_country', $numFeed);
	$xfgmc_def_delivery_area_type = xfgmc_optionGET('xfgmc_def_delivery_area_type', $numFeed);
	$xfgmc_def_delivery_area_value = xfgmc_optionGET('xfgmc_def_delivery_area_value', $numFeed);
	$xfgmc_def_shipping_service = xfgmc_optionGET('xfgmc_def_shipping_service', $numFeed);		
	$xfgmc_def_shipping_price = xfgmc_optionGET('xfgmc_def_shipping_price', $numFeed);
   
	$xfgmc_tax_info	= xfgmc_optionGET('xfgmc_tax_info', $numFeed);
	$xfgmc_def_shipping_label = xfgmc_optionGET('xfgmc_def_shipping_label', $numFeed);
	$xfgmc_def_min_handling_time = xfgmc_optionGET('xfgmc_def_min_handling_time', $numFeed);
	$xfgmc_def_max_handling_time = xfgmc_optionGET('xfgmc_def_max_handling_time', $numFeed);		
	$xfgmc_product_type = xfgmc_optionGET('xfgmc_product_type', $numFeed);
	$xfgmc_product_type_home = xfgmc_optionGET('xfgmc_product_type_home', $numFeed);
	$xfgmc_sale_price = xfgmc_optionGET('xfgmc_sale_price', $numFeed);
	$xfgmc_gtin = xfgmc_optionGET('xfgmc_gtin', $numFeed);
	$xfgmc_gtin_post_meta = xfgmc_optionGET('xfgmc_gtin_post_meta', $numFeed);
	$xfgmc_mpn = xfgmc_optionGET('xfgmc_mpn', $numFeed); 
	$xfgmc_mpn_post_meta = xfgmc_optionGET('xfgmc_mpn_post_meta', $numFeed);
	$xfgmc_age = xfgmc_optionGET('xfgmc_age', $numFeed);  
	$xfgmc_age_group_post_meta = xfgmc_optionGET('xfgmc_age_group_post_meta', $numFeed);
	$xfgmc_brand = xfgmc_optionGET('xfgmc_brand', $numFeed);  
	$xfgmc_brand_post_meta = xfgmc_optionGET('xfgmc_brand_post_meta', $numFeed);	
	$xfgmc_color = xfgmc_optionGET('xfgmc_color', $numFeed); 
	$xfgmc_material = xfgmc_optionGET('xfgmc_material', $numFeed); 
	$xfgmc_pattern = xfgmc_optionGET('xfgmc_pattern', $numFeed);  
	
	$xfgmc_gender = xfgmc_optionGET('xfgmc_gender', $numFeed); 
	$xfgmc_gender_alt = xfgmc_optionGET('xfgmc_gender_alt', $numFeed); 
	$xfgmc_size = xfgmc_optionGET('xfgmc_size', $numFeed); 
	$xfgmc_size_type = xfgmc_optionGET('xfgmc_size_type', $numFeed);  
	$xfgmc_size_type_alt = xfgmc_optionGET('xfgmc_size_type_alt', $numFeed);  
	$xfgmc_size_system = xfgmc_optionGET('xfgmc_size_system', $numFeed);  
	$xfgmc_size_system_alt = xfgmc_optionGET('xfgmc_size_system_alt', $numFeed); 
?>
 <div class="wrap">
  <h1><?php _e('Exporter Google Merchant Center', 'xfgmc'); ?></h1>
 	<?php $woo_version = xfgmc_get_woo_version_number();
	if ($woo_version <= 3.0 ) {
		print '<div class="notice notice-error is-dismissible"><p>'. __('For the plugin to function correctly, you need a version of WooCommerce 3.0 and higher! You have version ', 'xfgmc'). $woo_version . __(' installed. Please, update WooCommerce', 'xfgmc'). '! <a href="#">'. __('Learn More', 'xfgmc'). '</a>.</p></div>';		
	}
	if (defined('DISABLE_WP_CRON')) {
	 if (DISABLE_WP_CRON == true) {
		print '<div class="notice notice-error is-dismissible"><p>'. __('Most likely, the plugin does not work correctly because you turned off the CRON with the help of the ', 'xfgmc'). 'DISABLE_WP_CRON.</p></div>';
	 }
	}
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

	$xfgmc_newcat_id = '';	
	$xfgmc_newcat_id_arr = array();
	if (isset($_REQUEST['xfgmc_submit_newcat_id'])) {
	 if (!empty($_POST) && check_admin_referer('xfgmc_nonce_action_newcat_id', 'xfgmc_nonce_field_newcat_id')) {		 
	 $xfgmc_newcat_id = sanitize_text_field($_POST['xfgmc_newcat_id']);
	 if (isset($_POST['xfgmc_newcat_id_arr']) && is_array($_POST['xfgmc_newcat_id_arr'])) {
		$xfgmc_newcat_id_arr = array_map('absint', $_POST['xfgmc_newcat_id_arr']);	
		
		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'relation' => 'AND',
			'fields' => 'ids'
		);
		$args['tax_query'] = array('relation' => 'AND',
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'id',
				'terms'    => $xfgmc_newcat_id_arr,
				'operator' => 'IN',
			)
		);		
		$fq = new WP_Query($args);
		$prod_id_arr = array(); 
		$ntoupd = 0;		
		if ($fq->have_posts()) { 			
			$ntoupd = count($fq->posts);
			for ($i = 0; $i < $ntoupd; $i++) {
				$postId = $fq->posts[$i];				
				update_post_meta($postId, 'xfgmc_google_product_category', $xfgmc_newcat_id);
				xfgmc_error_log('Товару с $postId = '.$postId.' добавлена категория гугл $xfgmc_newcat_id = '.$xfgmc_newcat_id.'; Файл: export.php; Строка: '.__LINE__, 0);
			}
		}
		wp_reset_query(); /* Remember to reset */
		unset($fq); // чутка освободим память
		print '<div class="notice notice-success is-dismissible"><p>'.$ntoupd.' ' .__('products has been updated', 'xfgmc'). '.</p></div>';	
	 } else {
		print '<div class="notice notice-warning is-dismissible"><p>'. __('There are no products in these categories', 'xfgmc'). '!</p></div>';	
	 }	
	 }
	} ?> 
 <div class="notice notice-info">
 <p><span class="xfgmc_bold">XML for Google Merchant Center Pro</span> - <?php _e('a necessary extension for those who want to', 'xfgmc'); ?> <span class="xfgmc_bold" style="color: green;"><?php _e('save on advertising budget', 'xfgmc'); ?></span> <?php _e('on Google', 'xfgmc'); ?>! <a href="https://icopydoc.ru/product/plagin-xml-for-google-merchant-center-pro/?utm_source=xml-for-google-merchant-center&utm_medium=organic&utm_campaign=in-plugin-xml-for-google-merchant-center&utm_content=settings&utm_term=about-xml-google-pro"><?php _e('Learn More', 'xfgmc'); ?></a>.</p> 
 </div>
 <?php do_action('xfgmc_before_poststuff', $numFeed); ?>
 <div id="poststuff"><div id="post-body" class="columns-2">
  <div id="postbox-container-1" class="postbox-container"><div class="meta-box-sortables">
  	<?php do_action('xfgmc_prepend_container_1', $numFeed); ?>
	<div class="postbox"> 
	 <div class="inside">	
	  <p style="text-align: center;"><strong style="color: green;"><?php _e('Instruction', 'xfgmc'); ?>:</strong> <a href="<?php _e('https://icopydoc.ru/en/how-to-create-an-xml-feed-in-woocommerce-for-google-merchant-center-instruction/', 'xfgmc'); ?>?utm_source=xml-for-google-merchant-center&utm_medium=organic&utm_campaign=in-plugin-xml-for-google-merchant-center&utm_content=settings&utm_term=main-instruction" target="_blank"><?php _e('How to create a XML-feed', 'xfgmc'); ?></a>.</p>
	  <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">	
		<select style="width: 100%" name="xfgmc_num_feed" id="xfgmc_num_feed">
			<?php if (is_multisite()) {$cur_blog_id = get_current_blog_id();} else {$cur_blog_id = '0';}		
			$allNumFeed = (int)xfgmc_ALLNUMFEED; $ii = '1';
			for ($i = 1; $i<$allNumFeed+1; $i++) : ?>
			<option value="<?php echo $i; ?>" <?php selected($numFeed, $i); ?>><?php _e('Feed', 'xfgmc'); ?> <?php echo $i; ?>: feed-xml-<?php echo $cur_blog_id; ?>.xml <?php $assignment = xfgmc_optionGET('xfgmc_feed_assignment', $ii); if ($assignment === '') {} else {echo '('.$assignment.')';} ?></option>
			<?php $ii++; endfor; ?>
		</select>
		<?php wp_nonce_field('xfgmc_nonce_action_send_select_feed', 'xfgmc_nonce_field_send_select_feed'); ?>
		<input style="width: 100%; margin: 10px 0 10px 0;" class="button" type="submit" name="xfgmc_submit_send_select_feed" value="<?php _e('Select feed', 'xfgmc'); ?>" />
	  </form>
  	 </div>
	</div>
	
	<div class="postbox">
	  <h2 class="hndle"><?php _e('Please support the project!', 'xfgmc'); ?></h2>
	  <div class="inside">
		<p><?php _e('Thank you for using the plugin', 'xfgmc'); ?> <strong>XML for Google Merchant Center</strong></p>
		<p><?php _e('Please help make the plugin better', 'xfgmc'); ?> <a href="//forms.gle/cCTNqWbUQzQcJpZJ9" target="_blank" ><?php _e('answering 6 questions', 'xfgmc'); ?>!</a></p>
		<p><?php _e('If this plugin useful to you, please support the project one way', 'xfgmc'); ?>:</p>
		<ul class="xfgmc_ul">
			<li><a href="//wordpress.org/support/plugin/xml-for-google-merchant-center/reviews/" target="_blank"><?php _e('Leave a comment on the plugin page', 'xfgmc'); ?></a>.</li>
			<li><?php _e('Support the project financially', 'xfgmc'); ?>! <a href="//sobe.ru/na/xml_for_google_merchant_center" target="_blank"> <?php _e('Donate now', 'xfgmc'); ?></a>.</li>
			<li><?php _e('Noticed a bug or have an idea how to improve the quality of the plugin', 'xfgmc'); ?>? <a href="mailto:support@icopydoc.ru"><?php _e('Let me know', 'xfgmc'); ?></a>.</li>
		</ul>
		<p><?php _e('The author of the plugin Maxim Glazunov', 'xfgmc'); ?>.</p>
		<p><span style="color: red;"><?php _e('Accept orders for individual revision of the plugin', 'xfgmc'); ?></span>:<br /><a href="mailto:support@icopydoc.ru"><?php _e('Leave a request', 'xfgmc'); ?></a>.</p>
	  </div>
	</div>	
	<?php do_action('xfgmc_before_support_project'); ?>
	<?php do_action('xfgmc_between_container_1', $numFeed); ?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
	 <input type="hidden" name="xfgmc_num_feed_for_save" value="<?php echo $numFeed; ?>">
	 <div class="postbox">
	  <h2 class="hndle"><?php _e('Send data about the work of the plugin', 'xfgmc'); ?></h2>
	  <div class="inside">
	  	<p><?php _e('Sending statistics you help make the plugin even better', 'xfgmc'); ?>! <?php _e('The following data will be transferred', 'xfgmc'); ?>:</p>
		<ul class="xfgmc_ul">
			<li><?php _e('URL XML-feed', 'xfgmc'); ?></li>
			<li><?php _e('File generation status', 'xfgmc'); ?></li>
			<li><?php _e('Is the multisite mode enabled?', 'xfgmc'); ?></li>
		</ul>
		<p><?php _e('Did my plugin help you upload your products to the Google Merchant Center', 'xfgmc'); ?>?</p>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
		 <p>
			<input type="radio" name="xfgmc_its_ok" value="yes"><?php _e('Yes', 'xfgmc'); ?><br />
			<input type="radio" name="xfgmc_its_ok" value="no"><?php _e('No', 'xfgmc'); ?><br />
		 </p>
		 <p><?php _e("If you don't mind to be contacted in case of problems, please enter your email address", "xfgmc"); ?>.</p>
		 <p><input type="email" name="xfgmc_email"></p>
		 <p><?php _e("Your message", "xfgmc"); ?>:</p>
		 <p><textarea rows="6" cols="32" name="xfgmc_message" placeholder="<?php _e('Enter your text to send me a message (You can write me in Russian or English). I check my email several times a day', 'xfgmc'); ?>"></textarea></p>
		 <?php wp_nonce_field('xfgmc_nonce_action_send_stat', 'xfgmc_nonce_field_send_stat'); ?><input class="button-primary" type="submit" name="xfgmc_submit_send_stat" value="<?php _e('Send data', 'xfgmc'); ?>" />	 
		</form>
	  </div>
	 </div>
	</form>	
	<?php do_action('xfgmc_append_container_1', $numFeed); ?>
  </div></div>

  <div id="postbox-container-2" class="postbox-container"><div class="meta-box-sortables">
	<?php do_action('xfgmc_prepend_container_2', $numFeed); ?>
	<div class="postbox">
	  <h2 class="hndle"><?php _e('Feed', 'xfgmc'); ?> <?php echo $numFeed; ?>: <?php if ($numFeed !== '1') {echo $numFeed;} ?>feed-xml-<?php echo $cur_blog_id; ?>.xml <?php $assignment = xfgmc_optionGET('xfgmc_feed_assignment', $numFeed); if ($assignment === '') {} else {echo '('.$assignment.')';} ?> <?php if (empty($xfgmc_file_url)) : ?><?php _e('not created yet', 'xfgmc'); ?><?php else : ?><?php if ($status_sborki !== -1) : ?><?php _e('updating', 'xfgmc'); ?><?php else : ?><?php _e('created', 'xfgmc'); ?><?php endif; ?><?php endif; ?></h2>	
	  <div class="inside">
		<?php if (empty($xfgmc_file_url)) : ?> 
			<?php if ($status_sborki !== -1) : ?>
				<p><?php _e('We are working on automatic file creation. XML will be developed soon', 'xfgmc'); ?>.</p>
			<?php else : ?>		
				<p><?php _e('In order to do that, select another menu entry (which differs from "off") in the box called "Automatic file creation". You can also change values in other boxes if necessary, then press "Save"', 'xfgmc'); ?>.</p>
				<p><?php _e('After 1-7 minutes (depending on the number of products), the feed will be generated and a link will appear instead of this message', 'xfgmc'); ?>.</p>
			<?php endif; ?>
		<?php else : ?>
			<?php if ($status_sborki !== -1) : ?>
				<p><?php _e('We are working on automatic file creation. XML will be developed soon', 'xfgmc'); ?>.</p>
			<?php else : ?>
				<p><span class="fgmc_bold"><?php _e('Your XML feed here', 'xfgmc'); ?>:</span><br/><a target="_blank" href="<?php echo $xfgmc_file_url; ?>"><?php echo $xfgmc_file_url; ?></a>
				<br/><?php _e('File size', 'xfgmc'); ?>: <?php clearstatcache();
				if ($numFeed === '1') {$prefFeed = '';} else {$prefFeed = $numFeed;}
				$upload_dir = (object)wp_get_upload_dir();
				if (is_multisite()) {
					$filename = $upload_dir->basedir."/".$prefFeed."feed-xml-".get_current_blog_id().".xml";
				} else {
					$filename = $upload_dir->basedir."/".$prefFeed."feed-xml-0.xml";				
				}
				if (is_file($filename)) {echo xfgmc_formatSize(filesize($filename));} else {echo '0 KB';} ?>
				<br/><?php _e('Generated', 'xfgmc'); ?>: <?php echo $xfgmc_date_sborki; ?></p>
			<?php endif; ?>		
		<?php endif; ?>
		<p><?php _e('Please note that Google Merchant Center checks XML no more than 3 times a day! This means that the changes on the Google Merchant Center are not instantaneous', 'xfgmc'); ?>!</p>
	  </div>
	</div>	  
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
	 <?php do_action('xfgmc_prepend_form_container_2', $numFeed); ?>
	 <input type="hidden" name="xfgmc_num_feed_for_save" value="<?php echo $numFeed; ?>">
	 <div class="postbox">
	  <h2 class="hndle"><?php _e('Main parameters', 'xfgmc'); ?></h2>
	   <div class="inside">	    
	   <table class="form-table"><tbody>
		 <tr>
			<th scope="row"><label for="xfgmc_run_cron"><?php _e('Automatic file creation', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_run_cron" id="xfgmc_run_cron">	
					<option value="off" <?php selected($xfgmc_status_cron, 'off' ); ?>><?php _e('Off', 'xfgmc'); ?></option>
					<?php $xfgmc_enable_five_min = xfgmc_optionGET('xfgmc_enable_five_min'); if ($xfgmc_enable_five_min === 'on') : ?>
					<option value="five_min" <?php selected($xfgmc_status_cron, 'five_min' );?> ><?php _e('Every five minutes', 'xfgmc'); ?></option>
					<?php endif; ?>
					<option value="hourly" <?php selected($xfgmc_status_cron, 'hourly' )?> ><?php _e('Hourly', 'xfgmc'); ?></option>
					<option value="six_hours" <?php selected($xfgmc_status_cron, 'six_hours' ); ?> ><?php _e('Every six hours', 'xfgmc'); ?></option>	
					<option value="twicedaily" <?php selected($xfgmc_status_cron, 'twicedaily' )?> ><?php _e('Twice a day', 'xfgmc'); ?></option>
					<option value="daily" <?php selected($xfgmc_status_cron, 'daily' )?> ><?php _e('Daily', 'xfgmc'); ?></option>
				</select><br />
				<span class="description"><?php _e('The refresh interval on your feed', 'xfgmc'); ?></span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_ufup"><?php _e('Update feed when updating products', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<input type="checkbox" name="xfgmc_ufup" id="xfgmc_ufup" <?php checked($xfgmc_ufup, 'on' ); ?>/>
			</td>
		 </tr>
		 <?php do_action('xfgmc_after_ufup_option', $numFeed); /* С версии 2.1.0 */ ?>
		 <tr>
			<th scope="row"><label for="xfgmc_feed_assignment"><?php _e('Feed assignment', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<input type="text" maxlength="20" name="xfgmc_feed_assignment" id="xfgmc_feed_assignment" value="<?php echo $xfgmc_feed_assignment; ?>" placeholder="<?php _e('For Google', 'xfgmc');?>" /><br />
				<span class="description"><?php _e('Not used in feed. Inner note for your convenience', 'xfgmc'); ?>.</span>
			</td>
		 </tr>		 
		 <tr>
		 	<th scope="row"><label for="xfgmc_adapt_facebook"><?php _e('Adapt for Facebook', 'xfgmc'); ?> (beta)</label></th>
			<td class="overalldesc">
				<select name="xfgmc_adapt_facebook" id="xfgmc_adapt_facebook">
					<option value="no" <?php selected($xfgmc_adapt_facebook, 'no' ); ?>><?php _e('No', 'xfgmc'); ?></option>
					<option value="yes" <?php selected($xfgmc_adapt_facebook, 'yes' ); ?>><?php _e('Yes', 'xfgmc'); ?></option>
				</select><br />
				<span class="description"><?php _e('If you want to create a Facebook feed, set the value to ', 'xfgmc'); ?> "<?php _e('Yes', 'xfgmc'); ?>". <?php _e('If the feed is for Google Merchant Center, select', 'xfgmc'); ?> "<?php _e('No', 'xfgmc'); ?>"</span>
			</td>
		 </tr>
		 <tr class="xfgmc_tr">
			<th scope="row"><label for="xfgmc_whot_export"><?php _e('Whot export', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_whot_export" id="xfgmc_whot_export">
					<option value="all" <?php selected($xfgmc_whot_export, 'all' ); ?>><?php _e('Simple & Variable products', 'xfgmc'); ?></option>
					<option value="simple" <?php selected( $xfgmc_whot_export, 'simple' ); ?>><?php _e('Only simple products', 'xfgmc'); ?></option>
					<?php do_action('xfgmc_after_whot_export_option', $numFeed); ?>
				</select><br />
				<span class="description"><?php _e('Whot export', 'xfgmc'); ?></span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_desc"><?php _e('Description of the product', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_desc" id="xfgmc_desc">
				<option value="excerpt" <?php selected($xfgmc_desc, 'excerpt'); ?>><?php _e('Only Excerpt description', 'xfgmc'); ?></option>
				<option value="full" <?php selected($xfgmc_desc, 'full'); ?>><?php _e('Only Full description', 'xfgmc'); ?></option>
				<option value="excerptfull" <?php selected($xfgmc_desc, 'excerptfull'); ?>><?php _e('Excerpt or Full description', 'xfgmc'); ?></option>
				<option value="fullexcerpt" <?php selected($xfgmc_desc, 'fullexcerpt'); ?>><?php _e('Full or Excerpt description', 'xfgmc'); ?></option>
				<option value="excerptplusfull" <?php selected($xfgmc_desc, 'excerptplusfull'); ?>><?php _e('Excerpt plus Full description', 'xfgmc'); ?></option>
				<option value="fullplusexcerpt" <?php selected($xfgmc_desc, 'fullplusexcerpt'); ?>><?php _e('Full plus Excerpt description', 'xfgmc'); ?></option>
				<?php do_action('xfgmc_append_select_xfgmc_desc', $xfgmc_desc, $numFeed); /* с версии 2.1.0 */ ?>
				</select><br />
				<?php do_action('xfgmc_after_select_xfgmc_desc', $xfgmc_desc, $numFeed); /* с версии 2.1.0 */ ?>
				<span class="description"><?php _e('The source of the description', 'xfgmc'); ?>
				</span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_the_content"><?php _e('Use the filter', 'xfgmc'); ?> the_content</label></th>
			<td class="overalldesc">
				<select name="xfgmc_the_content" id="xfgmc_the_content">
				<option value="disabled" <?php selected($xfgmc_the_content, 'disabled'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
				<option value="enabled" <?php selected($xfgmc_the_content, 'enabled'); ?>><?php _e('Enabled', 'xfgmc'); ?></option>
				</select><br />
				<span class="description"><?php _e('Default', 'xfgmc'); ?>: <?php _e('Enabled', 'xfgmc'); ?></span>
			</td>
		 </tr>	
		 <tr>
			<th scope="row"><label for="xfgmc_var_desc_priority"><?php _e('The varition description takes precedence over others', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<input type="checkbox" name="xfgmc_var_desc_priority" id="xfgmc_var_desc_priority" <?php checked($xfgmc_var_desc_priority, 'on'); ?>/>
			</td>
		 </tr>		 	 		 
		 <tr class="xfgmc_tr">
			<th scope="row"><label for="xfgmc_shop_name"><?php _e('Shop name', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
			 <input maxlength="20" type="text" name="xfgmc_shop_name" id="xfgmc_shop_name" value="<?php echo $xfgmc_shop_name; ?>" /><br />
			 <span class="description"><?php _e('Required element', 'xfgmc'); ?> <strong>title</strong>. <?php _e('The short name of the store should not exceed 20 characters', 'xfgmc'); ?>.</span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_shop_description"><?php _e('The name of your data feed', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<input type="text" name="xfgmc_shop_description" id="xfgmc_shop_description" value="<?php echo $xfgmc_shop_description; ?>" /><br />
				<span class="description"><?php _e('Required element', 'xfgmc'); ?> <strong>description</strong>. <?php _e('The name of your data feed', 'xfgmc'); ?>.</span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_target_country"><?php _e('Target country', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_target_country" id="xfgmc_target_country">	
					<option value="BY" <?php selected($xfgmc_target_country, 'BY'); ?>><?php _e('Belarus', 'xfgmc'); ?></option>
					<option value="RU" <?php selected($xfgmc_target_country, 'RU'); ?>><?php _e('Russia', 'xfgmc'); ?></option>
					<option value="UA" <?php selected($xfgmc_target_country, 'UA'); ?>><?php _e('Ukraine', 'xfgmc'); ?></option>
					<option value="GB" <?php selected($xfgmc_target_country, 'GB'); ?>>United Kingdom</option>
					<option value="US" <?php selected($xfgmc_target_country, 'US'); ?>>United States</option>
					<option value="AF" <?php selected($xfgmc_target_country, 'AF'); ?>>Afghanistan</option>
					<option value="AX" <?php selected($xfgmc_target_country, 'AX'); ?>>Åland</option>
					<option value="AL" <?php selected($xfgmc_target_country, 'AL'); ?>>Albania</option>
					<option value="DZ" <?php selected($xfgmc_target_country, 'DZ'); ?>>Algeria</option>
					<option value="AS" <?php selected($xfgmc_target_country, 'AS'); ?>>American Samoa</option>
					<option value="AD" <?php selected($xfgmc_target_country, 'AD'); ?>>Andorra</option>
					<option value="AO" <?php selected($xfgmc_target_country, 'AO'); ?>>Angola</option>
					<option value="AI" <?php selected($xfgmc_target_country, 'AI'); ?>>Anguilla</option>
					<option value="AQ" <?php selected($xfgmc_target_country, 'AQ'); ?>>Antarctica</option>
					<option value="AG" <?php selected($xfgmc_target_country, 'AG'); ?>>Antigua and Barbuda</option>
					<option value="AR" <?php selected($xfgmc_target_country, 'AR'); ?>>Argentina</option>
					<option value="AM" <?php selected($xfgmc_target_country, 'AM'); ?>>Armenia</option>
					<option value="AW" <?php selected($xfgmc_target_country, 'AW'); ?>>Aruba</option>
					<option value="AU" <?php selected($xfgmc_target_country, 'AU'); ?>>Australia</option>
					<option value="AT" <?php selected($xfgmc_target_country, 'AT'); ?>>Austria</option>
					<option value="AZ" <?php selected($xfgmc_target_country, 'AZ'); ?>>Azerbaijan</option>
					<option value="BS" <?php selected($xfgmc_target_country, 'BS'); ?>>Bahamas</option>
					<option value="BH" <?php selected($xfgmc_target_country, 'BH'); ?>>Bahrain</option>
					<option value="BD" <?php selected($xfgmc_target_country, 'BD'); ?>>Bangladesh</option>
					<option value="BB" <?php selected($xfgmc_target_country, 'BB'); ?>>Barbados</option>
					<option value="BE" <?php selected($xfgmc_target_country, 'BE'); ?>>Belgium</option>
					<option value="BZ" <?php selected($xfgmc_target_country, 'BZ'); ?>>Belize</option>
					<option value="BJ" <?php selected($xfgmc_target_country, 'BJ'); ?>>Benin</option>
					<option value="BM" <?php selected($xfgmc_target_country, 'BM'); ?>>Bermuda</option>
					<option value="BT" <?php selected($xfgmc_target_country, 'BT'); ?>>Bhutan</option>
					<option value="BO" <?php selected($xfgmc_target_country, 'BO'); ?>>Bolivia</option>
					<option value="BQ" <?php selected($xfgmc_target_country, 'BQ'); ?>>Bonaire</option>
					<option value="BA" <?php selected($xfgmc_target_country, 'BA'); ?>>Bosnia and Herzegovina</option>
					<option value="BW" <?php selected($xfgmc_target_country, 'BW'); ?>>Botswana</option>
					<option value="BV" <?php selected($xfgmc_target_country, 'BV'); ?>>Bouvet Island</option>
					<option value="BR" <?php selected($xfgmc_target_country, 'BR'); ?>>Brazil</option>
					<option value="IO" <?php selected($xfgmc_target_country, 'IO'); ?>>British Indian Ocean Territory</option>
					<option value="VG" <?php selected($xfgmc_target_country, 'VG'); ?>>British Virgin Islands</option>
					<option value="BN" <?php selected($xfgmc_target_country, 'BN'); ?>>Brunei</option>
					<option value="BG" <?php selected($xfgmc_target_country, 'BG'); ?>>Bulgaria</option>
					<option value="BF" <?php selected($xfgmc_target_country, 'BF'); ?>>Burkina Faso</option>
					<option value="BI" <?php selected($xfgmc_target_country, 'BI'); ?>>Burundi</option>
					<option value="KH" <?php selected($xfgmc_target_country, 'KH'); ?>>Cambodia</option>
					<option value="CM" <?php selected($xfgmc_target_country, 'CM'); ?>>Cameroon</option>
					<option value="CA" <?php selected($xfgmc_target_country, 'CA'); ?>>Canada</option>
					<option value="CV" <?php selected($xfgmc_target_country, 'CV'); ?>>Cape Verde</option>
					<option value="KY" <?php selected($xfgmc_target_country, 'KY'); ?>>Cayman Islands</option>
					<option value="CF" <?php selected($xfgmc_target_country, 'CF'); ?>>Central African Republic</option>
					<option value="TD" <?php selected($xfgmc_target_country, 'TD'); ?>>Chad</option>
					<option value="CL" <?php selected($xfgmc_target_country, 'CL'); ?>>Chile</option>
					<option value="CN" <?php selected($xfgmc_target_country, 'CN'); ?>>China</option>
					<option value="CX" <?php selected($xfgmc_target_country, 'CX'); ?>>Christmas Island</option>
					<option value="CC" <?php selected($xfgmc_target_country, 'CC'); ?>>Cocos [Keeling] Islands</option>
					<option value="CO" <?php selected($xfgmc_target_country, 'CO'); ?>>Colombia</option>
					<option value="KM" <?php selected($xfgmc_target_country, 'KM'); ?>>Comoros</option>
					<option value="CK" <?php selected($xfgmc_target_country, 'CK'); ?>>Cook Islands</option>
					<option value="CR" <?php selected($xfgmc_target_country, 'CR'); ?>>Costa Rica</option>
					<option value="HR" <?php selected($xfgmc_target_country, 'HR'); ?>>Croatia</option>
					<option value="CU" <?php selected($xfgmc_target_country, 'CU'); ?>>Cuba</option>
					<option value="CW" <?php selected($xfgmc_target_country, 'CW'); ?>>Curacao</option>
					<option value="CY" <?php selected($xfgmc_target_country, 'CY'); ?>>Cyprus</option>
					<option value="CZ" <?php selected($xfgmc_target_country, 'CZ'); ?>>Czech Republic</option>
					<option value="CD" <?php selected($xfgmc_target_country, 'CD'); ?>>Democratic Republic of the Congo</option>
					<option value="DK" <?php selected($xfgmc_target_country, 'DK'); ?>>Denmark</option>
					<option value="DJ" <?php selected($xfgmc_target_country, 'DJ'); ?>>Djibouti</option>
					<option value="DM" <?php selected($xfgmc_target_country, 'DM'); ?>>Dominica</option>
					<option value="DO" <?php selected($xfgmc_target_country, 'DO'); ?>>Dominican Republic</option>
					<option value="TL" <?php selected($xfgmc_target_country, 'TL'); ?>>East Timor</option>
					<option value="EC" <?php selected($xfgmc_target_country, 'EC'); ?>>Ecuador</option>
					<option value="EG" <?php selected($xfgmc_target_country, 'EG'); ?>>Egypt</option>
					<option value="SV" <?php selected($xfgmc_target_country, 'SV'); ?>>El Salvador</option>
					<option value="GQ" <?php selected($xfgmc_target_country, 'GQ'); ?>>Equatorial Guinea</option>
					<option value="ER" <?php selected($xfgmc_target_country, 'ER'); ?>>Eritrea</option>
					<option value="EE" <?php selected($xfgmc_target_country, 'EE'); ?>>Estonia</option>
					<option value="ET" <?php selected($xfgmc_target_country, 'ET'); ?>>Ethiopia</option>
					<option value="FK" <?php selected($xfgmc_target_country, 'FK'); ?>>Falkland Islands</option>
					<option value="FO" <?php selected($xfgmc_target_country, 'FO'); ?>>Faroe Islands</option>
					<option value="FJ" <?php selected($xfgmc_target_country, 'FJ'); ?>>Fiji</option>
					<option value="FI" <?php selected($xfgmc_target_country, 'FI'); ?>>Finland</option>
					<option value="FR" <?php selected($xfgmc_target_country, 'FR'); ?>>France</option>
					<option value="GF" <?php selected($xfgmc_target_country, 'GF'); ?>>French Guiana</option>
					<option value="PF" <?php selected($xfgmc_target_country, 'PF'); ?>>French Polynesia</option>
					<option value="TF" <?php selected($xfgmc_target_country, 'TF'); ?>>French Southern Territories</option>
					<option value="GA" <?php selected($xfgmc_target_country, 'GA'); ?>>Gabon</option>
					<option value="GM" <?php selected($xfgmc_target_country, 'GM'); ?>>Gambia</option>
					<option value="GE" <?php selected($xfgmc_target_country, 'GE'); ?>>Georgia</option>
					<option value="DE" <?php selected($xfgmc_target_country, 'DE'); ?>>Germany</option>
					<option value="GH" <?php selected($xfgmc_target_country, 'GH'); ?>>Ghana</option>
					<option value="GI" <?php selected($xfgmc_target_country, 'GI'); ?>>Gibraltar</option>
					<option value="GR" <?php selected($xfgmc_target_country, 'GR'); ?>>Greece</option>
					<option value="GL" <?php selected($xfgmc_target_country, 'GL'); ?>>Greenland</option>
					<option value="GD" <?php selected($xfgmc_target_country, 'GD'); ?>>Grenada</option>
					<option value="GP" <?php selected($xfgmc_target_country, 'GP'); ?>>Guadeloupe</option>
					<option value="GU" <?php selected($xfgmc_target_country, 'GU'); ?>>Guam</option>
					<option value="GT" <?php selected($xfgmc_target_country, 'GT'); ?>>Guatemala</option>
					<option value="GG" <?php selected($xfgmc_target_country, 'GG'); ?>>Guernsey</option>
					<option value="GN" <?php selected($xfgmc_target_country, 'GN'); ?>>Guinea</option>
					<option value="GW" <?php selected($xfgmc_target_country, 'GW'); ?>>Guinea-Bissau</option>
					<option value="GY" <?php selected($xfgmc_target_country, 'GY'); ?>>Guyana</option>
					<option value="HT" <?php selected($xfgmc_target_country, 'HT'); ?>>Haiti</option>
					<option value="HM" <?php selected($xfgmc_target_country, 'HM'); ?>>Heard Island and McDonald Islands</option>
					<option value="HN" <?php selected($xfgmc_target_country, 'HN'); ?>>Honduras</option>
					<option value="HK" <?php selected($xfgmc_target_country, 'HK'); ?>>Hong Kong</option>
					<option value="HU" <?php selected($xfgmc_target_country, 'HU'); ?>>Hungary</option>
					<option value="IS" <?php selected($xfgmc_target_country, 'IS'); ?>>Iceland</option>
					<option value="IN" <?php selected($xfgmc_target_country, 'IN'); ?>>India</option>
					<option value="ID" <?php selected($xfgmc_target_country, 'ID'); ?>>Indonesia</option>
					<option value="IR" <?php selected($xfgmc_target_country, 'IR'); ?>>Iran</option>
					<option value="IQ" <?php selected($xfgmc_target_country, 'IQ'); ?>>Iraq</option>
					<option value="IE" <?php selected($xfgmc_target_country, 'IE'); ?>>Ireland</option>
					<option value="IM" <?php selected($xfgmc_target_country, 'IM'); ?>>Isle of Man</option>
					<option value="IL" <?php selected($xfgmc_target_country, 'IL'); ?>>Israel</option>
					<option value="IT" <?php selected($xfgmc_target_country, 'IT'); ?>>Italy</option>
					<option value="CI" <?php selected($xfgmc_target_country, 'CI'); ?>>Ivory Coast</option>
					<option value="JM" <?php selected($xfgmc_target_country, 'JM'); ?>>Jamaica</option>
					<option value="JP" <?php selected($xfgmc_target_country, 'JP'); ?>>Japan</option>
					<option value="JE" <?php selected($xfgmc_target_country, 'JE'); ?>>Jersey</option>
					<option value="JO" <?php selected($xfgmc_target_country, 'JO'); ?>>Jordan</option>
					<option value="KZ" <?php selected($xfgmc_target_country, 'KZ'); ?>>Kazakhstan</option>
					<option value="KE" <?php selected($xfgmc_target_country, 'KE'); ?>>Kenya</option>
					<option value="KI" <?php selected($xfgmc_target_country, 'KI'); ?>>Kiribati</option>
					<option value="XK" <?php selected($xfgmc_target_country, 'XK'); ?>>Kosovo</option>
					<option value="KW" <?php selected($xfgmc_target_country, 'KW'); ?>>Kuwait</option>
					<option value="KG" <?php selected($xfgmc_target_country, 'KG'); ?>>Kyrgyzstan</option>
					<option value="LA" <?php selected($xfgmc_target_country, 'LA'); ?>>Laos</option>
					<option value="LV" <?php selected($xfgmc_target_country, 'LV'); ?>>Latvia</option>
					<option value="LB" <?php selected($xfgmc_target_country, 'LB'); ?>>Lebanon</option>
					<option value="LS" <?php selected($xfgmc_target_country, 'LS'); ?>>Lesotho</option>
					<option value="LR" <?php selected($xfgmc_target_country, 'LR'); ?>>Liberia</option>
					<option value="LY" <?php selected($xfgmc_target_country, 'LY'); ?>>Libya</option>
					<option value="LI" <?php selected($xfgmc_target_country, 'LI'); ?>>Liechtenstein</option>
					<option value="LT" <?php selected($xfgmc_target_country, 'LT'); ?>>Lithuania</option>
					<option value="LU" <?php selected($xfgmc_target_country, 'LU'); ?>>Luxembourg</option>
					<option value="MO" <?php selected($xfgmc_target_country, 'MO'); ?>>Macao</option>
					<option value="MK" <?php selected($xfgmc_target_country, 'MK'); ?>>Macedonia</option>
					<option value="MG" <?php selected($xfgmc_target_country, 'MG'); ?>>Madagascar</option>
					<option value="MW" <?php selected($xfgmc_target_country, 'MW'); ?>>Malawi</option>
					<option value="MY" <?php selected($xfgmc_target_country, 'MY'); ?>>Malaysia</option>
					<option value="MV" <?php selected($xfgmc_target_country, 'MV'); ?>>Maldives</option>
					<option value="ML" <?php selected($xfgmc_target_country, 'ML'); ?>>Mali</option>
					<option value="MT" <?php selected($xfgmc_target_country, 'MT'); ?>>Malta</option>
					<option value="MH" <?php selected($xfgmc_target_country, 'MH'); ?>>Marshall Islands</option>
					<option value="MQ" <?php selected($xfgmc_target_country, 'MQ'); ?>>Martinique</option>
					<option value="MR" <?php selected($xfgmc_target_country, 'MR'); ?>>Mauritania</option>
					<option value="MU" <?php selected($xfgmc_target_country, 'MU'); ?>>Mauritius</option>
					<option value="YT" <?php selected($xfgmc_target_country, 'YT'); ?>>Mayotte</option>
					<option value="MX" <?php selected($xfgmc_target_country, 'MX'); ?>>Mexico</option>
					<option value="FM" <?php selected($xfgmc_target_country, 'FM'); ?>>Micronesia</option>
					<option value="MD" <?php selected($xfgmc_target_country, 'MD'); ?>>Moldova</option>
					<option value="MC" <?php selected($xfgmc_target_country, 'MC'); ?>>Monaco</option>
					<option value="MN" <?php selected($xfgmc_target_country, 'MN'); ?>>Mongolia</option>
					<option value="ME" <?php selected($xfgmc_target_country, 'ME'); ?>>Montenegro</option>
					<option value="MS" <?php selected($xfgmc_target_country, 'MS'); ?>>Montserrat</option>
					<option value="MA" <?php selected($xfgmc_target_country, 'MA'); ?>>Morocco</option>
					<option value="MZ" <?php selected($xfgmc_target_country, 'MZ'); ?>>Mozambique</option>
					<option value="MM" <?php selected($xfgmc_target_country, 'MM'); ?>>Myanmar [Burma]</option>
					<option value="NA" <?php selected($xfgmc_target_country, 'NA'); ?>>Namibia</option>
					<option value="NR" <?php selected($xfgmc_target_country, 'NR'); ?>>Nauru</option>
					<option value="NP" <?php selected($xfgmc_target_country, 'NP'); ?>>Nepal</option>
					<option value="NL" <?php selected($xfgmc_target_country, 'NL'); ?>>Netherlands</option>
					<option value="NC" <?php selected($xfgmc_target_country, 'NC'); ?>>New Caledonia</option>
					<option value="NZ" <?php selected($xfgmc_target_country, 'NZ'); ?>>New Zealand</option>
					<option value="NI" <?php selected($xfgmc_target_country, 'NI'); ?>>Nicaragua</option>
					<option value="NE" <?php selected($xfgmc_target_country, 'NE'); ?>>Niger</option>
					<option value="NG" <?php selected($xfgmc_target_country, 'NG'); ?>>Nigeria</option>
					<option value="NU" <?php selected($xfgmc_target_country, 'NU'); ?>>Niue</option>
					<option value="NF" <?php selected($xfgmc_target_country, 'NF'); ?>>Norfolk Island</option>
					<option value="KP" <?php selected($xfgmc_target_country, 'KP'); ?>>North Korea</option>
					<option value="MP" <?php selected($xfgmc_target_country, 'MP'); ?>>Northern Mariana Islands</option>
					<option value="NO" <?php selected($xfgmc_target_country, 'NO'); ?>>Norway</option>
					<option value="OM" <?php selected($xfgmc_target_country, 'OM'); ?>>Oman</option>
					<option value="PK" <?php selected($xfgmc_target_country, 'PK'); ?>>Pakistan</option>
					<option value="PW" <?php selected($xfgmc_target_country, 'PW'); ?>>Palau</option>
					<option value="PS" <?php selected($xfgmc_target_country, 'PS'); ?>>Palestine</option>
					<option value="PA" <?php selected($xfgmc_target_country, 'PA'); ?>>Panama</option>
					<option value="PG" <?php selected($xfgmc_target_country, 'PG'); ?>>Papua New Guinea</option>
					<option value="PY" <?php selected($xfgmc_target_country, 'PY'); ?>>Paraguay</option>
					<option value="PE" <?php selected($xfgmc_target_country, 'PE'); ?>>Peru</option>
					<option value="PH" <?php selected($xfgmc_target_country, 'PH'); ?>>Philippines</option>
					<option value="PN" <?php selected($xfgmc_target_country, 'PN'); ?>>Pitcairn Islands</option>
					<option value="PL" <?php selected($xfgmc_target_country, 'PL'); ?>>Poland</option>
					<option value="PT" <?php selected($xfgmc_target_country, 'PT'); ?>>Portugal</option>
					<option value="PR" <?php selected($xfgmc_target_country, 'PR'); ?>>Puerto Rico</option>
					<option value="QA" <?php selected($xfgmc_target_country, 'QA'); ?>>Qatar</option>
					<option value="CG" <?php selected($xfgmc_target_country, 'CG'); ?>>Republic of the Congo</option>
					<option value="RE" <?php selected($xfgmc_target_country, 'RE'); ?>>Réunion</option>
					<option value="RO" <?php selected($xfgmc_target_country, 'RO'); ?>>Romania</option>
					<option value="RW" <?php selected($xfgmc_target_country, 'RW'); ?>>Rwanda</option>
					<option value="BL" <?php selected($xfgmc_target_country, 'BL'); ?>>Saint Barthélemy</option>
					<option value="SH" <?php selected($xfgmc_target_country, 'SH'); ?>>Saint Helena</option>
					<option value="KN" <?php selected($xfgmc_target_country, 'KN'); ?>>Saint Kitts and Nevis</option>
					<option value="LC" <?php selected($xfgmc_target_country, 'LC'); ?>>Saint Lucia</option>
					<option value="MF" <?php selected($xfgmc_target_country, 'MF'); ?>>Saint Martin</option>
					<option value="PM" <?php selected($xfgmc_target_country, 'PM'); ?>>Saint Pierre and Miquelon</option>
					<option value="VC" <?php selected($xfgmc_target_country, 'VC'); ?>>Saint Vincent and the Grenadines</option>
					<option value="WS" <?php selected($xfgmc_target_country, 'WS'); ?>>Samoa</option>
					<option value="SM" <?php selected($xfgmc_target_country, 'SM'); ?>>San Marino</option>
					<option value="ST" <?php selected($xfgmc_target_country, 'ST'); ?>>São Tomé and Príncipe</option>
					<option value="SA" <?php selected($xfgmc_target_country, 'SA'); ?>>Saudi Arabia</option>
					<option value="SN" <?php selected($xfgmc_target_country, 'SN'); ?>>Senegal</option>
					<option value="RS" <?php selected($xfgmc_target_country, 'RS'); ?>>Serbia</option>
					<option value="SC" <?php selected($xfgmc_target_country, 'SC'); ?>>Seychelles</option>
					<option value="SL" <?php selected($xfgmc_target_country, 'SL'); ?>>Sierra Leone</option>
					<option value="SG" <?php selected($xfgmc_target_country, 'SG'); ?>>Singapore</option>
					<option value="SX" <?php selected($xfgmc_target_country, 'SX'); ?>>Sint Maarten</option>
					<option value="SK" <?php selected($xfgmc_target_country, 'SK'); ?>>Slovakia</option>
					<option value="SI" <?php selected($xfgmc_target_country, 'SI'); ?>>Slovenia</option>
					<option value="SB" <?php selected($xfgmc_target_country, 'SB'); ?>>Solomon Islands</option>
					<option value="SO" <?php selected($xfgmc_target_country, 'SO'); ?>>Somalia</option>
					<option value="ZA" <?php selected($xfgmc_target_country, 'ZA'); ?>>South Africa</option>
					<!--option value="GS" <?php selected($xfgmc_target_country, 'GS'); ?>>South Georgia and the South Sandwich Islands</option-->
					<option value="KR" <?php selected($xfgmc_target_country, 'KR'); ?>>South Korea</option>
					<option value="SS" <?php selected($xfgmc_target_country, 'SS'); ?>>South Sudan</option>
					<option value="ES" <?php selected($xfgmc_target_country, 'ES'); ?>>Spain</option>
					<option value="LK" <?php selected($xfgmc_target_country, 'LK'); ?>>Sri Lanka</option>
					<option value="SD" <?php selected($xfgmc_target_country, 'SD'); ?>>Sudan</option>
					<option value="SR" <?php selected($xfgmc_target_country, 'SR'); ?>>Suriname</option>
					<option value="SJ" <?php selected($xfgmc_target_country, 'SJ'); ?>>Svalbard and Jan Mayen</option>
					<option value="SZ" <?php selected($xfgmc_target_country, 'SZ'); ?>>Swaziland</option>
					<option value="SE" <?php selected($xfgmc_target_country, 'SE'); ?>>Sweden</option>
					<option value="CH" <?php selected($xfgmc_target_country, 'CH'); ?>>Switzerland</option>
					<option value="SY" <?php selected($xfgmc_target_country, 'SY'); ?>>Syria</option>
					<option value="TW" <?php selected($xfgmc_target_country, 'TW'); ?>>Taiwan</option>
					<option value="TJ" <?php selected($xfgmc_target_country, 'TJ'); ?>>Tajikistan</option>
					<option value="TZ" <?php selected($xfgmc_target_country, 'TZ'); ?>>Tanzania</option>
					<option value="TH" <?php selected($xfgmc_target_country, 'TH'); ?>>Thailand</option>
					<option value="TG" <?php selected($xfgmc_target_country, 'TG'); ?>>Togo</option>
					<option value="TK" <?php selected($xfgmc_target_country, 'TK'); ?>>Tokelau</option>
					<option value="TO" <?php selected($xfgmc_target_country, 'TO'); ?>>Tonga</option>
					<option value="TT" <?php selected($xfgmc_target_country, 'TT'); ?>>Trinidad and Tobago</option>
					<option value="TN" <?php selected($xfgmc_target_country, 'TN'); ?>>Tunisia</option>
					<option value="TR" <?php selected($xfgmc_target_country, 'TR'); ?>>Turkey</option>
					<option value="TM" <?php selected($xfgmc_target_country, 'TM'); ?>>Turkmenistan</option>
					<option value="TC" <?php selected($xfgmc_target_country, 'TC'); ?>>Turks and Caicos Islands</option>
					<option value="TV" <?php selected($xfgmc_target_country, 'TV'); ?>>Tuvalu</option>
					<option value="UM" <?php selected($xfgmc_target_country, 'UM'); ?>>U.S. Minor Outlying Islands</option>
					<option value="VI" <?php selected($xfgmc_target_country, 'VI'); ?>>U.S. Virgin Islands</option>
					<option value="UG" <?php selected($xfgmc_target_country, 'UG'); ?>>Uganda</option>
					<option value="AE" <?php selected($xfgmc_target_country, 'AE'); ?>>United Arab Emirates</option>
					<option value="UY" <?php selected($xfgmc_target_country, 'UY'); ?>>Uruguay</option>
					<option value="UZ" <?php selected($xfgmc_target_country, 'UZ'); ?>>Uzbekistan</option>
					<option value="VU" <?php selected($xfgmc_target_country, 'VU'); ?>>Vanuatu</option>
					<option value="VA" <?php selected($xfgmc_target_country, 'VA'); ?>>Vatican City</option>
					<option value="VE" <?php selected($xfgmc_target_country, 'VE'); ?>>Venezuela</option>
					<option value="VN" <?php selected($xfgmc_target_country, 'VN'); ?>>Vietnam</option>
					<option value="WF" <?php selected($xfgmc_target_country, 'WF'); ?>>Wallis and Futuna</option>
					<option value="EH" <?php selected($xfgmc_target_country, 'EH'); ?>>Western Sahara</option>
					<option value="YE" <?php selected($xfgmc_target_country, 'YE'); ?>>Yemen</option>
					<option value="ZM" <?php selected($xfgmc_target_country, 'ZM'); ?>>Zambia</option>
					<option value="ZW" <?php selected($xfgmc_target_country, 'ZW'); ?>>Zimbabwe</option>				
				</select><br />
				<span class="description"><?php _e('Select your target country', 'xfgmc'); ?></span>
			</td>
		 </tr>
		 <?php do_action('xfgmc_before_default_currency', $numFeed); ?>
		 <tr>
			<th scope="row"><label for="xfgmc_default_currency"><?php _e('Store currency', 'xfgmc'); ?></label><br />(<?php _e('Uppercase letter', 'xfgmc'); ?>!)</th>
			<td class="overalldesc">
				<input type="text" placeholder="USD" name="xfgmc_default_currency" id="xfgmc_default_currency" value="<?php echo $xfgmc_default_currency; ?>" /><br />
				<span class="description"><?php _e('For example', 'xfgmc'); ?>: <strong>USD</strong>. <a href="//support.google.com/merchants/answer/160637" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a></span>
			</td>
		 </tr>
		 <?php if (class_exists('WOOCS')) : 		 
			global $WOOCS; $currencies_arr = $WOOCS->get_currencies(); 
		 	if (is_array($currencies_arr)) : $array_keys = array_keys($currencies_arr); ?>
			<tr>
				<th scope="row"><label for="xfgmc_wooc_currencies"><?php _e('Feed currency', 'xfgmc'); ?></label></th>
				<td class="overalldesc">
					<select name="xfgmc_wooc_currencies" id="xfgmc_wooc_currencies">
					 <?php for ($i = 0; $i < count($array_keys); $i++) : ?>
						<option value="<?php echo $currencies_arr[$array_keys[$i]]['name']; ?>" <?php selected($xfgmc_wooc_currencies, $currencies_arr[$array_keys[$i]]['name']); ?>><?php echo $currencies_arr[$array_keys[$i]]['name']; ?></option>					
					 <?php endfor; ?>
					</select><br />
					<span class="description"><?php _e('You have plugin installed', 'xfgmc'); ?> <strong class="xfgmc_bold">WooCommerce Currency Switcher by PluginUs.NET. Woo Multi Currency and Woo Multi Pay</strong><br />
					<?php _e('Indicate in what currency the prices should be', 'xfgmc'); ?>.<br /><strong class="xfgmc_bold"><?php _e('Please note', 'xfgmc'); ?>:</strong> <?php _e('The currency must match the one you specified in the field above', 'xfgmc'); ?>
					</span>
				</td>
			</tr>
			<?php endif; ?>
		 <?php endif; ?>		 
		 <tr>
			<th scope="row"><label for="xfgmc_main_product"><?php _e('What kind of products do you sell', 'xfgmc'); ?>?</label></th>
			<td class="overalldesc">
					<select name="xfgmc_main_product" id="xfgmc_main_product">	
					<option value="electronics" <?php selected($xfgmc_main_product, 'electronics'); ?>><?php _e('Electronics', 'xfgmc'); ?></option>
					<option value="computer" <?php selected($xfgmc_main_product, 'computer'); ?>><?php _e('Computer techologies', 'xfgmc'); ?></option>
					<option value="clothes_and_shoes" <?php selected($xfgmc_main_product, 'clothes_and_shoes'); ?>><?php _e('Clothes and shoes', 'xfgmc'); ?></option>
					<option value="auto_parts" <?php selected($xfgmc_main_product, 'auto_parts'); ?>><?php _e('Auto parts', 'xfgmc'); ?></option>
					<option value="products_for_children" <?php selected($xfgmc_main_product, 'products_for_children'); ?>><?php _e('Products for children', 'xfgmc'); ?></option>
					<option value="sporting_goods" <?php selected($xfgmc_main_product, 'sporting_goods'); ?>><?php _e('Sporting goods', 'xfgmc'); ?></option>
					<option value="goods_for_pets" <?php selected($xfgmc_main_product, 'goods_for_pets'); ?>><?php _e('Goods for pets', 'xfgmc'); ?></option>
					<option value="sexshop" <?php selected($xfgmc_main_product, 'sexshop'); ?>><?php _e('Sex shop (Adult products)', 'xfgmc'); ?></option>
					<option value="books" <?php selected($xfgmc_main_product, 'books'); ?>><?php _e('Books', 'xfgmc'); ?></option>
					<option value="health" <?php selected($xfgmc_main_product, 'health'); ?>><?php _e('Health products', 'xfgmc'); ?></option>	
					<option value="food" <?php selected($xfgmc_main_product, 'food'); ?>><?php _e('Food', 'xfgmc'); ?></option>
					<option value="construction_materials" <?php selected($xfgmc_main_product, 'construction_materials'); ?>><?php _e('Construction Materials', 'xfgmc'); ?></option>
					<option value="other" <?php selected($xfgmc_main_product, 'other'); ?>><?php _e('Other', 'xfgmc'); ?></option>					
				</select><br />
				<span class="description"><?php _e('Specify the main category', 'xfgmc'); ?></span>
			</td>
		 </tr>		 
		 <tr class="xfgmc_tr">
			<th scope="row"><label for="xfgmc_step_export"><?php _e('Step of export', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_step_export" id="xfgmc_step_export">
				<?php do_action('xfgmc_before_step_export_option', $numFeed); ?>
				<option value="80" <?php selected($xfgmc_step_export, '80'); ?>>80</option>
				<option value="200" <?php selected($xfgmc_step_export, '200'); ?>>200</option>
				<option value="300" <?php selected($xfgmc_step_export, '300'); ?>>300</option>
				<option value="450" <?php selected($xfgmc_step_export, '450'); ?>>450</option>
				<option value="500" <?php selected($xfgmc_step_export, '500'); ?>>500</option>
				<option value="800" <?php selected($xfgmc_step_export, '800'); ?>>800</option>
				<option value="1000" <?php selected($xfgmc_step_export, '1000'); ?>>1000</option>
				<?php do_action('xfgmc_after_step_export_option', $numFeed); ?>
				</select><br />
				<span class="description"><?php _e('The value affects the speed of file creation', 'xfgmc'); ?>. <?php _e('If you have any problems with the generation of the file - try to reduce the value in this field', 'xfgmc'); ?>. <?php _e('More than 500 can only be installed on powerful servers', 'xfgmc'); ?>.</span>
			</td>
		 </tr>
		 <tr class="xfgmc_tr">
			<th scope="row"><label for="xfgmc_behavior_onbackorder"><?php _e('For pre-order products, establish availability equal to', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_behavior_onbackorder" id="xfgmc_behavior_onbackorder">
					<!-- option value="preorder" <?php selected($xfgmc_behavior_onbackorder, 'preorder')?> >preorder</option -->
					<option value="in_stock" <?php selected($xfgmc_behavior_onbackorder, 'in_stock'); ?>>in_stock</option>
					<option value="out_of_stock" <?php selected($xfgmc_behavior_onbackorder, 'out_of_stock')?> >out_of_stock</option>
				</select><br />
				<span class="description"><?php _e('For pre-order products, establish availability equal to', 'xfgmc'); ?> in_stock/out_of_stock</span>
			</td>
		 </tr>
		 <tr class="xfgmc_tr">
			<th scope="row"><label for="xfgmc_skip_missing_products"><?php _e('Skip missing products', 'xfgmc'); ?> (<?php _e('except for products for which a pre-order is permitted', 'xfgmc'); ?>.)</label></th>
			<td class="overalldesc">
				<input type="checkbox" name="xfgmc_skip_missing_products" id="xfgmc_skip_missing_products" <?php checked($xfgmc_skip_missing_products, 'on' ); ?>/>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_skip_backorders_products"><?php _e('Skip backorders products', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<input type="checkbox" name="xfgmc_skip_backorders_products" id="xfgmc_skip_backorders_products" <?php checked($xfgmc_skip_backorders_products, 'on' ); ?>/>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_one_variable"><?php _e('Upload only the first variation', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<input type="checkbox" name="xfgmc_one_variable" id="xfgmc_one_variable" <?php checked($xfgmc_one_variable, 'on' ); ?>/>
			</td>
		 </tr>		 
		 <?php do_action('xfgmc_append_main_param_table', $numFeed); ?>		 
		</tbody></table>
	   </div>
	 </div>
	 <?php do_action('xfgmc_after_main_param_block', $numFeed); ?>

	 <div class="postbox">
	   <h2 class="hndle"><?php _e('Shipping', 'xfgmc'); ?></h2>		 
	   <div class="inside">	
	    <p><i><?php _e('Google recommend that you set up shipping costs through Merchant Center settings instead of submitting the shipping attribute in the feed', 'xfgmc'); ?>. <a href="//support.google.com/merchants/answer/6069284" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a></i></p>
		<p><i><?php _e('To add this element to your feed make sure the fields are filled', 'xfgmc'); ?> "country" <?php _e('and', 'xfgmc'); ?> "<?php _e('Delivery area', 'xfgmc'); ?>". <a href="//support.google.com/merchants/answer/6324484" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a></i></p>
		<table class="form-table"><tbody>
		 <tr>
			<th scope="row"><label for="xfgmc_def_shipping_country"><?php _e('Attribute', 'xfgmc'); ?> country</label></th>
			<td class="overalldesc">
			 <input type="text" name="xfgmc_def_shipping_country" id="xfgmc_def_shipping_country" value="<?php echo $xfgmc_def_shipping_country; ?>" /><br />
			 <span class="description"><?php _e('Required attribute', 'xfgmc'); ?> <strong>shipping_country</strong>. <?php _e('Leave this field blank if you do not want to add a default value', 'xfgmc'); ?>.</span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><?php _e('Delivery area', 'xfgmc'); ?><select name="xfgmc_def_delivery_area_type"><option value="region" <?php selected($xfgmc_def_delivery_area_type, 'region'); ?>>region</option><option value="postal_code" <?php selected($xfgmc_def_delivery_area_type, 'postal_code'); ?>>postal_code</option><option value="location_id" <?php selected($xfgmc_def_delivery_area_type, 'location_id'); ?>>location_id</option><option value="location_group_name" <?php selected($xfgmc_def_delivery_area_type, 'location_group_name'); ?>>location_group_name</option></select></th>		  
			<td class="overalldesc">
				<input type="text" name="xfgmc_def_delivery_area_value" value="<?php echo $xfgmc_def_delivery_area_value; ?>" /><br />
				<span class="description"><?php _e('To specify a delivery area (which is optional), submit 1 of the 4 available options for the shipping attribute', 'xfgmc'); ?>. <a href="//support.google.com/merchants/answer/6324484" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a></span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_def_shipping_service"><?php _e('Attribute', 'xfgmc'); ?> service</label></th>
			<td class="overalldesc">
			 <input type="text" name="xfgmc_def_shipping_service" id="xfgmc_def_shipping_service" value="<?php echo $xfgmc_def_shipping_service; ?>" /><br />
			 <span class="description"><?php _e('Optional attribute', 'xfgmc'); ?> <strong>service</strong>. <?php _e('Leave this field blank if you do not want to add a default value', 'xfgmc'); ?>.</span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_def_shipping_price"><?php _e('Attribute', 'xfgmc'); ?> price</label></th>
			<td class="overalldesc">
			 <input type="text" name="xfgmc_def_shipping_price" id="xfgmc_def_shipping_price" value="<?php echo $xfgmc_def_shipping_price; ?>" /><br />
			 <span class="description"><?php _e('Optional attribute', 'xfgmc'); ?> <strong>price</strong>. <?php _e('Leave this field blank if you do not want to add a default value', 'xfgmc'); ?>.</span>
			</td>
		 </tr>		 		 		 		 		 		  
	 	<?php /* do_action('xfgmc_append_optional_elemet_table', $numFeed); */ ?>	 
		</tbody></table> 		
	   </div>
	 </div>

	 <div class="postbox">
	   <h2 class="hndle"><?php _e('Other elements', 'xfgmc'); ?></h2>		 
	   <div class="inside">	
		<table class="form-table"><tbody>
		 <tr>
			<th scope="row"><label for="xfgmc_tax_info"><?php _e('Tax info', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_tax_info" id="xfgmc_tax_info">
					<option value="disabled" <?php selected($xfgmc_tax_info, 'disabled'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
					<option value="enabled" <?php selected($xfgmc_tax_info, 'enabled'); ?>><?php _e('Enabled', 'xfgmc'); ?></option>					
				</select><br />
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>tax_category</strong>. <?php _e('The value is indicated on the product edit page or category edit page', 'xfgmc'); ?></span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_def_shipping_label"><?php _e('Definition', 'xfgmc'); ?> shipping_label (<?php _e('Default value', 'xfgmc'); ?>)</label></th>
			<td class="overalldesc">
			 <input type="text" name="xfgmc_def_shipping_label" id="xfgmc_def_shipping_label" value="<?php echo $xfgmc_def_shipping_label; ?>" /><br />
			 <span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>shipping_label</strong>. <?php _e('Leave this field blank if you do not want to add a default value', 'xfgmc'); ?>.</span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_def_min_handling_time"><?php _e('Definition', 'xfgmc'); ?> min_handling_time (<?php _e('Default value', 'xfgmc'); ?>)</label></th>
			<td class="overalldesc">
			 <input type="text" name="xfgmc_def_min_handling_time" id="xfgmc_def_min_handling_time" value="<?php echo $xfgmc_def_min_handling_time; ?>" /><br />
			 <span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>min_handling_time</strong>. <?php _e('Leave this field blank if you do not want to add a default value', 'xfgmc'); ?>.</span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_def_max_handling_time"><?php _e('Definition', 'xfgmc'); ?> max_handling_time (<?php _e('Default value', 'xfgmc'); ?>)</label></th>
			<td class="overalldesc">
			 <input type="text" name="xfgmc_def_max_handling_time" id="xfgmc_def_max_handling_time" value="<?php echo $xfgmc_def_max_handling_time; ?>" /><br />
			 <span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>max_handling_time</strong>. <?php _e('Leave this field blank if you do not want to add a default value', 'xfgmc'); ?>.</span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_product_type"><?php _e('Product type', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_product_type" id="xfgmc_product_type">
					<option value="disabled" <?php selected($xfgmc_product_type, 'disabled'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
					<option value="enabled" <?php selected($xfgmc_product_type, 'enabled'); ?>><?php _e('Enabled', 'xfgmc'); ?></option>					
				</select><br />
				<span class="description"><?php _e('Add root element', 'xfgmc'); ?>:</span><br />
				<input type="text" name="xfgmc_product_type_home" id="xfgmc_product_type_home" placeholder="<?php _e('Home', 'xfgmc'); ?>" value="<?php echo $xfgmc_product_type_home; ?>"/><br />
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>product_type</strong>.</span>
			</td>
		 </tr>		
		 <tr>
			<th scope="row"><label for="xfgmc_sale_price"><?php _e('Sale price', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_sale_price" id="xfgmc_sale_price">
					<option value="no" <?php selected($xfgmc_sale_price, 'no'); ?>><?php _e('No', 'xfgmc'); ?></option>
					<option value="yes" <?php selected($xfgmc_sale_price, 'yes'); ?>><?php _e('Yes', 'xfgmc'); ?></option>					
				</select><br />
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>sale_price</strong>.<br />
				<?php _e('In sale_price indicates the new price of the products, which must necessarily be lower than the old price', 'xfgmc'); ?>.</span>
			</td>
		 </tr>
		 <?php do_action('xfgmc_after_sale_price', $numFeed); ?>		
		 <tr>
			<th scope="row"><label for="xfgmc_gtin"><?php _e('GTIN', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_gtin" id="xfgmc_gtin">
				<option value="disabled" <?php selected($xfgmc_gtin, 'disabled'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
				<option value="sku" <?php selected($xfgmc_gtin, 'sku'); ?>><?php _e('Substitute from SKU', 'xfgmc'); ?></option>
				<option value="post_meta" <?php selected($xfgmc_gtin, 'post_meta'); ?>><?php _e('Substitute from post meta', 'xfgmc'); ?></option>
				<?php if (class_exists('WooCommerce_Germanized')) : ?>
				<option value="germanized" <?php selected($xfgmc_gtin, 'germanized'); ?>><?php _e('Substitute from', 'xfgmc'); ?> WooCommerce Germanized</option>
				<?php endif; ?>				
				<?php foreach (xfgmc_get_attributes() as $attribute) : ?>	
				<option value="<?php echo $attribute['id']; ?>" <?php selected($xfgmc_gtin, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option><?php endforeach; ?>
				</select><br />
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>gtin</strong></span><br />
				<span class="description"><?php _e('If selected', 'xfgmc'); ?> <span class="xfgmc_bold">"<?php _e('Substitute from post meta', 'xfgmc'); ?>"</span> <?php _e('do not forget to fill out this field', 'xfgmc'); ?>:</span><br />
				<input placeholder="<?php _e('Name post_meta', 'xfgmc'); ?>" type="text" name="xfgmc_gtin_post_meta" id="xfgmc_gtin_post_meta" value="<?php echo $xfgmc_gtin_post_meta; ?>" />
			</td>
		 </tr>	
		 <tr>
			<th scope="row"><label for="xfgmc_mpn"><?php _e('MPN', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_mpn" id="xfgmc_mpn">		 
				<option value="disabled" <?php selected($xfgmc_mpn, 'disabled'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
				<option value="sku" <?php selected($xfgmc_mpn, 'sku'); ?>><?php _e('Substitute from SKU', 'xfgmc'); ?></option>
				<option value="post_meta" <?php selected($xfgmc_mpn, 'post_meta'); ?>><?php _e('Substitute from post meta', 'xfgmc'); ?></option>
				<?php if (class_exists('WooCommerce_Germanized')) : ?>
				<option value="germanized" <?php selected($xfgmc_mpn, 'germanized'); ?>><?php _e('Substitute from', 'xfgmc'); ?> WooCommerce Germanized</option>
				<?php endif; ?>
				<?php foreach (xfgmc_get_attributes() as $attribute) : ?>	
				<option value="<?php echo $attribute['id']; ?>" <?php selected($xfgmc_mpn, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option><?php endforeach; ?>
				</select><br />
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>mpn</strong></span><br />
				<span class="description"><?php _e('If selected', 'xfgmc'); ?> <span class="xfgmc_bold">"<?php _e('Substitute from post meta', 'xfgmc'); ?>"</span> <?php _e('do not forget to fill out this field', 'xfgmc'); ?>:</span><br />
				<input placeholder="<?php _e('Name post_meta', 'xfgmc'); ?>" type="text" name="xfgmc_mpn_post_meta" id="xfgmc_mpn_post_meta" value="<?php echo $xfgmc_mpn_post_meta; ?>" />
			</td>
		 </tr>			 
		 <tr>
			<th scope="row"><label for="xfgmc_age"><?php _e('Age', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_age" id="xfgmc_age">		 
				<option value="disabled" <?php selected($xfgmc_age, 'disabled'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
				<option value="post_meta" <?php selected($xfgmc_age, 'post_meta'); ?>><?php _e('Substitute from post meta', 'xfgmc'); ?></option>
				<option value="default_value" <?php selected($xfgmc_age, 'default_value'); ?>><?php _e('Default value from field  below', 'xfgmc'); ?></option>
				<?php foreach (xfgmc_get_attributes() as $attribute) : ?>	
				<option value="<?php echo $attribute['id']; ?>" <?php selected($xfgmc_age, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option><?php endforeach; ?>
				</select><br />
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>age_group</strong></span><br />
				<span class="description"><?php _e('If selected', 'xfgmc'); ?> <span class="xfgmc_bold">"<?php _e('Substitute from post meta', 'xfgmc'); ?>"</span> <?php _e('or', 'xfgmc'); ?> <span class="xfgmc_bold">"<?php _e('Default value from field  below', 'xfgmc'); ?>"</span> <?php _e('do not forget to fill out this field', 'xfgmc'); ?>:</span><br />
				<input placeholder="<?php _e('Name post_meta', 'xfgmc'); ?>/<?php _e('Default value', 'xfgmc'); ?>" type="text" name="xfgmc_age_group_post_meta" id="xfgmc_age_group_post_meta" value="<?php echo $xfgmc_age_group_post_meta; ?>" />			
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_brand"><?php _e('Brand', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_brand" id="xfgmc_brand">		 
				<option value="off" <?php selected($xfgmc_brand, 'off' ); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
				<option value="post_meta" <?php selected($xfgmc_brand, 'post_meta'); ?>><?php _e('Substitute from post meta', 'xfgmc'); ?></option>
				<option value="default_value" <?php selected($xfgmc_brand, 'default_value'); ?>><?php _e('Default value from field  below', 'xfgmc'); ?></option>
				<?php if (is_plugin_active('perfect-woocommerce-brands/main.php')) : ?>
				<option value="sfpwb" <?php selected($xfgmc_brand, 'sfpwb'); ?>><?php _e('Substitute from', 'xfgmc'); ?> Perfect Woocommerce Brands</option>
				<?php endif; ?>
				<?php if (is_plugin_active('premmerce-woocommerce-brands/premmerce-brands.php')) : ?>
				<option value="premmercebrandsplugin" <?php selected($xfgmc_brand, 'premmercebrandsplugin'); ?>><?php _e('Substitute from', 'xfgmc'); ?> Premmerce Brands for WooCommerce</option>
				<?php endif; ?>					
				<?php foreach (xfgmc_get_attributes() as $attribute) : ?>	
				<option value="<?php echo $attribute['id']; ?>" <?php selected($xfgmc_brand, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option>	
				<?php endforeach; ?>
				</select><br />
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>brand</strong></span><br />
				<span class="description"><?php _e('If selected', 'xfgmc'); ?> <span class="xfgmc_bold">"<?php _e('Substitute from post meta', 'xfgmc'); ?>"</span> <?php _e('or', 'xfgmc'); ?> <span class="xfgmc_bold">"<?php _e('Default value from field  below', 'xfgmc'); ?>"</span> <?php _e('do not forget to fill out this field', 'xfgmc'); ?>:</span><br />
				<input placeholder="<?php _e('Name post_meta', 'xfgmc'); ?>/<?php _e('Default value', 'xfgmc'); ?>" type="text" name="xfgmc_brand_post_meta" id="xfgmc_brand_post_meta" value="<?php echo $xfgmc_brand_post_meta; ?>" />
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_color"><?php _e('Color', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_color" id="xfgmc_color">
				<option value="off" <?php selected($xfgmc_color, 'off'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
				<?php foreach (xfgmc_get_attributes() as $attribute) : ?>	
				<option value="<?php echo $attribute['id']; ?>" <?php selected($xfgmc_color, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option><?php endforeach; ?>
				</select><br />
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>color</strong></span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_material"><?php _e('Material', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_material" id="xfgmc_material">
				<option value="off" <?php selected($xfgmc_material, 'off'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
				<?php foreach (xfgmc_get_attributes() as $attribute) : ?>	
				<option value="<?php echo $attribute['id']; ?>" <?php selected($xfgmc_material, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option><?php endforeach; ?>
				</select><br />
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>material</strong></span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_pattern"><?php _e('Pattern', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_pattern" id="xfgmc_pattern">
				<option value="off" <?php selected($xfgmc_pattern, 'off'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
				<?php foreach (xfgmc_get_attributes() as $attribute) : ?>	
				<option value="<?php echo $attribute['id']; ?>" <?php selected($xfgmc_pattern, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option><?php endforeach; ?>
				</select><br />
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>pattern</strong></span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_gender"><?php _e('Gender', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_gender" id="xfgmc_gender">
				<option value="off" <?php selected($xfgmc_gender, 'off'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
				<?php foreach (xfgmc_get_attributes() as $attribute) : ?>	
				<option value="<?php echo $attribute['id']; ?>" <?php selected($xfgmc_gender, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option><?php endforeach; ?>
				</select><br />
				<?php _e('In the absence of a substitute', 'xfgmc'); ?>:<br />
				<select name="xfgmc_gender_alt">
					<option value="off" <?php selected($xfgmc_gender_alt, 'off'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
					<option value="male" <?php selected($xfgmc_gender_alt, 'male'); ?>>Male</option>
					<option value="female" <?php selected($xfgmc_gender_alt, 'female'); ?>>Female</option>
					<option value="unisex" <?php selected($xfgmc_gender_alt, 'unisex'); ?>>Unisex</option>				
				</select><br />				
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>gender</strong></span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_size"><?php _e('Size', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_size" id="xfgmc_size">
				<option value="off" <?php selected($xfgmc_size, 'off'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
				<?php foreach (xfgmc_get_attributes() as $attribute) : ?>	
				<option value="<?php echo $attribute['id']; ?>" <?php selected($xfgmc_size, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option><?php endforeach; ?>
				</select><br />
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>size</strong></span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_size_type"><?php _e('Size type', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_size_type" id="xfgmc_size_type">
				<option value="off" <?php selected($xfgmc_size_type, 'off'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>			
				<?php foreach (xfgmc_get_attributes() as $attribute) : ?>	
				<option value="<?php echo $attribute['id']; ?>" <?php selected($xfgmc_size_type, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option><?php endforeach; ?>
				</select><br />				
				<?php _e('In the absence of a substitute', 'xfgmc'); ?>:<br />
				<select name="xfgmc_size_type_alt">
					<option value="off" <?php selected($xfgmc_size_type_alt, 'off'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
					<option value="regular" <?php selected($xfgmc_size_type_alt, 'regular'); ?>>Regular</option>	
					<option value="petite" <?php selected($xfgmc_size_type_alt, 'petite'); ?>>Petite</option>	
					<option value="plus" <?php selected($xfgmc_size_type_alt, 'plus'); ?>>Plus</option>	
					<option value="bigandtall" <?php selected($xfgmc_size_type_alt, 'bigandtall'); ?>>Big and tall</option>	
					<option value="maternity" <?php selected($xfgmc_size_type_alt, 'maternity'); ?>>Maternity</option>			
				</select><br />
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>size_type</strong></span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_size_system"><?php _e('Size system', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<select name="xfgmc_size_system" id="xfgmc_size_system">
				<option value="off" <?php selected($xfgmc_size_type, 'off'); ?>><?php _e('Disabled', 'xfgmc'); ?></option>
				<?php foreach (xfgmc_get_attributes() as $attribute) : ?>	
				<option value="<?php echo $attribute['id']; ?>" <?php selected($xfgmc_size_system, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option><?php endforeach; ?>
				</select><br />				
				<?php _e('In the absence of a substitute', 'xfgmc'); ?>:<br />
				<select name="xfgmc_size_system_alt">
					<option value="off" <?php selected($xfgmc_size_type, 'off'); ?>><?php _e('None', 'xfgmc'); ?></option>
					<option value="AU" <?php selected($xfgmc_size_system_alt, 'AU'); ?>>AU</option>
					<option value="BR" <?php selected($xfgmc_size_system_alt, 'BR'); ?>>BR</option>
					<option value="CN" <?php selected($xfgmc_size_system_alt, 'CN'); ?>>CN</option>
					<option value="DE" <?php selected($xfgmc_size_system_alt, 'DE'); ?>>DE</option>
					<option value="EU" <?php selected($xfgmc_size_system_alt, 'EU'); ?>>EU</option>
					<option value="FR" <?php selected($xfgmc_size_system_alt, 'FR'); ?>>FR</option>
					<option value="IT" <?php selected($xfgmc_size_system_alt, 'IT'); ?>>IT</option>
					<option value="JP" <?php selected($xfgmc_size_system_alt, 'JP'); ?>>JP</option>
					<option value="MEX" <?php selected($xfgmc_size_system_alt, 'MEX'); ?>>MEX</option>
					<option value="UK" <?php selected($xfgmc_size_system_alt, 'UK'); ?>>UK</option>
					<option value="US" <?php selected($xfgmc_size_system_alt, 'US'); ?>>US</option>
				</select><br />
				<span class="description"><?php _e('Optional element', 'xfgmc'); ?> <strong>size_system</strong></span>
			</td>
		 </tr>
	 	<?php do_action('xfgmc_append_optional_elemet_table', $numFeed); ?>	 
		</tbody></table> 		
	   </div>
	 </div>
	 <?php do_action('xfgmc_after_optional_elemet_block', $numFeed); ?>
	 <div class="postbox">
	  <div class="inside">
		<table class="form-table"><tbody>
		 <tr>
			<th scope="row"><label for="button-primary"></label></th>
			<td class="overalldesc"><?php wp_nonce_field('xfgmc_nonce_action', 'xfgmc_nonce_field'); ?><input id="button-primary" class="button-primary" type="submit" name="xfgmc_submit_action" value="<?php _e('Save', 'xfgmc'); ?>"/><br />
			<span class="description"><?php _e('Click to save the settings', 'xfgmc'); ?></span></td>
		 </tr>
		</tbody></table>
	  </div>
	 </div>
	 <?php do_action('xfgmc_append_form_container_2', $numFeed); ?>
	</form>

	<div class="postbox">
	  <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
	  <h2 class="hndle"><?php _e('Add Google Product Categories', 'xfgmc'); ?> <?php _e('to product cards', 'xfgmc'); ?></h2>
	   <div class="inside">
		<p><i><strong><?php _e('Important advice', 'xfgmc'); ?>:</strong></i> <i><?php _e('There is a faster way to match categories. Go to "Products" - "Categories" - "Edit Category" and edit the field', 'xfgmc'); ?> "<?php _e('Google product category', 'xfgmc'); ?>"</i>.</p>
		<table class="form-table"><tbody>		
		 <tr>
			<th scope="row"><label for="xfgmc_newcat_id_arr"><?php _e('Select categories', 'xfgmc'); ?></label></th>
			<td class="overalldesc">				
			 <select id="xfgmc_newcat_id_arr" style="width: 100%;" name="xfgmc_newcat_id_arr[]" size="8" multiple>
			<?php 	
			 foreach (get_terms('product_cat', array('hide_empty'=>0, 'parent'=>0)) as $term) {
				 echo xfgmc_cat_tree($term->taxonomy, $term->term_id, $xfgmc_newcat_id_arr);		 
			 } ?>
			 </select><br />
			 <span class="description"><?php _e('Select categories for which you want to change', 'xfgmc'); ?> <strong>google_product_category</strong>.</span>
			</td>
		 </tr>		
		 <tr>
			<th scope="row"><label for="xfgmc_newcat_id"><?php _e('Google product category', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<input type="text" name="xfgmc_newcat_id" id="xfgmc_newcat_id" value="<?php echo $xfgmc_newcat_id; ?>" /><br />
				<span class="description"><?php _e('This', 'xfgmc'); ?> <strong>google_product_category</strong> <?php _e('will be added to all products in the categories above', 'xfgmc'); ?>. <a href="//support.google.com/merchants/answer/6324436" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a></span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"></th>
			<td class="overalldesc">
			<?php wp_nonce_field('xfgmc_nonce_action_newcat_id', 'xfgmc_nonce_field_newcat_id'); ?><input class="button" type="submit" name="xfgmc_submit_newcat_id" value="<?php _e('Add new category', 'xfgmc'); ?>" />	 
			</td>
		 </tr>
		</tbody></table>
	   </div></form>
	 </div>	
	<?php do_action('xfgmc_append_container_2', $numFeed); ?>
  </div></div>
 </div><!-- /post-body --><br class="clear"></div><!-- /poststuff -->
 <?php do_action('xfgmc_after_poststuff', $numFeed); ?>

 <div id="icp_slides" class="clear">
  <div class="icp_wrap">
	<input type="radio" name="icp_slides" id="icp_point1">
	<input type="radio" name="icp_slides" id="icp_point2">
	<input type="radio" name="icp_slides" id="icp_point3" checked>
	<input type="radio" name="icp_slides" id="icp_point4">
	<input type="radio" name="icp_slides" id="icp_point5">
	<input type="radio" name="icp_slides" id="icp_point6">
	<div class="icp_slider">
		<div class="icp_slides icp_img1"><a href="//wordpress.org/plugins/yml-for-yandex-market/" target="_blank"></a></div>
		<div class="icp_slides icp_img2"><a href="//wordpress.org/plugins/import-products-to-ok-ru/" target="_blank"></a></div>
		<div class="icp_slides icp_img3"><a href="//wordpress.org/plugins/xml-for-google-merchant-center/" target="_blank"></a></div>
		<div class="icp_slides icp_img4"><a href="//wordpress.org/plugins/gift-upon-purchase-for-woocommerce/" target="_blank"></a></div>
		<div class="icp_slides icp_img5"><a href="//wordpress.org/plugins/xml-for-avito/" target="_blank"></a></div>
		<div class="icp_slides icp_img6"><a href="//wordpress.org/plugins/xml-for-o-yandex/" target="_blank"></a></div>
	</div>
	<div class="icp_control">
		<label for="icp_point1"></label>
		<label for="icp_point2"></label>
		<label for="icp_point3"></label>
		<label for="icp_point4"></label>
		<label for="icp_point5"></label>
		<label for="icp_point6"></label>
	</div>
  </div> 
 </div>
 <?php do_action('xfgmc_after_icp_slides', $numFeed); ?>

 <div class="metabox-holder">
  <div class="postbox">
  	<h2 class="hndle"><?php _e('My plugins that may interest you', 'xfgmc'); ?></h2>
	<div class="inside">
		<p><span class="xfgmc_bold">XML for Google Merchant Center</span> - <?php _e('Сreates a XML-feed to upload to Google Merchant Center', 'xfgmc'); ?>. <a href="https://wordpress.org/plugins/xml-for-google-merchant-center/" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a>.</p> 
		<p><span class="xfgmc_bold">YML for Yandex Market</span> - <?php _e('Сreates a YML-feed for importing your products to Yandex Market', 'xfgmc'); ?>. <a href="https://wordpress.org/plugins/yml-for-yandex-market/" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a>.</p>
		<p><span class="xfgmc_bold">XML for Hotline</span> - <?php _e('Сreates a XML-feed for importing your products to Hotline', 'xfgmc'); ?>. <a href="https://wordpress.org/plugins/xml-for-hotline/" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a>.</p>
		<p><span class="xfgmc_bold">Gift upon purchase for WooCommerce</span> - <?php _e('This plugin will add a marketing tool that will allow you to give gifts to the buyer upon purchase', 'xfgmc'); ?>. <a href="https://wordpress.org/plugins/gift-upon-purchase-for-woocommerce/" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a>.</p>
		<p><span class="xfgmc_bold">Import products to ok.ru</span> - <?php _e('With this plugin, you can import products to your group on ok.ru', 'xfgmc'); ?>. <a href="https://wordpress.org/plugins/import-products-to-ok-ru/" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a>.</p>
		<p><span class="xfgmc_bold">XML for Avito</span> - <?php _e('Сreates a XML-feed for importing your products to', 'xfgmc'); ?> Avito. <a href="https://wordpress.org/plugins/xml-for-avito/" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a>.</p>
		<p><span class="xfgmc_bold">XML for O.Yandex (Яндекс Объявления)</span> - <?php _e('Сreates a XML-feed for importing your products to', 'xfgmc'); ?> Яндекс.Объявления. <a href="https://wordpress.org/plugins/xml-for-o-yandex/" target="_blank"><?php _e('Read more', 'xfgmc'); ?></a>.</p>
	</div>
  </div>
 </div>
 <?php do_action('xfgmc_append_wrap', $numFeed); ?>
</div><!-- /wrap -->
<?php
} /* end функция настроек xfgmc_export_page */ ?>
<?php if (!defined('ABSPATH')) {exit;}
/*
* @since 1.0.0
*
* @return nothing
* Получает все атрибуты вукомерца 
*/
function xfgmc_get_attributes() {
 $result = array();
 $attribute_taxonomies = wc_get_attribute_taxonomies();
 if (count($attribute_taxonomies) > 0) {
	$i = 0;
	foreach($attribute_taxonomies as $one_tax ) {
		/**
		* $one_tax->attribute_id => 6
		* $one_tax->attribute_name] => слаг (на инглише или русском)
		* $one_tax->attribute_label] => Еще один атрибут (это как раз название)
		* $one_tax->attribute_type] => select 
		* $one_tax->attribute_orderby] => menu_order
		* $one_tax->attribute_public] => 0			
		*/
		$result[$i]['id'] = $one_tax->attribute_id;
		$result[$i]['name'] = $one_tax->attribute_label;
		$i++;
   }
 }
 return $result;
}
/*
* @since 1.0.0
* Обновлён в 2.0.0
* Записывает или обновляет файл фида.
* Возвращает всегда true
*/
function xfgmc_write_file($result_xml, $cc, $numFeed = '1') {
 /* $cc = 'w+' или 'a'; */
 xfgmc_error_log('FEED № '.$numFeed.'; Стартовала xfgmc_write_file c параметром cc = '.$cc.'; Файл: functions.php; Строка: '.__LINE__, 0);
 $filename = urldecode(xfgmc_optionGET('xfgmc_file_file', $numFeed));
 if ($numFeed === '1') {$prefFeed = '';} else {$prefFeed = $numFeed;}
  
 if ($filename == '') {	
 	$upload_dir = (object)wp_get_upload_dir(); // $upload_dir->basedir
	$filename = $upload_dir->basedir.$prefFeed."feed-xml-0-tmp.xml"; // $upload_dir->path
 }
	   
 // if ((validate_file($filename) === 0)&&(file_exists($filename))) {
 if (file_exists($filename)) {
	// файл есть
	if (!$handle = fopen($filename, $cc)) {
		xfgmc_error_log('FEED № '.$numFeed.'; Не могу открыть файл '.$filename.'; Файл: functions.php; Строка: '.__LINE__, 0);
		xfgmc_error_log('FEED № '.$numFeed.'; Не могу открыть файл '.$filename.'; Файл: functions.php; Строка: '.__LINE__, 0);
	}
	if (fwrite($handle, $result_xml) === FALSE) {
		xfgmc_error_log('FEED № '.$numFeed.'; Не могу произвести запись в файл '.$handle.'; Файл: functions.php; Строка: '.__LINE__, 0);
		xfgmc_error_log('FEED № '.$numFeed.'; Не могу произвести запись в файл '.$handle.'; Файл: functions.php; Строка: '.__LINE__, 0);
	} else {
		xfgmc_error_log('FEED № '.$numFeed.'; Ура! Записали; Файл: Файл: functions.php; Строка: '.__LINE__, 0);
		xfgmc_error_log($filename, 0);
		return true;
	}
	fclose($handle);
 } else {
	xfgmc_error_log('FEED № '.$numFeed.'; Файла $filename = '.$filename.' еще нет. Файл: functions.php; Строка: '.__LINE__, 0);
	// файла еще нет
	// попытаемся создать файл
	if (is_multisite()) {
		$upload = wp_upload_bits($prefFeed.'feed-xml-'.get_current_blog_id().'-tmp.xml', null, $result_xml ); // загружаем shop2_295221-xml в папку загрузок
	} else {
		$upload = wp_upload_bits($prefFeed.'feed-xml-0-tmp.xml', null, $result_xml ); // загружаем shop2_295221-xml в папку загрузок
	}
	/*
	*	для работы с csv или xml требуется в плагине разрешить загрузку таких файлов
	*	$upload['file'] => '/var/www/wordpress/wp-content/uploads/2010/03/feed-xml.xml', // путь
	*	$upload['url'] => 'http://site.ru/wp-content/uploads/2010/03/feed-xml.xml', // урл
	*	$upload['error'] => false, // сюда записывается сообщение об ошибке в случае ошибки
	*/
	// проверим получилась ли запись
	if ($upload['error']) {
		xfgmc_error_log('FEED № '.$numFeed.'; Запись вызвала ошибку: '. $upload['error'].'; Файл: functions.php; Строка: '.__LINE__, 0);
		$err = 'FEED № '.$numFeed.'; Запись вызвала ошибку: '. $upload['error'].'; Файл: functions.php; Строка: '.__LINE__ ;
		xfgmc_errors_log($err);
	} else {
		xfgmc_optionUPD('xfgmc_file_file', urlencode($upload['file']), $numFeed);
		xfgmc_error_log('FEED № '.$numFeed.'; Запись удалась! Путь файла: '. $upload['file'] .'; УРЛ файла: '. $upload['url'], 0);
		return true;
	}		
 }
}
/*
* @since 1.0.0
* Обновлён в 2.0.0
* Перименовывает временный файл фида в основной.
* Возвращает false/true
*/
function xfgmc_rename_file($numFeed = '1') {
 xfgmc_error_log('FEED № '.$numFeed.'; Cтартовала xfgmc_rename_file; Файл: functions.php; Строка: '.__LINE__, 0);	
 if ($numFeed === '1') {$prefFeed = '';} else {$prefFeed = $numFeed;}	
 /* Перименовывает временный файл в основной. Возвращает true/false */
 if (is_multisite()) {
	$upload_dir = (object)wp_get_upload_dir();
	$filenamenew = $upload_dir->basedir."/".$prefFeed."feed-xml-".get_current_blog_id().".xml";
	$filenamenewurl = $upload_dir->baseurl."/".$prefFeed."/feed-xml-".get_current_blog_id().".xml";		
	// $filenamenew = BLOGUPLOADDIR."feed-xml-".get_current_blog_id().".xml";
	// надо придумать как поулчить урл загрузок конкретного блога
 } else {
	$upload_dir = (object)wp_get_upload_dir();
	/*
	*   'path'    => '/home/site.ru/public_html/wp-content/uploads/2016/04',
	*	'url'     => 'http://site.ru/wp-content/uploads/2016/04',
	*	'subdir'  => '/2016/04',
	*	'basedir' => '/home/site.ru/public_html/wp-content/uploads',
	*	'baseurl' => 'http://site.ru/wp-content/uploads',
	*	'error'   => false,
	*/
	$filenamenew = $upload_dir->basedir."/".$prefFeed."feed-xml-0.xml";
	$filenamenewurl = $upload_dir->baseurl."/".$prefFeed."feed-xml-0.xml";
 }
 $filenameold = urldecode(xfgmc_optionGET('xfgmc_file_file', $numFeed));
 xfgmc_error_log('FEED № '.$numFeed.'; $filenameold = '.$filenameold.'; Файл: functions.php; Строка: '.__LINE__, 0);
 xfgmc_error_log('FEED № '.$numFeed.'; $filenamenew = '.$filenamenew.'; Файл: functions.php; Строка: '.__LINE__, 0);
   
 if (rename($filenameold, $filenamenew) === FALSE) {
	xfgmc_error_log('FEED № '.$numFeed.'; Не могу переименовать файл из '.$filenameold.' в '.$filenamenew.'! Файл: functions.php; Строка: '.__LINE__, 0);
	return false;
 } else {
	xfgmc_optionUPD('xfgmc_file_url', urlencode($filenamenewurl), $numFeed);
	xfgmc_error_log('FEED № '.$numFeed.'; Файл переименован! Файл: functions.php; Строка: '.__LINE__, 0);
	return true;
 }
}
/*
* @since 1.0.0
* Возвращает URL без get-параметров или возвращаем только get-параметры
*/
function xfgmc_deleteGET($url, $whot = 'url') {
 $url = str_replace("&amp;", "&", $url); // Заменяем сущности на амперсанд, если требуется
 list($url_part, $get_part) = array_pad(explode("?", $url), 2, ""); // Разбиваем URL на 2 части: до знака ? и после
 if ($whot == 'url') {
	return $url_part; // Возвращаем URL без get-параметров (до знака вопроса)
 } else if ($whot == 'get') {
	return $get_part; // Возвращаем get-параметры (без знака вопроса)
 } else {
	return false;
 }
}
/*
* @since 1.0.0
* Записывает текст ошибки, чтобы потом можно было отправить в отчет
*/
function xfgmc_errors_log($message) {
 if (is_multisite()) {
	update_blog_option(get_current_blog_id(), 'xfgmc_errors', $message);
 } else {
	update_option('xfgmc_errors', $message);
 }
}
/*
* @since 1.0.0
* Возвращает версию Woocommerce
*/ 
function xfgmc_get_woo_version_number() {
 // If get_plugins() isn't available, require it
 if (!function_exists('get_plugins')) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php');
 }
 // Create the plugins folder and file variables
 $plugin_folder = get_plugins('/' . 'woocommerce');
 $plugin_file = 'woocommerce.php';
	
 // If the plugin version number is set, return it 
 if (isset( $plugin_folder[$plugin_file]['Version'] ) ) {
	return $plugin_folder[$plugin_file]['Version'];
 } else {	
	return NULL;
 }
}
/*
* @since 1.0.0
* Возвращает дерево таксономий, обернутое в <option></option>
*/
function xfgmc_cat_tree($TermName='', $termID, $value_arr, $separator='', $parent_shown=true) {
 /* 
 * $value_arr - массив id отмеченных ранее select-ов
 */
 $result = '';
 $args = 'hierarchical=1&taxonomy='.$TermName.'&hide_empty=0&orderby=id&parent=';
 if ($parent_shown) {
	$term = get_term($termID , $TermName); 
	$selected = '';
	if (!empty($value_arr)) {
		foreach ($value_arr as $value) {		
			if ($value == $term->term_id) {
	   			$selected = 'selected'; break;
	 		}
		}
	}
	// $result = $separator.$term->name.'('.$term->term_id.')<br/>';
	$result = '<option title="'.$term->name.'; ID: '.$term->term_id.'; '. __('products', 'xfgmc'). ': '.$term->count.'" class="hover" value="'.$term->term_id.'" '.$selected .'>'.$separator.$term->name.'</option>';		
	$parent_shown = false;
 }
 $separator .= '-';  
 $terms = get_terms($TermName, $args . $termID);
 if (count($terms) > 0) {
	foreach ($terms as $term) {
	$selected = '';
	if (!empty($value_arr)) {
		foreach ($value_arr as $value) {
			if ($value == $term->term_id) {
				$selected = 'selected'; break;
			}
		}
	}
	$result .= '<option title="'.$term->name.'; ID: '.$term->term_id.'; '. __('products', 'xfgmc'). ': '.$term->count.'" class="hover" value="'.$term->term_id.'" '.$selected .'>'.$separator.$term->name.'</option>';
	// $result .=  $separator.$term->name.'('.$term->term_id.')<br/>';
	$result .= xfgmc_cat_tree($TermName, $term->term_id, $value_arr, $separator, $parent_shown);
	}
 }
 return $result; 
}
/*
* @since 2.0.0
*
* @param string $optName (require)
* @param string $value (require)
* @param string $n (not require)
*
* @return true/false
* Возвращает то, что может быть результатом add_blog_option, add_option
*/
function xfgmc_optionADD($optName, $value='', $n='') {
 if ($optName == '') {return false;}
 if ($n === '1') {$n='';}
 $optName = $optName.$n;
 if (is_multisite()) { 
	return add_blog_option(get_current_blog_id(), $optName, $value);
 } else {
	return add_option($optName, $value);
 }
}
/*
* @since 2.0.0
*
* @param string $optName (require)
* @param string $value (require)
* @param string $n (not require)
*
* @return true/false
* Возвращает то, что может быть результатом update_blog_option, update_option
*/
function xfgmc_optionUPD($optName, $value='', $n='') {
 if ($optName == '') {return false;}
 if ($n === '1') {$n='';}
 $optName = $optName.$n;
 if (is_multisite()) { 
	return update_blog_option(get_current_blog_id(), $optName, $value);
 } else {
	return update_option($optName, $value);
 }
}
/*
* @since 1.0.0
* @updated in v2.0.0
*
* @param string $optName (require)
* @param string $n (not require)
*
* @return true/false
* Возвращает то, что может быть результатом get_blog_option, get_option
*/
function xfgmc_optionGET($optName, $n='') {
 if ($optName == '') {return false;}
 if ($n === '1') {$n='';}
 $optName = $optName.$n;
 if (is_multisite()) { 
	return get_blog_option(get_current_blog_id(), $optName);
 } else {
	return get_option($optName);
 }
}
/*
* @since 2.0.0
*
* @param string $optName (require)
* @param string $n (not require)
*
* @return true/false
* Возвращает то, что может быть результатом delete_blog_option, delete_option
*/
function xfgmc_optionDEL($optName, $n='') {
 if ($optName == '') {return false;}
 if ($n === '1') {$n='';}   
 $optName = $optName.$n;
 if (is_multisite()) { 
	return delete_blog_option(get_current_blog_id(), $optName);
 } else {
	return delete_option($optName);
 }
}
/*
* @since 1.0.0
* @updated in v2.0.0
*
* @param string $result_xml (require)
* @param string $postId (require)
* @param string $numFeed (not require) (string)
* @param string $ids_in_xml (not require)
*
* @return nothing
* Создает tmp файл-кэш товара
*/
function xfgmc_wf($result_xml, $postId, $numFeed = '1', $ids_in_xml = '') {
 $upload_dir = (object)wp_get_upload_dir();
 $name_dir = $upload_dir->basedir.'/xfgmc/feed'.$numFeed;
 if (!is_dir($name_dir)) {
	error_log('WARNING: Папкт $name_dir ='.$name_dir.' нет; Файл: functions.php; Строка: '.__LINE__, 0);
	if (!mkdir($name_dir)) {
		error_log('ERROR: Создать папку $name_dir ='.$name_dir.' не вышло; Файл: functions.php; Строка: '.__LINE__, 0);
	 }
 }
 if (is_dir($name_dir)) {
	$filename = $name_dir.'/'.$postId.'.tmp';
	$fp = fopen($filename, "w");
	fwrite($fp, $result_xml); // записываем в файл текст
	fclose($fp); // закрываем
	 
	/* C версии 2.0.0 */
	$filename = $name_dir.'/'.$postId.'-in.tmp';
	$fp = fopen($filename, "w");
	fwrite($fp, $ids_in_xml);
	fclose($fp);
	/* end с версии 2.0.0 */
 } else {
	error_log('ERROR: Нет папки xfgmc! $name_dir ='.$name_dir.'; Файл: functions.php; Строка: '.__LINE__, 0);
 }
}
/*
* @since 1.0.0
* @updated in v2.0.0
*
* @param array $id_arr (not require) (string)
* @param string $numFeed (not require) (string)
*
* Функция склейки/сборки
* @return nothing
*/
function xfgmc_gluing($id_arr, $numFeed = '1') {
 /*	
 * $id_arr[$i]['ID'] - ID товара
 * $id_arr[$i]['post_modified_gmt'] - Время обновления карточки товара
 * global $wpdb;
 * $res = $wpdb->get_results("SELECT ID, post_modified_gmt FROM $wpdb->posts WHERE post_type = 'product' AND post_status = 'publish'");	
 */	
 xfgmc_error_log('FEED № '.$numFeed.'; Стартовала xfgmc_gluing; Файл: functions.php; Строка: '.__LINE__, 0);
 if ($numFeed === '1') {$prefFeed = '';} else {$prefFeed = $numFeed;} 
 $upload_dir = (object)wp_get_upload_dir();
 $name_dir = $upload_dir->basedir.'/xfgmc/feed'.$numFeed;
 if (!is_dir($name_dir)) {
	if (!mkdir($name_dir)) {
		error_log('FEED № '.$numFeed.'; Нет папки xfgmc! И создать не вышло! $name_dir ='.$name_dir.'; Файл: functions.php; Строка: '.__LINE__, 0);
	} else {
		error_log('FEED № '.$numFeed.'; Создали папку xfgmc! Файл: functions.php; Строка: '.__LINE__, 0);
   }
 }

 $xfgmc_file_file = urldecode(xfgmc_optionGET('xfgmc_file_file', $numFeed));
 $xfgmc_file_ids_in_xml = urldecode(xfgmc_optionGET('xfgmc_file_ids_in_xml', $numFeed));

 $xfgmc_date_save_set = xfgmc_optionGET('xfgmc_date_save_set', $numFeed);
 clearstatcache(); // очищаем кэш дат файлов
 // $prod_id
 foreach ($id_arr as $product) {
	$filename = $name_dir.'/'.$product['ID'].'.tmp';
	$filenameIn = $name_dir.'/'.$product['ID'].'-in.tmp'; /* с версии 2.0.0 */
	xfgmc_error_log('FEED № '.$numFeed.'; RAM '.round(memory_get_usage()/1024, 1).' Кб. ID товара/файл = '.$product['ID'].'.tmp; Файл: functions.php; Строка: '.__LINE__, 0);
	if (is_file($filename) && is_file($filenameIn)) { // if (file_exists($filename)) {
		$last_upd_file = filemtime($filename); // 1318189167			
		if (($last_upd_file < strtotime($product['post_modified_gmt'])) || ($xfgmc_date_save_set > $last_upd_file)) {
			// Файл кэша обновлен раньше чем время модификации товара
			// или файл обновлен раньше чем время обновления настроек фида
			xfgmc_error_log('FEED № '.$numFeed.'; NOTICE: Файл кэша '.$filename.' обновлен РАНЬШЕ чем время модификации товара или время сохранения настроек фида! Файл: functions.php; Строка: '.__LINE__, 0);	
			$result_xml_unit = xfgmc_unit($product['ID'], $numFeed);
			if (is_array($result_xml_unit)) {
				$result_xml = $result_xml_unit[0];
				$ids_in_xml = $result_xml_unit[1];
			} else {
				$result_xml = $result_xml_unit;
				$ids_in_xml = '';
			}	
			xfgmc_wf($result_xml, $product['ID'], $numFeed, $ids_in_xml);
			file_put_contents($xfgmc_file_file, $result_xml, FILE_APPEND);			
			file_put_contents($xfgmc_file_ids_in_xml, $ids_in_xml, FILE_APPEND);
		} else {
			// Файл кэша обновлен позже чем время модификации товара
			// или файл обновлен позже чем время обновления настроек фида
			xfgmc_error_log('FEED № '.$numFeed.'; NOTICE: Файл кэша '.$filename.' обновлен ПОЗЖЕ чем время модификации товара или время сохранения настроек фида; Файл: functions.php; Строка: '.__LINE__, 0);
			xfgmc_error_log('FEED № '.$numFeed.'; Пристыковываем файл кэша без изменений; Файл: functions.php; Строка: '.__LINE__, 0);
			$result_xml = file_get_contents($filename);
			file_put_contents($xfgmc_file_file, $result_xml, FILE_APPEND);
			$ids_in_xml = file_get_contents($filenameIn);
			file_put_contents($xfgmc_file_ids_in_xml, $ids_in_xml, FILE_APPEND);
		}
	} else { // Файла нет
		xfgmc_error_log('FEED № '.$numFeed.'; NOTICE: Файла кэша товара '.$filename.' ещё нет! Создаем... Файл: functions.php; Строка: '.__LINE__, 0);
		$result_xml_unit = xfgmc_unit($product['ID'], $numFeed);
		if (is_array($result_xml_unit)) {
			$result_xml = $result_xml_unit[0];
			$ids_in_xml = $result_xml_unit[1];
		} else {
			$result_xml = $result_xml_unit;
			$ids_in_xml = '';
		}
		xfgmc_wf($result_xml, $product['ID'], $numFeed, $ids_in_xml);
		xfgmc_error_log('FEED № '.$numFeed.'; Создали! Файл: functions.php; Строка: '.__LINE__, 0);
		file_put_contents($xfgmc_file_file, $result_xml, FILE_APPEND);
		file_put_contents($xfgmc_file_ids_in_xml, $ids_in_xml, FILE_APPEND);
	}
 }
} // end function xfgmc_gluing()
/*
* @since 1.0.0
* @updated in v2.0.0
*
* @param string $numFeed (not require) (string)
*
* @return nothing
* Функция склейки
*/
function xfgmc_onlygluing($numFeed = '1') {
 xfgmc_error_log('FEED № '.$numFeed.'; NOTICE: Стартовала xfgmc_onlygluing; Файл: functions.php; Строка: '.__LINE__, 0); 	
 do_action('xfgmc_before_construct', 'cache');
 $result_xml = xfgmc_feed_header($numFeed);
 /* создаем файл или перезаписываем старый удалив содержимое */
 $result = xfgmc_write_file($result_xml, 'w+', $numFeed);
 if ($result !== true) {
	xfgmc_error_log('FEED № '.$numFeed.'; xfgmc_write_file вернула ошибку! $result ='.$result.'; Файл: functions.php; Строка: '.__LINE__, 0);
 } 

 xfgmc_optionUPD('xfgmc_status_sborki', '-1', $numFeed); 
 $whot_export = xfgmc_optionGET('xfgmc_whot_export', $numFeed);
   
 $result_xml = '';
 $step_export = -1;
 $prod_id_arr = array(); 
	
 if ($whot_export === 'xfgmc_vygruzhat') {
	$args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => $step_export, // сколько выводить товаров
		// 'offset' => $offset,
		'relation' => 'AND',
		'fields'  => 'ids',
		'meta_query' => array(
			array(
				'key' => '_xfgmc_vygruzhat',
				'value' => 'yes'
			)
		)
	);	
 } else { //  if ($whot_export == 'all' || $whot_export == 'simple')
	$args = array(
	   'post_type' => 'product',
	   'post_status' => 'publish',
	   'posts_per_page' => $step_export, // сколько выводить товаров
		// 'offset' => $offset,
	   'relation' => 'AND',
	   'fields'  => 'ids'
	);
 }
   
 $args = apply_filters('xfgmc_query_arg_filter', $args, $numFeed);
 xfgmc_error_log('FEED № '.$numFeed.'; NOTICE: xfgmc_onlygluing до запуска WP_Query RAM '.round(memory_get_usage()/1024, 1) . ' Кб; Файл: functions.php; Строка: '.__LINE__, 0); 
 $featured_query = new WP_Query($args);
 xfgmc_error_log('FEED № '.$numFeed.'; NOTICE: xfgmc_onlygluing после запуска WP_Query RAM '.round(memory_get_usage()/1024, 1) . ' Кб; Файл: functions.php; Строка: '.__LINE__, 0); 
	
 global $wpdb;
 if ($featured_query->have_posts()) { 
 	for ($i = 0; $i < count($featured_query->posts); $i++) {
		/*	
		*	если не юзаем 'fields'  => 'ids'
		*	$prod_id_arr[$i]['ID'] = $featured_query->posts[$i]->ID;
		*	$prod_id_arr[$i]['post_modified_gmt'] = $featured_query->posts[$i]->post_modified_gmt;
		*/
		$curID = $featured_query->posts[$i];
		$prod_id_arr[$i]['ID'] = $curID;
  			$res = $wpdb->get_results("SELECT post_modified_gmt FROM $wpdb->posts WHERE id=$curID", ARRAY_A);
		$prod_id_arr[$i]['post_modified_gmt'] = $res[0]['post_modified_gmt']; 	
		// get_post_modified_time('Y-m-j H:i:s', true, $featured_query->posts[$i]);
	}
 	wp_reset_query(); /* Remember to reset */
 	unset($featured_query); // чутка освободим память
 }
 if (!empty($prod_id_arr)) {
	xfgmc_error_log('FEED № '.$numFeed.'; NOTICE: xfgmc_onlygluing передала управление xfgmc_gluing; Файл: functions.php; Строка: '.__LINE__, 0);
	xfgmc_gluing($prod_id_arr, $numFeed);
 }
	
 // если постов нет, пишем концовку файла
 // $result_xml = "</offers>". PHP_EOL; 
 $result_xml = apply_filters('xfgmc_after_offers_filter', $result_xml);
 $result_xml .= '</channel>'. PHP_EOL.'</rss>';
 /* создаем файл или перезаписываем старый удалив содержимое */
 $result = xfgmc_write_file($result_xml, 'a', $numFeed);
 xfgmc_rename_file($numFeed);	 
 // выставляем статус сборки в "готово"
 $status_sborki = -1;
 if ($result == true) {
	xfgmc_optionGET('xfgmc_status_sborki', $status_sborki, $numFeed);	
	// останавливаем крон сборки
	wp_clear_scheduled_hook('xfgmc_cron_sborki');
	do_action('xfgmc_after_construct', 'cache');
 } else {
	xfgmc_error_log('FEED № '.$numFeed.'; xfgmc_write_file вернула ошибку! Я не смог записать концовку файла... $result ='.$result.'; Файл: functions.php; Строка: '.__LINE__, 0);
	do_action('xfgmc_after_construct', 'false');
 }
} // end function xfgmc_onlygluing()
/*
* @since 1.0.0
*
* @param string $text (require)
* @param string $i (require)
* 
* @return nothing
* Записывает файл логов /wp-content/uploads/xfgmc/xfgmc.log
*/
function xfgmc_error_log($text, $i) {	
 if (xfgmc_KEEPLOGS !== 'on') {return;}
 $upload_dir = (object)wp_get_upload_dir();
 $name_dir = $upload_dir->basedir."/xfgmc";
 // подготовим массив для записи в файл логов
 if (is_array($text)) {$r = xfgmc_array_to_log($text); unset($text); $text = $r;}
 if (is_dir($name_dir)) {
	$filename = $name_dir.'/xfgmc.log';
	file_put_contents($filename, '['.date('Y-m-d H:i:s').'] '.$text.PHP_EOL, FILE_APPEND);		
 } else {
	if (!mkdir($name_dir)) {
		error_log('Нет папки xfgmc! И создать не вышло! $name_dir ='.$name_dir.'; Файл: functions.php; Строка: '.__LINE__, 0);
	} else {
		error_log('Создали папку xfgmc!; Файл: functions.php; Строка: '.__LINE__, 0);
		$filename = $name_dir.'/xfgmc.log';
		file_put_contents($filename, '['.date('Y-m-d H:i:s').'] '.$text.PHP_EOL, FILE_APPEND);
	}
 } 
 return;
}
/*
* @since 1.0.0
* 
* @param string $text (require)
* @param int $i (not require)
* @param string $res (not require)
*
* @return nothing
* Позволяте писать в логи массив /wp-content/uploads/xfgmc/xfgmc.log
*/
function xfgmc_array_to_log($text, $i=0, $res = '') {
 $tab = ''; for ($x = 0; $x<$i; $x++) {$tab = '---'.$tab;}
 if (is_array($text)) { 
  $i++;
  foreach ($text as $key => $value) {
	if (is_array($value)) {	// массив
		$res .= PHP_EOL .$tab."[$key] => (".gettype($value).")";
		$res .= $tab.xfgmc_array_to_log($value, $i);
	} else { // не массив
		$res .= PHP_EOL .$tab."[$key] => (".gettype($value).")". $value;
	}
  }
 } else {
	$res .= PHP_EOL .$tab.$text;
 }
 return $res;
}
/*
* @since 1.0.0
*
* @param string $text (require)
* @param int $charlength (not require) 
*
* @return $text
* Сокращает число символов в описании, чтобы не нарушать лимити Гугла
*/
function xfgmc_max_lim_text($text, $charlength = 5000) {
 if (mb_strlen($text) > $charlength) {
	$charlength = $charlength - 3;		 
	$text = mb_substr($text, 0, $charlength);
	return $text.'...';
 } else {
	return $text;
 }
}
/*
* @since 2.0.0
*
* @param string $numFeed (not require) 
*
* @return nothing
* Создает пустой файл ids_in_xml.tmp или очищает уже имеющийся
*/
function xfgmc_clear_file_ids_in_xml($numFeed = '1') {
 $xfgmc_file_ids_in_xml = urldecode(xfgmc_optionGET('xfgmc_file_ids_in_xml', $numFeed));
 if (!is_file($xfgmc_file_ids_in_xml)) {
	xfgmc_error_log('FEED № '.$numFeed.'; WARNING: Файла c idшниками $xfgmc_file_ids_in_xml = '.$xfgmc_file_ids_in_xml.' нет! Создадим пустой; Файл: function.php; Строка: '.__LINE__, 0);
	$xfgmc_file_ids_in_xml = xfgmc_NAME_DIR .'/feed'.$numFeed.'/ids_in_xml.tmp';		
	$res = file_put_contents($xfgmc_file_ids_in_xml, '');
	if ($res !== false) {
		xfgmc_error_log('FEED № '.$numFeed.'; NOTICE: Файл c idшниками $xfgmc_file_ids_in_xml = '.$xfgmc_file_ids_in_xml.' успешно создан; Файл: function.php; Строка: '.__LINE__, 0);
		xfgmc_optionUPD('xfgmc_file_ids_in_xml', urlencode($xfgmc_file_ids_in_xml), $numFeed);
	} else {
		xfgmc_error_log('FEED № '.$numFeed.'; ERROR: Ошибка создания файла $xfgmc_file_ids_in_xml = '.$xfgmc_file_ids_in_xml.'; Файл: function.php; Строка: '.__LINE__, 0);
	}
 } else {
	xfgmc_error_log('FEED № '.$numFeed.'; NOTICE: Обнуляем файл $xfgmc_file_ids_in_xml = '.$xfgmc_file_ids_in_xml.'; Файл: function.php; Строка: '.__LINE__, 0);
	file_put_contents($xfgmc_file_ids_in_xml, '');
 }
}
/*
* @since 2.0.9
*
* @return nothing
* Обновляет настройки плагина
* Updates plugin settings
*/
function xfgmc_set_new_options() {
	wp_clean_plugins_cache();
	wp_clean_update_cache();
	add_filter('pre_site_transient_update_plugins', '__return_null');
	wp_update_plugins();
	remove_filter('pre_site_transient_update_plugins', '__return_null');
		
	$numFeed = '1'; // (string)
	if (!defined('xfgmc_ALLNUMFEED')) {define('xfgmc_ALLNUMFEED', '3');}
	$allNumFeed = (int)xfgmc_ALLNUMFEED;
	for ($i = 1; $i<$allNumFeed+1; $i++) {
		if (xfgmc_optionGET('xfgmc_brand_post_meta', $numFeed) === false) {xfgmc_optionUPD('xfgmc_brand_post_meta', '', $numFeed);}
		if (xfgmc_optionGET('xfgmc_feed_assignment', $numFeed) === false) {xfgmc_optionUPD('xfgmc_feed_assignment', '', $numFeed);}
		if (xfgmc_optionGET('xfgmc_product_type', $numFeed) === false) {xfgmc_optionUPD('xfgmc_product_type', 'disabled', $numFeed);}
		if (xfgmc_optionGET('xfgmc_product_type_home', $numFeed) === false) {xfgmc_optionUPD('xfgmc_product_type_home', '', $numFeed);}
		if (xfgmc_optionGET('xfgmc_age', $numFeed) === 'off') {xfgmc_optionUPD('xfgmc_age', 'disabled', $numFeed);}
		if (xfgmc_optionGET('xfgmc_age_group_post_meta', $numFeed) === false) {xfgmc_optionUPD('xfgmc_age_group_post_meta', '', $numFeed);}
		if (xfgmc_optionGET('xfgmc_tax_info', $numFeed) === false) {xfgmc_optionUPD('xfgmc_tax_info', 'disabled', $numFeed);}
		if (xfgmc_optionGET('xfgmc_the_content', $numFeed) === false) {xfgmc_optionUPD('xfgmc_the_content', 'enabled', $numFeed);}
		if (xfgmc_optionGET('xfgmc_def_shipping_label', $numFeed) === false) {xfgmc_optionUPD('xfgmc_def_shipping_label', '', $numFeed);}
		if (xfgmc_optionGET('xfgmc_def_min_handling_time', $numFeed) === false) {xfgmc_optionUPD('xfgmc_def_min_handling_time', '', $numFeed);}
		if (xfgmc_optionGET('xfgmc_def_max_handling_time', $numFeed) === false) {xfgmc_optionUPD('xfgmc_def_max_handling_time', '', $numFeed);}
		if (xfgmc_optionGET('xfgmc_behavior_onbackorder', $numFeed) === false) {xfgmc_optionUPD('xfgmc_behavior_onbackorder', 'out_of_stock', $numFeed);}
		if (xfgmc_optionGET('xfgmc_def_shipping_country', $numFeed) === false) {xfgmc_optionUPD('xfgmc_def_shipping_country', '', $numFeed);}
		if (xfgmc_optionGET('xfgmc_def_delivery_area_type', $numFeed) === false) {xfgmc_optionUPD('xfgmc_def_delivery_area_type', 'region', $numFeed);}
		if (xfgmc_optionGET('xfgmc_def_delivery_area_value', $numFeed) === false) {xfgmc_optionUPD('xfgmc_def_delivery_area_value', '', $numFeed);}
		if (xfgmc_optionGET('xfgmc_def_shipping_service', $numFeed) === false) {xfgmc_optionUPD('xfgmc_def_shipping_service', '', $numFeed);}
		if (xfgmc_optionGET('xfgmc_def_shipping_price', $numFeed) === false) {xfgmc_optionUPD('xfgmc_def_shipping_price', '', $numFeed);}
		if (xfgmc_optionGET('xfgmc_var_desc_priority', $numFeed) === false) {xfgmc_optionUPD('xfgmc_var_desc_priority', 'on', $numFeed);}
		if (xfgmc_optionGET('xfgmc_default_currency', $numFeed) === false) {$currencyId_xml = get_woocommerce_currency(); xfgmc_optionUPD('xfgmc_default_currency', $currencyId_xml, $numFeed);}
		if (xfgmc_optionGET('xfgmc_adapt_facebook', $numFeed) === false) {xfgmc_optionUPD('xfgmc_adapt_facebook', 'no', $numFeed);}
		if (xfgmc_optionGET('xfgmc_wooc_currencies', $numFeed) === false) {xfgmc_optionUPD('xfgmc_wooc_currencies', '', $numFeed);}	
		$numFeed++;
	}
	if (defined('xfgmc_VER')) {
		if (is_multisite()) {
			update_blog_option(get_current_blog_id(), 'xfgmc_version', xfgmc_VER);
		} else {
			update_option('xfgmc_version', xfgmc_VER);
		}
	}
}
/*
* @since 2.2.0
*
* @return formatted string
*/
function xfgmc_formatSize($bytes) {
	if ($bytes >= 1073741824) {
		   $bytes = number_format($bytes / 1073741824, 2) . ' GB';
	}
	elseif ($bytes >= 1048576) {
		   $bytes = number_format($bytes / 1048576, 2) . ' MB';
	}
	elseif ($bytes >= 1024) {
	   $bytes = number_format($bytes / 1024, 2) . ' KB';
	}
	elseif ($bytes > 1) {
		$bytes = $bytes . ' байты';
	}
	elseif ($bytes == 1) {
	   $bytes = $bytes . ' байт';
	}
	else {
	   $bytes = '0 байтов';
	}
	return $bytes;
}
/*
* @since 2.2.1
*
* @return formatted string
*/
function xfgmc_product_type($catid, $numFeed = '1', $result = '', $parent_id = false) {
	if ($parent_id === false) {
		$term = get_term($catid, 'product_cat', 'OBJECT');
	} else {
		$term = get_term($parent_id, 'product_cat', 'OBJECT');
	}

	if (is_wp_error($term)) {
		xfgmc_error_log('FEED № '.$numFeed.'; ERROR: get_term для $catid = '.$catid.' вернула wp_error; Файл: function.php; Строка: '.__LINE__, 0);
		$error = $term;
		$err = 'error_key = '. $error->get_error_code().'; ';
		$err .= 'error_message = '. $error->get_error_message().'; '; 
		$err .= 'error_data = '. $error->get_error_data();
		xfgmc_error_log('FEED № '.$numFeed.'; ERROR: $err = '.$err.'; Файл: function.php; Строка: '.__LINE__, 0);
	} else if ($term === null) {
		xfgmc_error_log('FEED № '.$numFeed.'; ERROR: get_term для $catid = '.$catid.' вернула null; Файл: function.php; Строка: '.__LINE__, 0);
	} else {
		if (is_object($term)) {
			if ($term->parent == 0) {
				$xfgmc_product_type_home = xfgmc_optionGET('xfgmc_product_type_home', $numFeed);
				if ($xfgmc_product_type_home == '') {
					if ($result === '') {$result = $term->name;} else {$result = $term->name.' > '.$result;}
				} else {
					if ($result === '') {$result = $xfgmc_product_type_home.' > '.$term->name;} else {$result = $xfgmc_product_type_home.' > '.$term->name.' > '.$result;}
				}
			} else {
				if ($result === '') {
					$result = $term->name; 
					$result = xfgmc_product_type($catid, $numFeed, $result, $term->parent);
				} else {
					$result = $term->name .' > '.$result;
					$result = xfgmc_product_type($catid, $numFeed, $result, $term->parent);
				}
			}
		} 
	}
	return $result;
}
/*
* @since 2.2.11
*
* @return formatted string
*/
function xfgmc_replace_decode($string, $numFeed = '1') {
 $string = str_replace("+", 'xfgmc', $string);
 $string = urldecode($string);
 $string = str_replace("xfgmc", '+', $string);
 return $string;
}
?>
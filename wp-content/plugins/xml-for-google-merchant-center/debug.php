<?php if (!defined('ABSPATH')) {exit;}
function xfgmc_debug_page() { 
 if (isset($_REQUEST['xfgmc_submit_debug_page'])) {
	if (!empty($_POST) && check_admin_referer('xfgmc_nonce_action','xfgmc_nonce_field')) {
		if (isset($_POST['xfgmc_keeplogs'])) {
			xfgmc_optionUPD('xfgmc_keeplogs', sanitize_text_field($_POST['xfgmc_keeplogs']));
		} else {
			xfgmc_optionUPD('xfgmc_keeplogs', '0');
		}
		if (isset($_POST['xfgmc_disable_notices'])) {
			xfgmc_optionUPD('xfgmc_disable_notices', sanitize_text_field($_POST['xfgmc_disable_notices']));
		} else {
			xfgmc_optionUPD('xfgmc_disable_notices', '0');
		}
		if (isset($_POST['xfgmc_enable_five_min'])) {
			xfgmc_optionUPD('xfgmc_enable_five_min', sanitize_text_field($_POST['xfgmc_enable_five_min']));
		} else {
			xfgmc_optionUPD('xfgmc_enable_five_min', '0');
		}		
	}
 }	
 $xfgmc_keeplogs = xfgmc_optionGET('xfgmc_keeplogs');
 $xfgmc_disable_notices = xfgmc_optionGET('xfgmc_disable_notices');
 $xfgmc_enable_five_min = xfgmc_optionGET('xfgmc_enable_five_min');
 ?>
 <div class="wrap"><h1><?php _e('Debug page', 'xfgmc'); ?> v.<?php echo xfgmc_optionGET('xfgmc_version'); ?></h1>
  <div id="dashboard-widgets-wrap"><div id="dashboard-widgets" class="metabox-holder">
  <div id="postbox-container-1" class="postbox-container"><div class="meta-box-sortables">
     <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">	 
	 <div class="postbox"> <h2 class="hndle"><?php _e('Logs', 'xfgmc'); ?></h2>
	   <div class="inside">
	  
		<p><?php if ($xfgmc_keeplogs === 'on') {echo '<strong>'. __("Log-file here", 'xfgmc').':</strong><br />'. xfgmc_UPLOAD_DIR .'/xfgmc.log';	} ?></p>		
		<table class="form-table"><tbody>
		 <tr>
			<th scope="row"><label for="xfgmc_keeplogs"><?php _e('Keep logs', 'xfgmc'); ?></label><br />
				<input class="button" id="xfgmc_submit_clear_logs" type="submit" name="xfgmc_submit_clear_logs" value="<?php _e('Clear logs', 'xfgmc'); ?>" />
			</th>
			<td class="overalldesc">
				<input type="checkbox" name="xfgmc_keeplogs" id="xfgmc_keeplogs" <?php checked($xfgmc_keeplogs, 'on' ); ?>/><br />
				<span class="description"><?php _e('Do not check this box if you are not a developer', 'xfgmc'); ?>!</span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_disable_notices"><?php _e('Disable notices', 'xfgmc'); ?></label></th>
			<td class="overalldesc">
				<input type="checkbox" name="xfgmc_disable_notices" id="xfgmc_disable_notices" <?php checked($xfgmc_disable_notices, 'on' ); ?>/><br />
				<span class="description"><?php _e('Disable notices about XML-construct', 'xfgmc'); ?>!</span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_enable_five_min"><?php _e('Enable', 'xfgmc'); ?> five_min</label></th>
			<td class="overalldesc">
				<input type="checkbox" name="xfgmc_enable_five_min" id="xfgmc_enable_five_min" <?php checked($xfgmc_enable_five_min, 'on' ); ?>/><br />
				<span class="description"><?php _e('Enable the five minute interval for CRON', 'xfgmc'); ?></span>
			</td>
		 </tr>		 
		 <tr>
			<th scope="row"><label for="button-primary"></label></th>
			<td class="overalldesc"></td>
		 </tr>		 
		 <tr>
			<th scope="row"><label for="button-primary"></label></th>
			<td class="overalldesc"><?php wp_nonce_field('xfgmc_nonce_action', 'xfgmc_nonce_field'); ?><input id="button-primary" class="button-primary" type="submit" name="xfgmc_submit_debug_page" value="<?php _e( 'Save', 'xfgmc'); ?>" /><br />
			<span class="description"><?php _e('Click to save the settings', 'xfgmc'); ?></span></td>
		 </tr>         
        </tbody></table>
       </div>
     </div>
     </form>
	</div></div> 
	<div id="postbox-container-2" class="postbox-container"><div class="meta-box-sortables">
	 <div class="postbox">
	  <h2 class="hndle"><?php _e('Reset plugin settings', 'xfgmc'); ?></h2>
	  <div class="inside">		
		<p><?php _e('Reset plugin settings can be useful in the event of a problem', 'xfgmc'); ?>.</p>
		<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
			<?php wp_nonce_field('xfgmc_nonce_action_reset', 'xfgmc_nonce_field_reset'); ?><input class="button-primary" type="submit" name="xfgmc_submit_reset" value="<?php _e('Reset plugin settings', 'xfgmc'); ?>" />	 
		</form>
	  </div>
	 </div>	
	 <div class="postbox">
	  <h2 class="hndle"><?php _e('Request simulation', 'xfgmc'); ?></h2>
	  <div class="inside">		
		<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
		 <?php $resust_simulated = '';
		 if (isset($_POST['xfgmc_num_feed'])) {$numFeed = sanitize_text_field($_POST['xfgmc_num_feed']);} else {$numFeed = '1';} 
		 if (isset($_POST['xfgmc_simulated_post_id'])) {$xfgmc_simulated_post_id = sanitize_text_field($_POST['xfgmc_simulated_post_id']);} else {$xfgmc_simulated_post_id = '';}
		 if (isset($_REQUEST['xfgmc_submit_simulated'])) {
			if (!empty($_POST) && check_admin_referer('xfgmc_nonce_action_simulated', 'xfgmc_nonce_field_simulated')) {		 
				$postId = (int)$xfgmc_simulated_post_id;
				$simulated_header = xfgmc_feed_header($numFeed);
				$simulated = xfgmc_unit($postId, $numFeed);
				if (is_array($simulated)) {
					$resust_simulated = $simulated_header.$simulated[0];
					$resust_simulated = apply_filters('xfgmc_after_offers_filter', $resust_simulated);
					$resust_simulated .= '</channel>'. PHP_EOL;
					$resust_simulated .= '</rss>'. PHP_EOL;				
				} else {
					$resust_simulated = $simulated_header.$simulated;
					$resust_simulated = apply_filters('xfgmc_after_offers_filter', $resust_simulated);
					$resust_simulated .= '</channel>'. PHP_EOL;
					$resust_simulated .= '</rss>'. PHP_EOL;	
				}
			}
		 } ?>		
		 <table class="form-table"><tbody>
		 <tr>
			<th scope="row"><label for="xfgmc_simulated_post_id">postId</label></th>
			<td class="overalldesc">
				<input type="number" min="1" name="xfgmc_simulated_post_id" value="<?php echo $xfgmc_simulated_post_id; ?>">
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="xfgmc_enable_five_min">numFeed</label></th>
			<td class="overalldesc">
				<select style="width: 100%" name="xfgmc_num_feed" id="xfgmc_num_feed">
					<?php if (is_multisite()) {$cur_blog_id = get_current_blog_id();} else {$cur_blog_id = '0';}		
					$allNumFeed = (int)xfgmc_ALLNUMFEED; $ii = '1';
					for ($i = 1; $i<$allNumFeed+1; $i++) : ?>
					<option value="<?php echo $i; ?>" <?php selected($numFeed, $i); ?>><?php _e('Feed', 'xfgmc'); ?> <?php echo $i; ?>: feed-xml-<?php echo $cur_blog_id; ?>.xml <?php $assignment = xfgmc_optionGET('xfgmc_feed_assignment', $ii); if ($assignment === '') {} else {echo '('.$assignment.')';} ?></option>
					<?php $ii++; endfor; ?>
				</select>
			</td>
		 </tr>			
		 <tr>
			<th scope="row" colspan="2"><textarea rows="16" style="width: 100%;"><?php echo htmlspecialchars($resust_simulated); ?></textarea></th>
		 </tr>			       
         </tbody></table>
		 <?php wp_nonce_field('xfgmc_nonce_action_simulated', 'xfgmc_nonce_field_simulated'); ?><input class="button-primary" type="submit" name="xfgmc_submit_simulated" value="<?php _e('Simulated', 'xfgmc'); ?>" />
		</form>			
	  </div>
	</div>	 	 
	</div></div> 
	<div id="postbox-container-3" class="postbox-container"><div class="meta-box-sortables">
	<div class="postbox">
	  <h2 class="hndle"><?php _e('Possible problems', 'xfgmc'); ?></h2>
	  <div class="inside">	  	
		  <?php
		  	$possibleProblems = ''; $possibleProblemsCount = 0; $conflictWithPlugins = 0; $conflictWithPluginsList = ''; 
			$check_global_attr_count = wc_get_attribute_taxonomies();
			if (count($check_global_attr_count) < 1) {
				$possibleProblemsCount++;
				$possibleProblems .= '<li>'. __('Your site has no global attributes! This may affect the quality of the XML feed. This can also cause difficulties when setting up the plugin', 'xfgmc'). '. <a href="https://icopydoc.ru/global-and-local-attributes-in-woocommerce/?utm_source=xml-for-google-merchant-center&utm_medium=organic&utm_campaign=in-plugin-xml-for-google-merchant-center&utm_content=debug-page&utm_term=no-local-attr">'. __('Please read the recommendations', 'xfgmc'). '</a>.</li>';
			}			
			if (is_plugin_active('snow-storm/snow-storm.php')) {
				$possibleProblemsCount++;
				$conflictWithPlugins++;
				$conflictWithPluginsList .= 'Snow Storm<br/>';
			}
			if (is_plugin_active('email-subscribers/email-subscribers.php')) {
				$possibleProblemsCount++;
				$conflictWithPlugins++;
				$conflictWithPluginsList .= 'Email Subscribers & Newsletters<br/>';
			}
			if (is_plugin_active('saphali-search-castom-filds/saphali-search-castom-filds.php')) {
				$possibleProblemsCount++;
				$conflictWithPlugins++;
				$conflictWithPluginsList .= 'Email Subscribers & Newsletters<br/>';
			}
			if (is_plugin_active('w3-total-cache/w3-total-cache.php')) {
				$possibleProblemsCount++;
				$conflictWithPlugins++;
				$conflictWithPluginsList .= 'W3 Total Cache<br/>';
			}
			if (is_plugin_active('docket-cache/docket-cache.php')) {
				$possibleProblemsCount++;
				$conflictWithPlugins++;
				$conflictWithPluginsList .= 'Docket Cache<br/>';
			}					
			if (class_exists('MPSUM_Updates_Manager')) {
				$possibleProblemsCount++;
				$conflictWithPlugins++;
				$conflictWithPluginsList .= 'Easy Updates Manager<br/>';
			}
			if (class_exists('OS_Disable_WordPress_Updates')) {
				$possibleProblemsCount++;
				$conflictWithPlugins++;
				$conflictWithPluginsList .= 'Disable All WordPress Updates<br/>';
			}
			if ($conflictWithPlugins > 0) {
				$possibleProblemsCount++;
				$possibleProblems .= '<li><p>'. __('Most likely, these plugins negatively affect the operation of', 'xfgmc'). ' XML for Google Merchant Center:</p>'.$conflictWithPluginsList.'<p>'. __('If you are a developer of one of the plugins from the list above, please contact me', 'xfgmc').': <a href="mailto:support@icopydoc.ru">support@icopydoc.ru</a>.</p></li>';
			}
			if ($possibleProblemsCount > 0) {
				echo '<ol>'.$possibleProblems.'</ol>';
			} else {
				echo '<p>'. __('Self-diagnosis functions did not reveal potential problems', 'xfgmc').'.</p>';
			}
			unset($possibleProblems);
			unset($possibleProblemsCount);
			unset($check_global_attr_count); 
			unset($conflictWithPlugins); 
			unset($conflictWithPluginsList); 
		  ?>
	  </div>
     </div>	
	 <div class="postbox">
	  <h2 class="hndle"><?php _e('Sandbox', 'xfgmc'); ?></h2>
	  <div class="inside">	  	
			<?php 		 
				require_once plugin_dir_path(__FILE__).'/sandbox.php';			 
				try {
					xfgmc_run_sandbox();
				} catch (Exception $e) {
					echo 'Exception: ',  $e->getMessage(), "\n";
				}			 				 
			?>
		</div>
     </div>		  
  </div></div>
  <div id="postbox-container-2" class="postbox-container"><div class="meta-box-sortables">
  	<?php do_action('xfgmc_before_support_project'); ?>

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
		 <p><textarea rows="5" cols="40" name="xfgmc_message" placeholder="<?php _e('Enter your text to send me a message (You can write me in Russian or English). I check my email several times a day', 'xfgmc'); ?>"></textarea></p>
		 <?php wp_nonce_field('xfgmc_nonce_action_send_stat', 'xfgmc_nonce_field_send_stat'); ?><input class="button-primary" type="submit" name="xfgmc_submit_send_stat" value="<?php _e('Send data', 'xfgmc'); ?>" />	 
		</form>
	  </div>
	 </div>  
  </div></div>
  </div></div>



 </div>
<?php
} /* end функция страницы debug-а xfgmc_debug_page */
?>
<?php if(! defined('WPINC')) die; ?>

<fieldset>
	<label>
		<input id="where-to-search-sku" type="checkbox" name="premmerce_search_fields[sku]" value="1" <?php checked($data['sku']); ?> >
		<?php _e('Products SKU', 'premmerce-search'); ?>
	</label>

    <br>

	<label>
		<input id="where-to-search-excerpt" type="checkbox" name="premmerce_search_fields[excerpt]" value="1" <?php checked($data['excerpt']); ?> >
		<?php _e('Short description', 'premmerce-search'); ?>
	</label>
</fieldset>

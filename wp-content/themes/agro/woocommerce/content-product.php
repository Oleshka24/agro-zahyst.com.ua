<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}

$id_last_cat = $product->get_category_ids();
$values_atrr = get_the_terms( $product->id, 'pa_virobnik');
$fndFormProduct = carbon_get_theme_option('fnd-form-product');
?>
    <li <?php wc_product_class('', $product); ?>>
<div class="product_item <? print $product->stock_status; ?>" prod_brand="<? echo $values_atrr[0]->name; ?>" prod_category="<? echo get_the_category_by_ID($id_last_cat[0]); ?>" prod_price="<? echo $product->price; ?>">
            <div class="product_image">
                
                <?php if ( $product->is_on_sale() ) : ?>
            	    <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>
            	<?php endif;?>
            	
                <? if ($product->stock_status == 'outofstock') : ?>
                    <span class="flag availability"><? pll_e('Немає в наявності'); ?></span>
                <? endif; ?>
                <a href="<? print get_permalink($product->id);?>">
                    <?
                    $images = wp_get_attachment_image( $product->image_id, 'full' );
                    print $images;
                    ?>
                </a>
                <a onclick="compareProcess(this)" class="compare__btn add_to_cart_button button br_compare_button br_product_<?php echo $product->id; ?> berocket_product_smart_compare <?php
                
                $BeRocket_Compare_Products = BeRocket_Compare_Products::getInstance();
                $products = $BeRocket_Compare_Products->get_all_compare_products();

                foreach ($products as $prod) {
                    if ($prod == $product->id) {
                        echo "br_compare_added";
                        break;
                    }
                }
                ?>" data-id="<?php echo $product->id; ?>" href="<?php echo home_url(); ?>/compare/">
                    <i class="fa fa-square-o"></i>
                    <i class="fa fa-check-square-o compare__count-minus" onclick="compareProcess(this)"></i>
                    <span class="br_compare_button_text">
                        <svg x="0px" y="0px" viewBox="0 0 213.933 213.933" style="enable-background:new 0 0 213.933 213.933;" xml:space="preserve">
                            <path d="M213.416,123.608l-30.872-61.861c0.677-0.875,1.096-1.96,1.096-3.152c0-2.86-2.319-5.179-5.179-5.179h-58.334  c2.509-0.812,4.324-3.164,4.324-5.943v0c0-3.451-2.797-6.248-6.248-6.248h-2.297c3.407-2.662,5.606-6.799,5.606-11.457  c0-8.033-6.512-14.544-14.544-14.544c-8.033,0-14.544,6.512-14.544,14.544c0,4.659,2.199,8.796,5.606,11.457h-2.298  c-3.451,0-6.248,2.797-6.248,6.248v0c0,2.779,1.816,5.131,4.324,5.943H36.065l-0.009-0.018l-0.009,0.018h-0.574  c-2.86,0-5.179,2.319-5.179,5.179c0,1.368,0.541,2.603,1.407,3.529L0.518,124.608c-0.487,0.976-0.613,2.032-0.45,3.033  c-0.017,0.194-0.026,0.392-0.006,0.593c1.756,18.334,17.201,32.671,35.994,32.671s34.239-14.337,35.995-32.671  c0.019-0.202,0.011-0.399-0.006-0.594c0.163-1,0.037-2.056-0.45-3.032l-30.36-60.834h58.748v119.44H51.8  c-5.797,0-10.496,4.699-10.496,10.496c0,2.763,2.24,5.003,5.003,5.003h121.321c2.763,0,5.003-2.24,5.003-5.003  c0-5.797-4.699-10.496-10.496-10.496h-48.183V63.773H172.2l-29.861,59.834c-0.487,0.976-0.613,2.033-0.45,3.033  c-0.017,0.194-0.026,0.391-0.006,0.593c1.756,18.334,17.201,32.671,35.994,32.671c18.794,0,34.239-14.337,35.995-32.671  c0.019-0.202,0.011-0.399-0.006-0.594C214.029,125.64,213.903,124.584,213.416,123.608z M11.625,124.744l24.43-48.953l24.43,48.953  H11.625z M153.447,123.744l24.43-48.953l24.43,48.953H153.447z"/>
                        </svg>
                    </span>
                </a>
            </div>
            <div class="product_title">
                <a href="<? print get_permalink($product->id);?>"><? print $product->name; ?></a>
            </div>
            <?php 
            $rating_count = $product->get_rating_count();
            $review_count = $product->get_review_count();
            $average      = $product->get_average_rating();

            if ( $rating_count > 0 ) : ?>

                <div class="woocommerce-product-rating">
                    <?php echo wc_get_rating_html( $average, $rating_count ); // WPCS: XSS ok. ?>
                </div>

            <?php endif; ?>
            <div class="price">
                <!--<p><? print number_format($product->price, 2, '.', ' '); ?><span class="woocommerce-Price-currencySymbol">&nbsp;<? print get_woocommerce_currency_symbol($currency = get_woocommerce_currency()); ?></span></p>-->
                <p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></p>            
                <?php if ($fndFormProduct) : ?> 
                    <? if (get_locale() == 'uk')  : ?>
                        <button data-fancybox data-src="#fnd-form" class="fnd-link">Знайшли дешевше?</button>
                    <? elseif (get_locale() == 'ru_RU') : ?>
                        <button data-fancybox data-src="#fnd-form" class="fnd-link">Нашли дешевле?</button>
                    <? endif; ?>
                <? endif; ?>
            </div>
            
            <div class="prod-izm">
                <?php $attributes = $product->get_attributes(); ?>
            	<?php foreach ( $attributes as $attribute ) :	?>
            	
            		<?php

                       if ( $attribute['name']=='pa_tarna-odinicja' ) {
            			    $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
            				echo "<span>".apply_filters( 'woocommerce_attribute', wpautop( wc_attribute_label($attribute['name']) . ': ' . wptexturize( implode( ', ', $values ) ) ), $attribute, $values )."</span>";
            			}                        
                        
                       if ( $attribute['name']=='pa_period-vegetacii-dniv' ) {
            			    $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
            				echo "<span>".apply_filters( 'woocommerce_attribute', wpautop( wc_attribute_label($attribute['name']) . ': ' . wptexturize( implode( ', ', $values ) ) ), $attribute, $values )."</span>";
            			}
            			
            			if ( $attribute['name']=='pa_stijkist-do-vovchka' ) {
            			    $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
            				echo "<span>".apply_filters( 'woocommerce_attribute', wpautop( wc_attribute_label($attribute['name']) . ': ' . wptexturize( implode( ', ', $values ) ) ), $attribute, $values )."</span>";
            			}    
            			
            			if ( $attribute['name']=='pa_fao' ) {
            			    $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
            				echo "<span>".apply_filters( 'woocommerce_attribute', wpautop( wc_attribute_label($attribute['name']) . ': ' . wptexturize( implode( ', ', $values ) ) ), $attribute, $values )."</span>";
            			}              			

            			if ( $attribute['name']=='pa_vologoviddacha' ) {
            			    $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
            				echo "<span>".apply_filters( 'woocommerce_attribute', wpautop( wc_attribute_label($attribute['name']) . ': ' . wptexturize( implode( ', ', $values ) ) ), $attribute, $values )."</span>";
            			}                            
            			?>
            	<?php endforeach; ?>
    	    </div>
            
            <? if ($product->stock_status == 'outofstock') : ?>
                <a href="<? print get_permalink($product->id);?>" class="button product_type_simple outofstock_button" rel="nofollow"><svg version="1.1" class="button_more_ico" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 281.488 281.488" style="enable-background:new 0 0 281.488 281.488;" xml:space="preserve"><g><path d="M140.744,0C63.138,0,0,63.138,0,140.744s63.138,140.744,140.744,140.744s140.744-63.138,140.744-140.744S218.351,0,140.744,0z M140.744,263.488C73.063,263.488,18,208.426,18,140.744S73.063,18,140.744,18s122.744,55.063,122.744,122.744S208.425,263.488,140.744,263.488z"/><path d="M163.374,181.765l-16.824,9.849v-71.791c0-3.143-1.64-6.058-4.325-7.69c-2.686-1.632-6.027-1.747-8.818-0.299l-23.981,12.436c-4.413,2.288-6.135,7.72-3.847,12.132c2.289,4.413,7.72,6.136,12.133,3.847l10.838-5.62v72.684c0,3.225,1.726,6.203,4.523,7.808c1.387,0.795,2.932,1.192,4.477,1.192c1.572,0,3.143-0.411,4.546-1.232l30.371-17.778c4.29-2.512,5.732-8.024,3.221-12.314S167.663,179.255,163.374,181.765z"/><circle cx="137.549" cy="86.612" r="12.435"/></g></svg><? pll_e('Детальніше'); ?></a>
            <? else :?>
                <a href="?add-to-cart=<? print $product->id; ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<? print $product->id; ?>" data-product_sku="" rel="nofollow"><svg class="add_to_cart_ico" enable-background="new 0 0 511.343 511.343" height="512" viewBox="0 0 511.343 511.343" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m490.334 106.668h-399.808l-5.943-66.207c-.972-10.827-10.046-19.123-20.916-19.123h-42.667c-11.598 0-21 9.402-21 21s9.402 21 21 21h23.468c12.825 142.882-20.321-226.415 24.153 269.089 1.714 19.394 12.193 40.439 30.245 54.739-32.547 41.564-2.809 102.839 50.134 102.839 43.942 0 74.935-43.826 59.866-85.334h114.936c-15.05 41.455 15.876 85.334 59.866 85.334 35.106 0 63.667-28.561 63.667-63.667s-28.561-63.667-63.667-63.667h-234.526c-15.952 0-29.853-9.624-35.853-23.646l335.608-19.724c9.162-.538 16.914-6.966 19.141-15.87l42.67-170.67c3.308-13.234-6.71-26.093-20.374-26.093zm-341.334 341.337c-11.946 0-21.666-9.72-21.666-21.667s9.72-21.667 21.666-21.667c11.947 0 21.667 9.72 21.667 21.667s-9.72 21.667-21.667 21.667zm234.667 0c-11.947 0-21.667-9.72-21.667-21.667s9.72-21.667 21.667-21.667 21.667 9.72 21.667 21.667-9.72 21.667-21.667 21.667zm47.366-169.726-323.397 19.005-13.34-148.617h369.142z"/></svg><? pll_e('У кошик'); ?></a>
            <? endif; ?>

        </div>
    </li>
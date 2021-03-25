<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
    <?php
    /**
     * Hook: woocommerce_before_single_product_summary.
     *
     * @hooked woocommerce_show_product_sale_flash - 10
     * @hooked woocommerce_show_product_images - 20
     */
    do_action('woocommerce_before_single_product_summary');
    ?>
    <div class="summary entry-summary">
        <?php
        /**
         * Hook: woocommerce_single_product_summary.
         *
         * @hooked woocommerce_template_single_title - 5
         * @hooked woocommerce_template_single_rating - 10
         * @hooked woocommerce_template_single_price - 10
         * @hooked woocommerce_template_single_excerpt - 20
         * @hooked woocommerce_template_single_add_to_cart - 30
         * @hooked woocommerce_template_single_meta - 40
         * @hooked woocommerce_template_single_sharing - 50
         * @hooked WC_Structured_Data::generate_product_data() - 60
         */
        do_action('woocommerce_single_product_summary');
        ?>

        <?
        $dostavka_i_oplata_list = carbon_get_theme_option('dostavka_i_oplata_list'.carbon_lang());
        if (!empty($dostavka_i_oplata_list)) :
            ?>
            <div class="product-bullets">
                <?foreach ($dostavka_i_oplata_list as $item) :
                    $dostavka_icon_id = $item['dostavka_icon'.carbon_lang()];
                    $dostavka_icon = wp_get_attachment_image_url($dostavka_icon_id, 'full');
                    ?>

                <div class="product-bullet">
                    <div class="product-img"><img class="product-bullet-img" src="<? print $dostavka_icon; ?>"></div>
                    <div class="product-title"><h4><?print $item['dostavka_title'.carbon_lang()]; ?></h4></div>
                    <?if(!empty($item['dostavka_link'].carbon_lang())):?>    
                        <div class="product-descr"><? print $item['dostavka_link'.carbon_lang()];?></div>
                    <?endif;?>
                </div>
                <?endforeach;?>
            </div>
        <? endif; ?>
    </div>


    <?php
    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action('woocommerce_after_single_product_summary');
    
    $id_last_cat = $product->get_category_ids();
    $values_atrr = get_the_terms( $product->id, 'pa_virobnik');
    ?>

    <div class="param_gtag">
        <input readonly type="hidden" id="g_id" value="<?php the_ID(); ?>">
        <input readonly type="hidden" id="g_brand" value="<?php echo $values_atrr[0]->name; ?>">
        <input readonly type="hidden" id="g_category" value="<?php echo get_the_category_by_ID($id_last_cat[0]) ?>">
        <input readonly type="hidden" id="g_price" value="<?php echo $product->price; ?>">
    </div>

</div>

<?php do_action('woocommerce_after_single_product'); ?>
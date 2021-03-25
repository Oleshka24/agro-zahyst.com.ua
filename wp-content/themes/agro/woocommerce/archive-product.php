<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
//do_action( 'woocommerce_before_main_content' );

?>
    <header class="woocommerce-products-header ">
        <?
        /**
        * Hook: woocommerce_archive_description.
        *
        * @hooked woocommerce_taxonomy_archive_description - 10
        * @hooked woocommerce_product_archive_description - 10
        */
        do_action('woocommerce_archive_description');
        ?>
        <?php
        $parentid = get_queried_object_id();
        $parentCat = get_queried_object();
        $child = get_term_children($parentid, 'product_cat');
        // if ($parentCat->parent === NULL ) {
        //     echo '<h1> Категории товаров </h1>';
        // } else {
        //     if ($child[0]) {
        //         echo '<h1> Подкатегории </h1>';
        //     }
        // }

        $args = array(
            'parent' => $parentid,
            'hide_empty' => true
        );
        $terms = get_terms('product_cat', $args);
        if ($terms) {
            echo '<ul class="products columns-4">';
            foreach ($terms as $term) { ?>
                <li class="product-category product first">
                    <a href="<? print  esc_url(get_term_link($term)) ?>">
                        <? woocommerce_subcategory_thumbnail($term); ?>
                        <h2 class="woocommerce-loop-category__title"><? print $term->name; ?></h2>
                    </a>
                </li>
                <?
            }
            echo '</ul>';
        }
        ?>

    </header>
<div id="product-catalog"></div>
<?if (!(dynamic_sidebar( 'Content Sidebar' ))):?>
    <div class="active-filters">
        <? dynamic_sidebar( 'Content Sidebar' ); ?>    
    </div>
<?endif;?>

<?php
if (woocommerce_product_loop()) {

    /**
     * Hook: woocommerce_before_shop_loop.
     *
     * @hooked woocommerce_output_all_notices - 10
     * @hooked woocommerce_result_count - 20
     * @hooked woocommerce_catalog_ordering - 30
     */
    do_action('woocommerce_before_shop_loop');

    woocommerce_product_loop_start();

    if (wc_get_loop_prop('total')) {
        while (have_posts()) {
            the_post();

            /**
             * Hook: woocommerce_shop_loop.
             */
            do_action('woocommerce_shop_loop');

            wc_get_template_part('content', 'product');
        }
    }

    woocommerce_product_loop_end();

    /**
     * Hook: woocommerce_after_shop_loop.
     *
     * @hooked woocommerce_pagination - 10
     */
    do_action('woocommerce_after_shop_loop');
} else {
    /**
     * Hook: woocommerce_no_products_found.
     *
     * @hooked wc_no_products_found - 10
     */
    do_action('woocommerce_no_products_found');
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');



$term_id = get_queried_object_id();
$info_block_button = carbon_get_term_meta($term_id,'question_answer_block_button');
$info_block_title = carbon_get_term_meta($term_id,'question_answer_block_title'.carbon_lang());
$info_block = carbon_get_term_meta($term_id,'question_answer_block'.carbon_lang());

if ($info_block_button == 'on') :
    if (!empty($info_block)) : ?>

        <section class="questions page_cat_product" itemprop="mainEntity" itemscope itemtype="https://schema.org/FAQPage">
            <div class="container">
                <div class="title">
                    <h2><? print $info_block_title; ?></h2>
                </div>

                <div class="tabs_wrapper">
                    <div class="tabs_items" id="accordeon">
                        <? foreach ($info_block as $info_item) : ?>
                            <div class="question_block" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                                <div class="tabs_item acc-head">
                                    <div itemprop="name"><? print $info_item['question_answer_title'.carbon_lang()]; ?></div>
                                </div>
                                <div class="acc-body" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                    <div itemprop="text"><? print $info_item['question_answer_text'.carbon_lang()]; ?></div>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>

                </div>

            </div>
        </section>
    <? endif; ?>
<? endif;

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
//do_action( 'woocommerce_sidebar' );

//get_footer( 'shop' );

?>
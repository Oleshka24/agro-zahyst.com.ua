<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper">
		<ul class="tabs wc-tabs" role="tablist">
			<?php foreach ( $product_tabs as $key => $product_tab ) : if ($product_tab["callback"]) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
					<a href="#tab-<?php echo esc_attr( $key ); ?>">
						<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
					</a>
				</li>
			<?php endif; endforeach; ?>
		</ul>
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
				<?php
				if ( isset( $product_tab['callback'] ) ) {
					call_user_func( $product_tab['callback'], $key, $product_tab );
				}
				?>
			</div>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>

<?php endif; ?>

<?
global $post;
$info_block_button = carbon_get_post_meta($post->ID,'question_answer_block_button');
$info_block_title = carbon_get_post_meta($post->ID,'question_answer_block_title'.carbon_lang());
$info_block = carbon_get_post_meta($post->ID,'question_answer_block'.carbon_lang());

?>
<? if ($info_block_button == 'on') :
    if (!empty($info_block)) : ?>

        <section class="questions" itemprop="mainEntity" itemscope itemtype="https://schema.org/FAQPage">
            <div class="container">
                <div class="title">
                    <h2><? print $info_block_title; ?></h2>
                </div>

                <div class="tabs_wrapper">
                    <div class="tabs_items" id="accordeon">
                        <? foreach ($info_block as $info_item) : ?>
                            <div class="question_block" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                                <div class="tabs_item acc-head">
                                    <p itemprop="name"><? print $info_item['question_answer_title'.carbon_lang()]; ?></p>
                                </div>
                                <div class="acc-body" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                    <p itemprop="text"><? print $info_item['question_answer_text'.carbon_lang()]; ?></p>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>

                </div>

            </div>
        </section>
    <? endif; ?>
<? endif; ?>
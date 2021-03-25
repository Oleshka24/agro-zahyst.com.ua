<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$fndFormSingleProduct = carbon_get_theme_option('fnd-form-single-product');
?>
<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?>
<?php if ($fndFormSingleProduct) : ?> 
    <? if (get_locale() == 'uk')  : ?>
        <button data-fancybox data-src="#fnd-form" class="fnd-link">Знайшли дешевше?</button>
    <? elseif (get_locale() == 'ru_RU') : ?>
        <button data-fancybox data-src="#fnd-form" class="fnd-link">Нашли дешевле?</button>
    <? endif; ?>
<? endif; ?>
</p>

<noindex>
    <? if (get_locale() == 'uk')  : ?>
    <span class="promo-text promo-price"><i>*Акційну ціну продовжено до 31.03.2021р. включно. Кількість товару обмежена.</i></span>
    <?else:?>
    <span class="promo-text promo-price"><i>*Акционная цена продлена до 31.03.2021г. включительно! Количество товара ограничено.</i></b></span>
    <?endif;?>
</noindex>    
<?if( $product->is_on_sale() ) :?>
<noindex>
    <? if (get_locale() == 'uk')  : ?>
    <div class="promo-text"><i>При замовленні товару від 5 одиниць <b>доставка БЕЗКОШТОВНО!</b><br/> Подробиці уточнюйте у менеджера! <br/> <b>Акція діє до 31.03.2021р. включно!</i></b></div>
    <?else:?>
    <div class="promo-text"><i>При заказе товара от 5 единиц <b>доставка БЕСПЛАТНО!</b><br/> Подробности уточняйте у менеджера!</br> <b>Акция действует до 31.03.2021г. включительно!</i></b></div>
    <?endif;?>
</noindex>    
<?endif;?>
<?if (get_post_meta(get_the_ID(), '_stock_status', true) == 'outofstock') :?>
<? if (get_locale() == 'uk')  : ?>
    <div class="outofstock">Немає в наявності</div>
<? elseif (get_locale() == 'ru_RU') : ?>
    <div class="outofstock">Нет в наличии</div>
<?endif;?>
<?else:?>
  <? if (get_locale() == 'uk')  : ?>
    <div class="stock">Товар в наявності</div>
<? elseif (get_locale() == 'ru_RU') : ?>
    <div class="stock">В наличии</div>
<?endif;?>
<?endif;?>

<?
/**
 * Вывод атрибутов на странице товара
 */

// Функция вывода атрибута
function productShoes() {
	global $product;
	// Получаем элементы таксономии атрибута shoes
	$attribute_names = get_the_terms($product->get_id(), 'pa_tarna-odinicja');
	$attribute_name = "pa_tarna-odinicja";
	if ($attribute_names) :?>
	<div class="product-izm">
	    <?echo wc_attribute_label($attribute_name);?>: 
		<?foreach ($attribute_names as $attribute_name):?>
		<strong><?	echo $attribute_name->name; ?></strong>
		<?endforeach;?>
	</div>	
	<?endif;?>
<?}
// Определяем место вывода атрибута
add_action('woocommerce_single_product_summary', 'productShoes', 61);
?>
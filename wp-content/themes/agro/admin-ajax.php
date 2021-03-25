<?
require_once('../../../wp-load.php');

$qty = sprintf($woocommerce->cart->cart_contents_count);

$price_product = $woocommerce->cart->total;
if (stristr($price_product, '.')) {
    $price_product = number_format($price_product, 2, '.', ' ');
} else {
    $price_product = number_format($price_product, 0, '.', ' ');
}
echo $price_product . '|' . $qty;




<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>


		<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><svg class="add_to_cart_ico" enable-background="new 0 0 511.343 511.343" height="512" viewBox="0 0 511.343 511.343" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m490.334 106.668h-399.808l-5.943-66.207c-.972-10.827-10.046-19.123-20.916-19.123h-42.667c-11.598 0-21 9.402-21 21s9.402 21 21 21h23.468c12.825 142.882-20.321-226.415 24.153 269.089 1.714 19.394 12.193 40.439 30.245 54.739-32.547 41.564-2.809 102.839 50.134 102.839 43.942 0 74.935-43.826 59.866-85.334h114.936c-15.05 41.455 15.876 85.334 59.866 85.334 35.106 0 63.667-28.561 63.667-63.667s-28.561-63.667-63.667-63.667h-234.526c-15.952 0-29.853-9.624-35.853-23.646l335.608-19.724c9.162-.538 16.914-6.966 19.141-15.87l42.67-170.67c3.308-13.234-6.71-26.093-20.374-26.093zm-341.334 341.337c-11.946 0-21.666-9.72-21.666-21.667s9.72-21.667 21.666-21.667c11.947 0 21.667 9.72 21.667 21.667s-9.72 21.667-21.667 21.667zm234.667 0c-11.947 0-21.667-9.72-21.667-21.667s9.72-21.667 21.667-21.667 21.667 9.72 21.667 21.667-9.72 21.667-21.667 21.667zm47.366-169.726-323.397 19.005-13.34-148.617h369.142z"/></svg><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
        
        
        <? if (get_locale() == 'uk')  : ?>
        <a href="#fast-order" class="single_add_to_cart_button button alt modal">
			<svg  class="add_to_cart_ico add_to_cart_ico--mouse" viewBox="0 0 450.47 450.47" style="enable-background:new 0 0 450.47 450.47;" xml:space="preserve">
				<path d="M237.298,99.533c-0.301-0.34-0.562-0.677-0.916-0.999c-3.937-3.535-4.043-2.491,0.266-6.463   c3.192-2.929,7.063-5.222,10.574-7.755c9.286-6.711,15.398-15.699,19.529-26.356C276.02,34.033,248.707,17.503,235,3.344   c-9.904-10.247-25.496,5.382-15.604,15.604c7.643,7.912,17.489,14.328,24.14,23.123c7.453,9.848-3.901,20.712-11.68,26.194   c-12.026,8.473-22.423,19.727-20.02,31.794c-53.971,5.042-103.87,34.623-103.87,86.767V333.2c0,64.664,52.603,117.27,117.27,117.27   c64.663,0,117.27-52.605,117.27-117.27V186.817C342.51,129.888,289.543,102.317,237.298,99.533z M130.044,186.817   c0-38.707,42.017-61.117,85.535-64.841v135.005c-39.697-1.998-71.928-11.042-85.535-15.457V186.817z M320.433,333.194   c0,52.5-42.705,95.199-95.192,95.199c-52.488,0-95.196-42.699-95.196-95.199V264.73c19.713,5.958,56.817,14.995,100.676,14.995   c28.088,0,58.93-3.759,89.713-14.352V333.194z M320.433,241.896c-27.916,10.675-56.424,14.849-82.78,15.415v-135.66   c42.569,2.553,82.78,22.969,82.78,65.175V241.896z M206.072,133.429v111.973c-17.153,3.027-67.583-11.094-67.583-11.094   C131.049,155.812,160.429,142.005,206.072,133.429z"/>
			</svg>
			<span>Швидке замовлення</span>
		</a>
        <? elseif (get_locale() == 'ru_RU') : ?>
        <a href="#fast-order" class="single_add_to_cart_button button alt modal">
			<svg  class="add_to_cart_ico add_to_cart_ico--mouse" viewBox="0 0 450.47 450.47" style="enable-background:new 0 0 450.47 450.47;" xml:space="preserve">
				<path d="M237.298,99.533c-0.301-0.34-0.562-0.677-0.916-0.999c-3.937-3.535-4.043-2.491,0.266-6.463   c3.192-2.929,7.063-5.222,10.574-7.755c9.286-6.711,15.398-15.699,19.529-26.356C276.02,34.033,248.707,17.503,235,3.344   c-9.904-10.247-25.496,5.382-15.604,15.604c7.643,7.912,17.489,14.328,24.14,23.123c7.453,9.848-3.901,20.712-11.68,26.194   c-12.026,8.473-22.423,19.727-20.02,31.794c-53.971,5.042-103.87,34.623-103.87,86.767V333.2c0,64.664,52.603,117.27,117.27,117.27   c64.663,0,117.27-52.605,117.27-117.27V186.817C342.51,129.888,289.543,102.317,237.298,99.533z M130.044,186.817   c0-38.707,42.017-61.117,85.535-64.841v135.005c-39.697-1.998-71.928-11.042-85.535-15.457V186.817z M320.433,333.194   c0,52.5-42.705,95.199-95.192,95.199c-52.488,0-95.196-42.699-95.196-95.199V264.73c19.713,5.958,56.817,14.995,100.676,14.995   c28.088,0,58.93-3.759,89.713-14.352V333.194z M320.433,241.896c-27.916,10.675-56.424,14.849-82.78,15.415v-135.66   c42.569,2.553,82.78,22.969,82.78,65.175V241.896z M206.072,133.429v111.973c-17.153,3.027-67.583-11.094-67.583-11.094   C131.049,155.812,160.429,142.005,206.072,133.429z"/>
			</svg>
			<span>Быстрый заказ</span>
		</a>
        <? endif; ?>
    
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
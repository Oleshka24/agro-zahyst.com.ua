<?

$advantage_1_title = carbon_get_theme_option('advantage_1_title'.carbon_lang());
$advantage_1_text = carbon_get_theme_option('advantage_1_text'.carbon_lang());

$advantage_2_title = carbon_get_theme_option('advantage_2_title'.carbon_lang());
$advantage_2_text = carbon_get_theme_option('advantage_2_text'.carbon_lang());

$advantage_3_title = carbon_get_theme_option('advantage_3_title'.carbon_lang());
$advantage_3_text = carbon_get_theme_option('advantage_3_text'.carbon_lang());

$advantage_4_title = carbon_get_theme_option('advantage_4_title'.carbon_lang());
$advantage_4_text = carbon_get_theme_option('advantage_4_text'.carbon_lang());

$map_title = carbon_get_theme_option('map_title'.carbon_lang());
$map_image_id = carbon_get_theme_option('map_image');
$map_image = wp_get_attachment_image_url($map_image_id, 'full');

$tpl_dir = get_template_directory();

$fndFormHome = carbon_get_theme_option('fnd-form-home');
?>

<? get_header(); ?>
    <section class="banner">
        <?
        $slider_list = carbon_get_post_meta($post->ID, 'home_page_slider_list');
        if (!empty($slider_list)) : ?>
            <div class="slider">
                
                <div class="wheat-wrap" style="transform: matrix(1, 0, 0, 1, 0, 0);">
                            <div class="wheat1">
                               <img src="<?print get_template_directory_uri();?>/assets/images/wheat1.png"/>
                            </div>
                            <div class="wheat2">
                                <img src="<?print get_template_directory_uri();?>/assets/images/wheat2.png"/>
                            </div>
                </div>
                
                 <div class="clouds-wrap" style="transform: matrix(1, 0, 0, 1, 0, 0);">
                            <div class="cloud1">
                               <img src="<?print get_template_directory_uri();?>/assets/images/sun1.png"/>
                            </div>
                </div>
                
                <div class="slider_list">
                    <? foreach ($slider_list as $slider_item) : ?>
                        <?
                        $slider_image_id = $slider_item['home_page_slider_image'];
                        $slider_image = wp_get_attachment_image_url($slider_image_id, 'full');

                        $slider_title = $slider_item['home_page_slider_title'];
                        $slider_button = $slider_item['home_page_slider_button'];
                        $slider_link = $slider_item['home_page_slider_link'];
                        ?>
                        <div class="slider_item"
                             style="background: url('<? print $slider_image; ?>') no-repeat center; background-size: cover;">
                            <div class="container">
                                <div class="title">
                                    <h2><? print $slider_title; ?></h2>
                                </div>
                                <? if (!empty($slider_link && $slider_button)) : ?>
                                    <div class="button">
                                        <a href="<? print $slider_link; ?>" class="btn"><? print $slider_button; ?></a>
                                    </div>
                                <? endif; ?>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        <? endif; ?>

        <?

        $home_page_categories_list = carbon_get_post_meta($post->ID, 'home_page_categories_list');
        If (!empty($home_page_categories_list)) : ?>
            <div class="categories_list container_flex">
                <? foreach ($home_page_categories_list as $item) :

                    $item_image_id = $item['home_page_category_image'];
                    $item_image = wp_get_attachment_image_url($item_image_id, 'full');
                    ?>
                    <div class="category_item">
                        <a href="<? print $item['home_page_category_link']; ?>" class="fill"></a>
                        <div class="image">
                            <img src="<? print $item_image ?>" alt="">
                        </div>
                        <div class="title">
                            <h2><? print $item['home_page_category_title']; ?></h2>
                        </div>
                    </div>
                <? endforeach; ?>

            </div>
        <? endif; ?>
    </section>
    <section class="advantages">
        <div class="container">
            <div class="advantages_list container_flex">
                <div class="advantage_item">
                    <div class="advantage_icon">
                        <svg version="1.1" class="price" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                             viewBox="0 0 478.502 478.502" style="enable-background:new 0 0 478.502 478.502;"
                             xml:space="preserve">
                        <g>
                            <g>
                                <path d="M360.301,162.1l-65.8-83.2c-11.2-14.1-27.4-23.4-45.2-26V10c0-5.5-4.5-10-10-10s-10,4.5-10,10v42.9
                                    c-17.8,2.5-34,11.8-45.1,26l-66,83.3c-5.7,7.3-8.9,16.3-8.9,25.6v249.9c0.1,22.6,18.5,40.9,41.1,40.8c0.1,0,0.1,0,0.2,0h177.3
                                    c22.6,0.2,41.1-18,41.3-40.6c0-0.1,0-0.1,0-0.2V187.8C369.201,178.5,366.001,169.5,360.301,162.1z M239.301,150.4
                                    c16.1,0,29.1,13,29.1,29.1s-13,29.1-29.1,29.1c-16.1,0-29.1-13-29.1-29.1C210.201,163.5,223.201,150.4,239.301,150.4z
                                     M349.301,437.7c0,11.7-9.6,20.8-21.3,20.8h-177.4c-11.7,0-21.3-9.1-21.3-20.8V187.8c0-4.8,1.6-9.5,4.6-13.2l65.9-83.3
                                    c7.4-9.3,17.8-15.8,29.5-18.1v58.2c-26.6,5.5-43.6,31.5-38.1,58.1s31.5,43.6,58.1,38.1c26.6-5.5,43.6-31.5,38.1-58.1
                                    c-4-19.1-18.9-34.1-38.1-38.1V73.2c4.1,0.8,8.1,2.2,11.9,4c6.8,3.3,12.8,8.1,17.5,14.1l66,83.2c3,3.8,4.6,8.5,4.6,13.3V437.7z"/>
                            </g>
                        </g>
                            <g>
                                <g>
                                    <path d="M271.201,364.7c-4.4-13.9-17.3-23.4-31.9-23.4c-7.4,0-13.4-6-13.4-13.4c0-7.4,6-13.4,13.4-13.4c7.4,0,13.4,6,13.4,13.4
                                    c0,5.5,4.5,10,10,10s10-4.5,10-10c0-14.6-9.5-27.5-23.4-31.9v-4.4c0-5.5-4.5-10-10-10s-10,4.5-10,10v4.4
                                    c-17.6,5.5-27.4,24.3-21.9,41.9c4.4,13.9,17.3,23.4,31.9,23.4c7.4,0,13.4,6,13.4,13.4c0,7.4-6,13.4-13.4,13.4
                                    c-7.4,0-13.4-6-13.4-13.4c0-5.5-4.5-10-10-10s-10,4.5-10,10c0,14.6,9.5,27.5,23.4,31.9v5c0,5.5,4.5,10,10,10s10-4.5,10-10v-5
                                    C266.901,401.1,276.701,382.3,271.201,364.7z"/>
                                </g>
                            </g>

                        </svg>
                    </div>
                    <div class="advantage_title">
                        <h5><? print $advantage_1_title; ?></h5>
                    </div>
                    <div class="advantage_text">
                        <p><? print $advantage_1_text; ?></p>
                    </div>
                </div>
                <div class="advantage_item">
                    <div class="advantage_icon">
                        <svg class="delivery" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" x="0px"
                             y="0px"
                             viewBox="0 0 447.907 447.907"
                             xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M432.703,206.904l-30.5-13.2l-25.9-50.4c-7-13.8-21.2-22.4-36.7-22.3h-44.6v-12.6c0-22.8-18.2-41.4-41-41.4h-213.2
                                        c-22.8,0-40.8,18.7-40.8,41.4v193c-0.2,13.9,10.9,25.3,24.8,25.5c0.1,0,0.2,0,0.4,0h5.3c0,1-0.1,1.4-0.1,2
                                        c-0.1,28.6,23,51.9,51.6,52c28.6,0.1,51.9-23,52-51.6c0-0.2,0-0.3,0-0.5c0-0.7,0-1-0.1-2h172.3c0,1,0,1.4,0,2
                                        c-0.1,28.6,23,51.9,51.6,52c28.6,0.1,51.9-23,52-51.6c0-0.2,0-0.3,0-0.5c0-0.7,0-1,0-2h12.9c13.9,0,25.2-11.3,25.2-25.2
                                        c0-0.1,0-0.2,0-0.4v-71C448.103,220.304,442.103,211.004,432.703,206.904z M82.303,361.004c-17.6,0-31.8-14.2-31.8-31.8
                                        c0-17.6,14.2-31.8,31.8-31.8s31.8,14.2,31.8,31.8C114.103,346.704,99.803,361.004,82.303,361.004z M275.003,307.104h-145.8
                                        c-8.4-18.3-26.8-30-46.9-29.9c-20.2-0.1-38.5,11.5-46.9,29.9h-10.2c-3.1,0-5.2-2.4-5.2-5.5v-51.5h255V307.104z M275.003,108.504
                                        v121.6h-255v-121.6c0-11.7,9.1-21.4,20.8-21.4h213.2c11.7,0.1,21.1,9.7,21,21.3V108.504z M295.003,141.104h44.6
                                        c7.9-0.1,15.3,4.2,19,11.3l20,38.7h-83.6V141.104z M358.103,361.004c-17.6,0-31.8-14.2-31.8-31.8c0-17.6,14.2-31.8,31.8-31.8
                                        s31.8,14.2,31.8,31.8C389.903,346.704,375.703,361.004,358.103,361.004z M428.003,301.604c0,3.1-2.1,5.5-5.2,5.5h-17.8
                                        c-12.1-25.9-42.9-37.1-68.8-25c-11,5.1-19.9,14-25,25h-16.2v-96h98l31.8,14c2,1,3.3,3.2,3.2,5.4V301.604z"/>
                                </g>
                            </g>
                            </svg>
                    </div>
                    <div class="advantage_title">
                        <h5><? print $advantage_2_title; ?></h5>
                    </div>
                    <div class="advantage_text">
                        <p><? print $advantage_2_text; ?></p>
                    </div>
                </div>
                <div class="advantage_item">
                    <div class="advantage_icon">
                        <svg class="guarantee" xmlns="http://www.w3.org/2000/svg" height="512pt" version="1.1"
                             viewBox="-38 0 512 512.00142" width="512pt">
                            <g id="surface1">
                                <path d="M 435.488281 138.917969 L 435.472656 138.519531 C 435.25 133.601562 435.101562 128.398438 435.011719 122.609375 C 434.59375 94.378906 412.152344 71.027344 383.917969 69.449219 C 325.050781 66.164062 279.511719 46.96875 240.601562 9.042969 L 240.269531 8.726562 C 227.578125 -2.910156 208.433594 -2.910156 195.738281 8.726562 L 195.40625 9.042969 C 156.496094 46.96875 110.957031 66.164062 52.089844 69.453125 C 23.859375 71.027344 1.414062 94.378906 0.996094 122.613281 C 0.910156 128.363281 0.757812 133.566406 0.535156 138.519531 L 0.511719 139.445312 C -0.632812 199.472656 -2.054688 274.179688 22.9375 341.988281 C 36.679688 379.277344 57.492188 411.691406 84.792969 438.335938 C 115.886719 468.679688 156.613281 492.769531 205.839844 509.933594 C 207.441406 510.492188 209.105469 510.945312 210.800781 511.285156 C 213.191406 511.761719 215.597656 512 218.003906 512 C 220.410156 512 222.820312 511.761719 225.207031 511.285156 C 226.902344 510.945312 228.578125 510.488281 230.1875 509.925781 C 279.355469 492.730469 320.039062 468.628906 351.105469 438.289062 C 378.394531 411.636719 399.207031 379.214844 412.960938 341.917969 C 438.046875 273.90625 436.628906 199.058594 435.488281 138.917969 Z M 384.773438 331.523438 C 358.414062 402.992188 304.605469 452.074219 220.273438 481.566406 C 219.972656 481.667969 219.652344 481.757812 219.320312 481.824219 C 218.449219 481.996094 217.5625 481.996094 216.679688 481.820312 C 216.351562 481.753906 216.03125 481.667969 215.734375 481.566406 C 131.3125 452.128906 77.46875 403.074219 51.128906 331.601562 C 28.09375 269.097656 29.398438 200.519531 30.550781 140.019531 L 30.558594 139.683594 C 30.792969 134.484375 30.949219 129.039062 31.035156 123.054688 C 31.222656 110.519531 41.207031 100.148438 53.765625 99.449219 C 87.078125 97.589844 116.34375 91.152344 143.234375 79.769531 C 170.089844 68.402344 193.941406 52.378906 216.144531 30.785156 C 217.273438 29.832031 218.738281 29.828125 219.863281 30.785156 C 242.070312 52.378906 265.921875 68.402344 292.773438 79.769531 C 319.664062 91.152344 348.929688 97.589844 382.246094 99.449219 C 394.804688 100.148438 404.789062 110.519531 404.972656 123.058594 C 405.0625 129.074219 405.21875 134.519531 405.453125 139.683594 C 406.601562 200.253906 407.875 268.886719 384.773438 331.523438 Z M 384.773438 331.523438 "
                                      style=" stroke:none;"/>
                                <path d="M 217.996094 128.410156 C 147.636719 128.410156 90.398438 185.652344 90.398438 256.007812 C 90.398438 326.367188 147.636719 383.609375 217.996094 383.609375 C 288.351562 383.609375 345.59375 326.367188 345.59375 256.007812 C 345.59375 185.652344 288.351562 128.410156 217.996094 128.410156 Z M 217.996094 353.5625 C 164.203125 353.5625 120.441406 309.800781 120.441406 256.007812 C 120.441406 202.214844 164.203125 158.453125 217.996094 158.453125 C 271.785156 158.453125 315.546875 202.214844 315.546875 256.007812 C 315.546875 309.800781 271.785156 353.5625 217.996094 353.5625 Z M 217.996094 353.5625 "
                                      style=" stroke:none;"/>
                                <path d="M 254.667969 216.394531 L 195.402344 275.660156 L 179.316406 259.574219 C 173.449219 253.707031 163.9375 253.707031 158.070312 259.574219 C 152.207031 265.441406 152.207031 274.953125 158.070312 280.816406 L 184.78125 307.527344 C 187.714844 310.460938 191.558594 311.925781 195.402344 311.925781 C 199.246094 311.925781 203.089844 310.460938 206.023438 307.527344 L 275.914062 237.636719 C 281.777344 231.769531 281.777344 222.257812 275.914062 216.394531 C 270.046875 210.523438 260.535156 210.523438 254.667969 216.394531 Z M 254.667969 216.394531 "
                                      style=" stroke:none;"/>
                            </g>
                        </svg>
                    </div>
                    <div class="advantage_title">
                        <h5><? print $advantage_3_title; ?></h5>
                    </div>
                    <div class="advantage_text">
                        <p><? print $advantage_3_text; ?></p>
                    </div>
                </div>
                <div class="advantage_item">
                    <div class="advantage_icon">
                        <svg class="chat" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" x="0px"
                             y="0px"
                             viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;"
                             xml:space="preserve">
                            <g>
                                <g>
                                    <g>
                                        <path d="M468.53,306.575c-4.14-10.239-15.798-15.188-26.038-11.046c-10.241,4.14-15.187,15.797-11.047,26.038L455,379.833
                                            l-69.958-30.839c-5.064-2.232-10.827-2.267-15.917-0.095c-23.908,10.201-49.52,15.373-76.124,15.373
                                            c-107.073,0-179-83.835-179-162.136c0-89.402,80.299-162.136,179-162.136s179,72.734,179,162.136
                                            c0,6.975-0.65,15.327-1.781,22.913c-1.63,10.925,5.905,21.102,16.83,22.732c10.926,1.634,21.103-5.905,22.732-16.83
                                            c1.431-9.59,2.219-19.824,2.219-28.815c0-54.33-23.006-105.308-64.783-143.543C405.936,20.809,351.167,0,293.001,0
                                            S180.067,20.809,138.784,58.592c-37.332,34.168-59.66,78.516-63.991,126.335C27.836,216.023,0.001,265.852,0.001,319.525
                                            c0,33.528,10.563,65.34,30.67,92.717L1.459,484.504c-3.051,7.546-1.224,16.189,4.621,21.855
                                            c3.809,3.694,8.828,5.642,13.925,5.642c2.723-0.001,5.469-0.556,8.063-1.7l84.229-37.13c21.188,7.887,43.585,11.88,66.703,11.88
                                            c0.5,0,0.991-0.039,1.482-0.075c33.437-0.253,65.944-9.048,94.098-25.507c25.218-14.744,45.962-34.998,60.505-58.917
                                            c14.199-2.55,28.077-6.402,41.547-11.551l107.301,47.3c2.595,1.143,5.34,1.7,8.063,1.7c5.097-0.001,10.117-1.949,13.926-5.642
                                            c5.845-5.666,7.672-14.308,4.621-21.855L468.53,306.575z M179.002,445c-0.273,0-0.539,0.03-0.81,0.041
                                            c-20.422-0.104-40.078-4.118-58.435-11.95c-5.089-2.173-10.852-2.138-15.916,0.095l-46.837,20.646l15.109-37.375
                                            c2.793-6.909,1.512-14.799-3.322-20.47c-18.835-22.097-28.79-48.536-28.79-76.462c0-31.961,13.445-62.244,36.969-85.206
                                            c7.324,39.925,27.989,78.117,59.162,108.119c38.791,37.333,90.101,58.961,145.506,61.565
                                            C255.626,429.608,218.402,445,179.002,445z"/>
                                        <circle cx="292.001" cy="203" r="20"/>
                                        <circle cx="372.001" cy="203" r="20"/>
                                        <circle cx="212.001" cy="203" r="20"/>
                                    </g>
                                </g>
                            </g>
                            </svg>
                    </div>
                    <div class="advantage_title">
                        <h5><? print $advantage_4_title; ?></h5>
                    </div>
                    <div class="advantage_text">
                        <p><? print $advantage_4_text; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="map">
        <div class="container">
            <div class="map_wrap container_flex">
                <div class="map_description">
                    <div class="title">
                        <h2><? print $map_title; ?></h2>
                    </div>
                    <? $legend_list = carbon_get_theme_option('legend_list'.carbon_lang());
                    if (!empty($legend_list)) : ?>
                        <div class="legend">
                            <div class="legend_list">
                                <? foreach ($legend_list as $legend_item) : ?>
                                    <div class="legend_item">
                                        <div class="icon"
                                             style="background-color: <? print $legend_item['legend_color'.carbon_lang()] ?>"></div>
                                        <div class="text">
                                            <p><span> - </span><? print $legend_item['legend_text'.carbon_lang()] ?></p>
                                        </div>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        </div>
                    <? endif; ?>
                </div>
                <div class="map_image">
                    <img src="<? print $map_image; ?>" alt="map">
                </div>
            </div>
        </div>
    </section>
<?
$args = array(
    'post_type' => 'product',
    'meta_key' => 'total_sales',
    'orderby' => 'meta_value_num',
    'posts_per_page' => 4,
);

$products = wc_get_products($args);

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
    <section class="products top_sales">
        <div class="container">
            <div class="title">
                <h2><? pll_e('Топ продаж'); ?></h2>
            </div>
            <div class="products_wrap">
                <div class="products_list container_flex">
                    <? foreach ($products

                                as $product) : ?>

                        <div class="product_item <? print $product->stock_status; ?>">
                            <div class="product_image">
                                <? if ($product->stock_status == 'outofstock') : ?>
                                    <span class="flag availability"><? pll_e('Немає в наявності'); ?></span>
                                <? endif; ?>
                                <a href="<? print get_permalink($product->id); ?>">
                                    <?php if ( $product->is_on_sale() ) : ?>
                                        <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>
                                    <?php endif; ?>
                                    <?
                                    $images = wp_get_attachment_image($product->image_id, 'full');
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
                                <a href="<? print get_permalink($product->id); ?>"><? print $product->name; ?></a>
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
                                <p>
                                <? if($product->price < $product->regular_price ){?>
                                <del>
                                    <? print number_format($product->regular_price, 2, '.', ' '); ?>
                                    <span class="woocommerce-Price-currencySymbol">
                                        <? print get_woocommerce_currency_symbol($currency = get_woocommerce_currency()); ?>
                                    </span>
                                </del>
                                <?}?>
                                <ins <? if ($product->price < $product->regular_price) { echo 'class="scale_price"'; }?>>
                                    <? print number_format($product->price, 2, '.', ' '); ?>
                                    <span class="woocommerce-Price-currencySymbol">
                                        <? print get_woocommerce_currency_symbol($currency = get_woocommerce_currency()); ?>
                                    </span>
                                </ins>
                                </p>
                                <?php if ($fndFormHome) : ?> 
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
                                        echo "<span>".apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values )."</span>";
                                    }
                                    ?>
                                <?php endforeach; ?>
                            </div>

                            <? if ($product->stock_status == 'outofstock') : ?>
                                <div class="button button_more woocommerce">
                                    <a href="<? print get_permalink($product->id); ?>"
                                       class="btn button outofstock_button"><svg version="1.1" class="button_more_ico" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 281.488 281.488" style="enable-background:new 0 0 281.488 281.488;" xml:space="preserve"><g><path d="M140.744,0C63.138,0,0,63.138,0,140.744s63.138,140.744,140.744,140.744s140.744-63.138,140.744-140.744S218.351,0,140.744,0z M140.744,263.488C73.063,263.488,18,208.426,18,140.744S73.063,18,140.744,18s122.744,55.063,122.744,122.744S208.425,263.488,140.744,263.488z"/><path d="M163.374,181.765l-16.824,9.849v-71.791c0-3.143-1.64-6.058-4.325-7.69c-2.686-1.632-6.027-1.747-8.818-0.299l-23.981,12.436c-4.413,2.288-6.135,7.72-3.847,12.132c2.289,4.413,7.72,6.136,12.133,3.847l10.838-5.62v72.684c0,3.225,1.726,6.203,4.523,7.808c1.387,0.795,2.932,1.192,4.477,1.192c1.572,0,3.143-0.411,4.546-1.232l30.371-17.778c4.29-2.512,5.732-8.024,3.221-12.314S167.663,179.255,163.374,181.765z"/><circle cx="137.549" cy="86.612" r="12.435"/></g></svg><? pll_e('Детальніше'); ?></a>
                                </div>
                            <? else : ?>
                                <div class="button button_more woocommerce">
                                    <a href="?add-to-cart=<? print $product->id; ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<? print $product->id; ?>" data-product_sku="" rel="nofollow"><svg class="add_to_cart_ico" enable-background="new 0 0 511.343 511.343" height="512" viewBox="0 0 511.343 511.343" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m490.334 106.668h-399.808l-5.943-66.207c-.972-10.827-10.046-19.123-20.916-19.123h-42.667c-11.598 0-21 9.402-21 21s9.402 21 21 21h23.468c12.825 142.882-20.321-226.415 24.153 269.089 1.714 19.394 12.193 40.439 30.245 54.739-32.547 41.564-2.809 102.839 50.134 102.839 43.942 0 74.935-43.826 59.866-85.334h114.936c-15.05 41.455 15.876 85.334 59.866 85.334 35.106 0 63.667-28.561 63.667-63.667s-28.561-63.667-63.667-63.667h-234.526c-15.952 0-29.853-9.624-35.853-23.646l335.608-19.724c9.162-.538 16.914-6.966 19.141-15.87l42.67-170.67c3.308-13.234-6.71-26.093-20.374-26.093zm-341.334 341.337c-11.946 0-21.666-9.72-21.666-21.667s9.72-21.667 21.666-21.667c11.947 0 21.667 9.72 21.667 21.667s-9.72 21.667-21.667 21.667zm234.667 0c-11.947 0-21.667-9.72-21.667-21.667s9.72-21.667 21.667-21.667 21.667 9.72 21.667 21.667-9.72 21.667-21.667 21.667zm47.366-169.726-323.397 19.005-13.34-148.617h369.142z"/></svg><? pll_e('У кошик'); ?></a>
                                </div>
                            <? endif; ?>
                        </div>
                    <? endforeach; ?>

                </div>
            </div>
        </div>
    </section>

<?
$args = array(
    'post_type' => 'product',
    'posts_per_page' => 4,
);

$products_2 = wc_get_products($args);

?>
    <section class="products latest">
        <div class="container">
            <div class="title">
                <h2><? pll_e('Останні надходження')?></h2>
            </div>
            <div class="products_wrap">
                <div class="products_list container_flex">
                    <? foreach ($products_2 as $product) : ?>
                        <div class="product_item <? print $product->stock_status; ?>">
                            <div class="product_image">
                                <? if ($product->stock_status == 'outofstock') : ?>
                                    <span class="flag availability"><? pll_e('Немає в наявності'); ?></span>
                                <? endif; ?>
                                <a href="<? print get_permalink($product->id); ?>">
                                    <?php if ( $product->is_on_sale() ) : ?>
                                        <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>
                                    <?php endif; ?>
                                    <?
                                    $images = wp_get_attachment_image($product->image_id, 'full');
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
                                <a href="<? print get_permalink($product->id); ?>"><? print $product->name; ?></a>
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
                                <p>
                                    <? if($product->price < $product->regular_price ){?>
                                        <del>
                                            <? print number_format($product->regular_price, 2, '.', ' '); ?>
                                            <span class="woocommerce-Price-currencySymbol">
                                        <? print get_woocommerce_currency_symbol($currency = get_woocommerce_currency()); ?>
                                    </span>
                                        </del>
                                    <?}?>
                                    <ins <? if ($product->price < $product->regular_price) { echo 'class="scale_price"'; }?>>
                                        <? print number_format($product->price, 2, '.', ' '); ?>
                                        <span class="woocommerce-Price-currencySymbol">
                                        <? print get_woocommerce_currency_symbol($currency = get_woocommerce_currency()); ?>
                                    </span>
                                    </ins>
                                </p>
                                <?php if ($fndFormHome) : ?> 
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
                                        echo "<span>".apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values )."</span>";
                                    }
                                    ?>
                                <?php endforeach; ?>
                            </div>

                            <? if ($product->stock_status == 'outofstock') : ?>
                                <div class="button button_more woocommerce">
                                    <a href="<? print get_permalink($product->id); ?>"
                                       class="btn button outofstock_button"><svg version="1.1" class="button_more_ico" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 281.488 281.488" style="enable-background:new 0 0 281.488 281.488;" xml:space="preserve"><g><path d="M140.744,0C63.138,0,0,63.138,0,140.744s63.138,140.744,140.744,140.744s140.744-63.138,140.744-140.744S218.351,0,140.744,0z M140.744,263.488C73.063,263.488,18,208.426,18,140.744S73.063,18,140.744,18s122.744,55.063,122.744,122.744S208.425,263.488,140.744,263.488z"/><path d="M163.374,181.765l-16.824,9.849v-71.791c0-3.143-1.64-6.058-4.325-7.69c-2.686-1.632-6.027-1.747-8.818-0.299l-23.981,12.436c-4.413,2.288-6.135,7.72-3.847,12.132c2.289,4.413,7.72,6.136,12.133,3.847l10.838-5.62v72.684c0,3.225,1.726,6.203,4.523,7.808c1.387,0.795,2.932,1.192,4.477,1.192c1.572,0,3.143-0.411,4.546-1.232l30.371-17.778c4.29-2.512,5.732-8.024,3.221-12.314S167.663,179.255,163.374,181.765z"/><circle cx="137.549" cy="86.612" r="12.435"/></g></svg><? pll_e('Детальніше'); ?></a>
                                </div>
                            <? else : ?>
                                <div class="button button_more woocommerce">
                                    <a href="?add-to-cart=<? print $product->id; ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<? print $product->id; ?>" data-product_sku="" rel="nofollow"><svg class="add_to_cart_ico" enable-background="new 0 0 511.343 511.343" height="512" viewBox="0 0 511.343 511.343" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m490.334 106.668h-399.808l-5.943-66.207c-.972-10.827-10.046-19.123-20.916-19.123h-42.667c-11.598 0-21 9.402-21 21s9.402 21 21 21h23.468c12.825 142.882-20.321-226.415 24.153 269.089 1.714 19.394 12.193 40.439 30.245 54.739-32.547 41.564-2.809 102.839 50.134 102.839 43.942 0 74.935-43.826 59.866-85.334h114.936c-15.05 41.455 15.876 85.334 59.866 85.334 35.106 0 63.667-28.561 63.667-63.667s-28.561-63.667-63.667-63.667h-234.526c-15.952 0-29.853-9.624-35.853-23.646l335.608-19.724c9.162-.538 16.914-6.966 19.141-15.87l42.67-170.67c3.308-13.234-6.71-26.093-20.374-26.093zm-341.334 341.337c-11.946 0-21.666-9.72-21.666-21.667s9.72-21.667 21.666-21.667c11.947 0 21.667 9.72 21.667 21.667s-9.72 21.667-21.667 21.667zm234.667 0c-11.947 0-21.667-9.72-21.667-21.667s9.72-21.667 21.667-21.667 21.667 9.72 21.667 21.667-9.72 21.667-21.667 21.667zm47.366-169.726-323.397 19.005-13.34-148.617h369.142z"/></svg><? pll_e('У кошик'); ?></a>
                                </div>
                            <? endif; ?>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </section>


<?
$info_block_button = carbon_get_theme_option('info_block_button');
$info_block_title = carbon_get_theme_option('info_block_title'.carbon_lang());
$info_block = carbon_get_theme_option('info_block'.carbon_lang());
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
                                    <p itemprop="name"><? print $info_item['info_title'.carbon_lang()]; ?></p>
                                </div>
                                <div class="acc-body" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                    <div itemprop="text"><? print $info_item['info_text'.carbon_lang()]; ?></div>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>

                </div>

            </div>
        </section>
    <? endif; ?>
<? endif; ?>

<?
$partners_block_button = carbon_get_theme_option('partners_block_button');
$partners_block_title = carbon_get_theme_option('partners_block_title'.carbon_lang());
$partners_block = carbon_get_theme_option('partners_block');
?>
<? if ($partners_block_button == 'on') :
    if (!empty($partners_block)) : ?>
        <section class="partners">
            <div class="container">
                <div class="title">
                    <h2><? print $partners_block_title; ?></h2>
                </div>
                <div class="partners_list container_flex">
                    <? foreach ($partners_block as $partner) :
                        $partner_image_id = $partner['partner_image'];
                        $partner_image = wp_get_attachment_image_url($partner_image_id, 'full');
                        ?>
                        <div class="partner_item">
                            <div class="icon">
                                <img src="<? print $partner_image; ?>" alt="">
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </section>
    <? endif; ?>
<? endif; ?>
<? get_footer(); ?>
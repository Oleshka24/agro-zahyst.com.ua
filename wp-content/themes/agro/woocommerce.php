<?php
/*
 Single Post Template: Single-page
 Description: This part is optional, but helpful for describing the Post Template
 */
?>

<? get_header(); ?>

    <section class="breadcrumbs_wrapper">
        <div class="container">
            <?php
            if (is_singular('product') === false)   : ?>
                <div class="title">
                    <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
                </div>
            <? endif; ?>

            <div class="breadcrumbs">
                <div class="breadcrumb-container">
                    <ul class="breadcrumb">
                        <?php
                        if (function_exists('yoast_breadcrumb')) {
                            yoast_breadcrumb('<div class="kama_breadcrumbs" id="breadcrumbs">', '</div>');
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="section">
        <div class="policesection">
            <div class="container">
            <?php if (is_singular('product') === false)   : ?>
                <div class="sidebar">
                    <div class="close_button mobile">
                        <a href="#" class="close_btn">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                 viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;"
                                 xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717
                                        L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859
                                        c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287
                                        l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285
                                        L284.286,256.002z"/>
                                </g>
                            </g>
                            </svg>
                        </a>
                    </div>
                    <div class="filter_wrapper">
                        <?php
                        if (function_exists('dynamic_sidebar'))
                            dynamic_sidebar('filter');
                        ?>
                    </div>
                </div>
                <div class="category_filter mobile">
                    <a href="#" class="filter_button">Фильтр</a>
                    <svg enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512"
                         xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path d="m497 365h-10v-283.596c0-20.073-16.331-36.404-36.404-36.404h-389.192c-20.073 0-36.404 16.331-36.404 36.404v283.596h-10c-8.284 0-15 6.716-15 15 0 47.972 39.028 87 87 87h338c47.972 0 87-39.028 87-87 0-8.284-6.716-15-15-15zm-442-283.596c0-3.531 2.873-6.404 6.404-6.404h389.191c3.531 0 6.404 2.873 6.404 6.404v283.596h-401.999zm370 355.596h-338c-26.241 0-48.397-17.823-54.998-42h447.995c-6.601 24.177-28.756 42-54.997 42z"/>
                            <path d="m151 199.469v-76.469c0-8.284-6.716-15-15-15s-15 6.716-15 15v76.469c-18.58 6.276-32 23.86-32 44.531s13.42 38.255 32 44.531v28.469c0 8.284 6.716 15 15 15s15-6.716 15-15v-28.469c18.58-6.276 32-23.86 32-44.531s-13.42-38.255-32-44.531zm-15 61.531c-9.374 0-17-7.626-17-17s7.626-17 17-17 17 7.626 17 17-7.626 17-17 17z"/>
                            <path d="m271 151.469v-28.469c0-8.284-6.716-15-15-15s-15 6.716-15 15v28.469c-18.58 6.276-32 23.86-32 44.531s13.42 38.255 32 44.531v76.469c0 8.284 6.716 15 15 15s15-6.716 15-15v-76.469c18.58-6.276 32-23.86 32-44.531s-13.42-38.255-32-44.531zm-15 61.531c-9.374 0-17-7.626-17-17s7.626-17 17-17 17 7.626 17 17-7.626 17-17 17z"/>
                            <path d="m391 199.469v-76.469c0-8.284-6.716-15-15-15s-15 6.716-15 15v76.469c-18.58 6.276-32 23.86-32 44.531s13.42 38.255 32 44.531v28.469c0 8.284 6.716 15 15 15s15-6.716 15-15v-28.469c18.58-6.276 32-23.86 32-44.531s-13.42-38.255-32-44.531zm-15 61.531c-9.374 0-17-7.626-17-17s7.626-17 17-17 17 7.626 17 17-7.626 17-17 17z"/>
                        </g>
                    </svg>
                </div>
            <?endif;?>    
                <div class="content category_list">
                    <div class="sitetext">
                        <?php
                        if (is_singular('product')) {
                            woocommerce_content();
                        } else {
                            woocommerce_get_template('archive-product.php');
                        } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

<? get_footer(); ?>
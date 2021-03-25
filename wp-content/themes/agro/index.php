<? get_header(); ?>
<?
$post_type = get_post_type();
?>

<? if (is_front_page()) { ?>

    <? get_template_part('template-parts/front-page', get_post_type()); ?>

<? } elseif (have_posts() && $post_type == 'product') {

    // Load posts loop.
    while (have_posts()) {
        the_post();
        get_template_part('template-parts/woocommerce');
    }

} else {
    get_template_part('template-parts/page-start', get_post_type());
} ?>
<? get_footer(); ?>
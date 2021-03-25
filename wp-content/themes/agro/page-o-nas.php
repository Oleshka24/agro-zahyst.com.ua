
<?php
/*
Template Name: O-nas
Template post type: page
*/
?>

<?get_header();?>
<?
$o_nas_background_id = carbon_get_post_meta($post->ID,'o_nas_background');
$o_nas_background = wp_get_attachment_image_url($o_nas_background_id, 'full');
?>
    <main class="info_page o_nas">
        <section class="banner" <? if (!empty($o_nas_background) ) : ?>style="background: url('<? print $o_nas_background; ?>') fixed no-repeat center; background-size: cover; <? endif; ?>">
            <div class="container">
                <div class="title">
                    <h1><? the_title(); ?></h1>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container">
                <? the_post();
                the_content(); ?>
            </div>
        </section>
    </main>
<?get_footer();?>
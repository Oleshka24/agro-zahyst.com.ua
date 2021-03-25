<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

?>
<section class="breadcrumbs_wrapper">
    <div class="container">
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
<div class="entry_content">
    <div class="container">

        <?php
        the_content(
            sprintf(
                wp_kses(
                /* translators: %s: Post title. Only visible to screen readers. */
                    __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'agro'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            )
        );

        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . __('Pages:', 'agro'),
                'after' => '</div>',
            )
        );
        ?>
    </div>
</div><!-- .entry-content -->
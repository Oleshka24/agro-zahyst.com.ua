<?php
/*
 Single Post Template: Single-page
 Description: This part is optional, but helpful for describing the Post Template
 */
?>
<section class="breadcrumbs_wrapper">
    <div class="container">
        <div class="title">
            <h1><? the_title(); ?></h1>
        </div>
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
            <div class="police">
                <div class="sitetext">
                    <? echo do_shortcode( $post->post_content ); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
/*
Template Name: Dostavka i Oplata
Template post type: page
*/
?>

<?get_header();?>

    <main class="info_page dostavka">
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
        <section class="content">
            <div class="container">
                <? the_post();
                the_content(); ?>
            </div>
        </section>
    </main>
<?get_footer();?>
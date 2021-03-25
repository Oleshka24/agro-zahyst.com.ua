<?php
/**
 * Search results are contained within a div.searchwp-live-search-results
 * which you can style accordingly as you would any other element on your site
 *
 * Some base styles are output in wp_footer that do nothing but position the
 * results container and apply a default transition, you can disable that by
 * adding the following to your theme's functions.php:
 *
 * add_filter( 'searchwp_live_search_base_styles', '__return_false' );
 *
 * There is a separate stylesheet that is also enqueued that applies the default
 * results theme (the visual styles) but you can disable that too by adding
 * the following to your theme's functions.php:
 *
 * wp_dequeue_style( 'searchwp-live-search' );
 *
 * You can use ~/searchwp-live-search/assets/styles/style.css as a guide to customize
 */
?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php $post_type = get_post_type_object( get_post_type() ); ?>
		<div class="searchwp-live-search-result" role="option" id="" aria-selected="false">
			<p><a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php the_title(); ?> &raquo;
			</a></p>
		</div>
	<?php endwhile; ?>
<?php else : ?>
	<p class="searchwp-live-search-no-results" role="option">
		<em class="searchwp-live-search-no-results--ua"><?php esc_html_e( 'Не знайдено товарів. Можливо у запиті є помилка. Натисніть Enter або спробуйте її виправити!', 'swplas' ); ?></em>
		<em class="searchwp-live-search-no-results--ru"><?php esc_html_e( 'Не найдено товаров. Возможно в запросе есть ошибка. Нажмите Enter или попробуйте её исправить!', 'swplas' ); ?></em>
	</p>
	<script>
	    var window_width = $( window ).width();
	    console.log(window_width);
	    if(window_width<=850) {
	        $('.search-holder.mobile .search-btn').trigger('click');
	    }
	    else {
	        $('.search-holder .search_form .search-btn').trigger('click');    
	    }
	</script>
	<script>
		document.querySelector(`
			html[lang = "ru_RU"] .searchwp-live-search-no-results--ua,
			html[lang = "uk"] .searchwp-live-search-no-results--ru
			`).remove();
	</script>
<?php endif; ?>

<!--<?php if ( have_posts() ) : ?>-->
<!--	<?php while ( have_posts() ) : the_post(); ?>-->
<!--		<?php $post_type = get_post_type_object( get_post_type() ); ?>-->
<!--		<div class="searchwp-live-search-result" role="option" id="" aria-selected="false">-->
<!--			<p><a href="<?php echo esc_url( get_permalink() ); ?>">-->
<!--				<?php the_title(); ?> &raquo;-->
<!--			</a></p>-->
<!--		</div>-->
<!--	<?php endwhile; ?>-->
<!--<?php else : ?>-->
<!--	<p class="searchwp-live-search-no-results" role="option">-->
<!--		<em><?php esc_html_e( 'No results found.', 'swplas' ); ?></em>-->
<!--	</p>-->
<!--<?php endif; ?>-->
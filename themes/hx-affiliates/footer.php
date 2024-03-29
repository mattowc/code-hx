<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Harvest Exchange
 * @since Harvest Exchange 1.0
 */
?>

	</div><!-- .container -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'hx_affiliates_credits' ); ?>
			<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'hx_affiliates' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'hx_affiliates' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'hx_affiliates' ), 'hx_affiliates', '<a href="http://onewebcentric.com" rel="designer">Jonathon McDonald</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>
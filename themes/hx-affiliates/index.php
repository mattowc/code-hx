<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Harvest Exchange
 * @since Harvest Exchange 1.0
 */

get_header(); ?>
<?php get_header(); ?>
<div class="container">
<div class="row">
	<div class="span6 offset3">
		<div id="signup-box">
			<?php if ( have_posts() ) : ?>
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<div id="signup-header">
						<h3><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'hx_affiliates' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					</div>
					<div id="signup-body">
						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'hx_affiliates' ) ); ?>
					</div> <!-- #signup-body -->
				</div> <!-- #signup-box -->
				<?php endwhile; ?>

			<?php elseif ( current_user_can( 'edit_posts' ) ) : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>
	</div> <!-- .span6 -->
</div> <!-- .row -->

<?php get_footer(); ?>
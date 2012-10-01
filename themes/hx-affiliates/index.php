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

				<?php hx_affiliates_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php hx_affiliates_content_nav( 'nav-below' ); ?>

			<?php elseif ( current_user_can( 'edit_posts' ) ) : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>
			<div id="signup-header">
				<h3>Important text here</h3>
				<h2>We connect you with farmers who are close to you.  This means you get healthy, organic food at a low cost. </h2>
			</div>
			<div id="signup-body">
				<p>Being healthy is important.  Supporting your community is important.  Do both by signing up to be notified when we launch.  </p>

				<form class="form-inline form-space" action="affiliate-area" method="post">
					<input class="input" type="text" name="email" placeholder="Email" />
					<input class="btn btn-primary" type="submit" name="affiliates-registration-submit" value="Sign up" />
					<?php 
					$nonce              = 'affiliates-registration-nonce';
		$nonce_action       = 'affiliates-registration';
					wp_nonce_field( $nonce_action, $nonce, true, false ); ?>
				</form>
			</div> <!-- #signup-body -->
		</div> <!-- #signup-box -->
	</div> <!-- .span6 -->
</div> <!-- .row -->

<?php get_footer(); ?>
		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php hx_affiliates_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php hx_affiliates_content_nav( 'nav-below' ); ?>

			<?php elseif ( current_user_can( 'edit_posts' ) ) : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
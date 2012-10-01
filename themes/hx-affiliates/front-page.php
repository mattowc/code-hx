<?php get_header(); ?>
<div class="container">
<div class="row">
	<div class="span6 offset3">
		<div id="signup-box">
			<div id="signup-header">
				<h3>Important text here</h3>
				<h2>We connect you with farmers who are close to you.  This means you get healthy, organic food at a low cost. </h2>
			</div>
			<div id="signup-body">
				<p>Being healthy is important.  Supporting your community is important.  Do both by signing up to be notified when we launch.  </p>

				<form class="form-inline form-space" action="test-form" method="post">
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
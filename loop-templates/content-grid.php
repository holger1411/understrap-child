<?php
/**
 * Partial template to display latest posts (home.php) as grid.
 *
 * @package understrap
 */

$col = 4;
?>


	<div class="col-md-2 col-xl-2 article-card">


		<div class="card card-inverse ">
		<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<?php $alt = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true ); ?>
				<img class="card-img "
				     src="<?php echo esc_html( get_the_post_thumbnail_url( $post->ID, 'grid-image' ) ) ?>" alt="<?php echo esc_html( $alt ); ?>">

				<div class="card-img-overlay">

					<header class="entry-header">
<!-- 						<h4 class="card-title"><?php the_title(); ?></h4> -->

						<?php if ( 'post' === get_post_type() ) : ?>

							
						<?php endif; ?>

					</header>

				</div>

			</article>

			</a>
		</div>


	</div>


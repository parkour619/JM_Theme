<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _s
 */

get_header();
?>


<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

while (have_posts()):
	the_post();
	?>

	<?php if (apply_filters('hello_elementor_page_title', true)): ?>

		<div class="hero-single-page-section">
			<header class="page-header">
				<div class="sc-single-hero-inner">
					<div class="single-post-category"><?php the_category(', '); ?></div>
					<?php the_title('<h1 class="single-post-title">', '</h1>'); ?>
					<div class="post-properties">
						<span class="post-author single-author">
							<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
								<?php echo get_avatar(get_the_author_meta('ID'), 25); ?>by
							</a>
							<?php the_author_posts_link(); ?>
						</span>
						<span class="published-date single-post-date">
							<i class="fa fa-calendar" aria-hidden="true"></i>
							<?php echo get_the_date(); ?>
						</span>
						<span class="rating-single">
							<?php
							$rating = get_post_meta(get_the_ID(), '_page_rating', true); // Retrieve rating value
							if ($rating) {
								echo '<p>Post Rating: ' . esc_html($rating) . '/5</p>';
							}
							?>
						</span>
					</div>
				</div>
			</header>
		</div>
	<?php endif; ?>

	<main id="content" <?php post_class('site-main'); ?>>
		<div class="main-content-single-post">

			<div class="page-post-content">
				<div class="mobile-thumbnail">
					<?php if (has_post_thumbnail()): ?>
						<?php the_post_thumbnail('large'); ?>
					<?php endif; ?>
				</div>
				<div class="sc_single-post-inner-content"><?php the_content(); ?></div>
				<div>
					<?php
					if (is_single() && has_action('faq_single_post_content')):

						echo '<div class="faq-accordion">'; ?>
						<?php display_faq_accordion();
						echo '</div>';
					endif;
					?>
				</div>
				<div class="share-buttons">
					<h3 class="article-share related-heading">Share this article:</h3>
					<a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
						target="_blank" rel="noopener noreferrer">
						<span class="icon-box"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></span>
					</a>
					<a href="https://www.linkedin.com/shareArticle?url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>"
						target="_blank" rel="noopener noreferrer">
						<span class="icon-box"><i class="fa-brands fa-linkedin"></i></span>
					</a>
					<a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode(wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full')); ?>&description=<?php echo urlencode(get_the_title()); ?>"
						target="_blank" rel="noopener noreferrer">
						<span class="icon-box"><i class="fa-brands fa-pinterest"></i></span>
					</a>
					<a href="whatsapp://send?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>"
						target="_blank" rel="noopener noreferrer">
						<span class="icon-box"><i class="fa-brands fa-whatsapp"></i></span>
					</a>
					<a href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_permalink()); ?>"
						rel="noopener noreferrer">
						<span class="icon-box"><i class="fa fa-envelope"></i></span>
					</a>
					<span class="icon-box"><i class="fa fa-link copy-url-button"></i></span>
				</div>

				<div class="sc-single-author-detail">

					<div class="sc-single-author-thumbnail">
						<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
							<?php echo get_avatar(get_the_author_meta('ID'), 25); ?>
						</a>

					</div>

					<div class="sc-single-author-description">
						<div class="sc-single-author-namerole">

							<?php the_author_posts_link(); ?> <br>
							<span class="sc-single-author-role">
								<?php
								$author_id = get_post_field('post_author', get_the_ID());


								?>
							</span>
						</div>

					</div>

				</div>

				<?php wp_link_pages(); ?>
			</div>


		</div>

		<div class="post-navigation">
			<?php
			$prev_post = get_previous_post();
			if (!empty($prev_post)):
				$prev_post_id = $prev_post->ID;
				?>

				<div class="prev-post">
					<?php if (has_post_thumbnail($prev_post_id)): ?>
						<a href="<?php echo esc_url(get_permalink($prev_post_id)); ?>" rel="prev">
							<?php echo get_the_post_thumbnail($prev_post_id, array(100, 100)); ?>
						</a>
					<?php endif; ?>
					<a href="<?php echo esc_url(get_permalink($prev_post_id)); ?>" rel="prev">
						<span class="prev-text">PREV. POST</span><br><span
							class="nav-post-title"><?php echo get_the_title($prev_post_id); ?></span>
					</a>
				</div>

			<?php endif; ?>

			<?php
			$next_post = get_next_post();
			if (!empty($next_post)):
				$next_post_id = $next_post->ID;
				?>
				<div class="next-post">
					<?php if (has_post_thumbnail($next_post_id)): ?>
						<a href="<?php echo esc_url(get_permalink($next_post_id)); ?>" rel="next">
							<?php echo get_the_post_thumbnail($next_post_id, array(100, 100)); ?>
						</a>
					<?php endif; ?>
					<a href="<?php echo esc_url(get_permalink($next_post_id)); ?>" rel="next">
						<span class="prev-text">NEXT POST</span><br><span
							class="nav-post-title"><?php echo get_the_title($next_post_id); ?></span>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<div class="related-posts-section">
			<h2 class="related-heading">You might also like</h2>
			<?php if (function_exists('custom_category_section_shortcode')) {
				echo '<div class="related-posts">';
				echo do_shortcode('[custom_category_section max="3" records_row="3"]');
				echo '</div>';
			} ?>
		</div>

	</main>

	<?php
endwhile;

get_footer();
?>
<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */

get_header();
?>

<div id="primary" class="content-area">
	<header class="category-background">
		<div class="sc-archive-hero-section">


		</div>
	</header>
	<main id="content" class="site-main category-position">
		<div class="post-design-sec custom-post-per-row-3">

			<?php
			if (have_posts()):
				while (have_posts()):
					the_post(); ?>

					<div class="sc-custom-post-item">
						<div class="sc-custom-post-item-container">

							<div class="post-thumbnail">
								<?php if (has_post_thumbnail()): ?>
									<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
								<?php endif; ?>
							</div>
							<div class="post-content">

								<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<div class="post-excerpt">
									<?php $excerpt = wp_trim_words(get_the_excerpt(), 30);
									echo $excerpt; ?>
								</div>
								<div class="author-and-date">
									<span class="post-author">
										<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
											<?php echo get_avatar(get_the_author_meta('ID'), 25); ?>by
										</a>
										<?php the_author_posts_link(); ?>
									</span>
									<span class="published-date">
										<i class="fa fa-calendar" aria-hidden="true"></i>
										<?php echo get_the_date(); ?>
									</span>
									<span class="rating">
										<?php
										$rating = get_post_meta(get_the_ID(), '_page_rating', true); // Retrieve rating value
										if ($rating) {
											echo '<p>Post Rating: ' . esc_html($rating) . '/5</p>';
										}
										?>
									</span>
								</div>




							</div>
						</div>
					</div>
				<?php endwhile;
			else: ?>
				<div class="sc-category-no-posts">
					<img src="http://blog.sendcredit.com/wp-content/uploads/2024/03/Group-114980.png"
						alt="no posts display">
					<h2 class="archive-title">''No Posts Found''</h2>
				</div>
			<?php endif; ?>
		</div>

		<?php wp_link_pages(); ?>
	</main>
</div>

<?php
get_footer();

<?php
/**
 * _s functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function _s_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('_s', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', '_s'),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'_s_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', '_s_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _s_content_width()
{
	$GLOBALS['content_width'] = apply_filters('_s_content_width', 640);
}
add_action('after_setup_theme', '_s_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _s_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', '_s'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', '_s'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', '_s_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function _s_scripts()
{
	wp_enqueue_style('_s-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('_s-style', 'rtl', 'replace');

	wp_enqueue_script('_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', '_s_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}


function enqueue_infinite_scroll_script()
{
	wp_enqueue_script('infinite-scroll', get_template_directory_uri() . '/js/infinite-scroll.js', array('jquery'), null, true);
	wp_localize_script('infinite-scroll', 'infinite_scroll_params', array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'current_page' => max(1, get_query_var('paged')),
		'max_page' => $GLOBALS['wp_query']->max_num_pages,
	));
}
add_action('wp_enqueue_scripts', 'enqueue_infinite_scroll_script');

function load_more_posts_ajax()
{
	$paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

	$args = array(
		'post_type' => 'post',
		'posts_per_page' => get_option('posts_per_page'),
		'paged' => $paged,
	);

	$query = new WP_Query($args);

	if ($query->have_posts()):
		while ($query->have_posts()):
			$query->the_post(); ?>
			<div class="sc-custom-post-item">
				<div class="sc-custom-post-item-container">
					<div class="post-thumbnail">
						<?php if (has_post_thumbnail()): ?>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
						<?php endif; ?>
					</div>
					<div class="post-content">
						<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></div>
						<div class="author-and-date">
							<span class="post-author">
								<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
									<?php echo get_avatar(get_the_author_meta('ID'), 25); ?> by
								</a>
								<?php the_author_posts_link(); ?>
							</span>
							<span class="published-date"><i class="fa fa-calendar" aria-hidden="true"></i>
								<?php echo get_the_date(); ?>
							</span>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile;
	endif;

	wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts_ajax');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts_ajax');


function theme_customizer_settings($wp_customize)
{

	$wp_customize->add_section('theme_logo_section', array(
		'title' => __('Logo', 'your-theme'),
		'priority' => 30,
	));

	$wp_customize->add_setting('theme_logo', array(
		'default' => '',
		'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Image_Control(
		$wp_customize,
		'theme_logo',
		array(
			'label' => __('Upload Logo', 'your-theme'),
			'section' => 'theme_logo_section',
			'settings' => 'theme_logo',
		)
	));

	$wp_customize->add_section('theme_font_color_section', array(
		'title' => __('Font Color', 'your-theme'),
		'priority' => 35,
	));

	$wp_customize->add_setting('theme_font_color', array(
		'default' => '#000000',
		'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control(
		$wp_customize,
		'theme_font_color',
		array(
			'label' => __('Font Color', 'your-theme'),
			'section' => 'theme_font_color_section',
			'settings' => 'theme_font_color',
		)
	));
}
add_action('customize_register', 'theme_customizer_settings');

function add_custom_rating_meta_box()
{
	add_meta_box(
		'rating_meta_box',
		'Post Rating',
		'display_rating_meta_box',
		'post',
		'side',
		'high'
	);
}
add_action('add_meta_boxes', 'add_custom_rating_meta_box');

function display_rating_meta_box($post)
{
	$rating = get_post_meta($post->ID, '_page_rating', true); // Get saved rating value
	?>
	<label for="page_rating">Post Rating(1 to 5): </label>
	<input type="number" name="page_rating" id="page_rating" value="<?php echo esc_attr($rating); ?>" min="1" max="5" />
	<?php
}

function save_rating_meta_box($post_id)
{
	if (isset($_POST['page_rating'])) {
		update_post_meta($post_id, '_page_rating', sanitize_text_field($_POST['page_rating']));
	}
}
add_action('save_post', 'save_rating_meta_box');







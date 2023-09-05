<?php
namespace Admission_Sight_Addon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Admission_Blog_Carousel extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'blog-carousel';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Blog Carousel', 'admissionsight-addon' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-code';
	}


	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic', 'admissionsight' ];
	}

	// Load CSS
	// public function get_style_depends() {

	// 	wp_register_style( 'guide-posts', plugins_url( '../assets/css/guide-posts.css', __FILE__ ));

	// 	return [
	// 		'guide-posts',
	// 	];

	// }

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	// public function get_keywords() {
	// 	return [ 'oembed', 'url', 'link' ];
	// }

	/**
	 * Register oEmbed widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'kolegal-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_word_limit',
			[
				'label' => esc_html__( 'Title Word Limit', 'kolegal-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 5,
			]
		);
		$this->add_control(
			'content_limit',
			[
				'label' => esc_html__( 'Content Limit', 'kolegal-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 24,
			]
		);
		$this->add_control(
			'post_count',
			[
				'label' => esc_html__( 'Post Per Page', 'kolegal-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
			'admission_icon',
			[
				'label' => esc_html__( 'Choose Image', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'icon_left',
			[
				'label' => esc_html__( 'Icon Left', 'kolegal-addon' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-arrow-left',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'circle',
						'dot-circle',
						'square-full',
					],
					'fa-regular' => [
						'circle',
						'dot-circle',
						'square-full',
					],
				],
			]
		);

		$this->add_control(
			'icon_right',
			[
				'label' => esc_html__( 'Icon Left', 'kolegal-addon' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'circle',
						'dot-circle',
						'square-full',
					],
					'fa-regular' => [
						'circle',
						'dot-circle',
						'square-full',
					],
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$content_limit = $settings['content_limit'];
		$title_word_limit = $settings['title_word_limit'];
	?>
	
	<div class="blog-carousel">
		<div class="swiper recentPosts">
			<div class="swiper-wrapper">
				<?php

				// The Query
				$args = array(
					'post_type' => 'post',
					'posts_per_page'      => $settings['post_count'],
					'post_status' => 'publish',
					'ignore_sticky_posts' => 1,
					'orderby' => 'date',
					'order'   =>  'DESC',
				);

				$the_query = new \WP_Query( $args );
				// The Loop
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						
						?>
						<article id="post-<?php the_ID();?>" <?php post_class( 'swiper-slide single-blog-item' );?>>
							<a href="<?php the_permalink(  ); ?>" class="d-block post-thumb-wrap">
								<div class="post-thumb" style="background-image: url(<?php  the_post_thumbnail_url('full'); ?>);"></div>
							</a>
							<div class="admission-icon">
								<img src="<?php echo esc_url($settings['admission_icon']['url']); ?>" alt=""> <?php _e('AdmissionSight'); ?>
							</div>
							<div class="post-content">
								<div class="post-inner">
									<a href="<?php the_permalink(  ); ?>" class="d-block"><h2><?php echo wp_trim_words( get_the_title(), $title_word_limit, '' ); ?><?php echo esc_html( '...' ) ?> </h2></a>
									<p><?php echo wp_trim_words( get_the_excerpt(), $content_limit, '...' ); ?></p>
								</div>
								<div class="blog-meta">
									<p><?php echo get_the_date(); ?></p>
								</div>
							</div>
						</article>
						<?php
					}
				}
				wp_reset_postdata();
				?>
			</div>
		</div>
		<div class="swiper-button-next">
			<?php \Elementor\Icons_Manager::render_icon( $settings['icon_right'], [ 'aria-hidden' => 'true' ] ); ?>
		</div>
    	<div class="swiper-button-prev">
			<?php \Elementor\Icons_Manager::render_icon( $settings['icon_left'], [ 'aria-hidden' => 'true' ] ); ?>
		</div>
	</div>

	<?php

	}

}
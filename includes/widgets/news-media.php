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
class Admission_Sight_News_Media extends \Elementor\Widget_Base {

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
		return 'news-media-pro';
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
		return esc_html__( 'News Media', 'admissionsight-addon' );
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
				'label' => esc_html__( 'Content', 'longcov-core-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_count',
			[
				'label' => esc_html__( 'Post Per Page', 'admissionsight-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 9,
			]
		);

		$this->add_control(
			'post_orderby',
			[
				'label' => esc_html__( 'Post Order By', 'admissionsight-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'ID'  => esc_html__( 'ID', 'admissionsight-addon' ),
					'date' => esc_html__( 'Date', 'admissionsight-addon' ),
					'comment_count' => esc_html__( 'Comment Count', 'admissionsight-addon' ),
					'author' => esc_html__( 'Author', 'admissionsight-addon' ),
					'title' => esc_html__( 'Title', 'admissionsight-addon' ),
					'rand' => esc_html__( 'Rand', 'admissionsight-addon' ),
				],
			]
		);

		$this->add_control(
			'post_order',
			[
				'label' => esc_html__( 'Post Order', 'admissionsight-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'ASC'  => esc_html__( 'Ascending', 'admissionsight-addon' ),
					'DESC' => esc_html__( 'Descending', 'admissionsight-addon' ),
				],
			]
		);

		$this->add_control(
			'title_word_limit',
			[
				'label' => esc_html__( 'Title Word Limit', 'admissionsight-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 8,
			]
		);

		$this->add_control(
			'content_limit',
			[
				'label' => esc_html__( 'Content Limit', 'admissionsight-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 15,
			]
		);


		$this->end_controls_section();

		// section_style
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'longcov-core-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
	

	<div class="ricci-blog-section">
	<?php

		

		// The Query
		$args = array(
			'post_type' => 'news-media',
			'posts_per_page'      => $settings['post_count'],
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby' => $settings['post_orderby'],
			'order'   =>  $settings['post_order'],
			'paged' => get_query_var('paged') ? get_query_var('paged') : 1,

		);

		$the_query = new \WP_Query( $args );

		// The Loop
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				
				?>
				<article id="post-<?php the_ID();?>" <?php post_class( 'single-item' );?>>
					<?php if( has_post_thumbnail(  ) ): 
					
					$news_media_url = get_field('news_media_url');
					?>
					<a target="_blank" href="<?php echo esc_url( $news_media_url ); ?>" class="d-block blog-thumb-wrap">
						<div class="blog-thumb" style="background-image: url(<?php  the_post_thumbnail_url('full'); ?>);"></div>
					</a>
					<?php endif; ?>
					<div class="blog-content">
						<a target="_blank" href="<?php echo esc_url( $news_media_url ); ?>" class="d-block"><h2><?php echo wp_trim_words( get_the_title(), $title_word_limit, ); ?></h2></a>
						<p><?php echo wp_trim_words( get_the_content(), $content_limit, '...' ); ?></p>
						<a target="_blank" href="<?php echo esc_url( $news_media_url ); ?>" class="redmore"> <?php echo esc_html__( 'More Info', 'admissionsight-addon' ) ?></a>
					</div>
				</article>
				<?php
			}
		}
		wp_reset_postdata();
	?>
	</div>

	<!-- Pagination -->
	<?php
		echo "<div class='page-nav-container'>" . paginate_links(array(
			'total' => $the_query->max_num_pages,
			'prev_next' => true,
			'prev_text' => __('Prev'),
			'next_text' => __('Next')
		)) . "</div>";

	
	?>

	<?php

	}

}
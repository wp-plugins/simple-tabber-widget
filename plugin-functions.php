<?php
/*
 Plugin Name: Tabber Widget
 Plugin URI: http://wordpress.org/plugins/simple-tabber-widget/
 Description: Wordpress simple and nice tabber widget. This plugin show 3 tabs that "Recent", "Popular" and "Comment".
 Author: Dipto Paul
 Version: 2.0
 Author URI: http://webprojectbd.blogspot.com
*/

// Adding latest jQuery
function simple_tabber_latest_jquery() {

	wp_enqueue_script('jquery');
}
add_action('init', 'simple_tabber_latest_jquery');

// Adding necessary scripts & CSS
function simple_tabber_main_files() {

    wp_enqueue_script( 'simple-tabber-js', plugins_url( '/js/tabber.js', __FILE__ ), array('jquery'));
    wp_enqueue_style( 'simple-tabber-css', plugins_url( '/css/tabber-style.css', __FILE__ ));
}

add_action('wp_head','simple_tabber_main_files');

// Widget Active
function simple_tabber_widget_active() {

	register_widget('Simple_Tabber_Widget');
}
add_action('widgets_init', 'simple_tabber_widget_active');

// Widget Functions
class Simple_Tabber_Widget extends WP_Widget {

	/**
	 * Constructor.
	 *
	 * @since Twenty Fourteen 1.0
	 *
	 * @return Simple_Tabber_Widget
	 */
	public function __construct() {
		parent::__construct( 'simple_tabber_element', __( 'Tabber Widget' ), array(
			'classname'   => 'simple_tabber_element',
			'description' => __( 'Wordpress simple and nice tabber widget.' ),
		) );
	}
	
/**
	 * Output the HTML for this widget.
	 *
	 * @access public
	 * @since Twenty Fourteen 1.0
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme.
	 * @param array $instance An array of settings for this widget instance.
	 */
	public function widget( $args, $instance ) {
		?>
		<div class="simple_tabber_plugin">
			<ul class="simple_tabber_menu">
				<li class="active"><a href="#tabber1">Recent</a></li>
				<li><a href="#tabber2">Popular</a></li>
				<li><a href="#tabber3">Comment</a></li>
			</ul>

			<div class="tabber_content">

				<div id="tabber1" class="single_tabber_content">
					<ul>
					<?php
					//Recent Posts #1st Tab
					$args = array( 'posts_per_page' => 6 );//Show 6 posts
					$recent_posts = wp_get_recent_posts( $args );
					foreach( $recent_posts as $recent ){
					echo '<li class="tabber_list_item"><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
					}
					?>
					</ul>
				</div>

				<div id="tabber2" class="single_tabber_content" style="display:none;">
					<ul>
					<?php
					//Popular Posts in last 30 days #2nd Tab
					function filter_where($where = '') {
					$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
					return $where;
					}
					add_filter('posts_where', 'filter_where');
					query_posts('post_type=post&posts_per_page=6&orderby=comment_count&order=DESC');
					while (have_posts()): the_post(); ?>
					<li class="tabber_list_item"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr('Permalink to %s'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></li>

					<?php
					endwhile;
					wp_reset_query();
					?>
					</ul>
				</div>

				<div id="tabber3" class="single_tabber_content" style="display:none;">
					<ul>
					<?php
					//Popular comment Posts #3rd Tab
					$args = array(
					'posts_per_page' => 6, //Show 6 posts
					'orderby' => 'comment_count',
					'order' => 'DESC'
					);
					?>
					<?php query_posts($args); ?>
					<?php while (have_posts()) : the_post(); ?>
					<li class="tabber_list_item"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
					<?php endwhile;?>
					</ul>
				</div>

			</div>
		</div>			
		<?php	
	}

}



?>
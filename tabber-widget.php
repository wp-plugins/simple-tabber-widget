<?php
/* 
Plugin Name: Tabber Widget
Plugin URI: http://wordpress.org/plugins/simple-tabber-widget/
Description: Wordpress simple and nice tabber widget
Version: 0.1
Author: Dipto Paul
Author URI: http://webprojectbd.blogspot.com
License: GPLv2 or later
*/

//widget create
class WP_TabberWidget extends WP_Widget {

function WP_TabberWidget() {
		$widget_ops = array(
		'classname' => 'WP_TabberWidget',
		'description' => 'Wordpress simple and nice tabber widget'
);
$this->WP_Widget(
		'WP_TabberWidget',
		'Tabber Widget',
		$widget_ops
);
}
function widget($args, $instance) { // widget sidebar output

function wp_tabber() { 

// Enqueue stylesheet and jQuery script

wp_register_style('wp-tabber-style', plugins_url('tabber-style.css', __FILE__));
wp_register_script('wp-tabber-widget-js', plugins_url('tabber.js', __FILE__), array('jquery'));
wp_enqueue_style('wp-tabber-style');
wp_enqueue_script('wp-tabber-widget-js');

// Creating tabs
?>

<ul class="tabs">
	<li class="active"><a href="#tab1">Recent</a></li>
	<li><a href="#tab2">Popular</a></li>
	<li><a href="#tab3">Comment</a></li>
</ul>

<div class="tab_container">

	<div id="tab1" class="tab_content">
		<ul>
		<?php
		//Recent Posts #1st Tab
		$args = array( 'numberposts' => '10' );//Show 10 posts
		$recent_posts = wp_get_recent_posts( $args );
		foreach( $recent_posts as $recent ){
		echo '<li class="list_item_posts"><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
		}
		?>
		</ul>
	</div>

	<div id="tab2" class="tab_content" style="display:none;">
		<ul>
		<?php
		//Popular Posts in last 30 days #2nd Tab
		function filter_where($where = '') {
		$args = array( 'numberposts' => '10' );//Show 10 posts
		$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
		return $where;
		}
		add_filter('posts_where', 'filter_where');
		query_posts('post_type=post&posts_per_page=10&orderby=comment_count&order=DESC');
		while (have_posts()): the_post(); ?>
		<li class="list_item_posts"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr('Permalink to %s'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></li>

		<?php
		endwhile;
		wp_reset_query();
		?>
		</ul>
	</div>

	<div id="tab3" class="tab_content" style="display:none;">
		<ul>
		<?php
		//Popular comment Posts #3rd Tab
		$args = array(
		'posts_per_page' => 10, //Show 10 posts
		'orderby' => 'comment_count',
		'order' => 'DESC'
		);
		?>
		<?php query_posts($args); ?>
		<?php while (have_posts()) : the_post(); ?>
		<li class="list_item_posts"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
		<?php endwhile;?>
		</ul>
	</div>

</div>

<div class="tab-clear"></div>

<?php

}

extract($args, EXTR_SKIP);
// pre-widget code from theme
echo $before_widget; 
$tabs = wp_tabber(); 
// output tabs HTML
echo $tabs; 
// post-widget code from theme
echo $after_widget; 
}
}

// registering and loading widget
add_action(
'widgets_init',
create_function('','return register_widget("WP_TabberWidget");')
);

?>
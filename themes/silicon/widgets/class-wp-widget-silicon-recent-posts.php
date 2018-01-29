<?php
/**
 * Widget API: WP_Widget_Recent_Posts class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 * Core class used to implement a Recent Posts widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class WP_Widget_Silicon_Recent_Posts extends WP_Widget {

	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_recent_entries',
			'description' => __( 'Your site&#8217;s most recent Posts.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'recent-posts', __( 'NOTICIAS RECIENTES' ), $widget_ops );
		$this->alt_option_name = 'widget_recent_entries';
	}

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		
		?>
		<h3 class="si-h3 si-text-purple">
				NOTICIAS RECIENTES
			</h3> <br>
		<?php

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( '' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filters the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r->have_posts()) :
		?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>

		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			
			
			<div class="row">

			<?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
                <div class="col-12">
                    <div class="si-purple si-text-white title-news-front">Noticia <?php $category = get_the_category(); echo $category[0]->cat_name; ?></div>
                    <a href="<?php echo get_permalink($p->ID)  ?>" >
                            <?php
                            if (has_post_thumbnail()): ?>                                    
                                        <div style="height: 15rem; background-position: 50% 50%; background-size:cover; background-image:url('<?php echo get_the_post_thumbnail_url(); ?>')"></div>                                    
                            <?php else: ?>
                                   <div style="height: 15rem; background-position: 50% 50%; background-size:cover; background-image:url('<?php echo trailingslashit( get_template_directory_uri() ) . '/resources/img/no-photo.png' ?>')"></div>
                            <?php endif;

                            ?> 
                            </a>
                    <div class="card-block"  >
                        <h4 class="si-h4 card-title si-text-purple"> <?php get_the_title() ?   the_title()  : the_ID(); ?></h4>
                        <p class="card-text"><?php echo trim_text(get_the_excerpt(), 200); ?>
                        <small class="text-muted si-text-purple si-a"><a href="<?php the_permalink(); ?>"> + Leer más</a></small>
                    </div>
                </div>
            </div>
		<?php endwhile; ?>
		
		<a class="si-text-purple" href="<?php echo home_url(); ?>/noticias">
		<h3 class="si-h3 sidebar-footer">
			VER MÁS +
		</h3>
		</a>

		<?php echo $args['after_widget']; ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;
	}

/*
 *
<div class="card si-light-grey">
    <div class="si-purple si-text-white title-news-front">Noticia Institucional</div>
        <img class="card-img-top" src="<?php echo get_bloginfo('template_url') ?>/resources/img/reunion.png"  alt="Card image cap">
        <div class="card-block"  >
            <h4 class="card-title si-text-purple">LOREM IPSUM DOLOR SIT AMET, CONSECTETUER
                XX/XX/XX
               </h4>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat  quis nostrud evulputate..</p>
        </div>
        <div class="card-footer si-light-grey">
            <small class="text-muted si-text-purple"><a href="#"> + Leer más</a></small>
        </div>
</div>
*/

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
<?php
	}
}

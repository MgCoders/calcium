<?php

/*------------------------------------------*/
/* WPZOOM: Single Page                      */
/*------------------------------------------*/

class Wpzoom_Single_Page extends WP_Widget {

	/* Widget setup. */
	function Wpzoom_Single_Page() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'wpzoom-singlepage', 'description' => __('Custom WPZOOM widget that displays a single specified static page.', 'wpzoom') );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'wpzoom-single-page' );

		/* Create the widget. */
		$this->WP_Widget( 'wpzoom-single-page', __('WPZOOM: Single Page', 'wpzoom'), $widget_ops, $control_ops );
	}

	/* How to display the widget on the screen. */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$page_id = (int) $instance['page_id'];
 		$show_image = $instance['show_image'] == true;
 		$show_content = $instance['show_content'] == true;
        $remove_formatting = $instance['remove_formatting'];


		if ( empty( $page_id ) || $page_id < 1 ) return false;
		$page_data = get_page( $page_id );
		$title = apply_filters( 'widget_title', trim($page_data->post_title), $instance, $this->id_base );
		$link_title = (bool) $instance['link_title'];

		if ( !empty( $page_data->post_content ) ) {
			echo $before_widget;


			/* Title of widget (before and after defined by themes). */
			if ( $title ) {
				echo $before_title;

				if ( $link_title ) echo '<a href="' . esc_url( get_permalink($page_data->ID) ) . '">';
				echo $title;
				if ( $link_title ) echo '</a>';

				echo $after_title;
			}

			$page_excerpt = trim( $page_data->post_excerpt );

 			echo '<div class="featured_page_content">';

  			if ( $show_image ) {

				if ($page_excerpt) {

					echo '<div class="post-video"><div class="video_cover">';

						echo apply_filters( 'the_content', trim($page_data->post_excerpt) );

					echo '</div></div>';

				} else {
					get_the_image( array( 'post_id' => $page_data->ID, 'size' => 'featured-page', 'width' => 580, 'before' => '<div class="post-thumb">', 'after' => '</div>' ) );
				}

			}

			if ( $show_content ) {

				echo '<div class="post-content">';

                    $empty_p_patterns = "/<p[^>]*><\\/p[^>]*>/";

					if ( false !== ( $more_tag_pos = strpos( $page_data->post_content, '<!--more-->' ) ) ) {
                        $content = substr( $page_data->post_content, 0, $more_tag_pos );

                        if ( $remove_formatting ) {
                            $content = force_balance_tags( wp_kses( $content, array( 'p' => array() ) ) );
                            $content = preg_replace( $empty_p_patterns, '', $content );
                        }

                        echo apply_filters( 'the_content', $content);
					} else {
                        $content = $page_data->post_content;

                        if ( $remove_formatting ) {
                            $content = force_balance_tags( wp_kses( $content, array( 'p' => array() ) ) );
                            $content = preg_replace( $empty_p_patterns, '', $content );
                        }

						echo apply_filters( 'the_content', $content);
					}

				echo '</div>';

			}

			echo '</div>';

			echo $after_widget;
		}
	}

		/* Update the widget settings.*/
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			/* Strip tags for title and name to remove HTML (important for text inputs). */
 			$instance['page_id'] = (int) $new_instance['page_id'];
			$instance['link_title'] = $new_instance['link_title'];
 			$instance['show_image'] = $new_instance['show_image'] == 'on';
 			$instance['show_content'] = $new_instance['show_content'] == 'on';
            $instance['remove_formatting'] = $new_instance['remove_formatting'] == 'on';

			return $instance;
		}

		/** Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function when creating your form elements. This handles the confusing stuff. */
		function form( $instance ) {
			/* Set up some default widget settings. */
			$defaults = array( 'page_id' => 0, 'link_title' => true, 'show_image' => true, 'show_content' => true, 'remove_formating' => false );
			$instance = wp_parse_args( (array) $instance, $defaults );

			?><p>
				<label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Page to Display:', 'wpzoom'); ?></label>
				<?php wp_dropdown_pages( array( 'name' => $this->get_field_name('page_id'), 'id' => $this->get_field_id('page_id'), 'selected' => (int) $instance['page_id'] ) ); ?>
			</p>

			<p>
				<label>
					<input class="checkbox" type="checkbox" <?php checked( $instance['show_content'] ); ?> id="<?php echo $this->get_field_id( 'show_content' ); ?>" name="<?php echo $this->get_field_name( 'show_content' ); ?>" />
					<?php _e( 'Display Page Content', 'wpzoom' ); ?>
				</label>
			</p>

			<p class="description">
				<?php _e('You can easily split the content you want to show in the widget by adding the <code>&lt;!--more--&gt;</code> tag.', 'wpzoom'); ?>
			</p>

            <p>
                <label>
                    <input class="checkbox" type="checkbox" <?php checked( $instance['remove_formatting'] ); ?> id="<?php echo $this->get_field_id( 'remove_formatting' ); ?>" name="<?php echo $this->get_field_name( 'remove_formatting' ); ?>" />
                    <?php _e( 'Remove Formatting', 'wpzoom' ); ?>
                </label>
            </p>

			<p>
				<label>
					<input class="checkbox" type="checkbox" <?php checked( $instance['show_image'] ); ?> id="<?php echo $this->get_field_id( 'show_image' ); ?>" name="<?php echo $this->get_field_name( 'show_image' ); ?>" />
					<?php _e( 'Display Image/Video at the Top', 'wpzoom' ); ?>
				</label>
			</p>


			<p class="description">
				<?php _e('To display a video in the widget, make sure to insert the <strong>embed code</strong> in the <strong>Excerpt</strong> field of the selected page.', 'wpzoom'); ?>
			</p>

			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['link_title'], 'on' ); ?> id="<?php echo $this->get_field_id( 'link_title' ); ?>" name="<?php echo $this->get_field_name( 'link_title' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'link_title' ); ?>"><?php _e('Link Page Title to Page', 'wpzoom'); ?></label>
			</p>
			 <?php
		}
}

function wpzoom_register_sp_widget() {
	register_widget('Wpzoom_Single_Page');
}
add_action('widgets_init', 'wpzoom_register_sp_widget');
?>
<?php


/* Registering metaboxes
============================================*/

add_action( 'admin_menu', 'wpzoom_options_box' );

function wpz_farbtastic() {
    global $post_type;
    if ( $post_type == 'slider' ) {
        wp_enqueue_style( 'farbtastic' );
        wp_enqueue_script( 'farbtastic' );
    }
}


function wpzoom_options_box() {

    add_action( 'admin_print_scripts-post-new.php', 'wpz_farbtastic' );
    add_action( 'admin_print_scripts-post.php', 'wpz_farbtastic' );

    add_meta_box( 'wpzoom_top_button', 'Slideshow Options', 'wpzoom_top_button_options', 'slider', 'side', 'high' );
    add_meta_box('wpzoom_post_embed', 'Post Options', 'wpzoom_post_info', 'post', 'side', 'high');


}


function wpz_newpost_head() {
    ?><style type="text/css">
        fieldset.fieldset-show { padding: 0.3em 0.8em 1em; border: 1px solid rgba(0, 0, 0, 0.2); -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; }
        fieldset.fieldset-show p { margin: 0 0 1em; }
        fieldset.fieldset-show p:last-child { margin-bottom: 0; }
    </style><?php
}
add_action('admin_head-post-new.php', 'wpz_newpost_head', 100);
add_action('admin_head-post.php', 'wpz_newpost_head', 100);

/* Slideshow Options
============================================*/
function wpzoom_top_button_options() {
    global $post;

    ?>

    <style>

        .slide_colors li span {
            width: 16px;
            height: 16px;
            float: left;
            margin: 0 5px 0 0;
        }

       .slide_colors li.red span {
           background: #de2b37;
        }

        .slide_colors li.orange span {
           background: #F27242;
        }

        .slide_colors li.green span {
           background: #49BD5E;
        }

        .slide_colors li.blue span {
           background: #2d87cc;
        }
    </style>

    <p>
        <strong><label for="wpzoom_slide_url"><?php _e( 'Slide URL', 'wpzoom' ); ?></label></strong> (<?php _e('optional', 'wpzoom'); ?>)<br/>
        <input type="text" name="wpzoom_slide_url" id="wpzoom_slide_url" class="widefat"
               value="<?php echo esc_url( get_post_meta( $post->ID, 'wpzoom_slide_url', true ) ); ?>"/>
    </p>


    <fieldset class="fieldset-show">
        <legend><strong><?php _e( 'Slide Button', 'wpzoom' ); ?></strong></legend>

        <p>
            <label>
                <strong><?php _e( 'Title', 'wpzoom' ); ?></strong> <?php _e( '(optional)', 'wpzoom' ); ?>
                <input type="text" name="wpzoom_slide_button_title" id="wpzoom_slide_button_title" class="widefat" value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_slide_button_title', true ) ); ?>" />
            </label>
        </p>

        <p>
            <label>
                <strong><?php _e( 'URL', 'wpzoom' ); ?></strong> <?php _e( '(optional)', 'wpzoom' ); ?>
                <input type="text" name="wpzoom_slide_button_url" id="wpzoom_slide_button_url" class="widefat" value="<?php echo esc_url( get_post_meta( $post->ID, 'wpzoom_slide_button_url', true ) ); ?>" />
            </label>
        </p>

        <p>
            <label for="wpzoom_slideshow_color"><strong><?php _e( 'Button Color', 'wpzoom' ); ?></strong> (<?php _e( 'optional', 'wpzoom' ); ?>)</label><br/>
            <input type="text" name="wpzoom_slideshow_color" id="wpzoom_slideshow_color"
                   value="<?php echo '' != ($colrval = trim( get_post_meta( $post->ID, 'wpzoom_slideshow_color', true ) )) ? $colrval : '#de2b37'; ?>"
                   size="7" maxlength="7"/>

            <div id="colorpicker"></div>
            <script type="text/javascript">
                jQuery(function ($) {
                    $('#colorpicker').hide().farbtastic('#wpzoom_slideshow_color');

                    $('#wpzoom_slideshow_color').focus(function () {
                        $('#colorpicker').show('normal');
                    }).blur(function () {
                        $('#colorpicker').hide('normal');
                    });
                });
            </script>

            <strong><?php _e('Predefined colors', 'wpzoom'); ?></strong>
            <ul class="slide_colors">
                <li class="red"><span></span>#de2b37</li>
                <li class="orange"><span></span>#F27242</li>
                <li class="blue"><span></span>#2d87cc</li>
                <li class="green"><span></span>#49BD5E</li>
            </ul>
        </p>

   </fieldset>


<?php
}


function wpzoom_post_info() {
    global $post;

    ?>
    <fieldset>
        <p class="wpz_border" style="border-bottom:none; padding:0;">
            <strong>Embed Video for Carousel Widget </strong> (<em>YouTube, Vimeo, etc.</em>):<br />
            <textarea style="height: 110px; width: 255px;" name="wpzoom_post_embed_code" id="wpzoom_post_embed_code"><?php echo get_post_meta($post->ID, 'wpzoom_post_embed_code', true); ?></textarea>
        </p>

    </fieldset>
    <?php
}




add_action( 'save_post', 'custom_add_save' );

function custom_add_save( $postID ) {

    // called after a post or page is saved
    if ( $parent_id = wp_is_post_revision( $postID ) ) {
        $postID = $parent_id;
    }


    if ( isset( $_POST['save'] ) || isset( $_POST['publish'] ) ) {

        if ( isset( $_POST['wpzoom_slide_url'] ) )
            update_custom_meta( $postID, esc_url_raw( $_POST['wpzoom_slide_url'] ), 'wpzoom_slide_url' );

        if ( isset( $_POST['wpzoom_slide_button_title'] ) )
            update_custom_meta( $postID, $_POST['wpzoom_slide_button_title'] , 'wpzoom_slide_button_title' );

        if ( isset( $_POST['wpzoom_slide_button_url'] ) )
            update_custom_meta( $postID, esc_url_raw( $_POST['wpzoom_slide_button_url'] ), 'wpzoom_slide_button_url' );

        if ( isset( $_POST['wpzoom_slideshow_color'] ) )
            update_custom_meta( $postID, $_POST['wpzoom_slideshow_color'], 'wpzoom_slideshow_color' );

        if (isset($_POST['wpzoom_post_embed_code']))
            update_custom_meta($postID, $_POST['wpzoom_post_embed_code'], 'wpzoom_post_embed_code');

    }
}


function update_custom_meta( $postID, $value, $field ) {
    // To create new meta
    if ( ! get_post_meta( $postID, $field ) ) {
        add_post_meta( $postID, $field, $value );
    } else {
        // or to update existing meta
        update_post_meta( $postID, $field, $value );
    }
}
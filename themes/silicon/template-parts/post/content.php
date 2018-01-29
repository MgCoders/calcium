<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Silicon
 * @since 1.0
 * @version 1.2
 */

?>


<?php if (WP_DEBUG) echo  "I'm content.php<br />"; ?>



<?php if (is_single()) : ?>

<?php if (WP_DEBUG) echo  "I'm content.php where single"; ?>

<!-- Featured image -->
<article>
<div class="row">
    <?php if (has_post_thumbnail( $post->ID ) ): ?>
        <?php $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
            <img class="img-fluid img-featured-post" src="<?php echo $url ?>" />

    <?php endif; ?>
</div>

<div id="news-main-title">
    <div class="row">
        <h2 class="si-h2 si-text-purple main-post-title"> <?php echo isset( $post->post_title ) ? mb_strtoupper($post->post_title) : '' ?></h2>
    </div>
    <div class="row">
        <p class="bold-text"> <?php echo isset( $post->ID ) ? get_the_subtitle($post->ID) : '' ?></p>
    </div>
</div>


	<div class="row justify-text">
		<?php
		the_content( sprintf(
			__( 'Continuar leyendo en <span class="screen-reader-text"> "%s"</span>', 'silicon' ),
			get_the_title()
		) );

		wp_link_pages( array(
			'before'      => '<div class="page-links">' . __( 'Pages:', 'silicon' ),
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		) );
		?>
	</div><!-- .entry-content -->

    <?php silicon_entry_footer(); // metadata information ?>

    <?php else: // I'm not single, I'm married :P ?>

        <?php if (WP_DEBUG) echo  "I'm content.php where NOT single<br />"; ?>

    <?php endif; ?>


	<?php
	if ( is_single() ) { // Is the query for an existing single post?



	}
	?>

</article><!-- #post-## -->
